<!DOCTYPE html>
<head>
<meta charset="utf-8"/>
<title>Re-edit Comment</title>
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
$commentId = $_SESSION['commentId'];
$comment = $_POST['comment'];
if ((!isset($comment) || trim($comment)==='')) {
    echo "<p>Comment cannot be empty or only whitespace.</p>";
} else {   
    $stmt = $mysqli->prepare("update comments set content=? where id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('ss', $comment, $commentId);
	$stmt->execute();
	$stmt->close();
	echo "<p>Your comment was edited successfully!</p>";
}
?>
<p>
<form name="backToNews" action="readNews.php" method="GET">
    <input type="submit" value="Back to News" />
    <input type="hidden" name="newsId" value="<?php echo $newsId;?>"/>
</form>
</p>
</div></body>
</html>