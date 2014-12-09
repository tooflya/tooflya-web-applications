<?

/**
 * @file users.php
 * @category api
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

/**
 *
 * Users definition
 *
 */
namespace API
{

  /**
   * 
   * Require API components.
   *
   */
  require_once('component.php');

  class users extends component
  {

    /**
     *
     *
     *
     */
    public function visit()
    {
      if(!$this->secret || $this->secret === 0 || $this->secret === '0' || $this->secret === 'false') {
        $this->secret = $this->controller->secret(true);
      }

      $new = $this->user();

      if($new)
      {
        $this->upgrade();

        $this->response('users', array(
          'secret' => $this->secret
        ));
      }
      else
      {
        $this->create();

        $this->response('users', array(
          'secret' => $this->secret,
          'info' => array(
            'uid' => $this->uid,
            'name' => $this->name,
            'surname' => $this->surname,
            'photo' => $this->photo
          )
        ));
      }
    }

    /**
     *
     *
     *
     */
    public function leaders()
    {
      if($this->validate('level')) {
        $this->response('users', array(
          'users' => $this->queries('users.leaders.level'),
          'secret' => $this->secret
        ));
      } else {
        switch($this->type) {
          default:
          $this->response('users', array(
            'users' => $this->queries('users.leaders.1'),
            'secret' => $this->secret
          ));
          break;
          case 2:
          $this->response('users', array(
            'place' => $this->queries('users.leaders.2'),
            'secret' => $this->secret
          ));
          break;
        }
      }
    }

    /**
     *
     *
     *
     */
    public function online()
    {
      $this->response('users', array(
        'uids' => $this->queries('users.online'),
        'secret' => $this->secret
      ));
    }

    /**
     *
     *
     *
     */
    public function update()
    {
      $this->queries('users.update');
    }

    /**
     *
     *
     *
     */
    private function user()
    {
      return $this->queries('users.user');
    }

    /**
     *
     *
     *
     */
    private function create()
    {
      $this->queries('users.create');
    }

    /**
     *
     *
     *
     */
    private function upgrade()
    {
      $this->queries('users.upgrade');
    }
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
