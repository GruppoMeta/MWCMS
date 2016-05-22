<?php
class museoweb_modules_pico_views_components_Thesaurus extends org_glizy_components_Input
{
    function init()
    {
        parent::init();

        $this->setAttribute('data', ';type=picoThesaurus', true);
    }

    public function render_html()
    {
        parent::render_html();

        $this->addOutputCode( org_glizy_helpers_JS::linkJSfile( __Paths::get('APPLICATION_TO_ADMIN').'classes/museoweb/modules/pico/static/ThesaurusPicker.js' ), 'tail' );
    }
}
