<?php
class museoweb_modulesBuilder_controllers_DeleteModule extends org_glizy_mvc_core_Command
{
	function execute()
	{
 		if (__Request::exists('next')) {
			$pageType = $this->application->getPageType();
			list( $moduleName ) = explode( '.', $pageType );
			__Request::set( 'mbTable', $moduleName );
			$builder = org_glizy_ObjectFactory::createObject( 'museoweb.modulesBuilder.builder.Builder' );
			$builder->executeDelete();

			org_glizy_helpers_Navigation::gotoUrl(__Link::makeUrl('link', array('pageId' => 'glizycms_contentsedit' ) ) );
		}
	}
}
