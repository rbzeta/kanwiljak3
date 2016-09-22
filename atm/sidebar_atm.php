<?php 

$isUker = 0;
$isAdmin = 0;
if (!empty($_SESSION['user_pn'])) {
	$logged = "in";
	if ($_SESSION['user_uker']) {
		$isUker = 1;
	}
	if ($_SESSION['user_level_id'] == 99)
	{
		$isAdmin = 1;
	}
}
?>
<html>
<head>
<style type="text/css">
#body .left h2 {
		background: url("../resource/fade.png") repeat-x scroll left top #418CF0;
		border: 1px solid #D0D0D0;
		border-radius: 2px 2px 0 0;
		color: #ffffff;
		font-size: 14px;
		font-weight: 700;
		padding: 5px 15px;
		margin-bottom: 0px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		font-weight: bold;
	}

#body .left h3 {
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		font-weight: bolder;
	}
</style>
<script type="text/javascript">

function viewMaintenanceATM(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_maintenance_atm";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}
function viewJadwal(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_jadwal_atm";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}
function viewMasterATM(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_master_atm";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function viewSparepartATM(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_master_sparepart_atm";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function viewMasterProblem(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_master_problem_atm";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function viewProblemByTID(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_problem_tid_atm";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function inputMaintenanceATM(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "input_maintenance_atm";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function inputJadwal(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "input_jadwal_atm";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}
function inputSparepartATM(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "input_sparepart_atm";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function inputMasterATM(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "input_master_atm";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}
</script>
</head>
<body>
<form action="../atm/dashboard_atm.php" method="post" style="margin:0px;" id="frmSideBar" name="frmSideBar">

		<div class="left">
		<h2>MENU ATM</h2>
		<div class="widget-content">
		<div id="accordion">
		<?php 
				$msgHTML = '';
				if ($logged == "in") {
					$msgHTML .= '
		<h3><a href="#">Data Master ATM</a></h3>
		<div>
			<ul class="link">
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat(1)" src="../resource/collapse.gif" id="img_expand_1">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">Master</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_1"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:viewMasterATM();">View</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_1"> 
									&nbsp; 
									<img src="../resource/corner-dots.gif"> 
									<a style="background:url();padding-left:3px;" href="javascript:inputMasterATM();">Input Data</a>
								</li>
		</ul>
		</div>
				
					';
				}
				echo $msgHTML;
				?>
			
		<h3><a href="#">Data Maintenance</a></h3>
		<div>
			<ul class="link">
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('2')" src="../resource/collapse.gif" id="img_expand_2">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">Master</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_2"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:viewMaintenanceATM();">View</a>
				</li>
				<?php 
				$msgHTML = '';
				if ($logged == "in") {
					$msgHTML .= '<li style="display:block; padding-left:5px;" id="li_2"> 
									&nbsp; 
									<img src="../resource/corner-dots.gif"> 
									<a style="background:url();padding-left:3px;" href="javascript:inputMaintenanceATM();">Input Data</a>
								</li>';
					
				}
				echo $msgHTML;
				?>
			</ul>
		</div>
		<h3><a href="#">Jadwal Maintenance</a></h3>
		<div>
			<ul class="link">
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('2')" src="../resource/collapse.gif" id="img_expand_2">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">Jadwal</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_2"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:viewJadwal();">View Jadwal</a>
				</li>
				<?php 
				$msgHTML = '';
				if ($logged == "in" && $isAdmin) {
					$msgHTML .= '<li style="display:block; padding-left:5px;" id="li_2"> 
									&nbsp; 
									<img src="../resource/corner-dots.gif"> 
									<a style="background:url();padding-left:3px;" href="javascript:inputJadwal();">Input Jadwal</a>
								</li>';
					
				}
				echo $msgHTML;
				?>
			</ul>
		</div>
		<?php 
				$msgHTML = '';
				if ($logged == "in") {
					$msgHTML .= '
		<h3><a href="#">Data Problem ATM</a></h3>
		<div>
			<ul class="link">
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat(3)" src="../resource/collapse.gif" id="img_expand_3">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">Daftar Problem</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_3"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:viewMasterProblem();">View Recent</a>
				</li>
		<li style="display:block; padding-left:5px;" id="li_3"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:viewProblemByTID();">View Problem by TID</a>
				</li>
		</ul>
		</div>
				
					';
				}
				echo $msgHTML;
				?>
				
				<?php 
				$msgHTML = '';
				if ($logged == "in") {
					$msgHTML .= '
		<h3><a href="#">Data Sparepart ATM</a></h3>
		<div>
			<ul class="link">
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat(4)" src="../resource/collapse.gif" id="img_expand_4">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">Stock Sparepart</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_4"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:viewSparepartATM();">View</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_4"> 
									&nbsp; 
									<img src="../resource/corner-dots.gif"> 
									<a style="background:url();padding-left:3px;" href="javascript:inputSparepartATM();">Input Data</a>
								</li>
		</ul>
		</div>
				
					';
				}
				echo $msgHTML;
				?>
		</div>
		</div>
		</div>
</form>
</body>
</html>