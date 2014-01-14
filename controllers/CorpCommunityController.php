<?

/**
 * @file CorpCommunityController.php
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

class CorpCommunityController extends BaseController
{

  private $corpEventsController;

  /**
   *
   *
   *
   */
  public function __construct()
  {
    parent::__construct();

    $this->corpEventsController = new CorpEventsController();
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
  public function create()
  {
  }

  /**
   *
   *
   *
   */
  public function remove($id)
  {
    mysql_query("DELETE FROM `users` WHERE `id` = '$id'");
  }

  /**
   *
   *
   *
   */
  public function assignUsersList()
  {
    $this->templates->assign_array("SELECT * FROM `corp_users` WHERE `available` = '1' ORDER by `name`", 'users');
  }

  /**
   *
   *
   *
   */
  public function assignUsersTasks($id)
  {
    $selectUsersDada = mysql_query("SELECT * FROM `corp_tasks` WHERE `receiver` = '$id' ORDER by `priority`, `title`");

    if(mysql_num_rows($selectUsersDada) > 0)
    {
      while($data = mysql_fetch_assoc($selectUsersDada))
      {
        $selectUsersDadaGeneric[] = $data;
        $selectUsersDadaGeneric[count($selectUsersDadaGeneric) - 1]['comments']['count'] = 0;//mysql_num_rows()
        $selectUsersDadaGeneric[count($selectUsersDadaGeneric) - 1]['requirements']['count'] = mysql_num_rows(mysql_query("SELECT * FROM `corp_tasks_requirements` WHERE `tid` = ".$data['id']));
        $selectUsersDadaGeneric[count($selectUsersDadaGeneric) - 1]['risks']['count'] = mysql_num_rows(mysql_query("SELECT * FROM `corp_tasks_risks` WHERE `tid` = ".$data['id']));
      }

      $this->templates->assign('tasks', $selectUsersDadaGeneric);
    }
  }

  /**
   *
   *
   *
   */
  public function get()
  {
    $this->templates->assign_array("SELECT * FROM `users` ORDER by `id`", 'users', $usersInformation);
  }

  /**
   *
   *
   *
   */
  public function signIn($id, $password)
  {
    $selectUsersDada = mysql_query("SELECT * FROM `corp_users` WHERE `id` = '$id' AND `password` = '$password' LIMIT 1");

    if(mysql_num_rows($selectUsersDada) > 0)
    {
      while($data = mysql_fetch_assoc($selectUsersDada))
      {
        Session::write('user', $data);

        $this->templates->assign('user', $data);

        Ajax::generate()->value("response", 1);

        $this->showProfile($data['id']);
      }

      if(EVENTS)
      {
        $selectUsersDada = mysql_query("SELECT * FROM `corp_users`");
        
        while ($data = mysql_fetch_assoc($selectUsersDada))
        {
          if($id != $data['id'])
          {
            mysql_query("INSERT INTO `events` SET `sender` = '$id', `receiver` = '".$data['id']."', `type` = '1'");
          }
        }
      }
    }
    else
    {
      Ajax::generate()->value("response", 0);
    }
  }

  /**
   *
   *
   *
   */
  public function signOut()
  {
    if(EVENTS)
    {
      $id = Session::read('user')['id'];

      $selectUsersDada = mysql_query("SELECT * FROM `corp_users`");
      
      while ($data = mysql_fetch_assoc($selectUsersDada))
      {
        if($id != $data['id'])
        {
          mysql_query("INSERT INTO `events` SET `sender` = '$id', `receiver` = '".$data['id']."', `type` = '2'");
        }
      }
    }

    unset($_SESSION['user']);

    Ajax::generate()->value("response", 1);

    $this->assignUsersList();
    $this->showLayout('CorpController/index.html', true);
  }

  /**
   *
   *
   *
   */
  public function showProfile($id)
  {
    $this->assignUsersList();

    if(Session::user())
    {
      $selectUsersDada = mysql_query("SELECT * FROM `corp_users` WHERE `id` = '$id' LIMIT 1");

      if(mysql_num_rows($selectUsersDada) > 0)
      {
        while($data = mysql_fetch_assoc($selectUsersDada))
        {
          if(!$data['available'])
          {
            $controller = new ErrorController();
            $controller->notFound();

            exit;
          }

          Ajax::generate()->value("response", 1);

          $this->templates->assign('user', $data);

          $this->assignUsersTasks($id);

          if(Ajax::isResponse())
          {
            $this->showLayout('CorpController/main.html', true);
          }
          else
          {
            $this->templates->display('CorpController', 'main');
          }
        }
      }
      else
      {
        if(Ajax::isResponse())
        {
          Ajax::generate()->value("response", 2);
        }
        else
        {
          $controller = new ErrorController();
          $controller->notFound();
        }
      }
    }
    else
    {
      $this->templates->display('CorpController');
    }
  }

  /**
   *
   *
   *
   */
  public function showEvents()
  {
    $this->assignUsersList();
    $this->corpEventsController->assignEvents();
    $this->corpEventsController->assignCounts();

    if(Ajax::isResponse())
    {
      Ajax::generate()->value("response", 1);

      $this->showLayout('CorpController/events.html', true);
    }
    else
    {
      $this->templates->display('CorpController', 'events');
    }
  }

  /**
   *
   *
   *
   */
  public function showUserEvents()
  {
    $this->assignUsersList();
    $this->corpEventsController->assignUserEvents();
    $this->corpEventsController->assignCounts();

    if(Ajax::isResponse())
    {
      Ajax::generate()->value("response", 1);

      $this->showLayout('CorpController/events.html', true);
    }
    else
    {
      $this->templates->display('CorpController', 'events');
    }
  }

  /**
   *
   *
   *
   */
  public function addTask()
  {
    // TODO: Full refactoring.
    // TODO: Add checks for wrong data.

    if(Session::user())
    {
      if(Ajax::isResponse())
      {
        $sender = Session::read('user')['id'];
        $receiver = Validate::post('id');

        $title = Validate::post('name');
        $description = Validate::post('description');
        $type = Validate::post('task_type');
        $priority = Validate::post('priority');

        mysql_query("INSERT INTO `corp_tasks` SET `receiver` = '$receiver', `sender` = '$sender', `title` = '$title', `description` = '$description', `type` = '$type', `priority` = '$priority'") or die
        (
          Ajax::generate()->value("response", mysql_error())
        );

        $id = mysql_insert_id();

        $count = 0;
        while($count < 100)
        {
          $count++;

          $title = Validate::post('requirement-name-'.$count);
          $description = Validate::post('requirement-description-'.$count);
          $points = Validate::post('requirement-points-'.$count);
          $priority = Validate::post('requirement-priority-'.$count);

          if(!$title) continue;

          mysql_query("INSERT INTO `corp_tasks_requirements` SET `tid` = '$id', `title` = '$title', `description` = '$description', `points` = '$points', `priority`= '$priority'") or die
          (
            Ajax::generate()->value("response", mysql_error())
          );
        }

        $count = 0;
        while($count < 100)
        {
          $count++;

          $title = Validate::post('risk-name-'.$count);
          $description = Validate::post('risk-description-'.$count);
          $points = Validate::post('risk-points-'.$count);

          if(!$title) continue;

          mysql_query("INSERT INTO `corp_tasks_risks` SET `tid` = '$id', `title` = '$title', `description` = '$description', `points` = '$points'") or die
          (
            Ajax::generate()->value("response", mysql_error())
          );
        }
        
        Ajax::generate()->value("response", 1);
      }
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
