<?php 
require '../config/DBConnect.php';
require '../helper/ATM_DBHelper.php';
include '../helper/excel_adapter.php';



if($_POST['logged'])
{
	$isUker = 0;
	$logged = $_POST['logged'];
	$userBranchId = 0;
	$userID = 0;
	if ($logged = "in") {
		
		$userBranchId = $_POST['userBranchIdVar'];
		$userID = $_POST['userIdVar'];
		$isUker = $_POST['isUkerVar'];;
		}
	
	
$page = $_POST['page'];

$txtsearch=$selectSearch="";

if ($_POST['txtsearch']) {
	$txtsearch = $_POST['txtsearch'];
}
if ($_POST['selectSearch']) {
	$selectSearch = $_POST['selectSearch'];
}


$criteria=$txtSearchSQL = "";
$count = 0;



if ($txtsearch <> "") {

	switch ($selectSearch) {
		case "atm_act_tid":
			$criteria .= " WHERE atm_act_tid LIKE ?  ";
			break;
		case "atm_brand_sname":
			$criteria .= " WHERE atm_brand_sname LIKE ?  ";
			break;
		case "atm_cro_name":
			$criteria .= " WHERE atm_cro_name LIKE ?  ";
			break;
		case "branch_name":
			$criteria .= " WHERE branch_name LIKE ?  ";
			break;
		case "status_name":
			$criteria .= " WHERE status_name LIKE ?  ";
			break;
		case "atm_act_loc":
			$criteria .= " WHERE atm_act_loc LIKE ?  ";
			break;				
		default:
			;
			break;
	}
	
	if ($logged == "in") {
		if ($isUker) {
			$criteria2 = " and atm_act_branch_id = ".$userBranchId;
		}else $criteria2 = " and atm_act_pmteamkw_id = ".$userID;
	
	}
	
	$txtSearchSQL = "%".$txtsearch."%";
}else {
	if ($logged == "in") {
		if ($isUker) {
			$criteria2 = " where atm_act_branch_id = ".$userBranchId;
			
		}else{
			$criteria2 = " where atm_act_pmteamkw_id = ".$userID;
			
		}
	}
}

$mysqli = getConnection();
unset($select_stmt,$select_count_stmt);

$select_stmt_excel = getATMMaintenanceExcel($mysqli, $criteria, $txtSearchSQL,$criteria2);

$ukerName = "Kanwil Jakarta 3";
if ($isUker) {
	$ukerName = $_POST['ukerNameVar'];
}

set_time_limit(0);
exportReportMaintenanceATM($select_stmt_excel,$ukerName);

$response = array(
		'success' => true,
		'url' => 'http://localhost/kanwiljak3/download/reportmaintainatm.xlsx'
);

header('Content-type: application/json');

// and in the end you respond back to javascript the file location
echo json_encode($response);


}

