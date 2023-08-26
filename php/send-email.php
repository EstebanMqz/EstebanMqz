<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once './vendor/autoload.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  // Validate the form data
  if (empty($name) || empty($email) || empty($message)) {
    // If any of the form fields are empty, redirect the user to the error page
    header('Location: ../error.html');
    exit;
  }

  // Create a new PHPMailer instance
  $mail = new PHPMailer(true);

  try {
    // Set the mailer to use SMTP
    $mail->isSMTP();

    // Set the SMTP server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'emarquez1895@gmail.com';                     //SMTP username
    $mail->Password   = 'stugvmmnfonqtcjj';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    // Set the email sender and recipient
    $mail->setFrom($email, $name);
    $mail->addAddress('emarquez1895@gmail.com', 'Esteban Marquez D.');

    // Set the email subject and body
    $mail->Subject = 'New message from ' . $name;
    $mail->Body = $message;

    // Send the email
    if ($mail->send()) {
      // If the email was sent successfully, redirect the user to the success page
      header('Location: ../success.html');
      exit;
    } else {
      // If there was an error sending the email, redirect the user to the error page
      header('Location: ../error.html');
      exit;
    }
  } catch (Exception $e) {
    // If there was an error sending the email, redirect the user to the error page
    header('Location: ../error.html');
    exit;
  }
} else {
  // If the form was not submitted via POST request, redirect the user to the error page
  header('Location: ../error.html');
  exit;
}
?>