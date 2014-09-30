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
      if($this->uids || $this->keys)
      {
        if(!$this->uids) { $this->uids = array($this->uid); } else { $this->uids = explode(",", $this->uids); }
        if(!$this->keys) { $this->keys = array($this->key); } else { $this->keys = explode(",", $this->keys); }

        if(count($this->uids) > 1)
        {
          $data = array();

          for($j = 0; $j < count($this->uids); $j++)
          {
            $storage = array();

            $this->uid = $this->uids[$j];

            for($i = 0; $i < count($this->keys); $i++)
            {
              $this->key = $this->keys[$i];

              $storage[] =  $this->queries('storage.get');
            }

            $data[] = array(
              'uid' => $this->uid,
              'storage' => $storage
            );
          }

          $this->response('storage', $data);
        }
        else
        {
          $storage = array();

          $this->uid = $this->uids[0];

          for($i = 0; $i < count($this->keys); $i++)
          {
            $this->key = $this->keys[$i];

            $storage[] =  $this->queries('storage.get');
          }

          $this->response('storage', array(
          'storage' => $storage
        ));
        }
      }
      else
      {
        $this->response('storage', array(
          'value' => $this->queries('storage.get')
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
      if(!$this->uids) { $this->uids = array($this->uid); } else { $this->uids = explode(",", $this->uids); }
      if(!$this->keys) { $this->keys = array($this->key); } else { $this->keys = explode(",", $this->keys); }
      if(!$this->values) { $this->values = array($this->value); } else { $this->values = explode(",", $this->values); }

      for($j = 0; $j < count($this->uids); $j++)
      {
        $this->uid = $this->uids[$j];

        for($i = 0; $i < count($this->keys); $i++)
        {
          $this->key = $this->keys[$i];
          $this->value = $this->values[$i];

          $this->queries('storage.set');
        }
      }

      $this->response('storage');
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
