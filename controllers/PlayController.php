<?

/**
 * @file PlayController.php
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

class PlayController extends BaseController {

  /**
   *
   *
   *
   */
  function __construct()
  {
    parent::__construct();

    mysql_select_db("play.tooflya.com") or die("Could not select database");
  }

  /**
   *
   *
   *
   */
  public function indexAction()
  {
    $this->templates->assign('url', (isset($_SERVER['HTTPS']) ? 'https://' : 'http://').'play.tooflya.com');

    $this->getBaseInfo();

    $this->templates->display($this->name);
  }

  /**
   *
   *
   *
   */
  public function getBaseInfo()
  {
    $available = mysql_num_rows(mysql_query("SELECT * FROM `playtest` WHERE UNIX_TIMESTAMP(`start`) <= UNIX_TIMESTAMP(NOW()) AND UNIX_TIMESTAMP(`end`) >= UNIX_TIMESTAMP(NOW())")) > 0;

    $this->templates->assign('available', $available);
    $this->templates->assign_element("SELECT *, UNIX_TIMESTAMP(`start`) AS `time`, UNIX_TIMESTAMP(NOW()) AS `now` FROM `playtest` ORDER by `start` LIMIT 1", 'play');
  }
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
