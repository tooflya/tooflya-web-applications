<?

/**
 * @file CompanyEventsController.php
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

class CompanyEventsController extends BaseController
{

  /**
   *
   *
   *
   */
  public function __construct()
  {
    parent::__construct();

    $this->assignCounts();
  }

  /**
   *
   *
   *
   */
  public function indexAction()
  {
  }

  /**
   *
   *
   *
   */
  public function assignCounts()
  {
    $user = Session::read('user');

    $id = $user['id'];

    $eventsInformation = array();
    $eventsInformation['count']['total'] = mysql_num_rows(mysql_query("SELECT * FROM `events` GROUP by `events`.`timestamp`"));
    $eventsInformation['count']['user'] = mysql_num_rows(mysql_query("SELECT * FROM `events` WHERE `sender` = '$id' GROUP by `events`.`timestamp`"));

    $this->templates->assign('events', $eventsInformation);
  }

  /**
   *
   *
   *
   */
  public function assignEvents()
  {
    $this->templates->assign('yesterday', strtotime('-1 day'));
    $this->templates->assign_array("SELECT * FROM `events` LEFT JOIN `company.users` ON(`events`.`sender` = `company.users`.`id`) GROUP by `events`.`timestamp` ORDER by `events`.`timestamp` DESC, `events`.`id` DESC", 'eventslist');
  }

  /**
   *
   *
   *
   */
  public function assignUserEvents()
  {
    $user = Session::read('user');

    $this->templates->assign('yesterday', strtotime('-1 day'));
    $this->templates->assign_array("SELECT * FROM `events` LEFT JOIN `company.users` ON(`events`.`sender` = `company.users`.`id`) WHERE `events`.`sender` = ".$user['id']." GROUP by `events`.`timestamp` ORDER by `events`.`timestamp` DESC, `events`.`id` DESC", 'eventslist');
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
