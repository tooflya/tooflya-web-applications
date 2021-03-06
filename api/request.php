<?

/**
 * @file request.php
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
 * Storage definition
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

  class request extends component
  {
    /**
     *
     *
     *
     */
    public function send()
    {
      switch($this->type)
      {
        default:
        $this->controller->abort(6);
        break;
        case 'live.send':
        case 'live.request':
        case 'play.send':
        break;
      }

      $this->queries('request.send');

      $this->response('request', array(
        'secret' => $this->secret
      ));
    }

    /**
     *
     *
     *
     */
    public function receive()
    {
      $this->response('request', array(
        'received' => $this->queries('request.receive'),
        'secret' => $this->secret
      ));
    }

    /**
     *
     *
     *
     */
    public function find()
    {
      $this->response('request', array(
        'requests' => $this->queries('request.find'),
        'secret' => $this->secret
      ));
    }

    /**
     *
     *
     *
     */
    public function check()
    {
      $this->response('request', array(
        'requests' => $this->queries('request.check'),
        'secret' => $this->secret
      ));
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
