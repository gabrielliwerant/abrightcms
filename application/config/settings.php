<?php

/**
 * A Bright CMS
 * 
 * Core MVC/CMS framework used in TaskVolt and created for lightweight, custom
 * web applications.
 * 
 * @package A Bright CMS
 * @author Gabriel Liwerant
 */

/**
 * Settings file sets some program environment settings.
 * 
 * Sets some constants and initial settings we'll need throughout the program to
 * help define what will happen elsewhere.
 */

// Since this constant will not be defined unless the settings file is called 
// from our main application index file (along with the rest of the application
// afterwards), we can use the lack of this constant definition to prevent 
// direct file access. The actual value used here is irrelevant.
define('DENY_ACCESS', true);

// Domain name defined here, used for pathing
define('DOMAIN_NAME', 'abrightcms');

// Sets the program environment, false is for development.
define('IS_MODE_PRODUCTION', false);

// Set to true to allow debugging messages to show with the Debug class and PDO.
// Also affects our level of error reporting.
define('IS_MODE_DEBUG', true);

// Set to true to force re-caching on external files.
// An empty value forces creation of a random string if we're set to cache bust,
// otherwise we can use a defined value here for versioning.
define('IS_MODE_CACHE_BUSTING', true);
define('CACHE_BUSTING_VALUE', null);	// 01072013

// Sets whether or not we log errors to a file.
define('IS_MODE_LOGGING', true);

// Defines the way we store and retrieve data from our model for our page views.
// The name set here must also be the name of our storage class.
define('STORAGE_TYPE', 'json');			// json | xml

// Will determine whether we load a database object into our model or null.
define('HAS_DATABASE', false);

// Sets whether or not we run concatenator for files we're combining in config.
define('DOES_CONCATENATE', false);
define('CONCATENATE_TYPE', 'js');		// css | js

// Set values for inbound emails sent from the server.
define('EMAIL_ADDRESS', 'gabriel@abrightconcept.com');
$headers	= "MIME-Version: 1.0\r\n"
			. "Content-type: text/html;"
			. "charset=iso-8859-1\r\n";
define("EMAIL_HEADERS", $headers);

// Set the default time zone for PHP date functionsf
define('DEFAULT_TIME_ZONE', 'America/New_York');

/* EOF application/config/settings.php */