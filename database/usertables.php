<?php
include 'pass.php';
error_reporting(E_ALL);
ini_set('display_errors','On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "harrings-db", "minstFy7WEjCWSCr", "harrings-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
if(!$mysqli->query("CREATE Table User_Account(
uid INT(11) NOT NULL AUTO_INCREMENT ,
user_email VARCHAR(255) UNIQUE NOT NULL,
password VARCHAR(20),
creation timestamp,
signature BLOB,
first_name VARCHAR(20) NOT NULL,
middle_name VARCHAR(20),
last_name VARCHAR(20) NOT NULL,
job_title VARCHAR(20) NOT NULL,
primary key (uid)
);
")) {
	echo "User_Account Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if(!$mysqli->query("CREATE Table Award(
adid INT(11) NOT NULL AUTO_INCREMENT ,
uid INT(11) NOT NULL,
award_type VARCHAR(20) NOT NULL,
recepient_email VARCHAR(255) NOT NULL,
r_first_name VARCHAR(20) NOT NULL,
r_middle_name VARCHAR(20),
r_last_name VARCHAR(20) NOT NULL,
granted DATE,
public boolean NOT NULL default 0,
primary key (adid),
foreign key (uid) 
references User_Account(uid)
);
")) {
	echo "Award table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
}


?>