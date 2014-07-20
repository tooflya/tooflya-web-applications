<?

/**
 * @file CompanyController.php
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

class CompanyController extends BaseController
{

  private $companyCommunityController;
  private $companyProjectsController;

  /**
   *
   *
   *
   */
  public function __construct()
  {
    parent::__construct();

    $this->companyCommunityController = new CompanyCommunityController();
    $this->companyProjectsController = new CompanyProjectsController();
  }

  /**
   *
   *
   *
   */
  public function create()
  {

  }

  /**
   *
   *
   *
   */
  public function indexAction()
  {
    $user = Session::read('user');

    $this->companyCommunityController->showProfile($user['id']);
  }

  /**
   *
   *
   *
   */
  public function userAction($id = false)
  {
    $user = Session::read('user');

    $this->companyCommunityController->showProfile($id ? $id : $user['id']);
  }

  /**
   *
   *
   *
   */
  public function projectAction($id = false)
  {
    $this->companyCommunityController->assignUsersList();
    $this->companyProjectsController->showProject($id);
  }

  /**
   *
   *
   *
   */
  public function taskAction($id = false)
  {
    $this->companyCommunityController->showTask($id);
  }

  /**
   *
   *
   *
   */
  public function settingsAction()
  {
    $this->companyCommunityController->showSettings();
  }

  /**
   *
   *
   *
   */
  public function eventsAction($user = false)
  {
    if($user)
    {
      $this->companyCommunityController->showUserEvents();
    }
    else
    {
      $this->companyCommunityController->showEvents();
    }
  }

  /**
   *
   *
   *
   */
  public function helpAction()
  {
    $this->templates->display('CompanyController', 'help');
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
