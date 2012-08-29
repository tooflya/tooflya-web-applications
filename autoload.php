<?

/**
 * @file autoload.php
 * @category Executable files
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
 *
 *
 * This is function __autoload
 *
 * @param mixed $class_name Name of the included class
 *
 */

if(!function_exists('autoload'))
{
  function autoload($class_name)
  {
    if($class_name == "Smarty")
    {
      include(PATH.'/tools/smarty/Smarty.class.php');
    }
    
    if(!@include(PATH.'/core/'.$class_name.'.class.php'))
    {
      include(PATH.'/controllers/'.$class_name.'.php');
    }
  }

  spl_autoload_register("autoload");
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
