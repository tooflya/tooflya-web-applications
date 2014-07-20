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
      'percent' => 100.0 - (((10080 - mysql_result(mysql_query("SELECT COUNT(*) FROM `uptime` WHERE date_sub(curdate(), INTERVAL 7 DAY) <= `time` ORDER by `id` DESC"), 0)) / 10080) * 100),
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
    $this->templates->assign_array("SELECT AVG(`speed`) AS `speed`, AVG(`ping`) AS `ping`, DAY(`time`) AS `day`, `time` FROM `bandwidth` GROUP BY `day` LIMIT 7", 'bandwidth');
    $this->templates->assign_array("SELECT COUNT(*) AS `count`, DAY(`time`) AS `day`, `time` FROM `uptime` GROUP BY `day` LIMIT 7", 'uptime');
    $this->templates->assign_array("SELECT AVG(`one`) AS `one`, AVG(`five`) AS `five`, AVG(`fifteen`) AS `fifteen`, DAY(`time`) AS `day`, `time` FROM `la` GROUP BY `day` LIMIT 7", 'la');

    $this->templates->display($this->name, 'base');
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
