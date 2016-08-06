<?php
//ob_start(); //from stack overflow
require_once(__DIR__.'/website-files/initialize.php');
include 'pass.php';
error_reporting(E_ALL);
//ini_set('display_errors','On');
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
// ini_set('display_errors', 'On');
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
// change format of date before it goes on certificate
$date = $_POST['date'];
$year = array();
$month = array();
$day = array();
//echo "date is " . $date . "\r";
for ($x = 0; $x < 4; $x++) {
    array_push($year, $date[$x]);
    //echo "year = " . $date[$x] . "\r";
}
$year = implode("",$year);
//echo "year = " . $year . "\r";

for ($x = 5; $x < 7; $x++)
{
	array_push($month, $date[$x]);
	//echo "month = " . $date[$x] . "\r";
}
$month = implode("",$month);
//echo "month = " . $month . "\r";
for ($x = 8; $x < 10; $x++)
{
	    array_push($day, $date[$x]);
	    //echo "day = " . $date[$x] . "\r";
}
$day =implode("",$day);
//echo "day = " . $day . "\r";

//echo "MONTH IS ". $month . "\r";

switch ($month) 
{
    case "01":
        $month = "January";
        break;
    case "02":
		$month = "February";
        break;
    case "03":
        $month = "March";
        break;
    case "04":
        $month = "April";
        break;
    case "05":
        $month = "May";
        break;
    case "06":
        $month = "June";
        break;
	case "07":
        $month = "July";
        break;
	case "08":
        $month = "August";
        break;
	case "09":
        $month = "September";
        break;
	case "10":
        $month = "October";
        break;
	case "11":
        $month = "November";
        break;
	case "12":
        $month = "December";
        break;
    default:
        echo "Problem with parsing code.";
}

$date = $month . " " . $day . ", ". $year;
if($_POST['r-middle-name'] != "")
{
	array_push($certificate_data, $_POST['r-first-name']);
	array_push($certificate_data, $_POST['r-middle-name']);
	array_push($certificate_data, $_POST['r-last-name']);
	array_push($certificate_data, $_POST['award-type']);

	array_push($certificate_data, $date);


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


	//*****MAKE THE CERTIFICATE*****
	exec("/usr/bin/pdflatex certificate_style3.ltx 2>&1");
}
else //Case where there is no recipient middle name
{
	array_push($certificate_data, $_POST['r-first-name']);
	//array_push($certificate_data, $_POST['r-middle-name']);
	array_push($certificate_data, $_POST['r-last-name']);
	array_push($certificate_data, $_POST['award-type']);

	array_push($certificate_data, $date);


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
	$heading = array('RFirstName', /*'RMiddleName',*/ 'RLastName', 'AwardType', 'Date', 'Signature', 'AFirstName', 'AMiddleName', 'ALastName', 'JobTitle');
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


	//*****MAKE THE CERTIFICATE*****
	exec("/usr/bin/pdflatex certificate_style3_no_middle_name.ltx 2>&1");
}
if(isset($_POST['preview']) /*file_exists('certificate_style3.pdf')*/)
{
	//echo "file exists";
	//echo "<iframe src=\"certificate_style3.pdf\" width=\"100%\" style=\"height:100%\"></iframe>"
	if($_POST["r-middle-name"] == "")
	{
		$_SESSION["middlenameset"] = "false";
	}
	else
	{
		$_SESSION["middlenameset"] = "true";
	}
	header("Location: preview_certificate.php");
    exit;
}
else if(isset($_POST['send']))
{
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
	//add award to db
	$award_type=$_POST['award-type'];
	$granted=$_POST['date'];
	$r_middle_name= $_POST['r-middle-name'];
	$uid=$_SESSION['uid'];
	$adid=$_SESSION['adid'];
	//echo "uid = " . $uid . "\r";
	$error=0;
			if (($_POST["public"]=="public"))
			{
				$public=1;
			}
			else
			{
				$public=0;
			}
			if (!($stmt = $mysqli->prepare("Update Award SET award_type=?, recepient_email=?, r_first_name=?, r_middle_name=?, r_last_name=?, granted=?, public=? WHERE adid='$adid'"))) {
				 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
				 $error=1;
			}
			if (!$stmt->bind_param("ssssssi", $award_type, $REmail, $RFirstName, $r_middle_name, $RLastName,$granted, $public)) {
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
		echo "Mailer Error: " . $m->ErrorInfo; ?>
						<script>
						alert('Error Creating Award');
					</script>
		<?php
		$_SESSION["new_award"]=-1;
		header("Location: editaward.php", true);
	} else {
		echo "Message sent!";
		?>
							<script>
						alert('Award Successfully Created');
					</script>
		<?php
		$_SESSION["new_award"]=1;
		header("Location: editaward.php", true);
	}
} ?>