<!DOCTYPE html>
<head>
<meta charset="utf-8"/>
<title>RegisterCheck</title>
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
require 'database.php';
$username = $_POST['username'];
$password = $_POST['password'];
$repeatPassword = $_POST['repeatPassword'];
if(!preg_match('/^[\w_\.\-]+$/', $username) ){
	echo "Invalid username, username should only be consisted by letters and numbers.";
	?>
	<p>
	<form name="register" action="register.html" method="POST">
		<input type="submit" value="Back to register page" />
	</form>
	</p>
	<?php
	exit;
}
$stmt = $mysqli->prepare("select username from users");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();
$stmt->bind_result($databaseUsername);
while($stmt->fetch()){
	$compare = strcmp($username, htmlspecialchars($databaseUsername));
	if ($compare == 0) {
		echo "Username exists already, please try another username.";
		?>
		<p>
		<form name="register" action="register.html" method="POST">
			<input type="submit" value="Back to register page" />
		</form>
		</p>
		<?php
		exit;
	}
}
$stmt->close();
$compare = strcmp($password, $repeatPassword);
if ($compare == 0) {
	$stmt = $mysqli->prepare("insert into users (username, salted_hash_pass) values (?, ?)");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('ss', $username, password_hash($password, PASSWORD_BCRYPT));
	$stmt->execute();
	$stmt->close();
	echo "Successfully registered!";
	?>
	<p>
	<form name="homepage" action="homepage.php" method="POST">
		<input type="submit" value="Back to homepage" />
	</form>
	</p>
	<?php
	exit;
} else {
	echo "Your passwords input do not match.";
	?>
	<p>
	<form name="register" action="register.html" method="POST">
		<input type="submit" value="Back to register page" />
	</form>
	</p>
	<?php
	exit;
}
?>
</div></body>
</html>