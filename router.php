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
$host = array_filter(explode('.', $_SERVER['HTTP_HOST']));
$params = parse_url(str_replace('/'.str_replace('/var/www', '', PATH), '', preg_replace('/\/{1,}/', '/', $_SERVER['REQUEST_URI'])));
$origin = preg_replace('/\/{1,}/', '/', $_SERVER['REQUEST_URI']);
$params = array_filter(explode('/', $params['path']));

if($params[1] != 'ajax')
{
  $param = $host[0];

  $host[0] = ucfirst(strtolower($host[0]));
  $host[0] .= 'Controller';

  $controller = file_exists(PATH.'/controllers/'.$host[0].'.php');

  if($controller)
  {
    array_unshift($params, $param);
  }

  if($params[1] != 'ru' && $params[1] != 'en')
  {
    array_unshift($params, Session::read('language'));
    array_unshift($params, Session::read('language'));
  }
  else if($controller)
  {
    $l = $params[1];

    array_shift($params);
    array_shift($params);

    array_unshift($params, $param);

    array_unshift($params, $l);
    array_unshift($params, $l);
  }

  require('languages.php');
}

/**
 *
 * Detect controllers and other controllers and models parameters
 *
 */

if(empty($params[2]))
{
  $controller = new WebController();
  $controller->indexAction();
}
else
{
  $params[2] = ucfirst(strtolower($params[2]));
  $params[2] .= 'Controller';

  if(file_exists(PATH.'/controllers/'.$params[2].'.php'))
  {
    $controller = new $params[2];

    if(isset($params[3]))
    {
      $action = $params[3].'Action';

      if(method_exists($controller, $action))
      {
        if(isset($params[4]))
        {
          $controller->$action(Validate::sql($params[4]));
        }
        else
        {
          $controller->$action();
        }
      }
      else
      {
        if(isset($params[4]))
        {
          $controller->indexAction(Validate::sql($params[3]), Validate::sql($params[4]));
        }
        else
        {
          $controller->indexAction(Validate::sql($params[3]));
        }
      }
    }
    else
    {
      $controller->indexAction();
    }
  }
  else
  {
    if($params[1] != 'ajax')
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
