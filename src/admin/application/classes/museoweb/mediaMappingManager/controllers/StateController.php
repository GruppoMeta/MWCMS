<?php
glz_import( 'org.glizy.components.StateSwitchClass' );

class museoweb_mediaMappingManager_controllers_StateController extends org_glizy_components_StateSwitchClass
{
    function executeLater_edit( $oldState )
    {
        $application = org_glizy_ObjectValues::get('org.glizy', 'application' );
        $mappingService = $application->retrieveProxy('org.glizycms.mediaArchive.services.MediaMappingService');
                
        if ( strtolower( __Request::get( 'action', '' ) ) == 'save' ) {
            if ($this->_parent->validate()) {
                $mappingService->setMapping(__Request::get('folderName'), __Request::get('filesystemPath'));
            }
            
            $this->_parent->refreshToState( 'reset' );
        } else {
            $folderName = __Request::get('dataGridEdit_recordId');
            $c = $this->_parent->getComponentById('folderName');
            $c->setText($folderName);
            $c = $this->_parent->getComponentById('filesystemPath');
            $c->setText($mappingService->getMapping($folderName));
        }
    }
    
    function executeLater_add( $oldState )
    {
        if ( strtolower( __Request::get( 'action', '' ) ) == 'save' )
        {
            if ($this->_parent->validate()) {
                $application = org_glizy_ObjectValues::get('org.glizy', 'application' );
                $mappingService = $application->retrieveProxy('org.glizycms.mediaArchive.services.MediaMappingService');
                $mappingService->setMapping(__Request::get('folderName'), __Request::get('filesystemPath'));
            }
            
            $this->_parent->refreshToState( 'reset' );
        }
    }
    
    function execute_delete( $oldState )
    {
        $folderName = __Request::get('dataGridEdit_recordId');
        
        if ($folderName) {
            $application = org_glizy_ObjectValues::get('org.glizy', 'application' );
            $mappingService = $application->retrieveProxy('org.glizycms.mediaArchive.services.MediaMappingService');
            $mappingService->deleteMapping($folderName);
            
            $this->_parent->refreshToState( 'reset' );
        }
    }
}
