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

  private static $instance;

  private $templates;
  private $name;

  private $SubscribersController;
  private $BlogController;
  private $SocialController;

  /**
   * 
   *
   *
   */
  private function __construct($templates)
  {
    $this->templates = $templates;
  }

  private function __clone() {}

  private function Prepare()
  {
    $this->BlogController = new BlogController();
    $this->SubscribersController = new SubscribersController();
    $this->SocialController = new SocialController();

    $this->templates->assign('subscribers_count', $this->SubscribersController->getSubscribedCount());
    $this->templates->assign('blog_latest_articles_template', $this->BlogController->getLatestArticles());
    $this->templates->assign('social_last_tweets', $this->SocialController->getLatestTweets());
  }

  /**
   *
   * Call this method to get singleton
   *
   * @return SubscribersController
   */
  public static function Instance($templates)
  {
    if (!self::$instance) {
      self::$instance = new PermanentController($templates);
      self::$instance->Prepare();
    }
    
    return self::$instance;
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
