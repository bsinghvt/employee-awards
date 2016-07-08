<?php
header("Content-Type: application/pdf");
//Create certificate using pdflatex
//echo exec('pwd');
//chdir('./texmf');
//echo "\r";
//echo exec('pwd');

//chdir(dirname(realpath('certificate_style3.ltx')));

//echo "\r";
//echo exec('ls');
exec("usr/bin/pdflatex certificate_style3.ltx");

$pdf = dirname(realpath('certificate_style3.pdf'));
readfile($pdf);