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
      $this->queries('level.set');

      $this->response('level', array(
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
