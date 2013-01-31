<?

/**
 * @file index.php
 * @category Executable files
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
//error_reporting(0);

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

switch($_GET['action']) {
	case 'get_rating':
		$score = intval($_GET['score']);
		$name = mysql_real_escape_string(trim($_GET['name']));

		mysql_query("UPDATE `bubblefun_rating` SET `score` = '$score' WHERE `name` = '$name'");
		
		$array = array();

		$query = mysql_query("SELECT * FROM `bubblefun_rating` GROUP by `name` ORDER by `score` DESC");

		$i = 0;
		while($result=mysql_fetch_assoc($query))
		{
			$array[$i] = array("name" => $result['name'], "score" => $result['score']);

			$i++;
		}
		

		print json_encode(array("response" => $array));
	break;

	case 'upd_rating':
		$score = intval($_GET['score']);
		$name = mysql_real_escape_string(trim($_GET['name']));

		mysql_query("UPDATE `bubblefun_rating` SET `score` = '$score' WHERE `name` = '$name'");

		print 1;
	break;
}

/**
 *
 * Designed specifically for using this code in projects of Tooflya Inc.
 * Tooflya Inc., 2013
 *
 * @author Igor Mats from Tooflya Inc.
 * @copyright (c) 2013 by Igor Mats
 *
 */
