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

  private static $instance;
  
  /**
   *
   * 
   *
   */
  function __construct()
  {
    parent::__construct();

    global $language, $language_iso;

    define('LANGUAGE', $language_iso);

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
    $this->assign('url', URL.'/'.$language);
    $this->assign('ajax', Ajax::isResponse());
    $this->assign('user', Session::user());
    $this->assign('language', $language);

    /**
     *
     * This function is create for smarty templates
     * She using in engine like abstract function for Language class
     *
     * @param array $params On of smarty strings params
     *
     */
    if(!function_exists('l'))
    {
      function l($params)
      {
        global $language;

        @include(PATH.'languages/'.$language.'.php');

        if(isset($_LANGUAGES[Encode::code($params['s'])]))
          return $_LANGUAGES[Encode::code($params['s'])];

        return /**Encode::code*/($params['s']);
      }
    }

    /**
     *
     * This function is
     *
     * @param 
     *
     */
    if(!function_exists('i'))
    {
      function i($params)
      {
        return preg_replace('!http://([a-zA-Z0-9./-]+[a-zA-Z0-9/-])!i', '<a href="\\0" target="_blank">\\0</a>', $params['s']);
      }
    }

    /**
     *
     * Register smarty functions wich 
     * we will using in Smarty templates
     *
     * function p() - Insert BBCodes for using in templates
     * function l() - Insert language function for using in templates
     *
     */
    $this->registerPlugin("function", "l", "l");
    $this->registerPlugin("function", "i", "i");
  }

  /**
   *
   * Call this method to get singleton
   *
   * @return SubscribersController
   */
  public static function Instance()
  {
    if (!self::$instance) {
      self::$instance = new Template();
    }
    
    return self::$instance;
  }
  
  /**
   *
   * 
   *
   */
   public function display($controller, $template = 'index')
   {
    $this->assign('tab', $controller.'/'.$template);
    
    parent::display($controller.'/'.$template.'.html');
   }
  
  /**
   *
   * 
   *
   */
   public function capture($controller, $template = 'index')
   {
    return parent::fetch($controller.'/'.$template.'.html');
   }
  
  /**
   *
   * 
   *
   */
   public function assign_array($query, $name)
   {
    $data = mysql_query($query) or die(mysql_error());

    $results = array();
    while($row = mysql_fetch_assoc($data))
    {
      $results[] = $row;
    }

    $this->assign($name, $results); 
  }
  
  /**
   *
   * 
   *
   */
   public function assign_element($query, $name)
   {
    $data = mysql_query($query) or die(mysql_error());

    $results = array();
    while($row = mysql_fetch_assoc($data))
    {
      $results = $row;
    }

    $this->assign($name, $results); 
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
