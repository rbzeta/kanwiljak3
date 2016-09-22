<?php 

function sec_session_start() {
	//check if session is already timeout or not
	
	
	    $session_name = 'sec_session_j4k3';   // Set a custom session name
	    $secure = false;
	    // This stops JavaScript being able to access the session id.
	    $httponly = true;
	    // Forces sessions to only use cookies.
	    if (ini_set('session.use_only_cookies', 1) === FALSE) {
	        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
	        exit();
	    }
	    // Gets current cookies params.
	    $cookieParams = session_get_cookie_params();
	    session_set_cookie_params($cookieParams["lifetime"],
	        $cookieParams["path"], 
	        $cookieParams["domain"], 
	        $secure,
	        $httponly);
	    // Sets the session name to the one set above.
	    session_name($session_name);
	    session_start();            // Start the PHP session 
	    //session_regenerate_id();    // regenerated the session, delete the old one. 
	    //sessionTimeout();
	    //print session_id();
}

function sessionTimeout(){
	$timeout = 5;
	
	if (isset($_SESSION['expire'])) {
		// last request was more than 30 minutes ago
		$duration = time() - $_SESSION['expire'];
		echo "<script type='text/javascript'>alert('duration = ".$duration."');</script>";
		if ($duration > $timeout) {
			echo "<script type='text/javascript'>alert('Session anda telah habis, silahkan login kembali.');</script>";
			sec_session_destroy();
			
		}
		
	}
		 
	$_SESSION['expire'] = time(); // update last activity time stamp
	
}

function sec_session_destroy(){
	// Unset all session values
	$_SESSION = array();
	
	// get session parameters
	$params = session_get_cookie_params();
	
	// Delete the actual cookie.
	setcookie(session_name(),
	'', time() - 42000,
	$params["path"],
	$params["domain"],
	$params["secure"],
	$params["httponly"]);
	
	// Destroy session
	session_destroy();
}

function login($pn, $password, $mysqli) {
	
	$user_id=$username=$db_password=$salt=$user_pn=$jabatan=$userlevelid=$isuker=$useremail=
	$userbranchid=$userstatus=$branch_code=$branch_name="";
	
	$select_prep = "SELECT user_id, user_lname, user_password, user_salt,user_pn,user_jabatan,
										user_level_id,user_uker,user_email,user_branch_id,user_status,
										branch_mbcode,branch_mbname
			        FROM m_user
					left join m_branch on user_branch_id = branch_id
			       WHERE user_pn = ? and user_status = 1 
			        LIMIT 1";
	
	$stmt = $mysqli->prepare($select_prep);
	
	// Using prepared statements means that SQL injection is not possible.
	if ($stmt) {
        $stmt->bind_param('s', $pn);  // Bind "$user_name" to parameter.
        $stmt->execute();  // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $salt,$user_pn,$jabatan,$userlevelid,$isuker,$useremail,
        					$userbranchid,$userstatus,$branch_code,$branch_name);
        $stmt->fetch();
		
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
        	// If the user exists we check if the account is locked
        	// from too many login attempts
			
        	if (checkbrute($user_id, $mysqli) == true) {
        		// Account is locked
        		// Send an email to user saying their account is locked
        		$_SESSION['login_error'] = "Anda sudah melakukan kesalahan 5x, hubungi Administrator.";
        		return false;
        	} else {
        		// Check if the password in the database matches
        		// the password the user submitted.
        		if ($db_password == $password) {
        			// Password is correct!
        			// Get the user-agent string of the user.
        			$user_browser = $_SERVER['HTTP_USER_AGENT'];
        			// XSS protection as we might print this value
        			$user_id = preg_replace("/[^0-9]+/", "", $user_id);
        			$user_pn = preg_replace("/[^0-9]+/", "", $user_pn);
        			$_SESSION['user_id'] = $user_id;
        			$_SESSION['user_pn'] = $user_pn;
        			// XSS protection as we might print this value
        			//$username = preg_replace("/[^a-zA-Z0-9_\-]+/","",$username);
        			$_SESSION['user_name'] = $username;
        			$_SESSION['login_string'] = hash('sha512',
        					$password . $user_browser);
        			$_SESSION['user_jabatan'] = $jabatan;
        			$_SESSION['user_level_id'] = $userlevelid;
        			$_SESSION['user_uker'] = $isuker;
        			$_SESSION['user_email'] = $useremail;
        			$_SESSION['user_branch_id'] = $userbranchid;
        			$_SESSION['user_status'] = $userstatus;
        			$_SESSION['user_branch_code'] = $branch_code;
        			$_SESSION['user_branch_name'] = $branch_name;
        			
        			// Login successful.
        			return true;
        		} else {
        			// Password is not correct
        			// We record this attempt in the database
        			$now = time();
        			$mysqli->query("INSERT INTO m_login_attempts(user_id, time)
        					VALUES ('$user_id', '$now')");
        			
        			$_SESSION['login_error'] = "Invalid User Name or Password";
        			return false;
        		}
        	}
        } else {
        	// No user exists.
        	$_SESSION['login_error'] = "Invalid User Name or Password";
        	return false;
        }
	}
}

function checkbrute($user_id, $mysqli) {
	// Get timestamp of current time
	$now = time();

	// All login attempts are counted from the past 2 hours.
	$valid_attempts = $now - (2 * 60 * 60);

	$select_prep = "SELECT time
			FROM m_login_attempts
			WHERE user_id = ?
			AND time > '$valid_attempts'";
	
	$stmt = $mysqli->prepare($select_prep);
					
	if ($stmt) {
			$stmt->bind_param('i', $user_id);

			// Execute the prepared query.
			$stmt->execute();
			$stmt->store_result();

			// If there have been more than 5 failed logins
			if ($stmt->num_rows > 5) {
			return true;
			} else {
				return false;
			}
	}
}

function login_check($mysqli) {
	$password="";
	
	// Check if all session variables are set
	if (isset($_SESSION['user_id'],
			$_SESSION['user_name'],
			$_SESSION['login_string'])) {

		$user_id = $_SESSION['user_id'];
		$login_string = $_SESSION['login_string'];
		$username = $_SESSION['user_name'];

		// Get the user-agent string of the user.
		$user_browser = $_SERVER['HTTP_USER_AGENT'];
		
		$select_prep = "SELECT user_password
                                      FROM m_user
                                      WHERE user_id = ? LIMIT 1";
		
		$stmt = $mysqli->prepare($select_prep);

		if ($stmt) {
                                      // Bind "$user_id" to parameter.
		$stmt->bind_param('i', $user_id);
		$stmt->execute();   // Execute the prepared query.
		$stmt->store_result();

		if ($stmt->num_rows == 1) {
			// If the user exists get variables from result.
			$stmt->bind_result($password);
			$stmt->fetch();
			$login_check = hash('sha512', $password . $user_browser);

			if ($login_check == $login_string) {
				// Logged In!!!!
				return true;
			} else {
				// Not logged in
				//echo "login_check == login_string";
				return false;
			}
		} else {
			// Not logged in
			//echo "stmt->num_rows";
			return false;
		}
		} else {
			// Not logged in
			//echo "stmt error";
			return false;
		}
	} else {
		
		// Not logged in
		//echo "session kosong";
		return false;
	}
}

function esc_url($url) {

	if ('' == $url) {
		return $url;
	}

	$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

	$strip = array('%0d', '%0a', '%0D', '%0A');
	$url = (string) $url;

	$count = 1;
	while ($count) {
		$url = str_replace($strip, '', $url, $count);
	}

	$url = str_replace(';//', '://', $url);

	$url = htmlentities($url);

	$url = str_replace('&amp;', '&#038;', $url);
	$url = str_replace("'", '&#039;', $url);

	if ($url[0] !== '/') {
		// We're only interested in relative links from $_SERVER['PHP_SELF']
		return '';
	} else {
		return $url;
	}
}

function loginAfterRegistration($pn, $password, $mysqli) {

	$user_id=$username=$db_password=$salt=$user_pn=$jabatan=$userlevelid=$isuker=$useremail=
	$userbranchid=$userstatus=$branch_code=$branch_name="";
	
	$select_prep = "SELECT user_id, user_lname, user_password, user_salt,user_pn,user_jabatan,
										user_level_id,user_uker,user_email,user_branch_id,user_status,
										branch_mbcode,branch_mbname
        FROM m_user
		left join m_branch on user_branch_id = branch_id
       WHERE user_pn = ? and user_status = 1 
        LIMIT 1";
	
	$stmt = $mysqli->prepare($select_prep);
	// Using prepared statements means that SQL injection is not possible.
	if ($stmt) {
        $stmt->bind_param('s', $pn);  // Bind "$user_name" to parameter.
        $stmt->execute();  // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $salt,$user_pn,$jabatan,$userlevelid,$isuker,$useremail,
        					$userbranchid,$userstatus,$branch_code,$branch_name);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {
        	// If the user exists we check if the account is locked
        	// Check if the password in the database matches
        	// the password the user submitted.
        		if ($db_password == $password) {
        			// Password is correct!
        			// Get the user-agent string of the user.
        			$user_browser = $_SERVER['HTTP_USER_AGENT'];
        			// XSS protection as we might print this value
        			$user_id = preg_replace("/[^0-9]+/", "", $user_id);
        			$user_pn = preg_replace("/[^0-9]+/", "", $user_pn);
        			$_SESSION['user_id'] = $user_id;
        			$_SESSION['user_pn'] = $user_pn;
        			// XSS protection as we might print this value
        			$_SESSION['user_name'] = $username;
        			$_SESSION['login_string'] = hash('sha512',
        					$password . $user_browser);
        			$_SESSION['user_jabatan'] = $jabatan;
        			$_SESSION['user_level_id'] = $userlevelid;
        			$_SESSION['user_uker'] = $isuker;
        			$_SESSION['user_email'] = $useremail;
        			$_SESSION['user_branch_id'] = $userbranchid;
        			$_SESSION['user_status'] = $userstatus;
        			$_SESSION['user_branch_code'] = $branch_code;
        			$_SESSION['user_branch_name'] = $branch_name;
        			// Login successful.
        			return true;
        		} else {
        			// Password is not correct
        			// We record this attempt in the database
        			$now = time();
        			$mysqli->query("INSERT INTO m_login_attempts(user_id, time)
        					VALUES ('$user_id', '$now')");
        			 
        			$_SESSION['registration_error'] = "Invalid User Name or Password";
        			return false;
        		}
        	
        } else {
        	// No user exists.
        	$_SESSION['registration_error'] = "Invalid User Name or Password";
        	return false;
        }
	}
}

function loginAfterUpdateUser($user_id_session, $password, $mysqli) {

	$user_id=$username=$db_password=$salt=$user_pn=$jabatan=$userlevelid=$isuker=$useremail=
	$userbranchid=$userstatus=$branch_code=$branch_name="";
	
	$select_prep = "SELECT user_id, user_lname, user_password, user_salt,user_pn,user_jabatan,
										user_level_id,user_uker,user_email,user_branch_id,user_status,
										branch_mbcode,branch_mbname
        FROM m_user
		left join m_branch on user_branch_id = branch_id
       WHERE user_id = ? and user_status = 1
        LIMIT 1";
	
	$stmt = $mysqli->prepare($select_prep);
	
	// Using prepared statements means that SQL injection is not possible.
	if ($stmt) {
        $stmt->bind_param('s', $user_id_session);  // Bind "$user_name" to parameter.
        $stmt->execute();  // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $salt,$user_pn,$jabatan,$userlevelid,$isuker,$useremail,
        		$userbranchid,$userstatus,$branch_code,$branch_name);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {
        	// If the user exists we check if the account is locked
        	// Check if the password in the database matches
        	// the password the user submitted.
        	if ($db_password == $password) {
        		// Password is correct!
        		// Get the user-agent string of the user.
        		$user_browser = $_SERVER['HTTP_USER_AGENT'];
        		// XSS protection as we might print this value
        		$user_id = preg_replace("/[^0-9]+/", "", $user_id);
        		$user_pn = preg_replace("/[^0-9]+/", "", $user_pn);
        		$_SESSION['user_id'] = $user_id;
        		$_SESSION['user_pn'] = $user_pn;
        		// XSS protection as we might print this value
        		$_SESSION['user_name'] = $username;
        		$_SESSION['login_string'] = hash('sha512',
        				$password . $user_browser);
        		$_SESSION['user_jabatan'] = $jabatan;
        		$_SESSION['user_level_id'] = $userlevelid;
        		$_SESSION['user_uker'] = $isuker;
        		$_SESSION['user_email'] = $useremail;
        		$_SESSION['user_branch_id'] = $userbranchid;
        		$_SESSION['user_status'] = $userstatus;
        		$_SESSION['user_branch_code'] = $branch_code;
        		$_SESSION['user_branch_name'] = $branch_name;
        		// Login successful.
        		return true;
        	} else {
        		// Password is not correct
        		// We record this attempt in the database
        		$now = time();
        		$mysqli->query("INSERT INTO m_login_attempts(user_id, time)
        				VALUES ('$user_id', '$now')");

        		$_SESSION['update_user_error'] = "Invalid User Name atau Password";
        		return false;
        	}
        	 
        } else {
        	// No user exists.
        	$_SESSION['update_user_error'] = "User tidak terdftar";
        	return false;
        }
	}
}

function tokenIsVerified($tokenValue, $mysqli) {
	$token="";
	$_SESSION['token_is_verified'] = "false";
	$select_prep = "SELECT token_id
        FROM m_tsi_monbin_token
        LIMIT 1";
	
	$stmt = $mysqli->prepare($select_prep);
	
	// Using prepared statements means that SQL injection is not possible.
	if ($stmt) {
		$stmt->execute();  // Execute the prepared query.
		$stmt->store_result();
	
		// get variables from result.
		$stmt->bind_result($token);
		$stmt->fetch();
		
		if ($stmt->num_rows == 1) {
			if($token == $tokenValue){
				$_SESSION['token_is_verified'] = "true";
				return true;
			}else return false;
		}else {
			$_SESSION['verify_token_error'] = "Token is empty.";
			$_SESSION['token_is_verified'] = "false";
			return false;
		}
	}else {
		$_SESSION['verify_token_error'] = "Token query error";
		$_SESSION['token_is_verified'] = "false";
		return false;
	}
		
}

?>