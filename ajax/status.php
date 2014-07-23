<?

/**
 * @file status.php
 * @category Ajax files
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
        switch (Validate::get('server')) {
          case 'server1':
          print json_encode(array(
            'response' => 1,
            'server1' => file_get_contents('http://www.tooflya.com/ajax/status.php?action=cross-origin')
          ));
          break;
          case 'server2':
          print json_encode(array(
            'response' => 1,
            'server2' => file_get_contents('http://status.tooflya.com/ajax/status.php?action=cross-origin')
          ));
          break;
          break;
        }
      }
      break;
      case 'cross-origin':
      $controller = new StatusController();

      switch(Validate::get('type')) {
        default:
        $controller->getServerBaseInfo();
        break;
        case 'games':
        $controller->getGamesServersBaseInfo();
        break;
        case 'game':
        $controller->getGameServerInfo(Validate::get('id'));
        break;
      }
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
 * Designed specifically for using this code in projects of Tooflya Inc.
 * Gloryon Kharkov, 2012
 *
 * @author Igor Mats from Tooflya Inc.
 * @copyright (c) 2014 by Igor Mats
 *
 */
