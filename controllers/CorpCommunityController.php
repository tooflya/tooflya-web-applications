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
  public function assignUserData()
  {
    $id = Session::read('user')['id'];

    $this->templates->assign_element("SELECT * FROM `corp_users` WHERE `id` = '$id'", 'user');
  }

  /**
   *
   *
   *
   */
  public function assignTaskRequirements($id)
  {
    $this->templates->assign_array("SELECT * FROM `corp_tasks_requirements` WHERE `tid` = '$id'", 'requirements');
  }

  /**
   *
   *
   *
   */
  public function assignTaskRisks($id)
  {
    $this->templates->assign_array("SELECT * FROM `corp_tasks_risks` WHERE `tid` = '$id'", 'risks');
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

      $this->showProfile($data['id']);
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
    $this->corpEventsController->assignCounts();

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
          $this->showProfile(Session::read('user')['id']);
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
  public function showTask($id)
  {
    $this->assignUsersList();
    $this->assignUserData();
    $this->corpEventsController->assignCounts();

    if(Session::user())
    {
      $selectUsersDada = mysql_query("SELECT `corp_tasks`.*, `corp_users`.`name` AS `sender_name`, `corp_users`.`surname` AS `sender_surname`, `corp_users`.`id` AS `sender_id` FROM `corp_tasks` LEFT JOIN `corp_users` ON(`corp_tasks`.`sender` = `corp_users`.`id`) WHERE `corp_tasks`.`id` = '$id' LIMIT 1");

      if(mysql_num_rows($selectUsersDada) > 0)
      {
        while($data = mysql_fetch_assoc($selectUsersDada))
        {
          Ajax::generate()->value("response", 1);

          $this->templates->assign('task', $data);
          $this->assignTaskRequirements($id);
          $this->assignTaskRisks($id);

          if(Ajax::isResponse())
          {
            $this->showLayout('CorpController/task.html', true);
          }
          else
          {
            $this->templates->display('CorpController', 'task');
          }
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
      $this->templates->display('CorpController');
    }
  }

  /**
   *
   *
   *
   */
  public function showSettings()
  {
    $this->assignUsersList();
    $this->corpEventsController->assignCounts();

    if(Ajax::isResponse())
    {
      Ajax::generate()->value("response", 1);

      $this->showLayout('CorpController/settings.html', true);
    }
    else
    {
      $this->templates->display('CorpController', 'settings');
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
  public function changeTaskStatus($id, $status)
  {
    if(Session::user())
    {
      if(Ajax::isResponse())
      {
        if(mysql_num_rows(mysql_query("SELECT * FROM `corp_tasks` WHERE `id` = '$id'")) > 0)
        {
          mysql_query("UPDATE `corp_tasks` SET `status` = '$status' WHERE `id` = '$id'");print $id;
        
          Ajax::generate()->value("response", 1);

          if(EVENTS)
          {
            $id = Session::read('user')['id'];

            $selectUsersDada = mysql_query("SELECT * FROM `corp_users`");
            
            while($data = mysql_fetch_assoc($selectUsersDada))
            {
              if($id != $data['id'])
              {
                mysql_query("INSERT INTO `events` SET `sender` = '$id', `receiver` = '".$data['id']."', `type` = '".($status + 4)."'");
              }
            }
          }
        }
        else
        {
          Ajax::generate()->value("response", 2);
        }
      }
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
        $number = Validate::post('number') ? Validate::post('number') : mysql_result(mysql_query("SELECT MAX(`id`) FROM `corp_tasks`"), 0) + 1000;
        $new = true;

        if(mysql_num_rows(mysql_query("SELECT * FROM `corp_tasks` WHERE `number` = '$number'")) > 0)
        {
          $id = mysql_result(mysql_query("SELECT `id` FROM `corp_tasks` WHERE `number` = '$number'"), 0);

          $this->deleteTask($id, true);

          $new = false;
        }

        mysql_query("INSERT INTO `corp_tasks` SET `number` = '$number', `receiver` = '$receiver', `sender` = '$sender', `title` = '$title', `description` = '$description', `type` = '$type', `priority` = '$priority'") or die
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

        if($new)
        {
          if(EVENTS)
          {
            $id = Session::read('user')['id'];

            $selectUsersDada = mysql_query("SELECT * FROM `corp_users`");
            
            while($data = mysql_fetch_assoc($selectUsersDada))
            {
              if($id != $data['id'])
              {
                mysql_query("INSERT INTO `events` SET `sender` = '$id', `receiver` = '".$data['id']."', `type` = '3'");
              }
            }
          }
        }
        else
        {
          if(EVENTS)
          {
            $id = Session::read('user')['id'];

            $selectUsersDada = mysql_query("SELECT * FROM `corp_users`");
            
            while($data = mysql_fetch_assoc($selectUsersDada))
            {
              if($id != $data['id'])
              {
                mysql_query("INSERT INTO `events` SET `sender` = '$id', `receiver` = '".$data['id']."', `type` = '5'");
              }
            }
          }
        }
      }
    }
  }

  /**
   *
   *
   *
   */
  public function deleteTask($id, $edit = false)
  {
    if(Session::user())
    {
      if(Ajax::isResponse())
      {
        $sender = mysql_result(mysql_query("SELECT `sender` FROM `corp_tasks` WHERE `id` = '$id'"), 0);
        $receiver = mysql_result(mysql_query("SELECT `receiver` FROM `corp_tasks` WHERE `id` = '$id'"), 0);

        if($sender == Session::read('user')['id'])
        {
          mysql_query("DELETE FROM `corp_tasks` WHERE `id` = '$id'");
          mysql_query("DELETE FROM `corp_tasks_requirements` WHERE `tid` = '$id'");
          mysql_query("DELETE FROM `corp_tasks_risks` WHERE `tid` = '$id'");

          if(!$edit)
          if(EVENTS)
          {
            $id = Session::read('user')['id'];

            $selectUsersDada = mysql_query("SELECT * FROM `corp_users`");
            
            while($data = mysql_fetch_assoc($selectUsersDada))
            {
              if($id != $data['id'])
              {
                mysql_query("INSERT INTO `events` SET `sender` = '$id', `receiver` = '".$data['id']."', `type` = '4'");
              }
            }
          }

          Ajax::generate()->value("response", 1);
          Ajax::generate()->value("receiver", $receiver);
        }
        else
        {
          Ajax::generate()->value("response", 2);
        }
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
