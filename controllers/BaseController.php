<?

/**
 * @file BaseController.php
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

abstract class BaseController implements IBaseController
{

  protected $templates;
  protected $name;

  /**
   *
   *
   *
   */
  function __construct()
  {
    define('TITLE', 'customTitle');
    
    $this->name = get_class($this);
    $this->templates = Template::Instance();

    if(PERNAMENT_CONTROLLERS)
    {
      PermanentController::Instance($this->templates);
    }
  }

  /**
   *
   *
   *
   */
  public function showLayout($view, $fetch = false, $area = 'body')
  {

    if($fetch)
    {
      Ajax::generate()->value($area, $this->templates->fetch($view));
    }
    else
    {
      $this->templates->display($view);
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
