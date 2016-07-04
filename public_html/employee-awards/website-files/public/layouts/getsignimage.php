<?php
require_once(__DIR__.'/../../initialize.php');
if(isset($_GET['id'];)){
	$user = new User();
	$data = [];
	$user->uid = $_GET['id'];
	$data = $user->get_sign();
	header("Content-type: image/jpeg");
	echo $data[0]->signature;
}
?>