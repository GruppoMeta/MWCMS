<?php
class museoweb_massiveImporter_models_Table extends org_glizy_dataAccessDoctrine_ActiveRecord
{
    function __construct($connectionNumber=0, $tableNameWithPrefix) {
        parent::__construct($connectionNumber);
        $this->setTableName($tableNameWithPrefix);

        $sm = new org_glizy_dataAccessDoctrine_SchemaManager($this->connection);
        $sequenceName = $sm->getSequenceName($this->getTableName());
        $this->setSequenceName($sequenceName);

        $fields = $sm->getFields($this->getTableName());

        foreach ($fields as $field) {
            $this->addField($field);
        }
    }
}