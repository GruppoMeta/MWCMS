<?php
class museoweb_modules_iccd_controllers_Import extends org_glizy_mvc_core_Command
{
    public function execute($moduleName)
    {
        if (!empty($_FILES['xsdFile']) && !empty($_FILES['xsdFile']['name'])) {
            $file 		= $_FILES['xsdFile'];
			$file_path 	= $file['tmp_name'];
			$file_name 	= $file['name'];
			$xsdFile    = __Paths::getRealPath( 'CACHE' ).md5( time().$file_name );

            try  {
                if (!move_uploaded_file( $file_path, $xsdFile )) {
                    throw new Exception('Errore nel caricamento del file:'.$file_name);
                }

                if (!empty($_FILES['xmlFileRequired']) && !empty($_FILES['xmlFileRequired']['name'])) {
                    $file 		= $_FILES['xmlFileRequired'];
				    $file_path 	= $file['tmp_name'];
        			$file_name 	= $file['name'];
        			$xmlFileRequired    = __Paths::getRealPath( 'CACHE' ).md5( time().$file_name );

                    if (!move_uploaded_file( $file_path, $xmlFileRequired )) {
                        throw new Exception('Errore nel caricamento del file'.$file_name);
                    }
                }

                $xsdParser = org_glizy_ObjectFactory::createObject('museoweb.modules.iccd.services.XSDParser');
                $elements = $xsdParser->parseFile($xsdFile, $xmlFileRequired, $moduleName);
                $htmlElements = $xsdParser->makeHtmlElements();
                $fieldsAttributes = $xsdParser->getFieldsAttributes();

                $moduleBuilder = org_glizy_ObjectFactory::createObject('museoweb.modules.iccd.services.ModuleBuilder');
                $moduleBuilder->createModule($moduleName, $elements, $htmlElements, $fieldsAttributes);

                $this->logAndMessage('Modulo creato correttamente.');
            } catch (Exception $e) {
        		$this->logAndMessage($e->getMessage(), '', true);
            }
        } else {
    		$this->logAndMessage('Selezionare un file XSD', '', true);
        }
    }
}