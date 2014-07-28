<?

/**
 * @file storage.php
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

  class storage extends component
  {
    /**
     *
     *
     *
     */
    public function get()
    {
      if($this->multiple)
      {
        $this->lock();

        $storage = array();

        for($i = 0; $i < count($this->keys); $i++)
        {
          $this->key = $this->keys[$i];

          $storage[] =  $this->queries('storage.get');
        }

        $this->unlock();

        $this->response('storage', array(
          'storage' => $storage
        ));
      }
      else
      {
        $value = $this->queries('storage.get');

        $this->response('storage', array(
          'value' => $value
        ));
      }
    }

    /**
     *
     *
     *
     */
    public function set()
    {
      if($this->multiple)
      {
        $values = [];

        $this->lock();

        for($i = 0; $i < count($this->keys); $i++)
        {
          $this->key = $this->keys[$i];
          $this->value = $this->values[$i];

          $values[] = $this->value;

          $this->set();
        }

        $this->unlock();

        $this->response('storage', array(
          'values' => $values
        ));
      }
      else
      {
        $this->queries('storage.set');

        $this->response('storage', array(
          'value' => $this->value
        ));
      }
    }

    /**
     *
     *
     *
     */
    public function view()
    {
      $storage = $this->queries('storage.view');

      $this->response('storage', array(
        'storage' => $storage
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
