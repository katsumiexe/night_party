<?
/*
MEMO2読み込み
*/
include_once('../../library/sql_post.php');

$c_id		=$_POST["c_id"];

$sql	 ="SELECT * FROM wp01_0customer_memo";
$sql	 .=" WHERE del=0";
$sql	 .=" AND customer_id='{$c_id}'";
$sql	 .=" AND `log` IS NOT NULL";
$sql	 .=" ORDER BY `date` DESC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$row["date"]=str_replace("-",".",$row["date"]);
		$row["date"]=substr($row["date"],0,16);

		$row["log"]=str_replace("\n","<br>",$row["log"]);

		$dat.="<div id=\"tr_memo_detail{$row["id"]}\" class=\"customer_memo_td1\">";
		$dat.="<div class=\"customer_memo_date\"><span class=\"customer_log_icon\"></span>{$row["date"]}</div>";
		$dat.="<div id=\"m_chg{$row["id"]}\" class=\"customer_memo_chg\"></div>";
		$dat.="<div id=\"m_del{$row["id"]}\" class=\"customer_memo_del\"></div>";
		$dat.="<span id=\"m_log{$row["id"]}\">{$row["log"]}</span>";
		$dat.="</div>";
	}
}


if(!$dat){
	$dat="<div id=\"customer_memo_nodata\" class=\"customer_memo_td1\" style=\"text-align:center;\"><br>まだ何もありません</div>";
}
echo $dat;
exit();
?>
