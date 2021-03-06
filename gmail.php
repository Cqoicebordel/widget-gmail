<?php 
print '<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Mails</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
print "<style type=\"text/css\">
 body {margin:0;padding:0;height:200px;width:700px}
 .from, .count {font-weight:bold}
 .count {display:none}
 @media (max-width:99px) {
  body {margin:0;padding:0;height:auto;width:auto}
  .mail {display:none}
  .count {display:inline}
 }
 </style>
 <script type=\"text/JavaScript\">
 /* Change this value to change the rate of refresh */
    setTimeout(\"location.reload(true);\", 300000);
</script>";



// Change those parameters to fit your accounts
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = ['xxx@gmail.com', 'yyy@gmail.com', 'zzz@gmail.com'];
$password = ['xxxPASS', 'yyyPASS', 'zzzPASS'];
$colors = ["#FF5858", "#0565FF", "#12D200"];

for($i=0; $i<count($username); $i++){
// Try to connect
    $inbox = imap_open($hostname,$username[$i],$password[$i]) or die('Cannot connect to Gmail : '.imap_last_error());

    // Grab the emails
    $emails = imap_search($inbox,'UNSEEN');

    // If emails are returned, cycle through each
    if($emails) {
        $output = '';

        rsort($emails);

        foreach($emails as $email_number) {

            $overview = imap_headerinfo($inbox, $email_number);

            /* output the email header information */
            $output.= '<div class="mail" style="color:'.$colors[$i].'">';

            $output.= '<span class="from">'.htmlentities(imap_utf8($overview->fromaddress)).' : </span>';

            $output.= '<span class="subject">'.htmlentities(imap_utf8($overview->Subject)).'</span> ';

            $output.= '</div>';
        }
        $output .= '<div class="count" style="color:'.$colors[$i].'">'.count($emails).'</div>';

        echo $output;
    } 
}

imap_close($inbox);
print '</body></html>';
?>