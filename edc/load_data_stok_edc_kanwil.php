<?php
require '../config/DBConnect.php';
require '../helper/ATM_DBHelper.php';

if($_POST['page'])
{
$page = $_POST['page'];
$logged = $_POST['logged'];

$txtsearch=$selectSearch="";

if ($_POST['txtsearch']) {
	$txtsearch = $_POST['txtsearch'];
}
if ($_POST['selectSearch']) {
	$selectSearch = $_POST['selectSearch'];
}


$cur_page = $page;
$page -= 1;
$per_page = 20;
$previous_btn = true;
$next_btn = true;
$first_btn = true;
$last_btn = true;
$start = $page * $per_page;
$rNum = ($per_page * ($page)) + 1;
$criteria=$txtSearchSQL = "";
$count = 0;


if ($txtsearch <> "") {

	switch ($selectSearch) {
		case "atmpart_sn":
			$criteria .= " AND atmpart_sn LIKE ?  ";
			break;
		case "atmpart_source_tid":
			$criteria .= " AND atmpart_source_tid LIKE ?  ";
			break;
		case "atmpart_dest_tid":
			$criteria .= " AND atmpart_dest_tid LIKE ?  ";
			break;
		case "jenispart_name":
			$criteria .= " AND jenispart_name LIKE ?  ";
			break;
				
		default:
			;
			break;
	}
	$txtSearchSQL = "%".$txtsearch."%";
}

$mysqli = getConnection();
unset($select_stmt,$select_count_stmt);

$select_stmt = getSparepartATMPagin($mysqli, $criteria, $txtSearchSQL,$start, $per_page);

$select_count_stmt = getCountSparepartATM($mysqli,$criteria,$txtSearchSQL);

$strAction = "";
if ($logged == "in") {
	$strAction .= '<th class="tg-b286" style="text-align: right">Edit</th>';
}
$msg = "";
$msg = "<table class='tg' >
    			<tr>
				    <th class='tg-b286' style='text-align: center'>No.</th>
					".$strAction."
    				<th class='tg-b286' style='text-align: right' nowrap>BRAND</th>
				    <th class='tg-b286' style='text-align: right' nowrap>PART</th>
				    <th class='tg-b286' style='text-align: left' nowrap>SERIAL NUMBER</th>
				    <th class='tg-b286' style='text-align: right' nowrap>TID SUMBER</th>
				    <th class='tg-b286' style='text-align: right' nowrap>TID TUJUAN</th>
				    <th class='tg-b286' style='text-align: right' nowrap>KETERANGAN</th>
				    <th class='tg-b286' style='text-align: right' nowrap>STATUS</th>
    			</tr>";

 if ($select_stmt->num_rows >= 1) {
 	
	$select_count_stmt->bind_result($count);
	$select_count_stmt->fetch();
	
	$select_stmt->bind_result($atmpart_id,
			$atmpart_brand_id,
			$atmpart_jenis_id,
			$atmpart_sn,
			$atmpart_source_tid,
			$atmpart_dest_tid,
			$atmpart_keterangan,
			$atmpart_isactive,
			$atmpart_creadt,
			$atmpart_upddt,
			$atmpart_creausr,
			$atmpart_updusr,
			$atmpart_status_id);
	
	while ($select_stmt->fetch()){
		
		switch ($atmpart_status_id) {
			case "In Use":
				$statusColor = "background-color:#FF3939";
				break;
			case "Available":
				$statusColor = "background-color:#00FF00";
				break;
			default: $statusColor = "background-color:#FFFFFF";
		}
		
	
		
		$strActionScript = "";
		if ($logged == "in") {
			$strActionScript .= '<td class="tg-031e" style="text-align: center">
													<a class="underline" href="javascript:updateAction('.$atmpart_id.');">
														<img src="../resource/pen.png" style="width:10px;height:10px"></img></a>
													<a class="underline" href="javascript:deleteAction('.$atmpart_id.');">
														<img src="../resource/delete_icon.png" style="width:10px;height:10px"></img></a>
												</td>';
		}
		
		$msg .= '<tr>
								    <td class="tg-031e" style="text-align: right">'.$rNum.'</td>
									'.$strActionScript.'
								    <td class="tg-031e" style="text-align: left">'.$atmpart_brand_id.'</td>
									<td class="tg-031e" style="text-align: left">'.$atmpart_jenis_id.'</td>
									<td class="tg-031e" style="text-align: left">'.$atmpart_sn.'</td>
									<td class="tg-031e" style="text-align: left">'.$atmpart_source_tid.'</td>
									<td class="tg-031e" style="text-align: left">'.$atmpart_dest_tid.'</td>
    								<td class="tg-031e" style="text-align: left">'.$atmpart_keterangan.'</td>
    								<td class="tg-031e" style="text-align: left;'.$statusColor.'">'.$atmpart_status_id.'</td>
								  </tr>';
		 
		$rNum += 1;
		
		}
		
	}
	else {
		if ($logged == "in") {
			
			$colspan = "9";
			
		}else {
			$colspan = "8";
		}
		$msg .= '<tr>
								    <td class="tg-031e" style="text-align: center" colspan="'.$colspan.'">No Data</td>
								  </tr>';
	}
	 






/* 
$query_pag_data = "SELECT
							  atmpart_id,
							  atm_brand_sname,
							  jenispart_name,
							  atmpart_sn,
							  atmpart_source_tid,
							  atmpart_dest_tid,
							  atmpart_keterangan,
							  atmpart_isactive,
							  atmpart_creadt,
							  atmpart_upddt,
							  atmpart_creausr,
							  atmpart_updusr,
							  statuspart_name FROM m_atm_sparepart
							LEFT JOIN m_atm_status_part ON statuspart_id = atmpart_status_id
							LEFT JOIN m_atm_brand2 ON atm_brand_id = atmpart_brand_id
							LEFT JOIN m_atm_jenispart ON jenispart_id = atmpart_jenis_id 
							WHERE atmpart_isactive = 1  
							ORDER BY statuspart_name,atm_brand_sname,jenispart_name
LIMIT $start, $per_page";

$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());

while ($row = mysql_fetch_array($result_pag_data)) {
	$htmlmsg = htmlentities($row['atmpart_sn']);
	
	switch (htmlentities($row['statuspart_name'])) {
		case "In Use":
			$statusColor = "background-color:#FF3939";
			break;
		case "Available":
			$statusColor = "background-color:#00FF00";
			break;
		default: $statusColor = "background-color:#FFFFFF";
	}
	
	$strActionScript = "";
	if ($logged == "in") {
		$strActionScript .= '<td class="tg-031e" style="text-align: center">
													<a class="underline" href="javascript:updateAction('.htmlentities($row['atmpart_id']).');">
														<img src="../resource/pen.png" style="width:10px;height:10px"></img></a>
													<a class="underline" href="javascript:deleteAction('.htmlentities($row['atmpart_id']).');">
														<img src="../resource/delete_icon.png" style="width:10px;height:10px"></img></a>
												</td>';
	}
	
    $msg .= "<tr>
								    <td class='tg-031e' style='text-align: right'>".$rNum."</td>
								    ".$strActionScript."
									<td class='tg-031e' style='text-align: left'>".htmlentities($row['atm_brand_sname'])."</td>
									<td class='tg-031e' style='text-align: left'>".htmlentities($row['jenispart_name'])."</td>
									<td class='tg-031e' style='text-align: left'>".htmlentities($row['atmpart_sn'])."</td>
									<td class='tg-031e' style='text-align: left'>".htmlentities($row['atmpart_source_tid'])."</td>
									<td class='tg-031e' style='text-align: left'>".htmlentities($row['atmpart_dest_tid'])."</td>
    								<td class='tg-031e' style='text-align: left'>".htmlentities($row['atmpart_keterangan'])."</td>
    								<td class='tg-031e' style='text-align: left;".$statusColor."'>".htmlentities($row['statuspart_name'])."</td>
								  </tr>";
    $rNum += 1;
} */
$msg = "<div class='data'>" . $msg . "</table></div>"; // Content for Data
//echo $msg;

/* --------------------------------------------- */
/* $query_pag_num = "SELECT COUNT(*) AS count FROM m_atm_sparepart WHERE atmpart_isactive = 1";
$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count']; */


$no_of_paginations = ceil($count / $per_page);

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
$goto = "<input type='text' class='goto' size='1' style='margin-top:-1px;margin-left:60px;'/><input type='button' id='go_btn' class='go_button' value='Go'/>";
$total_string = "<span class='total' a='$no_of_paginations'>Page <b>" . $cur_page . "</b> of <b>$no_of_paginations</b></span>";
$msg = $msg . "</ul>" . $goto . $total_string . "</div>";  // Content for pagination
echo $msg;
}

