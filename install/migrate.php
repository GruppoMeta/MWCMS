<?php
require_once("core/core.inc.php");

$application = org_glizy_ObjectFactory::createObject('org.glizycms.core.application.Application', 'application', '', 'localhost');
$conn1 = org_glizy_dataAccessDoctrine_DataAccess::getConnection();
$conn1Prefix = __Config::get('DB_PREFIX');

$conn2 = org_glizy_dataAccessDoctrine_DataAccess::getConnection(2);
$conn2Prefix = __Config::get('DB_PREFIX#2');
$mapExternalId = array();

truncateTables($conn1Prefix);
migrateCommonTables($conn1, $conn1Prefix, $conn2, $conn2Prefix);
setLanguages($conn2, $conn2Prefix);
migrateMedia($conn1, $conn1Prefix, $conn2, $conn2Prefix);
migratePageContent($conn1, $conn1Prefix, $conn2, $conn2Prefix);
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'news', 'news', 'news', 'museoweb.modules.news.models.Model');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'events', 'events', 'event', 'museoweb.modules.events.models.Model');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'touristroutes', 'touristroute', 'touristroute', 'museoweb.modules.touristRoutes.models.Route');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'touristsites', 'touristsite', 'touristsite', 'museoweb.modules.touristRoutes.models.Site');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'catalog', 'catalog', 'catalog', 'museoweb.modules.catalogs.models.Model', 'catalog');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'catalog', 'catalog', 'catalog', 'museoweb.modules.catalogsMultimedia.models.Model', 'catalogMultimedia');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'catalog', 'catalog', 'catalog', 'museoweb.modules.catalogsArchive.models.Model', 'catalogArchive');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'catalog', 'catalog', 'catalog', 'museoweb.modules.catalogsIcono.models.Model', 'catalogIcono');
fixCatalogLinkForRoutes();
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'competitions', 'competition', 'competition', 'museoweb.modules.competitions.models.Model');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'exhibitions', 'exhibitions', 'exhibition', 'museoweb.modules.exhibitions.models.Model');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'glossary', 'glossary', 'glossary', 'museoweb.modules.glossary.models.Model');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'merchandising', 'merchandising', 'merchandising', 'museoweb.modules.merchandising.models.Model');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'mountings', 'mounting', 'mounting', 'museoweb.modules.mountings.models.Mounting');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'mountingparts', 'mountingpart', 'mountingpart', 'museoweb.modules.mountings.models.MountingPart');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'pressroom', 'pressroom', 'pressroom', 'museoweb.modules.pressRooms.models.Model');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'projects', 'project', 'project', 'museoweb.modules.projects.models.Model');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'publications', 'publication', 'publication', 'museoweb.modules.publications.models.Model');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'regulations', 'regulation', 'regulation', 'museoweb.modules.regulations.models.Model');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'routegroups', 'routegroup', 'routegroup', 'museoweb.modules.routes.models.Group');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'routethemes', 'routetheme', 'routetheme', 'museoweb.modules.routes.models.Theme');
migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'routes', 'route', 'route', 'museoweb.modules.routes.models.Route');
fixSiteStructure($conn1, $conn1Prefix, $conn2, $conn2Prefix);
migrateSiteProperties($conn1, $conn1Prefix, $conn2, $conn2Prefix);
migrateMetanavigation($conn1, $conn1Prefix, $conn2, $conn2Prefix);

echo "Migrazione completata";

function truncateTables($prefix)
{
    $tables = array('documents_detail_tbl', 'documents_index_datetime_tbl', 'documents_index_date_tbl', 'documents_index_fulltext_tbl', 'documents_index_int_tbl', 'documents_index_text_tbl', 'documents_index_time_tbl', 'documents_tbl', 'ecommordersitems_tbl', 'ecommorders_tbl', 'exif_tbl', 'iccd_theasaurs_tbl', 'languages_tbl', 'massiveimporter_mappings_tbl', 'mediadetails_tbl', 'media_tbl', 'menudetails_tbl', 'menus_tbl', 'niso_tbl', 'picoqueues_tbl', 'registry_tbl', 'simple_documents_index_datetime_tbl', 'simple_documents_index_date_tbl', 'simple_documents_index_fulltext_tbl', 'simple_documents_index_int_tbl', 'simple_documents_index_text_tbl', 'simple_documents_index_time_tbl', 'simple_documents_tbl', 'sites_tbl', 'usergroups_tbl', 'userlogs_tbl', 'users_tbl');
    array_map(function($v) use ($prefix) {
        org_glizy_dataAccessDoctrine_DataAccess::truncateTable($prefix.$v);
    }, $tables);
}

function migrateCommonTables($conn1, $conn1Prefix, $conn2, $conn2Prefix)
{
    copyTable($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'languages_tbl');
    copyTable($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'menus_tbl');
    copyTable($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'menudetails_tbl');
    copyTable($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'users_tbl');
    copyTable($conn1, $conn1Prefix, $conn2, $conn2Prefix, 'usergroups_tbl');
}

function migrateMedia($conn1, $conn1Prefix, $conn2, $conn2Prefix)
{
    $ar = org_glizy_ObjectFactory::createModel('org.glizycms.models.Media');
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')->from($conn2Prefix.'media_tbl', 't');
    $stmt = $queryBuilder->execute();

    while ($row = $stmt->fetch()) {
        $ar->emptyRecord();
        $ar->save($row, true);
    }
}

function migrateSiteProperties($conn1, $conn1Prefix, $conn2, $conn2Prefix)
{
    __Registry::set('museoweb/templateName', 'Fourteen');
    __Registry::set('museoweb/templateValues/Fourteen', '{"0":{"headerLogo":"","footerLogo":"","footerLogoLink":"","footerLogoTitle":"","font1":"default","font2":"default","ca802b1a30a2eacd75516f2a3ba4b459a":"0","c-body-background":"","c-text":"#000000","c-text-heading":"#000000","c-color-link":"#AE3433","c-box-image-border":"#CCCCCC","c-sidebar-background":"#F5F5F5","c-sidebar-background-hover":"#AE3433","c-sidebar-border":"#7A7A7A","c-metanavigation-link":"#FFFFFF","c-metanavigation-link-hover":"#FFFFFF","c-slider-background":"#CCCCCC","c-slider-text":"#FFFFFF","c-slider-bullet-background":"#000000","c-slider-bullet-background-selected":"#CCCCCC","c-box-background":"#FFFFFF","c-box-header-background":"#FFFFFF","c-box-border":"#CCCCCC","c-box-text":"#000000","c-box-header-link":"#AE3433","c-box-relation-item-border":"#CCCCCC","c-box-relation-item-background":"#FFFFFF","c-box-relation-item-link":"#000000","c-box-relation-item-link-hover":"#CCCCCC","c-box-border-cart":"#CCCCCC","c-icon-in-box":"#FFFFFF","c-icon-in-box-background":"#CCCCCC","c-color-border-button":"#CCCCCC","c-color-arrow-button-slider":"#FFFFFF","c-color-background-button":"#AE3433","c-form-border":"#CCCCCC","c-form-required":"#CCCCCC","c-form-input-background":"#FFFFFF","c-form-button-primary":"#AE3433","c-form-buttonPrimary-text":"#FFFFFF","c-form-button":"#7A7A7A","c-form-button-text":"#FFFFFF","c-timeline-theme":"#AE3433","c-storyteller-background":"#E4E4E4","c-storyteller-item-background":"#F9F9F9","c-storyteller-border":"#D8D8D8","c-storyteller-comments-background":"#F9F9F9","c-storyteller-link":"#AE3433","c-storyteller-navigation-link":"#7A7A7A","c-storyteller-image-border":"#C6C6C6","c-footer-border":"#000000","c-footer-text":"#FFFFFF","c-footer-background":"#333333","c-color-menu-link":"#FFFFFF","c-color-menu-link-hover":"#FFFFFF","c-color-sub-menu-link":"#FFFFFF","c-color-cart-button":"#FFFFFF","c-bg-body":"#FFFFFF","c-bg-top-bar":"#AE3433","c-bg-outer":"#FFFFFF","c-bg-header":"#FFFFFF","c-bg-menu":"#AE3433","c-bg-module-main-search":"#F8F6F0","c-bg-button-add":"#48AE46","c-bg-button-reset":"#CCCCCC","customCss":""}}');

    $links = array();
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')->from($conn2Prefix.'registry_tbl', 't');
    $stmt = $queryBuilder->execute();

    while ($row = $stmt->fetch()) {
        if (strpos($row['registry_path'], 'org/minervaeurope/museoweb/siteProp')===0) {
            $key = str_replace('org/minervaeurope/museoweb/siteProp', 'museoweb/siteProp', $row['registry_path']);
            $value = unserialize($row['registry_value']);
            $siteProp = array(
                    'title' => $value['title'],
                    'address' => $value['address'],
                    'copyiright' => $value['footer'],
                    'slideShow' => $value['slideShow'],
                );

            $prefix = 'linkRepeater';
            $numItems = $value[$prefix];
            $langCode = str_replace('museoweb/siteProp/', '', $key);
            for ($i=0; $i<$numItems; $i++) {
                $suffix = $i > 0 ? '@'.$i.'-' : '-';
                if (!isset($links[$i])) {
                    $links[$i] = array();
                }
                $links[$i][$langCode] = array(
                        'title' => $value[$prefix.$suffix.'title'],
                        'type' => $value[$prefix.$suffix.'linkType'],
                        'internal' => $value[$prefix.$suffix.'linkInternal'],
                        'external' => $value[$prefix.$suffix.'linkExternal'],
                    );
            }
            __Registry::set($key, serialize($siteProp));
        }
    }

    addAlias($conn1, $conn1Prefix, $conn2, $conn2Prefix, $links, 'footer');
}

function migrateMetanavigation($conn1, $conn1Prefix, $conn2, $conn2Prefix)
{
    $links = array();
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')->from($conn2Prefix.'registry_tbl', 't');
    $stmt = $queryBuilder->execute();

    while ($row = $stmt->fetch()) {
        if (strpos($row['registry_path'], 'org/minervaeurope/museoweb/metanavigation')===0) {
            $value = unserialize($row['registry_value']);

            $prefix = 'metanavRepeater';
            $numItems = $value[$prefix];
            $langCode = str_replace('org/minervaeurope/museoweb/metanavigation/', '', $row['registry_path']);
            for ($i=0; $i<$numItems; $i++) {
                $suffix = $i > 0 ? '@'.$i.'-' : '-';
                if (!isset($links[$i])) {
                    $links[$i] = array();
                }
                if ($value[$prefix.$suffix.'linkType']=='user' || $value[$prefix.$suffix.'linkType']=='logout') continue;
                $links[$i][$langCode] = array(
                        'title' => $value[$prefix.$suffix.'title'],
                        'type' => $value[$prefix.$suffix.'linkType'],
                        'internal' => $value[$prefix.$suffix.'destination'],
                        'external' => $value[$prefix.$suffix.'linkExternal'],
                    );
            }
        }
    }
    addAlias($conn1, $conn1Prefix, $conn2, $conn2Prefix, $links, 'metanavigation');
}

function fixSiteStructure($conn1, $conn1Prefix, $conn2, $conn2Prefix)
{
    $languagesId = array_values(getLanguages($conn2, $conn2Prefix));
    org_glizy_ObjectValues::set('org.glizy', 'languagesId', $languagesId);
    org_glizy_ObjectValues::set('org.glizy', 'editingLanguageId', $languagesId[0]);

    $menuToAdd = array(
        '2' => 'Metanavigazione',
        '3' => 'Footer',
        '4' => 'Utilità',
        '5' => 'Strumenti',
    );

    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('menu_id')
        ->from($conn2Prefix.'menus_tbl', 't1')
        ->orderBY('menu_id', 'DESC');
    $stmt = $queryBuilder->execute();
    $row = $stmt->fetch();
    $lastId = $row['menu_id']+1;

    foreach($menuToAdd as $k=>$v) {
        $queryBuilder = $conn2->createQueryBuilder();
        $queryBuilder->select('*')
            ->from($conn2Prefix.'menus_tbl', 't1')
            ->where('menu_id = '.$k);
        $stmt = $queryBuilder->execute();
        $row = $stmt->fetch();
        if ($row) {
            $conn1->update(
                    $conn1Prefix.'menus_tbl',
                    array('menu_parentId' => $lastId),
                    array('menu_parentId' => $k)
                );
            $conn1->update(
                    $conn1Prefix.'menus_tbl',
                    array('menu_id' => $lastId),
                    array('menu_id' => $k)
                );
            $conn1->update(
                    $conn1Prefix.'menudetails_tbl',
                    array('menudetail_FK_menu_id' => $lastId),
                    array('menudetail_FK_menu_id' => $k)
                );
            $conn1->update(
                    $conn1Prefix.'documents_index_int_tbl',
                    array('document_index_int_value' => $lastId),
                    array('document_index_int_value' => $k, 'document_index_int_name' => 'id')
                );
            $lastId++;
        }

        $ar = org_glizy_ObjectFactory::createModel('org.glizycms.core.models.Menu');
        $ar->menu_id        = $k;
        $ar->menu_parentId  = 1;
        $ar->menu_pageType  = 'Empty';
        $ar->menu_order     = $k;
        $ar->menu_type      = 'SYSTEM';
        $ar->menu_hasPreview= '1';
        $ar->menu_url       = '';
        $ar->menu_creationDate = new org_glizy_types_DateTime();
        $ar->menu_modificationDate = new org_glizy_types_DateTime();

        $ar->menudetail_title = $v;
        $ar->menudetail_isVisible = 1;
        $ar->menudetail_keywords = '';
        $ar->menudetail_description = '';
        $ar->menudetail_subject = '';
        $ar->menudetail_creator = '';
        $ar->menudetail_publisher = '';
        $ar->menudetail_contributor = '';
        $ar->menudetail_type = '';
        $ar->menudetail_identifier = '';
        $ar->menudetail_coverage = '';
        $ar->menudetail_source = '';
        $ar->menudetail_relation = '';

        $ar->save(null, true);
    }

    $conn1->exec('ALTER TABLE '.$conn1Prefix.'menus_tbl AUTO_INCREMENT = '.$lastId);
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')
        ->from($conn2Prefix.'menus_tbl', 't1')
        ->where('menu_id = 14')
        ->andWhere('menu_pageType = "Empty"')
        ->andWhere('menu_type = "SYSTEM"');
    $stmt = $queryBuilder->execute();
    $row = $stmt->fetch();
    if ($row) {
        $conn1->update(
                $conn1Prefix.'menus_tbl',
                array('menu_parentId' => 5),
                array('menu_parentId' => 14)
            );
        $conn1->delete(
                $conn1Prefix.'menus_tbl',
                array('menu_id' => 14)
            );
    }

    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')
        ->from($conn2Prefix.'menus_tbl', 't1')
        ->where('menu_id = 17')
        ->andWhere('menu_pageType = "Empty"')
        ->andWhere('menu_type = "SYSTEM"');
    $stmt = $queryBuilder->execute();
    $row = $stmt->fetch();
    if ($row) {
        $conn1->update(
                $conn1Prefix.'menus_tbl',
                array('menu_parentId' => 4),
                array('menu_parentId' => 17)
            );
        $conn1->delete(
            $conn1Prefix.'menus_tbl',
            array('menu_id' => 17)
        );
    }

    $menuProxy = org_glizy_ObjectFactory::createObject('org.glizycms.contents.models.proxy.MenuProxy');
    $menuProxy->moveMenu(2, 0, 1);
    $menuProxy->moveMenu(3, 1, 1);
    $menuProxy->moveMenu(4, 2, 1);
    $menuProxy->moveMenu(5, 3, 1);

    org_glizy_ObjectValues::set('org.glizy', 'languagesId', array());
}


function migratePageContent($conn1, $conn1Prefix, $conn2, $conn2Prefix)
{
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')
        ->from($conn2Prefix.'contentversions_tbl', 't1')
        ->innerJoin('t1', $conn2Prefix.'contents_tbl', 't2', 't1.contentversion_id = t2.content_FK_version_id')
        ->innerJoin('t1', $conn2Prefix.'menus_tbl', 't3', 't1.contentversion_FK_menu_id = t3.menu_id')
        ->where('contentversion_status = "PUBLISHED"')
        ->orderBy('t1.contentversion_id');
    $stmt = $queryBuilder->execute();

    $contents = array();
    while ($row = $stmt->fetch()) {
        $id = $row['contentversion_id'].'_'.$row['contentversion_FK_language_id'].'_'.$row['contentversion_status'];
        if (!isset($contents[$id])) {
            $contents[$id] = array();
            $contents[$id]['menu_id'] = $row['contentversion_FK_menu_id'];
            $contents[$id]['user_id'] = $row['contentversion_FK_user_id'];
            $contents[$id]['date'] = $row['contentversion_date'];
            $contents[$id]['status'] = $row['contentversion_status'];
            $contents[$id]['language_id'] = $row['contentversion_FK_language_id'];
            $contents[$id]['pageType'] = $row['menu_pageType'];
            $contents[$id]['content'] = org_glizy_ObjectFactory::createObject('org.glizycms.contents.models.ContentVO');
            $contents[$id]['content']->setId($row['contentversion_FK_menu_id']);
        }
        $contents[$id]['content']->{$row['content_componentId']} = $row['content_value'];
    }


    $mapContentMenu = array();
    $ar = org_glizy_objectFactory::createModel('org.glizycms.core.models.Content');
    array_map(function($v) use (&$ar, &$mapContentMenu, $conn2, $conn2Prefix) {
            org_glizy_ObjectValues::set('org.glizy', 'editingLanguageId', $v['language_id']);
            org_glizy_ObjectValues::set('org.glizy', 'userId', $v['user_id']);
            $ar->emptyRecord();
            if (isset($mapContentMenu[$v['menu_id']])) {
                $ar->load($mapContentMenu[$v['menu_id']]);
            }
            $functionName = 'migratePageContent_'.$v['pageType'];
            if (function_exists($functionName)) {
                $functionName($v['content'], $conn2, $conn2Prefix);
            }
            $ar->setDataFromContentVO($v['content']);
            $ar->document_creationDate = $v['date'];
            // TODO non viene gestisto lo stato bozza, la data di creazione e di modifica
            $mapContentMenu[$v['menu_id']] = $ar->save(null, false, $v['status']);
    }, $contents);
}

function migrateModule($conn1, $conn1Prefix, $conn2, $conn2Prefix, $tblPrefix, $tblDetailPrefix, $fieldPrefix, $model, $tblQuery='')
{
    global $mapExternalId;
    $fieldPrefixMaster = $fieldPrefix;
    if ($fieldPrefixMaster=='mountingpart') {
        $fieldPrefixMaster = 'mountingparts';
    }
    $mapLanguageToRecord = array();
    $ar = org_glizy_objectFactory::createModel($model);
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')
        ->from($conn2Prefix.$tblPrefix.'_tbl', 't1')
        ->innerJoin('t1', $conn2Prefix.$tblDetailPrefix.'details_tbl', 't2', 't1.'.$fieldPrefix.'_id = t2.'.$fieldPrefix.'detail_FK_'.$fieldPrefixMaster.'_id')
        ->where($fieldPrefix.'detail_versionStatus = "PUBLISHED"')
        ->orderBy('t1.'.$fieldPrefix.'_id');
    $functionName = 'migrateModuleQuery_'.$tblQuery;
    if (function_exists($functionName)) {
        $functionName($queryBuilder);
    }
    $stmt = $queryBuilder->execute();

    while ($row = $stmt->fetch()) {
        $functionName = 'migrateModule_'.$tblPrefix;
        if (function_exists($functionName)) {
            $r = $functionName($conn2, $conn2Prefix, $row);
            if (!$r) continue;
        }

        array_walk($row, function(&$item, $key) {
            if (is_array($item)) {
                $item = json_decode(json_encode($item));
            } else {
                $item = javascript_to_html($item);
            }
        });

        $ar->emptyRecord();
        org_glizy_ObjectValues::set('org.glizy', 'editingLanguageId', $row[$fieldPrefix.'detail_FK_language_id']);
        if (!isset($mapLanguageToRecord[$row['external_id']])) {
            // crea il record per gestire tutte le lingue
            $id = $ar->save(null, false, 'PUBLISHED');
            $mapLanguageToRecord[$row['external_id']] = $id;
            $mapExternalId[$tblPrefix.$row['external_id']] = $id;
        }

        // TODO non viene gestisto lo stato bozza, la data di creazione e di modifica
        $ar->load($mapLanguageToRecord[$row['external_id']]);
        try {
            $ar->fulltext = org_glizycms_core_helpers_Fulltext::make($row, $ar, false);
            $ar->publish($row);
        } catch (Exception $e) {
            var_dump($e->getErrors());
        }
    }
}

/**
 * PageType migration
 */
function migratePageContent_home($content, $conn2, $conn2Prefix)
{
    $content->text = $content->{'HomeText-Content'};
}

function migratePageContent_page($content, $conn2, $conn2Prefix)
{
    $images = array('image' => array());
    $numImages = (int)$content->{'imagesRepeater'};
    unset($content->{'imagesRepeater'});
    for($i=0; $i<$numImages; $i++) {
        $prefix = $i>0 ? '@'.$i : '';
        $mediaId = $content->{'imagesRepeater'.$prefix.'-image'};
        // TODO usare getImage
        $images['image'][] = array('id' => $mediaId, 'src' => 'getImage.php?id='.$mediaId);
        unset($content->{'imagesRepeater'.$prefix.'-image'});
    }
    $content->images = $images;
}


function migratePageContent_photogallery($content, $conn2, $conn2Prefix)
{
    $images = array('image' => array(), 'text' => array());
    $numImages = (int)$content->{'downloadRepeater'};
    unset($content->{'downloadRepeater'});
    for($i=0; $i<$numImages; $i++) {
        $prefix = $i>0 ? '@'.$i : '';
        $mediaId = $content->{'downloadRepeater'.$prefix.'-attach'};
        $text = $content->{'downloadRepeater'.$prefix.'-text'};
        $images['image'][] = getImage($conn2, $conn2Prefix, $mediaId);
        $images['text'][] = $text;
        unset($content->{'downloadRepeater'.$prefix.'-attach'});
        unset($content->{'downloadRepeater'.$prefix.'-text'});
    }
    $content->text = $content->{'downloadRepeater-text'};
    unset($content->{'downloadRepeater-text'});
    $content->images = $images;
}

function migratePageContent_form($content, $conn2, $conn2Prefix)
{

    $repeater = array('fieldName' => array(), 'fieldDescription' => array(), 'fieldRequired' => array(), 'fieldType' => array());
    $numItems = (int)$content->{'formRepeater'};
    unset($content->{'formRepeater'});
    for($i=0; $i<$numItems; $i++) {
        $prefix = $i>0 ? '@'.$i : '';
        $repeater['fieldName'][] = $content->{'formRepeater'.$prefix.'-fieldName'};
        $repeater['fieldDescription'][] = $content->{'formRepeater'.$prefix.'-fieldDescription'};
        $repeater['fieldRequired'][] = $content->{'formRepeater'.$prefix.'-fieldRequired'};
        $repeater['fieldType'][] = $content->{'formRepeater'.$prefix.'-fieldType'};
        unset($content->{'formRepeater'.$prefix.'-fieldName'});
        unset($content->{'formRepeater'.$prefix.'-fieldDescription'});
        unset($content->{'formRepeater'.$prefix.'-fieldRequired'});
        unset($content->{'formRepeater'.$prefix.'-fieldType'});
    }
    $content->formBuilder = $repeater;
}

function migratePageContent_pageWithIndex($content, $conn2, $conn2Prefix)
{
    $texts = array();
    $numImages = (int)$content->{'paragraphRepeater'};
    unset($content->{'paragraphRepeater'});
    for($i=0; $i<$numImages; $i++) {
        $prefix = $i>0 ? '@'.$i : '';
        $item = new StdClass();
        $item->title = $content->{'paragraphRepeater'.$prefix.'-title'};
        $item->text = $content->{'paragraphRepeater'.$prefix.'-text'};
        $imagesRepeater = $content->{'paragraphRepeater'.$prefix.'-imagesRepeater'};
        $item->imagesRepeater = array();


        for($y=0; $y<$imagesRepeater; $y++) {
            $prefix2 = $y>0 ? '@'.$y : '';
            $mediaId = $content->{'paragraphRepeater'.$prefix.'-imagesRepeater'.$prefix2};
            $itemImage = new StdClass();
            $itemImage->image = array('id' => $mediaId, 'src' => 'getImage.php?id='.$mediaId);
            $item->imagesRepeater[] = $itemImage;
        }

       $texts[] = $item;
    }
    $content->paragraphRepeater = $texts;
}

/**
 * Modules migrations
 */

function migrateModule_news($conn2, $conn2Prefix, &$row)
{
    $mediaId = resolveJoin($conn2, $conn2Prefix, $row['news_id'], 'news_tbl');
    $row['media'] = array('media_id' => array());
    array_map(function($v) use (&$row, $conn2, $conn2Prefix) {
        $row['media']['media_id'][] = getMedia($conn2, $conn2Prefix, $v);
    }, $mediaId);
    if ($row['newsdetail_image']) {
        $row['newsdetail_image'] = getImage($conn2, $conn2Prefix, $row['newsdetail_image']);
    }
    $row['external_id'] = $row['news_id'];
    return true;
}


function migrateModule_events($conn2, $conn2Prefix, &$row)
{
    $mediaId = resolveJoin($conn2, $conn2Prefix, $row['event_id'], 'events_tbl');
    $row['media'] = array('media_id' => array());
    array_map(function($v) use (&$row, $conn2, $conn2Prefix) {
        $row['media']['media_id'][] = getMedia($conn2, $conn2Prefix, $v);
    }, $mediaId);
    if ($row['eventdetail_image']) {
        $row['eventdetail_image'] = getImage($conn2, $conn2Prefix, $row['eventdetail_image']);
    }
    $row['external_id'] = $row['event_id'];
    return true;
}

function migrateModule_catalog($conn2, $conn2Prefix, &$row)
{
    global $mapExternalId;
    $mediaId = resolveJoin($conn2, $conn2Prefix, $row['catalog_id'], 'catalog_tbl');
    $row['images'] = array('image_id' => array());
    array_map(function($v) use (&$row, $conn2, $conn2Prefix) {
        $row['images']['image_id'][] = getImage($conn2, $conn2Prefix, $v);
    }, $mediaId);

    if ($row['catalogdetail_FK_touristsite_id']) {
        $queryBuilder = $conn2->createQueryBuilder();
        $i = $row['catalogdetail_FK_touristsite_id'];
        if (isset($mapExternalId['touristsites'.$i])) {
            $row['catalogdetail_FK_touristsite_id'] = array();
            $queryBuilder->select('touristsitedetail_name')
                            ->from($conn2Prefix.'touristsitedetails_tbl', 't1')
                            ->where('touristsitedetail_FK_touristsite_id = '.$i)
                            ->andWhere('touristsitedetail_versionStatus = "PUBLISHED"')
                            ->andWhere('touristsitedetail_FK_language_id = '.$row['catalogdetail_FK_language_id']);
            $stmt = $queryBuilder->execute();
            $subRow = $stmt->fetch();
            $row['catalogdetail_FK_touristsite_id'][] = array('id' => $mapExternalId['touristsites'.$i], 'text' => $subRow['touristsitedetail_name']);
        }
    }

    $row['external_id'] = $row['catalog_id'];
    return true;
}

function migrateModuleQuery_catalog($queryBuilder)
{
    $queryBuilder->andWhere('catalog_type = "CATALOG"');
}

function migrateModuleQuery_catalogArchive($queryBuilder)
{
    $queryBuilder->andWhere('catalog_type = "ARCHIVE"');
}

function migrateModuleQuery_catalogMultimedia($queryBuilder)
{
    $queryBuilder->andWhere('catalog_type = "MULTIMEDIA"');
}

function migrateModuleQuery_catalogIcono($queryBuilder)
{
    $queryBuilder->andWhere('catalog_type = "ICONO"');
}

function migrateModule_competitions($conn2, $conn2Prefix, &$row)
{
    $mediaId = resolveJoin($conn2, $conn2Prefix, $row['competition_id'], 'competitions_tbl');
    $row['media'] = array('media_id' => array());
    array_map(function($v) use (&$row, $conn2, $conn2Prefix) {
        $row['media']['media_id'][] = getMedia($conn2, $conn2Prefix, $v);
    }, $mediaId);
    $row['external_id'] = $row['competition_id'];
    return true;
}

function migrateModule_exhibitions($conn2, $conn2Prefix, &$row)
{
    $mediaId = resolveJoin($conn2, $conn2Prefix, $row['exhibition_id'], 'exhibitions_tbl');
    $row['media'] = array('media_id' => array());
    array_map(function($v) use (&$row, $conn2, $conn2Prefix) {
        $row['media']['media_id'][] = getMedia($conn2, $conn2Prefix, $v);
    }, $mediaId);

    if ($row['exhibitiondetail_image']) {
        $row['exhibitiondetail_image'] = getImage($conn2, $conn2Prefix, $row['exhibitiondetail_image']);
    }
    $row['external_id'] = $row['exhibition_id'];
    return true;
}

function migrateModule_glossary($conn2, $conn2Prefix, &$row)
{
    if ($row['glossarydetail_image']) {
        $row['glossarydetail_image'] = getImage($conn2, $conn2Prefix, $row['glossarydetail_image']);
    }
    $row['external_id'] = $row['glossary_id'];
    return true;
}

function migrateModule_merchandising($conn2, $conn2Prefix, &$row)
{
    if ($row['merchandisingdetail_FK_photo_id']) {
        $row['merchandisingdetail_FK_photo_id'] = getImage($conn2, $conn2Prefix, $row['merchandisingdetail_FK_photo_id']);
    }
    $row['external_id'] = $row['merchandising_id'];
    return true;
}

function migrateModule_mountings($conn2, $conn2Prefix, &$row)
{
    $mediaId = resolveJoin($conn2, $conn2Prefix, $row['mounting_id'], 'mounting_tbl#mounting2drawing');
    $row['drawings'] = array('image_id' => array());
    array_map(function($v) use (&$row, $conn2, $conn2Prefix) {
        $row['drawings']['image_id'][] = getImage($conn2, $conn2Prefix, $v);
    }, $mediaId);
    $mediaId = resolveJoin($conn2, $conn2Prefix, $row['mounting_id'], 'mounting_tbl#mounting2photo');
    $row['images'] = array('image_id' => array());
    array_map(function($v) use (&$row, $conn2, $conn2Prefix) {
        $row['images']['image_id'][] = getImage($conn2, $conn2Prefix, $v);
    }, $mediaId);
    $mediaId = resolveJoin($conn2, $conn2Prefix, $row['mounting_id'], 'mounting_tbl#mounting2media');
    $row['media'] = array('media_id' => array());
    array_map(function($v) use (&$row, $conn2, $conn2Prefix) {
        $row['media']['media_id'][] = getMedia($conn2, $conn2Prefix, $v);
    }, $mediaId);

    $row['external_id'] = $row['mounting_id'];
    return true;
}

function migrateModule_mountingparts($conn2, $conn2Prefix, &$row)
{
    if ($row['mountingpartdetail_FK_media_id']) {
        $row['mountingpartdetail_FK_media_id'] = getImage($conn2, $conn2Prefix, $row['mountingpartdetail_FK_media_id']);
    }

    if ($row['mountingpartdetail_FK_mounting_id']) {
        // TODO manca da risolvere il nome dell'allestimento
        $row['mountingpartdetail_FK_mounting_id'] = array('id' => $row['mountingpartdetail_FK_mounting_id']);
    }

    $row['external_id'] = $row['mountingpart_id'];
    return true;
}

function migrateModule_pressroom($conn2, $conn2Prefix, &$row)
{
    $mediaId = resolveJoin($conn2, $conn2Prefix, $row['pressroom_id'], 'pressroom_tbl');
    $row['media'] = array('media_id' => array());
    array_map(function($v) use (&$row, $conn2, $conn2Prefix) {
        $row['media']['media_id'][] = getMedia($conn2, $conn2Prefix, $v);
    }, $mediaId);

    if ($row['pressroomdetail_image']) {
        $row['pressroomdetail_image'] = getImage($conn2, $conn2Prefix, $row['pressroomdetail_image']);
    }

    $row['external_id'] = $row['pressroom_id'];
    return true;
}

function migrateModule_projects($conn2, $conn2Prefix, &$row)
{
    $mediaId = resolveJoin($conn2, $conn2Prefix, $row['project_id'], 'projects_tbl');
    $row['media'] = array('media_id' => array());
    array_map(function($v) use (&$row, $conn2, $conn2Prefix) {
        $row['media']['media_id'][] = getMedia($conn2, $conn2Prefix, $v);
    }, $mediaId);

    if ($row['projectdetail_logo']) {
        $row['projectdetail_logo'] = getImage($conn2, $conn2Prefix, $row['projectdetail_logo']);
    }

    $row['external_id'] = $row['project_id'];
    return true;
}

function migrateModule_publications($conn2, $conn2Prefix, &$row)
{
    $mediaId = resolveJoin($conn2, $conn2Prefix, $row['publication_id'], 'publications_tbl');
    $row['media'] = array('media_id' => array());
    array_map(function($v) use (&$row, $conn2, $conn2Prefix) {
        $row['media']['media_id'][] = getMedia($conn2, $conn2Prefix, $v);
    }, $mediaId);

    if ($row['publicationdetail_FK_photo_id']) {
        $row['publicationdetail_FK_photo_id'] = getImage($conn2, $conn2Prefix, $row['publicationdetail_FK_photo_id']);
    }

    $row['external_id'] = $row['publication_id'];
    return true;
}

function migrateModule_regulations($conn2, $conn2Prefix, &$row)
{
    $mediaId = resolveJoin($conn2, $conn2Prefix, $row['regulation_id'], 'regulations_tbl');
    $row['media'] = array('media_id' => array());
    array_map(function($v) use (&$row, $conn2, $conn2Prefix) {
        $row['media']['media_id'][] = getMedia($conn2, $conn2Prefix, $v);
    }, $mediaId);

    $row['external_id'] = $row['regulation_id'];
    return true;
}

function migrateModule_routegroups($conn2, $conn2Prefix, &$row)
{
    $row['external_id'] = $row['routegroup_id'];
    return true;
}

function migrateModule_routethemes($conn2, $conn2Prefix, &$row)
{
    global $mapExternalId;
    if ($row['routethemedetail_FK_routegroup_id'] &&
        isset($mapExternalId['routegroups'.$row['routethemedetail_FK_routegroup_id']])) {
        $queryBuilder = $conn2->createQueryBuilder();
        $queryBuilder->select('routegroupdetail_title')
                ->from($conn2Prefix.'routegroupdetails_tbl', 't1')
                ->where('routegroupdetail_FK_routegroup_id = '.$row['routethemedetail_FK_routegroup_id'])
                ->andWhere('routegroupdetail_versionStatus = "PUBLISHED"')
                ->andWhere('routegroupdetail_FK_language_id = '.$row['routethemedetail_FK_language_id']);
        $stmt = $queryBuilder->execute();
        $subRow = $stmt->fetch();

        $row['routethemedetail_FK_routegroup_id'] = array('id' => $mapExternalId['routegroups'.$row['routethemedetail_FK_routegroup_id']], 'text' => $subRow['routegroupdetail_title']);
    } else {
        $row['routethemedetail_FK_routegroup_id'] = '';
    }

    if ($row['routethemedetail_FK_catalog']) {
        $queryBuilder = $conn2->createQueryBuilder();
        $ids = explode(',', $row['routethemedetail_FK_catalog']);
        $row['routethemedetail_FK_catalog'] = array();
        foreach($ids as $i) {
            if (isset($mapExternalId['catalog'.$i])) {
                $queryBuilder->select('catalogdetail_title')
                        ->from($conn2Prefix.'catalogdetails_tbl', 't1')
                        ->where('catalogdetail_FK_catalog_id = '.$i)
                        ->andWhere('catalogdetail_versionStatus = "PUBLISHED"')
                        ->andWhere('catalogdetail_FK_language_id = '.$row['routethemedetail_FK_language_id']);
                $stmt = $queryBuilder->execute();
                $subRow = $stmt->fetch();
                $row['routethemedetail_FK_catalog'][] = array('id' => $mapExternalId['catalog'.$i], 'text' => $subRow['catalogdetail_title']);
            }
        }
    }

    if ($row['routethemedetail_FK_touristsite']) {
        $queryBuilder = $conn2->createQueryBuilder();
        $ids = explode(',', $row['routethemedetail_FK_touristsite']);
        $row['routethemedetail_FK_touristsite'] = array();
        foreach($ids as $i) {
            if (isset($mapExternalId['touristsites'.$i])) {
                $queryBuilder->select('touristsitedetail_name')
                        ->from($conn2Prefix.'touristsitedetails_tbl', 't1')
                        ->where('touristsitedetail_FK_touristsite_id = '.$i)
                        ->andWhere('touristsitedetail_versionStatus = "PUBLISHED"')
                        ->andWhere('touristsitedetail_FK_language_id = '.$row['routethemedetail_FK_language_id']);
                $stmt = $queryBuilder->execute();
                $subRow = $stmt->fetch();
                $row['routethemedetail_FK_touristsite'][] = array('id' => $mapExternalId['touristsites'.$i], 'text' => $subRow['touristsitedetail_name']);
            }
        }
    }

    $row['external_id'] = $row['routetheme_id'];
    return true;
}

function migrateModule_routes($conn2, $conn2Prefix, &$row)
{
    global $mapExternalId;
    if ($row['routedetail_FK_routetheme_id'] &&
        isset($mapExternalId['routethemes'.$row['routedetail_FK_routetheme_id']])) {
        $queryBuilder = $conn2->createQueryBuilder();
        $queryBuilder->select('routethemedetail_title')
                ->from($conn2Prefix.'routethemedetails_tbl', 't1')
                ->where('routethemedetail_FK_routetheme_id = '.$row['routedetail_FK_routetheme_id'])
                ->andWhere('routethemedetail_versionStatus = "PUBLISHED"')
                ->andWhere('routethemedetail_FK_language_id = '.$row['routedetail_FK_language_id']);
        $stmt = $queryBuilder->execute();
        $subRow = $stmt->fetch();
        $row['routedetail_FK_routetheme_id'] = array('id' => $mapExternalId['routethemes'.$row['routedetail_FK_routetheme_id']], 'text' => $subRow['routethemedetail_title']);
    } else {
        $row['routethemedetail_FK_routegroup_id'] = '';
    }


    if ($row['routedetail_FK_catalog']) {
        $queryBuilder = $conn2->createQueryBuilder();
        $ids = explode(',', $row['routedetail_FK_catalog']);
        $row['routedetail_FK_catalog'] = array();
        foreach($ids as $i) {
            if (isset($mapExternalId['catalog'.$i])) {
                $queryBuilder->select('catalogdetail_title')
                        ->from($conn2Prefix.'catalogdetails_tbl', 't1')
                        ->where('catalogdetail_FK_catalog_id = '.$i)
                        ->andWhere('catalogdetail_versionStatus = "PUBLISHED"')
                        ->andWhere('catalogdetail_FK_language_id = '.$row['routedetail_FK_language_id']);
                $stmt = $queryBuilder->execute();
                $subRow = $stmt->fetch();
                $row['routedetail_FK_catalog'][] = array('id' => $mapExternalId['catalog'.$i], 'text' => $subRow['catalogdetail_title']);
            }
        }
    }

    if ($row['routedetail_FK_touristsite']) {
        $queryBuilder = $conn2->createQueryBuilder();
        $ids = explode(',', $row['routedetail_FK_touristsite']);
        $row['routedetail_FK_touristsite'] = array();
        foreach($ids as $i) {
            if (isset($mapExternalId['touristsites'.$i])) {
                $queryBuilder->select('touristsitedetail_name')
                        ->from($conn2Prefix.'touristsitedetails_tbl', 't1')
                        ->where('touristsitedetail_FK_touristsite_id = '.$i)
                        ->andWhere('touristsitedetail_versionStatus = "PUBLISHED"')
                        ->andWhere('touristsitedetail_FK_language_id = '.$row['routedetail_FK_language_id']);
                $stmt = $queryBuilder->execute();
                $subRow = $stmt->fetch();
                $row['routedetail_FK_touristsite'][] = array('id' => $mapExternalId['touristsites'.$i], 'text' => $subRow['touristsitedetail_name']);
            }
        }
    }

    $row['external_id'] = $row['route_id'];
    return true;
}



function migrateModule_touristroutes($conn2, $conn2Prefix, &$row)
{
    if ($row['touristroutedetail_map']) {
        $row['touristroutedetail_map'] = getImage($conn2, $conn2Prefix, $row['touristroutedetail_map']);
    }

    $row['touristroutedetail_FK_catalog'] = array();
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')
            ->from($conn2Prefix.'touristroute2catalog_tbl', 't1')
            ->join('t1', $conn2Prefix.'catalogdetails_tbl', 't2', 't1.touristroute2catalog_FK_catalog_id = t2.catalogdetail_FK_catalog_id')
            ->where('touristroute2catalog_FK_touristsite_id = '.$row['touristroute_id'])
            ->andWhere('catalogdetail_versionStatus = "PUBLISHED"')
            ->andWhere('catalogdetail_FK_language_id = '.$row['touristroutedetail_FK_language_id']);
    $stmt = $queryBuilder->execute();
    while ($subRow = $stmt->fetch()) {
        $row['touristroutedetail_FK_catalog'][] = array('id' => (int)$subRow['catalogdetail_FK_catalog_id'], 'text' => $subRow['catalogdetail_title']);
    }

    $row['external_id'] = $row['touristroute_id'];
    return true;
}

function migrateModule_touristsites($conn2, $conn2Prefix, &$row)
{
    global $mapExternalId;

    $row['images'] = array('image_id' => array());
    if ($row['touristsitedetail_image1']) {
        $row['images'][] = getImage($conn2, $conn2Prefix, $row['touristsitedetail_image1']);
    }
    if ($row['touristsitedetail_image2']) {
        $row['images'][] = getImage($conn2, $conn2Prefix, $row['touristsitedetail_image2']);
    }
    if ($row['touristsitedetail_image3']) {
        $row['images'][] = getImage($conn2, $conn2Prefix, $row['touristsitedetail_image3']);
    }
    if ($row['touristsitedetail_image4']) {
        $row['images'][] = getImage($conn2, $conn2Prefix, $row['touristsitedetail_image4']);
    }
    if ($row['touristsitedetail_image5']) {
        $row['images'][] = getImage($conn2, $conn2Prefix, $row['touristsitedetail_image5']);
    }

    if ($row['touristsitedetail_FK_touristroute']) {
        $queryBuilder = $conn2->createQueryBuilder();
        $ids = explode(',', $row['touristsitedetail_FK_touristroute']);
        $row['touristsitedetail_FK_touristroute'] = array();
        foreach($ids as $i) {
             if (isset($mapExternalId['touristroutes'.$i])) {
                $queryBuilder->select('touristroutedetail_name')
                        ->from($conn2Prefix.'touristroutedetails_tbl', 't1')
                        ->where('touristroutedetail_FK_touristroute_id = '.$i)
                        ->andWhere('touristroutedetail_versionStatus = "PUBLISHED"')
                        ->andWhere('touristroutedetail_FK_language_id = '.$row['touristsitedetail_FK_language_id']);
                $stmt = $queryBuilder->execute();
                $subRow = $stmt->fetch();
                $row['touristsitedetail_FK_touristroute'][] = array('id' => $mapExternalId['touristroutes'.$i], 'text' => $subRow['touristroutedetail_name']);
            }
        }
    }

    $row['touristsitedetail_FK_catalog'] = array();
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')
            ->from($conn2Prefix.'touristsite2catalog_tbl', 't1')
            ->join('t1', $conn2Prefix.'catalogdetails_tbl', 't2', 't1.touristsite2catalog_FK_catalog_id = t2.catalogdetail_FK_catalog_id')
            ->where('touristsite2catalog_FK_touristsite_id = '.$row['touristsite_id'])
            ->andWhere('catalogdetail_versionStatus = "PUBLISHED"')
            ->andWhere('catalogdetail_FK_language_id = '.$row['touristsitedetail_FK_language_id']);
    $stmt = $queryBuilder->execute();
    while ($subRow = $stmt->fetch()) {
        $row['touristsitedetail_FK_catalog'][] = array('id' => (int)$subRow['catalogdetail_FK_catalog_id'], 'text' => $subRow['catalogdetail_title']);
    }

    $row['external_id'] = $row['touristsite_id'];
    return true;
}


function fixCatalogLinkForRoutes()
{
    global $mapExternalId;
    $it = org_glizy_objectFactory::createModelIterator('museoweb.modules.touristRoutes.models.Route');
    foreach($it as $ar) {
        if (is_array($ar->touristroutedetail_FK_catalog) && count($ar->touristroutedetail_FK_catalog)) {
            $tempV = array();
            foreach($ar->touristroutedetail_FK_catalog as $v) {
                $temp = new StdClass;
                $temp->id = $mapExternalId['catalog'.$v->id];
                $temp->text = $v->text;
                $tempV[] = $temp;
            }

            $ar->touristroutedetail_FK_catalog = $tempV;
            $ar->save(null, false, 'PUBLISHED');
        }
    }

    $it = org_glizy_objectFactory::createModelIterator('museoweb.modules.touristRoutes.models.Site');
    foreach($it as $ar) {
        if (is_array($ar->touristsitedetail_FK_catalog) && count($ar->touristsitedetail_FK_catalog)) {
            $tempV = array();
            foreach($ar->touristsitedetail_FK_catalog as $v) {
                $temp = new StdClass;
                $temp->id = $mapExternalId['catalog'.$v->id];
                $temp->text = $v->text;
                $tempV[] = $temp;
            }

            $ar->touristsitedetail_FK_catalog = $tempV;
            $ar->save(null, false, 'PUBLISHED');
        }
    }
}


function copyTable_menus_tbl(&$row)
{
    $mapPagetype = array(
            'Blog' => 'museoweb.modules.blog.views.FrontEnd',
            'Catalog' => 'museoweb.modules.catalogs.views.FrontEnd',
            'CatalogArchive' => 'museoweb.modules.catalogsArchive.views.FrontEnd',
            'CatalogMultimedia' => 'museoweb.modules.catalogsMultimedia.views.FrontEnd',
            'Competition' => 'museoweb.modules.competitions.views.FrontEnd',
            'Events' => 'museoweb.modules.events.views.FrontEnd',
            'Exhibition' => 'museoweb.modules.exhibitions.views.FrontEnd',
            'Glossary' => 'museoweb.modules.glossary.views.FrontEnd',
            'Merchandising' => 'museoweb.modules.merchandising.views.FrontEnd',
            'Mounting' => 'museoweb.modules.mountings.views.FrontEnd',
            'News' => 'museoweb.modules.news.views.FrontEnd',
            'Mounting' => 'museoweb.modules.mountings.views.FrontEnd',
            'PressRoom' => 'museoweb.modules.pressRooms.views.FrontEnd',
            'Project' => 'museoweb.modules.projects.views.FrontEnd',
            'Publication' => 'museoweb.modules.publications.views.FrontEnd',
            'Regulation' => 'museoweb.modules.regulations.views.FrontEnd',
            'Routes' => 'museoweb.modules.routes.views.FrontEnd',
            'TouristRoute' => 'museoweb.modules.touristRoutes.views.RoutesFrontEnd',
            'TouristRouteSearch' => 'museoweb.modules.touristRoutes.views.RoutesFrontEnd',
            'TouristSites' => 'museoweb.modules.touristRoutes.views.SitesFrontEnd',
        );

    $row['menu_pageType'] = isset($mapPagetype[$row['menu_pageType']]) ? $mapPagetype[$row['menu_pageType']] : $row['menu_pageType'];
}


function copyTable_users_tbl(&$row)
{
    $row['user_password'] = glz_password($row['user_password']);
}


/**
 * Helpers
 */
function copyTable($conn1, $conn1Prefix, $conn2, $conn2Prefix, $table)
{
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')->from($conn2Prefix.$table, 't');
    $stmt = $queryBuilder->execute();

    while ($row = $stmt->fetch()) {
        $functionName = 'copyTable_'.$table;
        if (function_exists($functionName)) {
            $functionName($row);
        }

        $conn1->insert($conn1Prefix.$table, $row);
    }
}


function setLanguages($conn2, $conn2Prefix)
{
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')->from($conn2Prefix.'languages_tbl', 't');
    $stmt = $queryBuilder->execute();

    while ($row = $stmt->fetch()) {
        $languagesId[] = $row['language_id'];
    }
    org_glizy_ObjectValues::set('org.glizy', 'languagesId', $languagesId);
}


function resolveJoin($conn2, $conn2Prefix, $fkId, $name)
{
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')
        ->from($conn2Prefix.'joins_tbl', 't1')
        ->where('join_FK_source_id = ?')
        ->andWhere('join_objectName = ?')
        ->setParameter(0, $fkId)
        ->setParameter(1, $name)
        ->orderBy('join_id');
    $stmt = $queryBuilder->execute();
    $result = array();
    while ($row = $stmt->fetch()) {
        $result[] = $row['join_FK_dest_id'];
    }
    return $result;
}



function getMedia($conn2, $conn2Prefix, $id)
{
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')
        ->from($conn2Prefix.'media_tbl', 't1')
        ->where('media_id = '.$id);
    $stmt = $queryBuilder->execute();
    $row = $stmt->fetch();
    return json_encode(array('id' => $id, 'src' => 'getMedia.php?id='.$id, 'title' => $row['media_title']));
}

function getImage($conn2, $conn2Prefix, $id)
{
    $id = str_replace('media:id:', '', $id);
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')
        ->from($conn2Prefix.'media_tbl', 't1')
        ->where('media_id = '.$id);
    $stmt = $queryBuilder->execute();
    $row = $stmt->fetch();
    return json_encode(array('id' => $id, 'src' => 'getImage.php?w=150&h=150&c=1&co=1&f=0&t=1&.jpg&id='.$id, 'title' => $row['media_title']));
}

function getLanguages($conn2, $conn2Prefix)
{
    $queryBuilder = $conn2->createQueryBuilder();
    $queryBuilder->select('*')
        ->from($conn2Prefix.'languages_tbl', 't')
        ->orderBy('language_isDefault', 'DESC');
    $stmt = $queryBuilder->execute();

    $languagesId = array();
    while ($row = $stmt->fetch()) {
       $languagesId[$row['language_code']] = (int)$row['language_id'];
    }

    return $languagesId;
}


function addAlias($conn1, $conn1Prefix, $conn2, $conn2Prefix, $links, $parent)
{
    $languages = getLanguages($conn2, $conn2Prefix);
    $languagesId = array_values($languages);
    org_glizy_ObjectValues::set('org.glizy', 'languagesId', $languagesId);
    org_glizy_ObjectValues::set('org.glizy', 'editingLanguageId', $languagesId[0]);

    $menuProxy = org_glizy_ObjectFactory::createObject('org.glizycms.contents.models.proxy.MenuProxy');
    $contentProxy = org_glizy_objectFactory::createObject('org.glizycms.contents.models.proxy.ContentProxy');
    $parentId = $parent == 'footer' ? 3 : 2;

    foreach ($links as $v) {
        $menuId = $menuProxy->addMenu('Alias', $parentId, 'Alias');

        //rinomina i menù
        foreach($languages as $kk => $vv) {
            if ($v[$kk]['title']) {
                $menuProxy->rename($menuId, $vv, $v[$kk]['title']);
                $menuProxy->showHide($menuId, $vv, true);

                if ($v[$kk]['type']=='external') {
                    $url = $v[$kk]['external'];
                } else {
                    $url = 'alias:internal:'.$v[$kk]['internal'];
                    $data = $contentProxy->getContentVO();
                    $data->link = $v[$kk]['internal'];
                    $data->setId($menuId);
                    $data->setTitle($v[$kk]['title']);
                    $r = $contentProxy->saveContent($data, $vv, true);
                }

                $menu = org_glizy_ObjectFactory::createModel('org.glizycms.core.models.Menu');
                $menu->load($menuId);
                $menu->menu_url = $url;
                $menu->save();
            } else {
                $menuProxy->showHide($menuId, $vv, false);
            }
        }
    }
    org_glizy_ObjectValues::set('org.glizy', 'languagesId', array());
}

