<?php
//Make sure relative path is correct here
require_once '../phpmailer/vendor/autoload.php';
include("../../secret.php");
if(isset($_POST['a-email'], $_POST['r-email'])) {
	$AEmail = $_POST['a-email']; //Awarder's email 
	$REmail = $_POST['r-email']; //Recipient's email
}
else {
	echo "Need email addresses\r";
}
if(isset($_POST['a-first-name'], $_POST['r-first-name'])) {
	$AFirstName = $_POST['a-first-name']; //Awarder's first name 
	$RFirstName = $_POST['r-first-name']; //Recipient's first name
	$ALastName = $_POST['a-last-name']; //Awarder's last name 
	$RLastName = $_POST['r-last-name']; //Recipient's last name
}
else {
	echo "Need email addresses\r";
}
$m = new PHPMailer;

$m->isSMTP();
$m->SMTPAuth = true;
$m->SMTPDebug = 2;

$m->Host = 'smtp.gmail.com';
$m->Username = 'akane.tanaban@gmail.com';
$m->Password = $myPassword;
$m->SMTPSecure = 'ssl';
$m->Port = 465;

$m->From = $AEmail;
$m->FromName = $AFirstName . " " . $ALastName;
$m->addReplyTo($REmail, 'Reply address');
$m->addAddress($REmail, $RFirstName . " " . $RLastName);

$m->MsgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$m->Subject = 'Here is your award';
$m->Body = 'This is the body of an email';
$m->AltBody = 'This is the body of an email';
//Make sure relative path to certificate pic is correct here
$m->AddAttachment('certificate_style3.pdf');

//send the message, check for errors
if (!$m->send()) {
    echo "Mailer Error: " . $m->ErrorInfo;
} else {
    echo "Message sent!";
}
