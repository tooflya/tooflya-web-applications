<?

/**
 * @file SocialController.php
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

class SocialController extends BaseController
{

  /**
   *
   *
   *
   */
  public function indexAction($articleOrClass = false)
  {

  }

  /**
   *
   *
   *
   */
  public function getLatestTweets()
  {
    $date = new DateTime('now');

    $dateDb = new Datetime(mysql_result(mysql_query("SELECT `last` FROM `tweets_update` LIMIT 1"),0));
    $dateDb = $dateDb->getTimestamp();

    if($date->getTimestamp() - $dateDb > 300)
    {
      $url = 'http://api.twitter.com/1/statuses/user_timeline.json?screen_name=Tooflya&count=3';
      $tweets = array_reverse(json_decode(file_get_contents($url), TRUE));

      foreach($tweets as $k => $v)
      {
        mysql_query("INSERT INTO `tweets` SET `text` = '".mysql_real_escape_string($v['text'])."', `image` = '".$v['user']['profile_image_url_https']."'");
      }

      mysql_query("UPDATE `tweets_update` SET `last` = NOW() WHERE 1");
    }

    $this->templates->assign_array("SELECT * FROM `tweets` ORDER by `id` DESC LIMIT 5", 'last_tweets');
    return $this->templates->capture($this->name, "last");
  }
}

/**
 *
 * Designed specifically for using this code in projects of Tooflya Inc.
 * Tooflya Inc., 2012
 *
 * @author Igor Mats from Tooflya Inc.
 * @copyright (c) 2012 by Igor Mats
 *
 */
