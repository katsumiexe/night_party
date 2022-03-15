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
$img_url		="../../img/profile/".$_POST["img_url"];


if($del == 4){
	$sql="UPDATE wp00000_posts SET ";
	$sql.="status='4',";
	$sql.="img=''";
	$sql.=" WHERE id='{$id}'";
	unlink($img_url.".png");
	unlink($img_url."_s.png");
	unlink($img_url.".webp");
	unlink($img_url."_s.webp");

}else{

	if($img_del ==2){
		$app="img='',";
		unlink($img_url.".png");
		unlink($img_url."_s.png");
		unlink($img_url.".webp");
		unlink($img_url."_s.webp");
	}

	$sql="UPDATE wp00000_posts SET ";
	$sql.="view_date='{$date}',";
	$sql.="status='{$status}',";
	$sql.="title='{$title}',";
	$sql.=$app;
	$sql.="log='{$log}',";
	$sql.="img_del='{$img_del}'";
	$sql.=" WHERE id='{$id}'";
}


mysqli_query($mysqli,$sql);

echo $sql;
exit();
?>
