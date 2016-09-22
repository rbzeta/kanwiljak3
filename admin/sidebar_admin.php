<?php 
$isUker = 0;

if (!empty($_SESSION['user_pn'])) {
	if ($_SESSION['user_uker']) {
		$isUker = 1;
	}
	$logged = "in";
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

function viewUserList(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_user_admin";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function viewStockMikrotik(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_stock_mikrotik";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function inputMaintenanceUKO(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "input_maintenance_uko";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function inputStockMikrotik(){
	var action = document.createElement("input");
	
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "input_stock_mikrotik";
    //alert(action.name);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}
</script>
</head>
<body>
<form action="../admin/dashboard_admin.php" method="post" style="margin:0px;" id="frmSideBar" name="frmSideBar">

		<div class="left">
		<h2>MENU ADMIN</h2>
		<div class="widget-content">
		<div id="accordion">
		<h3><a href="#">User Profile Maintenance</a></h3>
		<div>
			<ul class="link">
				<li style="display:block; padding-left:5px;" id="li_2"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:viewUserList();">View</a>
				</li>
			</ul>
		</div>
		</div>
		</div>
		</div>
</form>
</body>
</html>