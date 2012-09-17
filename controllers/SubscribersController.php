<?

/**
 * @file SubscribersController.php
 * @category Controller
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

class SubscribersController {

  private $getSubscribedCount = false;
  private static $instance = null;

  /**
   * 
   * Private ctor so nobody else can instance it
   *
   */
  private function __construct() {}

  private function __clone() {}

  /**
   * Call this method to get singleton
   *
   * @return SubscribersController
   */
  public static function Instance()
  {
    if (!isset(static::$instance)) {
      static::$instance = new static;
    }
    
    return static::$instance;
  }

  /**
   *
   *
   *
   */
  public function indexAction()
  {
  	if(Ajax::isResponse())
    {

    }
    else
    {
      $controller = new ErrorController();
      $controller->notFound();
    }
  }

  /**
   *
   *
   *
   */
  public function getSubscribedCount()
  {
    if(!$this->getSubscribedCount)
    {
      $this->getSubscribedCount = number_format("" + SUBSCRIBERS_COUNT + mysql_num_rows(mysql_query("SELECT * FROM `subscriptions`")), 0, '', ',');
    }

    return $this->getSubscribedCount;
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
