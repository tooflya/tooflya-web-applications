<?
require('../../config.php');

error_reporting(E_ALL);

if(isset($_GET['mail']))
{
    $to = $_GET['mail'];
    $from = "Tooflya Inc."; 
    $subject = "Tooflya | Presentation of Project Birds"; 

    $message = file_get_contents('index.html');

    $headers  = "From: Tooflya Inc. <company@tooflya.com>\r\n"; 
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n"; 

    mail($to, $subject, $message, $headers);
}
else
{
  $query = mysql_query("SELECT * FROM `subscriptions` WHERE `publisher` = '1'");
  while(false!== ($row = mysql_fetch_assoc($query)))
  {
    $to = $row['mail'];
    $from = "Tooflya Inc."; 
    $subject = "Tooflya | Presentation of Project Birds"; 

    $message = file_get_contents('index.html');

    $headers  = "From: Tooflya Inc. <company@tooflya.com>\r\n"; 
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n"; 

    /* mail($to, $subject, $message, $headers); */
  }
}

echo file_get_contents('index.html');
