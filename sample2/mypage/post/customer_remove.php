<?
include_once('../../library/sql_post.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$c_id		=$_POST["c_id"]+0;

$sql="UPDATE ".TABLE_KEY."_customer SET";
$sql.=" del='1'";
$sql.=" WHERE cast_id='{$cast_data["id"]}'";
$sql.=" AND id='{$c_id}'";
mysqli_query($mysqli,$sql);

exit();
?>
