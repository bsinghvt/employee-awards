<?php

ini_set('display_errors', 'On');
$path1 = '/usr/bin';
$path2 = '/bin';

set_include_path(get_include_path() . PATH_SEPARATOR . $path1);
set_include_path(get_include_path() . PATH_SEPARATOR . $path2);

echo exec("echo \$PATH");
echo "\r";
echo get_include_path();
echo "\r";
//set_include_path(".:/bin/latex:/bin/pdflatex");
//$oldPath = get_include_path();
//echo $oldPath;
//$newPath = $oldPath . ":/bin/latex:/bin/pdflatex";
//echo $newPath;
//if (ini_get('safe_mode')) {
//	echo "safe mode is on";
//} else {
//	echo "safe mode is off";
//}
//chdir(dirname(realpath("certificate_style3.ltx")));

//$console = exec("pdflatex certificate_style3.ltx");
echo exec("pwd");
echo "\r";

echo exec("/usr/bin/pdflatex certificate_style3.ltx 2>&1");
echo "\r";

echo exec("ls -al certificate_style3.ltx");
echo "\r";

echo exec("/usr/bin/whoami 2>&1");
echo "\r";

echo exec("echo \$PATH");
echo "\r";