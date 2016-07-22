<?php
//ob_start(); //from stack overflow
require_once(__DIR__.'/website-files/initialize.php');
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
//session_start();
if (!isset($_SESSION["user_email"]))
{
    header("Location: login.php", true);
}
$uid=$_SESSION["uid"];
//$uid=123;


// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');
ini_set('display_errors', 'On');

require_once '../phpmailer/vendor/autoload.php';
include("../../secret.php");
include 'pass.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");
if ($mysqli->connect_errno) 
{
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;	
}

//Get information from database about user for the making of the certificate.
if (!($stmt = $mysqli->prepare("SELECT signature, first_name, middle_name, last_name, job_title from User_Account WHERE uid=?"))) 
{
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->bind_param("i", $uid)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
if (!$stmt->execute()) 
{
	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}

$stmt->bind_result($sig, $AFirstName, $AMiddleName, $ALastName, $job_title);

$certificate_data = array();
array_push($certificate_data, $_POST['r-first-name']);
array_push($certificate_data, $_POST['r-middle-name']);
array_push($certificate_data, $_POST['r-last-name']);
array_push($certificate_data, $_POST['award-type']);
array_push($certificate_data, $_POST['date']);

// foreach ($certificate_data as $data)
// {
// 	echo "certificate data = " . $data . "\r";

// }

$tmp = array();

while($stmt->fetch())
{
	array_push($certificate_data, $sig, $AFirstName, $AMiddleName, $ALastName, $job_title);
}

$stmt->close();

// foreach ($certificate_data as $data)
// {
// 	echo "certificate data = " . $data . "\r";

// }



//Output a csv file from POST (create award form) data and user's data retrieved from database

// create a file pointer connected to the output stream
$file = fopen('data.csv', 'w');
$heading = array('RFirstName', 'RMiddleName', 'RLastName', 'AwardType', 'Date', 'Signature', 'AFirstName', 'AMiddleName', 'ALastName', 'JobTitle');

// output the headings
fputcsv($file, $heading);
// foreach ($heading as $column) 
// {
//     fputcsv($file, $column);
// }


// output row of data needed for certificate making
fputcsv($file, $certificate_data);
// foreach ($certificate_data as $field) 
// {
//     fputcsv($file, $field);
// }

fclose($file);

//make the certificate
exec("/usr/bin/pdflatex certificate_style3.ltx 2>&1");

//add award to db
$award_type=$_POST['award-type'];
$granted=$_POST['date'];
$uid=$_SESSION['uid'];
$error=0;
$r_middle_name= $_POST['r-middle-name'];
		if (($_POST["public"]=="public"))
		{
			$public=1;
		}
		else
		{
			$public=0;
		}
		if (!($stmt = $mysqli->prepare("INSERT INTO Award(uid, award_type, recepient_email, r_first_name, r_middle_name , r_last_name, granted, public) VALUES (?,?,?,?,?,?,?,?)"))) {
			 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			 $error=1;
		}
		if (!$stmt->bind_param("issssssi",$uid, $award_type, $REmail, $RFirstName, $r_middle_name, $RLastName,$granted, $public)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			$error=1;
		}
		if (!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			$error=1;
		}
		$stmt->close();
if ($error==0)
		{
			echo "registered successfully";
		}

//*******Send the certificate via email
if(isset($_POST['r-email'])) {
	$AEmail = $_SESSION['user_email']; //Awarder's email 
	$REmail = $_POST['r-email']; //Recipient's email
}
else {
	echo "Need email addresses\r";
}
if(isset($_POST['r-first-name'])) {
	$RFirstName = $_POST['r-first-name']; //Recipient's first name
	$RLastName = $_POST['r-last-name']; //Recipient's last name
}
else {
	echo "Need recipient's name and awarder's name.\r";
}

$m = new PHPMailer;

$m->isSMTP();
$m->SMTPAuth = true;
$m->SMTPDebug = 2;

$m->Host = 'smtp.gmail.com';
$m->Username = 'webrecogapp@gmail.com';
$m->Password =  $myPassword;
$m->SMTPSecure = 'ssl';
$m->Port = 465;

$m->From = $AEmail;
$m->FromName = $AFirstName . " " . $ALastName;
$m->addReplyTo($REmail, 'Reply address');
$m->addAddress($REmail, $RFirstName . " " . $RLastName);

$m->MsgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$m->Subject = 'You Have Received an Award';
$m->Body = '<h1>Congratulations!</h1><br><p>You have been nominated for an award for your outstanding work performance.</p>';
$m->AltBody = 'Congratulations! You have been nominated for an award for your outstanding work performance.';
//Make sure relative path to certificate pic is correct here
$m->AddAttachment('certificate_style3.pdf');

//send the message, check for errors
if (!$m->send()) {
    echo "Mailer Error: " . $m->ErrorInfo;
	$_SESSION["new_award"]=-1;
	//header("Location: login.php", true);
} else {
    echo "Message sent!";
	$_SESSION["new_award"]=1;
	//header("Location: login.php", true);
}


