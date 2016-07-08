<?php
require_once 'vendor/autoload.php';

$m = new PHPMailer;

$m->isSMTP();
$m->SMTPAuth = true;
$m->SMTPDebug = 2;

$m->Host = 'smtp.gmail.com';
$m->Username = 'akane.tanaban@gmail.com';
$m->Password = 'N1ck8tec0rn';
$m->SMTPSecure = 'ssl';
$m->Port = 465;

$m->From = 'akane.tanaban@gmail.com';
$m->FromName = 'Akane Tanaban';
$m->addReplyTo('atanaban@yahoo.com', 'Reply address');
$m->addAddress('atanaban@yahoo.com', 'Akane Yahoo');

$m->MsgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$m->Subject = 'Here is an email';
$m->Body = 'This is the body of an email';
$m->AltBody = 'This is the body of an email';
$m->AddAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$m->send()) {
    echo "Mailer Error: " . $m->ErrorInfo;
} else {
    echo "Message sent!";
}
//var_dump($m->send());
?>
