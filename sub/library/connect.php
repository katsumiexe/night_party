<?
define("TABLE_KEY", "NP");
$mysqli = mysqli_connect("mysql57.night-party.sakura.ne.jp","night-party","npnp0000","night-party_np");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 
?>
