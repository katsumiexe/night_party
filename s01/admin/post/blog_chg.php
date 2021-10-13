<?
include_once('../../library/sql_post_admin.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/


$id				=$_POST["id"];
$del			=$_POST["del"];
$date			=$_POST["date"];
$status			=$_POST["status"];
$title			=$_POST["title"];
$tag			=$_POST["tag"];
$log			=$_POST["log"];
$img_code		=$_POST["img_code"];
$img_del		=$_POST["img_del"];


if($del == 4){
	$sql="UPDATE wp01_0posts SET ";
	$sql.="status='4'";
	$sql.=" WHERE id='{$id}'";
}else{

	$sql="UPDATE wp01_0posts SET ";
	$sql.="view_date='{$date}',";
	$sql.="status='{$status}',";
	$sql.="title='{$title}',";
	$sql.="log='{$log}',";
	$sql.="img_del='{$img_del}'";
	$sql.=" WHERE id='{$id}'";
}


mysqli_query($mysqli,$sql);

echo $sql;
exit();
?>
