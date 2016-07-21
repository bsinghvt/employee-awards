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
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$uid=$_SESSION["uid"];
if (!$stmt = $mysqli->query("SELECT adid, award_type, recepient_email, r_first_name, r_middle_name, r_last_name, granted, public FROM Award WHERE uid='$uid'")) {
		echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
	}
?>
<h2>Awards Given</h2>
<table border="1">
<thead> 
<tr>
    <th>Recepeient first name</th> 
    <th>Recepeient middle name</th> 
	<th>Recepeient last name</th> 
    <th>Recepeient email</th> 
    <th>Date Granted</th> 
    <th>Public/Private</th> 
	<th>Edit</th>
    <th>Delete</th>
</tr> 
</thead>
<tbody>
<?php
$totalunits=0;
$totalgp=0;
while($row = mysqli_fetch_array($stmt))	
{
	echo "<tr>" ;
	echo "<td>" . $row['r_first_name'] . "</td>";
	echo "<td>" . $row['r_middle_name'] . "</td>";
	echo "<td>" . $row['r_last_name'] . "</td>";
	echo "<td>" . $row['recepient_email'] . "</td>";
	echo "<td>" . $row['granted'] . "</td>";
	if (!$row['public'])
	{
			echo "<td> Private </td>";
	}
	else
	{
		echo "<td> Public </td>";
	}
	echo "<td><form method=\"POST\" action=\"editaward.php\">";
	echo "<input type=\"hidden\" name=\"adid\" value=\"".$row['adid']."\">";
	echo "<input type=\"submit\" value=\"edit\">";
	echo "</form> </td>";
	echo "<td><form method=\"POST\" action=\"deleteaward.php\">";
	echo "<input type=\"hidden\" name=\"adid\" value=\"".$row['adid']."\">";
	echo "<input type=\"submit\" value=\"delete\">";
	echo "</form> </td>";
	echo "</tr>";
}
	?>
</tbody>
</table>
<?php get_template("footer.php"); 
 ?>