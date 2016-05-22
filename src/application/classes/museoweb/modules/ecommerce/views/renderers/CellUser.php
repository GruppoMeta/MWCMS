<?php
class museoweb_modules_ecommerce_views_renderers_CellUser extends org_glizycms_contents_views_renderer_AbstractCellEdit
{
    function renderCell($key, $value, $row)
    {
        return $row->user_firstName.' '.$row->user_lastName.' ['.$row->user_email.']';
    }
}


