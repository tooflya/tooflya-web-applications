<?

/**
 * @file languages.php
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

if(Validate::isPost())
{
  if(Validate::post('language'))
  {
    if(Session::read('language') != Validate::post('language'))
    {
      $language = Validate::post('language');
      Session::write('language', $language);

      $origin = str_replace('/ru', '', $origin);
      $origin = str_replace('/en', '', $origin);

      header("HTTP/1.1 301 Moved Permanently");
      header('Location: /'.$language.''.$origin);
      exit;
    }
  }
}
else
{
  if(
  $params['path'][1] != 'ru' &&
  $params['path'][1] != 'en'
  )
  {
    if(Session::read('language'))
    {
      $language = Session::read('language');
    }
    else
    {
      $language = $params['path'][1];
      Session::write('language', $language);
    }

    header("HTTP/1.1 301 Moved Permanently");
    header('Location: /'.$language.''.$origin);
    exit;
  }
  else
  {
    if(Session::read('language'))
    {
      if(Session::read('language') != $params['path'][1])
      {
        Session::write('language', $params['path'][1]);
        $language = Session::read('language');
      }
      else
      {
        $language = Session::read('language');
      }
    }
  }
}

$switch = Session::read('language') ? Session::read('language') : $params['path'][1];
switch($switch)
{
  case 'en':
     $language_iso = 0;
  break;

  case 'ru':
    $language_iso = 1;
  break;
}
print_r($_SESSION);print_r($params);
/**
 *
 * Designed specifically for using this code in projects of Tooflya Inc.
 * Tooflya Inc., 2012
 *
 * @author Igor Mats from Tooflya Inc.
 * @copyright (c) 2012 by Igor Mats
 *
 */
