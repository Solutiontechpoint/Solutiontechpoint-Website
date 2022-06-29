<?php

  $receiving_email_address = 'thanunr5@gmail.com';


  // $contact = new PHP_Email_Form;
  // $contact->ajax = true;
  
  // $contact->to = $receiving_email_address;
  // $contact->from_name = $_POST['name'];
  // $contact->from_email = $_POST['email'];
  // $contact->subject = $_POST['subject'];

  // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
  /*
  $contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
  );
  */

  // $contact->add_message( $_POST['name'], 'From');
  // $contact->add_message( $_POST['email'], 'Email');
  // $contact->add_message( $_POST['message'], 'Message', 10);

  // echo $contact->send();
  // $headers = 'From: '.$_POST['email'];
  $headers = 'From: Jack Sparrow<some@site.com>';
  $message = 'Name : '.$_POST['name'] .'\nEmail : '.$_POST['email'] .'\n\n'.$_POST['message'];
  echo mail($receiving_email_address, $_POST['subject'], $message, $headers);
?>
