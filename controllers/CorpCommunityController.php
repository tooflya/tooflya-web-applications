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
    $this->templates->assign_array("SELECT * FROM `corp_users`", 'users');
  }

  /**
   *
   *
   *
   */
  public function get()
  {
    global $templates;

    $usersInformation = array();
    $getUsersInformation = mysql_query("SELECT * FROM `users` ORDER by `id`");
    while ($data = mysql_fetch_assoc($getUsersInformation))
    {
      $usersInformation[] = $data;
    }

    $templates->assign('users', $usersInformation);
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
      while ($data = mysql_fetch_assoc($selectUsersDada))
      {
        Session::write('id', $data['id']);
        Session::write('name', $data['name']);
        Session::write('surname', $data['surname']);
        Session::write('avatar', $data['avatar']);
        Session::write('status', $data['status']);

        Ajax::generate()->value("response", 1);

        (new CorpEventsController)->getHistory();

        $this->showLayout('CorpController/base/index.html', true);
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
      $id = Session::read('id');

      $selectUsersDada = mysql_query("SELECT * FROM `corp_users`");
      
      while ($data = mysql_fetch_assoc($selectUsersDada))
      {
        if($id != $data['id'])
        {
          mysql_query("INSERT INTO `events` SET `sender` = '$id', `receiver` = '".$data['id']."', `type` = '2'");
        }
      }
    }

    unset($_SESSION['id']);
    unset($_SESSION['name']);
    unset($_SESSION['surname']);
    unset($_SESSION['avatar']);

    session_destroy();

    $this->assignUsersList();
    $this->showLayout('CorpController/index.html', true);
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
