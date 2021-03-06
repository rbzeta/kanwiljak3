<?php
require '/helper/functionHelper.php';

sec_session_start();
echo session_name();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Protected Page</title>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body><?php foreach($_SESSION as $key => $value) {
    		echo  'Current session variable ' . $key . ' is: ' . $value . '<br />';
    	}
    	?>
        <?php if (login_check(getConnection()) == true) : ?>
            <p>Welcome <?php echo htmlentities($_SESSION['user_name']); ?>!</p>
            <p>
                This is an example protected page.  To access this page, users
                must be logged in.  At some stage, we'll also check the role of
                the user, so pages will be able to determine the type of user
                authorised to access the page.
            </p>
            <p>Return to <a href="login.php">login page</a></p>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>
    </body>
</html>