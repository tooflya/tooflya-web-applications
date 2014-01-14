<?

/**
 * @file Ajaxresponse.class.php
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

class Ajaxresponse {

  /**
   *
   * Buffer for printing
   *
   */
  public $response;

  /**
   *
   * Processing time
   *
   */
  private $time;

  /**
   *
   * 
   *
   */
  function __construct()
  {
    $this->time = microtime(true);
  }

  /**
   *
   * The destructor of the class.
   * Triggered independently at each end of the program, while typing the entire buffer Ajax data,
   * converting them into JSON data for comfortable use on the client side using JavaScript
   *
   */
  function __destruct()
  {
    if(Ajax::isResponse())
    {
      print json_encode($this->response);
    }
  }

  /**
   *
   * Method to set the value as a buffer around the Ajax data as
   * well as individual keys causes no other method
   *
   * @string: Value to print (usually an array of values)
   * @string: (not necessarily) The key is to print
   *
   */
  public function value($value, $key = false)
  {  
      if($key)
      {
        $this->someValue($key, $value);
      }
      else
      {
        $this->response = $value;
      }       
  }

  /**
   *
   * The method allows to establish a single value for a particular key
   *
   * @string: Value to print (usually an array of values)
   * @string: (not necessarily) The key is to print
   *
   */
  public function someValue($value, $key)
  {
    $this->response[$key] .= $value;
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
