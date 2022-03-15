<?
/*
mail_hist
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

include_once('../../library/sql_post.php');

$page		=($_POST['page']+0)*20;
$send		=$_POST['send'];

if($send ==1){
	$app	 =" AND opt=0";
	$app	.=" AND block<2";
	$app	.=" AND mail<>''";
}

$dat["midoku"]=0;
$sql	 ="SELECT COUNT(M.mail_id) AS cnt, M.customer_id FROM wp00000_easytalk AS M";
$sql	.=" LEFT JOIN wp00000_customer AS C ON (M.customer_id = C.id )";
$sql	.=" WHERE watch_date IS NULL";

$sql	.=" AND block<2";
$sql	.=" AND send_flg='2'";
$sql	.=" AND M.cast_id='{$cast_data["id"]}'";
$sql	.=" GROUP BY M.customer_id"; 

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$dat["midoku"]++;
	}
}

if($dat["midoku"]>9){
	$dat["midoku"]="9+";
}

$sql	 ="SELECT M.customer_id, C.name, C.nickname, C.block, C.face, C.mail, C.prm, MAX(send_date) AS l_date, MAX(mail_id) AS m_id FROM wp00000_easytalk AS M";
$sql	 .=" LEFT JOIN wp00000_customer AS C ON M.customer_id=C.id AND C.cast_id=M.cast_id";
$sql	 .=" WHERE M.cast_id='{$cast_data["id"]}'";
$sql	 .=" AND mail_del=0";
$sql	 .=" AND C.del=0";
$sql	 .=$app;
$sql	 .=" GROUP BY M.customer_id";
$sql	 .=" ORDER BY l_date DESC";
$sql	 .=" LIMIT {$page}, 20";

$dat["sql"]	=$sql;

$n=0; 
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if(!$row["name"]){
			$row["name"]=$row["nickname"];
		}

		if(!$row["nickname"]){
			$row["nickname"]=$row["name"];
		}

		if (file_exists("../../img/cast/{$box_no}/c/{$row["face"]}.webp") && $admin_config["webp_select"] == 1) {
			$row["face"]="<img src=\"../img/cast/{$box_no}/c/{$row["face"]}.webp?t={$row["prm"]}\" class=\"mail_img\" alt=\"{$row["nickname"]}様\">";

		}elseif (file_exists("../../img/cast/{$box_no}/c/{$row["face"]}.png") ) {
			$row["face"]="<img src=\"../img/cast/{$box_no}/c/{$row["face"]}.png?t={$row["prm"]}\" class=\"mail_img\" alt=\"{$row["nickname"]}様\">";

		}else{
			$row["face"]="<img src=\"../img/customer_no_image.png\" class=\"mail_img\" alt=\"{$row["nickname"]}様\">";
		}

		$sql	 ="SELECT log, send_flg, watch_date FROM wp00000_easytalk";
		$sql	 .=" WHERE mail_id='{$row["m_id"]}'";
		$sql	 .=" ORDER BY mail_id DESC";
		$sql	 .=" LIMIT 1";

		$result2 = mysqli_query($mysqli,$sql);
		$row2 = mysqli_fetch_assoc($result2);
	
		if($row2["send_flg"] == 2 && !$row2["watch_date"]){
			$row["yet"]=1;
		}

		$row["send_flg"]=$row2["send_flg"];
		$row["log_p"]=$row2["log"];

		$row["last_date"]=date("Y.m.d H:i",strtotime($row["l_date"]));
		$html.="<div id=\"mail_hist{$row["customer_id"]}\" class=\"mail_hist {$row["mail_yet"]}\">";
		$html.="{$row["face"]}";
		$html.="<span class=\"mail_date\">{$row["last_date"]}</span>";
		$html.="<span class=\"mail_log\">{$row["log_p"]}</span>";
		$html.="<span class=\"mail_gp\"></span><span id=\"mail_nickname{$s}\" class=\"mail_nickname\">{$row["nickname"]}</span>";

		if($row["yet"]==1){
			$html.="<span class=\"mail_count\"></span>";
		}
		$html.="<input type=\"hidden\" class=\"mail_name\" value=\"{$row["name"]}\">";
		$html.="<input type=\"hidden\" class=\"mail_address\" value=\"{$row["mail"]}\">";
		$html.="<input type=\"hidden\" class=\"mail_block\" value=\"{$row["block"]}\">";
		$html.="</div>";
	}
}

if(!$html && $page == 0){
	$html.="<div class=\"no_data\">送信履歴はありません。</div>";
}
$dat["html"]=$html;
echo json_encode($dat);
exit();
?>
