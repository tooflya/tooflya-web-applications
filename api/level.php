<?

/**
 * @file level.php
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

  class level extends component
  {

    /**
     *
     *
     *
     */
    public function get()
    {
      $this->response('level', array(
        'level' => $this->queries('level.get'),
        'secret' => $this->secret
      ));
    }

    /**
     *
     *
     *
     */
    public function set()
    {
      $secure = array();

      if($this->queries('level.set')) {
        $secure = json_decode($this->proceedSignature('level.set'), true);
      }

      $this->response('level', array(
        'secure' => $secure,
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
      $this->queries('level.update');

      $this->response('level', array(
        'secret' => $this->secret
      ));
    }

    /**
     *
     *
     *
     */
    public function stars()
    {
      $this->response('level', array(
        'count' => $this->queries('level.stars'),
        'secret' => $this->secret
      ));
    }

    /**
     *
     *
     *
     */
    private function proceedSignature($method)
    {
      $info = $this->queries('proceed');

      $sid = $info['sid'];
      $platform = $info['platform'];

      switch($platform)
      {
        default:
        return true;
        break;
        case 1:
        switch($method) {
          case 'level.set':
          $arguments = array(
            'api_id' => $sid,
            'method' => 'secure.setUserLevel',
            'random' => rand(10000, 99999),
            'timestamp' => round(microtime(true) * 1000),
            'uid' => $this->uid,
            'level' => $this->level,
            'format' => 'json'
          );
          break;
        }

        $request = 'http://api.vkontakte.ru/api.php' . '?sig=' . $this->calculateSignature($arguments, $info);

        foreach($arguments as $key => $value)
        {
          $request .= "&$key=$value";
        }

        return file_get_contents($request);
        break;
      }

      return true;
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
