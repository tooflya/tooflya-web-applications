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

      $this->id           = $this->param('id');
      $this->uid          = $this->param('uid');
      $this->name         = $this->param('name');
      $this->surname      = $this->param('surname');
      $this->photo        = $this->param('photo');
      $this->application  = $this->param('application');
      $this->platform     = $this->param('platform');
      $this->language     = $this->param('language');
      $this->time         = $this->param('time');
      $this->item         = $this->param('item');
      $this->purchase     = $this->param('purchase');
      $this->code         = $this->param('code');
      $this->limit        = $this->param('limit');
      $this->type         = $this->param('type');
      $this->level        = $this->param('level');
      $this->score        = $this->param('score');
      $this->stars        = $this->param('stars');
      $this->force        = $this->param('force');
      $this->friends      = $this->param('friends');

      $this->key          = $this->param('key');
      $this->value        = $this->param('value');

      $this->keys         = $this->param('keys');
      $this->values       = $this->param('values');

      $this->language     = $this->param('language');
      $this->language     = $this->language ? $this->language : 0;

      $this->ip           = $_SERVER['REMOTE_ADDR'];

      $this->secret       = $this->param('secret');

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
        case 'vk':
        $this->platform = 1;
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
      if($this->validate($key) || $this->validate($key) === 0 || $this->validate($key) === '0')
      {
        return $this->validate($key);
      }

      return $this->controller->information[$key];
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
        return mysql_query("INSERT INTO `users` SET `uid` = '$this->uid', `platform` = '$this->platform', `secret` = '$this->secret', `application` = '$this->application', `name` = '$this->name', `surname` = '$this->surname', `photo` = '$this->photo', `language` = '$this->language', `ip` = '$this->ip', `time` = '$this->time', `join` = NOW()");
        break;
        case 'users.update':
        return mysql_query("UPDATE `users` SET `secret` = '$this->secret' WHERE `uid` = '$this->uid' AND `platform` = '$this->platform'");
        break;
        case 'users.user':
        return mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE `uid` = '$this->uid' AND `platform` = '$this->platform' LIMIT 1")) > 0;
        break;
        case 'users.using':
        return mysql_query("INSERT INTO `visits` SET `uid` = '$this->uid', `application` = '$this->application'");
        break;
        case 'users.leaders.1':
        $data = Array();
        $query = mysql_query("SELECT `users`.*, SUM(`levels`.`score`) AS `rating` FROM `users` JOIN `levels` ON (`users`.`id` = `levels`.`uid`) WHERE `levels`.`application` = '$this->application' GROUP by `users`.`id` ORDER by `rating` DESC LIMIT 0, $this->limit");
        while(false !== ($result = mysql_fetch_assoc($query)))
        {
          $data[] = $result;
        }

        return $data;
        break;
        case 'users.leaders.2':
        $data = Array();
        $place = 1;
        $query = mysql_query("SELECT `users`.*, SUM(`levels`.`score`) AS `rating` FROM `users` JOIN `levels` ON (`users`.`id` = `levels`.`uid`) WHERE `levels`.`application` = '$this->application' GROUP by `users`.`id` ORDER by `rating` DESC LIMIT 0, $this->limit");
        while(false !== ($result = mysql_fetch_assoc($query)))
        {
          if($result['secret'] == $this->secret) {
            return $place;
          }

          $place++;
        }

        return -1;
        break;
        case 'users.leaders.level':
        $data = Array();
        $query = mysql_query("SELECT `users`.*, SUM(`levels`.`score`) AS `rating` FROM `users` JOIN `levels` ON (`users`.`id` = `levels`.`uid`) WHERE `levels`.`application` = '$this->application' AND `levels`.`level` = '$this->level' GROUP by `users`.`id` ORDER by `rating` DESC LIMIT 0, $this->limit");
        while(false !== ($result = mysql_fetch_assoc($query)))
        {
          $data[] = $result;
        }

        return $data;
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

        case 'payments.get':
        return "SELECT * FROM `purchases` WHERE `purchase` = '$this->item' AND `language` = '$this->language'";
        break;
        case 'payments.item':
        return mysql_fetch_assoc(mysql_query("SELECT * FROM `purchases` WHERE `purchase` = '$group' AND `language` = '$this->language' LIMIT 1"));
        break;
        case 'payments.available':
        return mysql_num_rows(mysql_query("SELECT * FROM `purchases` WHERE `purchase` = '$this->item' AND `language` = '$this->language'")) > 0;
        break;
        case 'payments.proceed':
        $query = mysql_query("SELECT * FROM `games` WHERE `id` = ".\Validate::get('id')." LIMIT 1");

        if(mysql_num_rows($query) > 0)
        {
          return mysql_fetch_assoc($query);
        }
        else
        {
          return false;
        }
        break;
        case 'payments.visit.true':
        mysql_query("UPDATE `payments` SET `success` = '1' WHERE `uid` = '$this->id' AND `application` = '$this->application' ORDER by `id` DESC LIMIT 1");
        mysql_query("UPDATE `users` SET `purchases` = purchases + 1 WHERE `secret` = '$this->secret' LIMIT 1");
        break;
        case 'payments.visit.false':
        mysql_query("INSERT INTO `payments` SET `uid` = '$this->id', `application` = '$this->application'");
        break;

        case 'promo.get':
        return mysql_num_rows(mysql_query("SELECT * FROM `promo` WHERE `application` = '$this->application' AND `purchase` = '$this->purchase' AND `code` = '$this->code'")) > 0;
        break;
        case 'promo.remove':
        return mysql_query("DELETE FROM `promo` WHERE `application` = '$this->application' AND `purchase` = '$this->purchase' AND `code` = '$this->code'");
        break;

        case 'level.get':
        return mysql_result(mysql_query("SELECT `level` FROM `users` WHERE `secret` = '$this->secret'"), 0);
        break;
        case 'level.set':
        if($this->force) {
          mysql_query("UPDATE `users` SET `level` = '$this->level' WHERE `secret` = '$this->secret'");
        } else {
          if($this->level > $this->queries('level.get')) {
            mysql_query("UPDATE `users` SET `level` = '$this->level' WHERE `secret` = '$this->secret'");
          }
        }
        break;
        case 'level.update':
        if($this->level == -1)
        {
          if(mysql_num_rows(mysql_query("SELECT * FROM `levels` WHERE `application` = '$this->application' AND `uid` = '$this->id' AND `level` = '-1'")) > 0)
          {
            mysql_query("UPDATE `levels` SET `score` = score + $this->score WHERE `application` = '$this->application' AND `uid` = '$this->id' AND `level` = '-1'");
          }
          else
          {
            mysql_query("INSERT INTO `levels` SET `stars` = '3', `score` = '$this->score', `application` = '$this->application', `uid` = '$this->id', `level` = '-1'");
          }
        }
        else
        {
          if(mysql_num_rows(mysql_query("SELECT * FROM `levels` WHERE `application` = '$this->application' AND `uid` = '$this->id' AND `level` = '$this->level'")) > 0)
          {
            if($this->force)
            {
              mysql_query("UPDATE `levels` SET `stars` = '$this->stars', `score` = '$this->score' WHERE `application` = '$this->application' AND `uid` = '$this->id' AND `level` = '$this->level'");
            }
            else
            {
              $data = mysql_fetch_assoc(mysql_query("SELECT * FROM `levels` WHERE `application` = '$this->application' AND `uid` = '$this->id' AND `level` = '$this->level' LIMIT 1"));

              $this->stars = max($this->stars, $data['stars']);
              $this->score = max($this->score, $data['score']);

              mysql_query("UPDATE `levels` SET `stars` = '$this->stars', `score` = '$this->score' WHERE `application` = '$this->application' AND `uid` = '$this->id' AND `level` = '$this->level'");
            }
          }
          else
          {
            mysql_query("INSERT INTO `levels` SET `application` = '$this->application', `uid` = '$this->id', `level` = '$this->level', `stars` = '$this->stars', `score` = '$this->score'");
          }
        }
        break;
        case 'energy.get':
        $friends = '13527563';//implode(', ', $this->friends);

        $query = mysql_query(
          "SELECT
            `users`.`name`,
            `users`.`surname`,
            `users`.`photo`,
            `storage`.`value` AS `energy`
              FROM `users`, `storage`
            WHERE
              `users`.`uid` IN ($friends)
                AND
              `storage`.`uid` IN ($friends)
                AND
              `storage`.`key` =  '$this->key'
                AND
              `storage`.`key` < 5
                AND
              `users`.`application` = '$this->application'
                AND
              `storage`.`application` = '$this->application'
          ");
        while(false !== ($result = mysql_fetch_assoc($query)))
        {
          $data[] = $result;
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
