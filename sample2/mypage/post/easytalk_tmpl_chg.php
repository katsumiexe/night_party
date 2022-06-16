<?
include_once('../../library/sql_post.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$id				=$_POST['id'];
$title			=$_POST['title'];
$log			=$_POST['log'];


$sql	 ="UPDATE ".TABLE_KEY."_easytalk_tmpl SET";
$sql	.=" title='{$title}',";
$sql	.=" log='{$log}'";
$sql	.=" WHERE cast_id={$cast_data["id"]}";
$sql	.=" AND sort={$id}";
mysqli_query($mysqli,$sql);
exit();
?>


