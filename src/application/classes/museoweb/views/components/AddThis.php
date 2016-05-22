<?php
class museoweb_views_components_AddThis extends org_glizy_components_Component
{
	function render_html()
	{
		$siteProp = $this->_application->getSiteProperty();
		if ( isset( $siteProp[ 'addthis' ] ) &&  $siteProp[ 'addthis' ] == "1" )
		{
			$code = $siteProp[ 'addthis' ];
			$output =  <<< EOD
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style clearfix">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f0b6fe248dc64d3"></script>
<!-- AddThis Button END -->
EOD;
			// add the code in the output buffer
			$this->addOutputCode($output);
		}
	}
}
