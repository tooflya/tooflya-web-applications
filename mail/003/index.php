<?
require('../../config.php');

ini_set('max_execution_time', 100);
error_reporting(E_ALL);

$query = mysql_query("SELECT * FROM `subscriptions`");
while(false!==($row = mysql_fetch_assoc($query)))
{
    //change this to your email. 
    $to = $_GET['mail'];//$row['mail'];
    $from = "compamy@tooflya.com"; 
    $subject = "Tooflya | Presentation of Project Birds (Test for publishers)"; 

    //begin of HTML message 
    $message = <<<EOF
<html>
  <head>
    <title>Tooflya | Presentation of Project Birds</title>
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
                      <p style="color:#606060;font-family:Arial,Helvetica,sans-serif;font-size:28px;line-height:1;margin:0 0 10px;">We Want to Introduce You a New Game!</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">We are very excited to introduce you our new game <a target="_blank" style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:20px;text-decoration:none;letter-spacing:-1.0px;" href="http://play.tooflya.com/en/">Project Birds*</a> <b>available soon</b> not only for mobile platforms such as <b>iOS</b> and <b>Android</b>, but also for social networks <b>Facebook and VK</b> (using <a target="_blank" href="http://en.wikipedia.org/wiki/HTML5" style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;text-decoration:none;letter-spacing:-1.0px;">HTML5</a>).</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;padding:10px 0;text-align:center;"><img src="http://www.tooflya.com/assets/img/mail/003/Fz5NLoRa5f4.jpg" alt="" /></p>
                      <div>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>We are looking for a publisher</b> for awesome game <b>Project Birds*</b>.</p>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">If you are interested in our game please reply to this email or use the following contact information:</p>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;padding-top:15px;">Email: <a style="text-decoration:none;font-size:21px;color:#00aff0;" href="mailto:company@tooflya.com">company@tooflya.com</a></p>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;padding-top:15px;">We are looking forward to your response and look forward to working.</p>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>This game deserves to show it to the world!</b></p>
                        <p style="">
                          <p style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:18px;line-height:1;padding-top:20px;">Some screenshots</p>
                          <ul style="padding-bottom:20px;list-style-type:none;">
                            <li style="display:inline-block;"><a target="_blank" href="//"><img src="http://www.tooflya.com/assets/img/mail/003/76FzlaADCi.jpg" alt="" style="background-color:#fff;padding:5px;border:1px #ccc solid;" /></a></li>
                            <li style="display:inline-block;"><a target="_blank" href="//"><img src="http://www.tooflya.com/assets/img/mail/003/ZAyn3apYhD.jpg" alt="" style="background-color:#fff;padding:5px;border:1px #ccc solid;" /></a></li>
                            <li style="display:inline-block;"><a target="_blank" href="//"><img src="http://www.tooflya.com/assets/img/mail/003/Umwrhl5n9y.jpg" alt="" style="background-color:#fff;padding:5px;border:1px #ccc solid;" /></a></li>
                          </ul>
                        </div>
                        <p style="text-align:center;padding-bottom:40px;"><a target="_blank" href="http://play.tooflya.com/en/"><img src="http://www.tooflya.com/assets/img/mail/003/Olbbw1xoCA.png" alt="" style="" /></a></p>
                        <p style="clear:both;"></p>
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <center>
                        <table cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td>
                                <img width="530" height="11" src="http://www.tooflya.com/assets/img/divider.png">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </center>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p style="float:left;margin:0;text-align:center;">
                        <img src="http://www.tooflya.com/assets/img/mail/003/e0YQIIXcwd.jpg" alt="" style="border-radius:99px;background-color:#fff;border:1px #eee solid;padding:1px;margin-bottom: 5px;" /><br />
                        <span style="color:#ABC2DB;font-size:11px;">Igor Mats</span><br />
                        <span style="color:#ABC2DB;font-size:11px;">CEO</span>
                      </p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:18px;margin:0;font-style:italic;padding-left:60px;padding-top:2px;">In this letter we have tried as clearly as possible to answer for all questions that may arise in the first look on the our game. If you have any questions please feel free to contact us by email.</p>
                      <p style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:18px;line-height:1;padding-top:30px;">General Information</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b style="display:inline-block;min-width:250px;">Name:</b> <a target="_blank" style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:20px;text-decoration:none;letter-spacing:-1.0px;" href="http://play.tooflya.com/en/">Project Birds*</a></p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b style="display:inline-block;min-width:250px;">Genre:</b> Match-3</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b style="display:inline-block;min-width:250px;">Supported platforms:</b> iOS, Android, Facebook, VK</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b style="display:inline-block;min-width:250px;">Type of monetization:</b> free-2-play, In-App Purchases</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b style="display:inline-block;min-width:250px;">Multiplayer:</b> Yes</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b style="display:inline-block;min-width:250px;">Social integration:</b> Yes</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b style="display:inline-block;min-width:250px;">Synchronization with web-version:</b> Yes or optional</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b style="display:inline-block;min-width:250px;">Used framework:</b> Cocos2d-x, Cocos2d-js</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b style="display:inline-block;min-width:250px;">Used server technology:</b> PHP, Node.js, MySQL</p>
                      <p style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:18px;line-height:1;padding-top:20px;">What is this game?</p>
                      <p>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><a target="_blank" style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:20px;text-decoration:none;letter-spacing:-1.0px;" href="http://play.tooflya.com/en/">Project Birds*</a> it's a incredible game with <b>Match-3</b> mechanic in a modern twist which tells the story of the battle of fabulous feathered characters.</p>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">The player will go through 30 (at this moment) levels in order to release the prisoners of the royal army of birds meeting on the way strong and dangerous detention.</p>
                        <p style="clear:both;"></p>
                      </p>
                      <p style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:18px;line-height:1;padding-top:20px;">How to play?</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">Each level is a matrix of the game elements (plates) and rival. The player should move one of the <b>10 types</b> of game plates to collect <b>3 or more identical plates </b> in a row, each of which carries its own meaning. Player and opponent perform his move in turn.</p>
                      <p style="text-align:center;"><img src="http://www.tooflya.com/assets/img/mail/003/RO7w7CeJKW.png" alt="" style="" /></p>
                      <p style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:18px;line-height:1;padding-top:20px;">What are the key features of the game?</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">
                        <ul>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>11 types</b> of weapon available in shop;</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>9 types</b> additional characters available for purchase to the player;</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>5 types</b> bonuses are available for purchase to the player;</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>30</b> thoughtful and challenging levels;</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>2</b> additional game modes;</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>60</b> achievements;</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>Play with friends in multiplayer mode</b>;</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>The clever monetization</b>;</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>Integrated social functions</b>;</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">Up to <b>10 additional languages</b>;</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>Cross-platform</b>;</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">Daily rewards;</li>
                        </ul>
                      </p>
                      <p style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:18px;line-height:1;padding-top:20px;padding-bottom:20px;">How monetization works?</p>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <center>
                        <table cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td>
                                <img width="530" height="11" src="http://www.tooflya.com/assets/img/divider.png">
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </center>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <p style="float:left;margin:0;text-align:center;">
                        <img src="http://www.tooflya.com/assets/img/mail/003/zzVreq0KIK.jpg" alt="" style="border-radius:99px;background-color:#fff;border:1px #eee solid;padding:1px;margin-bottom: 5px;" /><br />
                        <span style="color:#ABC2DB;font-size:11px;">Dmitry Shane</span><br />
                        <span style="color:#ABC2DB;font-size:11px;">CFO</span>
                      </p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:18px;margin:0;font-style:italic;padding-left:60px;padding-top:2px;">In the development of the game we tried not to deviate from the standard models for monetizing this type of game. We have choose <b>free-2-play</b> monetization model with the following <b>Inn-App Purchases</b>:</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">
                        <ul style="list-style-type:none;margin:0;padding:0;padding-top:30px;">
                          <li style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:1;padding:10px 0 10px 5px;">Purchase of gold and silver coins</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;padding:0px 0 10px 5px;">Gold and silver coins is a <b>game currency</b>. With the help of this currency users can make purchases in the game store.</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">
                            <img src="http://www.tooflya.com/assets/img/mail/003/Vvmdds1taL.png" alt="" style="float:left;padding:5px;" />
                            <b>Coins Pack 1</b>
                            <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>Price:</b> $0.99.</p>
                            <div style="clear:both;"></div>
                          </li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">
                            <img src="http://www.tooflya.com/assets/img/mail/003/h6ZEnaAshW.png" alt="" style="float:left;padding:5px;" />
                            <b>Coins Pack 2</b>
                            <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>Price:</b> $2.99.</p>
                            <div style="clear:both;"></div>
                          </li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">
                            <img src="http://www.tooflya.com/assets/img/mail/003/1dMKRObcKP.png" alt="" style="float:left;padding:5px;" />
                            <b>Coins Pack 3</b>
                            <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>Price:</b> $4.99.</p>
                            <div style="clear:both;"></div>
                          </li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">
                            <img src="http://www.tooflya.com/assets/img/mail/003/3lYYT4QPzq.png" alt="" style="float:left;padding:5px;" />
                            <b>Coins Pack 4</b>
                            <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>Price:</b> $7.99.</p>
                            <div style="clear:both;"></div>
                          </li>
                          <li style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:1;padding:10px 0 10px 5px;">Purchase of gold keys</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;padding:0px 0 10px 5px;">Gold keys are also is a <b>game currency</b> but unlike coins serve to open items, levels and additional modes.</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">
                            <img src="http://www.tooflya.com/assets/img/mail/003/nkamDLz2YQ.png" alt="" style="float:left;padding:5px;" />
                            <b>Keys Bundle 1</b>
                            <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>Price:</b> $2.99.</p>
                            <div style="clear:both;"></div>
                          </li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">
                            <img src="http://www.tooflya.com/assets/img/mail/003/DvvVdpZVcy.png" alt="" style="float:left;padding:5px;" />
                            <b>Keys Bundle 2</b>
                            <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>Price:</b> $7.99.</p>
                            <div style="clear:both;"></div>
                          </li>
                          <li style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:1;padding:10px 0 10px 5px;">Purchase of lives</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;padding:0px 0 10px 5px;">The player is given up to <b>5 lives</b> which are used when you start the battle. Only winning player recovers the spent life. Every life is restored within the hour.</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">
                            <img src="http://www.tooflya.com/assets/img/mail/003/6j7IEbdAJG.png" alt="" style="float:left;padding:5px;" />
                            <b>Lives restoring</b>
                            <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>Price:</b> $0.99.</p>
                            <div style="clear:both;"></div>
                          </li>
                          <li style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:1;padding:10px 0 10px 5px;">Purchase of moves</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;padding:0px 0 10px 5px;">Each game level implies a certain number of moves which the player can perform to complete the level. If the level is not yet complete but there are no more moves the player is invited to restore the original number of moves.</li>
                          <li style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">
                            <img src="http://www.tooflya.com/assets/img/mail/003/n574vqj8GM.png" alt="" style="float:left;padding:5px;" />
                            <b>Moves restoring</b>;
                            <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><b>Price:</b> $1.99.</p>
                            <div style="clear:both;"></div>
                          </li>
                        </ul>
                      <p style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:18px;line-height:1;padding-top:20px;">What technologies used in the development of the game?</p>
                      <p style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:1;padding:10px 0 10px 0;">Native application</p>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">Native version of application was build with <b>C++</b> and <b>Cocos2d-x</b> framework.</p>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">Native version works with some popular mobile and desktop operation systems such as <b>iOS</b>, <b>Android</b>, <b>Windows Phone</b>, <b>Windows</b>, <b>OS X</b>, <b>Linux</b>, etc.</p>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">Also application is use social networks API's and <a target="_blank" href="http://api.tooflya.com/" style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;text-decoration:none;letter-spacing:-1.0px;">Tooflya API</a>.</p>
                      <p style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:1;padding:10px 0 10px 0;">Web application</p>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">Web version of application was build with <b>Javascript</b> and <b>Cocos2d-js</b> framework.</p>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">Web version works with all popular browsers such as <b>Google Chrome</b>, <b>Firefox</b>, <b>Opera</b>, <b>Internet Explorer</b>, etc.</p>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;">Also application is use social networks API's and <a target="_blank" href="http://api.tooflya.com/" style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;text-decoration:none;letter-spacing:-1.0px;">Tooflya API</a>.</p>
                      <p style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:1;padding:10px 0 10px 0;">About Tooflya API</p>
                        <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;"><a target="_blank" href="http://api.tooflya.com/" style="color:#00aff0;font-family:Arial,Helvetica,sans-serif;text-decoration:none;letter-spacing:-1.0px;">Tooflya API</a> it's a service which running on the servers of Tooflya Inc. and works like "bridge" between database and application. This service can provide various information about users of application. Using of this service is optional.</p>
                      <p style="color:#868a8c;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0;margin-top:30px;"><b>Thank you for being with us</b>.</p>
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
                <tbody>
                  <tr>
                    <td>
                      <p style="color:#626262;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;margin:0 0 15px;">Don't forget to <a href="http://twitter.com/tooflya" style="color:#00aff0;text-decoration:underline;" target="_blank">follow Tooflya on Twitter</a> and <a href="http://www.facebook.com/tooflya" style="color:#00aff0;text-decoration:underline;" target="_blank">like us on Facebook</a>!&nbsp;Any questions? Check out our <a href="http://www.tooflya.com" style="color:#00aff0;text-decoration:underline;" target="_blank">website</a>, or reply to this email. Have a good day!</p>
                      <p style="color:#606060;font-family:Arial,Helvetica,sans-serif;font-size:20px;line-height:28px;margin:0;">Regards,<br><b>Tooflya Team</b></p>
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
          <td style="background-color:#f9f9f9;border-top:solid 1px #ededed;border-bottom:solid 1px #ededed;">
            <table width="100%">
              <tbody>
                <tr>
                  <td height="20"></td>
                </tr>
                
                <tr>
                  <td height="10"></td>
                </tr>
                <tr>
                  <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#868a8c;line-height:16px;" align="center">
                    You are receiving this email because you (or someone pretending to be you) subscribed to our newsletter.<br>
                    If this is you no longer interested you can <a href="http://www.tooflya.com/unsubscribe/" style="color:#868a8c;text-decoration:underline;" class="daria-goto-anchor" target="_blank">unsubscribe just now</a>.
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
                  <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#868a8c;line-height:18px;" align="center">&copy; 2014 Tooflya Inc.</td>
                </tr>
                <tr>
                  <td height="20"></td>
              </tr>
              </tbody>
            </table>
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

    exit;
  }
?>
