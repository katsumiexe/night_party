<?
/*
MEMO2読み込み
*/
include_once('../../library/sql_post.php');

$c_id		=$_POST["c_id"];

$sql	 ="SELECT * FROM wp00000_customer_memo";
$sql	 .=" WHERE del=0";
$sql	 .=" AND customer_id='{$c_id}'";
$sql	 .=" AND `log` IS NOT NULL";
$sql	 .=" ORDER BY `date` DESC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$row["date"]=str_replace("-",".",$row["date"]);
		$row["date"]=substr($row["date"],0,16);

		$row["log"]=str_replace("\n","<br>",$row["log"]);

		$dat.="<div class=\"customer_memo_log\">";
		$dat.="<div class=\"customer_memo_date\"><span class=\"customer_log_icon\"></span>{$row["date"]}";
		$dat.="<div id=\"m_chg{$dat1["log_id"]}\" class=\"customer_log_chg\"></div>";
		$dat.="<div id=\"m_del{$dat1["log_id"]}\" class=\"customer_log_del\"></div>";
		$dat.="</div>";
		$dat.="<div id=\"tr_log_detail{$dat1["log_id"]}\" class=\"customer_memo_log_in\">";
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
