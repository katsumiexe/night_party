<?
include_once('./sample1/library/sql.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/



$sql	 ="UPDATE sheet SET";



if($log || $img_code){

$sql	 ="SELECT I.cast_id, I.customer_id, C.nickname, A.login_id, A.login_pass, C.name, S.mail,C.opt,C.infom FROM ".TABLE_KEY."_ssid AS I";
$sql	.=" LEFT JOIN ".TABLE_KEY."_staff AS S ON I.cast_id=S.staff_id";
$sql	.=" LEFT JOIN ".TABLE_KEY."_cast AS A ON I.cast_id=A.id";
$sql	.=" LEFT JOIN ".TABLE_KEY."_customer AS C ON I.customer_id=C.id";
$sql	.=" WHERE ssid='{$sid}'";
$sql	.=" LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$dat = mysqli_fetch_assoc($result);
}
if(!$dat["nickname"]) {
	$dat["nickname"]=$dat["name"];
}

//box_no----------------------------------------
$id_8=substr("00000000".$dat["cast_id"],-8);
$id_0	=$dat["cast_id"] % 20;

for($n=0;$n<8;$n++){
	$tmp_id=substr($id_8,$n,1);
	$box_no2.=$dec[$id_0][$tmp_id];
}
$box_no2.=$id_0;


}
exit();
?>
