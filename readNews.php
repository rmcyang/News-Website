<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>News Reader</title>
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
if (isset($_GET['newsId'])) {
	$newsId = $_GET['newsId'];
	$_SESSION['newsId'] = $newsId;
} else {
	$newsId = $_SESSION['newsId'];
}
$stmt = $mysqli->prepare("select title, user_name, date, link, content from news where id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $newsId);
$stmt->execute();
$stmt->bind_result($database_title, $database_user_name, $database_date, $database_link, $database_content);
$stmt->fetch();
printf("<h2>%s</h2><h3>Owner: %s</h3><h3>%s</h3><h3>Source: %s</h3><br><p>%s</p>",
		htmlspecialchars($database_title),
		htmlspecialchars($database_user_name),
        htmlspecialchars($database_date),
        htmlspecialchars($database_link),
        htmlspecialchars($database_content)
);
$stmt->close();
?>
<br>
<?php
if (isset($_SESSION['username'])) {
	?>
	<h3>Make a comment:</h3>
	<form name="Comment Editor" action="makeComment.php" method="POST">
		<p>
		<textarea name = "comment" rows="5" cols="100"></textarea><br>
		<input type= "submit" value="Comment"/>
		</p>
	</form>
	<?php
}
?>
<h3>Comments:</h3>
<?php
$stmt = $mysqli->prepare("select id, viewer, date, content from comments where news_id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $newsId);
$stmt->execute();
$stmt->bind_result($database_id, $database_viewer, $database_comment_date, $database_comment);
echo "<table>";
while($stmt->fetch()){
	echo "<tr>";
	printf("<td>%s said on %s: <br>&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;%s</td>",
			htmlspecialchars($database_viewer),
			htmlspecialchars($database_comment_date),
			htmlspecialchars($database_comment)
	);
	if (isset($_SESSION['username']) && ($database_viewer == $_SESSION['username'])) {
		?>
		<td>
		<form name="comment options" action="commentOptions.php" method="GET">
			<input type="submit" name="delete" value="Delete" />
			<input type="submit" name="edit" value="Edit" />
			<input type="hidden" name="id" value="<?php echo $database_id?>" />
		</form>
		</td>
		<?php
	} else {
		echo "<td></td>";
	}
	echo "</tr>";
}
echo "</table>";
$stmt->close();
?>
<form name="backToHomepage" action="homepage.php" method="GET">
	<p><input type="submit" value="Back to homepage" /></p>
</form>
</div></body>
</html>