<?php
class org_glizycms_contents_views_renderer_DocumentTitle extends GlizyObject
{
    function renderCell( $key, $value, $row )
    {
        $value = glz_encodeOutput($value);
        if ($row->isTranslated()) {
            return $value;
        }
        else {
            return '<em>'.$value.'</em>';
        }
    }
}