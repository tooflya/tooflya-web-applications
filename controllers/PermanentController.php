<?

/**
 * @file PermanentController.php
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

class PermanentController
{

  private static $instance = null;

  private $templates;
  private $name;

  private $SubscribersController;
  private $BlogController;

  /**
   * 
   * Private constructor so nobody else can instance it
   *
   */
  private function __construct($templates)
  {
    $this->templates = $templates;

    $this->BlogController = new BlogController();
    $this->SubscribersController = new SubscribersController();

    $this->templates->assign('subscribers_count', $this->SubscribersController->getSubscribedCount());
    $this->templates->assign('blog_latest_articles', $this->BlogController->getLatestArticles());
  }

  private function __clone() {}

  /**
   *
   * Call this method to get singleton
   *
   * @return SubscribersController
   */
  public static function Instance($templates)
  {
    if (!isset(static::$instance)) {
      static::$instance = new PermanentController($templates);
    }
    
    return static::$instance;
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
