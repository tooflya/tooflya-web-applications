<?

/**
 * @file CorpEventsController.php
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

class CorpEventsController extends BaseController
{

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
  public function getHistory()
  {
    $eventsInformation = array();
    $getSitesInformation = mysql_query("SELECT * FROM `events` LEFT JOIN `corp_users` ON(`events`.`sender` = `corp_users`.`id`) WHERE `events`.`sender` != '" . Session::read('id') . "' GROUP by `events`.`timestamp` ORDER by `events`.`id` DESC");
    while ($data = mysql_fetch_assoc($getSitesInformation))
    {
      $eventsInformation[] = $data;
    }

    $this->templates->assign('events', $eventsInformation);
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
