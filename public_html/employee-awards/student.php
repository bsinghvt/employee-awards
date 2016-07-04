<?php
ob_start(); //from stack overflow
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
session_start();
if (!isset($_SESSION["username"]))
{
    header("Location: index.php", true);
}
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", $pass, "harrings-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student Courses</title>
<?php
include "navbar.php";
?>
</head>
<body>
<section>
<h2>Add Class</h2>
<form action="addclass.php" method="post">
		<p>Course Name: <input type="text" name="cname" /></p>
		<p>Course Units: <input type="number" name="cunits" min="1" max="10" /></p>	
		<p>Grade as number: <input type="number" name="cgrade" min="1" max="10" /></p>	
		<br><br>
		<input type="submit" value="Submit">
		<br><br>
</form>
<?php
$username=$_SESSION['username'];
$gradunits=$_SESSION['units'];
if (!$stmt = $mysqli->query("SELECT uid, cname, cunits, cgrade, shared FROM CINFO WHERE username='$username'")) {
		echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
	}
?>
<h2>Classes Taken</h2>
<table border="1">
<thead> 
<tr>
    <th>Course Name</th> 
    <th>Course Units</th> 
    <th>Course Grade</th> 
    <th>Shared</th> 
    <th>Change Status</th> 
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
	echo "<td>" . $row['cname'] . "</td>";
	echo "<td>" . $row['cunits'] . "</td>";
	echo "<td>" . $row['cgrade'] . "</td>";
	echo "<td>";
	if (!$row['shared'])
	{
		echo "Not Shared </td>";
		echo "<td><form method=\"POST\" action=\"share.php\">";
		echo "<input type=\"hidden\" name=\"uid\" value=\"".$row['uid']."\">";
		echo "<input type=\"submit\" value=\"share\">";
		echo "</form> </td>";
	}
	else
	{
		echo "Shared </td>";
		echo "<td><form method=\"POST\" action=\"unshare.php\">";
		echo "<input type=\"hidden\" name=\"uid\" value=\"".$row['uid']."\">";
		echo "<input type=\"submit\" value=\"unshare\">";
		echo "</form> </td>";
	}
	echo "<td><form method=\"POST\" action=\"delete.php\">";
	echo "<input type=\"hidden\" name=\"uid\" value=\"".$row['uid']."\">";
	echo "<input type=\"submit\" value=\"delete\">";
	echo "</form> </td>";
	echo "</tr>";
	$totalunits=$row['cunits']+$totalunits;
	$totalgp=($row['cunits']*$row['cgrade'])+$totalgp;
}
?>
</tbody>
</table>
<h2>Student Record</h2>
<table border="1">
<thead> 
<tr>
    <th>Student Name</th> 
    <th>Units needed total</th> 
    <th>Units Taken</th> 
    <th>Units Left</th> 
    <th>GPA</th> 
</tr> 
</thead>
<tbody>
<tr>
<?php
$unitsleft=$gradunits-$totalunits;
if ($totalunits==0)
{
	$gpa=0;
}
else
{
$gpa=$totalgp/$totalunits;
}
	echo "<td>$username</td>";
	echo "<td>$gradunits</td>";
	echo "<td>$totalunits</td>";
	echo "<td>$unitsleft</td>";
	echo "<td>$gpa</td>";
?>
</tr>
</tbody>
</table>
<?php
$sharedusers=array();
if (!$stmt = $mysqli->query("SELECT username FROM CINFO WHERE shared=1")) {
		echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
	}
while($row = mysqli_fetch_array($stmt))	
{
	if ((!(in_array($row['username'], $sharedusers)))&&($row['username']!=null))
	{
		array_push($sharedusers,$row['username']);
	}
}
?>
<h2>Shared Info Sort by User</h2>
<form action="filter.php" method="POST">
<div align="center">
<select name="sort">
<option value="All">All Shared</option>
<option value="NONE">NONE</option>
<?php
$x=count($sharedusers);
for ($i=0;$i<$x; $i++)
{
	echo "<option value=$sharedusers[$i]>$sharedusers[$i]</option>";
}
?>
</select>
</div>
<input type="submit" value="Filter">
</form>
<?php
if(!isset($_SESSION['sort'])||$_SESSION['sort']=="NONE")
{
	echo "<h3>Currently Viewing No Shared Users</h3>";
}
else if ($_SESSION['sort']=="All")
{
	if (!$stmt = $mysqli->query("SELECT username, cname, cunits, cgrade FROM CINFO WHERE shared=1")) {
		echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
	}	
?>
<h3>Currently Viewing All Shared User CLasses</h3>
<table border="1">
<thead> 
<tr>
	<th>Username</th>
    <th>Course Name</th> 
    <th>Course Units</th> 
    <th>Course Grade</th> 
</tr> 
</thead>
<tbody>
<?php
while($row = mysqli_fetch_array($stmt))	
{
	echo "<tr>" ;
	echo "<td>" . $row['username'] . "</td>";
	echo "<td>" . $row['cname'] . "</td>";
	echo "<td>" . $row['cunits'] . "</td>";
	echo "<td>" . $row['cgrade'] . "</td>";	
	echo "</tr>";
}
?>
</tbody>
</table>
<?php
}
else
{
$sorter=$_SESSION['sort'];
	if (!$stmt = $mysqli->query("SELECT cname, cunits, cgrade FROM CINFO WHERE shared=1 and username='$sorter'")) {
		echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
	}
	echo "<h3>Currently Viewing $sorter Shared User CLasses</h3>";
?>
<table border="1">
<thead> 
<tr>
    <th>Course Name</th> 
    <th>Course Units</th> 
    <th>Course Grade</th> 
</tr> 
</thead>
<tbody>
<?php
while($row = mysqli_fetch_array($stmt))	
{
	echo "<tr>" ;
	echo "<td>" . $row['cname'] . "</td>";
	echo "<td>" . $row['cunits'] . "</td>";
	echo "<td>" . $row['cgrade'] . "</td>";	
	echo "</tr>";
}
?>
</tbody>
</table>
<?php	
}
?>
</section>
</body>
</html>

	




