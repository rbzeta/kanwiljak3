<?php 
//include_once 'register.inc.php';
require '../helper/functionHelper.php';
require '../config/DBConnect.php';

 
sec_session_start();
 
$logged = "";

if (login_check(getConnection()) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
//echo $logged;

?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>BRI Kanwil Jakarta 3</title>
  <link rel="stylesheet" href="../css/style-login.css">
  <script type="text/JavaScript" src="../js/sha512.js"></script> 
  <script type="text/javascript" src="../css/utils.js"></script>
  <script type="text/JavaScript" src="../js/forms.js"></script>
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <script type="text/javascript">
	function disabledKCList(formName,elInput,elToDisable){
		
		document.getElementById(elToDisable).disabled = true;
	}
	function enabledKCList(formName,elInput,elToDisable){
		
		document.getElementById(elToDisable).disabled = false;
	}
  </script>
</head>
<body>
<?php 
if ($logged == "in") {
	// Unset all session values
	$_SESSION = array();
	
	// get session parameters
	$params = session_get_cookie_params();
	
	// Delete the actual cookie.
	setcookie(session_name(),
	'', time() - 42000,
	$params["path"],
	$params["domain"],
	$params["secure"],
	$params["httponly"]);
	
	// Destroy session
	session_destroy();
}

try {
	$con = getConnection();
	if (!empty($con)) {

		$lstBranch = getQueryResult($con,"select 0 as branch_id,0 as branch_mbcode,'---- Pilih Unit Kerja ----' as branch_name 
										union all 
										SELECT distinct branch_id ,branch_mbcode,concat(branch_mbcode,' - ',branch_mbname) as branch_name FROM m_branch WHERE branch_mbcode = branch_code order by branch_mbcode");

	}
}catch (Exception $e){

}

?>
  <section class="container">
    <div class="login">
      <?php 
      if (isset($_GET['error'],$_SESSION['registration_error'])) {
      	echo '<h2 class="error">'.$_SESSION['registration_error'].'</h2>';
      	?>
      	<h1>Form Registrasi</h1>
      	<form method="post" action="register.inc.php" name="frmLogin">
      	<!-- p><input type="text" id="username" name="username" value="" placeholder="Nama User"></p-->
      	<p><input type="text" id="pn" name="pn" value="<?php echo $_SESSION['reg_pn'];?>"  onkeypress="return numbersonly(this, event)"></p>
      		<p><input type="password" id="password" name="password" value="" placeholder="Password"></p>
      		<p><input type="password" name="confirmpwd" name="confirmpwd" id="confirmpwd" value="" placeholder="Konfirm Password"></p>
      		<p><input type="text" id="userlname" name="userlname" value="<?php echo $_SESSION['reg_username'];?>" placeholder="Nama Lengkap"></p>
      		<p><input type="text" id="jabatan" name="jabatan" value="<?php echo $_SESSION['reg_jabatan'];?>" placeholder="Jabatan"></p>
      		<p><input type="text" id="email" name="email" value="<?php echo $_SESSION['reg_email'];?>" placeholder="E-mail"></p>
      		<?php 
      		$kanwilCek=$kancaCek="";
      		if ($_SESSION['reg_iskanca'] == 1){
      			$kancaCek = "checked";
      			
      		}else {
      			$kanwilCek = "checked";
      			
      		}
      		?>
      		<p><input type="radio" id="uker" name="uker" value="kanwil" onclick="javascript:disabledKCList('frmLogin','uker','lstKC');"
      			  <?php echo $kanwilCek?>/>Kanwil
        	<input type="radio" id="uker" name="uker" value="kanca" onclick="javascript:enabledKCList('frmLogin','uker','lstKC');"
        	      <?php echo $kancaCek?>/>Kanca</p>
        <p>
      	    <select name="lstKC" id="lstKC">
      	    <?php
      	    while ($row = $lstBranch->fetch_assoc()){
      	
	      	    unset($id, $name);
	      		$id = $row['branch_id'];
	      		$name = $row['branch_name'];
	      		if($id == $_SESSION['reg_idkanca']){
								echo '<option value="'.$id.'" selected>'.$name.'</option>';
	      		}else echo '<option value="'.$id.'">'.$name.'</option>';
      		}
      		?>
      	    	</select>
      	        </p>
      	        
      	        
      	        <!-- p class="remember_me">
      	          <label>
      	            <input type="checkbox" name="remember_me" id="remember_me">
      	            Ingat saya di komputer ini
      	          </label>
      	        </p-->
      	        <p class="submit"><input type="button" id="commit" name="commit" value="Register" 
      	        onclick="return regformhash(this.form,
      	                                   this.form.userlname,
      	                                   this.form.password,this.form.confirmpwd,
      	                                   this.form.pn,this.form.jabatan,this.form.email,
      	                                   this.form.uker,this.form.lstKC);"></p>
      	      </form>
      <?php 
      }else {
      ?>
      <h1>Form Registrasi</h1>
      <form method="post" action="register.inc.php" name="frmLogin">
        <!-- p><input type="text" id="username" name="username" value="" placeholder="Nama User"></p-->
        <p><input type="text" id="pn" name="pn" value="" placeholder="Personal Number" onkeypress="return numbersonly(this, event)"></p>
        <p><input type="password" id="password" name="password" value="" placeholder="Password"></p>
        <p><input type="password" name="confirmpwd" name="confirmpwd" id="confirmpwd" value="" placeholder="Konfirm Password"></p>
       	<p><input type="text" id="userlname" name="userlname" value="" placeholder="Nama Lengkap"></p>
        <p><input type="text" id="jabatan" name="jabatan" value="" placeholder="Jabatan"></p>
        <p><input type="text" id="email" name="email" value="" placeholder="E-mail"></p>
        <p><input type="radio" id="uker" name="uker" value="kanwil" onclick="javascript:disabledKCList('frmLogin','uker','lstKC');"/>Kanwil 
        <input type="radio" id="uker" name="uker" value="kanca" onclick="javascript:enabledKCList('frmLogin','uker','lstKC');"/>Kanca</p>
        <p>
        <select name="lstKC" id="lstKC">
   				<?php 
   					 while ($row = $lstBranch->fetch_assoc()){
    
						unset($id, $name);
						$id = $row['branch_id'];
						$name = $row['branch_name'];
						if($id == $recKC){
							echo '<option value="'.$id.'" selected>'.$name.'</option>';
						}else echo '<option value="'.$id.'">'.$name.'</option>';
						
					}
				?>
    	</select>
        </p>
        
        
        <!-- p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Ingat saya di komputer ini
          </label>
        </p-->
        <p class="submit"><input type="button" id="commit" name="commit" value="Register" 
        onclick="return regformhash(this.form,
                                   this.form.userlname,
                                   this.form.password,this.form.confirmpwd,
                                   this.form.pn,this.form.jabatan,this.form.email,
                                   this.form.uker,this.form.lstKC);"></p>
      </form>
      <?php 
      }?>
    </div>

    <div class="login-help">
      <p><a href="../login/login.php">Login</a></p>
    </div>
  </section>
</body>
</html>
