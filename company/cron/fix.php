<?

/**
 * @file CorpCommunityController.php
 * @category Controller
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

require('../../config.php');
print 1;
$sid = mysql_result(mysql_query("SELECT `id` FROM `corp_sprints` WHERE NOW() BETWEEN `start` AND `end` LIMIT 1"), 0);

$users = mysql_query("SELECT * FROM `corp_users`");

while($data = mysql_fetch_assoc($users))
{
  $uid = $data['id'];

  if(mysql_num_rows(mysql_query("SELECT * FROM `corp_sprints_results` WHERE `uid` = '$uid' AND `sid` = '$sid'")) <= 0)
  {
    $totalPointsOnTheSprint = mysql_result(mysql_query("SELECT SUM(`points`) FROM `corp_tasks_requirements` WHERE `tid` IN (SELECT `id` FROM `corp_tasks` WHERE `receiver` = '$uid' AND `sprint` = '$sid')"), 0);
    $totalEarnedPoints = mysql_result(mysql_query("SELECT SUM(`points`) FROM `corp_tasks_requirements` WHERE `tid` IN (SELECT `id` FROM `corp_tasks` WHERE `receiver` = '$uid' AND `sprint` = '$sid' AND `status` = '6')"), 0);

    $progress = round($totalEarnedPoints / $totalPointsOnTheSprint * 100);

    if(!$totalEarnedPoints || $totalEarnedPoints < 0) $totalEarnedPoints = 0;

    mysql_query("INSERT INTO `corp_sprints_results` SET
      `uid` = '$uid',
      `sid` = '$sid',
      `value` = '$progress',
      `points` = '$totalEarnedPoints'") or die(mysql_error());

    $nsid = $sid + 1;

    mysql_query("UPDATE `corp_tasks` SET `status` = '7' WHERE `status` = '6' AND `receiver` = '$uid'");
    mysql_query("UPDATE `corp_tasks` SET `sprint` = '$nsid' WHERE `status` < '6' AND `receiver` = '$uid'");

    mysql_query("INSERT INTO `corp_sprints_fixes` SET
      `uid` = '$uid',
      `sid` = '$nsid',
      `value` = (SELECT SUM(`points`) FROM `corp_tasks_requirements` WHERE `tid` IN (SELECT `id` FROM `corp_tasks` WHERE `receiver` = '$uid' AND `sprint` = '$sid'))");
  }
}
