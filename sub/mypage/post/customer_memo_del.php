<?
/*
メモ削除
				'memo_id'	:Del_ID,
				'flg'		:Flg
*/

include_once('../../library/sql_post.php');
$memo_id	=$_POST["memo_id"];
$flg		=$_POST["flg"];



if($flg == "memo"){
	$sql ="UPDATE ".TABLE_KEY."_customer_memo SET";
	$sql.=" `del`='1'";
	$sql.=" WHERE id='{$memo_id}'";
	mysqli_query($mysqli,$sql);

}elseif($flg == "log"){

	$sql ="UPDATE ".TABLE_KEY."_cast_log SET";
	$sql.=" `del`='1'";
	$sql.=" WHERE log_id='{$memo_id}'";
	mysqli_query($mysqli,$sql);

	$sql ="UPDATE ".TABLE_KEY."_cast_log_list SET";
	$sql.=" `del`='1'";
	$sql.=" WHERE master_id='{$memo_id}'";
	mysqli_query($mysqli,$sql);

}elseif($flg == "mail"){
	$sql ="UPDATE ".TABLE_KEY."_easytalk SET";
	$sql.=" `log`='この投稿は削除されました。',";
	$sql.=" `mail_del`='1'";
	$sql.=" WHERE mail_id='{$memo_id}'";
	mysqli_query($mysqli,$sql);
}


echo $sql;
exit();
?>
