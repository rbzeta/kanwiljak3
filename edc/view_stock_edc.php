<?php 

$isUker = 0;
if (!empty($_SESSION['user_pn'])) {
	$logged = "in";
	if ($_SESSION['user_uker']) {
			$isUker = 1;
	}
}

?>
<head>

<style type="text/css">

</style>

<script type="text/javascript">

</script>
</head>
<?php 
$stockedc_id=
$stockedc_jumlah=
$stockedc_tipe=
$stockedc_origin=
$stockedc_creadt=
$stockedc_creausr=
$stockedc_upddt=
$stockedc_updusr="";


$rNum=1;

$mysqli = getConnection();

//unset var before reusing
unset($select_prep,$select_stmt);

$select_prep = " SELECT DISTINCT masteratm_id, masteratm_branch_code,branch_name,masteratm_tid,masteratm_lokasi,masteratm_isonsite,masteratm_tipe,
					CASE
					 WHEN ISNULL((SELECT atm_brand_sname 
						FROM m_atm_activitylog 
						LEFT JOIN m_atm_brand ON atm_brand_id = atm_act_brand_id 
						WHERE  atm_act_tid = masteratm_tid	
						LIMIT 1)) THEN masteratm_merk
						ELSE (SELECT atm_brand_sname 
						FROM m_atm_activitylog 
						LEFT JOIN m_atm_brand ON atm_brand_id = atm_act_brand_id 
						WHERE  atm_act_tid = masteratm_tid	
						LIMIT 1)
					END AS masteratm_merk
					FROM m_master_atm
					LEFT JOIN m_branch ON branch_code = masteratm_branch_code
					WHERE masteratm_branch_mbcode = ?
					ORDER BY masteratm_branch_code ASC ";

$select_stmt = $mysqli->prepare($select_prep);

if ($select_stmt) {
	
	$select_stmt->bind_param('s', $getBranchCode);
	$select_stmt->execute();
	$select_stmt->store_result();
	
}
?>
<body>
<form action="../edc/dashboard_edc.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch">
<div class="right">

</div>
</form>
</body>
</html>
