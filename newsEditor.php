<!DOCTYPE html>
<head>
<meta charset="utf-8"/>
<title>News Editor</title>
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
<h1>News Editor</h1>
<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("Location: homepage.php");
	exit;
}
$username = $_SESSION['username'];
?>
<form name="News Editor" action="writeNews.php" method="POST">
	<p>
	<label>Title: </label><input type = "text" name="title"/><br><br>
	<label>Link: </label><input type = "text" name="link"/><br><br>
	Write news:
	<textarea name = "news" rows="25" cols="100"></textarea><br>
	<input type= "submit" value="Post"/>
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
	</p>
</form>
<form name="backToHomepage" action="homepage.php" method="GET">
	<p><input type="submit" value="Back to homepage" /></p>
</form>
</div></body>
</html>