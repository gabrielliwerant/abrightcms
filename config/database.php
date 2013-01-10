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
 * Database file
 * 
 * Contains the database settings and constants for the program depending upon 
 * whether or not we are in production mode.
 */

if ( ! IS_MODE_PRODUCTION)
{
	define('DB_TYPE', 'mysql');
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'abrightcms');
	define('DB_USER', 'Gabriel');
    define('DB_PASS', 'Liwerant');
}
else
{
	define('DB_TYPE', 'mysql');
	define('DB_HOST', '');
	define('DB_NAME', '');
	define('DB_USER', '');
    define('DB_PASS', '');
}

// Some database settings used consistently in creating tables during install
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');

// Defines our database error message when not using PDO
define('DB_ERR_MSG', 'Error Connecting to Database');

/* EOF config/database.php */