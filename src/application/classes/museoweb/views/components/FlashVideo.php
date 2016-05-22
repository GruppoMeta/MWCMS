<?php
class museoweb_views_components_FlashVideo extends org_glizy_components_Groupbox
{
	function render_html()
	{
		// don't render the children components
		$this->canHaveChilds = false;

		// add the JS code in the head
		$js = org_glizy_helpers_JS::linkJSfile('static/swfobject/swfobject.js');
		$js .= org_glizy_helpers_JS::JScode('swfobject.registerObject("myFlvPlayer", "8.0.0", "static/swfobject/expressInstall.swf")');
		$this->addOutputCode($js, 'head');

		// get tha contets of the children components
		$content = $this->getContent();

		// get the settings and sstore in local variables
		$player = "static/flv_player/player.swf";
		$movie = "&file=../../".$content['movie']['src'];
		$width = $content['width'];
		$height = $content['height'];
		$flv_background = $content['backgroundcolor'];
		$backcolor = "&backcolor=".str_replace('#', '0x', $content['backcolor']);
		$frontcolor = "&frontcolor=".str_replace('#', '0x', $content['frontcolor']);
		$lightcolor = "&lightcolor=".str_replace('#', '0x', $content['lightcolor']);
		$lightcolor = "&screencolor=".str_replace('#', '0x', $content['backgroundcolor']);
		$autostart = $content['autostart']['checked'] ? "&autostart=true" : "";
		$alttext = $content['textAlternative'];

		$v = str_replace( "&", "&amp;", $movie.$backcolor.$frontcolor.$lightcolor.$autostart );

		// compose the output HTML
		$output =  <<< EOD
<div id="flvplayer">
	<object id="myFlvPlayer" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="{$width}" height="{$height}">
		<param name="movie" value="{$player}" />
		<!--[if !IE]>-->
		<object type="application/x-shockwave-flash" data="{$player}" width="{$width}" height="{$height}">
		<!--<![endif]-->
		<param name="bgcolor" value="{$flv_background}" />
		<param name="allowfullscreen" value="true" />
		<param name="flashvars" value="{$v}" />
		<div>
			{$alttext}
		</div>
		<!--[if !IE]>-->
		</object>
		<!--<![endif]-->
	</object>
</div>
EOD;
		// add the code in the output buffer
		$this->addOutputCode($output);
	}

	// override Groupbox render methods
	function render_html_onStart() {}
	function render_html_onEnd(){}
}
?>