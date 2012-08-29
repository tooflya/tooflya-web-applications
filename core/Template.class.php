<?

/**
 * @file Template.class.php
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

class Template extends Smarty {
  
  /**
   *
   * 
   *
   */
  function __construct()
  {
    parent::__construct();

    /**
     *
     * This instructions created for support Smarty templates
     * We initial smarty dir and compiled templates dir
     *
     */
    $this->template_dir = PATH.'/views/';
    $this->compile_dir = PATH.'/tools/smarty/templates';
    $this->cache_dir = PATH.'/tools/smarty/cache';
            
    $this->caching = false; 
    $this->compile_check = true; 
    $this->cache_lifetime = 20*60;
    $this->debugging = false;

    /**
     *
     * Define variables for the template engine
     *
     */
    $this->assign('ajax', Ajax::isResponse());
    $this->assign('user', Session::user());
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
