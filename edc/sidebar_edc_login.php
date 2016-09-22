<?php 

$isUker = 0;
if (!empty($_SESSION['user_pn'])) {
	if ($_SESSION['user_uker']) {
			$isUker = 1;
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
		font: 13px/20px normal Segoe UI Semibold, Arial, sans-serif;
		font-weight: bold;
	}

#body .left h3 {
		font: 13px/20px normal Segoe UI Semibold, Arial, sans-serif;
		font-weight: bolder;
	}
</style>
<script type="text/javascript">
function openCrudEDCBrilink(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "openmenubrilinkinput";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function openCrudEDCMerchant(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "openmenumerchantinput";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}
function openCrudEDCUKO(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "openmenuukoinput";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function inputComplaintTiket(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "inputcomplainttiket";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function inputMaintenanceEDC(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "input_maintenance_edc";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function inputEDCUKO(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "input_edc_uko";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function inputEDCMerchant(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "input_edc_merchant";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function inputEDCBrilink(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "input_edc_brilink";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function viewMaintenanceEDC(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_maintenance_edc";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function viewStockEDCKanwil(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_stock_edc_kanwil";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function viewComplaintTiket(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "viewcomplainttiket";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function replyComplaintTiket(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "replycomplainttiket";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function verifEDCUKO(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_verif_uko_edc";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function verifEDCBrilink(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_verif_brilink_edc";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}

function verifEDCMerchant(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_verif_merchant_edc";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
}
</script>
</head>
<body>
<form action="../edc/dashboard_edc.php" method="post" style="margin:0px;" id="frmSideBar" name="frmSideBar">

		<div class="left">
		<h2>MENU EDC</h2>
		<div class="widget-content">
		<div id="accordion">
		<!--h3><a href="#">Verifikasi</a></h3>
		<div>
			<ul class="link">
			<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('6')" src="../resource/collapse.gif" id="img_expand_6">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">EDC</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_6"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:verifEDCUKO();">UKO</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_6"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:verifEDCBrilink();">BRILINK</a>
				</li>	
				<li style="display:block; padding-left:5px;" id="li_6"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:verifEDCMerchant();">MERCHANT</a>
				</li>
			</ul>
		</div-->
		<h3><a href="#">Data Master</a></h3>
		<div>
			<ul class="link">
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('1')" src="../resource/collapse.gif" id="img_expand_2">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">DATA EDC</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_1"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:openCrudEDCUKO();">EDC UKO</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_1"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:openCrudEDCMerchant();">EDC Merchant</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_1"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:openCrudEDCBrilink();">EDC Brilink</a>
				</li>
			</ul>
			<p>
			<ul class="link">
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('2')" src="../resource/collapse.gif" id="img_expand_1">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">Input Data EDC</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_2"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:inputEDCUKO();">EDC UKO</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_2"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:inputEDCMerchant();">EDC Merchant</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_2"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:inputEDCBrilink();">EDC Brilink</a>
				</li>
			</ul>
		</div>
		<h3><a href="#">Complaint</a></h3>
		<div>
			<ul class="link">
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('3')" src="../resource/collapse.gif" id="img_expand_4">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">Complaint</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_3"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:inputComplaintTiket();">Create Ticket</a>
				</li>
				<?php 
				if (!$isUker){
					echo '<li style="display:block; padding-left:5px;" id="li_3">
					&nbsp;
					<img src="../resource/corner-dots.gif">
					<a style="background:url();padding-left:3px;" href="javascript:replyComplaintTiket();">Reply Ticket</a>
					</li>';
				}
				?>
				
				<li style="display:block; padding-left:5px;" id="li_3"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:viewComplaintTiket();">View Ticket</a>
				</li>																
			</ul>
		</div>
		<h3><a href="#">Maintenance</a></h3>
		<div>
			<ul class="link">
			<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('4')" src="../resource/collapse.gif" id="img_expand_3">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">Lap. Maintenance</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_4"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:inputMaintenanceEDC();">Create</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_4"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:viewMaintenanceEDC();">View Maintenance</a>
				</li>	
			</ul>
		</div>
		 <?php 
 				if (!$isUker){
 $lima=5;
 echo '
		<h3><a href="#">Stock Management</a></h3>
		<div>
			<ul class="link">
			<li>
			<img style="margin-right:5px;" onclick="javascript:expand_cat("5")" src="../resource/collapse.gif" id="img_expand_5">
			<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">Manajemen Stock</a>
			</li>
			<li style="display:block; padding-left:5px;" id="li_5">
			&nbsp;
			<img src="../resource/corner-dots.gif">
			<a style="background:url();padding-left:3px;" href="javascript:viewStockEDCKanwil();">Stock EDC Kanwil</a>
			</li>
			<li style="display:block; padding-left:5px;" id="li_5">
			&nbsp;
			<img src="../resource/corner-dots.gif">
			<a style="background:url();padding-left:3px;" href="javascript:viewMaintenanceEDC();">Stock Masuk</a>
			</li>
			<li style="display:block; padding-left:5px;" id="li_5">
			&nbsp;
			<img src="../resource/corner-dots.gif">
			<a style="background:url();padding-left:3px;" href="javascript:viewMaintenanceEDC();">Stock Keluar</a>
			</li>
			</ul>
		</div>
				';
		}
	?>
		</div>
		</div>
		</div>
</form>
</body>
</html>