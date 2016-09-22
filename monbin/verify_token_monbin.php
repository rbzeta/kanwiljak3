<?php 
include_once '../helper/functionHelper.php';
require '../config/DBConnect.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.

$action="";
?>


<html>
<head>
<script type="text/javascript">

function redirectPage(controlID){
	var action = document.createElement("input");
	//Add the new element to our form. 
	form =document.getElementById('frmSearch');
	 
	form.appendChild(action);
	action.name = "action";
	action.type = "hidden";
	action.value = controlID;
	form.submit();
}
</script>
</head>
<body>
<form action="../monbin/verify_token_monbin.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch">
</form>
<?php 
if (!empty($_POST['action'])) {
	$action = $_POST['action'];
}

if (!empty($action)) {
	switch ($action) {
		case "cancel_token_monbin":
			header('Location: ../index.php');
			session_write_close();
			break;
		case "verify_token_monbin":
			if (isset($_POST['p'])) {
					
				$tokenValue = $_POST['p'];

				if (tokenIsVerified($tokenValue,getConnection())) {
					header('Location: ../monbin/dashboard_monbin.php');
					session_write_close();
				}else {
					echo "<script type='text/javascript'>
						alert('Invalid Token ID.');
						var action = document.createElement('input');
						//Add the new element to our form.
						form =document.getElementById('frmSearch');
					
						form.appendChild(action);
						action.name = 'action';
						action.type = 'hidden';
						action.value = 'invalid_token_monbin';
						form.submit();
					  </script>";
						
				}
			}
			break;
		case "invalid_token_monbin":
			header('Location: ../index.php');
			session_write_close();
			break;

	};

}else {

	header('Location: ../index.php');
	session_write_close();
}

?>

</body>
</html>
