<html>
<head>
<style type="text/css">
	a {
		text-decoration: none;
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		font: 13px/20px Segoe UI Semibold, Arial, sans-serif;
	}
	
	a.underline {
		text-decoration: underline;
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		font: 13px/20px Segoe UI Semibold, Arial, sans-serif;
	}
	
	.fontLogin {
		text-decoration:none;
		font-family:"Segoe UI Semibold", Verdana, Arial;
		font-size:10pt;
		font-weight: bold;
		color: black;
	}
/*body { 
 background-image: url("../resource/a.png");
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: full;
}*/
</style>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="left" class="style4" bgcolor="#00509a"> 
		<div style="font-size:28px;  color:#FFFFFF;font-weight:bold; ">
			<label style="padding-left: 40px;">Bank Rakyat Indonesia </label>
			</div>
		<div style="font-size:18px;  color:#FFFFFF; font-weight:bold;">
			<label style="padding-left: 40px;">Portal Kanwil Jakarta 3 </label>
		</div>
		</td>
		
	</tr>
	<tr>
		<td>
		<table cellpadding="2" width="100%" border="0" cellspacing="0" bgcolor="ff980A">
			<tr><?php 
				if (empty($_SESSION["user_name"])) {
					?>
				<td align="right" ><a href="../index.php">Dashboard</a>	
  			      | <a href="../login/login.php">User Login</a>	
  			      | <a href="../register/register.php">User Registrasi</a> &nbsp; 
				</td>
					<?php 
				}
			else { ?>
				<td align="left" class="fontLogin">Selamat Datang, <b><?php echo $_SESSION["user_name"]?></b>	
  			      | <a href="../login/logout.php" onclick="return konfirmasi('Anda yakin ingin logout?')">Logout</a>	
  			      | <a href="../admin/setting.php">Pengaturan</a>	
  			      | <a href="../index.php">Dashboard</a> &nbsp; 
				</td>
				<?php } ?>
			</tr>
		</table>
		</td>
	</tr>
</table>
</body>
</html>