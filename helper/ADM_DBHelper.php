<?php 
function getUserData($mysqli,$criteria,$txtSearchSQL){
	$select_prep = " SELECT
								  user_id,
								  user_name,
								  user_lname,
								  user_password,
								  user_pn,
								  user_jabatan,
								  user_level_id,
								  user_uker,
								  user_email,
								  user_teamkw_id,
								  user_branch_id,
								  user_status,
								  user_logintry,
								  user_salt,
								  user_creadt,
								  user_upddt,
								  user_creausr,
								  user_updusr,
								  user_tsi_monbin,
								  branch_name
								FROM m_user
								LEFT JOIN m_branch ON branch_id = user_branch_id
							
							
							 ";
	
	$select_prep .= $criteria;
	
	$select_prep .= " ORDER BY user_lname ";
	
	$select_stmt = $mysqli->prepare($select_prep);

	// TEST ONLY ECHO QUERY
	//echo $select_prep;
	//TEST ONLY
	if ($select_stmt) {
		if ($criteria <> "") {
			$select_stmt->bind_param('s', $txtSearchSQL);
												
		}
			$select_stmt->execute();
			$select_stmt->store_result();
	}

	return $select_stmt;
}

function getUserDetailByid($mysqli,$tid){
	$select_prep = " SELECT
								  user_id,
								  user_name,
								  user_lname,
								  user_password,
								  user_pn,
								  user_jabatan,
								  user_level_id,
								  user_uker,
								  user_email,
								  user_teamkw_id,
								  user_branch_id,
								  user_status,
								  user_logintry,
								  user_salt,
								  user_creadt,
								  user_upddt,
								  user_creausr,
								  user_updusr,
								  user_tsi_monbin
								FROM m_user
								LEFT JOIN m_branch ON branch_id = user_branch_id
								WHERE user_id = ?
								LIMIT 1
				
							 ";

	//$select_prep .= $criteria;

	//$select_prep .= " ORDER BY user_lname ";

	$select_stmt = $mysqli->prepare($select_prep);

	// TEST ONLY ECHO QUERY
	//echo $select_prep;
	//TEST ONLY
	if ($select_stmt) {
		$select_stmt->bind_param('s', $tid);
		$select_stmt->execute();
		$select_stmt->store_result();
	}

	return $select_stmt;
}

function updateUserProfileById($mysqli, $user_id)
{
	$txtPassword = mysqli_real_escape_string($mysqli,$_POST["p"]);
	// Create a random salt
	//$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
	$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
	
	// Create salted password
	$password = hash('sha512', $txtPassword . $random_salt);
	
	if ($_POST["user_uker"] == "kanca") {
		$iskanca = 1;
		$idKanca = $_POST["select_kanca"];
	}else {
		$iskanca = 0;
		$idKanca = 0;
	}
	
	//$password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
	if (strlen($password) != 128) {
		// The hashed pwd should be 128 characters long.
		// If it's not, something really odd has happened
		$error_msg .= '<p class="error">Konfigurasi password tidak valid.</p>';
	}
	
	if (empty($error_msg)) {
		// Update the data into the database
		$insert_prep = "UPDATE m_user
							SET user_pn = ?,
								user_password = ?,
								user_lname = ?,
							  	user_jabatan = ?,
								user_email = ?,
							  	user_uker = ?,	
							  	user_branch_id = ?,
								user_status = ?,
							  	user_salt = ?,
							  	user_upddt = ?,
							  	user_updusr = ?
							WHERE user_id = ? ;";
	
		$insert_stmt = $mysqli->prepare($insert_prep);
	
		if ($insert_stmt) {
	
			$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
			if (!empty($_SESSION['user_pn'])) {
				$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);;
			}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
				
			$insert_stmt->bind_param('sssssiiissss',
					validateInput($_POST['user_pn']),
					validateInput($password),
					validateInput($_POST['user_lname']),
					validateInput($_POST['user_jabatan']),
					validateInput($_POST['user_email']),
					validateInput($iskanca),
					validateInput($idKanca),
					validateInput($_POST['select_status']),
					validateInput($random_salt),
					validateInput($txtUpdateDt),
					validateInput($txtUpdateUser),
					$user_id);
	
			// 	echo $_POST['user_lname'];
			// 	echo $_POST['user_jabatan'];
			// 	echo $iskanca;
			// 	echo $_POST['user_email'];
			//	echo $idKanca;
			//	echo $password;
			// 	echo $random_salt;
			// 	echo $txtUpdateDt;
			// 	echo $txtUpdateUser;
			// 	echo $user_id;
			// Execute the prepared query.
			if (! $insert_stmt->execute()) {
				echo "<script type='text/javascript'>
						alert('Terjadi kesalahan saat menyimpan data.[statement]');
					  </script>";
			}else {
				//loginAfterUpdateUser($user_id, $password, $mysqli);
				echo "<script type='text/javascript'>
						alert('Data berhasil disimpan.');
						redirectPage('update_user_admin_finish');
						</script>";
			}
		}else{
			echo "<script type='text/javascript'>
						alert('Terjadi kesalahan saat menyimpan data.[query]');
					  </script>";
			/* header('Location: ../kanwiljak3/error.php?error=1');
			 session_write_close(); */
		}
	
	}
}
?>
