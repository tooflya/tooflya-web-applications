<?

/**
 * @file BlogController.php
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

class BlogController extends BaseController
{

  /**
   *
   *
   *
   */
  public function indexAction($articleOrClass = false)
  {
    if(!$articleOrClass)
    {
      $this->templates->assign(TITLE, 'Interesting records for you');
      $this->getArticlesClasses();
      $this->templates->display($this->name);
    }
    else
    {
      /** Check for class **/
      if($this->isClassExist($articleOrClass))
      {
        $this->getArticlesClasses();
        $this->getLatestArticles($articleOrClass);
        $this->templates->assign(TITLE, ucfirst($articleOrClass));
        $this->templates->display($this->name);
      }
      /** Check for article **/
      elseif($this->isArticleExist($articleOrClass))
      {
        $this->getArticle($articleOrClass);
        $temp = $this->templates->getTemplateVars('some');
        $this->templates->assign(TITLE, $temp['title']);
        $this->templates->display($this->name, 'article');
      }
      /** Nothing found **/
      else
      {
        $controller = new ErrorController();
        $controller->notFound();
      }
    }
  }

  /**
   *
   *
   *
   *
   */
  private function isClassExist($class)
  {
    return mysql_num_rows(mysql_query("SELECT * FROM `blog_classes` WHERE `alias` = '$class' AND `language` = ".LANGUAGE)) > 0;
  }

  /**
   *
   *
   *
   *
   */
  private function isArticleExist($class)
  {
    return mysql_num_rows(mysql_query("SELECT * FROM `blog` WHERE `article_alias` = '$class' AND `language` = ".LANGUAGE)) > 0;
  }

  /**
   *
   *
   *
   */
  private function getArticle($article)
  {
    $this->templates->assign_element("SELECT * FROM `blog` LEFT JOIN `users` ON (`blog`.`user` = `users`.`id`) LEFT JOIN `blog_classes` ON (`blog`.`class` = `blog_classes`.`id`) WHERE `blog`.`article_alias` = '".$article."' AND  `blog`.`language` = ".LANGUAGE, 'some');
  }

  /**
   *
   *
   *
   */
  public function getArticlesClasses()
  {
    $this->templates->assign_array("SELECT * FROM `blog_classes` WHERE `language` = '".LANGUAGE."'", 'blog_classes');
  }

  /**
   *
   *
   *
   */
  public function getLatestArticles($class = false)
  {
    if(!$class)
    {
      $this->templates->assign_array("SELECT * FROM `blog` LEFT JOIN `users` ON (`blog`.`user` = `users`.`id`) LEFT JOIN `blog_classes` ON (`blog`.`class` = `blog_classes`.`id`) WHERE `blog`.`visible` = '1' AND `blog`.`language` = '".LANGUAGE."' ORDER by `blog`.`id` DESC LIMIT 5", 'blog_latest_articles');
    }
    else
    {
      $this->templates->assign_array("SELECT * FROM `blog` LEFT JOIN `users` ON (`blog`.`user` = `users`.`id`) LEFT JOIN `blog_classes` ON (`blog`.`class` = `blog_classes`.`id`) WHERE `blog`.`class` = (SELECT `id` FROM `blog_classes` WHERE `alias` = '".$class."' AND `language` = ".LANGUAGE.") AND `blog`.`visible` = '1' AND  `blog`.`language` = ".LANGUAGE." ORDER by `blog`.`id` DESC LIMIT 5", 'blog_latest_articles');
    }

    return $this->templates->capture($this->name, "bottom");
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
