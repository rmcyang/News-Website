<!DOCTYPE html>
<head>
<meta charset="utf-8"/>
<title>Edit Content</title>
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
$newsId = $_GET['id'];
$_SESSION['newsId'] = $newsId;
if (isset($_GET['delete'])) {
    $stmt = $mysqli->prepare("delete from comments where news_id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $newsId);
	$stmt->execute();
	$stmt->close();
    $stmt = $mysqli->prepare("delete from news where id=?");
    if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
    $stmt->bind_param('s', $newsId);
	$stmt->execute();
	$stmt->close();
    header("Location: homepage.php");
    exit;
}
if (isset($_GET['edit'])) {
    $stmt = $mysqli->prepare("select content from news where id=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $newsId);
    $stmt->execute();
    $stmt->bind_result($database_content);
    $stmt->fetch();
    $content = htmlspecialchars($database_content);
}
?>
<h3>Edit the content here: </h3>
<form name="Content Editor" action="editContent.php" method="POST">
	<p>
	<textarea name = "content" rows="25" cols="100">
        <?php echo $content?>
    </textarea><br>
	<input type= "submit" value="Update"/>
	</p>
</form>
<form name="backToHomepage" action="homepage.php" method="GET">
	<p><input type="submit" value="Cancel" /></p>
</form>
</div></body>
</html>