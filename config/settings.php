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

// Sets the program environment, true is for a live site.
define('IS_MODE_PRODUCTION', false);
// Set to true to allow debugging messages to show with the Debug class and PDO.
define('IS_MODE_DEBUG', true);
// Set to true to force re-caching on external files.
define('IS_MODE_CACHE_BUSTING', true);
// Set to false to perform install at runtime.
define('IS_MODE_INSTALLED', true);
// Set to false to populate reference tables when we install.
define('IS_MODE_POPULATED', true);
// Sets whether or not we log errors to a file.
define('IS_MODE_LOGGING', true);

// Define some error codes for common errors.
define('PAGE_NOT_FOUND', 404);

/* EOF config/settings.php */