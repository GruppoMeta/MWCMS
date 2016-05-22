<?php
/**
 * This file is part of the GLIZY framework.
 * Copyright (c) 2005-2012 Daniele Ugoletti <daniele.ugoletti@glizy.com>
 *
 * For the full copyright and license information, please view the COPYRIGHT.txt
 * file that was distributed with this source code.
 */

class org_glizy_helpers_FileServe
{
	static public function serve($fileName, $originalFileName=null, $forceDownload=false)
	{
		$mime = !$forceDownload ? org_glizy_helpers_FileServe::mimeType($fileName) : 'application/force-download';
		$fileSize = filesize($fileName);
		$gmdate_mod = gmdate('D, d M Y H:i:s', filemtime($fileName) );
		if(! strstr($gmdate_mod, 'GMT')) {
			$gmdate_mod .= ' GMT';
		}

	    header('Content-Type: ' . $mime);
	    header('Content-Length: ' . $fileSize);
		header('Last-Modified: ' . $gmdate_mod);
		if ($originalFileName) {
			header('Content-Transfer-Encoding: binary');
		    header('Content-Disposition: attachment; filename=' . $originalFileName);
	    }

	    @ob_end_clean();
	    @ob_end_flush();
	    readfile($fileName);
	    exit;
	}

	static public function mimeType($fileName)
	{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		return finfo_file($finfo, $fileName);
	}
}


// http://stackoverflow.com/questions/2000715/answering-http-if-modified-since-and-http-if-none-match-in-php
// http://stackoverflow.com/questions/14661637/allowing-caching-of-image-php-until-source-has-been-changed
// http://www.coneural.org/florian/papers/04_byteserving.php

