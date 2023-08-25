<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  $to = 'emarquez1895@gmail.com';
  $subject = 'New message from your website';
  $body = "Name: $name\nEmail: $email\nMessage: $message";
  $headers = "From: $name <$email>";

  if (mail($to, $subject, $body, $headers)) {
    header('Location: ../html/successful.html');
    exit;
  } else {
    header('Location: ../html/error.html'); 
    exit;
  }
}
?>