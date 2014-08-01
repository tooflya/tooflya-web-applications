<?

/**
 * @file PressController.php
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

class GamesController extends BaseController {

  /**
   *
   *
   *
   */
  function __construct()
  {
    parent::__construct();

    mysql_select_db("games.tooflya.com") or die("Could not select database");
  }

  /**
   *
   *
   *
   */
  public function indexAction($id = false, $api = false)
  {
    $this->templates->assign('url', (isset($_SERVER['HTTPS']) ? 'https://' : 'http://').'games.tooflya.com');

    if($id)
    {
      if($this->isGameAvailable($id))
      {
        if($api)
        {
          // Do nothing;
        }
        else
        {
          $this->assignGame($id);

          $this->templates->assign(TITLE, 'Our Games'); // TODO: Change page title.
          $this->templates->display($this->name, 'game');
        }
      }
      else
      {
        $controller = new ErrorController();
        $controller->notFound();
      }
    }
    else
    {
      if(Ajax::isResponse())
      {
        $this->getExtendedInfo();

        $this->templates->display($this->name, 'games');
      }
      else
      {
        $this->getBaseInfo();

        $this->templates->display($this->name);
      }
    }
  }

  /**
   *
   *
   *
   */
  public function startAction()
  {
    $query = mysql_query("SELECT * FROM `games` WHERE `server` IS NOT NULL GROUP by `server`") or die("Could not select database");

    while(false !== ($data = mysql_fetch_assoc($query)))
    {
      $server = $data['server'];
      $port = $data['port'];
      $name = $data['name'];

      $output = array();
      $com = "forever $server > /dev/null &";

      $exitcode = 0;
      exec($com, $output, $exitcode);

      print "<b>$name</b> server on port <b>$port</b> was running. <br />";
    }
  }

  /**
   *
   *
   *
   */
  public function isGameAvailable($id)
  {
    return mysql_num_rows(mysql_query("SELECT * FROM `games` WHERE `alias` = '$id'")) > 0;
  }

  /**
   *
   *
   *
   */
  public function assignGame($id)
  {
    $this->templates->assign_element("SELECT * FROM `games` WHERE `alias` = '$id' LIMIT 1", 'game');
  }

  /**
   *
   *
   *
   */
  public function getBaseInfo()
  {
    $this->templates->assign_array("SELECT * FROM `games`", 'games');
  }

  /**
   *
   *
   *
   */
  public function getExtendedInfo()
  {
    $data = mysql_query("SELECT * FROM `games`") or die(mysql_error());

    $results = array();
    while($row = mysql_fetch_assoc($data))
    {
      $row['data'] = $this->getGameExtendedInfo($row['id']);

      $results[] = $row;
    }

    $this->templates->assign('games', $results);
  }

  /**
   *
   *
   *
   */
  public function getGameExtendedInfo($id)
  {
    if(mysql_num_rows(mysql_query("SELECT * FROM `games` WHERE `id` = '$id'")))
    {
      $data = array();
      $data['more'] = array(
        'users' => array(
          'total' => mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `application` = '$id'"), 0),
          'online' => mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `application` = '$id' AND `visit` > DATE_SUB(now(), INTERVAL 5 MINUTE)"), 0),
          'new' => mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `application` = '$id' AND `join` > DATE_SUB(now(), INTERVAL 7 DAY)"), 0),
          'active' => mysql_num_rows(mysql_query("SELECT * FROM `visits` WHERE `application` = '$id' AND `time` > NOW() - INTERVAL 7 DAY GROUP by `uid`")),
          'plays' => mysql_num_rows(mysql_query("SELECT * FROM `visits` WHERE `application` = '$id' AND `time` > NOW() - INTERVAL 7 DAY"))
        ),
        'levels' => array(
          'average' => mysql_result(mysql_query("SELECT ROUND(AVG(`level`)) FROM `users` WHERE `application` = '$id'"), 0),
          'hard' => mysql_result(mysql_query("SELECT `level`, COUNT(`level`) AS `count` FROM `users` GROUP by `level` ORDER by `count` DESC LIMIT 1"), 0),
        ),
        'finance' => array(
          'retention' => array(
            'free' => mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `application` = '$id' AND `inapps` = '0'"), 0),
            'pay' => mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `application` = '$id' AND `inapps` > '0'"), 0)
          ),
          'count' => mysql_result(mysql_query("SELECT COUNT(*) FROM `payments` WHERE `application` = '$id' AND `success` = TRUE"), 0)
        ),
      );

      $users = array();
      $plays = array();
      $payments = array();
      for($i = 7; $i >= 0; $i--) {
        $users[$i - 1] = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `count`, (CURRENT_TIMESTAMP - INTERVAL $i DAY) AS `join` FROM `users` WHERE `application` = '$id' AND `join` >= (CURDATE() - $i) AND `join` < (CURDATE() - $i + 1)"), 0);
        $users[$i - 1]['visits'] = mysql_num_rows(mysql_query("SELECT * FROM `visits` WHERE `application` = '$id' AND `time` >= (CURDATE() - $i) AND `time` < (CURDATE() - $i + 1) GROUP by `uid`"));
        $plays[$i - 1] = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `count`, DAY((CURDATE() - $i)) AS `day`, (CURRENT_TIMESTAMP - INTERVAL $i DAY) AS `time` FROM `visits` WHERE `application` = '$id' AND `time` >= (CURDATE() - $i) AND `time` < (CURDATE() - $i + 1)"), 0);
      }
      for($i = 7; $i >= 0; $i--) {
        $payments[$i - 1]['success'] = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `count`, (CURRENT_TIMESTAMP - INTERVAL $i DAY) AS `time` FROM `payments` WHERE `application` = '$id' AND `success` = TRUE AND `time` >= (CURDATE() - $i) AND `time` < (CURDATE() - $i + 1)"), 0);
        $payments[$i - 1]['failure'] = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `count`, (CURRENT_TIMESTAMP - INTERVAL $i DAY) AS `time` FROM `payments` WHERE `application` = '$id' AND `success` = FALSE AND `time` >= (CURDATE() - $i) AND `time` < (CURDATE() - $i + 1)"), 0);
      }
      $data['users'] = $users;
      $data['plays'] = $plays;
      $data['payments'] = $payments;

      $levels = array_fill(0, mysql_result(mysql_query("SELECT `levels` FROM `games` WHERE `id` = '$id'"), 0), 0);
      $query = mysql_query("SELECT * FROM `users` WHERE `application` = '$id'");
      while(false !== ($result = mysql_fetch_assoc($query)))
      {
        $levels[$result['level'] - 1]++;
      }

      $data['levels'] = $levels;

      return $data;
    }
    else
    {
      return false;
    }
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
