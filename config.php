<?

/**
 * @file config.php
 * @category Config files
 *
 * @author Igor Mats from Tooflya Inc.
 * @copyright (c) 2012 by Igor Mats
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License v3
 * @all rights granted under this License are granted for the term of
 * copyright on the Program, and are irrevocable provided the stated
 * conditions are met.  This License explicitly affirms your unlimited
 * permission to run the unmodified Program.  The output from running a
 * covered work is covered by this License only if the output, given its
 * content, constitutes a covered work.  This License acknowledges your
 * rights of fair use or other equivalent, as provided by copyright law.
 *
 */

/**
 *
 * Define some constants
 *
 */
define('PATH', '/var/www');
define('DEBUG', true);
define('EVENTS', true);

require('autoload.php');
require('router.php');

/**
 *
 * Turn off error display to protect ajax/json queries
 * from crashes
 * TODO: Check some variants to remove this
 *
 */
//error_reporting(0);

/**
 *
 * Starting session with custom session name
 * TODO: Create own session handler with database
 *
 */
session_name('s');
session_start();

/**
 *
 * Connecttion to the database
 * TODO: Remove connection data to the config file
 * TODO: Check about PDO
 * TODO: Think about own controller 
 *
 */
@mysql_connect("127.0.0.1", "root", "password");
mysql_select_db("base");
mysql_query("SET NAMES UTF8");

/**
 *
 * Create Smarty templator object
 * TODO: Remove this to the $templates __get or whatever...
 *
 */
$templates = new Template();

/**
 *
 * Designed specifically for using this code in projects of Tooflya Inc.
 * Tooflya Inc., 2012
 *
 * @author Igor Mats from Tooflya Inc.
 * @copyright (c) 2012 by Igor Mats
 *
 */
