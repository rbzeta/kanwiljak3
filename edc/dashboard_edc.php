<?php
require '../helper/validateHelper.php';
require '../helper/functionHelper.php';
require '../config/DBConnect.php';
require '../config/SUperGlobalVar.php';
require '../helper/DBHelper.php';
require '../helper/EDC_DBHelper.php';

sec_session_start();

$logged = "";

if (login_check(getConnection()) == true) {
	$logged = 'in';
	
} else {
	$logged = 'out';
	sec_session_destroy();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portal BRI Kanwil Jakarta 3</title>
<script type="text/javascript" src="../css/jquery-1.6.4.min.js"></script>
<script src="../js/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="../css/utils.js"></script>
<script type="text/JavaScript" src="../js/forms.js"></script>
<style type="text/css">@import "../css/menu.css";</style>
<link rel="stylesheet" href="../js/jquery-ui-1.8.13/themes/base/jquery.ui.all.css"></link>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/jquery-1.5.1.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.accordion.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.datepicker.js"></script>
<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 10px 30px 50px 30px;
		/* font: 13px/20px normal Helvetica, Arial, sans-serif; */
		color: #4F5155;
	}

	a {
		text-decoration: none;
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}
	
	a.underline {
		text-decoration: underline;
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 18px;
		font-weight: normal;
		margin: 0px;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Segoe UI Semibold, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	#body .left {
		float: left;
		width: 235px;
		margin-bottom: 20px;
	}
	
	#body .right {
		float: left;
		width: 1050px;
		/*margin-left: 20px;*/
		margin: 20px 0 0 20px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		/*border-top: 1px solid #D0D0D0;*/
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 10px 0 0 0;
		clear:both;
	}
	
	p.copyright{
		text-align: right;
		font-size: 11px;
		line-height: 10px;
		padding: 0 10px 0 10px;
		margin: 2px 0 ;
		clear:both;
	}
	
	p.bestview{
		text-align: left;
		font-size: 11px;
		line-height: 10px;
		padding: 0 10px 0 10px;
		margin: 2px 0 ;
		clear:both;
	}
	
	#container{
		margin: 0 auto;
		width: 1150px;
		background-color:#FFFFFF;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	
	#container_top{
		margin: 0 auto;
		width: 1150px;
	}
	
	#container_bottom{
		margin: 0 auto;
		width: 1150px;
	}
	
	#header_tid_txt {
		font: 12px/20px normal Segoe UI Semibold, Arial, sans-serif;
		border: 1px solid #D0D0D0;
		padding: 4px;
		color: #002166;
		background-color: #ffffff;
	}
	
	#header_tid_btn {
		font: 12px/20px normal Segoe UI Semibold, Arial, sans-serif;
		border: 1px solid #D0D0D0;
		padding: 4px;
		color: #002166;
		background-color: #ffffff;
	}

	#header_tid_txt:focus, #header_tid_btn:focus {
		background-color: #ffffff;
		border: 1px solid #D0D0D0;
	}
	
	#login {
		background: url('../assets/img/bg_images.png') no-repeat scroll 3px -130px transparent; 
		width: 20px; 
		height: 20px; 
		float:left; 
		margin-top: 10px;
		margin-right: 5px
	}
	
	.link {
		margin: -15px;
		padding-left: 0px;
		list-style: none outside none;
		line-height: 1.5;
	}
	
	.link li a {
		text-decoration: none;
		color: #878787;
		font-size: 11px;
		font-weight: 700;
	}
	
	
	
	#body .left .widget-content {
		border: 1px solid #dddddd;
		padding: 10px 10px 15px;
	}
.ui-widget {
	font-family: Segoe UI Semibold, Arial !important;
}
</style>
<script type="text/javascript">
function expand_cat(ids) {
	var m = document.getElementById("img_expand_"+ids).getAttribute("src");
	var trs = document.getElementsByTagName('ul.link');
	
	if(m == '../resource/collapse.gif'){
		document.getElementById("img_expand_"+ids).setAttribute("src","../resource/expand.gif");
	}else{
		document.getElementById("img_expand_"+ids).setAttribute("src","../resource/collapse.gif");
	}
	
	var trul = $('ul.link');
	var li_length = trul.children().length;
	var i = 0;
	
	trul.children().each(function() {
		var kid = $(this);
		if(kid.attr('id') != undefined) {
			var li_id = kid.attr('id').split('_');
			if(li_id[1] == ids) {
				var li_display = kid.css('display');
				(li_display == 'none') ? kid.css('display','block') : kid.css('display','none');
			}
		}
	});
	
}
$(function() {
	$( "#accordion" ).accordion({
		collapsible: true,
		//heightStyle: "content",
		autoHeight: false,
					active: 3 
	});
});
</script>
</head>

<body style="margin-top: 0px;margin-left: 0px;margin-right: 0px">
<div class="container">
	<div id="header">
	<?php 
	include '../global/header.php';
	?>
	</div>
<div id="body">	
	<?php 
	if ($logged == "in") {
		include 'sidebar_edc_login.php';;
	}else include 'sidebar_edc.php';
	
	$action=$tid="";
	if (!empty($_POST['action'])) {
		$action = $_POST['action'];
	}
	
	if ($logged == "in" && $action == "") {
		include 'default_edc.php';
	}elseif ($action == "") include 'default_edc.php';
	
	if ($action != "") {
		switch ($action) {
			case "opentidmerchant":
				include 'report_detil_merchant_tid.php';
				break;
			case "opentiduko":
				include 'report_detil_uko_tid.php';
				break;
			case "opentidbrilink":
				include 'report_detil_brilink_tid.php';
				break;
			case "openmenubrilinkview":
				include 'upd_brilink_edc.php';
				break;
// 			case "openmenubrilinkritel":
// 				include 'crud_brilinkritel_edc.php';
// 				break;
			case "openmenumerchantview":
				include 'upd_merchant_edc.php';
				break;
// 			case "openmenumerchantritel":
// 				include 'crud_merchantritel_edc.php';
// 				break;
			case "openmenuuko":
				include 'upd_uko_edc.php';
				break;
			case "input_edc_uko_finish":
				include 'upd_uko_edc.php';
				break;
			case "input_edc_merchant_finish":
				include 'upd_merchant_edc.php';
				break;
			case "input_edc_brilink_finish":
				include 'upd_brilink_edc.php';
				break;
			case "openmenuukoinput":
				include 'upd_uko_edc.php';
				break;
			case "openmenumerchantinput":
				include 'upd_merchant_edc.php';
				break;
			case "opentidmerchantinputedit":
				include 'upd_merchant_edit_edc.php';
				break;
			case "openmenubrilinkinput":
				include 'upd_brilink_edc.php';
				break;
			case "opentidbrilinkinputedit":
				include 'upd_brilink_edit_edc.php';
				break;
			case "openmenuukoinput":
				include 'upd_uko_edc.php';
				break;
			case "opentidukoinputedit":
				include 'upd_uko_edit_edc.php';
				break;
			case "inputcomplainttiket":
				include 'input_complaint_edc.php';
				break;
			case "input_maintenance_edc":
				include 'input_maintenance_edc.php';
				break;
			case "input_edc_uko":
				include 'input_uko_edc.php';
				break;
			case "input_edc_merchant":
				include 'input_merchant_edc.php';
				break;
			case "input_edc_brilink":
				include 'input_brilink_edc.php';
				break;
							
			case "view_maintenance_edc":
				include 'view_maintenance_edc.php';
				break;
			case "view_stock_edc_kanwil":
				include 'view_stock_edc_kanwil.php';
				break;
			case "view_verif_uko_edc":
				include 'view_verif_uko_edc.php';
				break;
			case "view_verif_brilink_edc":
				include 'view_verif_brilink_edc.php';
				break;
			case "view_verif_merchant_edc":
				include 'view_verif_merchant_edc.php';
				break;
			case "viewcomplainttiket":
				include 'view_complaint_edc.php';
				break;
			case "view_maintenance_edc":
				include 'view_maintenance_edc.php';
				break;
			case "replycomplainttiket":
				include 'reply_complaint_edc.php';
				break;
			case "openreportbytid":
				include 'report_detil_tid_controller.php';
				break;
			case "replycomplaintbytid":
				include 'reply_complaint_edit_edc.php';
				break;
			default:
				include 'default_edc.php';;
				break;
		};
	}
		
	?>
</div>
</div>
</body>
</html>

