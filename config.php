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
 * Turn off error display to protect ajax/json queries
 * from crashes
 * TODO: Check some variants to remove this
 *
 */
error_reporting(0);


/**
 *
 * Setting default timezone
 *
 */
date_default_timezone_set('Europe/Kyiv');

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
mysql_connect("127.0.0.1", "root", "password") or die("Could not connect to mysql server");
mysql_select_db("www.tooflya.com") or die("Could not select database");
mysql_query("SET NAMES UTF8");

/**
 *
 * Define some constants
 *
 */
define('PATH', 'D:/Server/tooflya.com/www/');
define('DEBUG', true);
define('EVENTS', true);
define('URL', (isset($_SERVER['HTTPS']) ? 'https://' : 'http://').'www.tooflya.com');
define('SUBSCRIBERS_COUNT', 10043);

require('autoload.php');
require('router.php');

/**
 *
 * Designed specifically for using this code in projects of Tooflya Inc.
 * Tooflya Inc., 2012
 *
 * @author Igor Mats from Tooflya Inc.
 * @copyright (c) 2012 by Igor Mats
 *
 */
