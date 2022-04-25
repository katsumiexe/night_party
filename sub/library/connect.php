<?
define("TABLE_KEY", "TBL");
$mysqli = mysqli_connect("localhost","bjonvdlh","MkcuE8E.S#9y77","bjonvdlh_db");
if(!$mysqli){
	$msg="接続エラー";	
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 
?>
