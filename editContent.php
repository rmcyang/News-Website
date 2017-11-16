<!DOCTYPE html>
<head>
<meta charset="utf-8"/>
<title>Re-edit Content</title>
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
session_start();
$newsId = $_SESSION['newsId'];
$content = $_POST['content'];
if ((!isset($content) || trim($content)==='')) {
    echo "<p>Content cannot be empty or only whitespace.</p>";
} else {   
    $stmt = $mysqli->prepare("update news set content=? where id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('ss', $content, $newsId);
	$stmt->execute();
	$stmt->close();
	echo "<p>The news content was edited successfully!</p>";
}
?>
<p>
<form name="backToHomepage" action="homepage.php" method="GET">
    <input type="submit" value="Back to homepage" />
</form>
</p>
</div></body>
</html>