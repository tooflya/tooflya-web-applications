<?
require('../../config.php');

$query = mysql_query("SELECT * FROM `subscriptions`");
while(false!==($row = mysql_fetch_assoc($query)))
{
    //change this to your email. 
    $to = $row['mail'];
    $from = "compamy@tooflya.com"; 
    $subject = "Tooflya | You Are Awesome!"; 

    //begin of HTML message 
    $message = <<<EOF
<html>
  <head>
    <title>Tooflya | You Are Amazing!</title>
  </head>
  <body>
    <table width="100%" cellspacing="0" cellpadding="0">
      <tbody>
        <tr height="40"></tr>
        <tr>
          <td valign="top">
            <center>
              <table width="530" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                    <td>
                      <img width="148px" height="56px" src="http://www.tooflya.com/assets/img/logo_small_wh.png">
                    </td>
                  </tr>
                </tbody>
              </table>
            </center>
          </td>
        </tr>
        <tr height="40">
          <td></td>
        </tr>
        <tr>
          <td valign="top">
            <center>
              <table width="530" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                    <td>
                      <p style="color:#606060;font-family:Arial,Helvetica,sans-serif;font-size:28px;line-height:1;margin:0 0 10px;">You Are Amazing!</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">We are thank's you for subscribe to the our official site. Interesting news from the world of mobile innovation, game reviews for the mobile devices, and of course, our new products - all this and many more of you are now able to find in our newsletter. <b>Thank you for being with us</b>.</p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </center>
          </td>
        </tr>
        <tr height="20">
          <td></td>
        </tr>
        <tr>
          <td>
            <center>
              <table cellspacing="0" cellpadding="0">
                <tbody><tr>
                  <td>
                    <img width="530" height="11" src="http://www.tooflya.com/assets/img/divider.png">
                  </td>
                </tr>
              </tbody></table>
            </center>
          </td>
        </tr>
        <tr height="30">
          <td></td>
        </tr>
        <tr>
          <td valign="top">
            <center>
              <table width="530" cellspacing="0" cellpadding="0">
                <tbody><tr>
                  <td>
                    <p style="color:#626262;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0 0 15px;">Don't forget to <a href="http://twitter.com/tooflya"  target="_blank">follow Tooflya on Twitter</a> and <a href="http://www.facebook.com/tooflya" style="color:#00aff0;text-decoration:underline;" target="_blank">like us on Facebook</a>!&nbsp;Any questions? Check out our <a href="" style="color:#00aff0;text-decoration:underline;" target="_blank">website</a>, or reply to this email. Have a good day!</p>
                    <p style="color:#606060;font-family:Arial,Helvetica,sans-serif;font-size:20px;line-height:28px;margin:0;">Regards,<br><b>Tooflya Team</b></p>
                  </td>
                </tr>
              </tbody></table>
            </center>
          </td>
        </tr>
        <tr height="40">
          <td></td>
        </tr>
        <tr>
          <td style="background-color:#f9f9f9;border-top:solid 1px #ededed;border-bottom:solid 1px #ededed;">
            <table width="100%">
              <tbody><tr>
                <td height="20"></td>
              </tr>
              
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#868a8c;line-height:16px;" align="center">
                  You are receiving this email because you (or someone pretending to be you) subscribed to our newsletter.<br>
                  If this is you no longer interested you can <a href="http://www.tooflya.com" style="color:#868a8c;text-decoration:underline;" class="daria-goto-anchor" target="_blank">unsubscribe just now</a>.
                </td>
              </tr>
              <tr>
                <td height="8"></td>
              </tr>
              <tr>
                <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#868a8c;line-height:18px;" align="center"><b>Tooflya Inc</b>., Sunnny Isles Beach, FL. US 33160</td>
              </tr>
              <tr>
                <td height="8"></td>
              </tr>
              <tr>
                <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#868a8c;line-height:18px;" align="center">© 2012 Tooflya Inc.</td>
              </tr>
              <tr>
                <td height="20"></td>
              </tr>
            </tbody></table>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html> 
EOF;
   //end of message 
    $headers  = "From: $from\r\n"; 
    $headers .= "Content-type: text/html\r\n"; 

    //options to send to cc+bcc 
    //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
    //$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 
     
    // now lets send the email. 
    mail($to, $subject, $message, $headers); 

    echo $to; 
  }
?>
