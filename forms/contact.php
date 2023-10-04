<?php

  $receiving_email_address = 'contact@solutiontechservices.com';

  $from = $_POST['name'] .'<'. $_POST['email'] .'>';
  $headers = "" .
           "Reply-To:" . $from . "\r\n" .
           "From:" . $from . "\r\n" .
           "X-Mailer: PHP/" . phpversion();
  $headers .= 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
  echo mail($receiving_email_address, $_POST['subject'], $_POST['message'], $headers);
?>
