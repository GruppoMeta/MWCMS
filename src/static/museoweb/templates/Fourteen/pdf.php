<pdf orientation="portrait" size="A4" stripImages="false" margin="27,15,25,15" marginHeaderFooter="5,10" imageScale="1.25" logoScale="1">
	<header font="helvetica" fontSize="10" logo="<?php print($logoUrl) ?>"><![CDATA[<?php print( strip_tags( $doctitle ) ) ?>]]></header>
	<styles><![CDATA[]]></styles>
	<content font="helvetica" fontSize="10"><![CDATA[<?php print($content.$text.$news.$events) ?>]]></content>
	<footer font="helvetica" fontSize="8"><![CDATA[##url##]]></footer>
</pdf>