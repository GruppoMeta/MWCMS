<?php
class museoweb_modules_mag_controllers_Import extends org_glizy_mvc_core_Command
{
    function execute($moduleId, $folder)
    {
        if ($this->user->isLogged()) {
            if ($folder && $moduleId) {
                $application = org_glizy_ObjectValues::get('org.glizy', 'application' );
                $mappingService = $application->retrieveProxy('org.glizycms.mediaArchive.services.MediaMappingService');
                $folder = $mappingService->getPathFromMapping($folder);
                $files = glob($folder.'/*');
                $i = 0;
                foreach ($files as $file) {
                    if($this->importFile($file, $moduleId)) $i++;
                }
                $this->logAndMessage( $i." ".__T( 'file importati' ) );
            }
        }
    }

    function importFile($file, $moduleId = 0000000000)
    {
        $xml = new DomDocument();
        $xml->load($file);

        $data = new StdClass;
        $data->ref_id = 0;
        $data->ref_model_id = '';

        $gen = $xml->getElementsByTagName("gen")->item(0);
        if($gen) {
            $data->gen_creation = str_replace('T', ' ', $gen->getAttribute('creation'));
            $data->mag_stprog = $xml->getElementsByTagName("stprog")->item(0)->nodeValue;
            $data->mag_collection = $xml->getElementsByTagName("collection")->item(0)->nodeValue;
            $data->mag_agency = $xml->getElementsByTagName("agency")->item(0)->nodeValue;
            $data->mag_access_rights = $xml->getElementsByTagName("access_rights")->item(0)->nodeValue;
            $data->mag_completeness = $xml->getElementsByTagName("completeness")->item(0)->nodeValue;
        }

        $bibNode = $xml->getElementsByTagName("bib")->item(0);
        if($bibNode) {
            $data->dc_identifier = $bibNode->getElementsByTagName("identifier")->item(0)->nodeValue;
            $data->dc_title = $bibNode->getElementsByTagName("title")->item(0)->nodeValue;
            $data->dc_creator = $bibNode->getElementsByTagName("creator")->item(0)->nodeValue;
            $data->dc_publisher = $bibNode->getElementsByTagName("publisher")->item(0)->nodeValue;
            $data->dc_date = $bibNode->getElementsByTagName("date")->item(0)->nodeValue;
            $data->dc_type = $bibNode->getElementsByTagName("type")->item(0)->nodeValue;
            $data->dc_format = $bibNode->getElementsByTagName("format")->item(0)->nodeValue;
            $data->dc_language = $bibNode->getElementsByTagName("language")->item(0)->nodeValue;
            $data->mag_library = $bibNode->getElementsByTagName("library")->item(0)->nodeValue;
            $data->mag_inventory_number = $bibNode->getElementsByTagName("inventory_number")->item(0)->nodeValue;
            $data->mag_year = $bibNode->getElementsByTagName("year")->item(0)->nodeValue;
            $data->mag_issue = $bibNode->getElementsByTagName("issue")->item(0)->nodeValue;
            $data->mag_stpiece_per = $bibNode->getElementsByTagName("stpiece_per")->item(0)->nodeValue;
        }

        $imgGroupsNodes = $gen->getElementsByTagName("img_group");
        if($imgGroupsNodes) {
            $imgGroups = array();
            foreach($imgGroupsNodes as $imgGroup) {
                $imgGroupData = new StdClass();
                $imgGroupData->niso_samplingfrequencyunit = $imgGroup->getElementsByTagName("samplingfrequencyunit")->item(0)->nodeValue;
                $imgGroupData->niso_samplingfrequencyplane = $imgGroup->getElementsByTagName("samplingfrequencyplane")->item(0)->nodeValue;
                $imgGroupData->niso_xsamplingfrequency = $imgGroup->getElementsByTagName("xsamplingfrequency")->item(0)->nodeValue;
                $imgGroupData->niso_ysamplingfrequency = $imgGroup->getElementsByTagName("ysamplingfrequency")->item(0)->nodeValue;
                $imgGroupData->niso_photometricinterpretation = $imgGroup->getElementsByTagName("photometricinterpretation")->item(0)->nodeValue;
                $imgGroupData->niso_bitpersample = $imgGroup->getElementsByTagName("bitpersample")->item(0)->nodeValue;
                $imgGroupData->niso_name = $imgGroup->getElementsByTagName("name")->item(0)->nodeValue;
                $imgGroupData->niso_mime = $imgGroup->getElementsByTagName("mime")->item(0)->nodeValue;
                $imgGroupData->niso_compression= $imgGroup->getElementsByTagName("compression")->item(0)->nodeValue;
                $imgGroupData->niso_sourcetype = $imgGroup->getElementsByTagName("sourcetype")->item(0)->nodeValue;
                $imgGroupData->niso_scanningagency = $imgGroup->getElementsByTagName("scanningagency")->item(0)->nodeValue;
                $imgGroupData->niso_devicesource = $imgGroup->getElementsByTagName("devicesource")->item(0)->nodeValue;
                $imgGroupData->niso_scanner_manufacturer = $imgGroup->getElementsByTagName("scanner_manufacturer")->item(0)->nodeValue;
                $imgGroupData->niso_scanner_model = $imgGroup->getElementsByTagName("scanner_model")->item(0)->nodeValue;
                $imgGroupData->niso_capture_software = $imgGroup->getElementsByTagName("capture_software")->item(0)->nodeValue;
                $imgGroupData->niso_targetType = $imgGroup->getElementsByTagName("targetType")->item(0)->nodeValue;
                $imgGroupData->niso_targetID = $imgGroup->getElementsByTagName("targetID")->item(0)->nodeValue;
                $imgGroupData->niso_imageData = $imgGroup->getElementsByTagName("imageData")->item(0)->nodeValue;
                $imgGroupData->niso_performanceData = $imgGroup->getElementsByTagName("performanceData")->item(0)->nodeValue;
                $imgGroupData->niso_profiles = $imgGroup->getElementsByTagName("profiles")->item(0)->nodeValue;
                $imgGroups[$imgGroup->getAttribute('ID')] = $imgGroupData;
            }
        }

        $images = $xml->getElementsByTagName("img");
        if($images) {
            $imgData = new StdClass();
            foreach($images as $image) {
                $sequence = $image->getElementsByTagName("sequence_number")->item(0)->nodeValue;
                $this->fillImageFields($imgData, $imgGroups, $image, $sequence, NULL);
                $altImages = $image->getElementsByTagName("altimg");
                if($altImages) {
                    foreach ($altImages as $altImage) {
                        $this->fillImageFields($imgData, $imgGroups, $altImage, NULL, $sequence);
                    }
                }
            }
            $data->img = $imgData;
        }


        $docs = $xml->getElementsByTagName("doc");
        if($docs) {
            $docData = new StdClass();
            foreach($docs as $doc) {
                $docData->dmag_datetimecreated[] = str_replace('T', ' ', $doc->getElementsByTagName("datetimecreated")->item(0)->nodeValue);
                $docData->dmag_sequence_number[] = $doc->getElementsByTagName("sequence_number")->item(0)->nodeValue;
                $docData->dmag_nomenclature[] = $doc->getElementsByTagName("nomenclature")->item(0)->nodeValue;
                $docData->dmag_usage[] = $doc->getElementsByTagName("usage")->item(0)->nodeValue;
                $docData->dmag_side[] = $doc->getElementsByTagName("side")->item(0)->nodeValue;
                $docData->dmag_file_href[] = $doc->getElementsByTagName("file")->item(0)->getAttribute('xlink:href');
                $docData->dmag_md5[] = $doc->getElementsByTagName("md5")->item(0)->nodeValue;
                $docData->dmag_filesize[] = $doc->getElementsByTagName("filesize")->item(0)->nodeValue;
                $docData->dniso_name[] = $doc->getElementsByTagName("name")->item(0)->nodeValue;
                $docData->dniso_mime[] = $doc->getElementsByTagName("mime")->item(0)->nodeValue;
                $docData->dniso_compression[] = $doc->getElementsByTagName("compression")->item(0)->nodeValue;
            }

            $data->doc = $docData;
        }



        $magProxy = org_glizy_ObjectFactory::createObject('museoweb.modules.mag.models.proxy.MagProxy');
        $mapping = $magProxy->getMapping($moduleId);
        if(isset($mapping['dc_identifier'])) {
            $it = org_glizy_ObjectFactory::createModelIterator($moduleId);
            $it->setFilters(array($mapping['dc_identifier'] => $data->dc_identifier));
            if($it->count()) {
                $ar = $it->current();
                $data->path = $moduleId;
                $data->text = $data->dc_identifier;
                $data->ref_model_id = $moduleId;
                $data->ref_id = $moduleId.":".$ar->document_id.":".$this->application->getEditingLanguageId();
            }
        }
        $data->__model = 'museoweb.modules.mag.models.Model';
        $contentproxy = org_glizy_objectFactory::createObject('org.glizycms.contents.models.proxy.ModuleContentProxy');
        $result = $contentproxy->saveContent($data);
        return $result;
    }

    private function fillImageFields(&$imgData, $imgGroups, $img, $sequence, $parent ) {
        $href = $img->getElementsByTagName("file")->item(0)->getAttribute('xlink:href');
        $imgData->mag_sequence_number[] = $sequence;
        $imgData->parentSequenceNumber[] = $parent;
        $imgData->img_id[] = '';
        $imgData->importMode[] = 'free';
        $imgData->img_name[] = end(explode('/',$href));
        $imgData->mag_datetimecreated[] = str_replace('T', ' ', $img->getElementsByTagName("datetimecreated")->item(0)->nodeValue);
        $imgData->mag_nomenclature[] = $img->getElementsByTagName("nomenclature")->item(0)->nodeValue;
        $imgData->mag_usage[] = $img->getElementsByTagName("usage")->item(0)->nodeValue;
        $imgData->mag_side[] = $img->getElementsByTagName("side")->item(0)->nodeValue;
        $imgData->mag_file_href[] = $href;
        $imgData->mag_md5[] = $img->getElementsByTagName("md5")->item(0)->nodeValue;
        $imgData->mag_filesize[] = $img->getElementsByTagName("filesize")->item(0)->nodeValue;
        $imgData->niso_imagelength[] = $img->getElementsByTagName("imagelength")->item(0)->nodeValue;
        $imgData->niso_imagewidth[] = $img->getElementsByTagName("imagewidth")->item(0)->nodeValue;

        $imgGroup = $imgGroups[$img->getAttribute('imggroupID')];

        $imgData->niso_source_xdimension[] = $imgGroup->niso_source_xdimension;
        $imgData->niso_source_ydimension[] = $imgGroup->niso_source_ydimension;
        $imgData->niso_samplingfrequencyunit[] = $imgGroup->niso_samplingfrequencyunit;
        $imgData->niso_samplingfrequencyplane[] = $imgGroup->niso_samplingfrequencyplane;
        $imgData->niso_xsamplingfrequency[] = $imgGroup->niso_xsamplingfrequency;
        $imgData->niso_ysamplingfrequency[] = $imgGroup->niso_ysamplingfrequency;
        $imgData->niso_photometricinterpretation[] = $imgGroup->niso_photometricinterpretation;
        $imgData->niso_bitpersample[] = $imgGroup->niso_bitpersample;
        $imgData->niso_name[] = $imgGroup->niso_name;
        $imgData->niso_mime[] = $imgGroup->niso_mime;
        $imgData->niso_compression[] = $imgGroup->niso_compression;
        $imgData->niso_sourcetype[] = $imgGroup->niso_sourcetype;
        $imgData->niso_scanningagency[] = $imgGroup->niso_scanningagency;
        $imgData->niso_devicesource[] = $imgGroup->niso_devicesource;
        $imgData->niso_scanner_manufacturer[] = $imgGroup->niso_scanner_manufacturer;
        $imgData->niso_scanner_model[] = $imgGroup->niso_scanner_model;
        $imgData->niso_capture_software[] = $imgGroup->niso_capture_software;
        $imgData->niso_targetType[] = $imgGroup->niso_targetType;
        $imgData->niso_targetID[] = $imgGroup->niso_targetID;
        $imgData->niso_imageData[] = $imgGroup->niso_imageData;
        $imgData->niso_performanceData[] = $imgGroup->niso_performanceData;
        $imgData->niso_profiles[] = $imgGroup->niso_profiles;
    }
}
