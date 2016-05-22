<?php
class museoweb_views_components_Podcast extends org_glizy_components_Groupbox
{

	function render( $outputMode )
	{
		if (is_null($outputMode)) $outputMode = $this->_application->getOutputMode();
		if ( $outputMode == 'html' )
		{
			// add the JS code in the head
			$js = org_glizy_helpers_JS::linkJSfile('static/swfobject/swfobject.js');
			$js .= org_glizy_helpers_JS::linkJSfile('static/audio-player/audio-player-uncompressed.js');
			$this->addOutputCode($js, 'head');

		// get the settings and store in local variables
		$this->_content = array();
		$content = $this->getContent();
		$player = "static/audio-player/player.swf";
		$audio = $content['audio']['src'];
		$title = addslashes( $content['audio']['title'] );

			$output =  <<< EOD
<script type="text/javascript">
// <![CDATA[
AudioPlayer.setup("{$player}", {
	    width: '100%',
	    initialvolume: 100,
	    transparentpagebg: "yes",
	    left: "000000",
	    lefticon: "FFFFFF"
	    });
AudioPlayer.embed("audioplayer", {
		soundFile: "{$audio}",
		titles: "{$title}",
		autostart: "false"
		});
// ]]>
</script>
EOD;

			$this->_content['jsCode'] = $output;
		}
		parent::render( $outputMode );
	}

	function getContent()
	{
		return array_merge( $this->_content, $this->getChildContent() );
	}
}
