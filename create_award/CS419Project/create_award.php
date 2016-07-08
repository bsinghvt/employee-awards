<?php
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');
ini_set('display_errors', 'On');

if(isset($_POST['a-last-name'], $_POST['a-middle-name'], $_POST['a-first-name'])) {
	$certificate_data = array($_POST['r-first-name'], $_POST['r-middle-name'], $_POST['r-last-name'], $_POST['award-type'], $_POST['date'], $_POST['signature'], $_POST['a-first-name'], $_POST['a-middle-name'], $_POST['a-last-name'], $_POST['job-title'],);
	echo "awarder's full name is " . $certificate_data[6] . " " . $certificate_data[7] . " " . $certificate_data[8] . "\r\r";
}
else {
	echo "didn't work";
}

//Output a csv file from POST data


// create a file pointer connected to the output stream
$file = fopen('./texmf/data.csv', 'w');

// output the column headings
fputcsv($file, array('RFirstName', 'RMiddleName', 'RLastName', 'AwardType', 'Date', 'Signature', 'AFirstName', 'AMiddleName', 'ALastName', 'JobTitle'));

//fetch single row of data from POST variable
fputcsv($file, $certificate_data);

fclose($file);
//echo $output;
// fetch the data from database
//mysql_connect('localhost', 'username', 'password');
//mysql_select_db('database');
//$rows = mysql_query('SELECT field1,field2,field3 FROM table');

// loop over the rows, outputting them
//while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);
header("Content-Type: application/pdf");
//Create certificate using pdflatex
echo exec('pwd');
chdir('./texmf');
echo "\r";
echo exec('pwd');

chdir(dirname(realpath('certificate_style3.ltx')));

echo "\r";
echo exec('ls');
$command = shell_exec("pdflatex certificate_style3.ltx");

$pdf = dirname(realpath('certificate_style3.pdf'));
readfile($pdf);

