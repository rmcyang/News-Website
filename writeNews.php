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
<?php
require 'database.php';
session_start();
$title = $_POST['title'];
$link = $_POST['link'];
$news = $_POST['news'];
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
if ((!isset($title) || trim($title)==='') || (!isset($news) || trim($news)==='')) {
    echo "<p>Invalid input. Please ensure that title and news cannot be empty or only whitespace.</p>";
    ?>
    <p>
    <form name="backToEditor" action="newsEditor.php" method="GET">
        <input type="submit" value="Back to Editor" />
    </form>
    </p>
    <?php
    exit;
} else {
    $stmt = $mysqli->prepare("SELECT id FROM users WHERE username=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $username);
    $username = $_SESSION['username'];
    $stmt->execute();
    $stmt->bind_result($database_user_id);
    $stmt->fetch();
    $userid = htmlspecialchars($database_user_id);
    $stmt->close();
    $stmt = $mysqli->prepare("insert into news (user_id, title, user_name, link, content) values (?, ?, ?, ?, ?)");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('sssss', $userid, $title, $username, $link, $news);
	$stmt->execute();
	$stmt->close();
	echo "The news posted successfully!";
    ?>
    <p>
	<form name="homepage" action="homepage.php" method="GET">
		<input type="submit" value="Back to homepage" />
	</form>
	</p>
    <?php
    exit;
}
?>
</div></body>
</html>