<?php
/* SVN FILE: $Id: RoutesController.php 234 2009-02-19 08:30:19Z ugoletti $ */

/**
 * @copyright Copyright(c) 2005-2009 Ministero per i beni e le attività culturali. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * Museo & Web CMS is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 *
 * @author		Daniele Ugoletti <daniele@ugoletti.com>, Gruppo Meta <http://www.gruppometa.it>
 * @package		Museo&Web CMS
 * @category	Component
 */


class museoweb_modulesBuilder_controllers_StateController extends org_glizy_components_StateSwitchClass
{
	/**
	 * Submit dello step2D, è stata scelta la tabella
	 *
	 * @param string $oldState
	 * @return void
	 */
	function executeLater_step2Csv( $oldState )
	{
		// controlla se è stato ftto submit
		if ( strtolower( __Request::get( 'action', '' ) ) == 'next' )
		{
			// sposta il file caricato nella cache
			if(isset($_FILES['mbCsvFile']) && !empty($_FILES['mbCsvFile']) && !empty($_FILES['mbCsvFile']['name']))
			{
				$file 		= $_FILES['mbCsvFile'];
				$file_path 	= $file['tmp_name'];
				$file_name 	= $file['name'];
				$file_destname 	= __Paths::getRealPath( 'CACHE' ).md5( time().$file_name ).'.csv';

				if ( move_uploaded_file( $file_path, $file_destname ) )
				{
					$moduleName = explode('.', $file_name );
	                $options = array(
	                    'filePath' => $file_destname,
	                    'enclosure' => __Request::get( 'mbCsvEnclose', ';' ),
	                    'delimiter' => __Request::get( 'mbCsvSeparate', ';' )
	                );
					$this->_parent->refreshToState( 'step3',
							array(	'mbTable' => $this->getModuleName($moduleName[0]),
									'mbTableDB' => __Request::get('table'),
									'mbName' => $moduleName[0],
									'mbModuleType' => 'csv',
									'mbCsvOptions' => $options
								));
				}
				else
				{
					// errore
					$this->_parent->validateAddError( __T( 'Errore nel caricamento del file' ) );
				}

				@unlink( $file_destname );
			}
			else
			{
				// errore
				$this->_parent->validateAddError( __T( 'Errore nel caricamento del file' ) );
			}

		}
	}

	/**
	 * Submit dello step2D, è stata scelta la tabella
	 *
	 * @param string $oldState
	 * @return void
	 */
	function executeLater_step2DB( $oldState )
	{
		// controlla se è stato ftto submit
		if ( strtolower( __Request::get( 'action', '' ) ) == 'next' )
		{
			// controlla la validità della form
			if ( $this->_parent->validate() )
			{
				$this->_parent->refreshToState( 'step3',
							array(	'mbTable' => $this->getModuleName(__Request::get('table')),
									'mbTableDB' => __Request::get('table'),
									'mbName' => __Request::get('table'),
									'mbModuleType' => 'db'
								));
			}
		}
	}

	function execute_step3( $oldState )
	{
		if ( strtolower( __Request::get( 'action', '' ) ) != 'next' )
		{
			// in fase di modifica il nome del modulo
			// viene passato in get
			if ( __Request::exists( 'mbTable' ) && __Request::exists( 'mbName' ) && __Request::exists( 'mod' ))
			{
				// cambia il tiolo della pagina
				$c = $this->_parent->getComponentById( "pageTitle" );
				$c->setAttribute( 'value', __T( 'Modifica modulo' ) );
				$c->process();

				// imposta altri valori dal file info
				$builder = org_glizy_ObjectFactory::createObject( 'museoweb.modulesBuilder.builder.Builder' );
				$values = file_get_contents( $builder->getCustomModulesFolder().'/Info' );
				$values = unserialize( $values );
				__Request::set( 'fieldOrder', $values[ 'fieldOrder' ] );
				__Request::set( 'fieldRequired', $values[ 'fieldRequired' ] );
				__Request::set( 'fieldType', $values[ 'fieldType' ] );
				__Request::set( 'fieldSearch', $values[ 'fieldSearch' ] );
				__Request::set( 'fieldListSearch', $values[ 'fieldListSearch' ] );
				__Request::set( 'fieldAdmin', $values[ 'fieldAdmin' ] );
				__Request::set( 'fieldLabel', $values[ 'fieldLabel' ] );
				__Request::set( 'mbModuleType', isset($values[ 'mbModuleType' ]) ? $values[ 'mbModuleType' ] : 'document' );
				__Request::set( 'mbTableDB', $values[ 'tableDb' ] );
				}
		}
	}

	function executeLater_step3( $oldState )
	{
		// controlla se è stato fatto submit
		if ( strtolower( __Request::get( 'action', '' ) ) == 'next' )
		{
			// controlla la validità della form
			if ( $this->_parent->validate() )
			{
				$fieldOrder = __Request::get( 'fieldOrder' );
				$fieldSearch = __Request::get( 'fieldSearch' );
				$fieldListSearch = __Request::get( 'fieldListSearch' );
				$fieldAdmin = __Request::get( 'fieldAdmin' );

				$error = false;
				if ( is_null( $fieldSearch ) )
				{
					$error = true;
					$this->_parent->validateAddError( __T( 'Specificare i campi per la ricerca' ) );
				}
				if ( !$error && is_null( $fieldListSearch ) )
				{
					$error = true;
					$this->_parent->validateAddError( __T( 'Specificare i campi per il risultato della ricerca' ) );
				}
				if ( !$error && is_null( $fieldAdmin ) )
				{
					$error = true;
					$this->_parent->validateAddError( __T( 'Specificare i campi per la lista in amministrazione' ) );
				}

				if ( !$error )
				{
					__Request::set( 'fieldName', explode( ',', $fieldOrder ) );
					$builder = org_glizy_ObjectFactory::createObject( 'museoweb.modulesBuilder.builder.Builder' );
					$builder->execute();

					$this->_parent->refreshToState( 'step4' );
				}
			}
		}
	}

	function executeLater_step3new( $oldState )
	{
		// controlla se è stato fatto submit
		if ( strtolower( __Request::get( 'action', '' ) ) == 'next' )
		{
				$fieldOrder = __Request::get( 'fieldOrder' );
				__Request::set( 'fieldName', explode( ',', $fieldOrder ) );
				$mbName = __Request::get( 'mbName' );
				__Request::set( 'mbTable', $this->getModuleName($mbName) );
				__Request::set( 'mbModuleType', 'document');

				$builder = org_glizy_ObjectFactory::createObject( 'museoweb.modulesBuilder.builder.Builder' );
				$builder->execute();
				$this->_parent->refreshToState( 'step4' );
		}
	}

	private function getModuleName($mbTable)
	{
		return strtolower( str_replace( array( '_', ' ', ')', '(', '/', '\\' ), '', $mbTable ) ).''.uniqid();
	}
}