<?php
require_once("../core/core.inc.php");

org_glizy_ObjectValues::set('org.glizy', 'languageId', 1);
$application = org_glizy_ObjectFactory::createObject('org.glizy.oaipmh.core.Application', '../application', '../');

$application->addMetadataFormat( 	'oai_dc',
									'http://www.openarchives.org/OAI/2.0/oai_dc.xsd',
									'http://www.openarchives.org/OAI/2.0/oai_dc/',
									'dc',
									'http://purl.org/dc/elements/1.1/');

$application->addMetadataFormat(    'pico',
                                    'http://www.culturaitalia.it/pico/schemas/1.0/pico.xsd',
                                    'http://purl.org/pico/1.0/',
                                    'pico',
                                    ''
);

museoweb_modules_pico_Module::setConfig();
museoweb_modules_pico_Module::addSets($application);
$application->run();

