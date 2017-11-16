<!DOCTYPE html>
<head>
<meta charset="utf-8"/>
<title>loginCheck</title>
<style type="text/css">
body{
	width: 760px; /* how wide to make your web page */
	background-color: teal; /* what color to make the background */
	margin: 0 auto;
	padding: 0;
	font:12px/16px Verdana, sans-serif; /* default font */
}
div#main{
	background-color: #FFF;
	margin: 0;
	padding: 10px;
}
</style>
</head>
<body><div id="main">
<?php
// This is a *good* example of how you can implement password-based user authentication in your web application.

require 'database.php';

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), id, salted_hash_pass FROM users WHERE username=?");

// Bind the parameter
$stmt->bind_param('s', $user);
$user = $_POST['username'];
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();

$pwd_guess = $_POST['password'];
// Compare the submitted password to the actual password hash

if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
	// Login succeeded!
    session_start();
	$_SESSION['username'] = $user;
	$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
	header("Location: homepage.php");
	exit;
} else{
    echo "<p>Username does not exist or password is not correct.</p>";
    ?>
    <p>
	<form name="backToHomepage" action="homepage.php" method="GET">
		<input type="submit" value="Back to homepage" />
	</form>
	</p>
    <?php
	exit;
}
?>
</div></body>
</html>