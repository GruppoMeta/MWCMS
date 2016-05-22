<?php
$mapping = array(
    'glizyModule' => 'Risorgimento',

    // campi
    'title' => 'catalogdetail_title',
    'description_t' => array('stripHtml:catalogdetail_bibliography'),
    'publisher_t' => '',
    'creator_t' => 'catalogdetail_author',
    'subject_t' => 'catalogdetail_category',
    'date_t' => '',
    'type_t' => '',
    'source_t' => 'catalogdetail_origin',
    'country_t' => '',
    'region_t' => '',
    'district_t' => '',
    'city_t' => 'catalogdetail_place2',

    // faccette
    'publisher_facet' => '',
    'creator_facet' => 'catalogdetail_author',
    'subject_facet' => 'catalogdetail_category',
    'type_facet' => '',
    'source_facet' => '',
    'city_facet' => 'catalogdetail_place2',
);