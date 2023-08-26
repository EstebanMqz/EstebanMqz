<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  // Create a new PHPMailer instance.
  $mail = new PHPMailer(true);

  try {
    // Validate the sender's email address.
    $mail->validateAddress($email);

    // Set the sender's email address and name.
    $mail->setFrom($email, $name);

    // Set the recipient's email address.
    $mail->addAddress('emarquez1895@gmail.com');

    // Set the email subject and body.
    $mail->Subject = 'New message from your website';
    $mail->Body = "Name: $name\nEmail: $email\nMessage: $message";

    // Send the email.
    $mail->send();

    header('Location: ../html/successful.html');
    exit;
  } catch (Exception $e) {
    header("Location: ../html/error.html?email=$email");
    exit;
  }
}
?>