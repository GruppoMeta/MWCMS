<?php
class museoweb_modules_pico_views_components_ThesaurusPicker extends org_glizy_components_Component
{
	function render()
	{
			$output = <<<EOD
<link rel="stylesheet" media="all" type="text/css" href="../static/jquery/jquery.treeview/jquery.treeview.css" />
<script type="text/javascript" src="../static/jquery/jquery.treeview/jquery.treeview.js"></script>
<script type="text/javascript" src="../static/jquery/jquery.cookie/jquery.cookie.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#thesaurus").treeview({
		animated: "fast",
		collapsed: true,
		unique: true,
		persist: "cookie"
	});

	jQuery("#thesaurus a").click( function( e ){
		e.preventDefault();
		if ( this.href != "" )
		{
			var value = this.href + '"' + this.firstChild.nodeValue+ '"';
			if ( value != "" )
			{
				parent.Glizy.picoThesaurus.addThesaurus(value);
				//parent.Glizy.pageContent_widgets.callMethod( parent.Glizy.pageContent_widgets.EditableSelectThesaurus.elForPicker, 'addThesaurus', value );
			}
		}
	});
});
</script>
EOD;
		$this->addOutputCode( $output, 'head' );

		$thesaurusParser = org_glizy_ObjectFactory::createObject( 'museoweb.modules.pico.thesaurus.Parser' );
		$info = $thesaurusParser->read();
		$this->addOutputCode( $info[ 'mapIt' ] );
	}
}
?>