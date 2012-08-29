<?

/**
 * @file Ajax.class.php
 * @category Classes
 *
 * @author Igor Mats from Tooflya Inc.
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
 */

class Ajax {
    
  /**
   *
   * Instance for the helper class of Ajax responses
   *
   */
  private static $response;

  /**
   *
   * Method to check the ajax request
   *
   * @return: state of http request
   *
   */
  public static function isResponse()
  {
      return(isset($_SERVER['HTTP_X_REQUESTED_WITH']) || isset($_SERVER['HTTP_X_FILE_NAME']) || isset($_FILES['file']));
  }

  /**
   *
   * Method to instantiate the class to work with the Ajax-buffered data
   *
   * @return: object for instance is responsible for buffering data Ajax
   *
   */
  public static function generate()
  {
      if(!isset(self::$response))
      {
          self::$response = new Ajaxresponse();
      }
          
      return self::$response;
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
