<?php 
$tid=$edc_tipe="";

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}

$mysqli = getConnection();

$select_prep = " SELECT IF(EXISTS(SELECT edcmerchant_id FROM m_edc_merchant WHERE edcmerchant_tid = $tid),
										('Merchant'),
										(IF(EXISTS(SELECT edcbrilink_id FROM m_edc_brilink WHERE edcbrilink_tid = $tid),
										('Brilink'),
										('Uko')))) AS edc_tipe ";

$select_stmt = $mysqli->prepare($select_prep);
// TEST ONLY ECHO QUERY
//echo $select_prep.$tid;
//TEST ONLY
if ($select_stmt) {

	$select_stmt->execute();
	$select_stmt->store_result();
}

if ($select_stmt->num_rows >= 1) {

	$select_stmt->bind_result($edc_tipe);
	
	$select_stmt->fetch();
	
	switch ($edc_tipe) {
		case 'Merchant':
			include 'report_detil_merchant_tid.php';
			break;
		case 'Brilink':
			include 'report_detil_brilink_tid.php';
			break;
		case 'Uko':
			include 'report_detil_uko_tid.php';
			break;
		default:
			include 'default_edc.php';;
		break;
	}
}
?>