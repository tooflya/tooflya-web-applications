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
      $this->uids         = $this->param('uids');
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
      $this->friend       = $this->param('friend');
      $this->friends      = $this->param('friends');
      $this->message      = $this->param('message');

      $this->key          = $this->param('key');
      $this->value        = $this->param('value');

      $this->keys         = $this->param('keys');
      $this->values       = $this->param('values');

      $this->language     = $this->param('language');
      $this->language     = $this->language ? $this->language : 0;

      $this->ip           = $_SERVER['REMOTE_ADDR'];

      $this->secret       = $this->param('secret');

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
        case 'fb':
        $this->platform = 2;
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
      $this->using($component);
      $this->statistic($component);

      $this->controller->response($data);
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
    protected function query($method, $params)
    {
      $url = 'http://api.tooflya.com/' . $method;

      $options = array(
        'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'POST',
          'content' => http_build_query($params)
        )
      );

      $context  = stream_context_create($options);
      $result = file_get_contents($url, false, $context);

      return $result;
    }

    /**
     *
     *
     *
     */
    protected function calculateSignature($arguments, $info)
    {
      $platform = $info['platform'];
      $secret = $info['secret'];

      switch($platform)
      {
        default:
        return true;
        break;
        case 1:
        $keys = array();
        foreach($arguments as $key => $value)
        {
          if($key != 'sig')
          {
            $keys[] = "$key=$value";
          }
        }
        sort($keys);

        return md5(join('', $keys) . $secret);
        break;
      }
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
        case 'users.upgrade':
        return mysql_query("UPDATE `users` SET `secret` = '$this->secret' WHERE `uid` = '$this->uid' AND `application` = '$this->application'");
        break;
        case 'users.update':
        return mysql_query("UPDATE `users` SET `visit` = NOW() WHERE `uid` = '$this->uid' AND `application` = '$this->application'");
        break;
        case 'users.user':
        return mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE `uid` = '$this->uid' AND `application` = '$this->application' LIMIT 1")) > 0;
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
        case 'users.online':
        $count = 0;
        $data = array();

        $uids = explode(',', $this->uids);

        foreach($uids as $uid)
        {
          $uid = intval(trim($uid));
          if($uid > 0) {
            $count++;
          }
        }

        if($count < 1)
        {
          $this->controller->abort(5);
        }
        else
        {
          foreach($uids as $uid)
          {
            $uid = intval(trim($uid));
            if($uid > 0) {
              $visit = mysql_result(mysql_query("SELECT UNIX_TIMESTAMP(`visit`) FROM `users` WHERE `uid` = '$uid' AND `application` = '$this->application'"), 0); // TODO: Need to test it.
              if($visit) {
                $data[] = array(
                  'uid' => $uid,
                  'online' => $visit
                );
              }
            }
          }
        }

        return $data;
        break;
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

          return true;
        } else {
          if($this->level > $this->queries('level.get')) {
            mysql_query("UPDATE `users` SET `level` = '$this->level' WHERE `secret` = '$this->secret'");

            return true;
          }
        }

        return false;
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
        case 'level.stars':
        return mysql_result(mysql_query("SELECT SUM(`stars`) FROM `levels` WHERE `uid` = '$this->id' AND `application` = '$this->application'"), 0);
        break;
        case 'proceed':
        $query = mysql_query("SELECT * FROM `games` WHERE `id` = '$this->application' LIMIT 1");

        if(mysql_num_rows($query) > 0)
        {
          return mysql_fetch_assoc($query);
        }
        else
        {
          return false;
        }
        break;
        case 'request.send':
        mysql_query("INSERT INTO `requests` SET `type` = '$this->type', `application` = '$this->application', `uid1` = '".$this->controller->information['uid']."', `uid2` = '$this->uid'");
        break;
        case 'request.find':
        $data = array();

        $minutes = $this->force ? (60 * 24) : 1;

        $query1 = mysql_query("SELECT `users`.`uid`, `users`.`name`, `users`.`surname`, `users`.`photo`, UNIX_TIMESTAMP(`users`.`visit`) AS `online`, `requests`.`id`, UNIX_TIMESTAMP(`requests`.`time`) AS `time`, `requests`.`type`, `requests`.`showed`, `requests`.`received` FROM `users`, `requests` WHERE `requests`.`application` = '$this->application' AND `requests`.`uid2` = '$this->uid' AND `requests`.`received` = '0' AND `users`.`uid` = `requests`.`uid1` AND `requests`.`time` > DATE_SUB(NOW(), INTERVAL $minutes minute)");
        $query2 = mysql_query("UPDATE `requests` SET `showed` = '1' WHERE `application` = '$this->application' AND `uid2` = '$this->uid'");

        while(false !== ($result = mysql_fetch_assoc($query1)))
        {
          if(!$this->force)
          {
            if($result['showed'] == 1)
            {
              continue;
            }
          }

          $data[] = $result;
        }

        return $data;
        break;
        case 'request.receive':
        if(mysql_num_rows(mysql_query("SELECT * FROM `requests` WHERE `id` = '$this->id'")) > 0)
        {
          mysql_query("UPDATE `requests` SET `showed` = '1', `received` = '1' WHERE `application` = '$this->application' AND `id` = '$this->id'");

          return true;
        }

        return false;
        break;
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
