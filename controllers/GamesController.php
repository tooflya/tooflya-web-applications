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
  public function indexAction($id = false)
  {
    if($id)
    {
      if($this->isGameAvailable($id))
      {
        $this->assignGame($id);

        $this->templates->assign(TITLE, 'Our Games'); // TODO: Change page title.
        $this->templates->display($this->name, 'game');
      }
      else
      {
        $controller = new ErrorController();
        $controller->notFound();
      }
    }
    else
    {
      $this->templates->assign(TITLE, 'Our Games');
      $this->templates->display($this->name);
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
