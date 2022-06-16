<?
include_once('../library/sql.php');

$c_id		=$_POST['c_id'];
$cast_id	=$_POST['cast_id'];
$st			=($_POST['st']+0)*10;

$id_8=substr("00000000".$cast_id,-8);
$id_0	=$cast_id % 20;

for($n=0;$n<8;$n++){
	$tmp_id=substr($id_8,$n,1);
	$box_no2.=$dec[$id_0][$tmp_id];
}
	$box_no2.=$id_0;


$sql	 ="SELECT * FROM ".TABLE_KEY."_easytalk AS M";
$sql	.=" LEFT JOIN ".TABLE_KEY."_customer AS C ON M.customer_id=C.id";
$sql	.=" WHERE M.customer_id='{$c_id}' AND M.cast_id='{$cast_id}'";
$sql	.=" AND M.mail_del=0";
$sql	.=" AND (log <>'' OR img <>'')";
$sql	.=" ORDER BY mail_id DESC";
$sql	.=" LIMIT {$st},11";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$row["log"]=str_replace("\n","<br>",$row["log"]);
		$row["send_date"]=substr(str_replace("-",".",$row["send_date"]),0,16);

		if($row["watch_date"] =='0000-00-00 00:00:00'){
			$row["kidoku"]="<span class=\"midoku\">未読</span>";
			$row["new"]="<span class=\"mail_new\">NEW!</span>";

		}else{
			$row["kidoku"]="<span class=\"kidoku\">既読</span>";
			$row["bg"]=1;
		}

		if($row["img"]){
			$row["stamp"]="<img src=\"./img/cast/{$box_no2}/m/{$row["img"]}.png\" class=\"blog_img\">";
		}

		$dat[]=$row;
		$count_dat++;
	}
}

if($count_dat>10){
	$count_dat=10;
	$app="<div class=\"mail_detail_in_btm\">　</div>";
}

if (file_exists("../img/profile/{$cast_id}/0_s.webp")  && $admin_config["webp_select"] == 1) {
	$face="./img/profile/{$cast_id}/0_s.webp";			

}elseif (file_exists("../img/profile/{$cast_id}/0_s.jpg")){
	$face="./img/profile/{$cast_id}/0_s.jpg";			

}else{
	$face="./img/customer_no_image.png?t_".time();
}

for($n=0;$n<$count_dat;$n++){
	if($dat[$n]["send_flg"] == 1){
		if($dat[$n]["watch_date"] =="0000-00-00 00:00:00" && $dat[$n-1]["watch_date"] !="0000-00-00 00:00:00"){
		$html.="<div class=\"mail_border\">----------ここから新着--------------</div>";
		}

		$html.="<div class=\"mail_box_a\">";		


		$html.="<div class=\"mail_box_face\">";
		$html.="<img src=\"{$face}\" class=\"mail_box_img\">";
		$html.="</div>";
		$html.="<div class=\"mail_box_a_right\">";
		$html.="<span class=\"mail_box_date_a\">{$dat[$n]["send_date"]}　{$dat[$n]["new"]}</span>";
		$html.="<div class=\"mail_box_log_1\">";
		$html.="<div class=\"mail_box_log_in\">";
		$html.=$dat[$n]["log"];
		$html.="</div>";
		$html.=$dat[$n]["stamp"];
		$html.="</div>";
		$html.="</div>";
		$html.="</div>";

	}else{
		$html.="<div class=\"mail_box_b\">";
		$html.="<span class=\"mail_box_date_b\">{$dat[$n]["send_date"]}　{$dat[$n]["kidoku"]}</span>";
		$html.="<div class=\"mail_box_log_2 bg{$dat[$n]["bg"]}\">";
		$html.="<div class=\"mail_box_log_in\">";
		$html.=$dat[$n]["log"];
		$html.="</div>";
		$html.=$dat[$n]["stamp"];
		$html.="</div>";
		$html.="</div>";
	}
}
if($count_dat>0){
	$html.="<div class=\"mail_detail_in_btm\"></div>";
}

$sql	 ="UPDATE ".TABLE_KEY."_easytalk SET";
$sql	.=" watch_date='{$now}'";
$sql	.=" WHERE customer_id='{$c_id}'";
$sql	.=" AND cast_id='{$cast_id}'";
$sql	.=" AND watch_date='0000-00-00 00:00:00'";
$sql	.=" AND send_flg=1";
mysqli_query($mysqli,$sql);
echo $html;
exit();
?>
