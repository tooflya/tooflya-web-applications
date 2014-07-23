<?

/**
 * @file StatusController.php
 * @category Controller
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

class StatusController extends BaseController
{

  /**
   *
   *
   *
   */
  public function indexAction()
  {
    $this->templates->display($this->name);
  }

  /**
   *
   *
   *
   */
  private function getServerAddress()
  {
    $ifconfig = shell_exec('/sbin/ifconfig eth0');
    preg_match('/addr:([\d\.]+)/', $ifconfig, $match);

    return $match[1];
  }

  /**
   *
   *
   *
   */
  public function getServerBaseInfo()
  {
    mysql_select_db("status.tooflya.com") or die("Could not select database");

    $time = new DateTime();
    $time->setTime(0, 0, 0);
    $time->getTimestamp();

    $time = (new DateTime())->diff($time)->h * 60 + (new DateTime())->diff($time)->i;

    $memory = array(
      'total' => 0,
      'free' => 0
    );

    $fh = fopen('/proc/uptime', 'r');
    $data = fread($fh, 128);

    $upsecs = (int) substr($data, 0, strpos($data, ' '));
    $uptime = Array(
      'days' => floor($data / 60 / 60 / 24),
      'hours' => $data / 60 / 60 % 24,
      'minutes' => $data / 60 % 60,
      'seconds' => $data % 60,
      'percent' => 100.0 - ((((8640 + $time) - mysql_result(mysql_query("SELECT COUNT(*) FROM `uptime` WHERE date_sub(curdate(), INTERVAL 7 DAY) <= `time` ORDER by `id` DESC"), 0)) / (8640 + $time)) * 100),
    );

    $fh = fopen('/proc/meminfo','r');
    while($line = fgets($fh))
    {
      $pieces = array();
      if(preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces))
      {
        $memory['total'] = $pieces[1];
      }
      if(preg_match('/^MemFree:\s+(\d+)\skB$/', $line, $pieces))
      {
        $memory['free'] = $pieces[1];
      }
    }
    fclose($fh);

    $this->templates->assign('server', array(
      'main' => array(
        'ip' => $this->getServerAddress(),
        'id' => preg_replace('[\D]', '', php_uname('n')),
        'domain' => php_uname('n'),
        'system' => php_uname('s').' '.php_uname('r'),
        'memory' => array(
          'total' => $memory['total'],
          'free' => $memory['free'],
          'available' => ini_get('memory_limit')
        ),
        'disk' => array(
          'total' => disk_total_space('/'),
          'free' => disk_free_space('/')
        ),
        'uptime' => $uptime,
        'bandwidth' => mysql_result(mysql_query("SELECT AVG(`speed`) FROM `bandwidth` ORDER by `id` DESC LIMIT 7"), 0),
        'ping' => mysql_result(mysql_query("SELECT AVG(`ping`) FROM `bandwidth` ORDER by `id` DESC LIMIT 7"), 0),
        'la' => array(
          'one' => mysql_result(mysql_query("SELECT AVG(`one`) FROM `la` ORDER by `id` DESC LIMIT 7"), 0),
          'five' => mysql_result(mysql_query("SELECT AVG(`five`) FROM `la` ORDER by `id` DESC LIMIT 7"), 0),
          'fifteen' => mysql_result(mysql_query("SELECT AVG(`fifteen`) FROM `la` ORDER by `id` DESC LIMIT 7"), 0)
        )
      )
    ));
    $this->templates->assign_array("SELECT * FROM (SELECT *, COUNT(*) AS `count`, DAY(`time`) AS `day` FROM `uptime` GROUP by `day` ORDER by `time` DESC LIMIT 7) AS `table` GROUP BY `table`.`day`", 'uptime');
    $this->templates->assign_array("SELECT AVG(`speed`) AS `speed`, AVG(`ping`) AS `ping`, DAY(`time`) AS `day`, `time` FROM (SELECT * FROM `bandwidth` GROUP by DAY(`time`) ORDER by `time` DESC LIMIT 7) AS `table` GROUP BY `day`", 'bandwidth');
    $this->templates->assign_array("SELECT AVG(`one`) AS `one`, AVG(`five`) AS `five`, AVG(`fifteen`) AS `fifteen`, DAY(`time`) AS `day`, `time` FROM (SELECT * FROM `la` GROUP by DAY(`time`) ORDER by `time` DESC LIMIT 7) AS `table` GROUP BY `day`", 'la');

    $this->templates->assign('time', $time);

    $this->templates->display($this->name, 'base');
  }

  /**
   *
   *
   *
   */
  public function setServerBaseInfo()
  {
    mysql_select_db("status.tooflya.com") or die("Could not select database");

    $la_one = sys_getloadavg()[0];
    $la_five = sys_getloadavg()[1];
    $la_fifteen = sys_getloadavg()[2];

    $ping = $this->ping('www.google.com');
    $speed = $this->bandwidth();

    mysql_query("INSERT INTO `uptime` SET `time` = NOW()");
    mysql_query("INSERT INTO `bandwidth` SET `ping` = '$ping', `speed` = '$speed'");
    mysql_query("INSERT INTO `la` SET `one` = '$la_one', `five` = '$la_five', `fifteen` = '$la_fifteen'");

    $this->fixMissingDates('uptime');
    $this->fixMissingDates('bandwidth');
    $this->fixMissingDates('la');
  }

  /**
   *
   *
   *
   */
  private function bandwidth($interface = 'eth0')
  {
    $output = array();
    $com = 'vnstat -tr 60 -i '.$interface;
    
    $exitcode = 0;
    exec($com, $output, $exitcode);
    
    if(($exitcode == 0 || $exitcode == 1) && false === strpos($output[0], 'Error'))
    {
      foreach($output as $cline)
      {
        if(strpos($cline, 'kbit/s') !== false)
        {
          $out = floatval(substr($cline, strpos($cline, 'rx ') + 5));
          return $out;
        }
      }
    }
    else
    {print 'false';
      return $this->bandwidth('venet0');
    }
    
    return false;
  }

  /**
   *
   *
   *
   */
  private function ping($host, $timeout = 10)
  {
    $output = array();
    $com = 'ping -n -w ' . $timeout . ' -c 1 ' . escapeshellarg($host);
    
    $exitcode = 0;
    exec($com, $output, $exitcode);
    
    if($exitcode == 0 || $exitcode == 1)
    { 
      foreach($output as $cline)
      {
        if(strpos($cline, ' bytes from ') !== false)
        {
          $out = (int)ceil(floatval(substr($cline, strpos($cline, 'time=') + 5)));
          return $out;
        }
      }
    }
    
    return false;
  }

  /**
   *
   *
   *
   */
  private function fixMissingDates($action, $limit = 7, $counter = 1)
  {
    if($limit < 0)
    {
      return true;
    }

    if(mysql_num_rows(mysql_query("SELECT * FROM `$action` WHERE `time` >= (CURDATE() - $counter) AND `time` < (CURDATE() - $counter + 1)")) < 1)
    {
      mysql_query("INSERT INTO `$action` SET `time` = NOW() - INTERVAL $counter DAY");
    }

    return $this->fixMissingDates($action, $limit - 1, $counter + 1);
  }
}

/**
 *
 * Designed specifically for using this code in projects of Tooflya Inc.
 * Tooflya Inc., 2012
 *
 * @author Igor Mats from Tooflya Inc.
 * @copyright (c) 2012 by Igor Mats
 *
 */
