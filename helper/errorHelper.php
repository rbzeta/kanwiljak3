<?php

function customError($errNo, $strError) {
	echo "<b>Error:</b> [$errNo] $strError<br>";
	die();
}

function writeError($errNo, $strError){
	set_error_handler("customError");
	
}

function my_error_handler($errno, $errstr, $errfile, $errline)
{
	switch ($errno) {
		case E_USER_ERROR:
			echo "user error";
			break;

		case E_USER_WARNING:
			echo "user warning";
			break;

		case E_USER_NOTICE:
			echo "user notice";
			break;

		default:
			echo "default error";
			break;
	}

	// Don't execute PHP's internal error handler
	return TRUE;
}
?>