<?
/*
mail_hist
*/
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
include_once('../../library/sql_post.php');

$c_id		=$_POST['c_id'];
$st			=($_POST['st']+0)*10;


$sql	 ="SELECT sort,title FROM ".TABLE_KEY."_easytalk_tmpl";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" ORDER BY sort DESC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tmpl[$row["sort"]]=$row["title"];	
	}
}

$sql	 ="SELECT block, opt FROM ".TABLE_KEY."_customer";
$sql	.=" WHERE id='{$c_id}'";
$sql	.=" AND del=0";

if($result	= mysqli_query($mysqli,$sql)){
	$row	= mysqli_fetch_assoc($result);
	$block	=$row["block"];	
	$opt	=$row["opt"];	
}

$sql	 ="SELECT * FROM ".TABLE_KEY."_easytalk AS M";
$sql	.=" LEFT JOIN ".TABLE_KEY."_customer AS C ON M.customer_id=C.id";
$sql	.=" WHERE M.customer_id='{$c_id}' AND M.cast_id='{$cast_data["id"]}'";
$sql	.=" AND M.mail_del=0";
$sql	.=" AND (log <>'' OR img <>'')";
$sql	.=" ORDER BY mail_id DESC";
$sql	.=" LIMIT {$st},11";

if($st == 0){
if($block >1){
	$html.="<div class=\"mail_box_b new_set\"><div class=\"mail_box_new_ng\">";
	$html.="<div class=\"mail_box_new_msg2\"><span class=\"mail_box_icon\"></span>メッセージは送信できません</div></div></div>";

}elseif($opt==1){
	$html.="<div class=\"mail_box_b new_set\"><div class=\"mail_box_new_ng\">";
	$html.="<div class=\"mail_box_new_msg2\"><span class=\"mail_box_icon\"></span>受信を拒否されています</div></div></div>";

}else{
	$html.="<div class=\"mail_box_b new_set\"><div class=\"mail_box_new\">";
	$html.="<div class=\"mail_box_new_msg\"><span class=\"mail_box_icon\"></span>メッセージの作成<div class=\"mail_box_new_del\">×</div></div>";
	$html.="<div class=\"mail_box_new_in\">";
	$html.="<div class=\"mail_box_new_log_out\"><textarea id=\"easytalk_text\" class=\"mail_box_new_log\"></textarea></div>";

if($block ==1){
	$html.="<img src=\"../img/blog_no_image_out.png\" class=\"mail_box_new_img\">";
}else{
	$html.="<img id=\"easytalk_img\" src=\"../img/blog_no_image.png\" class=\"mail_box_new_img\">";

}
	$html.="<div class=\"mail_box_new_tmpl\">";
	$html.="<div id=\"tmpl_list0\" class=\"mail_box_new_list\">{$tmpl[0]}</div>";
	$html.="<div id=\"tmpl_list1\" class=\"mail_box_new_list\">{$tmpl[1]}</div>";
	$html.="<div id=\"tmpl_list2\" class=\"mail_box_new_list\">{$tmpl[2]}</div>";
	$html.="<div id=\"tmpl_list3\" class=\"mail_box_new_list\">{$tmpl[3]}</div>";
	$html.="<div id=\"tmpl_list4\" class=\"mail_box_new_list\">{$tmpl[4]}</div>";
	$html.="</div>";
	$html.="<button id=\"easytalk_send\" class=\"mail_box_new_btn\"><span class=\"mail_box_icon\"></span>メッセージを送信する</button>";
	$html.="</div></div>";
	$html.="<div class=\"filter_err\"></div>";
	$html.="</div>";
}
}

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$row["log"]=str_replace("\n","<br>",$row["log"]);
		$row["send_date"]=substr(str_replace("-",".",$row["send_date"]),0,16);

		if(!$row["watch_date"]){
			$row["kidoku"]="<span class=\"midoku\">未読</span>";
			$row["new"]="<span class=\"mail_new\">NEW!</span>";

		}else{
			$row["kidoku"]="<span class=\"kidoku\">既読</span>";
			$row["bg"]=1;
		}

		if($row["img"]){
			$row["stamp"]="<img src=\"../img/cast/{$box_no}/m/{$row["img"]}.png\" class=\"mail_box_stamp\">";
		}

		$dat[]=$row;
		$count_dat++;
	}
}

if($count_dat>10){
	$count_dat=10;
	$app="<div class=\"mail_detail_in_btm\">　</div>";
}

if (file_exists("../../img/cast/{$box_no}/c/{$dat[0]["face"]}.webp") && $admin_config["webp_select"] == 1) {
	$face="../img/cast/{$box_no}/c/{$dat[0]["face"]}.webp?t={$row["prm"]}";

}elseif (file_exists("../../img/cast/{$box_no}/c/{$dat[0]["face"]}.png") ) {
	$face="../img/cast/{$box_no}/c/{$dat[0]["face"]}.png?t={$row["prm"]}";

}else{
	$face="../img/customer_no_image.png";
}
	$html.="<input type=\"hidden\" id=\"hidden_face\" value=\"{$face}\">";

for($n=0;$n<$count_dat;$n++){
	if($dat[$n]["send_flg"] == 2){
		$html.="<div class=\"mail_box_a\">";		
		$html.="<div class=\"mail_box_face\">";
		$html.="<img src=\"{$face}\" class=\"mail_box_img\" alt=\"{$dat[0]["nickname"]}様\">";
		$html.="</div>";
		$html.="<div class=\"mail_box_log_1\">";
		$html.="<div class=\"mail_box_log_in\">";
		$html.=$dat[$n]["log"];
		$html.="</div>";
		$html.=$dat[$n]["stamp"];
		$html.="</div>";
		$html.="<span class=\"mail_box_date_a\">{$dat[$n]["new"]}{$dat[$n]["send_date"]}</span>";
		$html.="</div>";

		if(!$dat[$n]["watch_date"] && $dat[$n+1]["watch_date"]){
		$html.="<div class=\"mail_border\"><div class=\"mail_border_l\"></div><div class=\"mail_border_in\">ここから新着</div></div>";
		}

	}else{

		$html.="<div id=\"mail_box_{$dat[$n]["mail_id"]}\" class=\"mail_box_b\">";
		$html.="<div class=\"mail_box_log_2 bg{$dat[$n]["bg"]}\">";
		$html.="<div class=\"mail_box_log_in\">";
		$html.=$dat[$n]["log"];
		$html.="</div>";
		$html.=$dat[$n]["stamp"];

		$html.="</div>";
		$html.="<span class=\"mail_box_date_b\">{$dat[$n]["kidoku"]}　{$dat[$n]["send_date"]}</span>";
		$html.="<span id=\"m_del{$dat[$n]["mail_id"]}\" class=\"mail_box_del\">× 削除</span>";
		$html.="</div>";

	}
}
$html.=$app;

$sql	 ="UPDATE ".TABLE_KEY."_easytalk SET";
$sql	.=" watch_date='{$now}'";
$sql	.=" WHERE customer_id='{$c_id}'";
$sql	.=" AND cast_id='{$cast_data["id"]}'";
$sql	.=" AND watch_date IS NULL";
$sql	.=" AND send_flg=2";
//mysqli_query($mysqli,$sql);
echo $html;
exit();
?>
