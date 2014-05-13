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

class Push
{
  public $gcm;
  public $acm;
  public $data;
  public $registrations;

  /**
   *
   *
   *
   */
  public function __construct($project, $data, $registrations)
  {
    $this->gcm = $project['gcm'];
    $this->acm = $project['acm'];
    $this->data = $data;
    $this->registrations = $registrations;
  }
}

class CorpProjectsController extends BaseController
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
    mysql_query("DELETE FROM `projects` WHERE `id` = '$id'");
  }

  /**
   *
   *
   *
   */
  public function assignProjectsList()
  {
    $this->templates->assign_array("SELECT * FROM `projects`", 'projects');
  }

  /**
   *
   *
   *
   */
  public function showProject($id)
  {
    if(Session::user())
    {
      $corpCommunityController = new CorpCommunityController();
      $corpCommunityController->assignUsersList();

      $this->assignProjectsList();

      $selectUsersDada = mysql_query("SELECT * FROM `projects` WHERE `id` = '$id' LIMIT 1");

      if(mysql_num_rows($selectUsersDada) > 0)
      {
        $this->templates->assign_element("SELECT * FROM `projects` WHERE `id` = '$id' LIMIT 1", 'project');
        $this->templates->assign_element("SELECT COUNT(*) AS `count` FROM `notifications` WHERE `project` = '$id'", 'totalregistrations');
        $this->templates->assign_element("SELECT COUNT(*) AS `count` FROM `notifications` WHERE `project` = '$id' AND `date` BETWEEN NOW() - INTERVAL 1 HOUR AND NOW()", 'lastregistrations');
        $this->templates->assign_element("SELECT `date` AS `time` FROM `notifications.history` WHERE `project` = '$id' ORDER by `id` DESC LIMIT 1", 'last');
        $this->templates->assign_array("SELECT * FROM `notifications.history` LEFT JOIN `corp_users` ON(`notifications.history`.`user` = `corp_users`.`id`) WHERE `project` = '$id' ORDER by `notifications.history`.`id` DESC", 'notifications');
        $this->templates->assign_array("SELECT * FROM `notifications` WHERE `project` = '$id' ORDER by `date` DESC LIMIT 100", 'project', 'users');

        if(Ajax::isResponse())
        {
          $this->showLayout('CorpController/project.html', true);

          Ajax::generate()->value("response", 1);
        }
        else
        {
          $this->templates->display('CorpController', 'project');
        }
      }
      else
      {
        if(Ajax::isResponse())
        {
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
  public function sendNotification()
  {
    if(Session::user())
    {
      if(Ajax::isResponse())
      {
        $id = Validate::post('id');

        $success = 0;
        $failure = 0;

        $count = mysql_result(mysql_query("SELECT COUNT(*) AS `count` FROM `notifications` WHERE `project` = '$id'"), 0);
        $project = mysql_fetch_assoc(mysql_query("SELECT * FROM `projects` WHERE `id` = '$id'"));

        $part = 1000;
        $part = $part > $count ? $count : $part;

        for($i = 0; $i < $count; $i)
        {
          $registrations = mysql_query("SELECT * FROM `notifications` WHERE `project` = '$id' LIMIT $i, $part");
          $registrationsIds = array();

          while(false !== ($data = mysql_fetch_assoc($registrations)))
          {
            $registrationsIds[] = $data['key'];
          }

          $result = $this->pushNotification(new Push($project, array(
            'id' => 1, // TODO: Add message ID.
            'type' = > 1, // TODO: Add message type.
            'title' => Validate::post('title'),
            'preview' => Validate::post('preview'),
            'message' => Validate::post('description'),
            'action' => Validate::post('action')
          ), $registrationsIds));

          $success += $result['success'];
          $failure += $result['failure'];

          if($count - $i >= $part)
          {
            $i += $part;
          }
          else
          {
            $i += ($count - $i);
          }
        }

        Ajax::generate()->value("response", 1);
        Ajax::generate()->value("count", $count);
        Ajax::generate()->value("success", $success);
        Ajax::generate()->value("failure", $failure);

        /** History */

        $title = Validate::post('title');
        $description = Validate::post('description');
        $uid = Session::user();

        mysql_query("INSERT INTO `notifications.history` SET `project` = '$id', `title` = '$title', `description` = '$description', `user` = '$uid'");
      }
    }
  }

  /**
   *
   *
   *
   */
  private function pushNotification($message)
  {
    // TODO: Add iOS and Windows Phone API's.

    $headers = array(
      "Content-Type: application/json",
      "Authorization: key=". $message->gcm
    );
    $data = array(
      'data' => $message->data,
      'registration_ids' => $message->registrations
    );
 
    $ch = curl_init();
 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
 
    $response = curl_exec($ch);
    curl_close($ch);
 
    return json_decode($response, true);
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
