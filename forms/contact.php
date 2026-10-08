<?php
header('Content-Type: application/json; charset=utf-8');

// Ensure request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    'status' => 'error',
    'message' => 'Invalid request method. Please submit via the form.'
  ]);
  exit;
}

$receiving_email_address = 'contact@solutiontechservices.com';

// Sanitize inputs
$name = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : '';
$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$subject = isset($_POST['subject']) && !empty(trim($_POST['subject'])) ? trim(strip_tags($_POST['subject'])) : 'Website Digital Solution Inquiry';
$message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';

// Validation
if (empty($name) || empty($email) || empty($message)) {
  echo json_encode([
    'status' => 'error',
    'message' => 'Please fill in all required fields (Name, Email, Message).'
  ]);
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo json_encode([
    'status' => 'error',
    'message' => 'Please enter a valid email address.'
  ]);
  exit;
}

$from = "$name <$email>";
$headers = "Reply-To: $from\r\n";
$headers .= "From: $from\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/plain; charset=utf-8\r\n";

$body = "Name: $name\nEmail: $email\nSubject: $subject\n\nProject Vision / Message:\n$message\n";

$sent = @mail($receiving_email_address, "[STS Inquiry] " . $subject, $body, $headers);

echo json_encode([
  'status' => 'success',
  'message' => 'Your transmission was received successfully. Our engineering team will contact you within 24 hours.'
]);
?>
