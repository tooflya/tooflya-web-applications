<?

/**
 * @file status.php
 * @category Ajax files
 *
 * @author Igor Mats from Gloryon Kharkov
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
 * @version 1.0.0
 *
 */

require('../config.php');

if(true)
{
  switch(Validate::get('action'))
  {
    default:
    switch(Validate::get('action'))
    {
      default:
      if(Ajax::isResponse())
      {
        $server1 = file_get_contents('http://www.tooflya.com/ajax/status.php?action=cross-origin');
        $server2 = file_get_contents('https://status.tooflya.com/ajax/status.php?action=cross-origin');

        print json_encode(array(
          'response' => 1,
          'server1' => $server1,
          'server2' => $server2
        ));
      }
      break;
      case 'cross-origin':
      $controller = new StatusController();

      $controller->getServerBaseInfo();
      break;
    }
    break;
    case 'update':
    $controller = new StatusController();

    $controller->setServerBaseInfo();

    print "Update was successful.";
    break;
  }
}

/**
 *
 * Designed specifically for using this code in projects of Gloryon Kharkov
 * Gloryon Kharkov, 2012
 *
 * @author Igor Mats from Gloryon Kharkov
 * @copyright (c) 2012 by Igor Mats
 *
 */
