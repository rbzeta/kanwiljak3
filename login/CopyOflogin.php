<html>
<head>
</head>
<body onLoad="document.getElementById('username').focus();">
	<div class="form_right">
		<table style="width: 350px; margin-left: auto; margin-right: auto;">
			<tr>
				<td class="logo"><img alt=""
					src="http://bristars.bri.co.id/bristars/Image/bristars.PNG"
					width="100%" height="70" /></td>
			</tr>
			<tr>
			<td>
					<form name="loginForm" method="post"
						action="http://bristars.bri.co.id/bristars/login">
						<fieldset class="fieldset-login">
							<legend class="legend-login" align="left">
								<h3>LOGIN</h3>
							</legend>
							<table style="margin-left: auto; margin-right: auto;">
								<tr>
									<td width="105px" align="right"><span style="font-size: 13px;">Personal
											Number</span></td>
									<td width="5px"></td>
									<td width="210px"><input type="text" id="inputUserid"
										name="inputUserid" size="25px" /></td>
								</tr>
								<tr>
									<td width="105px" align="right"><span style="font-size: 13px;">Password</span>
									</td>
									<td width="5px"></td>
									<td width="210px"><input type="password" id="inputPassword"
										name="inputPassword" size="25px" /></td>
								</tr>
								<tr>
									<td colspan=3></td>
								</tr>
								<tr>
									<td width="100px"></td>
									<td width="10px"></td>
									<td width="210px" align="left"><input type="submit"
										value="login" class="art-button" id="btnLogin" name="btnLogin" />
									</td>
								</tr>
							</table>
						</fieldset>
					</form>
				</td>
			</tr>
		</table>
	</div>
</body>

</html>
