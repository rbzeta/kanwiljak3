<?php 

function getEDCUKOVerifikasi($mysqli,$criteria,$txtSearchSQL){
	$branch_code = "";
	
	if (!empty($_SESSION['user_branch_code'])){
		$branch_code = $_SESSION['user_branch_code'];
	}
	
	$select_prep = " SELECT
					  `MID`,
					  `TID`,
						`NAMA UNIT KERJA`,
					  `KODE UKER PEMRAKARSA`,
					  `UKER PEMRAKARSA`,
					  `uker_implementor`,
					  `KANCA INPLEMENTOR`,
					  u.`mainbr`,
					  d1.`BRDESC`,
					  u.`mainbr_imp`,
					  d2.`BRDESC`,
					  keterangan
					FROM m_edc_uko_verif u
					LEFT JOIN dwh_branch d1 ON d1.`BRANCH` = u.mainbr
					LEFT JOIN dwh_branch d2 ON d2.`BRANCH` = u.mainbr_imp 
							
							 ";
	
	if ($branch_code <> "") {
		$criteria .= " WHERE u.mainbr LIKE ? OR u.mainbr_imp LIKE ? OR ISNULL(u.`mainbr`) ";;
	}
	
	$select_prep .= $criteria;
	
	
	$select_prep .= " ORDER BY u.mainbr,u.mainbr_imp,tid,mid,keterangan ";
	
	$select_stmt = $mysqli->prepare($select_prep);

	// TEST ONLY ECHO QUERY
	//echo $select_prep;
	//TEST ONLY
	if ($select_stmt) {
		if ($criteria <> "") {
			$select_stmt->bind_param('ss', $branch_code,$branch_code);
												
		}
											
			$select_stmt->execute();
			$select_stmt->store_result();
	}

	return $select_stmt;
}


function getEDCBrilinkVerifikasi($mysqli,$criteria,$txtSearchSQL){
	$branch_code = "";

	if (!empty($_SESSION['user_branch_code'])){
		$branch_code = $_SESSION['user_branch_code'];
	}

	$select_prep = " SELECT
  `MID`,
  `TID`,
  `NAMA MERCHANT`,
  `KODE UKER PEMRAKARSA`,
  `UKER PEMRAKARSA`,
  `uker_implementor`,
  `UKER IMPLEMENTOR`,
  u.`mainbr`,
d1.`BRDESC`,
u.`mainbr_imp`,
d2.`BRDESC`,
keterangan
FROM m_edc_brilink_verif u
LEFT JOIN dwh_branch d1 ON d1.`BRANCH` = u.mainbr
LEFT JOIN dwh_branch d2 ON d2.`BRANCH` = u.mainbr_imp
				
							 ";

	if ($branch_code <> "") {
		$criteria .= " WHERE u.mainbr LIKE ? OR u.mainbr_imp LIKE ? OR ISNULL(u.`mainbr`) ";;
	}

	$select_prep .= $criteria;


	$select_prep .= " ORDER BY u.mainbr,u.mainbr_imp,tid,mid,keterangan ";

	$select_stmt = $mysqli->prepare($select_prep);

	// TEST ONLY ECHO QUERY
	echo $select_prep;
	//TEST ONLY
	if ($select_stmt) {
		if ($criteria <> "") {
			$select_stmt->bind_param('ss', $branch_code,$branch_code);

		}
			
		$select_stmt->execute();
		$select_stmt->store_result();
	}

	return $select_stmt;
}

function getEDCMerchantVerifikasi($mysqli,$criteria,$txtSearchSQL){
	$branch_code = "";

	if (!empty($_SESSION['user_branch_code'])){
		$branch_code = $_SESSION['user_branch_code'];
	}

	$select_prep = " SELECT
					  `MID`,
					  `TID`,
					  `NAMA MERCHANT`,
					  `KODE UKER`,
					  `NAMA CABANG`,
					   u.`mainbr`,
						d1.`BRDESC`,
						u.`mainbr_imp`,
						d2.`BRDESC`,
						keterangan
					FROM `m_edc_merchant_verif` u
					LEFT JOIN dwh_branch d1 ON d1.`BRANCH` = u.mainbr
					LEFT JOIN dwh_branch d2 ON d2.`BRANCH` = u.mainbr_imp

							 ";

	if ($branch_code <> "") {
		$criteria .= " WHERE u.mainbr LIKE ? OR ISNULL(u.`mainbr`) ";;
	}

	$select_prep .= $criteria;


	$select_prep .= " ORDER BY u.mainbr,tid,mid,keterangan ";

	$select_stmt = $mysqli->prepare($select_prep);

	// TEST ONLY ECHO QUERY
	echo $select_prep;
	//TEST ONLY
	if ($select_stmt) {
		if ($criteria <> "") {
			$select_stmt->bind_param('s', $branch_code);

		}
			
		$select_stmt->execute();
		$select_stmt->store_result();
	}

	return $select_stmt;
}
?>
