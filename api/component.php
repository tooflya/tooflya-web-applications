<?

/**
 * @file component.php
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
  class component
  {

    protected $controller;

    /**
     *
     *
     *
     */
    public function __construct($controller)
    {
      $this->controller = $controller;

      $this->uid          = $this->param('uid');
      $this->name         = $this->param('name');
      $this->surname      = $this->param('surname');
      $this->application  = $this->param('application');
      $this->platform     = $this->param('platform');
      $this->language     = $this->param('language');
      $this->time         = $this->param('time');

      $this->key          = $this->param('key');
      $this->value        = $this->param('value');

      $this->keys         = $this->param('keys');
      $this->values       = $this->param('values');

      $this->ip           = $_SERVER['REMOTE_ADDR'];

      $this->secret       = $this->controller->secret(true);

      if($this->keys || $this->keys)
      {
        $this->keys = explode(",", $this->keys);
        $this->values = explode(",", $this->values);

        $this->lock();
      }

      switch($this->platform)
      {
        case 'standalone':
        case 'www.tooflya.com':
        case 'tooflya.com':
        case 'tooflya':
        $this->platform = 0;
        break;
        // TODO: Add platforms.
      }
    }

    /**
     *
     *
     *
     */
    protected function param($key)
    {
      if($this->controller->information[$key])
      {
        return $this->controller->information[$key];
      }

      return $this->validate($key);
    }

    /**
     *
     *
     *
     */
    protected function validate($key)
    {
      return \Validate::post($key);
    } 

    /**
     *
     *
     *
     */
    protected function response($component, $data)
    {
      if(!$this->lock)
      {
        $this->using($component);
        $this->statistic($component);

        $this->controller->response($data);
      }
    }

    /**
     *
     *
     *
     */
    protected function statistic($group)
    {
      mysql_select_db('api.tooflya.com');

      $this->queries('statistic', $group);
    }

    /**
     *
     *
     *
     */
    protected function using($component)
    {
      $this->queries($component.'.using');
    }

    /**
     *
     *
     *
     */
    protected function lock()
    {
      $this->multiple = $this->lock ? false : true;
      $this->lock = true;
    }

    /**
     *
     *
     *
     */
    protected function unlock()
    {
      $this->lock = false;
      $this->multiple = false;
    }


    /**
     *
     *
     *
     */
    protected function queries($query, $group = false)
    {
      switch($query)
      {

        case 'statistic':
        return mysql_query("INSERT INTO `calls` SET `group` = '$group', `application` = '$this->application'");
        break;
        /**
         *
         * User component queries.
         *
         */
        case 'users.create':
        return mysql_query("INSERT INTO `users` SET `uid` = '$this->uid', `platform` = '$this->platform', `secret` = '$this->secret', `application` = '$this->application', `name` = '$this->name', `surname` = '$this->surname', `language` = '$this->language', `ip` = '$this->ip', `time` = '$this->time', `join` = NOW()");
        break;
        case 'users.update':
        return mysql_query("UPDATE `users` SET `secret` = '$this->secret' WHERE `uid` = '$this->uid' AND `platform` = '$this->platform'");
        break;
        case 'users.user':
        return mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE `uid` = '$this->uid' AND `platform` = '$platform' LIMIT 1")) > 0;
        break;
        case 'users.using':
        return mysql_query("INSERT INTO `visits` SET `uid` = '$this->uid', `application` = '$this->application'");
        break;

        /**
         *
         * Storage component queries.
         *
         */
        case 'storage.get':
        return mysql_result(mysql_query("SELECT `value` FROM `storage` WHERE `key` = '$this->key' AND `uid` = '$this->uid' AND `application` = '$this->application'"), 0);
        break;
        case 'storage.set':
        if(mysql_num_rows(mysql_query("SELECT * FROM `storage` WHERE `key` = '$this->key' AND `uid` = '$this->uid' AND `application` = '$this->application'")) > 0)
        {
          return mysql_query("UPDATE `storage` SET `value` = '$this->value' WHERE `key` = '$this->key' AND `uid` = '$this->uid' AND `application` = '$this->application'");
        }
        else
        {
          return mysql_query("INSERT INTO `storage` SET `uid` = '$this->uid', `application` = '$this->application', `key` = '$this->key', `value` = '$this->value'");
        }
        break;
        case 'storage.view':
        $data = Array();
        $query = mysql_query("SELECT * FROM `storage` WHERE `uid` = '$this->uid' AND `application` = '$this->application'");
        while(false !== ($result = mysql_fetch_assoc($query)))
        {
          $data[] = array('key' => $result['key'], 'value' => $result['value']);
        }

        return $data;
        break;

        /**
         *
         * ? component queries.
         *
         */
      }
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
