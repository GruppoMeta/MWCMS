<?php

if (is_null( $_SERVER["SERVER_NAME"] )) {
    echo 'Eseguire lo script tramite browser'.PHP_EOL;
    exit;
}

$cwd = getcwd().'/..';

$folders = array (
   'cache',
   'admin/cache',
   'admin/application/config',
   'admin/application/startup',
   'application/config',
   'application/startup',
   'application/classes/userModules',
   'application/mediaArchive',
   'application/mediaArchive/Archive',
   'application/mediaArchive/Audio',
   'application/mediaArchive/Flash',
   'application/mediaArchive/Image',
   'application/mediaArchive/Office',
   'application/mediaArchive/Other',
   'application/mediaArchive/Pdf',
   'application/mediaArchive/Video'
);

$err = array();

foreach ($folders as $folder) {
    if (!is_writeable($cwd.'/'.$folder)) {
        $err[] = $folder;
    }
}

if (!empty($err)) {
    echo 'Rendere scrivibili le seguenti cartelle:'.'</br>';
    echo implode('</br>', $err).'</br>';
} else {
    echo 'Tutte le cartelle hanno i permessi corretti.'.'</br>';
}

