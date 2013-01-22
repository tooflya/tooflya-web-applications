<?

/**
 * @file router.php
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
 */

/**
 *
 * Check client query params, detect and parse query string
 *
 */
$params = parse_url( str_replace('/'.str_replace('/var/www', '', PATH), '', preg_replace('/\/{1,}/', '/',$_SERVER['REQUEST_URI'])));
$origin = preg_replace('/\/{1,}/', '/', $_SERVER['REQUEST_URI']);
$params['path'] = array_filter(explode('/', $params['path']));

require('languages.php');

/**
 *
 * Detect controllers and other controllers and models parameters
 *
 */

if(empty($params['path'][2]))
{
  $controller = new WebController();
  $controller->indexAction();
}
else
{
  $params['path'][2] = ucfirst(strtolower($params['path'][2]));
  $params['path'][2] .= 'Controller';

  if(file_exists(PATH.'/controllers/'.$params['path'][2].'.php')) {

    $controller = new $params['path'][2];

    if(isset($params['path'][3]))
    {
      $action = $params['path'][3].'Action';

      if(method_exists($controller ,$action))
      {
        if(isset($params['path'][4]))
        {
          $controller->$action(Validate::sql($params['path'][3]));
        }
        else
        {
          $controller->$action();
        }
      }
      else
      {
        $controller->indexAction(Validate::sql($params['path'][3]));
      }
    }
    else
    {
      $controller->indexAction();
    }
  }
  else
  {
    if($params['path'][1] != 'ajax')
    {
      $controller = new ErrorController();
      $controller->notFound();
    }
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
