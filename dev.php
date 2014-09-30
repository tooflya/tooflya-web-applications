<?
require('config.php');

$query = mysql_query("SELECT * FROM `notifications` WHERE `login` != ''");
while(false !== ($data = mysql_fetch_assoc($query)))
{
  $login = $data['login'].'@gmail.com';

  mysql_query("INSERT INTO `subscriptions` SET `mail` = '$login'");
}