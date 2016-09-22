<html>
<head>
</head>
<body>
<?php 
$edccomplaint_id=$status_name=$branch_name=$tid=
$edccomplaint_tid=
$edccomplaint_pic=
$edccomplaint_keterangan=
$edccomplaint_kodeuker=
$edccomplaint_status=
$edccomplaint_creadt=
$edccomplaint_lokasi=
$edccomplaint_tindakan="";
$msg = "";

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}

$mysqli = getConnection();

$complaint_prep = "SELECT
						  edccomplaint_id,status_name,branch_name,
						  edccomplaint_tid,
						  edccomplaint_pic,
						  edccomplaint_keterangan,
						  edccomplaint_kodeuker,
						  edccomplaint_status,
						  edccomplaint_creadt,
						  edccomplaint_lokasi,
						  edccomplaint_tindakan
						FROM m_edc_complaint
						LEFT JOIN m_status ON status_id = edccomplaint_status
						LEFT JOIN m_branch ON branch_id = edccomplaint_kodeuker
						WHERE edccomplaint_tid = ? ORDER BY edccomplaint_creadt DESC ";

$complaint_stmt = $mysqli->prepare($complaint_prep);
// TEST ONLY ECHO QUERY
// echo $complaint_prep.$tid;
//TEST ONLY
if ($complaint_stmt) {

	$complaint_stmt->bind_param('s', $tid);
	$complaint_stmt->execute();
	$complaint_stmt->store_result();
}

									if ($complaint_stmt->num_rows >= 1) {
											
											$msg .= '<table width="100%" border="1" cellpadding="1" cellspacing="0"
														class="prLBL3"
														style="margin: 10px 0; font: 11px/20px normal Helvetica, Arial, sans-serif !important;">
														<tr align="center" valign="middle"
															style="background-color: #73AAE5; font-weight: bold; color: #ffffff;">
															<td class="prLBL1" width="15%">TANGGAL</td>
															<td class="prLBL1">KETERANGAN</td>
															<td class="prLBL1" width="15%">STATUS</td>
														</tr>';
											
											
												$complaint_stmt->bind_result($edccomplaint_id,$status_name,$branch_name,
														$edccomplaint_tid,
														$edccomplaint_pic,
														$edccomplaint_keterangan,
														$edccomplaint_kodeuker,
														$edccomplaint_status,
														$edccomplaint_creadt,
														$edccomplaint_lokasi,
														$edccomplaint_tindakan);
											
												while ($complaint_stmt->fetch()){
													switch ($status_name) {
														case "PENDING":
															$statusColor = "background-color:#FF3939";
															break;
														case "DONE":
															$statusColor = "background-color:#00FF00";
															break;
														case "ON PROGRESS":
															$statusColor = "background-color:#FFE000";
															break;
													}
												
														
													$msg .= '<tr class="tblhov">
																<td align="center">'.date("Y-m-d",strtotime($edccomplaint_creadt)).'</td>
																<td align="left" style="padding-left: 7px;"><b>'.$edccomplaint_pic.' ('.$branch_name.') : </b> '.$edccomplaint_keterangan.' </td>
																<td align="center" style="font-weight: bold; '.$statusColor.'">'.$status_name.'</td>
															</tr>';																								
												}
												$msg .= '</table>';
												echo $msg;
											}else {
												$msg .= '<table width="100%" border="0" cellpadding="1" cellspacing="0"
															class="prLBL3"
															style="margin: 10px 0; font: 11px/20px normal Helvetica, Arial, sans-serif !important;">
															<tr>
																<td align="center">- Tidak ada data -</td>
															</tr>
														</table>';
												
												echo $msg;
												 	
											}
											
											?>
										
</body>
</html>