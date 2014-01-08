<?php
/**
 * ------------------------------------------------------
 *	Load Library!
 *	Require all php files in the "System" directory
 * ------------------------------------------------------
 *
 *	This script checks if all the files in the System directory are .php files
 *	and then require them based on the System path that is defined in this file.
 */
	//For each file in the System directory (scandir)
	foreach( scandir(SYS_PATH) as $systemFile ) {
		// If the last 4 characters of the filename are '.php'
		if (substr($systemFile, -4) == '.php') {
			// Require the file
			require_once(SYS_PATH .'/'. $systemFile);
		}
	}