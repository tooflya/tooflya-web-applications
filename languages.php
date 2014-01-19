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

      header('Location: /'.$language.''.$origin);
      exit;
    }
  }
}
else
{
  if(
  $params['path'][1] != 'ru' &&
  $params['path'][1] != 'en' &&
  $params['path'][1] != 'ajax'
  ) {
    if(Session::read('language'))
    {
        $language = Session::read('language');
    
        header('Location: /'.$language.''.$origin);
        exit;
    }
    else
    {
      $language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    
      header('Location: /'.$language.''.$origin);
      exit;
    }
  }
  else
  {
    if(Session::read('language'))
    {
      if(Session::read('language') != $params['path'][1])
      {
        if($params['path'][1] != 'ajax') Session::write('language', $params['path'][1]);

        $language = Session::read('language');
      }
      else
      {
        $language = Session::read('language');
      }
    }
    else
    {
      $language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

      Session::write('language', $language);
    }
  }
}

switch($language)
{
  case 'en':
     $language_iso = 0;
  break;

  case 'ru':
    $language_iso = 1;
  break;
}

if(Ajax::isResponse())
{
  $language = Session::read('last_language');
  $language_iso = Session::read('last_language_iso');
}
else
{
  Session::write('last_language', $language);
  Session::write('last_language_iso', $language_iso);
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
