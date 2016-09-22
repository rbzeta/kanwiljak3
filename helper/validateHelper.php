<?php

function validateInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
function validateName($strName){
	if (!preg_match("/^[a-zA-Z ]*$/",$strName)) {
		$nameErr = "Gunakan karakter yang valid.";
	}
}

function validateEmail($strEmail){
	if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$strEmail)) {
  		$emailErr = "Format E-mail tidak valid."; 
	}
}

function validateURL($strURL){
	if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$strURL)) {
		$websiteErr = "Invalid URL";
	}
}
?>