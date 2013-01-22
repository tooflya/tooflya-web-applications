<?

/**
 * @file sites.php
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

if(Ajax::isResponse())
{
  $controller = new SitesController();

  switch(Validate::post('type'))
  {
    default:
      
      $controller->information(Validate::post('id'));

      $controller->showLayout(true);
    
    break;

    case "add":
      
      if($controller->create(Validate::post('address')))
      {
        Ajax::generate()->value("response", 1);
      }
      else
      {
        Ajax::generate()->value("response", 0);
      }

    break;

    case "remove":
      
      if($controller->remove(Validate::post('id')))
      {
        Ajax::generate()->value("response", 1);
      }
      else
      {
        Ajax::generate()->value("response", 0);
      }

    break;

    case "find":

      $controller->find(Validate::post('query'), Validate::post('problem'));

    break;

    case "update":

      $controller->update(Validate::post('id'));

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
