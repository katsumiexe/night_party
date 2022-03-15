<?
/*
mail_hist
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

include_once('../library/sql.php');

$c_id		=$_POST['c_id'];
$cast_id	=$_POST['cast_id'];
$face		=$_POST['face'];
$midoku_flg	=$_POST['midoku'];

$dat["kidoku"]=0;
$now_view	=date("Y.m.d H:i",$now_time);

//box_no----------------------------------------
$id_8=substr("00000000".$cast_id,-8);
$id_0	=$cast_id % 20;

for($n=0;$n<8;$n++){
	$tmp_id=substr($id_8,$n,1);
	$box_no2.=$dec[$id_0][$tmp_id];
}
$box_no2.=$id_0;

if($c_id){
	if($midoku_flg){
		$sql	 ="SELECT mail_id FROM wp00000_easytalk";
		$sql	.=" WHERE customer_id='{$c_id}' AND cast_id='{$cast_id}'";
		$sql	.=" AND mail_del=0";
		$sql	.=" AND send_flg=2";
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


	$sql	 ="SELECT * FROM wp00000_easytalk";
	$sql	.=" WHERE customer_id='{$c_id}' AND cast_id='{$cast_id}'";
	$sql	.=" AND mail_del=0";
	$sql	.=" AND send_flg=1";
	$sql	.=" AND watch_date IS NULL";
	$sql	.=" AND (log <>'' OR img <>'')";
	$sql	.=" ORDER BY mail_id DESC";
	$sql	.=" LIMIT 10";

	$now=date("Y.m.d H:i");
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$now_view=date("Y.m.d H:i",strtotime($row["send_date"]));

			if (file_exists("../img/cast/{$box_no2}/m/{$row["img"]}.webp") && $admin_config["webp_select"] == 1) {
				$row["stamp"]="<./img src=\"img/cast/{$box_no2}/m/{$row["img"]}.webp\" class=\"mail_box_stamp\" alt=\"easytalk_stamp\">";

			}elseif (file_exists("../img/cast/{$box_no2}/m/{$row["img"]}.png")) {
				$row["stamp"]="<img src=\"./img/cast/{$box_no2}/m/{$row["img"]}.png\" class=\"mail_box_stamp\" alt=\"easytalk_stamp\">";
			}

			$html.="<div class=\"mail_box_a tl_append\" style=\"display:none\">";		
			$html.="<div class=\"mail_box_face\">";
			$html.="<img src=\"{$face}\" class=\"mail_box_img\" alt=\"easytalk_icon\">";
			$html.="</div>";
			$html.="<div class=\"mail_box_a_right\">";
			$html.="<span class=\"mail_box_date_a\">{$now_view}</span>";
			$html.="<div class=\"mail_box_log_1\">";
			$html.="<div class=\"mail_box_log_in\">";
			$html.=str_replace("\n","<br>",$row["log"]);
			$html.="</div>";
			$html.=$row["stamp"];
			$html.="</div>";
			$html.="</div>";
			$html.="</div>";




		}
	}

	if($html){
		$sql	 ="UPDATE wp00000_easytalk SET";
		$sql	.=" watch_date='{$now}'";
		$sql	.=" WHERE customer_id='{$c_id}' AND cast_id='{$cast_id}' AND watch_date IS NULL";
		mysqli_query($mysqli,$sql);
	}
}

$dat["html"]=$html;
echo json_encode($dat);
exit();
?>
