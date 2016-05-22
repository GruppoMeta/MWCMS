<?php
class museoweb_modules_solr_models_proxy_DcProxy extends GlizyObject
{
    private $option = array( 'solr',
                             'facets',
                             'lod' );

    private $field = array( 'abstract' => array('solr' => 't', 'lod' => 'dcterms:abstract'),
                            'accessRights' => array('solr' => 't', 'lod' => 'dcterms:accessRights'),
                            'accrualMethod' => array('solr' => 't', 'lod' => 'dcterms:accrualMethod'),
                            'accrualPeriodicity' => array('solr' => 't', 'lod' => 'dcterms:accrualPeriodicity'),
                            'accrualPolicy' => array('solr' => 't', 'lod' => 'dcterms:accrualPolicy'),
                            'alternative' => array('solr' => 't', 'lod' => 'dcterms:alternative'),
                            'audience' => array('solr' => 't', 'lod' => 'dcterms:audience'),
                            'available' => array('solr' => 't', 'lod' => 'dcterms:available'),
                            'bibliographicCitation' => array('solr' => 't', 'lod' => 'dcterms:bibliographicCitation'),
                            'conformsTo' => array('solr' => 't', 'lod' => 'dcterms:conformsTo'),
                            'contributor' => array('solr' => 't', 'lod' => 'dc:contributor'),
                            'coverage' => array('solr' => 't', 'lod' => 'dc:coverage'),
                            'created' => array('solr' => 't', 'lod' => 'dcterms:created'),
                            'creator' => array('solr' => 't', 'lod' => 'dc:creator'),
                            'date' => array('solr' => 't', 'lod' => 'dc:date'),
                            'dateAccepted' => array('solr' => 't', 'lod' => 'dcterms:dateAccepted'),
                            'dateCopyrighted' => array('solr' => 't', 'lod' => 'dcterms:dateCopyrighted'),
                            'dateSubmitted' => array('solr' => 't', 'lod' => 'dcterms:dateSubmitted'),
                            'description' => array('solr' => 't', 'lod' => 'dc:description'),
                            'educationLevel' => array('solr' => 't', 'lod' => 'dcterms:educationLevel'),
                            'extent' => array('solr' => 't', 'lod' => 'dcterms:extent'),
                            'format' => array('solr' => 't', 'lod' => 'dc:format'),
                            'hasFormat' => array('solr' => 't', 'lod' => 'dcterms:hasFormat'),
                            'hasPart' => array('solr' => 't', 'lod' => 'dcterms:hasPart'),
                            'hasVersion' => array('solr' => 't', 'lod' => 'dcterms:hasVersion'),
                            'image' => array('solr' => 't', 'lod' => 'image'),
                            'identifier' => array('solr' => 't', 'lod' => 'dc:identifier'),
                            'instructionalMethod' => array('solr' => 't', 'lod' => 'dcterms:instructionalMethod'),
                            'isFormatOf' => array('solr' => 't', 'lod' => 'dcterms:isFormatOf'),
                            'isPartOf' => array('solr' => 't', 'lod' => 'dcterms:isPartOf'),
                            'isReferencedBy' => array('solr' => 't', 'lod' => 'dcterms:isReferencedBy'),
                            'isReplacedBy' => array('solr' => 't', 'lod' => 'dcterms:isReplacedBy'),
                            'isRequiredBy' => array('solr' => 't', 'lod' => 'dcterms:isRequiredBy'),
                            'issued' => array('solr' => 't', 'lod' => 'dcterms:issued'),
                            'isVersionOf' => array('solr' => 't', 'lod' => 'dcterms:isVersionOf'),
                            'language' => array('solr' => 't', 'lod' => 'dc:language'),
                            'license' => array('solr' => 't', 'lod' => 'dcterms:license'),
                            'mediator' => array('solr' => 't', 'lod' => 'dcterms:mediator'),
                            'medium' => array('solr' => 't', 'lod' => 'dcterms:medium'),
                            'modified' => array('solr' => 't', 'lod' => 'dcterms:modified'),
                            'provenance' => array('solr' => 't', 'lod' => 'dcterms:provenance'),
                            'publisher' => array('solr' => 't', 'lod' => 'dc:publisher'),
                            'references' => array('solr' => 't', 'lod' => 'dcterms:references'),
                            'relation' => array('solr' => 't', 'lod' => 'dc:relation'),
                            'replaces' => array('solr' => 't', 'lod' => 'dcterms:replaces'),
                            'requires' => array('solr' => 't', 'lod' => 'dcterms:requires'),
                            'rights' => array('solr' => 't', 'lod' => 'dc:rights'),
                            'rightsHolder' => array('solr' => 't', 'lod' => 'dcterms:rightsHolder'),
                            'source' => array('solr' => 't', 'lod' => 'dc:source'),
                            'spatial' => array('solr' => 't', 'lod' => 'dcterms:spatial'),
                            'subject' => array('solr' => 't', 'lod' => 'dc:subject'),
                            'tableOfContents' => array('solr' => 't', 'lod' => 'dcterms:tableOfContents'),
                            'temporal' => array('solr' => 't', 'lod' => 'dcterms:temporal'),
                            'title' => array('solr' => '', 'lod' => 'dc:title'),
                            'type' => array('solr' => 't', 'lod' => 'dc:type'),
                            'valid' => array('solr' => 't', 'lod' => 'dcterms:valid') );

    private $defaultMapping = array( 'museoweb_Events' => 'O:8:"stdClass":10:{s:5:"title";a:1:{i:0;a:2:{i:0;s:17:"eventdetail_title";i:1;s:0:"";}}s:5:"image";a:1:{i:0;a:2:{i:0;s:17:"eventdetail_image";i:1;s:0:"";}}s:11:"description";a:1:{i:0;a:2:{i:0;s:23:"eventdetail_description";i:1;s:0:"";}}s:9:"publisher";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"creator";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"subject";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:4:"date";a:1:{i:0;a:2:{i:0;s:16:"eventdetail_date";i:1;s:0:"";}}s:4:"type";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:6:"source";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"spatial";a:1:{i:0;a:2:{i:0;s:17:"eventdetail_place";i:1;s:0:"";}}}',
                                     'museoweb_News' => 'O:8:"stdClass":10:{s:5:"title";a:1:{i:0;a:2:{i:0;s:16:"newsdetail_title";i:1;s:0:"";}}s:5:"image";a:1:{i:0;a:2:{i:0;s:16:"newsdetail_image";i:1;s:0:"";}}s:11:"description";a:1:{i:0;a:2:{i:0;s:20:"newsdetail_bodyShort";i:1;s:0:"";}}s:9:"publisher";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"creator";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"subject";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:4:"date";a:1:{i:0;a:2:{i:0;s:20:"newsdetail_startDate";i:1;s:0:"";}}s:4:"type";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:6:"source";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"spatial";a:1:{i:0;a:2:{i:0;s:16:"newsdetail_place";i:1;s:0:"";}}}',
                                     'museoweb_Catalogs' => 'O:8:"stdClass":10:{s:5:"title";a:1:{i:0;a:2:{i:0;s:19:"catalogdetail_title";i:1;s:0:"";}}s:5:"image";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:11:"description";a:2:{i:0;a:2:{i:0;s:25:"catalogdetail_description";i:1;s:12:"pulisci html";}i:1;a:2:{i:0;s:26:"catalogdetail_bibliography";i:1;s:12:"pulisci html";}}s:9:"publisher";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"creator";a:1:{i:0;a:2:{i:0;s:20:"catalogdetail_author";i:1;s:0:"";}}s:7:"subject";a:1:{i:0;a:2:{i:0;s:22:"catalogdetail_category";i:1;s:0:"";}}s:4:"date";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:4:"type";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:6:"source";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"spatial";a:4:{i:0;a:2:{i:0;s:21:"catalogdetail_country";i:1;s:20:"elemento posizione 1";}i:1;a:2:{i:0;s:21:"catalogdetail_country";i:1;s:20:"elemento posizione 2";}i:2;a:2:{i:0;s:21:"catalogdetail_country";i:1;s:20:"elemento posizione 3";}i:3;a:2:{i:0;s:18:"catalogdetail_city";i:1;s:0:"";}}}',
                                     'museoweb_CatalogsMultimedia' => 'O:8:"stdClass":10:{s:5:"title";a:1:{i:0;a:2:{i:0;s:19:"catalogdetail_title";i:1;s:0:"";}}s:5:"image";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:11:"description";a:2:{i:0;a:2:{i:0;s:25:"catalogdetail_description";i:1;s:12:"pulisci html";}i:1;a:2:{i:0;s:26:"catalogdetail_bibliography";i:1;s:12:"pulisci html";}}s:9:"publisher";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"creator";a:1:{i:0;a:2:{i:0;s:20:"catalogdetail_author";i:1;s:0:"";}}s:7:"subject";a:1:{i:0;a:2:{i:0;s:22:"catalogdetail_category";i:1;s:0:"";}}s:4:"date";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:4:"type";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:6:"source";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"spatial";a:4:{i:0;a:2:{i:0;s:21:"catalogdetail_country";i:1;s:20:"elemento posizione 1";}i:1;a:2:{i:0;s:21:"catalogdetail_country";i:1;s:20:"elemento posizione 2";}i:2;a:2:{i:0;s:21:"catalogdetail_country";i:1;s:20:"elemento posizione 3";}i:3;a:2:{i:0;s:18:"catalogdetail_city";i:1;s:0:"";}}}',
                                     'museoweb_CatalogsIcono' => 'O:8:"stdClass":10:{s:5:"title";a:1:{i:0;a:2:{i:0;s:19:"catalogdetail_title";i:1;s:0:"";}}s:5:"image";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:11:"description";a:2:{i:0;a:2:{i:0;s:25:"catalogdetail_description";i:1;s:12:"pulisci html";}i:1;a:2:{i:0;s:26:"catalogdetail_bibliography";i:1;s:12:"pulisci html";}}s:9:"publisher";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"creator";a:1:{i:0;a:2:{i:0;s:20:"catalogdetail_author";i:1;s:0:"";}}s:7:"subject";a:1:{i:0;a:2:{i:0;s:22:"catalogdetail_category";i:1;s:0:"";}}s:4:"date";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:4:"type";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:6:"source";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"spatial";a:4:{i:0;a:2:{i:0;s:21:"catalogdetail_country";i:1;s:20:"elemento posizione 1";}i:1;a:2:{i:0;s:21:"catalogdetail_country";i:1;s:20:"elemento posizione 2";}i:2;a:2:{i:0;s:21:"catalogdetail_country";i:1;s:20:"elemento posizione 3";}i:3;a:2:{i:0;s:18:"catalogdetail_city";i:1;s:0:"";}}}',
                                     'museoweb_CatalogsArchive' => 'O:8:"stdClass":10:{s:5:"title";a:1:{i:0;a:2:{i:0;s:19:"catalogdetail_title";i:1;s:0:"";}}s:5:"image";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:11:"description";a:2:{i:0;a:2:{i:0;s:25:"catalogdetail_description";i:1;s:12:"pulisci html";}i:1;a:2:{i:0;s:26:"catalogdetail_bibliography";i:1;s:12:"pulisci html";}}s:9:"publisher";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"creator";a:1:{i:0;a:2:{i:0;s:20:"catalogdetail_author";i:1;s:0:"";}}s:7:"subject";a:1:{i:0;a:2:{i:0;s:22:"catalogdetail_category";i:1;s:0:"";}}s:4:"date";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:4:"type";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:6:"source";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"spatial";a:4:{i:0;a:2:{i:0;s:21:"catalogdetail_country";i:1;s:20:"elemento posizione 1";}i:1;a:2:{i:0;s:21:"catalogdetail_country";i:1;s:20:"elemento posizione 2";}i:2;a:2:{i:0;s:21:"catalogdetail_country";i:1;s:20:"elemento posizione 3";}i:3;a:2:{i:0;s:18:"catalogdetail_city";i:1;s:0:"";}}}',
                                     'bacchiglione5284ddd49862c5284de0b80531' => 'O:8:"stdClass":10:{s:5:"title";a:2:{i:0;a:2:{i:0;s:5:"row_8";i:1;s:0:"";}i:1;a:2:{i:0;s:6:"row_19";i:1;s:12:"pulisci data";}}s:5:"image";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:11:"description";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:9:"publisher";a:1:{i:0;a:2:{i:0;s:6:"row_10";i:1;s:0:"";}}s:7:"creator";a:1:{i:0;a:2:{i:0;s:5:"row_9";i:1;s:0:"";}}s:7:"subject";a:1:{i:0;a:2:{i:0;s:12:"bacchiglione";i:1;s:7:"manuale";}}s:4:"date";a:1:{i:0;a:2:{i:0;s:6:"row_17";i:1;s:0:"";}}s:4:"type";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:6:"source";a:1:{i:0;a:2:{i:0;s:5:"row_3";i:1;s:0:"";}}s:7:"spatial";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}}',
                                     'Risorgimento' => 'O:8:"stdClass":10:{s:5:"title";a:1:{i:0;a:2:{i:0;s:19:"catalogdetail_title";i:1;s:0:"";}}s:5:"image";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:11:"description";a:1:{i:0;a:2:{i:0;s:26:"catalogdetail_bibliography";i:1;s:12:"pulisci html";}}s:9:"publisher";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"creator";a:1:{i:0;a:2:{i:0;s:20:"catalogdetail_author";i:1;s:0:"";}}s:7:"subject";a:1:{i:0;a:2:{i:0;s:22:"catalogdetail_category";i:1;s:0:"";}}s:4:"date";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:4:"type";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:6:"source";a:1:{i:0;a:2:{i:0;s:20:"catalogdetail_origin";i:1;s:0:"";}}s:7:"spatial";a:1:{i:0;a:2:{i:0;s:20:"catalogdetail_place2";i:1;s:0:"";}}}',
                                     'tabpapiri35284a82394f67' => 'O:8:"stdClass":10:{s:5:"title";a:1:{i:0;a:2:{i:0;s:5:"row_4";i:1;s:0:"";}}s:5:"image";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:11:"description";a:8:{i:0;a:2:{i:0;s:5:"row_5";i:1;s:0:"";}i:1;a:2:{i:0;s:5:"row_6";i:1;s:0:"";}i:2;a:2:{i:0;s:5:"row_8";i:1;s:0:"";}i:3;a:2:{i:0;s:5:"row_9";i:1;s:0:"";}i:4;a:2:{i:0;s:6:"row_10";i:1;s:0:"";}i:5;a:2:{i:0;s:6:"row_11";i:1;s:0:"";}i:6;a:2:{i:0;s:6:"row_12";i:1;s:0:"";}i:7;a:2:{i:0;s:6:"row_13";i:1;s:0:"";}}s:9:"publisher";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"creator";a:1:{i:0;a:2:{i:0;s:6:"row_11";i:1;s:0:"";}}s:7:"subject";a:1:{i:0;a:2:{i:0;s:16:"papiri di laurea";i:1;s:7:"manuale";}}s:4:"date";a:1:{i:0;a:2:{i:0;s:5:"row_7";i:1;s:0:"";}}s:4:"type";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:6:"source";a:1:{i:0;a:2:{i:0;s:0:"";i:1;s:0:"";}}s:7:"spatial";a:1:{i:0;a:2:{i:0;s:5:"row_5";i:1;s:0:"";}}}');

    private $defaultProfile = 'O:8:"stdClass":10:{s:5:"title";O:8:"stdClass":4:{s:4:"solr";i:1;s:6:"facets";i:0;s:3:"lod";i:1;s:5:"title";s:5:"title";}s:5:"image";O:8:"stdClass":4:{s:4:"solr";i:1;s:6:"facets";i:0;s:3:"lod";i:1;s:5:"title";s:5:"image";}s:11:"description";O:8:"stdClass":4:{s:4:"solr";i:1;s:6:"facets";i:1;s:3:"lod";i:1;s:5:"title";s:11:"description";}s:9:"publisher";O:8:"stdClass":4:{s:4:"solr";i:1;s:6:"facets";i:1;s:3:"lod";i:1;s:5:"title";s:9:"publisher";}s:7:"creator";O:8:"stdClass":4:{s:4:"solr";i:1;s:6:"facets";i:1;s:3:"lod";i:1;s:5:"title";s:7:"creator";}s:7:"subject";O:8:"stdClass":4:{s:4:"solr";i:1;s:6:"facets";i:1;s:3:"lod";i:1;s:5:"title";s:7:"subject";}s:4:"date";O:8:"stdClass":4:{s:4:"solr";i:1;s:6:"facets";i:0;s:3:"lod";i:1;s:5:"title";s:4:"date";}s:4:"type";O:8:"stdClass":4:{s:4:"solr";i:1;s:6:"facets";i:1;s:3:"lod";i:1;s:5:"title";s:4:"type";}s:6:"source";O:8:"stdClass":4:{s:4:"solr";i:1;s:6:"facets";i:1;s:3:"lod";i:1;s:5:"title";s:6:"source";}s:7:"spatial";O:8:"stdClass":4:{s:4:"solr";i:1;s:6:"facets";i:0;s:3:"lod";i:1;s:5:"title";s:7:"spatial";}}';

    public function getOptions()
    {
        return $this->option;
    }

    public function getFields()
    {
        return $this->field;
    }

    public function getDefaultMappingById($id) {
        return $this->defaultMapping[$id];
    }

    public function getDefaultMapping() {
        return $this->defaultMapping;
    }


    public function getDefaultProfile() {
        return $this->defaultProfile;
    }

}
