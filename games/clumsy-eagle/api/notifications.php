<?

/**
 * Tooflya Inc. Development
 *
 * @author Igor Mats from Tooflya Inc.
 * @copyright (c) 2013 by Igor Mats
 * http://www.tooflya.com/development/
 *
 * License: Attribution NonCommercial NoDerivatives 4.0 International
 *
 * Creative Commons Corporation (“Creative Commons”) is not a law firm and does
 * not provide legal services or legal advice. Distribution of Creative Commons
 * public licenses does not create a lawyer-client or other relationship.
 * Creative Commons makes its licenses and related information available on
 * an “as-is” basis. Creative Commons gives no warranties regarding its licenses,
 * any material licensed under their terms and conditions, or any related
 * information. Creative Commons disclaims all liability for damages resulting
 * from their use to the fullest extent possible.
 *
 * Creative Commons public licenses provide a standard set of terms and
 * conditions that creators and other rights holders may use to share original
 * works of authorship and other material subject to copyright and certain other
 * rights specified in the public license below. The following considerations
 * are for informational purposes only, are not exhaustive, and do not form part
 * of our licenses.
 *
 * Creative Commons may be contacted at creativecommons.org.
 *
 * @version of cocos2d-x is 2.1.4
 *
 */

require('../../../config.php');

switch(Validate::get('platform'))
{
  case 'android':
  switch(Validate::get('type'))
  {
    case 'notification':
    switch(Validate::get('action'))
    {
      case 'store':
      $id = Validate::get('id');
      $login = Validate::get('login');
      $version = Validate::get('version');

      if(mysql_num_rows(mysql_query("SELECT * FROM `notifications` WHERE `platform` = '1' AND `key` = '$id'")) <= 0)
      {
        mysql_query("INSERT INTO `notifications` SET `platform` = '1', `project` = '7', `key` = '$id', `login` = '$login', `version` = '$version'");

        print
        "
        {
          response: {
            code: 1,
            message: 'Device with Google Cloud Messaging key #$id was registered now.'
          }
        }
        ";
      }
      else
      {
        mysql_query("UPDATE `notifications` SET `login` = '$login', `version` = '$version', `date` = NOW() WHERE `key` = '$id'");

        print
        "
        {
          response: {
            code: 2,
            message: 'Device with Google Cloud Messaging key #$id already registered. Updated.'
          }
        }
        ";
      }
      break;
    }
    break;
  }
  break;
}
