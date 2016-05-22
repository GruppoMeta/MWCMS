<?php
$mapping = array(
    'glizyModule' => 'museoweb_CatalogsArchive',

    // campi
    'title' => 'catalogdetail_title',
    'description_t' => array('stripHtml:catalogdetail_description', 'stripHtml:catalogdetail_bibliography'),
    'publisher_t' => '',
    'creator_t' => 'catalogdetail_author',
    'subject_t' => 'catalogdetail_category',
    'date_t' => '',
    'type_t' => '',
    'source_t' => '',
    'country_t' => 'split:0:catalogdetail_country',
    'region_t' => 'split:1:catalogdetail_country',
    'district_t' => 'split:2:catalogdetail_country',
    'city_t' => 'catalogdetail_city',

    // faccette
    'publisher_facet' => '',
    'creator_facet' => 'catalogdetail_author',
    'subject_facet' => 'catalogdetail_category',
    'type_facet' => '',
    'source_facet' => '',
    'city_facet' => 'catalogdetail_city',
);


