<?php
class museoweb_modules_pico_controllers_Step2 extends org_glizy_mvc_core_Command
{
    public function execute()
    {
        // controlla se è stato ftto submit
        if(isset($_FILES['myFile']) && !empty($_FILES['myFile']) && !empty($_FILES['myFile']['name']))
        {
            $file       = $_FILES['myFile'];
            $file_path  = $file['tmp_name'];
            $file_name  = $file['name'];

            $file_destname = org_glizy_Paths::getRealPath('CACHE_CODE').'/thesaurus.xml';

            @unlink( $file_destname );
            if ( move_uploaded_file( $file_path, $file_destname ) )
            {
                $thesaurusParser = org_glizy_ObjectFactory::createObject( 'museoweb.modules.pico.thesaurus.Parser' );
                $thesaurusParser->parse();
                // $this->view->refreshToState( 'step2' );
            }
            else
            {
                // errore
                $this->view->validateAddError( __T( 'Errore nel caricamento del file, verificare i permessi in scrittura sulla cartella "pico"' ) );
                org_glizy_helpers_Navigation::goHere();
            }
            @unlink( $file_destname );
        }
        else
        {
            // errore
            $this->view->validateAddError( __T( 'Errore nel caricamento del file' ) );
            org_glizy_helpers_Navigation::goHere();
        }
    }
}