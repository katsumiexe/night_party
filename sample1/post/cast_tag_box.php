<?
include_once('../library/sql.php');

$date		=$_POST['date'];
$h_time=$admin_config["start_time"]*100;

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

$sql ="SELECT * FROM ".TABLE_KEY."_sch_table";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sch_time[$row["in_out"]][$row["time"]]	=$row["name"];
		$sch_sort[$row["in_out"]][$row["time"]]	=$row["sort"];
	}
}

$sql="SELECT MAX(id) AS tmp, cast_id FROM ".TABLE_KEY."_schedule ";
$sql.="WHERE sche_date='{$date}' ";
$sql.="GROUP BY cast_id";

if($result = mysqli_query($mysqli,$sql)){
	while($row0 = mysqli_fetch_assoc($result)){

		$sql2=" SELECT S.id, S.stime, S.etime, S.cast_id, C.genji, C.prm, C.genji, C.ctime, C.ribbon_use, C.cast_ribbon, C.prm FROM ".TABLE_KEY."_schedule AS S";
		$sql2.=" LEFT JOIN ".TABLE_KEY."_cast AS C ON C.id = S.cast_id";
		$sql2.=" WHERE S.id='{$row0["tmp"]}'";
		$sql2.=" AND S.stime<>''";
		$sql2.=" AND S.etime<>''";
		$sql2.=" AND C.genji IS NOT NULL";

		if($result2 = mysqli_query($mysqli,$sql2)){
			while($row = mysqli_fetch_assoc($result2)){
				if($row["stime"] && $row["etime"] ){
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

					if (file_exists("../img/profile/{$row["cast_id"]}/0.webp") && $admin_config["webp_select"] == 1) {
						$row["face"]="./img/profile/{$row["cast_id"]}/0.webp?t={$row["prm"]}";

					}elseif (file_exists("../img/profile/{$row["cast_id"]}/0.jpg")) {
						$row["face"]="./img/profile/{$row["cast_id"]}/0.jpg?t={$row["prm"]}";

					}elseif (file_exists("../img/profile/{$row["cast_id"]}/0.png")) {
						$row["face"]="./img/profile/{$row["cast_id"]}/0.png?t={$row["prm"]}";

					}else{
						$row["face"]="./img/cast_no_image.jpg";			
					}

					$row["sch"]=$sch_time["in"][$row["stime"]]." - ".$sch_time["out"][$row["etime"]];

					if($h_time>$row["stime"]){
						$tmp=($row["stime"]+2400)*10000000;
					}else{
						$tmp=($row["stime"])*1000000;
					}

					if($h_time>$row["etime"]){
						$tmp+=($row["etime"]+2400)*10000;
					}else{
						$tmp+=($row["etime"])*10000;
					}

					$tmp+=$row["id"];
					$cast_dat[$tmp]=$row;
				}
			}
		}
	}
}
ksort($cast_dat);


foreach($cast_dat as $b1=> $b2){
	$ck=1;
	$html.="<a href=\"./person.php?post_id={$b2["cast_id"]}\" id=\"i{$b2["cast_id"]}\" class=\"main_d_1\">";
	$html.="<img src=\"{$b2["face"]}\" class=\"main_d_1_1\">";
	$html.="<span class=\"main_d_1_2\">";
	$html.="<span class=\"main_b_1_2_h\"></span>";
	$html.="<span class=\"main_b_1_2_f f_tr\"></span>";
	$html.="<span class=\"main_b_1_2_f f_tl\"></span>";
	$html.="<span class=\"main_b_1_2_f f_br\"></span>";
	$html.="<span class=\"main_b_1_2_f f_bl\"></span>";
	$html.="<span class=\"main_d_1_2_name\">{$b2["genji"]}</span>";
	$html.="<span class=\"main_d_1_2_sch\">{$b2["sch"]}</span>";
	$html.="</span>";

	if($b2["ribbon_name"]){
	$html.="<span class=\"main_b_1_ribbon\" style=\"background:linear-gradient({$b2["ribbon_c1"]},{$b2["ribbon_c2"]});box-shadow:0 -5px 0 {$b2["ribbon_c1"]},0 5px 0 {$b2["ribbon_c2"]};\">{$b2["ribbon_name"]}</span>";
	}
	$html.="</a>";
}

if(!$ck){
	$html.="<span class=\"no_info\">待機予定はまだありません</span><br>";

}

echo $html;
exit();
?>
