<?

/**
 * @file webController.php
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

class WebController extends BaseController
{

  /**
   *
   *
   *
   */
  public function indexAction($param = false)
  {
    switch($param)
    {
      default:
      break;
      
      case 'subsribe-fail':
        $this->templates->assign('subscribe', false);
      break;
      
      case 'subsribe':
        $this->templates->assign('subscribe', true);
      break;
    }

    $this->templates->assign('index', true);
    $this->templates->display($this->name);
  }

  /**
   *
   *
   *
   */
  public function aboutAction()
  {
    $this->templates->assign(TITLE, 'О проекте');
    $this->templates->display($this->name, 'about');
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
