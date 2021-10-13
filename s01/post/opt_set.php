<?
/*
mail_hist
*/
include_once('../library/sql.php');

$ss			=$_POST['ss'];
$ck			=$_POST['ck'];

$id_8=substr("00000000".$cast_id,-8);
$id_0	=$cast_id % 20;

for($n=0;$n<8;$n++){
	$tmp_id=substr($id_8,$n,1);
	$box_no2.=$dec[$id_0][$tmp_id];
}
	$box_no2.=$id_0;

$sql	 ="UPDATE wp01_0customer SET";
$sql	.=" opt='{$ck}'";
$sql	.=" WHERE customer_id='{$c_id}'";
$sql	.=" AND cast_id='{$cast_id}'";
mysqli_query($mysqli,$sql);
echo $html;
exit();
?>
