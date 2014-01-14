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

class Session {
  
  /**
   *
   * 
   *
   */
  public static function user()
  {
    if(self::read('user'))
    {
        return true;
    }

    return false;
  }
  
  /**
   *
   * 
   *
   */
  public static function confirm()
  {
    if(self::read('Confirm'))
    {
        return true;
    }

    return false;
  }
  
  /**
   *
   * 
   *
   */
  public static function admin()
  {
    if(self::read('Privileges'))
    {
        return true;
    }

    return false;
  }
  
  /**
   *
   * 
   *
   */
  public static function read($key)
  {
    if(isset($_SESSION[$key]))
    {
        return $_SESSION[$key];
    }
    
    return false;
  }
  
  /**
   *
   * 
   *
   */
  public static function write($key, $value)
  {
    $_SESSION[$key] = $value;
    
    return true;
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
