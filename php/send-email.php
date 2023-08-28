<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once './vendor/autoload.php';

// Form submission -> GET(request) / POST(submit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Assign variables from E-mail.html.
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  // Validate the form data
  if (empty($name) || empty($email) || empty($message)) {
    header('Location: ../html/error.html');
    exit;
  }

  // Validate the email address
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../html/error.html');
    exit;
  }

  // New PHPMailer instance: https://www.hesk.com/knowledgebase/index.php?article=72
  $mail = new PHPMailer(true);
  try {
    $mail->isSMTP(); // Set the mailer to use SMTP.
    $mail->Host       = 'smtp.gmail.com'; //Sent through: SMTP server.
    $mail->SMTPAuth   = false; //SMTP authentication is not required.
    $mail->Port       = 587; //TCP port.
    $mail->SMTPSecure = 'TLS';
 
    $mail->setFrom($email, $name);// Sender.
    $mail->addAddress('emarquez1895@gmail.com', 'Esteban Marquez D.'); // Recipient.
    $mail->Subject = 'New message from ' . $name; // subject
    $mail->Body = $message; // body

    // File upload attachment.
    if (isset($_FILES['Business-file']) && $_FILES['Business-file']['error'] == UPLOAD_ERR_OK) {
      $mail->addAttachment($_FILES['Business-file']['tmp_name'], $_FILES['Business-file']['name']);
    }
    
    // Email sent sucessfully.
    if ($mail->send()) { 
      header('Location: ../html/success.html');
      exit;
    } else {
      // Email sent error.
      header('Location: ../html/error.html');
      exit;
    }
  } catch (Exception $e) {
    header('Location: ../html/error.html');
    exit;
  }
} else {
  header('Location: ../html/error.html');
  exit;
}