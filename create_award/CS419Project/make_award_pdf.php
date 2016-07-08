<?php


//Create certificate using pdflatex
//echo exec('pwd');
//chdir('./texmf');
//echo "\r";
//echo exec('pwd');

ob_start();
include 'certificate_style3.php';
$outputData .= ob_get_contents();
ob_end_clean();
//echo $outputData;
//$texFile = tempnam(sys_get_temp_dir(), 'test');
$texFile = tempnam('/nfs/stak/students/t/tanabana/public_html/CS419Project', 'test');
//echo "texFile = " . $texFile . "\r\r";

$base = basename($texFile);
//echo "base = " . $base . "\r\r";

rename($textFile, $texFile.".ltx");
$texFile .= ".ltx";
//echo "texFile = " . $texFile . "\r\r";

file_put_contents($texFile, $outputData);

chdir(dirname(realpath($texFile)));

//$console = shell_exec("pdflatex {$texFile}");
exec("/usr/bin/pdflatex \$base 2>&1");
//echo "console = " . "<pre>$console</pre>";

header("Content-type: application/pdf");

//echo "\r";
//echo exec('ls');
//$console = shell_exec("pdflatex certificate_style3.ltx");
//echo $console;
$pdf = dirname(realpath($texFile)).DIRECTORY_SEPARATOR.$base.".pdf";
//echo "pdf = " . $pdf;
readfile($pdf);