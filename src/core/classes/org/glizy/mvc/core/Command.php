<?php
/**
 * This file is part of the GLIZY framework.
 * Copyright (c) 2005-2012 Daniele Ugoletti <daniele.ugoletti@glizy.com>
 *
 * For the full copyright and license information, please view the COPYRIGHT.txt
 * file that was distributed with this source code.
 */

/**
 * Class org_glizy_mvc_core_Command
 */
class org_glizy_mvc_core_Command extends GlizyObject
{
    /** @var org_glizy_components_Component $controller */
	protected $controller = NULL;
	/** @var org_glizy_components_Component $view */
	protected $view = NULL;
	/** @var org_glizy_mvc_core_Application $application */
	protected $application = NULL;
	/** @var org_glizy_application_User $user */
	protected $user = NULL;

	/**
	 * @param org_glizy_mvc_components_Component $view
	 * @param org_glizy_mvc_core_Application $application
	 */
	function __construct( $view=NULL, $application=NULL )
	{
		$this->controller = $view;
		$this->view = $view;
		$this->application = is_null( $application ) && !is_null( $view ) ? $view->_application : $application;
		$this->user = &$this->application->getCurrentUser();
	}

	function execute( $oldAction=null )
	{
	}

	function changePage( $routingName, $option=array(), $addParam=array() )
	{
		$url = __Link::makeUrl( $routingName, $option, $addParam );
		org_glizy_helpers_Navigation::gotoUrl( $url );
	}

	function changeAction( $action )
	{
		$url = __Link::makeUrl( 'linkChangeAction', array( 'action' => $action ) );
		org_glizy_helpers_Navigation::gotoUrl( $url );
	}

	function goHere($params=null, $hash='')
	{
		org_glizy_helpers_Navigation::gotoUrl( __Routing::scriptUrl(), $params, $hash);
	}

	function changeBackPage()
	{
		$url = __Session::get( '__backUrl__', '' );
		org_glizy_helpers_Navigation::gotoUrl( $url );
	}


	function setComponentsVisibility( $components, $state )
	{
		$this->setComponentsAttribute( $components, 'visible', $state );
	}

	function setComponentsAttribute( $components, $attribute, $state, $merge = false )
	{
		$components = is_array( $components ) ? $components : array( $components );
		foreach( $components as $v )
		{
			$c = $this->view->getComponentById( $v );
			if ( is_object( $c ) )
			{
				$c->setAttribute( $attribute, $state, $merge);
			}
		}
	}
}