<?php 
require '../helper/validateHelper.php';
require '../helper/functionHelper.php';
require '../config/DBConnect.php';

sec_session_start();

$logged = "";

if (login_check(getConnection()) == true) {
	$logged = 'in';
	$isUker = 0;
		if ($_SESSION['user_uker']) {
			$isUker = 1;
		}
	
	
	
} else {
	$logged = 'out';
	sec_session_destroy();
}


?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portal BRI Kanwil Jakarta 3</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portal BRI Kanwil Jakarta 3</title>
<script type="text/javascript" src="../css/jquery-1.6.4.min.js"></script>
<script src="../js/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="../css/utils.js"></script>
<script type="text/JavaScript" src="../js/forms.js"></script>
<style type="text/css">@import "../css/menu.css";</style>
<style type="text/css">@import "../css/table.css";</style>
<link rel="stylesheet" href="../js/jquery-ui-1.8.13/themes/base/jquery.ui.all.css"></link>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/jquery-1.5.1.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.accordion.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.datepicker.js"></script>

<style type="text/css">
.dashboardTiles
        {
           position:absolute;
           top:50%;
           left:35%; 

            /*Alternatively you could use: */
           /*
              position: fixed;
               bottom: 50%;
               right: 50%;
           */


        }
</style>
</head>

<body style="margin-top: 0px;margin-left: 0px;margin-right: 0px">
<div class="container">
	<div id="header">
<?php 
include 'header.php';
?>
	</div>
</div> 

			
		

<table border="0" align="center" >
<tr>
	<td align="center" colspan="4"><code>Download Firefox terbaru di 
	<a				class="underline"
					href="../files/Firefox_Setup_36.0.1.exe">sini</a>
	
	</code></td>
</tr>
<tr><td> </td></tr>
<tr>
	<td align="center"><a href="/kanwiljak3/edc/dashboard_edc.php"><img src="../resource/edc2.png" alt="Portal EDC BRI KW Jakarta 3" style="width:150px;height:150px"></img></a></td>
	<td align="center"><a href="/kanwiljak3/atm/dashboard_atm.php"><img src="../resource/images.jpg" alt="Portal ATM BRI KW Jakarta 3" style="width:150px;height:150px"></img></a></td>
	<td align="center"><a href="/kanwiljak3/uko/dashboard_uko.php"><img src="../resource/uko_logo_fix.jpg" alt="Portal UKO BRI KW Jakarta 3" style="width:150px;height:150px"></img></a></td>
	<?php 
	if($logged == "in"){
	if (!$isUker) {
		echo '<td align="center"><a href="/kanwiljak3/monbin/popup_token_monbin.php"><img src="../resource/monbin_tsi_logo_fix.jpg" alt="Portal UKO BRI KW Jakarta 3" style="width:150px;height:150px"></img></a></td>';
	}
	}?>
	
</tr>
<tr>
	<td align="center"><strong style="color: #0000ff; font-size: 14px;">Portal EDC</strong></td>
	<td align="center"><strong style="color: #0000ff; font-size: 14px;">Portal ATM</strong></td>
	<td align="center"><strong style="color: #0000ff; font-size: 14px;">Portal Unit Kerja</strong></td>
	<?php 
	if($logged == "in"){
	if (!$isUker) {
		echo '<td align="center"><strong style="color: #0000ff; font-size: 14px;">Monbin TSI</strong></td>';
	}
	}?>
</tr>

</table>
</body>
</html>
