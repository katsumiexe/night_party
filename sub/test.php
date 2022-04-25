<?
$connect=<<<CON
define("TABLE_KEY", "wp00000");
$mysqli = mysqli_connect("<?=$db?>","<?=$user?>","<?=$pass?>","<?=$dbn?>");

if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 
CON;

file_put_contents("./library/connect.php",$connect);
?>
