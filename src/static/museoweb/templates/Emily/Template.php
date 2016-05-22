<?php
class Template extends org_glizycms_template_fe_views_AbstractLessTemplate
{
	function __construct()
	{
		$this->path = __DIR__;
	}

	public function process($application, $view, $templateData)
    {
		$box = array(	'boxLogin' 		=> 'boxLogin',
						'boxLogin2' 	=> 'boxUser',
						'boxSearch' 	=> 'boxSearch',
						'navigation1' 	=> 'navigation1',
						);

		foreach($box as $b=>$componentName)
		{
			if ($b=='boxLogin2') $b = "boxLogin";
			$component = &$view->getComponentById($componentName);
			if (is_object($component))
			{
				if ($b=='boxLogin2' || $b=='boxLogin' && $component->getAttribute('visible')==false) continue;
				$component->setAttribute('enabled', !$templateData->{$b}=='0');
				$component->setAttribute('editableRegion', $templateData->{$b}=='1' ? 'leftContent':'rightContentAfter');
			}
		}
    }


	protected function applyCssVariables(&$templateData, $less, $css)
	{
		return parent::applyCssVariablesFromJson($templateData, $less, $css);
	}

	protected function applyFont(&$templateData, $css)
	{
		$font1 = $templateData->font1 == 'default' ? 'sans-serif' : $templateData->font1;
		$font2 = $templateData->font2 == 'default' ? 'serif' : $templateData->font2;

		if ($font1!='sans-serif' && $font1!='serif') {
			$fonts = '@import url(http://fonts.googleapis.com/css?family='.str_replace(' ', '+', $font1).':400,700,600);'.PHP_EOL.
					 '@font-1: \''.$font1.'\', sans-serif;'.PHP_EOL;
		} else {
			$fonts = '@font-1: '.($font1=='sans-serif' ? 'Arial, Helvetica, "Helvetica Neue", sans-serif' : 'Georgia, "Times New Roman",Times,serif').';'.PHP_EOL;
		}
		if ($font2!='sans-serif' && $font2!='serif') {
			$fonts .= '@import url(http://fonts.googleapis.com/css?family='.str_replace(' ', '+', $font2).':400,700,600);'.PHP_EOL.
					  '@font-2: \''.$font2.'\', sans-serif;'.PHP_EOL;
		} else {
			$fonts .= '@font-2: '.($font2=='sans-serif' ? 'Arial, Helvetica, "Helvetica Neue", sans-serif' : 'Georgia, "Times New Roman",Times,serif').';'.PHP_EOL;
		}

		return $css.PHP_EOL.$fonts;
	}

	protected function addLogoCss(&$templateData, $css)
	{
		$templateData->headerLogo = @json_decode($templateData->headerLogo);
		if ($templateData->headerLogo) {
			$image = org_glizy_media_MediaManager::getMediaById($templateData->headerLogo->id);
			$fileName = $image->getFileName();
			$sizes = $image->getOriginalSizes();

			$templateData->customCss .= <<<EOD
#header #site-link {
    background: url("../{$fileName}") no-repeat ;
    width: {$sizes['width']}px;
    height: {$sizes['height']}px;
}
EOD;
		} else {
			$templateData->customCss .= <<<EOD
#header #site-link {
	background: transparent;
    text-indent: 0;
	font-size: 30px;
	font-family: @font-2;
	display: block;
	width: auto;
	height: auto;
	margin: 0 20px 20px;
	color: #fff;
}
EOD;
		}

		return $css;
	}


	protected function addCustomCss(&$templateData, $css)
	{
		$css .= PHP_EOL.$templateData->customCss;
		return $css;
	}

	protected function addCustomOutput(&$view, &$templateData)
	{
        if ($templateData->footerLogo) {
            $view->addOutputCode($templateData->footerLogo, 'logoFooter');
        }
	}

   	public function fixTemplateData(&$templateData)
	{
		// interpreta i dati del logo nel footer
		if ($templateData->footerLogo) {
			$media = json_decode($templateData->footerLogo);
			if ($media && property_exists($media, 'id')) {
				$attributes = array();
				$attributes['alt'] = $templateData->footerLogoTitle;
				$attributes['title'] = $templateData->footerLogoTitle;
				$attributes['src'] = org_glizy_helpers_Media::getFileUrlById($media->id, true);
				$templateData->footerLogo = org_glizy_helpers_Html::renderTag('img', $attributes);
				if ($templateData->footerLogoLink) {
					$templateData->footerLogo = __Link::makeSimpleLink($templateData->footerLogo, $templateData->footerLogoLink, $templateData->footerLogoTitle, '', 'external');
				}
			}
        }
	}

	protected function fixTemplateName($view)
	{
		$view->setAttribute('templateFileName', 'page.php');
	}


	public static function homeSliderImage($item)
	{
	    return 'background:url("'.$item->image['src'].'") no-repeat 0 0;';
	}
}
