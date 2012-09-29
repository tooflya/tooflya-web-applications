<?

/**
 * @file Session.class.php
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
  
class Validate {
  
  /**
   *
   * 
   *
   */
  function __construct()
  {
      
  }
  
  /**
   * Method to validate string valiables
   *
   * @mixed: string to validate
   *
   * @return: filtered variable
   */
  public static function string($var)
  {
    return trim($var);
  }
  
  /**
   * Method to validate integer valiables
   *
   * @mixed: string to validate
   *
   * @return: filtered variable
   */
  public static function int($var)
  {
    return abs(intval($var));
  }
  
  /**
   * Method to validate sql valiables
   *
   * @mixed: string to validate
   *
   * @return: filtered variable
   *
   */
  public static function sql($var)
  {
    return trim(mysql_real_escape_string($var));
  }
  
  /**
   * Method to validate POST variables
   *
   * @mixed: key of POST global array
   * @bool: (optional) if it's true the variable is filter for sql queries
   *
   * @return: value of POST element with some key
   */
  public static function post($var, $param = true)
  {

      if(!isset($_POST[$var]))
      {
        return false;
      }
      
      $var = $_POST[$var];
      
      if($param)
      {
        return self::sql($var);
      }
      
      return $var;
  
  }
  
  /**
   * Method to validate GET variables
   *
   * @mixed: key of GET global array
   * @bool: (optional) if it's true the variable is filter for sql queries
   *
   * @return: value of GET element with some key
   */

  public static function get($var, $param = true)
  {
      if(!isset($_GET[$var]))
      {
        return false;
      }

      $var = $_GET[$var];
      
      if($param)
      {
          return self::sql($var);
      }
      
      return $var;
  }
  
  /**
   *
   * Method to validate (check) email addresses
   *
   * @mixed: some email address
   *
   * @return: boolean value, result of validate
   *
   */
  public static function email($email)
  {
    $pattern = '/^[a-z0-9а-яё](?:\.?[-a-z0-9а-яё_]){0,148}[a-z0-9а-яё]@[a-z0-9а-яё](?:-?[a-z0-9а-яё]){0,61}\.(?:[a-z0-9а-яё](?:-?[a-z0-9а-яё]){0,61}[a-z0-9а-яё]\.)?(?:рф|укр|[a-z]{1,4})$/iu';
      
    return preg_match($pattern, $email);
  }

  /**
   *
   * Method to validate phone number
   *
   * @mixed: some phone number
   *
   * @return: boolean value, result of validate
   *
   */
  public static function phone($phone)
  {
    $pattern = '/^(?:\+380|380|80|0)\d{9}$/';
      
    return preg_match($pattern, $phone);
  }

  /**
   *
   * Method to validate url address
   *
   * @mixed: some url address
   *
   * @return: boolean value, result of  validate
   *
   */
  public static function url($url)
  {
    $pattern = "/^[a-zA-Z]+[:\/\/]+[A-Za-z0-9\-_]+\\.+[A-Za-z0-9\.\/%&=\?\-_]+$/i";
      
    return preg_match($pattern, $url);
  }

  /**
   *
   * Method to validate post data
   *
   * @return: 
   *
   */
  public static function isPost()
  {
    if($_POST) return true;
  
    return false;
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