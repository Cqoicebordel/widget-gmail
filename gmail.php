<?php 
print "<style type=\"text/css\">
 body {margin:0;padding:0;height:200px;width:700px}
 .from {font-weight:bold}
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
            
            $overview = imap_fetch_overview($inbox,$email_number,0);
            
            // Output the email informations
            $output.= '<div style="color:'.$colors[$i].'">';
            $output.= '<span class="from">'.$overview[0]->from.' : </span>';

            //
            $output.= '<span class="subject">'.imap_mime_header_decode($overview[0]->subject)[0]->text.'</span> ';;

            $output.= '</div>';
        }
        echo $output;
    } 
}

imap_close($inbox); 
?>