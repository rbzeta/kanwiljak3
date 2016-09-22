<html>
<head>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.tabs.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.jqChart.css" />
<link rel="stylesheet" type="text/css" href="../css/jquery.jqRangeSlider.css" />
<script src="../js/jquery.mousewheel.js" type="text/javascript"></script>
<script src="../js/jquery.jqChart.min.js" type="text/javascript"></script>
<script src="../js/jquery.jqRangeSlider.min.js" type="text/javascript"></script>
<style type="text/css">
#tabs {
	border: 0px !important;
}

.ui-tabs .ui-tabs-panel {
	padding: 0px !important;
}

.ui-widget-header {
	background: #ffffff !important;
	border: 0px !important;
	border-bottom: 1px solid #aaaaaa !important;
	border-radius: 0px;
}

.ui-tabs .ui-tabs-nav li {
	font-size: 13px;
	border-radius: 2px;
}

table tr td .list_left {
	background-color:#F5F4E5; 
	font-weight:bold; 
	padding-left:5px; 
	vertical-align: top;
	width:150px;
}

table tr td .list_right {
	border-bottom:1px #DDDDDD solid;
}


</style>

<script type="text/javascript">
$(function() {
	$( "#tabs" ).tabs({
		selected:0	});
});

</script>
</head>
<body>
<?php 
$edcbrilink_id=$edcbrilink_tid=$edcbrilink_mid=$edcbrilink_tipe=$edcbrilink_kodekanca=$edcbrilink_kodeunit=$edcbrilink_brand=
$edcbrilink_sn=$edcbrilink_simcard=$edcbrilink_agen=$edcbrilink_alamatrumah=$edcbrilink_alamatusaha=$edcbrilink_nohp=$edcbrilink_jenisusaha=
$edcbrilink_jarak=$edcbrilink_norekkupedes=$edcbrilink_noreksimpedes=$edcbrilink_plafon=$edcbrilink_bakidebet=$edcbrilink_saldosimpanan=
$edcbrilink_lamadebitur=$edcbrilink_lamanasabah=$edcbrilink_alasan=$edcbrilink_provider=$edcbrilink_tglimplementasi=$edcbrilink_tglinit=$tid=
$edcbrand_id=$edcbrand_nama=$branch_mbcode=$branch_mbname=$branch_code=$branch_name=$edcsp_no=$edcbrilink_pic=$edcbrilink_pic_notelp="";

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}
//echo $tid;

$mysqli = getConnection();

$select_prep = "SELECT edcbrilink_id,edcbrilink_tid,edcbrilink_mid,edcbrilink_tipe,edcbrilink_kodekanca,edcbrilink_kodeunit,edcbrilink_brand,
				edcbrilink_sn,edcbrilink_simcard,edcbrilink_agen,edcbrilink_alamatrumah,edcbrilink_alamatusaha,edcbrilink_nohp,edcbrilink_jenisusaha,
				edcbrilink_jarak,edcbrilink_norekkupedes,edcbrilink_noreksimpedes,edcbrilink_plafon,edcbrilink_bakidebet,edcbrilink_saldosimpanan,
				edcbrilink_lamadebitur,edcbrilink_lamanasabah,edcbrilink_alasan,edcbrilink_provider,edcbrilink_tglimplementasi,edcbrilink_tglinit,
				edcbrand_id,edcbrand_nama,branch_mbcode,branch_mbname,branch_code,branch_name,edcbrilink_pic,edcbrilink_pic_notelp
				FROM m_edc_brilink
				LEFT JOIN m_edc_brand ON edcbrand_id = edcbrilink_brand
				LEFT JOIN m_branch ON branch_code = edcbrilink_kodeunit 
			    WHERE edcbrilink_tid = ? AND edcbrilink_isactive = 1 LIMIT 1 ";

$select_stmt = $mysqli->prepare($select_prep);
// TEST ONLY ECHO QUERY
//echo $select_prep.$tid;
//TEST ONLY
if ($select_stmt) {

	$select_stmt->bind_param('s', $tid);		
	$select_stmt->execute();
	$select_stmt->store_result();
}

if ($select_stmt->num_rows >= 1) {

	$select_stmt->bind_result($edcbrilink_id,$edcbrilink_tid,$edcbrilink_mid,$edcbrilink_tipe,$edcbrilink_kodekanca,$edcbrilink_kodeunit,$edcbrilink_brand,
				$edcbrilink_sn,$edcbrilink_simcard,$edcbrilink_agen,$edcbrilink_alamatrumah,$edcbrilink_alamatusaha,$edcbrilink_nohp,$edcbrilink_jenisusaha,
				$edcbrilink_jarak,$edcbrilink_norekkupedes,$edcbrilink_noreksimpedes,$edcbrilink_plafon,$edcbrilink_bakidebet,$edcbrilink_saldosimpanan,
				$edcbrilink_lamadebitur,$edcbrilink_lamanasabah,$edcbrilink_alasan,$edcbrilink_provider,$edcbrilink_tglimplementasi,$edcbrilink_tglinit,
				$edcbrand_id,$edcbrand_nama,$branch_mbcode,$branch_mbname,$branch_code,$branch_name,$edcbrilink_pic,$edcbrilink_pic_notelp);
	
	$select_stmt->fetch();
}
?>
<div class="right">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="3">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td align="center" valign="middle"><h3 style="margin-top:0px;"><b><?php echo $edcbrilink_agen?></b></h3></td>
          </tr>
        </table>
    </td>
  </tr>
  
  <tr>
    <td valign="top">
	<table width="100%"  border="0" cellpadding="00">
      <tr>
        <td align="center" valign="top">
			<div id="tabs">
				<ul>
					<li><a href="#tabs-1" style="font-size:12px;"><b>Profile</b></a></li>
					<li><a href="#tabs-2" style="font-size:12px;"><b>Transaksi</b></a></li>
					<li><a href="#tabs-3" style="font-size:12px;"><b>Complaint</b></a></li>
					<li><a href="#tabs-4" style="font-size:12px;"><b>Maintenance</b></a></li>
					<li><a href="#tabs-5" style="font-size:12px;"><b>Penarikan</b></a></li>
				</ul>
<div id="tabs-1">

<table width="100%" style="font: 11px/20px normal Helvetica, Arial, sans-serif !important; margin:10px 0 0 0;">
	<tr>
		<td valign="top" width="50%">
			<table width="100%" border="0" cellpadding="1" cellspacing="2">
				<tr>
					<td class="list_left">TERMINAL ID</td>
					<td class="list_right">: <?php echo $edcbrilink_tid?></td>
				</tr>
				<tr>
					<td class="list_left">MERCHANT ID</td>
					<td class="list_right">: <?php echo $edcbrilink_mid?></td>
				</tr>
				<tr>
					<td class="list_left">UNIT KERJA</td>
					<td class="list_right">: <?php echo $branch_name?></td>
				</tr>
				<tr>
					<td class="list_left">NAMA AGEN</td>
					<td class="list_right">: <?php echo $edcbrilink_agen?></td>
				</tr>
				<tr>
					<td class="list_left">ALAMAT</td>
					<td class="list_right">: <?php echo $edcbrilink_alamatrumah?></td>
				</tr>
				<tr>
					<td class="list_left">TIPE</td>
					<td class="list_right">: <?php echo $edcbrilink_tipe?></td>
				</tr>
				<tr>
					<td class="list_left">NO REKENING</td>
					<td class="list_right">: <?php echo $edcbrilink_noreksimpedes?></td>
				</tr>
				<tr>
					<td class="list_left">TELP</td>
					<td class="list_right">: <?php echo $edcbrilink_nohp?></td>
				</tr>
			</table>
		</td>
		<td valign="top">
			<table width="100%" border="0" cellpadding="1" cellspacing="2">
				<tr>
					<td class="list_left">NO SP</td>
					<td class="list_right">: <?php echo $edcsp_no?></td>
				</tr>
				<tr>
					<td class="list_left">S/N MESIN</td>
					<td class="list_right">: <?php echo $edcbrilink_sn?></td>
				</tr>
				<tr>
					<td class="list_left">MERK</td>
					<td class="list_right">: <?php echo $edcbrand_nama?></td>
				</tr>
				<tr>
					<td class="list_left"> TGL IMPLEMENTASI</td>
					<td class="list_right">: <?php echo $edcbrilink_tglimplementasi?></td>
				</tr>
				<tr>
					<td class="list_left">PROVIDER</td>
					<td class="list_right">: <?php echo $edcbrilink_provider?></td>
				</tr>
				<tr>
					<td class="list_left">S/N SIMCARD</td>
					<td class="list_right">: <?php echo $edcbrilink_simcard?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellpadding="1" cellspacing="2">
				<tr>
					<td class="list_left">KETERANGAN</td>
					<td class="list_right">: <?php echo $edcbrilink_alasan?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>
<!-- >div id="tabs-2">
					<table width="100%">
	<tr>
		<td>
			<link rel="stylesheet" type="text/css" href="http://2.131.177.53/edcmalang/../js-packages/jqchart/jquery.jqChart.css" />
			<link rel="stylesheet" type="text/css" href="http://2.131.177.53/edcmalang/../js-packages/jqchart/jquery.jqRangeSlider.css" />

			<script src="http://2.131.177.53/edcmalang/../js-packages/jqchart/jquery.mousewheel.js" type="text/javascript"></script>
			<script src="http://2.131.177.53/edcmalang/../js-packages/jqchart/jquery.jqChart.min.js" type="text/javascript"></script>
			<script src="http://2.131.177.53/edcmalang/../js-packages/jqchart/jquery.jqRangeSlider.min.js" type="text/javascript"></script>
			<!--[if IE]><script lang="javascript" type="text/javascript" src="http://2.131.177.53/edcmalang/../js-packages/jqchart/excanvas.js"></script><![endif]-->
						 <!-- >script lang="javascript" type="text/javascript">
				function addCommas(nStr) {
					nStr += '';
					x = nStr.split('.');
					x1 = x[0];
					x2 = x.length > 1 ? '.' + x[1] : '';
					var rgx = /(\d+)(\d{3})/;

					while (rgx.test(x1)) {
						x1 = x1.replace(rgx, '$1' + '.' + '$2');
					}

					return x1 + x2;
				}

				$(document).ready(function () {
					$('#jqChart_2').bind('axisLabelCreating', function (event, data) {
						if (data.context.axis.location == 'left') {
							data.text = addCommas(data.text);
						}
					});
					
					$('#jqChart_2').bind('tooltipFormat', function (e, data) {
						return 'Rp ' + addCommas(data.y);
					});
					
					$('#jqChart_3').bind('tooltipFormat', function (e, data) {
						return 'Rp ' + addCommas(data.y);
					});

					$('#jqChart').jqChart({
						title: { text: "HISTORY TRANSAKSI EDC", font: '11px sens-serif' },
						border: { cornerRadius: 1, strokeStyle:"white" },
						legend: { visible: true, location: 'top', allowHideSeries: true, font: '11px sans-serif', 
							border:{ padding:2, strokeStyle:"white", cornerRadius:1 }
						},
						animation: { duration: 1 },
						shadows: {
							enabled: true
						},
						series: [
							{
								type: 'stackedColumn',
								title: 'Transaksi',
								data: 
								[
									['Jan',0],['Feb',0],['Mar',2],['Apr',15],['Mei',36],['Jun',11],['Jul',10],['Aug',12],['Sep',11],								],
								labels: {
									font: '11px sans-serif',
									fillStyle: 'white'
								}
							}
						]
					});
					
					$('#jqChart_3').jqChart({
						title: { text: "HISTORY SHARING FEE", font: '11px sens-serif' },
						border: { cornerRadius: 1, strokeStyle:"white" },
						legend: { visible: true, location: 'top', allowHideSeries: true, font: '11px sans-serif', 
							border:{ padding:2, strokeStyle:"white", cornerRadius:1 }
						},
						animation: { duration: 1 },
						shadows: {
							enabled: true
						},
						series: [
							{
								type: 'area',
								title: 'Sharing Fee',
								data: 
								[
									['Jan',0],['Feb',0],['Mar',1350],['Apr',10125],['Mei',22050],['Jun',6300],['Jul',7200],['Aug',7200],['Sep',5400],								],
								labels: {
									font: '11px sans-serif',
									fillStyle: '#000000'
								}
							}
						]
					});
				});
			</script>
			<div id="jqChart"></div>
		</td>
		<td>
			<div class="widget-content">
				<script type="text/javascript">
					$(document).ready(function () {
						$('#jqChart_2').jqChart({
							title: { text:"HISTORY NOMINAL EDC", font: '11px sens-serif' },
							border: { cornerRadius: 1, strokeStyle:"white" },
							legend: { visible: true, location: 'top', allowHideSeries: true, font: '11px sans-serif', 
								border:{ padding:2, strokeStyle:"white", cornerRadius:1 }
							},
							animation: { duration:1 },
							series: [
										{
											title: 'Nominal',
											type: 'line',
											data: [
											['Jan',0],['Feb',0],['Mar',7700000],['Apr',169946057],['Mei',113349300],['Jun',29267100],['Jul',18740634],['Aug',311264947],['Sep',20060000],											]
										}
									]
						});
					});
				</script>
				<div id="jqChart_2"></div>
			</div>
		</td>
	</tr>
</table>

<table width="100%" border="0" cellpadding="1" cellspacing="5" class="prLBL3" style="font: 11px/20px normal Helvetica, Arial, sans-serif !important;">
	<tr>
		<td width="53%">
			<table width="100%">
				<tr>
					<td align="left">
						<p style="font-weight:bold; font-size:10px; line-height:16px; margin:0px;">
							<i>* click bulan untuk melihat rincian transaksi harian di bulan tersebut</i>
						</p>
					</td>
				</tr>
			</table>
			<table width="100%"  border="1" cellpadding="1" cellspacing="0" class="prLBL3" style="font: 11px/20px normal Helvetica, Arial, sans-serif !important;">
				<tr align="center" valign="middle" style="background-color: #73AAE5; font-weight: bold; color:#ffffff;">
					<td width="80">BULAN</td>
					<td width="100">TRX SUKSES</td>
					<td>NOMINAL</td>
					<td width="100">SHARING FEE</td>
				</tr>
								<tr>
					<td align="left" style="padding-left:7px;">
						<a href="http://2.131.177.53/edcmalang/index.php/report_brilink/report_edc_detail_by_tid/21345702/1">
							Januari						</a>
					</td>
					<td align="right" style="padding-right:7px;">0</td>
					<td align="right" style="padding-right:7px;">0</td>
					<td align="right" style="padding-right:7px;">0</td>
				</tr>
								<tr>
					<td align="left" style="padding-left:7px;">
						<a href="http://2.131.177.53/edcmalang/index.php/report_brilink/report_edc_detail_by_tid/21345702/2">
							Februari						</a>
					</td>
					<td align="right" style="padding-right:7px;">0</td>
					<td align="right" style="padding-right:7px;">0</td>
					<td align="right" style="padding-right:7px;">0</td>
				</tr>
								<tr>
					<td align="left" style="padding-left:7px;">
						<a href="http://2.131.177.53/edcmalang/index.php/report_brilink/report_edc_detail_by_tid/21345702/3">
							Maret						</a>
					</td>
					<td align="right" style="padding-right:7px;">2</td>
					<td align="right" style="padding-right:7px;">7,700,000</td>
					<td align="right" style="padding-right:7px;">1,350</td>
				</tr>
								<tr>
					<td align="left" style="padding-left:7px;">
						<a href="http://2.131.177.53/edcmalang/index.php/report_brilink/report_edc_detail_by_tid/21345702/4">
							April						</a>
					</td>
					<td align="right" style="padding-right:7px;">15</td>
					<td align="right" style="padding-right:7px;">169,946,057</td>
					<td align="right" style="padding-right:7px;">10,125</td>
				</tr>
								<tr>
					<td align="left" style="padding-left:7px;">
						<a href="http://2.131.177.53/edcmalang/index.php/report_brilink/report_edc_detail_by_tid/21345702/5">
							Mei						</a>
					</td>
					<td align="right" style="padding-right:7px;">36</td>
					<td align="right" style="padding-right:7px;">113,349,300</td>
					<td align="right" style="padding-right:7px;">22,050</td>
				</tr>
								<tr>
					<td align="left" style="padding-left:7px;">
						<a href="http://2.131.177.53/edcmalang/index.php/report_brilink/report_edc_detail_by_tid/21345702/6">
							Juni						</a>
					</td>
					<td align="right" style="padding-right:7px;">11</td>
					<td align="right" style="padding-right:7px;">29,267,100</td>
					<td align="right" style="padding-right:7px;">6,300</td>
				</tr>
								<tr>
					<td align="left" style="padding-left:7px;">
						<a href="http://2.131.177.53/edcmalang/index.php/report_brilink/report_edc_detail_by_tid/21345702/7">
							Juli						</a>
					</td>
					<td align="right" style="padding-right:7px;">10</td>
					<td align="right" style="padding-right:7px;">18,740,634</td>
					<td align="right" style="padding-right:7px;">7,200</td>
				</tr>
								<tr>
					<td align="left" style="padding-left:7px;">
						<a href="http://2.131.177.53/edcmalang/index.php/report_brilink/report_edc_detail_by_tid/21345702/8">
							Agustus						</a>
					</td>
					<td align="right" style="padding-right:7px;">12</td>
					<td align="right" style="padding-right:7px;">311,264,947</td>
					<td align="right" style="padding-right:7px;">7,200</td>
				</tr>
								<tr>
					<td align="left" style="padding-left:7px;">
						<a href="http://2.131.177.53/edcmalang/index.php/report_brilink/report_edc_detail_by_tid/21345702/9">
							September						</a>
					</td>
					<td align="right" style="padding-right:7px;">11</td>
					<td align="right" style="padding-right:7px;">20,060,000</td>
					<td align="right" style="padding-right:7px;">5,400</td>
				</tr>
							</table>
		</td>
		<td>
			<div id="jqChart_3"></div>
		</td>
	</tr>
</table>
<div align="left">
	<p style="font-size:11px; margin:0px;">Untuk transaksi <b>PLN Prepaid dan Postpaid</b> nominal sebenarnya adalah ditambahkan 2 digit "0" di belakang</p>
</div>

				</div-->
				
				
				<div id="tabs-3">
					<?php include 'report_detil_complaint_tid.php';?>
				</div>
				
				<div id="tabs-4">
						<table width="100%"  border="0" cellpadding="1" cellspacing="0" class="prLBL3" style="margin:10px 0; font: 11px/20px normal Helvetica, Arial, sans-serif !important;">
		<tr>
			<td align="center">- Tidak ada data -</td>
		</tr>
	</table>
				</div>
				<div id="tabs-5">
						<table width="100%"  border="0" cellpadding="1" cellspacing="0" class="prLBL3" style="margin:10px 0; font: 11px/20px normal Helvetica, Arial, sans-serif !important;">
		<tr>
			<td align="center">- Tidak ada data -</td>
		</tr>
	</table>
				</div>
			</div>
        </td>
        <td align="right" valign="top">&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
</table>
</div>
</body>
</html>