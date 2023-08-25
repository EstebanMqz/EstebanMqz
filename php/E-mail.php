<?php
require '../vendor/autoload.php'; // Load the SendGrid PHP library.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  $to = 'youremail@example.com';
  $subject = 'New message from your website';
  $body = "Name: $name\nEmail: $email\nMessage: $message";

  $email = new \SendGrid\Mail\Mail(); // Create a new SendGrid email object.
  $email->setFrom($email, $name); // Set the sender's name and email address.
  $email->setSubject($subject); // Set the email subject.
  $email->addTo($to); // Add the recipient's email address.
  $email->addContent("text/plain", $body); // Set the email body.

  $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY')); // Create a new SendGrid object with your API key.
  try {
    $response = $sendgrid->send($email); // Send the email.
    header('Location: ../html/thankyou.html'); // Redirect the user to the thank you page.
    exit;
  } catch (Exception $e) {
    header('Location: ../html/error.html'); // Redirect the user to the error page.
    exit;
  }
}
?>