<?
include_once('../library/sql.php');

$page=$_POST["page"]*30;

$sql ="SELECT * FROM ".TABLE_KEY."_sch_table";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sch_time[$row["in_out"]][$row["time"]]	=$row["name"];
	}
}


$sql  ="SELECT id, tag_name, tag_icon,sort FROM ".TABLE_KEY."_tag ";
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

$sql=" SELECT id, genji,ctime,ribbon_use,cast_ribbon,prm FROM ".TABLE_KEY."_cast";
$sql.=" WHERE cast_status=0";
$sql.=" AND id>0";
$sql.=" AND genji IS NOT NULL";
$sql.=" ORDER BY cast_sort ASC";
$sql.=" LIMIT {$page},30";

echo $sql;

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if($admin_config["ribbon"] ==1){
			if($ribbon[$row["cast_ribbon"]]["name"]){
				$row["ribbon_name"]	=$ribbon[$row["cast_ribbon"]]["name"];
				$row["ribbon_c1"]	=$ribbon[$row["cast_ribbon"]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$row["cast_ribbon"]]["c2"];

			}elseif($day_8 == $row["ctime"] && $admin_config["today_commer"]==1){

				$row["ribbon_name"]	=$ribbon[$ribbon_sort[2]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[2]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[2]]["c2"];

			}elseif((strtotime($day_8) - strtotime($row["ctime"]))/86400<$admin_config["new_commer_cnt"]){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[3]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[3]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[3]]["c2"];

			}elseif($day_8 < $row["ctime"] && $admin_config["coming_soon"]==1){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[1]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[1]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[1]]["c2"];
			}
		}

		if (file_exists("../img/profile/{$row["id"]}/0.webp") && $admin_config["webp_select"] == 1) {
			$row["face"]="./img/profile/{$row["id"]}/0.webp?t={$row["prm"]}";			

		}elseif (file_exists("../img/profile/{$row["id"]}/0.jpg")) {
			$row["face"]="./img/profile/{$row["id"]}/0.jpg?t={$row["prm"]}";

		}else{
			$row["face"]="./img/cast_no_image.jpg";			
		}

		$row["sch"]="休み";
		$sql2=" SELECT stime, etime, cast_id FROM ".TABLE_KEY."_schedule AS S";
		$sql2.=" WHERE sche_date='{$day_8}'";
		$sql2.=" AND cast_id='{$row["id"]}'";
		$sql2.=" ORDER BY S.id DESC";
		$sql2.=" LIMIT 1";

		if($result2 = mysqli_query($mysqli,$sql2)){
			while($row2 = mysqli_fetch_assoc($result2)){
				if($row2["stime"] && $row2["etime"]){
					$row["sch"]="{$sch_time["in"][$row2["stime"]]} － {$sch_time["out"][$row2["etime"]]}";
				}
			}
		}

$html.="<a href=\"./person.php?post_id={$row["id"]}\" id=\"i{$b1}\" class=\"main_d_1\">";
$html.="<div class=\"main_d_1_1\" style=\"background-image:url('{$row["face"]}')\"></div>";
$html.="<span class=\"main_d_1_2\">";
$html.="<span class=\"main_b_1_2_h\"></span>";
$html.="<span class=\"main_b_1_2_f f_tr\"></span>";
$html.="<span class=\"main_b_1_2_f f_tl\"></span>";
$html.="<span class=\"main_b_1_2_f f_br\"></span>";
$html.="<span class=\"main_b_1_2_f f_bl\"></span>";

$html.="<span class=\"main_d_1_2_name\">{$row["genji"]}</span>";
$html.="<span class=\"main_d_1_2_sch\">{$row["sch"]}</span>";
$html.="</span>";

if($row["ribbon_name"]){
$html.="<span class=\"main_b_1_ribbon\" style=\"background:linear-gradient({$row["ribbon_c1"]},{$row["ribbon_c2"]});box-shadow:0 -5px 0 {$row["ribbon_c1"]},0 5px 0 {$row["ribbon_c2"]};\">{$row["ribbon_name"]}</span>";
}
$html.="</a>";

//		$cast_dat[$row["id"]]=$row;
	}
}
echo $html;
exit();
?>
