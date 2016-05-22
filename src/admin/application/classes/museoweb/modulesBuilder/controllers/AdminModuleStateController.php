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

glz_import('org.glizy.components.StateSwitchClass');

class museoweb_modulesBuilder_AdminModuleStateController extends org_glizy_components_StateSwitchClass
{
	function executeLater_import( $oldState )
	{
		// controlla se è stato fatto submit
		if ( strtolower( __Request::get( 'action', '' ) ) == 'next'  )
		{
			include( dirname( __FILE__ ) .'/libs/CVSimporter.php' );
			// sposta il file caricato nella cache

			if(isset($_FILES['mbCsvFile']) && !empty($_FILES['mbCsvFile']) && !empty($_FILES['mbCsvFile']['name']))
			{
				$file 		= $_FILES['mbCsvFile'];
				$file_path 	= $file['tmp_name'];
				$file_name 	= $file['name'];
				$file_destname 	= __Paths::getRealPath( 'CACHE' ).md5( time().$file_name );

				if ( move_uploaded_file( $file_path, $file_destname ) )
				{
					list( $tableName ) = explode('.', $this->_parent->_application->getPageType() );
					$ar = org_glizy_ObjectFactory::createModel( 'userModules.'.$tableName.'.models.'.$tableName );
					$fields = array_keys( $ar->getValuesAsArray( false, false ) );
					$csv = new CVSimporter();
					$csv->conn = org_glizy_dataAccess_DataAccess::getConnection();
					$csv->set_encoding( __Request::get( 'mbCsvEncoding' ) );
					$csv->dropTable = __Request::get( 'mbCsvDrop', '0' ) == 1;

					$csv->file_name = $file_destname;
					$csv->table_name = $tableName;
					$csv->use_csv_header = true;
					$csv->add_header_prefix = false;
				  	$csv->field_separate_char = __Request::get( 'mbCsvSeparate', ';' );
				  	$csv->field_enclose_char = __Request::get( 'mbCsvEnclose', '""' );
				  	$csv->field_escape_char = __Request::get( 'mbCsvEscape', '\\' );
					$csv->import( true, $fields );
					if ( $csv->error != "" )
					{
						$this->_parent->validateAddError( __T( 'Errore nell\'importazione del file, il formato CVS può essere errato' ) );
					}
					else
					{
						__Session::set( 'mbTable', $tableName );
						__Session::set( 'mbName', $tableName );
						$this->_parent->refreshToState( 'importConfirm' );
					}
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


	function executeLater_deleteModule( $oldState )
	{
//		echo __Request::get( 'action', '' );
		// controlla se è stato ftto submit
		if ( strtolower( __Request::get( 'action', '' ) ) == 'next'  )
		{
			$pageType = $this->_parent->_application->getPageType();
			list( $moduleName ) = explode( '.', $pageType );
			__Session::set( 'mbTable', $moduleName );
			glz_import( 'museoweb.modulesBuilder.builder.*', array( 'Builder.php', 'AbstractCommand.php' ) );
			$builder = org_glizy_ObjectFactory::createObject( 'museoweb.modulesBuilder.builder.Builder' );
			$builder->executeDelete();

			glz_import( 'org.glizy.helpers.Navigation' );
			org_glizy_helpers_Navigation::gotoUrl(__Link::makeUrl('link', array('pageId' => 'SiteMap' ) ) );
		}
	}
}


?>