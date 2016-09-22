<?php 
require '../helper/validateHelper.php';
require '../helper/functionHelper.php';
require '../config/DBConnect.php';
require '../helper/excel_adapter.php';

sec_session_start();

$logged = "";

if (login_check(getConnection()) == true) {
	$logged = 'in';
	$isUker = 0;
	$isAdmin = 0;
		if ($_SESSION['user_uker']) {
			$isUker = 1;
		}
		if ($_SESSION['user_level_id'] == 99)
		{
			$isAdmin = 1;
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

function openATMDetilByUker(branch_code,branch_name){
	
	window.location.href="/kanwiljak3/global/global_dashboard_atm.php?tipe=uker&branch="+branch_code+"&branch_name="+branch_name;
}
</script>
</head>
<?php 
$branch_code=
$branch_name=
$jumlah_atm=
$atm_onsite=
$atm_offsite=
$msg="";

$rNum=1;

$total_atm=$total_onsite=$total_offsite=0;

$mysqli = getConnection();

//unset var before reusing
unset($select_prep,$select_stmt);

$select_prep = "SELECT DISTINCT masteratm_branch_mbcode AS branch_code,branch_name,COUNT(masteratm_tid) AS jumlah_atm,
				SUM(masteratm_isonsite) AS atm_onsite,(COUNT(masteratm_tid) - SUM(masteratm_isonsite)) AS atm_offsite
				FROM m_master_atm
				LEFT JOIN m_branch ON branch_code = masteratm_branch_mbcode
				WHERE masteratm_isactive = 1
				GROUP BY masteratm_branch_mbcode
				ORDER BY masteratm_branch_mbcode ASC ";

$select_stmt = $mysqli->prepare($select_prep);

if ($select_stmt) {
		
	$select_stmt->execute();
	$select_stmt->store_result();
	
}
?>
<body style="margin-top: 0px;margin-left: 0px;margin-right: 0px">
<div class="container">
	<div id="header">
<?php 
include 'header.php';
?>
	</div>
</div> 
<table >
	<tr>
		<td style="padding-left: 30px;padding-right: 30px">
			<div>
			<p style="font-family:monospace;font-weight: bolder;text-align: center; ">DAFTAR ATM KANWIL JAKARTA 3</p>
				<table class="tg" >
				  <tr>
				    <th class="tg-b286" style="text-align: center">No.</th>
				    <th class="tg-b286" style="text-align: right">Kode Uker</th>
				    <th class="tg-b286" style="text-align: left">Nama Uker</th>
				    <th class="tg-b286" style="text-align: right">Onsite</th>
				    <th class="tg-b286" style="text-align: right">Offsite</th>
				    <th class="tg-b286" style="text-align: right">Jumlah ATM/CDM</th>
				  </tr>
				  <?php 
				  if ($select_stmt->num_rows >= 1) {
				  
				  	$select_stmt->bind_result($branch_code,
												$branch_name,
												$jumlah_atm,
												$atm_onsite,
												$atm_offsite);
				  	while ($select_stmt->fetch()){
						
						$total_atm += $jumlah_atm;
						$total_onsite += $atm_onsite;
						$total_offsite += $atm_offsite;
				
						$msg="";
				  		$msg .= '<tr>
								    <td class="tg-031e" style="text-align: right">'.$rNum.'</td>
								    <td class="tg-031e" style="text-align: right">'.$branch_code.'</td>
								    <td class="tg-031e" style="text-align: left">
										<a style="font-family:Arial, sans-serif;font-size:11px;" 
												href="javascript:openATMDetilByUker('.$branch_code.',&#96'.$branch_name.'&#96);" >'.$branch_name.'</a>
									</td>
								    <td class="tg-031e" style="text-align: right">'.$atm_onsite.'</td>
								    <td class="tg-031e" style="text-align: right">'.$atm_offsite.'</td>
								    <td class="tg-031e" style="text-align: right">'.$jumlah_atm.'</td>
								  </tr>';
				  			
				  		$rNum += 1;
				  		
				  		echo $msg;
				  	}
				  }
				  
				  ?>
				  <tr>
				    <td class="tg-xodn">Total</td>
				    <td class="tg-xodn"></td>
				    <td class="tg-xodn"></td>
				    <td class="tg-xodn" style="text-align: right"><?php echo number_format($total_onsite) ?></td>
				    <td class="tg-xodn" style="text-align: right"><?php echo number_format($total_offsite) ?></td>
				    <td class="tg-xodn" style="text-align: right"><?php echo number_format($total_atm) ?></td>
				  </tr>
				</table>
			</div>
		</td>
		
		<td style="padding-left: 30px;padding-right: 30px;position: absolute;">
			<table >
			<tr>
				<td align="center" colspan="4"><code>Download Firefox terbaru di 
				<a				class="underline"
								href="../files/Firefox_Setup_36.0.1.exe">sini</a> untuk tampilan terbaik
				
				</code></td>
			</tr>
			
			<tr>
				<td align="center"><a href="/kanwiljak3/edc/dashboard_edc.php"><img src="../resource/edc2.png" alt="Portal EDC BRI KW Jakarta 3" style="width:150px;height:150px"></img></a></td>
				<td align="center"><a href="/kanwiljak3/atm/dashboard_atm.php"><img src="../resource/images.jpg" alt="Portal ATM BRI KW Jakarta 3" style="width:150px;height:150px"></img></a></td>
				<td align="center"><a href="/kanwiljak3/uko/dashboard_uko.php"><img src="../resource/uko_logo_fix.jpg" alt="Portal UKO BRI KW Jakarta 3" style="width:150px;height:150px"></img></a></td>
				<?php 
				if($logged == "in"){
				if (!$isUker) {
					echo '<td align="center"><a href="/kanwiljak3/monbin/popup_token_monbin.php"><img src="../resource/monbin_tsi_logo_fix.jpg" alt="Portal UKO BRI KW Jakarta 3" style="width:150px;height:150px"></img></a></td>';
				}
				}?>
				
			</tr>
			<tr>
				<td align="center"><strong style="color: #0000ff; font-size: 14px;">Portal EDC</strong></td>
				<td align="center"><strong style="color: #0000ff; font-size: 14px;">Portal ATM</strong></td>
				<td align="center"><strong style="color: #0000ff; font-size: 14px;">Portal Unit Kerja</strong></td>
				<?php 
				if($logged == "in"){
				if (!$isUker) {
					echo '<td align="center"><strong style="color: #0000ff; font-size: 14px;">Monbin TSI</strong></td>';
				}
				}?>
			</tr>
			<?php 
				if($logged == "in"){
				if ($isAdmin) {
			echo '<tr>
				<td colspan="4" align="center"><a href="/kanwiljak3/admin/dashboard_admin.php"><img src="../resource/admin_icon.jpg" alt="Portal EDC BRI KW Jakarta 3" style="width:150px;height:150px"></img></a></td>
				</tr>
				<tr>
				<td colspan="4" align="center"><strong style="color: #0000ff; font-size: 14px;">Administrator</strong></td>
				</tr>';
			
				}
				}
			?>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
