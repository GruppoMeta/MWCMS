<?php
include( '../application/startup/mwcms.php' );

glz_loadLocale('museoweb.*');

museoweb_modules_pico_Module::registerModule();
museoweb_modulesBuilder_Module::registerModule();
