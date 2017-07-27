<?php
class Template extends org_glizycms_template_fe_views_AbstractLessTemplate
{
	function __construct()
	{
		$this->path = __DIR__;
	}

	public function process($application, $view, $templateData)
    {
        $box = array(	'boxSearch' 	=> 'boxSearch',
						);
		foreach($box as $b=>$componentName) {
			$component = &$view->getComponentById($componentName);
			if (is_object($component)) {
				$component->setAttribute('enabled', !$templateData->{$b}=='0');
			}
		}

		$component = &$view->getComponentById('boxUser');
		if (is_object($component)) {
			$component->setAttribute('enabled', true);
		}
    }

	protected function applyCssVariables(&$templateData, $less, $css)
	{
		return parent::applyCssVariablesFromJson($templateData, $less, $css);
	}

	protected function applyFont(&$templateData, $css)
	{
		$font1 = $templateData->font1 == 'default' ? 'serif' : $templateData->font1;
		$font2 = $templateData->font2 == 'default' ? 'Signika' : $templateData->font2;

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
			$image = org_glizycms_mediaArchive_MediaManager::getMediaById($templateData->headerLogo->id);
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
	text-indent: 0;
	background:none;
	text-indent:0;
	width: auto;
	height: auto;
	display:block;
	font-family:@font-2;
	color:@color-logo;
	text-decoration:none;
	font-size:50px;
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
		$elements = explode(',', 'c-text,c-bg-body,c-bg-button-add,c-bg-button-reset,c-bg-header,c-bg-module-main-search,c-bg-outer,c-bg-top-bar,c-border-slider,c-box-border,c-box-border-cart,c-box-header-link,c-box-image-border,c-box-relation-item-background,c-box-relation-item-border,c-box-relation-item-link,c-box-relation-item-link-hover,c-box-text,c-color-arrow-button-slider,c-color-background-button,c-color-block-box-title,c-color-border-button,c-color-cart-button,c-color-link,c-color-logo,c-color-menu-link,c-color-menu-link-hover,c-color-sub-menu-link,c-footer-background,c-footer-border,c-footer-text,c-form-border,c-form-button,c-form-button-primary,c-form-button-text,c-form-buttonPrimary-text,c-form-input-background,c-form-required,c-icon-in-box,c-icon-in-box-background,c-metanavigation-background,c-metanavigation-background-hover,c-metanavigation-link,c-metanavigation-link-hover,c-sidebar-background,c-sidebar-background-hover,c-sidebar-border,c-slider-background,c-slider-bullet-background,c-slider-bullet-background-selected,c-slider-text,c-storyteller-background,c-storyteller-border,c-storyteller-comments-background,c-storyteller-image-border,c-storyteller-item-background,c-storyteller-link,c-storyteller-navigation-link,c-text-heading,c-timeline-theme');
		$colors = explode(',', '#000000,#CCCCCC6,#CCCCCC5,#CCCCCC,#CCCCCC6,#CCCCCC2,#CCCCCC0,#F9F9F9,#CCCCCC,#CCCCCC,#CCCCCC,#CCCCCC7,#CCCCCC,#FFFFFF,#CCCCCC,#000000,#CCCCCC,#000000,#CCCCCC0,#CCCCCC,#CCCCCC7,#CCCCCC,#FFFFFF,#000000,#CCCCCC7,#CCCCCC7,#CCCCCC7,#CCCCCC7,#CCCCCC4,#CCCCCC,#000000,#CCCCCC,#7A7A7A,#CCCCCC7,#FFFFFF,#CCCCCC0,#FFFFFF,#CCCCCC,#FFFFFF,#CCCCCC,#D8D8D8,#CCCCCC,#CCCCCC7,#CCCCCC7,#F5F5F5,#000000,#7A7A7A,#CCCCCC,#000000,#CCCCCC,#CCCCCC7,#E4E4E4,#D8D8D8,#F9F9F9,#C6C6C6,#F9F9F9,#000000,#7A7A7A,#000000,#000000');
		$numElements = count($elements);

		for ($i=0; $i<$numElements; $i++) {
			if (!property_exists($templateData, $elements[$i])) {
				$templateData->{$elements[$i]} = $colors[$i];
			}
		}

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

}