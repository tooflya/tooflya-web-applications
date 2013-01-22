<?

/**
 * @file events.php
 * @category Ajax files
 *
 * @author Igor Mats from Gloryon Kharkov
 * @copyright (c) 2012 by Igor Mats
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

/**
 *
 * TABLE OF EVENTS
 *
 * 1 - USER IS ONLINE
 * 2 - USER IS OFFLINE
 *
 * 3 - ADDED NEW SITE
 * 4 - SOME SITE WAS DELETED
 * 5 - SOME SITE WAS UPDATED
 *
 */
sleep(3);
require('../config.php');

if(Ajax::isResponse())
{
  if(Session::user())
  {
    $eventStatus = false;
    $eventLoopCount = 0;

    while(/**!$eventStatus or **/$eventLoopCount < 1)
    {
      $response = array();
      $response['online'] = array();
      $response['offline'] = array();
      $response['newsite'] = array();
      $response['delsite'] = array();
      $response['updsite'] = array();

      $selectEventsData = mysql_query("SELECT * FROM `events` WHERE `receiver` = '".Session::read('id')."' AND `timestamp` > NOW() - 5 AND `received` = '0'");
            
      while ($data = mysql_fetch_assoc($selectEventsData))
      {
        switch($data['type'])
        {
          // User is online
          case 1:

            $senderData = mysql_query("SELECT * FROM `corp_users` WHERE `id` = '".$data['sender']."'");
            
            while ($sd = mysql_fetch_assoc($senderData))
            {
              $response['online'][] = array('eventID' => $data['id'], 'id' => $sd['id'], 'name' => $sd['name'], 'surname' => $sd['surname'], 'avatar' => $sd['avatar'], 'sex' => $sd['sex']);
            }

          break;

          // User is offline
          case 2:

            $senderData = mysql_query("SELECT * FROM `corp_users` WHERE `id` = '".$data['sender']."'");
            
            while ($sd = mysql_fetch_assoc($senderData))
            {
              $response['offline'][] = array('eventID' => $data['id'], 'id' => $sd['id'], 'name' => $sd['name'], 'surname' => $sd['surname'], 'avatar' => $sd['avatar'], 'sex' => $sd['sex']);
            }

          break;
        }

        // DELETE EVENT
        mysql_query("UPDATE `events` SET `received` = '1' WHERE `id` = '".$data['id']."'");
      }

      if(mysql_num_rows($selectEventsData) > 0)
      {
            
        Ajax::generate()->value("response", json_encode($response));

        $eventStatus = true;
      }
      else
      {
        // sleep(1);
      }
      
      $eventLoopCount++;
    }

    if(!$eventStatus)
    {
      Ajax::generate()->value("response", 2);
    }
  }
  else
  {
    Ajax::generate()->value("response", 2);
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
