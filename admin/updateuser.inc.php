<?php
require '/helper/validateHelper.php';
require '../helper/functionHelper.php';
require '../config/DBConnect.php';
 
$error_msg = "";

sec_session_start();
 
if (isset($_POST['pn'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $pn = filter_input(INPUT_POST, 'pn', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">Alamat email tidak valid.</p>';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Konfigurasi password tidak valid.</p>';
    }
    
    $userlname = validateInput($_POST['userlname']);
    
    //$pn = validateInput($_POST['pn']);
    
    $jabatan = validateInput($_POST['jabatan']);
    
    if ($_POST["uker"] == "kanca") {
    	$iskanca = 1;
    	$idKanca = $_POST["lstKC"];
    }else {
    	$iskanca = 0;
    	$idKanca = 0;
    }
    $levelId = 3;
    $status = 1;
    
    // set session if registraion fail
    $_SESSION["reg_pn"] = $pn;
    $_SESSION["reg_email"] = $email;
    $_SESSION["reg_username"] = $userlname;
    $_SESSION["reg_jabatan"] = $jabatan;
    $_SESSION["reg_iskanca"] = $iskanca;
    $_SESSION["reg_idkanca"] = $idKanca;
    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //
 
    /*prep_stmt = "SELECT id FROM members WHERE email = ? LIMIT 1";
    $stmt = getConnection()->prepare($prep_stmt);
 
   // check existing email  
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
                        $stmt->close();
        }
                $stmt->close();
    } else {
        $error_msg .= '<p class="error">Database error Line 39</p>';
                $stmt->close();
    }
 	*/
    /* $dataToUpdate = getQueryResult(getConnection(),"SELECT user_id FROM m_user WHERE user_name = '".$username."' LIMIT 1");
    	
    while ($row = $dataToUpdate->fetch_assoc()){
    	$error_msg .= '<p class="error">A user with this username already exists</p>';
    } */
    
    
    // check existing pn
    $mysqli = getConnection();
    $prep_stmt = "SELECT user_id FROM m_user WHERE user_pn = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
    
    if ($stmt) {
        $stmt->bind_param('s', $pn);
        $stmt->execute();
        $stmt->store_result();
                if ($stmt->num_rows == 1) {
                        // A user with this pn already exists
                        $error_msg .= '<p class="error">Personal Number '.$pn.' sudah terdaftar.</p>';
                        //$stmt->close();
                }
                $stmt->close();
        } else {
                $error_msg .= '<p class="error">Database error line 55</p>';
                $stmt->close();
        }
    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
 	
    if (empty($error_msg)) {
        // Create a random salt
        //$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
 
        // Insert the new user into the database 
        $insert_prep = "INSERT INTO m_user (user_lname, user_password, user_pn,user_jabatan
											,user_level_id,user_uker,user_email,user_branch_id,user_status,user_salt,user_creadt,
        									user_upddt,user_creausr,user_updusr) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $insert_stmt = $mysqli->prepare($insert_prep);
        if ($insert_stmt) {
        	
        	$txtCreateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
        	$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
        	$txtCreateUser = mysqli_real_escape_string($mysqli,"REGISTER_PAGE");
        	$txtUpdateUser = mysqli_real_escape_string($mysqli,"REGISTER_PAGE");
        	
            $insert_stmt->bind_param('ssssiisiisssss', $userlname, $password, $pn,$jabatan,$levelId
            										,$iskanca,$email,$idKanca,$status,$random_salt
													,$txtCreateDt,$txtUpdateDt,$txtCreateUser,$txtUpdateUser);
            
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
               header('Location: ../kanwiljak3/register.php?error=1');
            }
        }
        }else{
        	$_SESSION['registration_error'] = $error_msg;
        	header('Location: ../kanwiljak3/register.php?error=1');
        	session_write_close();
      	
       }

       if (loginAfterRegistration($pn, $password, $mysqli) == true) {
       	// Login success
       	header('Location: ../kanwiljak3/view_atm_activitylog.php');
       	session_write_close();
       } else {
       	// Login failed
       	$_SESSION['registration_error'] = $error_msg;
       	header('Location: ../kanwiljak3/register.php?error=1');
       	session_write_close();
       	
       }
}
?>