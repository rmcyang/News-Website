<!DOCTYPE html>
<head>
<meta charset="utf-8"/>
<title>Homepage</title>
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
<h1>News Website</h1>
<br>
<?php
require 'database.php';
session_start();
if (isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	printf("<h2>Hello %s, welcome!</h2>",
	   htmlentities($username)
	);
	?>
	<form action="logout.php" method="GET">
		<p><input type="submit" value="Logout" /></p>
	</form><br>
	<form action="newsEditor.php" method="GET">
		<p><input type="submit" value="Write News" /></p>
	</form>
	<?php
} else {
	echo "<h2>Hello guest, welcome!</h2>";
	?>
	<form name="login" action="loginCheck.php" method="POST">
		<p>
		<label>Login Port: </label>
		<label>Username: </label><input type="text" name="username" />
		<label>Password: </label><input type="password" name="password" />
		<input type="submit" value="Login" />
		</p>
	</form>
	<form name="register" action="register.html" method="GET">
		<p><label>New user? Register here: </label><input type="submit" value="Register" /></p>
	</form>
	<br>
	<?php
}
?>
<h2>Recent News:</h2>
<form action="sortByDate.php" method="POST">
	<p>
	<select name ="sortByDate">
		<option value ="none">choose</option>
		<option value ="newest">most recent</option>
		<option value ="oldest">least recent</option>
	</select>
	<input type="submit" value="Update">
	</p>
</form>
<?php
$qury = "select title, user_name, date, id from news order by date desc";
if (isset($_SESSION['sort']) && $_SESSION['sort'] == "oldest") {
	$qury = "select title, user_name, date, id from news order by date";
}
$stmt = $mysqli->prepare($qury);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();
$stmt->bind_result($database_title, $database_user_name, $database_date, $database_id);
echo "<table>\n";
while($stmt->fetch()) {
	echo "<tr>";
	printf("<td><b>%s</b><br>&nbsp;&nbsp;&nbsp;&nbsp;posted by %s&nbsp;&nbsp;&nbsp;&nbsp;%s<br><br></td>",
		htmlspecialchars($database_title),
		htmlspecialchars($database_user_name),
		htmlspecialchars($database_date)
	);
	?>
	<td>
	<form action="readNews.php" method="GET">
		<input type="hidden" name="newsId" value="<?php printf("%s", htmlspecialchars($database_id))?>" />
		<input type="submit" value="Read" />
	</form>
	</td>
	<?php
	if (isset($_SESSION['username']) && ($database_user_name == $_SESSION['username'])) {
		?>
		<td>
		<form name="news options" action="newsOptions.php" method="GET">
			<input type="submit" name="delete" value="Delete" />
			<input type="submit" name="edit" value="Edit" />
			<input type="hidden" name="id" value="<?php echo $database_id?>" />
		</form></td>
		<?php
	} else {
		echo "<td></td>";
	}
	echo "</tr>";
}
echo "</table>\n";
$stmt->close();
?>
</div></body>
</html>