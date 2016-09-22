<?php
include '../helper/ATM_DBHelper.php';
require '../config/DBConnect.php';

$mysqli = getConnection();
$tid = 1200;
$select_stmt = getATMProblemKeteranganByTID($mysqli, $tid);

?>
<head>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#999;}
.tg td{font-family:Arial, sans-serif;font-size:11px;padding:1px 3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#444;background-color:#F7FDFA;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#999;color:#fff;background-color:#26ADE4;}
.tg .tg-b286{background-color:#f56b00}
.tg .tg-xodn{font-weight:bold;background-color:#010066;color:#ffffff}

</style>

</head>
<body>

			<table class="tg">
			  <tr>
			    <th class="tg-b286" style="text-align: center" >TID</th>
			    <th class="tg-b286" style="text-align: left" >Date</th>
			    <th class="tg-b286" style="text-align: left" >Keterangan</th>
			  </tr>
<?php 
if ($select_stmt->num_rows >= 1) {

	$select_stmt->bind_result($atmproblem_tid,
							$atmproblem_creadt,
							$atmproblem_creausr,
							$atmproblem_keterangan);
	while ($select_stmt->fetch()){
		
		?>
		  <tr>
		    <td class="tg-031e" style="text-align: center" ><?php echo $atmproblem_tid?></td>
		    <td class="tg-031e" style="text-align: left" ><?php echo $atmproblem_creadt?></td>
		    <td class="tg-031e" style="text-align: left" ><?php echo $atmproblem_creausr.' : '.$atmproblem_keterangan?></td>
		  </tr>
		
<?php 			
	}	
}
?>
			</table>
</body>