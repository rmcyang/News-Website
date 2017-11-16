<?php
session_start();
$sort = $_POST['sortByDate'];
$_SESSION['sort'] = $sort;
header("Location: homepage.php");
//if ($_POST['sortBydate'] == "newest") {
//	$_SESSION['sortBydate'] = 'ASC';
//} 
//elseif ($_POST['sortBydate'] == "oldest") {
//	$_SESSION['sortBydate'] = 'DESC';
//}
//header("Location: homepage.php");
//exit;
?>