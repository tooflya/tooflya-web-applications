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

  private $page;
  private $itemsOnPage = 4;
  
  /**
   *
   *
   *
   */
  public function indexAction($articleOrClass = false, $page = 0)
  {
    $this->page = $page;

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
      /** Maybe it's page number? **/
      else
      {
        if(is_numeric($articleOrClass))
        {
          $this->page = $articleOrClass;
      
          $this->templates->assign(TITLE, 'Interesting records for you');
          $this->getArticlesClasses();
          $this->getLatestArticles();
          $this->templates->display($this->name);
        }
        else
        {
          /** Nothing found **/

          $controller = new ErrorController();
          $controller->notFound();
        }
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
    $this->templates->assign_element("SELECT * FROM `blog` LEFT JOIN `users` ON (`blog`.`user` = `users`.`id`) LEFT JOIN `blog_classes` ON (`blog`.`class` = `blog_classes`.`cid`) WHERE `blog`.`article_alias` = '".$article."' AND  `blog`.`language` = ".LANGUAGE, 'some');
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
    $elements_count = 0;

    if(!$class)
    {
      $elements_count = mysql_num_rows(mysql_query("SELECT * FROM `blog` WHERE `visible` = '1' AND `language` = ".LANGUAGE.""));

      $this->templates->assign_array("SELECT * FROM `blog` LEFT JOIN `users` ON (`blog`.`user` = `users`.`id`) LEFT JOIN `blog_classes` ON (`blog`.`class` = `blog_classes`.`cid` AND `blog_classes`.`language` = '".LANGUAGE."') WHERE `blog`.`visible` = '1' AND `blog`.`language` = '".LANGUAGE."' ORDER by `blog`.`id` DESC LIMIT ". ($this->page * $this->itemsOnPage) .", ". ($this->itemsOnPage), 'blog_latest_articles');
    }
    else
    {
      $elements_count = mysql_num_rows(mysql_query("SELECT * FROM `blog` WHERE `blog`.`class` = (SELECT `cid` FROM `blog_classes` WHERE `alias` = '".$class."' AND `language` = ".LANGUAGE.") AND `visible` = '1' AND `language` = ".LANGUAGE.""));

      $this->templates->assign_array("SELECT * FROM `blog` LEFT JOIN `users` ON (`blog`.`user` = `users`.`id`) LEFT JOIN `blog_classes` ON (`blog`.`class` = `blog_classes`.`cid` AND `blog_classes`.`language` = '".LANGUAGE."') WHERE `blog`.`class` = (SELECT `cid` FROM `blog_classes` WHERE `alias` = '".$class."' AND `language` = ".LANGUAGE.") AND `blog`.`visible` = '1' AND  `blog`.`language` = ".LANGUAGE." ORDER by `blog`.`id` DESC LIMIT ". ($this->page * $this->itemsOnPage) .", ". ($this->itemsOnPage), 'blog_latest_articles');
      $this->templates->assign('class', $class .'/');
    }

    $this->templates->assign('page', $this->page);
    $this->templates->assign('maxPage', $elements_count / $this->itemsOnPage - 1);

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
