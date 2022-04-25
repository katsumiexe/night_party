<?
include_once('../../library/sql_post.php');

$page_id=$_POST["page_id"];

if($page_id == "99"){
	$_SESSION="";
	session_destroy();
}else{
	$_SESSION["cast_page"]	=$page_id;
}
exit();
?>
