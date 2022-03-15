<?
/*
mail_hist
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

include_once('../../library/sql_post.php');

$c_id		=$_POST['c_id'];
$face		=$_POST['face'];
$midoku_flg	=$_POST['midoku'];

//$dat["midoku"]=0;
$dat["kidoku"]=0;
$now_view	=date("Y.m.d H:i",$now_time);

if($c_id){

/*
	if($midoku_flg){
		$sql	 ="SELECT mail_id FROM wp00000_easytalk";
		$sql	.=" WHERE customer_id='{$c_id}' AND cast_id='{$cast_data["id"]}'";
		$sql	.=" AND mail_del=0";
		$sql	.=" AND send_flg=1";
		$sql	.=" AND watch_date IS NULL";
		$sql	.=" AND (log <>'' OR img <>'')";
		$sql	.=" ORDER BY mail_id DESC";
		$sql	.=" LIMIT 1";
		$result = mysqli_query($mysqli,$sql);
		$row = mysqli_fetch_assoc($result);
		if(!$row["mail_id"]){
			$dat["kidoku"]=1;
		}

	}
*/

	$sql	 ="SELECT * FROM wp00000_easytalk";
	$sql	.=" WHERE customer_id='{$c_id}' AND cast_id='{$cast_data["id"]}'";
	$sql	.=" AND mail_del=0";
//	$sql	.=" AND send_flg=2";
	$sql	.=" AND watch_date IS NULL";
	$sql	.=" AND (log <>'' OR img <>'')";
	$sql	.=" ORDER BY mail_id DESC";
	$sql	.=" LIMIT 10";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){

			if($row["send_flg"] == 1){
				$kidoku_ck=1;

			}else{
				if (file_exists("../../img/cast/{$box_no}/m/{$row["img"]}.webp") && $admin_config["webp_select"] == 1) {
					$row["stamp"]="<img src=\"../img/cast/{$box_no}/m/{$row["img"]}.webp\" class=\"mail_box_stamp\" alt=\"easytalk_stamp\">";

				}elseif (file_exists("../../img/cast/{$box_no}/m/{$row["img"]}.png")) {
					$row["stamp"]="<img src=\"../img/cast/{$box_no}/m/{$row["img"]}.png\" class=\"mail_box_stamp\" alt=\"easytalk_stamp\">";
				}

				$html.="<div class=\"mail_box_a tl_append\">";		
				$html.="<div class=\"mail_box_face\">";
				$html.="<img src=\"{$face}\" class=\"mail_box_img\" alt=\"easytalk_icon\">";
				$html.="</div>";
				$html.="<div class=\"mail_box_log_1\">";
				$html.="<div class=\"mail_box_log_in\">";
				$html.=$row["log"];
				$html.="</div>";
				$html.=$row["stamp"];
				$html.="</div>";
				$html.="<span class=\"mail_box_date_a\">{$now_view}</span>";
				$html.="</div>";
			}
		}
	}

	if($html){
		$sql	 ="UPDATE wp00000_easytalk SET";
		$sql	.=" watch_date='{$now}'";
		$sql	.=" WHERE customer_id='{$c_id}' AND cast_id='{$cast_data["id"]}' AND watch_date IS NULL";
		mysqli_query($mysqli,$sql);
	}
}

if($midoku_flg && $kidoku_ck !=1){
	$dat["kidoku"]=1;
}

$sql	 ="SELECT COUNT(M.mail_id) AS cnt, M.customer_id, M.log, M.send_date FROM wp00000_easytalk AS M";
$sql	.=" LEFT JOIN wp00000_customer AS C ON (M.customer_id = C.id )";
$sql	.=" WHERE watch_date IS NULL";
$sql	.=" AND block<2";
$sql	.=" AND send_flg='2'";
$sql	.=" AND M.cast_id='{$cast_data["id"]}'";
$sql	.=" GROUP BY M.customer_id, M.log, M.send_date"; 

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$send_date	=substr(str_replace("-",".",$row["send_date"]),0,16);
		$dat["midoku"][$row["customer_id"]]=$send_date.$row["log"];
	}
}
 
$dat["html"]=$html;

echo json_encode($dat);
exit();
?>
