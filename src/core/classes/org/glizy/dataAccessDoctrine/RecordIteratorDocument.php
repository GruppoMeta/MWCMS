<?php
/**
 * This file is part of the GLIZY framework.
 * Copyright (c) 2005-2012 Daniele Ugoletti <daniele.ugoletti@glizy.com>
 *
 * For the full copyright and license information, please view the COPYRIGHT.txt
 * file that was distributed with this source code.
 */

use Doctrine\DBAL\Types\Type,
    Doctrine\DBAL\Cache\QueryCacheProfile;

class org_glizy_dataAccessDoctrine_RecordIteratorDocument extends org_glizy_dataAccessDoctrine_AbstractRecordIterator
{
    const DOCUMENT_TABLE_ALIAS = 'doc';
    const DOCUMENT_ID = 'document_id';
    const DOCUMENT_TYPE = 'document_type';
    const DOCUMENT_DETAIL_TABLE_ALIAS = 'doc_detail';
    const DOCUMENT_DETAIL_FK_LANGUAGE = 'document_detail_FK_language_id';
    const DOCUMENT_DETAIL_STATUS = 'document_detail_status';
    const DOCUMENT_DETAIL_IS_VISIBLE = 'document_detail_isVisible';
    const DOCUMENT_DETAIL_FK_USER = 'document_detail_FK_user_id';

    const STATUS_PUBLISHED = 'PUBLISHED';
    const STATUS_DRAFT = 'DRAFT';
    const STATUS_OLD = 'OLD';

    protected $conditionNumber;
    protected $indexNumber;
    protected $typeSet;
    protected $statusSet;
    protected $visibilitySet;
    protected $languageSet;
    protected $unionArray;
    protected $unionArrayParams;
    protected $unionOrderBy;
    protected $unionLimit;
    protected $conditionsMap;

    protected function resetQuery()
    {
        parent::resetQuery();
        $this->qb = $this->ar->createQueryBuilder(true, self::DOCUMENT_TABLE_ALIAS, self::DOCUMENT_DETAIL_TABLE_ALIAS);
        $this->qb->select(self::DOCUMENT_TABLE_ALIAS.'.*', self::DOCUMENT_DETAIL_TABLE_ALIAS.'.*');
        $this->conditionNumber = 0;
        $this->indexNumber = 0;
        $this->hasLimit = false;
        $this->hasSelect = true;
        $this->typeSet = false;
        $this->statusSet = false;
        $this->visibilitySet = false;
        $this->languageSet = false;
        $this->unionArray = array();
        $this->unionArrayParams = array();
        $this->unionOrderBy = array();
        $this->unionLimit = array();
        $this->conditionsMap = array();
    }

    protected function processUnionFields($fieldName, $value)
    {
        if (strpos($fieldName, ',') !== false && !$this->ar->fieldExists($fieldName)) {
            if (!empty( $value )) {
                $fields = explode(',', $fieldName);

                $v = array();
                foreach ($fields as $field) {
                    $v[] = array('field' => $field, 'value' => '%'.$value,'%', 'condition' => 'LIKE' );
                }
                $value = $v;
            }
        } else if (!$this->ar->fieldExists($fieldName)) {
            return '';
        }

        return $value;
    }

    public function setOrFilters($filters)
    {
        $i = 0;

        /**
         La forma del filters può essere
         $filters['nome campo'] = 'valore';
         $filters['nome campo'] = array('value' => '', 'condition' => '');
         $filters['nome campo'] = array(array('field' => '', value' => '', 'condition' => ''), array('field' => '', 'value' => '', 'condition' => ''))
         */
        foreach ($filters as $fieldName => $value) {
            if (is_array($value)) {
               if (isset($value['value']) && !is_array($value['value'])) {
                    $this->where(isset($value['field']) ? $value['field'] : $fieldName, $value['value'], $value['condition']);
                } else {
                    foreach ($value as $v) {
                        $this->where($v['field'], $v['value'], $v['condition']);
                    }
                }
            } else {
                $this->where($fieldName, $value);
            }

            if ($i != count($filters)-1) {
                $this->newQueryInOr();
                $i++;
            }
        }

        return $this;
    }



    public function selectDistinct($fieldName)
    {
        $indexData = $this->addIndex($fieldName);
        $indexValue = $indexData['indexFieldPrefixAlias'].'_value';
        $this->qb->resetQueryPart('select');
        if ($this->ar->getDriverName() == 'mysql') {
            $this->qb->select('DISTINCT('.$indexValue.'), '.$indexValue.' AS '.$fieldName);
        } else {
            $this->qb->select('DISTINCT ON('.$indexValue.') '.$indexValue.' AS '.$fieldName);
        }
        $this->hasSelect = true;
        return $this;
    }

    protected function addIndex($fieldName, $indexAliasPrefix='index')
    {
        if (isset($this->conditionsMap[$fieldName])) {
            return $this->conditionsMap[$fieldName];
        }

        $indexAlias = $indexAliasPrefix.$this->indexNumber;
        $indexType = $this->ar->getIndexFieldType($fieldName);

        $documentDetailIdName = $this->ar->getDocumentDetailTableIdName();

        $documentIndexTablePrefix = $this->ar->getDocumentIndexTablePrefix();
        $indexTablePrefix = $documentIndexTablePrefix.$indexType;

        $documentIndexFieldPrefix = $this->ar->getDocumentIndexFieldPrefix();
        $indexFieldPrefixAlias = $indexAlias.'.'.$documentIndexFieldPrefix.$indexType;

        $this->qb->join(self::DOCUMENT_TABLE_ALIAS, $indexTablePrefix.'_tbl', $indexAlias,
                        $this->expr->eq(self::DOCUMENT_DETAIL_TABLE_ALIAS.".".$documentDetailIdName, $indexFieldPrefixAlias."_FK_document_detail_id"));

        $this->qb->andWhere($this->expr->eq("{$indexFieldPrefixAlias}_name", ":name{$this->indexNumber}"));
        $this->qb->setParameter(":name{$this->indexNumber}", $fieldName);

        $indexData = array(
            'indexAlias' => $indexAlias,
            'indexFieldPrefixAlias' => $indexFieldPrefixAlias
        );

        $this->conditionsMap[$fieldName] = $indexData;

        $this->indexNumber++;

        return $indexData;
    }

    // il primo parametro è il campo da cui si ricava l'indice da selezionare
    public function selectIndex($fieldName, $key, $value)
    {
        $indexData = $this->addIndex($fieldName);
        $indexAlias = $indexData['indexAlias'];
        $this->select($indexAlias.'.'.$key, $indexAlias.'.'.$value);
        return $this;
    }

    public function where($fieldName, $value = null, $condition = '=')
    {
        if ($fieldName == self::DOCUMENT_TYPE) {
            return $this->whereTypeIs($value, $condition);
        } else if ($fieldName == self::DOCUMENT_ID) {
            return $this->whereDocumentIdIs($value);
        } else if ($fieldName == self::DOCUMENT_DETAIL_FK_LANGUAGE) {
            return $this->whereLanguageIs($value);
        } else if ($fieldName == self::DOCUMENT_DETAIL_STATUS) {
            return $this->whereStatusIs($value);
        } else if ($this->ar->getField($fieldName)->isSystemField) {
            return $this->whereSystemField($fieldName, $value, $condition);
        } else {
            return parent::where($fieldName, $value, $condition);
        }
    }

    protected function whereCondition($fieldName, $value, $condition = '=', $composite = null)
    {
        $this->ar->whereCondition($this->qb, $this->indexNumber, $fieldName, $value, $condition);
        $this->indexNumber++;
        return $this;
    }

    public function newQueryInOr()
    {
        $this->finalizeQuery();
        $this->unionArray[] = $this->qb;
        $this->unionArrayParams = array_merge($this->unionArrayParams, $this->qb->getParameters());
        $this->qb = $this->ar->createQueryBuilder(true, self::DOCUMENT_TABLE_ALIAS, self::DOCUMENT_DETAIL_TABLE_ALIAS);
        $this->qb->select(self::DOCUMENT_TABLE_ALIAS.'.*', self::DOCUMENT_DETAIL_TABLE_ALIAS.'.*');
        $this->hasLimit = false;
        $this->typeSet = false;
        $this->statusSet = false;
        $this->visibilitySet = false;
        $this->languageSet = false;

        return $this;
    }

    public function whereTypeIs($type, $condition = '=')
    {
        $valueParam = ':type'.$this->conditionNumber++;
        $fieldName = self::DOCUMENT_TABLE_ALIAS.'.'.self::DOCUMENT_TYPE;
        $this->qb->andWhere($this->expr->comparison($fieldName, $condition, $valueParam))
                 ->setParameter($valueParam, $type);
        $this->typeSet = true;

        return $this;
    }

    public function allTypes()
    {
        $this->typeSet = true;
        return $this;
    }

    public function whereStatusIs($value)
    {
        $valueParam = ':status'.$this->conditionNumber++;
        $this->qb->andWhere($this->expr->eq(self::DOCUMENT_DETAIL_STATUS, $valueParam))
                 ->setParameter($valueParam, $value);
        $this->statusSet = true;
        return $this;
    }

    public function allStatuses()
    {
        $this->statusSet = true;
        return $this;
    }

    public function whereLanguageIs($value)
    {
        $this->qb->andWhere($this->expr->eq(self::DOCUMENT_DETAIL_FK_LANGUAGE, ':language'))
                 ->setParameter(':language', $value);
        $this->languageSet = true;
        return $this;
    }

    public function allLanguages()
    {
        $this->languageSet = true;
        return $this;
    }

    public function whereDocumentIdIs($value)
    {
        $paramName = ':documenId_'.count($this->unionArray);
        $this->qb->andWhere($this->expr->eq(self::DOCUMENT_ID, $paramName))
                 ->setParameter($paramName, $value);
        return $this;
    }

    protected function whereSystemField($fieldName, $value, $condition = '=')
    {
        $valueParam = ':system'.$this->conditionNumber++;
        $this->qb->andWhere($this->expr->comparison($fieldName, $condition, $valueParam))
                 ->setParameter($valueParam, $value);
        return $this;
    }


    public function showAll()
    {
        $this->visibilitySet = true;
        return $this;
    }

    public function showVisible()
    {
        $valueParam = ':isVisible'.$this->conditionNumber++;
        $this->qb->andWhere($this->expr->eq(self::DOCUMENT_DETAIL_IS_VISIBLE, $valueParam))
                 ->setParameter($valueParam, 1);
        $this->visibilitySet = true;
        return $this;
    }

    public function limit($offset, $limit = -1, $performCount=true)
    {
        if (!empty($this->unionArray)) {
            if (is_array($offset)) {
                if (!isset($offset['start'])) {
                    list($offset, $limit) = array_values($offset);
                } else {
                    $limit = $offset['pageLength'];
                    $offset = $offset['start'];
                }
            }

            $this->unionLimit = array($limit, $offset);
            return $this;
        }

        return parent::limit($offset, $limit, $performCount);
    }

    public function orderBy($fieldName, $order = 'ASC')
    {
        if (!empty($this->unionArray)) {
            $this->unionOrderBy = array($fieldName, $order);
            return $this;
        }

        if ($this->ar->getField($fieldName)->isSystemField) {
            return $this->orderBySystemField($fieldName, $order);
        } else {
            $indexData = $this->addIndex($fieldName);
            $indexFieldPrefixAlias = $indexData['indexFieldPrefixAlias'];
            $this->qb->addOrderBy("{$indexFieldPrefixAlias}_value", $order);
            return $this;
        }
    }

    protected function orderBySystemField($fieldName, $order = 'ASC')
    {
        $this->qb->addOrderBy($fieldName, $order);
        return $this;
    }

    private function finalizeQuery()
    {
        if (!$this->typeSet) {
            $this->whereTypeIs($this->ar->getType());
        }

        if (!$this->statusSet) {
            $this->whereStatusIs(self::STATUS_PUBLISHED);
        }

        if (!$this->languageSet) {
            $this->whereLanguageIs($this->ar->getLanguageId());
        }

        if (__Config::get('glizy.dataAccess.documentVisibility') && !$this->visibilitySet) {
            $this->showVisible();
        }
    }

    // TODO aggiustare
    public function addAcl()
    {
        $qb = $this->qb;
        $and = $qb->expr()->andX();
        $and->add($qb->expr()->eq('acl.join_FK_source_id', self::DOCUMENT_TABLE_ALIAS.'.'.self::DOCUMENT_ID));
        $and->add($qb->expr()->eq('acl.join_objectName', ':join_objectName'));

        $or = $qb->expr()->orX();
        $or->add($qb->expr()->isNull('acl.join_FK_dest_id'));

        $application = org_glizy_ObjectValues::get('org.glizy', 'application');
        $user = $application->getCurrentUser();
        $roles = $user->getRoles();

        $i = 0;

        foreach ($roles as $role) {
            $roleParam = ':role'.$i++;
            $or->add($qb->expr()->eq('acl.join_FK_dest_id', $roleParam));
            $qb->setParameter($roleParam, $role);
        }

        $qb->addSelect('acl.*')
           ->leftJoin(self::DOCUMENT_TABLE_ALIAS, $this->ar->getTablePrefix().'joins_tbl', 'acl', $and)
           ->andWhere($or)
           ->setParameter(':join_objectName', 'documents_tbl#rel_aclView');

        return $this;
    }

    public function exec()
    {
        if (!$this->querySqlToExec) {
            $this->finalizeQuery();
        }

        if (empty($this->unionArray)) {
            if (__Config::get('ACL_ROLES')) {
                $application = org_glizy_ObjectValues::get('org.glizy', 'application');
                $user = $application->getCurrentUser();
                if ($user->id && !$user->acl($application->getPageId(), 'all')) {
                    $this->addAcl();
                }
            }

            parent::exec();
        }
        else {
            $this->unionArray[] = $this->qb;
            $this->unionArrayParams = array_merge($this->unionArrayParams, $this->qb->getParameters());

            if (!empty($this->unionOrderBy)) {
                list($fieldName, $order) = $this->unionOrderBy;

                if (!$this->ar->getField($fieldName)->isSystemField) {
                    $indexType = $this->ar->getIndexFieldType($fieldName);
                    $documentDetailIdName = $this->ar->getDocumentDetailTableIdName();
                    $documentTableIndexPrefix = $this->ar->getDocumentIndexTablePrefix();
                    $indexAlias = 'orderIndex';
                    $indexTablePrefix = $documentTableIndexPrefix.$indexType;

                    $documentFieldIndexPrefix = $this->ar->getDocumentIndexFieldPrefix();
                    $indexFieldPrefix = $documentFieldIndexPrefix.$indexType;
                    $indexFieldPrefixAlias = $indexAlias.'.'.$indexFieldPrefix;

                    foreach ($this->unionArray as $qb) {
                        $qb->addSelect('orderIndex.*');
                        $qb->join(self::DOCUMENT_TABLE_ALIAS, $indexTablePrefix.'_tbl', 'orderIndex',
                                  $this->expr->eq(self::DOCUMENT_DETAIL_TABLE_ALIAS.".".$documentDetailIdName, $indexFieldPrefixAlias."_FK_document_detail_id"));
                        $qb->andWhere($this->expr->eq("{$indexFieldPrefixAlias}_name", ":orderIndex"));
                    }

                    $this->unionArrayParams[":orderIndex"] = $fieldName;

                    $orderSql = "ORDER BY {$indexFieldPrefix}_value $order";
                }
                else {
                    $orderSql = "ORDER BY $fieldName $order";
                }
            }



            $sqlArray = array();

            foreach ($this->unionArray as $qb) {
                if (!$this->siteSet && $this->ar->getSiteField()) {
                    $qb->andWhere($this->expr->eq($this->ar->getSiteField(), ':site'));
                    $this->unionArrayParams[":site"] = $this->ar->getSiteid();
                }

                $sqlArray[] = $qb->getSql();
            }

            $sql = '(' . implode(') UNION (', $sqlArray) . ')';

            if (!empty($this->unionOrderBy)) {
                $sql .= $orderSql;
            }
            if ($this->unionLimit && count($this->unionLimit)) {
                $sql .= ' LIMIT '.$this->unionLimit[0].' OFFSET '.$this->unionLimit[1];
            }

            if (__Config::get('QUERY_CACHING') && ($cacheDriver = org_glizy_dataAccessDoctrine_DataAccess::getCache())) {
                $lifeTime = __Config::get('QUERY_CACHING_LIFETIME');
                $key = md5($sql);
                $this->statement = $this->ar->getConnection()->executeQuery($sql, $this->unionArrayParams, array(), new QueryCacheProfile($lifeTime, $key, $cacheDriver));
            } else {
                $this->statement = $this->ar->getConnection()->executeQuery($sql, $this->unionArrayParams);
            }

            $this->resetQuery();
        }
    }

    // TODO
    public function execSql($sql, $options=array())
    {
        if (is_string($sql)) {
            $sql = array('sql' => $sql);
        }

        $params = isset($options['params']) ? $options['params'] : ( is_array($options) ? $options : array());
        $params = isset($sql['params']) ? array_merge($sql['params'], $params) : $params;
        $this->statement = $this->ar->getConnection()->executeQuery($sql['sql'], $params);
// TODO implementare meglio
        $this->count = $this->statement->rowCount();
    }
}