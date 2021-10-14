<?
/*
通常ページ　CAST読み込み
*/
include_once('../library/sql.php');

$sort=array();
$date		=$_POST['date'];

$sql  ="SELECT id, tag_name, tag_icon,sort FROM wp00000_tag ";
$sql .=" WHERE tag_group='ribbon'";
$sql.=" AND del='0'";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		$ribbon_sort[$row["sort"]]=$row["id"];
		$ribbon[$row["id"]]["name"]=$row["tag_name"];

		$tmp=hexdec(str_replace("#","",$row["tag_icon"]));
		$tmp+=2631720;
		$tmp=dechex($tmp);
	
		$ribbon[$row["id"]]["c1"]="#".$tmp;
		$ribbon[$row["id"]]["c2"]=$row["tag_icon"];
	}
}

$sql=" SELECT id, genji,ctime,cast_ribbon FROM wp00000_cast";
$sql.=" WHERE cast_status=0";
$sql.=" AND id>0";
$sql.=" AND genji IS NOT NULL";
$sql.=" ORDER BY cast_sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if($admin_config["ribbon"] ==1){
			if($day_8 < $row["ctime"] && $admin_config["coming_soon"]==1){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[1]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[1]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[1]]["c2"];

			}elseif($day_8 == $row["ctime"] && $admin_config["today_commer"]==1){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[2]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[2]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[2]]["c2"];

			}elseif((strtotime($day_8) - strtotime($row["ctime"]))/86400<$admin_config["new_commer_cnt"]){
				$row["ribbon_name"]	=$ribbon[15]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[3]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[3]]["c2"];

			}elseif($row["cast_ribbon"]>0){
				$row["ribbon_name"]	=$ribbon[$row["cast_ribbon"]]["name"];
				$row["ribbon_c1"]	=$ribbon[$row["cast_ribbon"]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$row["cast_ribbon"]]["c2"];
			}
		}

		if (file_exists("../img/profile/{$row["id"]}/0.jpg")) {
			$row["face"]="./img/profile/{$row["id"]}/0.jpg";		

		}else{
			$row["face"]="./img/cast_no_image.jpg";			
		}
		$cast_dat[$row["id"]]=$row;
	}
}

$sql ="SELECT * FROM wp00000_sch_table";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sch_time[$row["in_out"]][$row["time"]]	=$row["name"];
		$sch_sort[$row["in_out"]][$row["time"]]	=$row["sort"];
	}
}

$sql=" SELECT wp00000_cast.id,sche_date, wp00000_schedule.cast_id, ribbon_use, cast_ribbon, stime, etime, ctime, genji,wp00000_cast.id FROM wp00000_schedule";
$sql.=" LEFT JOIN wp00000_cast ON wp00000_schedule.cast_id=wp00000_cast.id";
$sql.=" WHERE sche_date='{$date}'";
$sql.=" AND del='0'";
$sql.=" AND cast_status=0";
$sql.=" ORDER BY wp00000_cast.cast_sort ASC, wp00000_schedule.id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($cast_dat[$row["cast_id"]]["genji"]){

			if($row["stime"] && $row["etime"] && $cast_dat[$row["cast_id"]]["genji"]){
				$cast_dat[$row["cast_id"]]["sch"]="{$sch_time["in"][$row["stime"]]} － {$sch_time["out"][$row["etime"]]}";
				$sort[$row["cast_id"]]=$sch_sort["in"][$row["stime"]];

			}else{
				$cast_dat[$row["cast_id"]]["sch"]="";
				$sort[$row["cast_id"]]="";
			}
		}
	}
}

asort($sort);

foreach($sort as $b1=> $b2){
	if($b2){
		$html.="<a href=\"./person.php?post_id={$b1}\" id=\"i{$b1}\" class=\"main_d_1\">";
		$html.="<img src=\"{$cast_dat[$b1]["face"]}\" class=\"main_d_1_1\">";
		$html.="<span class=\"main_d_1_2\">";
		$html.="<span class=\"main_b_1_2_h\"></span>";
		$html.="<span class=\"main_b_1_2_f f_tr\"></span>";
		$html.="<span class=\"main_b_1_2_f f_tl\"></span>";
		$html.="<span class=\"main_b_1_2_f f_br\"></span>";
		$html.="<span class=\"main_b_1_2_f f_bl\"></span>";
		$html.="<span class=\"main_d_1_2_name\">{$cast_dat[$b1]["genji"]}</span>";
		$html.="<span class=\"main_d_1_2_sch\">{$cast_dat[$b1]["sch"]}</span>";
		$html.="</span>";

		if($cast_dat[$b1]["ribbon_name"]){
		$html.="<span class=\"main_b_1_ribbon\" style=\"background:linear-gradient({$cast_dat[$b1]["ribbon_c1"]},{$cast_dat[$b1]["ribbon_c2"]});box-shadow	:0 -5px 0 {$cast_dat[$b1]["ribbon_c1"]},0 5px 0 {$cast_dat[$b1]["ribbon_c2"]};\">{$cast_dat[$b1]["ribbon_name"]}</span>";
		}
		$html.="</a>";
	}
}

echo $html;
exit();
?>
