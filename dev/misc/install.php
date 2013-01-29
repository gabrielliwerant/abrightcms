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
 * Database and table schema install file.
 * 
 * This file creates the database and all the tables at the outset for the 
 * program needed to run, including setting the constraints. It also serves as 
 * referemce to the setup of the database schema.
 */

/**
 * Create new table
 */
$create_table = "";

$db->query($create_table);

/* EOF install.php */