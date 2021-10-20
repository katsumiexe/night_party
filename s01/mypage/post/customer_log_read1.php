<?
include_once('../../library/sql_post.php');
$c_id		=$_POST["c_id"];
$sql	 ="SELECT * FROM wp00000_cast_log";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND customer_id='{$c_id}'";
$sql	.=" AND del='0'";
$sql	.=" ORDER BY log_id DESC";
$sql	.=" LIMIT 20";

$dat="<span class=\"customer_detail_in\"></span>";

if($result = mysqli_query($mysqli,$sql)){
	while($dat1 = mysqli_fetch_assoc($result)){
		$t_date=str_replace("-",".",$dat1["sdate"]);
		$s_time=$dat1["stime"];
		$e_time=$dat1["etime"];

		$dat1["log"]=str_replace("\n","<br>",$dat1["log"]);

		$dat.="<div class=\"customer_memo_log\">";
		$dat.="<div class=\"customer_memo_date\"><span class=\"customer_log_icon\"></span><span class=\"customer_log_date_detail\">{$t_date} {$s_time}-{$e_time}</span>";
		$dat.="<div id=\"l_chg{$dat1["log_id"]}\" class=\"customer_log_chg\"></div>";
		$dat.="<div id=\"l_del{$dat1["log_id"]}\" class=\"customer_log_del\"></div>";
		$dat.="</div>";

		$dat.="<div id=\"tr_log_detail{$dat1["log_id"]}\" class=\"customer_memo_log_in\">";
		$dat.="<div class=\"customer_log_memo\">";
		$dat.="{$dat1["log"]}";
		$dat.="</div>";

		$dat.="<div class=\"customer_log_item item_pts\" style=\"border:1px solid #606090; background:#606090; color:#fafafa;\">";
		$dat.="<span class=\"sel_log_icon_s\"></span>";
		$dat.="<span class=\"sel_log_comm_s\">利用総額</span>";
		$dat.="<span class=\"sel_log_price_s\">{$dat1["pts"]}</span>";
		$dat.="</div>";

		$dat.="<div class=\"customer_log_list\">";
		$sql	 ="SELECT * FROM wp00000_cast_log_list";
		$sql	.=" WHERE master_id='{$dat1["log_id"]}'";
		$sql	.=" ORDER BY wp00000_cast_log_list.id DESC";

		if($result2 = mysqli_query($mysqli,$sql)){
			while($dat3 = mysqli_fetch_assoc($result2)){
				$dat.="<div class=\"customer_log_item\" style=\"border:1px solid {$dat3["log_color"]}; color:{$dat3["log_color"]};\">";
				$dat.="<span class=\"sel_log_icon_s\">{$dat3["log_icon"]}</span>";
				$dat.="<span class=\"sel_log_comm_s\">{$dat3["log_comm"]}</span>";
				$dat.="<span class=\"sel_log_price_s\">{$dat3["log_price"]}</span>";
				$dat.="</div>";
			}
		}
		$dat.="</div>";
		$dat.="</div>";
	}

}
if($dat1["log_id"]){
	$dat.="<div style=\"height:5px\"></div><div id=\"customer_log_nodata\" class=\"customer_memo_nodata\"\">まだ何もありません</div>";
}
echo $dat;
exit();
?>
