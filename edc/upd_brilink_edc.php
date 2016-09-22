<?php 
$isUker = 0;
if (!empty($_SESSION['user_pn'])) {
	$logged = "in";
	if ($_SESSION['user_uker']) {
		$isUker = 1;
	}
	
}else {
	$_SESSION["login_error"] = "Halaman tidak dapat diakses, silahkan login terlebih dahulu.";
	//header('Location: ../login/login.php?error=1');
	session_write_close();
}
?>
<html>
<head>
<style type="text/css">@import "../css/table_edc.css";</style>
<style type="text/css">

#loading{
width: 100%;
position: absolute;
top: 100px;
left: 500px;
margin-top:200px;
}
#tableContainer{
width: 1050px;
height: 100%;
overflow:scroll;

}
#tableContainer .pagination ul li.inactive,
#tableContainer .pagination ul li.inactive:hover{
background-color:#ededed;
color:#bababa;
border:1px solid #bababa;
cursor: default;
}
#tableContainer .data ul li{
list-style: none;
font-family: verdana;
margin: 5px 0 5px 0;
color: #000;
font-size: 13px;
}

#tableContainer .pagination{
width: 650px;
height: 100%;
font-family: verdana;
font-size: 12px;
margin-top:2px;
}
#tableContainer .pagination ul li{
list-style: none;
float: left;
border: 1px solid #006699;
padding: 2px 6px 2px 6px;
margin: 0 3px 0 3px;
font-family: arial;
font-size: 12px;
color: #006699;
font-weight: bold;
background-color: #f2f2f2;
}
#tableContainer .pagination ul li:hover{
color: #fff;
background-color: #006699;
cursor: pointer;
}
.go_button
{
	background-color:#f2f2f2;border:1px solid #006699;color:#006699;
	padding:0px 0px 0px 0px;cursor:pointer;position:absolute;margin-top:0px;
	margin-left:5px;
}
.total
{
	float:right;font-family:arial;color:#999;
}
.nowrap { white-space: nowrap; }
</style>

<script type="text/javascript">

$(document).ready(function(){
	function loading_show(){
		$('#loading').html("<img src='resource/loading.gif'/>").fadeIn('fast');
	}
	function loading_hide(){
		$('#loading').fadeOut('fast');
	}
	function loadData(page){
		loading_show();
		//alert(page);
		var action = document.createElement("input");
		var paginaction = document.createElement("input");
		//Add the new element to our form. 
		form =document.getElementById('frmSearch');
		form.appendChild(action);
		action.name = "action";
		action.type = "hidden";
		action.value = "openmenubrilinkinput";
		form.appendChild(paginaction);
		paginaction.name = "paginaction";
		paginaction.type = "hidden";
		paginaction.value = page;
		//alert(paginaction.value);
		//document.getElementById('frmSearch').action = "dashboard_edc.php?action=page&page="+page;
		document.getElementById('frmSearch').submit();

		/* $.ajax
		 ({
		 		type: "POST",
		 		url: "crud_uko_edc.php",
		 		data: "page="+page,
		 		success: function(msg)
		 		{
		 		$("#tableContainer").ajaxComplete(function(event, request, settings)
		 		{
		 				loading_hide();
		 				$("#tableContainer").html(msg);
		 				});
		 		}
		 		});  */
	}
	//loadData(1);  // For first time page load default results
	$('#tableContainer .pagination li.active').live('click',function(){
		var page = $(this).attr('p');
		loadData(page);

	});
	$('#go_btn').live('click',function(){
		var first_page = 1;
		var page = parseInt($('.goto').val());
		var no_of_pages = parseInt($('.total').attr('a'));
		if (no_of_pages == 0) {
			first_page = 0;
		}
		if(page != 0 && page <= no_of_pages){
			loadData(page);
		}else{
			alert('Masukan halaman antara '+first_page+' dan '+no_of_pages);
			$('.goto').val("").focus();
			return false;
		}

	});
});

function updateReportDetilByTID(recId){
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
    action.value = "opentidbrilinkinputedit";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
	
}

function openReportDetilByTID(form,recId){
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
    action.value = "opentidbrilink";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
	
}

function submitSearch(){
	var p = document.createElement("input");
	var action = document.createElement("input");

	// Add the new element to our form. 
    form =document.getElementById('frmSearch');
    form.appendChild(p);
    p.name = "actioncari";
    p.type = "hidden";
    p.value = "cari";
    
    // Add the new element to our form. 
	form =document.getElementById('frmSearch');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "openmenubrilinkinput";
    
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
	    action.value = "openmenubrilinkinput";
	
	    form.appendChild(actionType);
	    actionType.name = "deleteaction";
	    actionType.type = "hidden";
	    actionType.value = "openmenubrilinkinputdelete";
	    //alert(saveaction.value);
	    // Finally submit the form. 
	    form.submit();
		//document.getElementById('frmSearch').submit();
	}
}
</script>
</head>
<?php

/* $edcmerchant_id=$edcmerchant_tid=$edcmerchant_mid=$edcmerchant_tipe=$edcmerchant_kodekanca =$edcmerchant_nama=$edcmerchant_brand=$edcmerchant_sn=               
$edcmerchant_provider=$edcmerchant_opendate=$edcmerchant_dataadded=$edcmerchant_alamat=$edcmerchant_kota=$edcmerchant_norek=$edcmerchant_pic=$edcmerchant_pictelp          
=$edcmerchant_usaha=$edcmerchant_FO=$edcmerchant_tglimplementasi=$edcmerchant_tglinisiasi=$edcmerchant_keterangan=$edcmerchant_mcc=$edcmerchant_mdronus          
=$edcmerchant_mdroffus=$edcmerchant_creadt=$edcmerchant_upddt=$edcmerchant_creausr=$edcmerchant_updusr=$edcmerchant_replace=$edcmerchant_status=$action=
$edcbrand_id=$edcbrand_nama=$branch_mbcode=$branch_mbname=$branch_code=$branch_name=""; */

$edcbrilink_id=$edcbrilink_tid=$edcbrilink_mid=$edcbrilink_tipe=$edcbrilink_kodekanca=$edcbrilink_kodeunit=
$edcbrilink_brand=$edcbrilink_sn=$edcbrilink_simcard=$edcbrilink_agen=$edcbrilink_alamatrumah=$edcbrilink_alamatusaha=
$edcbrilink_nohp=$edcbrilink_jenisusaha=$edcbrilink_jarak=$edcbrilink_norekkupedes=$edcbrilink_noreksimpedes=
$edcbrilink_plafon=$edcbrilink_bakidebet=$edcbrilink_saldosimpanan=$edcbrilink_lamadebitur=$edcbrilink_lamanasabah=
$edcbrilink_alasan=$edcbrilink_provider=$edcbrilink_tglimplementasi=$edcbrilink_tglinit=
$edcbrand_id=$edcbrand_nama=$branch_mbcode=$branch_mbname=$branch_code=$branch_name=$edcsp_no=$edcbrilink_jenisusaha_id=$jenisusaha_id=$jenisusaha_desc=
$edcbrand_select_id=$edcbrand_select_nama=$provider_id=$provider_id=$provider_desc=$action=$edcbrilink_pic=$edcbrilink_pic_notelp=
$saveaction="";

$page = 1;//default value when load
if (!empty($_POST['paginaction'])){
$page = $_POST['paginaction'];
	//echo $page;
}
//get action page when loading
if (!empty($_POST["paginaction"])){
$action = $_POST["paginaction"];
}

$cur_page = $page;
$page -= 1;
$per_page = $GLOBALS["per_page"];//jumlah record per halaman
$previous_btn = true;
$next_btn = true;
$first_btn = true;
$last_btn = true;
$start = $page * $per_page;
$no_of_paginations=0;
$msg = "";

$tid = "";
if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}

$mysqli = getConnection();

if (!empty($_POST["deleteaction"])){

	$delete_prep = "UPDATE m_edc_brilink SET edcbrilink_isactive = 0 WHERE edcbrilink_id = ?  ";
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
?>
<body>
<form action="../edc/dashboard_edc.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch">
<div class="right">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  		<tr>
   		 <td height="3">
        	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
         	 	<tr>
             	 <td align="center" valign="middle"><h3 style="margin-top:0px;"><b>LIST EDC BRILINK</b></h3></td>
          		</tr>
        	</table>
    	 </td>
  		</tr>
  		<tr>
    		<td valign="top">
    			<table width="100%"  border="0" cellpadding="0">
     			<tr>
        			<td align="center" valign="top">
						
							<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	              			<tr>
								<td align="left" valign="middle">
									<b><i>Search by :</i></b>
									<?php 
										$post=$txtSearch = "";
										$totalatm = 0;
										if (!empty($_POST['selectSearch'])) {
											$post = $_POST['selectSearch'];
										
											if (validateInput($_POST["txtSearch"]) <> "") {
												$txtSearch = $_POST["txtSearch"];
											}
										}
										
										$mysqli = getConnection();
																			
										//unset var before reusing
										unset($select_prep,$select_stmt);
										
										$orderbySQL = " ORDER BY ";
										$orderby = " edcbrilink_kodekanca,edcbrilink_tid ";
										$ascdesc = " asc ";
										$criteria=$txtSearchSQL = "";
										$orderbySQL .= $orderby.$ascdesc;
										
										//mengambil data sesuai kriteria
										$select_prep = "SELECT edcbrilink_id,edcbrilink_tid,edcbrilink_mid,edcbrilink_tipe,edcbrilink_kodekanca,edcbrilink_kodeunit,edcbrilink_brand,
															edcbrilink_sn,edcbrilink_simcard,edcbrilink_agen,edcbrilink_alamatrumah,edcbrilink_alamatusaha,edcbrilink_nohp,edcbrilink_jenisusaha,edcbrilink_jarak,edcbrilink_norekkupedes,
															edcbrilink_noreksimpedes,edcbrilink_plafon,edcbrilink_bakidebet,edcbrilink_saldosimpanan,edcbrilink_lamadebitur,
															edcbrilink_lamanasabah,edcbrilink_alasan,edcbrilink_provider,edcbrilink_tglimplementasi,edcbrilink_tglinit,
															edcbrand_id,edcbrand_nama,b2.mainbr AS branch_mbcode,b2.brdesc AS branch_mbname,b1.branch AS branch_code,b1.brdesc AS branch_name,edcbrilink_pic,edcbrilink_pic_notelp
														FROM m_edc_brilink
														LEFT JOIN m_edc_brand ON edcbrand_id = edcbrilink_brand
														LEFT JOIN dwh_branch b1 ON b1.branch = edcbrilink_kodeunit
														LEFT JOIN dwh_branch b2 ON b2.branch = edcbrilink_kodekanca
														WHERE edcbrilink_isactive = 1  ";
										
										$count_prep = "SELECT COUNT(edcbrilink_id)
														FROM m_edc_brilink
														LEFT JOIN m_edc_brand ON edcbrand_id = edcbrilink_brand
														LEFT JOIN m_branch ON branch_code = edcbrilink_kodekanca 
														WHERE edcbrilink_isactive = 1 ";
										
										if(!empty($_POST["actioncari"]) || !empty($action)){
											if (validateInput($_POST["txtSearch"]) <> "") {
										
												switch ($post) {
													case "edcbrilink_tid":
														$criteria .= " AND edcbrilink_tid LIKE ? ";
														break;
													case "edcbrilink_mid":
														$criteria .= " AND edcbrilink_mid LIKE ? ";
														break;
													case "kodekanca":
														$criteria .= " AND branch_code LIKE ? ";
														break;
													case "edcbrilink_kodekanca":
														$criteria .= " AND branch_name LIKE ? ";
														break;
													case "kodeunit":
														$criteria .= " AND branch_code LIKE ? ";
														break;
													case "edcbrilink_kodeunit":
														$criteria .= " AND branch_name LIKE ? ";
														break;		
													case "edcbrilink_agen":
														$criteria .= " AND edcbrilink_agen LIKE ? ";
														break;
													case "edcbrilink_jenisusaha":
														$criteria .= " AND edcbrilink_jenisusaha LIKE ? ";
														break;														
													default:
														;
														break;
												}
												if ($logged == "in") {
													if ($isUker) {	
														$criteria .= " and edcbrilink_kodeunit IN (select branch from dwh_branch b3 where b3.MAINBR = ".$_SESSION['user_branch_code'].") ";
													}
												}
												$txtSearchSQL = "%".$txtSearch."%";
											}else {
												if ($logged == "in") {
													if ($isUker) {
														$select_prep .= " AND edcbrilink_kodeunit IN (select branch from dwh_branch b3 where b3.MAINBR = ".$_SESSION['user_branch_code'].") ";
														$count_prep .= " AND edcbrilink_kodeunit IN (select branch from dwh_branch b3 where b3.MAINBR = ".$_SESSION['user_branch_code'].") ";
													}
												}											
											}
											$select_prep .= $criteria;
											$count_prep .= $criteria;
										}else {
												if ($logged == "in") {
													if ($isUker) {
														$select_prep .= " AND edcbrilink_kodeunit IN (select branch from dwh_branch b3 where b3.MAINBR = ".$_SESSION['user_branch_code'].") ";
														$count_prep .= " AND edcbrilink_kodeunit IN (select branch from dwh_branch b3 where b3.MAINBR = ".$_SESSION['user_branch_code'].") ";
													}
												}											
											}
										$select_prep .= $orderbySQL." LIMIT $start,$per_page";
										$count_prep .= $orderbySQL;
										$select_stmt = $mysqli->prepare($select_prep);
										$count_stmt = $mysqli->prepare($count_prep);
										 
										// TEST ONLY ECHO QUERY
//  									echo $select_prep.$logged;
										//TEST ONLY
										if ($select_stmt) {
											if ($criteria <> "") {
												$select_stmt->bind_param('s', $txtSearchSQL);
												$count_stmt->bind_param('s', $txtSearchSQL);
											}
											
											$select_stmt->execute();
											$select_stmt->store_result();
											$count_stmt->execute();
											$count_stmt->store_result();
										}
										 
										if ($count_stmt->num_rows >= 1) {
										
											$count_stmt->bind_result($totalatm);
											$count_stmt->fetch();
										}
										$count = $totalatm;
										$no_of_paginations = ceil($count / $per_page);
									?>
									<select id="selectSearch" name="selectSearch">
									<option value="edcbrilink_tid" <?php if ($post == "edcbrilink_tid") { echo "selected"; }else echo "";?>>TID</option>
									<option value="edcbrilink_mid" <?php if ($post == "edcbrilink_mid") { echo "selected"; }else echo "";?>>MID</option>
									<option value="kodekanca" <?php if ($post == "kodekanca") { echo "selected"; }else echo "";?>>Kode Kanca</option>
									<option value="edcbrilink_kodekanca" <?php if ($post == "edcbrilink_kodekanca") { echo "selected"; }else echo "";?>>Kanca</option>
									<option value="kodeunit" <?php if ($post == "kodeunit") { echo "selected"; }else echo "";?>>Kode Unit</option>
									<option value="edcbrilink_kodeunit" <?php if ($post == "edcbrilink_kodeunit") { echo "selected"; }else echo "";?>>Unit</option>
									<option value="edcbrilink_agen" <?php if ($post == "edcbrilink_agen") { echo "selected"; }else echo "";?>>Nama Agen</option>
									<option value="edcbrilink_jenisusaha" <?php if ($post == "edcbrilink_jenisusaha") { echo "selected"; }else echo "";?>>Jenis Usaha</option>					
									</select>
									<input type="text" id="txtSearch" name="txtSearch" value="<?php echo $txtSearch;?>" />
<!-- 									<input type="submit" value=" Cari " id="btnCari" name="btnCari"/> -->
									<input type="button" value=" Cari" id="btnCari" name="btnCari" onclick="submitSearch();"/>
								</td>
								<td align="right">
									<b><i>Total Data EDC: <?php echo number_format($totalatm,0);?></i></b>
								</td>
	              			</tr>
	              			<tr><td colspan ="2"><hr/></td></tr>
	              			</table>
						
					</td>
				</tr>
              	<tr>
              		<td>
              			<div id="tableContainer">
              			
              			<?php 
              			$strAction = "";
              			if ($logged == "in") {
              				$strAction .= '<th style="text-align: center;" nowrap>Action</th>';
              				 
              				 
              			}
              			$msg .= '<thead>
								<tr class="tr">
						    	<th style="text-align: center;" nowrap>No</th>
								'.$strAction.'
								<th style="text-align: center;" nowrap>Tid</th>
								<!--th style="text-align: center;" nowrap>Mid</th-->
								
						        <th style="text-align: center;" nowrap>Kanca Supervisi</th>
								<th style="text-align: center;" nowrap>Unit Kerja</th>
								<th style="text-align: center;" nowrap>Agen</th>
						        <th style="text-align: center;" nowrap>Tipe</th>
								<th style="text-align: center;" nowrap>Merk</th>
								<th style="text-align: center;" nowrap>PIC</th>
								<th style="text-align: center;" nowrap>No Telp PIC</th>
						        
						        <!--th style="text-align: center;" nowrap>Jenis Usaha</th-->
								
							</tr></thead>';
						try {	
							
							$rNum = ($per_page * ($page)) + 1;
							
 							if ($select_stmt->num_rows >= 1) {

								$select_stmt->bind_result($edcbrilink_id,$edcbrilink_tid,$edcbrilink_mid,$edcbrilink_tipe,$edcbrilink_kodekanca,$edcbrilink_kodeunit,$edcbrilink_brand,
								$edcbrilink_sn,$edcbrilink_simcard,$edcbrilink_agen,$edcbrilink_alamatrumah,$edcbrilink_alamatusaha,$edcbrilink_nohp,$edcbrilink_jenisusaha,$edcbrilink_jarak,$edcbrilink_norekkupedes,
								$edcbrilink_noreksimpedes,$edcbrilink_plafon,$edcbrilink_bakidebet,$edcbrilink_saldosimpanan,$edcbrilink_lamadebitur,
								$edcbrilink_lamanasabah,$edcbrilink_alasan,$edcbrilink_provider,$edcbrilink_tglimplementasi,$edcbrilink_tglinit,
								$edcbrand_id,$edcbrand_nama,$branch_mbcode,$branch_mbname,$branch_code,$branch_name,$edcbrilink_pic,$edcbrilink_pic_notelp);
								while ($select_stmt->fetch()){

$strActionScript = "";
if ($logged == "in") {
	$strActionScript .= '<td style="text-align: center;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">
																		<a class="underline" href="javascript:updateReportDetilByTID('.$edcbrilink_tid.');"><img src="../resource/pen.png" width="11" title="edit" alt="edit" /></a>
																		<a class="underline" href="javascript:deleteAction('.$edcbrilink_id.');"><img src="../resource/delete_icon.png" width="11" title="delete" alt="delete" /></a>
																		</td>';
}
															
									$msg .= '<tbody class="table-hover"><tr class="tr">
											<td style="text-align: center;font-size: 13px" class="td">'.$rNum.'</td>								
											'.$strActionScript.'
											<td style="text-align: center;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">
				<a style="font-size: 13px;font-family: Courier New;" 
				href="javascript:openReportDetilByTID(this.form,'.$edcbrilink_tid.');" >'.$edcbrilink_tid.'</a></td>
											<!--td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$edcbrilink_mid.'</td-->	
		 									<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.str_pad($branch_mbcode, 5, '0', STR_PAD_LEFT).' - '.$branch_mbname.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.str_pad($branch_code, 5, '0', STR_PAD_LEFT).' - '.$branch_name.'</td>	
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$edcbrilink_agen.'</td>						
				<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$edcbrilink_tipe.'</td>							
				<td style="text-align: center;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$edcbrand_nama.'</td>
    		<td style="text-align: center;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$edcbrilink_pic.'</td>
    		<td style="text-align: center;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$edcbrilink_pic_notelp.'</td>
											<!--td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$edcbrilink_jenisusaha.'</td-->';	
									$rNum += 1;
								}
							}else $msg .= '<tbody class="table-hover"><tr class="tr"><td colspan="10" style="text-align: center;" class="td">Data tidak ditemukan</td></tr></tbody>';
							
						} catch (Exception $e) {
							echo $e->getMessage();
						}
				
						$msg = "<table ><tr><td><div class='data'><table class='table-fill'>" . $msg . "</table></div></td></tr><tr><td>"; // Content for Data
						
						/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
						if ($cur_page >= 7) {
							$start_loop = $cur_page - 3;
							if ($no_of_paginations > $cur_page + 3)
								$end_loop = $cur_page + 3;
							else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
								$start_loop = $no_of_paginations - 6;
								$end_loop = $no_of_paginations;
							} else {
								$end_loop = $no_of_paginations;
							}
						} else {
							$start_loop = 1;
							if ($no_of_paginations > 7)
								$end_loop = 7;
							else
								$end_loop = $no_of_paginations;
						}
						/* ----------------------------------------------------------------------------------------------------------- */
						$msg .= "<div class='pagination'><ul>";
						
						// FOR ENABLING THE FIRST BUTTON
						if ($first_btn && $cur_page > 1) {
							$msg .= "<li p='1' class='active'>First</li>";
						} else if ($first_btn) {
							$msg .= "<li p='1' class='inactive'>First</li>";
						}
						
						// FOR ENABLING THE PREVIOUS BUTTON
						if ($previous_btn && $cur_page > 1) {
							$pre = $cur_page - 1;
							$msg .= "<li p='$pre' class='active'>Previous</li>";
						} else if ($previous_btn) {
							$msg .= "<li class='inactive'>Previous</li>";
						}
						
						for ($i = $start_loop; $i <= $end_loop; $i++) {
						
							if ($cur_page == $i)
								$msg .= "<li p='$i' style='color:#fff;background-color:#006699;' class='active'>{$i}</li>";
							else
								$msg .= "<li p='$i' class='active'>{$i}</li>";
						}
						
						// TO ENABLE THE NEXT BUTTON
						if ($next_btn && $cur_page < $no_of_paginations) {
							$nex = $cur_page + 1;
							$msg .= "<li p='$nex' class='active'>Next</li>";
						} else if ($next_btn) {
							$msg .= "<li class='inactive'>Next</li>";
						}
						
						// TO ENABLE THE END BUTTON
						if ($last_btn && $cur_page < $no_of_paginations) {
							$msg .= "<li p='$no_of_paginations' class='active'>Last</li>";
						} else if ($last_btn) {
							$msg .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
						}
						if ($no_of_paginations == 0) {
							$no_of_paginations = 1;
						}
						$goto = "<input type='text' class='goto' size='1' style='margin-top:0px;margin-left:3px;'/><input type='button' id='go_btn' class='go_button' value='Go'/>";
						$total_string = "<span class='total' a='$no_of_paginations'>Page " . $cur_page . " of ".$no_of_paginations."</span>";
						$msg = $msg . "</ul>" . $goto . $total_string . "</div>";  // Content for pagination
						echo $msg.'</td></tr></table>';
						
						$select_stmt->close();
						?>  
						</div>            			
              		</td>
              	</tr>		
				</table>
			</td>
		</tr>
  		</table>
	</div>
	</form>
</body>
</html>