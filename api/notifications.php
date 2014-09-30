<?

/**
 * @file notifications.php
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

  class notifications extends component
  {

    /**
     *
     *
     *
     */
    public function send()
    {
      $secure = $this->proceedSignature('notifications.send');

      $this->response('notifications', array(
        'secure' => $secure,
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
          case 'notifications.send':
          $arguments = array(
            'api_id' => $sid,
            'method' => 'secure.sendNotification',
            'random' => rand(10000, 99999),
            'timestamp' => round(microtime(true) * 1000),
            'uids' => $this->uids,
            'message' => $this->message,
            'format' => 'json'
          );
          break;
        }

        $request = 'http://api.vkontakte.ru/api.php' . '?sig=' . $this->calculateSignature($arguments, $info);

        $arguments['message'] = urlencode($arguments['message']);
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
