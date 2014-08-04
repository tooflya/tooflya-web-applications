<?

/**
 * @file ApiController.php
 * @category Controller
 *
 * @author Igor Mats from Tooflya Inc.
 * @copyright (c) 2014 by Igor Mats
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
 * Require API components.
 *
 */
require(PATH.'/api/storage.php');
require(PATH.'/api/users.php');

/**
 * Response codes:
 * -1: Service unreachable;
 *  0: Undefined call method;
 *  1: Success;
 *  2: Invalid secret;
 */
class ApiController extends BaseController
{
  
  /**
   *
   *
   *
   */
  public $information;

  /**
   *
   *
   *
   */
  public function indexAction($call = false)
  {
    if($call)
    {
      $this->call($call);
    }
    else
    {
      $this->assignStatistic();

      $this->templates->display($this->name);
    }
  }

  /**
   *
   *
   *
   */
  private function call($call)
  {
    mysql_select_db('games.tooflya.com') or die(
      $this->abort(-1)
    );

    switch($call)
    {
      case 'users.visit':
      $this->users()->visit();
      break;
    }

    $this->secret();

    switch($call)
    {
      default:
      $this->abort(0);
      break;
      case 'storage.get':
      $this->storage()->get();
      break;
      case 'storage.set':
      $this->storage()->set();
      break;
      case 'storage.view':
      $this->storage()->view();
      break;
    }
  }

  /**
   *
   *
   *
   */
  public function secret($generate = false)
  {
    if($generate)
    {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $secret = '';
      for($i = 0; $i < 20; $i++) {
        $secret .= $characters[rand(0, strlen($characters) - 1)];
      }

      return $secret;
    }
    else
    {
      $secret = Validate::post('secret');

      if(mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE `secret` = '$secret' LIMIT 1")) <= 0 || !$secret)
      {
        $this->abort(2);
      }
      else
      {
        $this->information = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `secret` = '$secret' LIMIT 1"));
      }
    }
  }

  /**
   *
   *
   *
   */
  public function abort($code)
  {
    switch($code)
    {
      case -1:
      $reason = 'Service unreachable.';
      break;
      case 0:
      $reason = 'Undefined call method.';
      break;
      case 2:
      $reason = 'Invalid secret.';
      break;
    }

    print json_encode(array(
      'response' => $code,
      'data' => array(
        'reason' => $reason
      )
    ));

    exit;
  }

  /**
   *
   *
   *
   */
  public function response($data = false)
  {
    print json_encode(array(
      'response' => 1,
      'data' => $data
    ));

    exit;
  }

  /**
   *
   *
   *
   */
  private function assignStatistic()
  {
    mysql_select_db('api.tooflya.com');

    $this->statistics = [];
    for($i = 7; $i >= 0; $i--) {
      $this->assignGroupStatistic(false, $i);
      $this->assignGroupStatistic('storage', $i);
      $this->assignGroupStatistic('users', $i);
      $this->assignGroupStatistic('score', $i);
      $this->assignGroupStatistic('coins', $i);
    }

    $this->templates->assign('statistics', $this->statistics);
  }

  /**
   *
   *
   *
   */
  private function assignGroupStatistic($group, $i)
  {
    if(!$group)
    {
      $key = 'calls';
      $group = "IS NOT NULL";
    }
    else
    {
      $key = $group;
      $group = "= '" . $group . "'";
    }

    $this->statistics[$key][$i - 1] = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `count`, (CURRENT_TIMESTAMP - INTERVAL $i DAY) AS `time`, `group` FROM `calls` WHERE `group` $group AND `time` >= (CURDATE() - $i) AND `time` < (CURDATE() - $i + 1)"), 0);
    $this->statistics[$key . 'Count'] += $this->statistics[$key][$i - 1]['count'];
  }

  private function users() {return new API\users($this);}
  private function storage() {return new API\storage($this);}
}

/**
 *
 * Designed specifically for using this code in projects of Tooflya Inc.
 * Tooflya Inc., 2014
 *
 * @author Igor Mats from Tooflya Inc.
 * @copyright (c) 2014 by Igor Mats
 *
 */
