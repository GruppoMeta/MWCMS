<?php
class museoweb_views_components_FormWithAjaxSteps extends org_glizycms_views_components_FormEdit
{
	public function render_html_onStart()
	{
        // TODO localizzare il javascript
        $this->addOutputCode( org_glizy_helpers_JS::linkJSfile( __Paths::get('STATIC_DIR').'jquery/jquery-simplemodal/jquery.simplemodal.1.4.1.min.js' ) );
        $this->addOutputCode( org_glizy_helpers_JS::linkJSfile( __Paths::get('STATIC_DIR').'museoweb/js/formWithAjaxSteps.js' ) );
        $this->addOutputCode( org_glizy_helpers_JS::linkJSfile( __Paths::get('STATIC_DIR').'museoweb/js/progressBar/progressBar.js' ) );
        $this->addOutputCode( org_glizy_helpers_CSS::linkCSSfile( __Paths::get('STATIC_DIR').'museoweb/js/progressBar/progressBar.css' ), 'head' );
		parent::render_html_onStart();



        $output = '<div id="progress_bar" class="ui-progress-bar ui-container">
                  <div class="ui-progress" style="width: 0%;">
                  <span class="ui-label" style="display:none;"><b class="value">0%</b></span>
                      </div></div>';
        $this->addOutputCode( $output );

	}
}
