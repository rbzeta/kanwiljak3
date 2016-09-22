<?php 
//Constant DB parameter
define("DBADDRESS", "1.132.218.71");
define("DBUSER", "sa");
define("DBPASSWORD", "P@ssw0rd");
define("DBNAME", "kanwiljak3");

function getConnection(){
	//try {
		// Create connection
		//$con = @mysqli_connect(DBADDRESS,DBUSER,DBPASSWORD,DBNAME);
		$con = new mysqli(DBADDRESS, DBUSER, DBPASSWORD, DBNAME);
		// Check connection
		//if (mysqli_connect_errno()) {
		//	throw new Exception("The system is under maintenance");
			
		//}
		
	//} catch (Exception $e) {
	//	echo $e->getMessage();
	//};
	return $con;
}


function getQueryResult($con,$query){
	//try {
		$result = mysqli_query($con, $query);
		
	//} catch (Exception $e) {
		
	//}
	return $result;
}

?>