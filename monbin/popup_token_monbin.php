<?php 
?>
<html>
<head>
<script>
function myFunction() {
	var token = prompt("Masukan Token, Hubungi bagian E-Channel & TSI untuk meminta Token.");
    if (token != null && token.length > 0) {
    	redirectPageToken('verify_token_monbin',token);
    }else
        redirectPage('cancel_token_monbin');
}

function redirectPage(controlID){
	var action = document.createElement("input");
	// Add the new element to our form. 
	form =document.getElementById('frmSearch');
	    
	form.appendChild(action);
	action.name = "action";
	action.type = "hidden";
	action.value = controlID;
	form.submit();
}

function redirectPageToken(controlID,tokenValue){
	var action = document.createElement("input");
	var p = document.createElement("input");
	// Add the new element to our form. 
	form =document.getElementById('frmSearch');
	    
	form.appendChild(action);
	form.appendChild(p);
	
	action.name = "action";
	action.type = "hidden";
	action.value = controlID;

	p.name = "p";
	p.type = "hidden";
	p.value = tokenValue;
	
	form.submit();
}
</script>
</head>
<body onload="myFunction()">
<form action="../monbin/verify_token_monbin.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch">
</form>
</body>
</html>