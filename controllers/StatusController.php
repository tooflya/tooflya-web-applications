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
      'percent' => '93.8'
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
        'ip' => gethostbyname(gethostname()),
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
        'bandwidth' => mysql_result(mysql_query("SELECT AVG(`speed`) FROM `bandwidth`"), 0),
        'ping' => mysql_result(mysql_query("SELECT AVG(`speed`) FROM `bandwidth`"), 0)
      )
    ));
    $this->templates->assign_array("SELECT * FROM `bandwidth`", 'bandwidth');

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
