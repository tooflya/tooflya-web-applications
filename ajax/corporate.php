<?

/**
 * @file permissions.php
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

require('../config.php');
require('../languages.php');

if(Ajax::isResponse())
{
  $controller = new CorpCommunityController();

  switch(Validate::post('type'))
  {
    case "profile":

      $controller->showProfile(Validate::post('id'));

    break;

    case "events":

      if(Validate::post('user'))
      {
        $controller->showUserEvents();
      }
      else
      {
        $controller->showEvents();
      }

    break;

    case "add-task":

      $controller->addTask();

    break;

    case 'task-change-status':

      $controller->changeTaskStatus(Validate::post('id'), Validate::post('status'));

    break;

    case "delete-task":

      $controller->deleteTask(Validate::post('id'));

    break;

    case "task":

      $controller->showTask(Validate::post('id'));

    break;

    case "settings":

      $controller->showSettings();

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
