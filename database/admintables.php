<?php
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", "minstFy7WEjCWSCr", "harrings-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
if(!$mysqli->query("CREATE Table Admin_Account(
admin_id INT(11) NOT NULL AUTO_INCREMENT ,
user_email VARCHAR(255) UNIQUE NOT NULL,
password VARCHAR(20),
primary key (admin_id)
);
")) {
	echo "User_Account Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if(!$mysqli->query("CREATE Table Admin_Actions(
action_id INT(11) NOT NULL AUTO_INCREMENT ,
uid INT(11) NOT NULL,
action VARCHAR(20) NOT NULL,
admin_id INT(11) NOT NULL,
primary key (action_id),
foreign key (uid) references User_Account (uid),
foreign key (admin_id) references Admin_Account (admin_id)
);
")) {
	echo "Award table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
}


?>