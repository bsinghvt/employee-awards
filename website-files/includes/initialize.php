<?php
//Database constants
defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
<<<<<<< HEAD
defined("SITE_ROOT") ? null : define("SITE_ROOT", DS.'website-files');
=======
defined("SITE_ROOT") ? null : define("SITE_ROOT", DS.'var'.DS.'www'.DS.'website-files');
>>>>>>> fa41eb31ce0ee3d27a79acb086464f9882a78c48
defined("LIB_PATH") ? null : define("LIB_PATH", SITE_ROOT.DS.'includes');
require_once(LIB_PATH.DS."config.php");
require_once(LIB_PATH.DS."functions.php");
require_once(LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS."database.php");
require_once(LIB_PATH.DS."database-object.php");
require_once(LIB_PATH.DS."user.php");
require_once(LIB_PATH.DS."admin.php");
require_once(LIB_PATH.DS."awards.php");
?>
