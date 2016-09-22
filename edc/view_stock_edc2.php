<?php 

$isUker = 0;
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

.ellipsis { margin-right:-10000px;text-overflow:ellipsis; overflow:hidden; width:140px; white-space:nowrap; }
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
		action.value = "view_stock_edc";
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
    action.value = "openreportbytid";
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
    action.value = "view_stock_edc";
    
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
	
}
</script>
</head>
<?php
$edcstock_id=
$edcstock_sn=
$edcstock_jarkom=
$edcstock_vendor=
$edcstock_status_id=
$edcstock_merk=
$edcstock_tipe=
$edcstock_tglmasuk=$edcstock_tglkeluar=
$status_name=$branch_name=
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
?>
<body>
<form action="../edc/dashboard_edc.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch">
<div class="right">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  		<tr>
   		 <td height="3">
        	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
         	 	<tr>
             	 <td align="center" valign="middle"><h3 style="margin-top:0px;"><b>DATA STOCK EDC</b></h3></td>
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
										$orderby = " edcstock_sn ";
										$ascdesc = " asc ";
										$criteria=$txtSearchSQL = "";
										$orderbySQL .= $orderby.$ascdesc;
										
										//mengambil data sesuai kriteria
										$select_prep = " SELECT edcstock_id,
																edcstock_sn,
																edcstock_jarkom,
																edcstock_vendor,
																edcstock_status_id,
																edcstock_merk,
																edcstock_tipe,
																edcstock_tglmasuk,
																edcstock_tglkeluar,
																status_name 
														FROM m_edc_stock 
														LEFT JOIN m_stock_status ON status_id = edcstock_status_id ";
										
										$count_prep = "SELECT COUNT(edcstock_id)
														FROM m_edc_stock ";
										
										if(!empty($_POST["actioncari"]) || !empty($action)){
											if (validateInput($_POST["txtSearch"]) <> "") {
										
												switch ($post) {
													case "edcstock_sn":
														$criteria .= " WHERE edcstock_sn LIKE ? ";
														break;
													case "edcstock_tipe":
														$criteria .= " WHERE edcstock_merk LIKE ? ";
														break;
													default:
														;
														break;
												}
												
												$txtSearchSQL = "%".$txtSearch."%";
											}
											$select_prep .= $criteria;
											$count_prep .= $criteria;
										}
										$select_prep .= $orderbySQL." LIMIT $start,$per_page";
										$count_prep .= $orderbySQL;
										$select_stmt = $mysqli->prepare($select_prep);
										$count_stmt = $mysqli->prepare($count_prep);
										 
										// TEST ONLY ECHO QUERY
//  									echo $count_prep.$logged.$isUker;
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
									<option value="edcstock_sn" <?php if ($post == "edcstock_sn") { echo "selected"; }else echo "";?>>TID</option>
									<option value="edcstock_tipe" <?php if ($post == "edcstock_tipe") { echo "selected"; }else echo "";?>>Tipe EDC</option>
									</select>
									<input type="text" id="txtSearch" name="txtSearch" value="<?php echo $txtSearch;?>" />
									<input type="button" value=" Cari" id="btnCari" name="btnCari" onclick="submitSearch();"/>
								</td>
								<td align="right">
									<b><i>Total Data Stock EDC: <?php echo number_format($totalatm,0);?></i></b>
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
              			$msg .= '<thead>
								<tr class="tr">
						    	<th style="text-align: center;" nowrap>No</th>
								<th style="text-align: center;" nowrap>Tgl Masuk</th>
								<th style="text-align: center;" nowrap>Tgl Keluar</th>
								<th style="text-align: center;" nowrap>Status</th>
								<th style="text-align: center;" nowrap>S/N</th>
								<th style="text-align: center;" nowrap>Jarkom</th>
								<th style="text-align: center;" nowrap>Merk</th>
								<th style="text-align: center;" nowrap>Vendor</th>
								<th style="text-align: center;" nowrap>Tipe</th>						        
								</tr>
								</thead>';
						try {	
							$rNum = ($per_page * ($page)) + 1;
							
 							if ($select_stmt->num_rows >= 1) {
								
								$select_stmt->bind_result($edcstock_id,
															$edcstock_sn,
															$edcstock_jarkom,
															$edcstock_vendor,
															$edcstock_status_id,
															$edcstock_merk,
															$edcstock_tipe,
															$edcstock_tglmasuk,
															$edcstock_tglkeluar,
															$status_name);
								while ($select_stmt->fetch()){
									switch ($status_name) {
										case "OUT OF STOCK":
										    $statusColor = "background-color:#FF3939";
											break;
										case "IN STOCK":
											$statusColor = "background-color:#00FF00";
											break;
										default: $statusColor = "background-color:#FFFFFF";
									}
									
															
									$msg .= '<tbody class="table-hover"><tr class="tr">
											<td style="text-align: center;font-size: 13px" class="td">'.$rNum.'</td>								
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.date("Y-m-d",strtotime($edcstock_tglmasuk)).'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.date("Y-m-d",strtotime($edcstock_tglkeluar)).'</td>
											<td style="text-align: center;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;color:#000;'.$statusColor.'" nowrap class="td">'.$status_name.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$edcstock_sn.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$edcstock_jarkom.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$edcstock_merk.'</td>
		 									<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$edcstock_vendor.'</td>
											<td style="text-align: left;font-size: 13px;padding-left:7px;padding-right:7px;font-family: Courier New;" nowrap class="td">'.$edcstock_tipe.'</td>';
											
									$rNum += 1;
								}
							}else $msg .= '<tbody class="table-hover"><tr class="tr"><td colspan="9" style="text-align: center;" class="td">Data tidak ditemukan</td></tr></tbody>';
							
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
						$count_stmt->close();
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