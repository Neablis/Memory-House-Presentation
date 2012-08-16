<?php


	include 'dbWrapper.php';	
	$value = getNewImagePath('1999-1-1 01:01:01');
	echo json_encode($value);

?>