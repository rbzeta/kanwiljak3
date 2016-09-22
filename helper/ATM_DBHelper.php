<?php 
function getViewATMProblemByTID($mysqli,$criteria,$txtSearchSQL){
	$select_prep = " SELECT DISTINCT atmproblem_keterangan AS atmnop_keterangan,atmproblem_creadt AS atmnop_creadt,
						atmproblem_tid AS atmnop_tid,atmproblem_creausr AS atmnop_creausr,'-' AS atmnop_status
						FROM m_atm_problem_keterangan 
						WHERE atmproblem_tid = ? AND atmproblem_keterangan <> ''
						GROUP BY atmnop_keterangan
						
						UNION ALL 
						
						SELECT DISTINCT atmnop_keterangan,atmnop_creadt,atmnop_tid,atmnop_creausr,atmnop_status
						FROM m_atm_nop_sum
						WHERE atmnop_tid = ? AND atmnop_keterangan <> ''
						GROUP BY atmnop_keterangan ";
													 

	//$select_prep .= $criteria;
	$select_prep .= " ORDER BY atmnop_creadt DESC  ";
	$select_stmt = $mysqli->prepare($select_prep);

	// TEST ONLY ECHO QUERY
	//echo $select_prep;
	//TEST ONLY
	if ($select_stmt) {
		if ($criteria <> "") {
			$select_stmt->bind_param('ss', $txtSearchSQL,$txtSearchSQL);
		
		}
			
		$select_stmt->execute();
		$select_stmt->store_result();
	}

	return $select_stmt;
}

function getATMProblemKeteranganByTID($mysqli,$tid){
	$select_prep = " SELECT atmproblem_tid,
							atmproblem_creadt,
							atmproblem_creausr,
							atmproblem_keterangan 
						FROM m_atm_problem_keterangan
						WHERE atmproblem_tid = ?
						
				
							 ";
	$select_prep .= " ORDER BY atmproblem_creadt DESC ";

	$select_stmt = $mysqli->prepare($select_prep);
	
	//TEST ONLY ECHO QUERY
	//echo $select_prep.$logged.$isUker;
	//TEST ONLY
	if ($select_stmt) {
		
		$select_stmt->bind_param('s', $tid);
	
		
			
		$select_stmt->execute();
		$select_stmt->store_result();
	}

	return $select_stmt;
}

function getJadwalDetailByid($mysqli,$tid){
	$select_prep = " SELECT
						  atmjadwal_id,
						  atmjadwal_date,
						  atmjadwal_branch_id,
						  atmjadwal_tid,
						  atmjadwal_pic,
						  atmjadwal_keterangan,
						  atmjadwal_creadt,
						  atmjadwal_creausr,
						  atmjadwal_upddt,
						  atmjadwal_updusr,
						  atmjadwal_isactive
						FROM m_atm_jadwal
						WHERE atmjadwal_id = ?


							 ";
	//$select_prep .= " ORDER BY atmproblem_creadt DESC ";

	$select_stmt = $mysqli->prepare($select_prep);

	//TEST ONLY ECHO QUERY
	//echo $select_prep.$logged.$isUker;
	//TEST ONLY
	if ($select_stmt) {

		$select_stmt->bind_param('s', $tid);


			
		$select_stmt->execute();
		$select_stmt->store_result();
	}

	return $select_stmt;
}

function getATMNOPSUM($mysqli,$criteria,$txtSearchSQL){
	$select_prep = " SELECT
							  atmnop_id,
							  atmnop_tid,
							  atmnop_brand,
							  atmnop_vendor,
							  atmnop_ip,
							  atmnop_lokasi,
							  atmnop_area,
							  atmnop_pengelola,
							  atmnop_downtime,
							  CONCAT_WS('\n\n',CONCAT('(',atmproblem_creadt,') ',atmproblem_creausr ,' : ',atmproblem_keterangan),atmnop_keterangan)atmnop_keterangan,
							  atmnop_petugas,
							  atmnop_lasttrx,
							  atmnop_creadt,
							  atmnop_upddt,
							  atmnop_creausr,
							  atmnop_updusr,
							  atmnop_garansi,
							  atmnop_status,
							  CASE 
								WHEN ISNULL(r.atmreplace_tid) THEN '-'
								ELSE 'Replace'
								END AS atmnop_isreplace
							FROM m_atm_nop_sum
							LEFT JOIN m_atm_replace r ON r.atmreplace_tid= atmnop_tid
							LEFT JOIN (SELECT DISTINCT atmproblem_tid,atmproblem_creadt,atmproblem_keterangan ,atmproblem_creausr
												FROM m_atm_problem_keterangan t1
												WHERE t1.atmproblem_creadt = (SELECT MAX(t2.atmproblem_creadt) 
																FROM m_atm_problem_keterangan t2
																WHERE t2.atmproblem_tid = t1.atmproblem_tid)) AS T3
											ON T3.atmproblem_tid = atmnop_tid
							WHERE atmnop_isactive = 1 
							
							 ";
	
	$select_prep .= $criteria;
	
	$select_prep .= " ORDER BY atmnop_isreplace,atmnop_status,atmnop_rowno ";
	
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

function getJadwalData($mysqli,$criteria,$txtSearchSQL,$criteriaBranch){
	$select_prep = " SELECT
							  atmjadwal_id,
							  atmjadwal_date,
							  atmjadwal_branch_id,
							  atmjadwal_tid,
							  atmjadwal_pic,
							  atmjadwal_keterangan,
							  atmjadwal_creadt,
							  atmjadwal_creausr,
							  atmjadwal_upddt,
							  atmjadwal_updusr,
							  brdesc,
							  atmjadwal_isactive
							FROM m_atm_jadwal
							LEFT JOIN dwh_branch ON branch = atmjadwal_branch_id
							WHERE atmjadwal_isactive = 1
				
							 ";
	
	$select_prep .= $criteriaBranch;
	$select_prep .= $criteria;

	$select_prep .= " ORDER BY atmjadwal_date,atmjadwal_branch_id desc ";
	//echo $select_prep;
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

function getMaxDateNOP($mysqli){
	$select_prep = " SELECT MAX(atmnop_creadt) AS atmproblem_creadt
					FROM m_atm_nop_sum ";


	$select_stmt = $mysqli->prepare($select_prep);

	// TEST ONLY ECHO QUERY
	//echo $select_prep;
	//TEST ONLY
	if ($select_stmt) {
		
		$select_stmt->execute();
		$select_stmt->store_result();
	}

	return $select_stmt;
}

function getSparepartATM($mysqli,$criteria,$txtSearchSQL){
	$select_prep = " SELECT
							  atmpart_id,
							  atm_brand_sname,
							  jenispart_name,
							  atmpart_sn,
							  atmpart_source_tid,
							  atmpart_dest_tid,
							  atmpart_keterangan,
							  atmpart_isactive,
							  atmpart_creadt,
							  atmpart_upddt,
							  atmpart_creausr,
							  atmpart_updusr,
							  statuspart_name
							FROM m_atm_sparepart
							LEFT JOIN m_atm_status_part ON statuspart_id = atmpart_status_id
							LEFT JOIN m_atm_brand2 ON atm_brand_id = atmpart_brand_id
							LEFT JOIN m_atm_jenispart ON jenispart_id = atmpart_jenis_id
							WHERE atmpart_isactive = 1 ";
													 

	$select_prep .= $criteria;
	$select_prep .= " ORDER BY statuspart_name,atm_brand_sname,jenispart_name ";
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

function getSparepartATMPagin($mysqli,$criteria,$txtSearchSQL,$start, $per_page){
	$select_prep = " SELECT
							  atmpart_id,
							  atm_brand_sname,
							  jenispart_name,
							  atmpart_sn,
							  atmpart_source_tid,
							  atmpart_dest_tid,
							  atmpart_keterangan,
							  atmpart_isactive,
							  atmpart_creadt,
							  atmpart_upddt,
							  atmpart_creausr,
							  atmpart_updusr,
							  statuspart_name
							FROM m_atm_sparepart
							LEFT JOIN m_atm_status_part ON statuspart_id = atmpart_status_id
							LEFT JOIN m_atm_brand2 ON atm_brand_id = atmpart_brand_id
							LEFT JOIN m_atm_jenispart ON jenispart_id = atmpart_jenis_id
							WHERE atmpart_isactive = 1 ";


	$select_prep .= $criteria;
	$select_prep .= " ORDER BY statuspart_name,atm_brand_sname,jenispart_name LIMIT $start, $per_page";
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

function getCountSparepartATM($mysqli,$criteria,$txtSearchSQL){
	$select_prep = " SELECT   COUNT(atmpart_id)
							FROM m_atm_sparepart
							LEFT JOIN m_atm_status_part ON statuspart_id = atmpart_status_id
							LEFT JOIN m_atm_brand2 ON atm_brand_id = atmpart_brand_id
							LEFT JOIN m_atm_jenispart ON jenispart_id = atmpart_jenis_id
							WHERE atmpart_isactive = 1 ";


	$select_prep .= $criteria;
	//$select_prep .= " ORDER BY statuspart_name,atm_brand_sname,jenispart_name LIMIT $start, $per_page";
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

function getATMMaintenanceExcel($mysqli,$criteria,$txtSearchSQL,$criteria2){
	$select_prep = " select atm_act_id,atm_act_date,atm_act_loc,atm_act_tid,atm_act_pmaction,
														atm_act_pmteamkc,atm_act_pmdesc,atm_brand_sname,atm_cro_name,branch_code,atm_act_isonsite,
														branch_name,branch_mbcode,branch_mbname,problem_name,status_name,status_id,atm_act_isgaransi,
														u.user_lname,u.user_uker
														from m_atm_activitylog
														left join m_atm_brand on atm_brand_id = atm_act_brand_id
														left join m_user u on user_id = atm_act_pmteamkw_id
														left join m_atm_cro on atm_cro_id = atm_act_cro_id
														left join m_branch on branch_id = atm_act_branch_id
														left join m_problem_cat on problem_id = atm_act_probcat_id
														left join m_status on status_id = atm_act_status_id ";


	$select_prep .= $criteria;
	$select_prep .= $criteria2;
	$select_prep .= " ORDER BY atm_act_upddt DESC";
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

function getCROList($mysqli){
	//get kanca list
	$select_cro = "select 0 as atm_cro_id,'-' as atm_cro_name
					union all
						SELECT distinct atm_cro_id,atm_cro_name
							FROM m_atm_cro order by atm_cro_name "; ;
							$cro_stmt = $mysqli->prepare($select_cro);

							if ($cro_stmt) {

							$cro_stmt->execute();
							$cro_stmt->store_result();
}

return $cro_stmt;
}

function getATMBrandList($mysqli){
	//get kanca list
	$select_brandatm = "select 0 as atm_brand_id,'-' as atm_brand_sname 
			union all 
			SELECT distinct atm_brand_id,atm_brand_sname 
			FROM m_atm_brand2 order by atm_brand_sname ";
	
	$brandatm_stmt = $mysqli->prepare($select_brandatm);

	if ($brandatm_stmt) {

		$brandatm_stmt->execute();
		$brandatm_stmt->store_result();
	}

	return $brandatm_stmt;
}

function getATMProblemList($mysqli){
	//get kanca list
	$select_problematm = "select 0 as problem_id,'-' as problem_name 
			union all 
			SELECT distinct problem_id,problem_name 
			FROM m_problem_cat order by problem_name ";

	$problematm_stmt = $mysqli->prepare($select_problematm);

	if ($problematm_stmt) {

		$problematm_stmt->execute();
		$problematm_stmt->store_result();
	}

	return $problematm_stmt;
}

function getATMStatusList($mysqli){
	//get kanca list
	$select_statusatm = "SELECT 0 as status_id,'-' as status_name 
			UNION ALL 
			SELECT status_id,status_name 
			FROM m_status ";

	$statusatm_stmt = $mysqli->prepare($select_statusatm);

	if ($statusatm_stmt) {

		$statusatm_stmt->execute();
		$statusatm_stmt->store_result();
	}

	return $statusatm_stmt;
}

function getATMJenisPartList($mysqli){
	//get kanca list
	$select_jenispart = "SELECT 0 as jenispart_id,'-' as jenispart_name
			UNION ALL
			SELECT jenispart_id,jenispart_name
			FROM m_atm_jenispart ";

	$jenispart_stmt = $mysqli->prepare($select_jenispart);

	if ($jenispart_stmt) {

		$jenispart_stmt->execute();
		$jenispart_stmt->store_result();
	}

	return $jenispart_stmt;
}

function getATMStatusPartList($mysqli){
	//get kanca list
	$select_statuspart = "SELECT 0 as statuspart_id,'-' as statuspart_name
			UNION ALL
			SELECT statuspart_id,statuspart_name
			FROM m_atm_status_part ";

	$statuspart_stmt = $mysqli->prepare($select_statuspart);

	if ($statuspart_stmt) {

		$statuspart_stmt->execute();
		$statuspart_stmt->store_result();
	}

	return $statuspart_stmt;
}
function insertATMJadwal($mysqli)
{
	$isActive = 1;
	// Update the data into the database
	$insert_prep = " INSERT INTO m_atm_jadwal
				            (atmjadwal_date,
				             atmjadwal_branch_id,
				             atmjadwal_tid,
				             atmjadwal_pic,
				             atmjadwal_keterangan,
				             atmjadwal_creadt,
				             atmjadwal_creausr,
				             atmjadwal_upddt,
				             atmjadwal_updusr,
				             atmjadwal_isactive)
					VALUES (?,?,?,?,?,?,?,?,?,?) ;  ";
	
	$insert_stmt = $mysqli->prepare($insert_prep);
	
	if ($insert_stmt) {
	
		$varDate = str_replace('/', '-', $_POST["atmjadwal_date"]);
		$txtDate = date('Y/m/d', strtotime($varDate));
		$txtDate = mysqli_real_escape_string($mysqli,$txtDate);
	
		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
		if (!empty($_SESSION['user_pn'])) {
			$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);;
		}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
			
		$insert_stmt->bind_param('sisssssssi', 	
				validateInput($txtDate),
				validateInput($_POST['select_kanca']),
				validateInput($_POST['atmjadwal_tid']),
				validateInput($_POST['atmjadwal_pic']),
				validateInput($_POST['atmjadwal_keterangan']),
				validateInput($txtUpdateDt),
				validateInput($txtUpdateUser),
				validateInput($txtUpdateDt),
				validateInput($txtUpdateUser),
				$isActive);
	
		// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data [exec q error].');
				  </script>";
		}else{ echo "<script type='text/javascript'>
					alert('Data berhasil disimpan.');
					redirectPage('input_jadwal_atm_finish');
				  </script>";
		}
	}else{
		echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data. [statement q error]');
				  </script>";
		/* header('Location: ../kanwiljak3/error.php?error=1');
			session_write_close(); */
	}
}
function insertATMSparepart($mysqli){
	// insert the data into the database
	$insert_prep = "INSERT INTO m_atm_sparepart
			            (atmpart_brand_id,
			             atmpart_jenis_id,
			             atmpart_sn,
			             atmpart_source_tid,
			             atmpart_dest_tid,
			             atmpart_keterangan,
			             atmpart_isactive,
			             atmpart_creadt,
			             atmpart_upddt,
			             atmpart_creausr,
			             atmpart_updusr,
						 atmpart_status_id)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?);  ";
	
	$insert_stmt = $mysqli->prepare($insert_prep);
	if ($insert_stmt) {
		
		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
        	if (!empty($_SESSION['user_pn'])) {
        		$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);
        	}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
		 
		$insert_stmt->bind_param('iissssissssi', 
												    validateInput($_POST['select_merk']),
													validateInput($_POST['select_part']),
													validateInput($_POST['atmpart_sn']),
													validateInput($_POST['atmpart_source_tid']),
													validateInput($_POST['atmpart_dest_tid']),
													validateInput($_POST['atmpart_keterangan']),
													validateInput('1'),
													validateInput($txtUpdateDt),
													validateInput($txtUpdateDt),
													validateInput($txtUpdateUser),
													validateInput($txtUpdateUser),
													validateInput($_POST['select_statuspart']));
		
		// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data.');
				  </script>";
		}else echo "<script type='text/javascript'>
					alert('Data berhasil disimpan.');
				  </script>";
		}else{
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data [q] query.');
				  </script>";
			/* header('Location: ../kanwiljak3/error.php?error=1');
				session_write_close(); */
		}
	

	return $insert_stmt;
}


function updateATMSparepartById($mysqli,$tid){
	// insert the data into the database
	$insert_prep = "UPDATE m_atm_sparepart
					SET atmpart_brand_id = ?,
					  atmpart_jenis_id = ?,
					  atmpart_sn = ?,
					  atmpart_source_tid = ?,
					  atmpart_dest_tid = ?,
					  atmpart_keterangan = ?,
					  atmpart_upddt = ?,
					  atmpart_updusr = ?,
					  atmpart_status_id = ?
					WHERE atmpart_id = ?;  ";

	$insert_stmt = $mysqli->prepare($insert_prep);

	if ($insert_stmt) {

		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
		if (!empty($_SESSION['user_pn'])) {
			$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);
		}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
			
		$insert_stmt->bind_param('iissssissi',
				validateInput($_POST['select_merk']),
				validateInput($_POST['select_part']),
				validateInput($_POST['atmpart_sn']),
				validateInput($_POST['atmpart_source_tid']),
				validateInput($_POST['atmpart_dest_tid']),
				validateInput($_POST['atmpart_keterangan']),
				validateInput($txtUpdateDt),
				validateInput($txtUpdateUser),
				validateInput($_POST['select_statuspart']),
				$tid);

		// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data.');
				  </script>";
		}else echo "<script type='text/javascript'>
					alert('Data berhasil disimpan.');
					redirectPage('update_sparepart_atm_finish');
				  </script>";
	}else{
		echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data [q] query.');
				  </script>";
		/* header('Location: ../kanwiljak3/error.php?error=1');
		 session_write_close(); */
	}


	return $insert_stmt;
}

function updateATMJadwalById($mysqli,$tid){
	// insert the data into the database
	$insert_prep = " UPDATE m_atm_jadwal
					 SET atmjadwal_date = ?,
					  atmjadwal_branch_id = ?,
					  atmjadwal_tid = ?,
					  atmjadwal_pic = ?,
					  atmjadwal_keterangan = ?,
					  atmjadwal_upddt = ?,
					  atmjadwal_updusr = ?
					WHERE atmjadwal_id = ?;  ";

	$insert_stmt = $mysqli->prepare($insert_prep);

	if ($insert_stmt) {
		
		$varDate = str_replace('/', '-', $_POST["atmjadwal_date"]);
		$txtDate = date('Y/m/d', strtotime($varDate));
		$txtDate = mysqli_real_escape_string($mysqli,$txtDate);
		
		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
		if (!empty($_SESSION['user_pn'])) {
			$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);
		}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
			
		$insert_stmt->bind_param('ssssssss',
				validateInput($txtDate),
				validateInput($_POST['select_kanca']),
				validateInput($_POST['atmjadwal_tid']),
				validateInput($_POST['atmjadwal_pic']),
				validateInput($_POST['atmjadwal_keterangan']),
				validateInput($txtUpdateDt),
				validateInput($txtUpdateUser),
				$tid);

		// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data.');
				  </script>";
		}else echo "<script type='text/javascript'>
					alert('Data berhasil disimpan.');
					redirectPage('update_jadwal_atm_finish');
				  </script>";
	}else{
		echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data [q] query.');
				  </script>";
		/* header('Location: ../kanwiljak3/error.php?error=1');
		 session_write_close(); */
	}


	return $insert_stmt;
}

function updateATMProblemById($mysqli,$tid){
	// insert the data into the database
	$insert_prep = "UPDATE m_atm_nop_sum
						SET 
						  atmnop_tid = ?,
						  atmnop_brand = ?,
						  atmnop_vendor = ?,
						  atmnop_lokasi = ?,
						  atmnop_area = ?,
						  atmnop_pengelola = ?,
						  atmnop_petugas = ?,
						  atmnop_upddt = ?,
						  atmnop_updusr = ?
						  
					WHERE atmnop_id = ?;  ";

	$insert_stmt = $mysqli->prepare($insert_prep);

	if ($insert_stmt) {

		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
		if (!empty($_SESSION['user_pn'])) {
			$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);
		}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
			
		$insert_stmt->bind_param('ssssssssss',
				validateInput($_POST['atmnop_tid']),
				validateInput($_POST['atmnop_brand']),
				validateInput($_POST['atmnop_vendor']),
				validateInput($_POST['atmnop_lokasi']),
				validateInput($_POST['atmnop_area']),
				validateInput($_POST['atmnop_pengelola']),
				validateInput($_POST['atmnop_petugas']),
				validateInput($txtUpdateDt),
				validateInput($_SESSION['user_name']),
				$tid);

		// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data.');
				  </script>";
		}else {
			$insert_prep_ket = "INSERT INTO m_atm_problem_keterangan
							            (atmproblem_tid,
							             atmproblem_keterangan,
							             atmproblem_creadt,
							             atmproblem_creausr)
							VALUES (?,
							        ?,
							        ?,
							        ?);";
			
			$insert_stmt_ket = $mysqli->prepare($insert_prep_ket);
					
			if ($insert_stmt_ket) {
				
				$insert_stmt_ket->bind_param('ssss',
						validateInput($_POST['atmnop_tid']),
						validateInput($_POST['atmnop_keterangan']),
						validateInput($txtUpdateDt),
						validateInput($txtUpdateUser));
				
				$insert_stmt_ket->execute();
			}
			
			echo "<script type='text/javascript'>
					alert('Data berhasil disimpan.');
					redirectPage('update_problem_atm_finish');
				  </script>";
		}
					
	}else{
		echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data [q] query.');
				  </script>";
		/* header('Location: ../kanwiljak3/error.php?error=1');
		 session_write_close(); */
	}


	return $insert_stmt;
}

function getATMPartDetailByid($mysqli,$tid){

	$select_prep = " SELECT
							  atmpart_id,
							  atmpart_brand_id,
							  atmpart_jenis_id,
							  atmpart_sn,
							  atmpart_source_tid,
							  atmpart_dest_tid,
							  atmpart_keterangan,
							  atmpart_isactive,
							  atmpart_creadt,
							  atmpart_upddt,
							  atmpart_creausr,
							  atmpart_updusr,
							  atmpart_status_id
							FROM m_atm_sparepart
							WHERE atmpart_isactive = 1 and atmpart_id = ? LIMIT 1
							 ";
	
	$select_stmt = $mysqli->prepare($select_prep);
	
	// TEST ONLY ECHO QUERY
	//echo $select_prep.$logged.$isUker;
	//TEST ONLY
	if ($select_stmt) {
		
		$select_stmt->bind_param('s', $tid);
	
		
			
		$select_stmt->execute();
		$select_stmt->store_result();
	}
	
	return $select_stmt;
}

function getATMProblemDetailByid($mysqli,$tid){

	$select_prep = " SELECT
							  atmnop_id,
							  atmnop_tid,
							  atmnop_brand,
							  atmnop_vendor,
							  atmnop_ip,
							  atmnop_lokasi,
							  atmnop_area,
							  atmnop_pengelola,
							  atmnop_downtime,
							  atmnop_keterangan,
							  atmnop_petugas,
							  atmnop_lasttrx,
							  atmnop_creadt,
							  atmnop_upddt,
							  atmnop_creausr,
							  atmnop_updusr,
							  atmnop_garansi,
							  atmnop_status
							  
							FROM kanwiljak3.m_atm_nop_sum
							WHERE atmnop_isactive = 1 and atmnop_id = ? LIMIT 1
							 ";

	$select_stmt = $mysqli->prepare($select_prep);

	// TEST ONLY ECHO QUERY
	//echo $select_prep.$logged.$isUker;
	//TEST ONLY
	if ($select_stmt) {

		$select_stmt->bind_param('s', $tid);


			
		$select_stmt->execute();
		$select_stmt->store_result();
	}

	return $select_stmt;
}
?>
