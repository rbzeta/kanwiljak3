<?php
include_once '../helper/functionHelper.php';
require '../config/DBConnect.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['username'], $_POST['p'])) {
    $userName = $_POST['username'];
    $password = $_POST['p']; // The hashed password.
 
    if (login($userName, $password, getConnection()) == true) {
        // Login success 
        header('Location: ../index.php');
        session_write_close();
    	
    } else {
        // Login failed 
        header('Location: ../login/login.php?error=1');
        session_write_close();
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}
// 6ZaxN2Vzm9NUJT2y