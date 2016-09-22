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
function openCrudEDCBrilink(){
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
	form =document.getElementById('frmSideBar');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "openmenubrilinkview";
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
    action.value = "openmenumerchantview";
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
    action.value = "openmenuuko";
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
</script>
</head>
<body>
<form action="../edc/dashboard_edc.php" method="post" style="margin:0px;" id="frmSideBar" name="frmSideBar">

		<div class="left">
		<h2>MENU EDC</h2>
		<div class="widget-content">
		<div id="accordion">
		<h3><a href="#">Data Master</a></h3>
		<div>
			<ul class="link">
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('2')" src="../resource/collapse.gif" id="img_expand_2">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">TIPE EDC</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_2"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:openCrudEDCUKO();">EDC UKO</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_2"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:openCrudEDCMerchant();">EDC Merchant</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_2"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:openCrudEDCBrilink();">EDC Brilink</a>
				</li>
			</ul>
		</div>
		<!-- <h3><a href="#">Report</a></h3>
		<div>
			<ul class="link">
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('3')" src="../resource/collapse.gif" id="img_expand_3">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">EDC MERCHANT RITEL</a>
				</li>
													<li style="display:block; padding-left:5px;" id="li_3"> 
						&nbsp; 
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/0">All</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_3"> 
						&nbsp; 
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="#">EDC Transaction</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_3"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/6">Bulanan</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_3"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/7">Mingguan</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_3"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/8">Search by date</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_3"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/get_ranking_nom">Ranking</a>
					</li>
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('4')" src="../resource/collapse.gif" id="img_expand_4">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">EDC MERCHANT CHAIN</a>
				</li>
													<li style="display:block; padding-left:5px;" id="li_4"> 
						&nbsp; 
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/0">All</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_4"> 
						&nbsp; 
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="#">EDC Transaction</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_4"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/6">Bulanan</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_4"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/7">Mingguan</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_4"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/8">Search by date</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_4"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/get_ranking_nom">Ranking</a>
					</li>
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('5')" src="../resource/collapse.gif" id="img_expand_5">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">EDC BRILINK RITEL</a>
				</li>
													<li style="display:block; padding-left:5px;" id="li_5"> 
						&nbsp; 
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/0">All</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_5"> 
						&nbsp; 
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="#">EDC Transaction</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_5"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/6">Bulanan</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_5"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/8">Search by date</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_5"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/get_ranking_nom">Ranking</a>
					</li>						
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('6')" src="../resource/collapse.gif" id="img_expand_6">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">EDC BRILINK MIKRO</a>
				</li>
													<li style="display:block; padding-left:5px;" id="li_6"> 
						&nbsp; 
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/0">All</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_6"> 
						&nbsp; 
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="#">EDC Transaction</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_6"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/6">Bulanan</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_6"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/8">Search by date</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_6"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/get_ranking_nom">Ranking</a>
					</li>	
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('7')" src="../resource/collapse.gif" id="img_expand_7">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">EDC UKO</a>
				</li>
													<li style="display:block; padding-left:5px;" id="li_7"> 
						&nbsp; 
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/0">All</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_7"> 
						&nbsp; 
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="#">EDC Transaction</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_7"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/6">Bulanan</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_7"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/report_edc/8">Search by date</a>
					</li>
																	<li style="display:block; padding-left:5px;" id="li_7"> 
						&nbsp; &nbsp; &nbsp;
						<img src="../resource/corner-dots.gif"> 
						<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/report/get_ranking_nom">Ranking</a>
					</li>		
			</ul>
		</div>
		<h3><a href="#">Chart</a></h3>
		<div>
			<ul class="link">
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('8')" src="../resource/collapse.gif" id="img_expand_8">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">EDC TRANSACTION</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_8"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/merchant/view">EDC Kanwil</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_8"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/brilink/view">EDC Per Cabang</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_8"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/brilink_mikro/view">Perbandingan Cabang</a>
				</li>
			</ul>
		</div>-->
		<h3><a href="#">Lain-lain</a></h3>
		<div>
			<ul class="link">
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('9')" src="../resource/collapse.gif" id="img_expand_9">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">Complaint</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_9"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:viewComplaintTiket();">View Complaint</a>
				</li>
				<li>
					<img style="margin-right:5px;" onclick="javascript:expand_cat('3')" src="../resource/collapse.gif" id="img_expand_3">
					<a style="background:url(); padding-left:0; color:#306AFD !important;" href="#">Lap. Maintenance</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_3"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="javascript:viewMaintenanceEDC();">View Maintenance</a>
				</li>
				<!--  <li style="display:block; padding-left:5px;" id="li_9"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/brilink/view">Penarikan EDC</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_9"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/brilink_mikro/view">SP EDC</a>
				</li>
				<li style="display:block; padding-left:5px;" id="li_9"> 
					&nbsp; 
					<img src="../resource/corner-dots.gif"> 
					<a style="background:url();padding-left:3px;" href="http://2.131.177.53/edcmalang/index.php/brilink_mikro/view">Lap. Maintenance</a>
				</li>-->
			</ul>
		</div>
		</div>
		</div>
		</div>
</form>
</body>
</html>