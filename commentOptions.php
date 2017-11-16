<!DOCTYPE html>
<head>
<meta charset="utf-8"/>
<title>Edit Comment</title>
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
$commentId = $_GET['id'];
$_SESSION['commentId'] = $commentId;
$newsId = $_SESSION['newsId'];
if (isset($_GET['delete'])) {
    $stmt = $mysqli->prepare("delete from comments where id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('s', $commentId);
	$stmt->execute();
	$stmt->close();
    header("Location: readNews.php");
    exit;
}
if (isset($_GET['edit'])) {
    $stmt = $mysqli->prepare("select content from comments where id=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $commentId);
    $stmt->execute();
    $stmt->bind_result($database_content);
    $stmt->fetch();
    $comment = htmlspecialchars($database_content);
}
?>
<h3>Edit the comment here: </h3>
<form name="Comment Editor" action="editComment.php" method="POST">
	<p>
	<textarea name = "comment" rows="25" cols="100">
        <?php echo $comment?>
    </textarea><br>
	<input type= "submit" value="Update"/>
	<p>
</form>
<form name="backToNews" action="readNews.php" method="GET">
	<p><input type="submit" value="Cancel" /></p>
</form>
</div></body>
</html>