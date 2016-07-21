<?php
require_once(__DIR__.'/website-files/initialize.php');
//ob_start(); //from stack overflow
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
//session_start();
if (!isset($_SESSION["user_email"]))
{
    header("Location: login.php", true);
}
get_template("header.php");
get_template("nav2.php");

$uid=$_SESSION["uid"];
?>
<h2>All Public Awards</h2>
<table border="1">
<thead> 
<tr>
    <th>Recepeient first name</th> 
    <th>Recepeient middle name</th> 
	<th>Recepeient last name</th> 
    <th>Recepeient email</th> 
    <th>Date Granted</th> 
    <th>Awarder first name</th> 
	    <th>Awarder middle name</th> 
	<th>Awarder last name</th>
</tr> 
</thead>
<tbody>
<?php
include 'pass.php';
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");
    if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
if (!$stmt = $mysqli->query("SELECT Award.award_type, Award.recepient_email, Award.r_first_name, Award.r_middle_name, Award.r_last_name, Award.granted, Award.Public, User_Account.first_name,User_Account.middle_name, User_Account.last_name FROM Award INNER JOIN User_Account on Award.uid=User_Account.uid WHERE Award.Public=1 ORDER BY Award.adid DESC"))
	{
		echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
	}
while($row = mysqli_fetch_array($stmt))	
{
	echo "<tr>" ;
	echo "<td>" . $row['r_first_name'] . "</td>";
	echo "<td>" . $row['r_middle_name'] . "</td>";
	echo "<td>" . $row['r_last_name'] . "</td>";
	echo "<td>" . $row['recepient_email'] . "</td>";
	echo "<td>" . $row['granted'] . "</td>";
	echo "<td>" . $row['first_name'] . "</td>";
		echo "<td>" . $row['middle_name'] . "</td>";
			echo "<td>" . $row['last_name'] . "</td>";
	echo "<tr>" ;
}
?>
</tbody>
</table>
<?php get_template("footer.php"); 
 ?>