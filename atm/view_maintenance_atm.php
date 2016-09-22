<?php 

$isUker = 0;
$logged = "out";
if (!empty($_SESSION['user_pn'])) {
	$logged = "in";
	if ($_SESSION['user_uker']) {
		$isUker = 1;
	}
}
?>
<html>
<head>
<style type="text/css">@import "../css/table_edc.css";</style>
<!--<style type="text/css">@import "../css/ajax-loading.css";</style>
 script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script> -->
<style type="text/css">

/* #loading{
width: 100%;
position: absolute;
top: 100px;
left: 500px;
margin-top:200px;
} */
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

#fader {
  opacity: 0.5;
  background: black;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  display: none;
}

.modal {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('../resource/loadingdrive.gif') 
                50% 50% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .modal {
    display: block;
}
</style>

<script type="text/javascript">

 $body = $("body");
 
 //$(document).on({
    //ajaxStart: function() { $body.addClass("loading");    },
    //ajaxStop: function() { $body.removeClass("loading"); }    
//});
 
 $(document)
  .ajaxStart(function () {
	  $body.addClass("loading");
  })
  .ajaxStop(function () {
	  $body.removeClass("loading");
  });
 
$(document).ready(function(){

function exportExcel(page,txtSearch,selectSearch){
		
        //loading_show();     
        //alert('start downloading ' + selectSearch +' '+txtSearch);    
        var loggedId = $('#logged').val();    
        var userId = $('#userId').val();  
        var userBranchId = $('#userBranchId').val();   
        var isUker = $('#isUker').val();   
        var ukerName = $('#ukerName').val();   
        //alert('start downloading ' + userBranchId );  
               
        $.ajax
        ({
            type: "POST",
            url: "export_excel_maintenance_atm.php",
            data: {page : page,
                	logged : loggedId, 
                	txtsearch : txtSearch, 
                	selectSearch : selectSearch,
                	userIdVar : userId,
                	userBranchIdVar : userBranchId,
                	isUkerVar : isUker,
                	ukerNameVar : ukerName},
            //dataType: "json",
            success: function(response)
            {
            	
            	window.location.href = response.url;
            	//window.open(response.url,'_blank' );
            	//alert('download finish ' + selectSearch +' '+txtSearch);
            },
            error: function( error )
            {

               alert( JSON.stringify(error) );

            }
        });
    }
	$('#btnExport').live('click',function(){
		//$('#fader').css('display', 'block');
        var txtSearch = $('#txtSearch').val();
        var selectSearch = $('#selectSearch').val();
        exportExcel(1,txtSearch,selectSearch);
        
    });
    
	function loading_show(){
        $('#loading').html("<img src='../resource/loadingajax.gif").fadeIn('fast');
    }
    function loading_hide(){
        $('#loading').fadeOut('fast');
    }    
	function loadData(page){
		//loading_show();
		//alert(page);
		var action = document.createElement("input");
		var paginaction = document.createElement("input");
		//Add the new element to our form. 
		form =document.getElementById('frmSearch');
		form.appendChild(action);
		action.name = "action";
		action.type = "hidden";
		action.value = "view_maintenance_atm";
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
	form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_maintenance_atm";
    
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
	
}

function submitExport(){
	var p = document.createElement("input");
	var action = document.createElement("input");
	var actionx = document.createElement("input");

	// Add the new element to our form. 
    form =document.getElementById('frmSearch');
    form.appendChild(p);
    p.name = "actioncari";
    p.type = "hidden";
    p.value = "cari";
    
    // Add the new element to our form. 
	form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_maintenance_atm";

    form.appendChild(actionx);
    actionx.name = "actionexport";
    actionx.type = "hidden";
    actionx.value = "export_excel";
    
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
	    action.value = "view_maintenance_atm";
	
	    form.appendChild(actionType);
	    actionType.name = "deleteaction";
	    actionType.type = "hidden";
	    actionType.value = "view_maintenance_atm_delete";
	    //alert(saveaction.value);
	    // Finally submit the form. 
	    form.submit();
		//document.getElementById('frmSearch').submit();
	}
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
    action.value = "update_maintenance_atm";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
	
}
</script>
</head>
<?php

$atm_act_id=
$atm_act_date=
$atm_act_loc=
$atm_act_tid=
$atm_act_pmaction=
$atm_act_pmteamkc=
$atm_act_pmdesc=
$atm_brand_sname=
$atm_cro_name=
$branch_code=
$atm_act_isonsite=
$branch_name=
$branch_mbcode=
$branch_mbname=
$problem_name=
$status_name=
$status_id=
$atm_act_isgaransi=
$user_lname=
$user_uker=
$action="";

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
	
	$delete_prep = "DELETE FROM m_atm_activitylog WHERE atm_act_id = ? ";
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
<form action="../atm/dashboard_atm.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch">
<input type="hidden" id="logged" value="<?php echo $logged;?>"></input>
<input type="hidden" id="userId" value="<?php if(!empty($_SESSION['user_id'])) echo $_SESSION['user_id'];?>"></input>
<input type="hidden" id="userBranchId" value="<?php if(!empty($_SESSION['user_branch_id'])) echo $_SESSION['user_branch_id'];?>"></input>
<input type="hidden" id="isUker" value="<?php echo $isUker;?>"></input>
<input type="hidden" id="ukerName" value="<?php if(!empty($_SESSION['user_branch_name'])) echo $_SESSION['user_branch_name'];?>"></input>
<div id="fader"></div>
<div class="right">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  		<tr>
   		 <td height="3">
        	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
         	 	<tr>
             	 <td align="center" valign="middle"><h3 style="margin-top:0px;"><b>Report Maintenance ATM</b></h3></td>
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
																			
										//unset var before reusing
										unset($select_prep,$select_stmt);
										
										$orderbySQL = " ORDER BY ";
										$orderby = " atm_act_upddt ";
										$ascdesc = " desc ";
										$criteria=$txtSearchSQL = "";
										$orderbySQL .= $orderby.$ascdesc;
										
										//mengambil data sesuai kriteria
										$select_prep = "select atm_act_id,atm_act_date,atm_act_loc,atm_act_tid,atm_act_pmaction,
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
										
										$count_prep = "SELECT COUNT(atm_act_id)
														from m_atm_activitylog
														left join m_atm_brand on atm_brand_id = atm_act_brand_id
														left join m_user u on user_id = atm_act_pmteamkw_id
														left join m_atm_cro on atm_cro_id = atm_act_cro_id
														left join m_branch on branch_id = atm_act_branch_id
														left join m_problem_cat on problem_id = atm_act_probcat_id
														left join m_status on status_id = atm_act_status_id ";
										
										if(!empty($_POST["actioncari"]) || !empty($action)){
											if (validateInput($_POST["txtSearch"]) <> "") {
										
												switch ($post) {
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
														$criteria .= " and atm_act_branch_id = ".$_SESSION['user_branch_id'];
													}else $criteria .= " and atm_act_pmteamkw_id = ".$_SESSION['user_id'];
																								
												}
												
												$txtSearchSQL = "%".$txtSearch."%";
											}else {
												if ($logged == "in") {
													if ($isUker) {
														$select_prep .= " where atm_act_branch_id = ".$_SESSION['user_branch_id'];
														$count_prep .= " where atm_act_branch_id = ".$_SESSION['user_branch_id'];
													}else{
														$select_prep .= " where atm_act_pmteamkw_id = ".$_SESSION['user_id'];
														$count_prep .= " where atm_act_pmteamkw_id = ".$_SESSION['user_id'];
													}
												}
											
											}
											$select_prep .= $criteria;
											$count_prep .= $criteria;
										}else {
												if ($logged == "in") {
													if ($isUker) {
														$select_prep .= " where atm_act_branch_id = ".$_SESSION['user_branch_id'];
														$count_prep .= " where atm_act_branch_id = ".$_SESSION['user_branch_id'];
													}else{
														$select_prep .= " where atm_act_pmteamkw_id = ".$_SESSION['user_id'];
														$count_prep .= " where atm_act_pmteamkw_id = ".$_SESSION['user_id'];
													}
												}
											
											}
										$select_prep_excel = $select_prep;
										$select_prep .= $orderbySQL." LIMIT $start,$per_page";
										$count_prep .= $orderbySQL;
										$select_stmt = $mysqli->prepare($select_prep);
										$select_stmt_excel = $mysqli->prepare($select_prep_excel);
										$count_stmt = $mysqli->prepare($count_prep);
										 
										// TEST ONLY ECHO QUERY
//  									echo $select_prep.$logged.$isUker;
										//TEST ONLY
										if ($select_stmt) {
											if ($criteria <> "") {
												$select_stmt->bind_param('s', $txtSearchSQL);
												$select_stmt_excel->bind_param('s', $txtSearchSQL);
												$count_stmt->bind_param('s', $txtSearchSQL);
											}
											
											$select_stmt->execute();
											$select_stmt->store_result();
											$select_stmt_excel->execute();
											$select_stmt_excel->store_result();
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
									<option value="atm_act_tid" <?php if ($post == "atm_act_tid") { echo "selected"; }else echo "";?>>TID</option>
									<option value="atm_brand_sname" <?php if ($post == "atm_brand_sname") { echo "selected"; }else echo "";?>>Merk</option>
									<option value="atm_cro_name" <?php if ($post == "atm_cro_name") { echo "selected"; }else echo "";?>>CRO</option>
									<option value="branch_name" <?php if ($post == "branch_name") { echo "selected"; }else echo "";?>>KC Supervisi</option>
									<option value="status_name" <?php if ($post == "status_name") { echo "selected"; }else echo "";?>>Status</option>
									<option value="atm_act_loc" <?php if ($post == "atm_act_loc") { echo "selected"; }else echo "";?>>Lokasi</option>					
									</select>
									<input type="text" id="txtSearch" name="txtSearch" value="<?php echo $txtSearch;?>" />
<!-- 									<input type="submit" value=" Cari " id="btnCari" name="btnCari"/> -->
									<input type="button" value=" Cari" id="btnCari" name="btnCari" onclick="submitSearch();"/>
									<!-- input type="button" value=" Excel" id="btnExport" name="btnExport" onclick="submitExport();"/-->
									<?php if ($logged == "in"){
										
										echo "<input type='button' value=' Export Excel' id='btnExport' />";
										
										
									}
									
									?>
									<!-- a href="../helper/excel_adapter.php?RTYPE=atmmaintenance" target="_blank">export</a-->
								</td>
								<td align="right">
									<b><i>Total Data: <?php echo number_format($totalatm,0);?></i></b>
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
              			$jumKolom = "14";
              			if ($logged == "in") {
              				$strAction .= '<th style="text-align: center;" nowrap>Action</th>';
              				$jumKolom = "15";
              			}
              			$msg .= '<thead>
								<tr class="tr">
						    	<th style="text-align: center;" nowrap>No</th>'.
								$strAction
								.'<th style="text-align: center;" nowrap>Tanggal</th>
								<th style="text-align: center;" nowrap>Tid</th>
								<th style="text-align: center;" nowrap>Merk</th>
								<th style="text-align: center;" nowrap>CRO</th>
						        <th style="text-align: center;" nowrap>Kanca Supervisi</th>
								<th style="text-align: center;" nowrap>Lokasi</th>
						        <th style="text-align: center;" nowrap>Onsite/Offsite</th>
						        <th style="text-align: center;" nowrap>Garansi/Non Garansi</th>
						        <th style="text-align: center;" nowrap>Problem</th>
						        <th style="text-align: center;" nowrap>Tindakan</th>
						        <th style="text-align: center;" nowrap>Status</th>
								<th style="text-align: center;" nowrap>Keterangan</th>
								<th style="text-align: center;" nowrap>Team Maintenance</th>
							</tr></thead>';
						try {	
							$rNum = ($per_page * ($page)) + 1;
								
								
								
 							if ($select_stmt->num_rows >= 1) {
								
								$select_stmt->bind_result($atm_act_id,
															$atm_act_date,
															$atm_act_loc,
															$atm_act_tid,
															$atm_act_pmaction,
															$atm_act_pmteamkc,
															$atm_act_pmdesc,
															$atm_brand_sname,
															$atm_cro_name,
															$branch_code,
															$atm_act_isonsite,
															$branch_name,
															$branch_mbcode,
															$branch_mbname,
															$problem_name,
															$status_name,
															$status_id,
															$atm_act_isgaransi,
															$user_lname,
															$user_uker);
								while ($select_stmt->fetch()){
									
									if ($atm_act_isonsite == 1) {
										$isOnsite = "Onsite";
									}else $isOnsite = "Offsite";
									
									if ($atm_act_isgaransi == 1) {
										$isGaransi = "Garansi";
									}else $isGaransi = "Non Garansi";
									
									$teamPM = "";
									if (!empty($user_lname)) {
										$teamPM = $user_lname;
										if (!empty($atm_act_pmteamkc)) $teamPM .=','.$atm_act_pmteamkc;
									} 
									
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
										default: $statusColor = "background-color:#FFFFFF";
									}
									
									$strActionScript = "";
									if ($logged == "in") {
										$strActionScript .= '<td style="text-align: center;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">
						<a class="underline" href="javascript:updateAction('.$atm_act_id.');"><img src="../resource/pen.png" width="11" title="edit" alt="edit" /></a>
						<a class="underline" href="javascript:deleteAction('.$atm_act_id.');"><img src="../resource/delete_icon.png" width="11" title="hapus" alt="hapus" /></a></td>';
									}
									$msg .= '<tbody class="table-hover"><tr class="tr">
											<td style="text-align: center;font-size: 13px" class="td">'.$rNum.'</td>
											'.$strActionScript.'
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$atm_act_date.'</td>
											<td style="text-align: center;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">
		<a href="http://atmpro.bri.co.id/statusatm/viewatmdetail.pl?ATM_NUM='
										.$atm_act_tid.'" target="_blank">
		'.$atm_act_tid.'</a></td>									
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$atm_brand_sname.'</td>
            								<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$atm_cro_name.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$branch_name.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$atm_act_loc.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$isOnsite.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$isGaransi.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$problem_name.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$atm_act_pmaction.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;color:#000;'.$statusColor.' " nowrap class="td">'.$status_name.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$atm_act_pmdesc.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$teamPM.'</td>
                				 			</tr>';
									
									$rNum += 1;
								}
							}else $msg .= '<tbody class="table-hover"><tr class="tr"><td colspan="'.$jumKolom.'" style="text-align: center;" class="td">Data tidak ditemukan</td></tr></tbody>';
							
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
						
						if (!empty($_POST['actionexport']))
						{
							$ukerName = "Kanwil Jakarta 3";
							if ($isUker) {
								$ukerName = $_SESSION['user_branch_name'];
							}
							//$_SESSION['excel_atm_maintenance'] = $select_stmt_excel;
							set_time_limit(0);
							exportReportMaintenanceATM($select_stmt_excel,$ukerName);
							$select_stmt_excel->close();
						}
						?>  
						</div>            			
              		</td>
              	</tr>		
				</table>
			</td>
		</tr>
  		</table>
	</div>
	<div class="modal"></div>
	</form>
</body>
</html>