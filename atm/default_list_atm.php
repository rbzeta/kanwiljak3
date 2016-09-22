<?php 

$logged = "";

if (login_check(getConnection()) == true) {
	$logged = 'in';
	$isUker = 0;
	$session_user_branchcode = 0;
	$session_user_branchname = "";
	
		if ($_SESSION['user_uker']) {
			$isUker = 1;
		}
		
		if ($_SESSION['user_branch_code'] <> 0) {
			$session_user_branchcode = $_SESSION['user_branch_code'];
			$session_user_branchname = $_SESSION['user_branch_name'];
		}
	
	
	
} else {
	$logged = 'out';
	sec_session_destroy();
}


?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portal BRI Kanwil Jakarta 3</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portal BRI Kanwil Jakarta 3</title>
<script type="text/javascript" src="../css/jquery-1.6.4.min.js"></script>
<script src="../js/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="../css/utils.js"></script>
<script type="text/JavaScript" src="../js/forms.js"></script>
<style type="text/css">@import "../css/menu.css";</style>
<style type="text/css">@import "../css/table.css";</style>
<link rel="stylesheet" href="../js/jquery-ui-1.8.13/themes/base/jquery.ui.all.css"></link>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/jquery-1.5.1.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.accordion.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.datepicker.js"></script>

<style type="text/css">

</style>

<script type="text/javascript">

function openATMDetilByUker(branch_code){
	
	window.location.href="/kanwiljak3/global/dashboard_atm.php?tipe=uker&branch="+branch_code;
}

function updateAction(recId){
	var p = document.createElement("input");
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
    form =document.getElementById('frmSearch');
    form.appendChild(p);
    p.name = "tid";
    p.type = "hidden";
    p.value = recId;
    
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "update_master_atm";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
	
}

function deleteAction(recId){
	if(confirm('Anda yakin ingin menghapus data ?')){
		var p = document.createElement("input");
		var action = document.createElement("input");
		var actionType = document.createElement("input");
		 
	    // Add the new element to our form. 
	    form =document.getElementById('frmSearch');
	    form.appendChild(p);
	    p.name = "tid";
	    p.type = "hidden";
	    p.value = recId;
	    
	    form.appendChild(action);
	    action.name = "action";
	    action.type = "hidden";
	    action.value = "view_master_atm";
	
	    form.appendChild(actionType);
	    actionType.name = "deleteaction";
	    actionType.type = "hidden";
	    actionType.value = "view_master_atm_delete";
	    //alert(saveaction.value);
	    // Finally submit the form. 
	    form.submit();
		//document.getElementById('frmSearch').submit();
	}
}
</script>
</head>
<?php 
$masteratm_id=
$masteratm_branch_code=
$branch_name=
$masteratm_tid=
$masteratm_lokasi=
$masteratm_isonsite=
$masteratm_tipe=
$masteratm_merk=
//start add atm attribute
$masteratm_attr_cover=
$masteratm_attr_it=
$masteratm_attr_ups=
$masteratm_attr_cctv=
//end
$getBranchName=
$msg="";

$rNum=1;
$getBranchCode=0;

if(!empty($_GET['branch'])){
	$getBranchCode = $_GET['branch'];
}else{
	$getBranchCode = $session_user_branchcode;
}

if(!empty($_GET['branch_name'])){
	$getBranchName = $_GET['branch_name'];
}else{
	$getBranchName = $session_user_branchname;
}

$tid = "";
if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}

$mysqli = getConnection();

if (!empty($_POST["deleteaction"])){

	$delete_prep = "UPDATE m_master_atm SET masteratm_isactive = 0 WHERE masteratm_id = ? ";
	$delete_stmt = $mysqli->prepare($delete_prep);

	if ($delete_stmt) {
		$delete_stmt->bind_param('i', $tid);
		// Execute the prepared query.
		if (! $delete_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menghapus data.');
				  </script>";
		}else echo "<script type='text/javascript'>
					alert('Data berhasil dihapus.');
				  </script>";
	}else {
		echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menghapus data.');
				  </script>";

	}
}
//$mysqli = getConnection();

//unset var before reusing
unset($select_prep,$select_stmt);

$select_prep = " SELECT DISTINCT masteratm_id, masteratm_branch_code,branch_name,masteratm_tid,masteratm_lokasi,masteratm_isonsite,atmtipe_name,
					CASE 
					WHEN ISNULL(masteratm_brand_id) THEN masteratm_merk
					ELSE (SELECT atm_brand_sname 
						FROM m_atm_brand 
						WHERE atm_brand_id = masteratm_brand_id
						LIMIT 1)
					END AS masteratm_merk
		/* start add atm attribute */
		,a.atmattribut_name AS masteratm_attr_cover,
		b.atmattribut_name AS masteratm_attr_it,
		c.atmattribut_name AS masteratm_attr_ups,
		d.atmattribut_name AS masteratm_attr_cctv
		/*end*/
					FROM m_master_atm
					LEFT JOIN m_branch ON branch_code = masteratm_branch_code
					LEFT JOIN m_atm_tipe ON atmtipe_id = masteratm_tipe
					LEFT JOIN m_status_atm_attribut a ON a.atmattribut_id = masteratm_attr_cover
					LEFT JOIN m_status_atm_attribut b ON b.atmattribut_id = masteratm_attr_it
					LEFT JOIN m_status_atm_attribut c ON c.atmattribut_id = masteratm_attr_ups
					LEFT JOIN m_status_atm_attribut d ON d.atmattribut_id = masteratm_attr_cctv
					WHERE masteratm_branch_mbcode = ? AND masteratm_isactive = 1
					ORDER BY masteratm_branch_code ASC ";

$select_stmt = $mysqli->prepare($select_prep);

if ($select_stmt) {
	
	$select_stmt->bind_param('s', $getBranchCode);
	$select_stmt->execute();
	$select_stmt->store_result();
	
}
?>
<body style="margin-top: 0px;margin-left: 0px;margin-right: 0px">
<form action="../atm/dashboard_atm.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch"> 
<div class="right">
<table >
	<tr>
		<td style="padding-left: 30px;padding-right: 30px">
			<div>
			<p style="font-family:monospace;font-weight: bolder;text-align: left; "></p>
			<table class="tg">
			<tr>
			<th class="tg-b286" style="text-align: left" colspan="2">General Info</th>
			</tr>
			<tr>
			<td class="tg-031e" style="text-align: left;font-size: 12;font-weight:bold;padding-left: 10px;padding-right: 20px">Area/Cabang</td>
			<td class="tg-031e" style="text-align: right;font-size: 12;font-weight:bold;padding-left: 20px;padding-right: 10px"><?php echo $getBranchCode ?></td>
			</tr>
			<tr>
			<td class="tg-031e" style="text-align: left;font-size: 12;font-weight:bold;padding-left: 10px;padding-right: 20px">Lokasi</td>
			<td class="tg-031e" style="text-align: right;font-size: 12;font-weight:bold;padding-left: 20px;padding-right: 10px"><?php echo $getBranchName ?></td>
			</tr>
			</table>
			<p style="font-family:monospace;font-weight: bolder;text-align: left; "></p>
			<hr>
				<table class="tg" >
				  <tr>
				    <th class="tg-b286" style="text-align: center">No.</th>
				    <?php 
              			$strAction = "";
              			if ($logged == "in") {
              				$strAction .= '<th class="tg-b286" style="text-align: right">Edit</th>';
              				echo $strAction;
              				
              			}
              			?>
				    <th class="tg-b286" style="text-align: right">Kode Uker</th>
				    <th class="tg-b286" style="text-align: left">Nama Uker</th>
				    <th class="tg-b286" style="text-align: right">Tipe</th>
				    <th class="tg-b286" style="text-align: right">TID</th>
				    <th class="tg-b286" style="text-align: right">Lokasi</th>
				    <th class="tg-b286" style="text-align: right">Onsite</th>
				    <th class="tg-b286" style="text-align: right">Merk</th>
				    <th class="tg-b286" style="text-align: right">Cover</th>
				    <th class="tg-b286" style="text-align: right">IT</th>
				    <th class="tg-b286" style="text-align: right">UPS</th>
				    <th class="tg-b286" style="text-align: right">CCTV</th>
				    <th class="tg-b286" style="text-align: center">Ratas Trx</th>
				  </tr>
				  <?php 
				  if ($select_stmt->num_rows >= 1) {
				  
				  	$select_stmt->bind_result($masteratm_id,
												$masteratm_branch_code,
												$branch_name,
												$masteratm_tid,
												$masteratm_lokasi,
												$masteratm_isonsite,
												$masteratm_tipe,
												$masteratm_merk
												//start add atm attribute
												,$masteratm_attr_cover,
												$masteratm_attr_it,
												$masteratm_attr_ups,
												$masteratm_attr_cctv
												//end
												);
				  	while ($select_stmt->fetch()){

						$checkedImage = "";
						
						if ($masteratm_isonsite == 0) {
							$checkedImage.='<td class="tg-031e" style="text-align: center"><img src="../resource/unchecked.png" style="width:10px;height:10px"></img></td>';
						}else $checkedImage.='<td class="tg-031e" style="text-align: center"><img src="../resource/checked.jpg" style="width:10px;height:10px"></img></td>';
						
						$msg="";
						
						$strActionScript = "";
						if ($logged == "in") {
							$strActionScript .= '<td class="tg-031e" style="text-align: center">
													<a class="underline" href="javascript:updateAction('.$masteratm_id.');">
														<img src="../resource/pen.png" style="width:10px;height:10px;"></img></a>
													<a class="underline" href="javascript:deleteAction('.$masteratm_id.');">
														<img src="../resource/delete_icon.png" style="width:10px;height:10px"></img></a>
												</td>';
						}
						
				  		$msg .= '<tr>
								    <td class="tg-031e" style="text-align: right">'.$rNum.'</td>
									'.$strActionScript.'
								    <td class="tg-031e" style="text-align: right">'.$masteratm_branch_code.'</td>
									<td class="tg-031e" style="text-align: right">'.$branch_name.'</td>
									<td class="tg-031e" style="text-align: center">'.$masteratm_tipe.'</td>
								    <td class="tg-031e" style="text-align: right">
										<a style="font-family:Arial, sans-serif;font-size:11px;" 
												href="http://atmpro.bri.co.id/statusatm/viewatmdetail.pl?ATM_NUM='
										.$masteratm_tid.'" target="_blank">'.$masteratm_tid.'</a>
									</td>
									<td class="tg-031e" style="text-align: right">'.$masteratm_lokasi.'</td>
									'.$checkedImage.'		
								    <td class="tg-031e" style="text-align: left">'.$masteratm_merk.'</td>
					    			<td class="tg-031e" style="text-align: center">'.$masteratm_attr_cover.'</td>
									<td class="tg-031e" style="text-align: center">'.$masteratm_attr_it.'</td>
									<td class="tg-031e" style="text-align: center">'.$masteratm_attr_ups.'</td>
									<td class="tg-031e" style="text-align: center">'.$masteratm_attr_cctv.'</td>
									<td class="tg-031e" style="text-align: right">Coming Soon</td>
								  </tr>';
				  			
				  		$rNum += 1;
				  		
				  		echo $msg;
				  	}
				  }
				  
				  ?>
				</table>
			</div>
		</td>
	</tr>
</table>
<div align="right">
			<p
				style="font-weight: bold; margin-bottom: 0px; font-family: Consolas, Monaco, Courier New, Courier, monospace;">Electronic
				Payment Services</p>
			<hr />
			<img src="../resource/card_maestro.png" width="60" /> <img
				src="../resource/card_cirrus.png" width="60" /> <img
				src="../resource/card_link.png" width="60" /> <img
				src="../resource/card_visa.png" width="60" /> <img
				src="../resource/card_mastercard.jpg" width="60" />
		</div>
</div>
</form>
</body>
</html>
