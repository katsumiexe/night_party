<?
include_once('../../library/sql_post_admin.php');

$id		=$_POST['id'];
$val	=$_POST['val'];
$name	=$_POST['name'];
$time	=$_POST['time'];

if($val == 1){
	$sql	 ="UPDATE `".TABLE_KEY."_sch_table` SET";
	$sql	.=" name='{$name}',";
	$sql	.=" time='{$time}'";
	$sql	.=" WHERE id='{$id}'";
//	mysqli_query($mysqli,$sql);

}elseif($val == 2){
	$sql	 ="UPDATE `".TABLE_KEY."_sch_table` SET";
	$sql	.=" del='1'";
	$sql	.=" WHERE id='{$id}'";
//	mysqli_query($mysqli,$sql);

}elseif($val == 3){
	if($time < $admin_config["start_time"]){
		$tmp_sort=$time+2400;
	}else{
		$tmp_sort=$time;
	}

	$dat[$tmp_sort]["in_out"]="in";
	$dat[$tmp_sort]["name"]=$name;
	$dat[$tmp_sort]["time"]=$time;

	$sql	 ="SELECT sort, id, name, time FROM `".TABLE_KEY."_sch_table` WHERE in_out='in' AND del=0 ORDER BY sort ASC";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){

			if($row["time"] < $admin_config["start_time"]*100){
				$tmp_sort=$row["time"]+2400;
			}else{
				$tmp_sort=$row["time"];
			}
			$dat[$tmp_sort]=$row;
		}
	}

	ksort($dat);
	foreach($dat as $a1 => $a2){
		$tmp_set++;
		if($a2["id"]){
			$sql	 ="UPDATE `".TABLE_KEY."_sch_table` SET sort={$tmp_set} WHERE id={$a2["id"]}";
			mysqli_query($mysqli,$sql);
			$tmp_auto	=$a2["id"];
			$tmp_name	=$a2["name"];
			$tmp_time	=$a2["time"];
			$html.="<div class=\"sche_in\">";

		}else{
			$sql	  ="INSERT INTO `".TABLE_KEY."_sch_table` (`in_out`,`sort`,`name`,`time`,`del`)";
			$sql	 .=" VALUES('in','{$tmp_set}','{$name}','{$time}','0')";
//			mysqli_query($mysqli,$sql);
			$tmp_auto=mysqli_insert_id($mysqli);
			$tmp_name	=$name;
			$tmp_time	=$time;
			$html.="<div class=\"sche_in now_set\">";
		}	
		$html.="<input id=\"schen_{$tmp_auto}\" type=\"text\" name=\"in_name[{$tmp_auto}]\" class=\"set_box_sch\" value=\"{$tmp_name}\" style=\"margin-right:20px;\">";
		$html.="<input id=\"schet_{$tmp_auto}\" type=\"text\" name=\"in_name[{$tmp_auto}]\" class=\"set_box_sch\" value=\"{$tmp_time}\" style=\"margin-right:15px;\">";
		$html.="<button id=\"schec_{$tmp_auto}\" type=\"button\" class=\"prof_btn sch_chg_btn\">変更</button>";
		$html.="<button id=\"sched_{$tmp_auto}\" type=\"button\" class=\"prof_btn sch_del_btn\" style=\"margin:0 5px;\">削除</button>";
		$html.="</div>";
	}


}elseif($val == 4){
	if($time < $admin_config["start_time"]*100){
		$tmp_sort=$time+2400;
	}else{
		$tmp_sort=$time;
	}

	$dat[$tmp_sort]["in_out"]="out";
	$dat[$tmp_sort]["name"]=$name;
	$dat[$tmp_sort]["time"]=$time;

	$sql	 ="SELECT sort, id, name, time FROM `".TABLE_KEY."_sch_table` WHERE in_out='out' AND del=0 ORDER BY sort ASC";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){

			if($row["time"] < $admin_config["start_time"]*100){
				$tmp_sort=$row["time"]+2400;
			}else{
				$tmp_sort=$row["time"];
			}
			$dat[$tmp_sort]=$row;
		}
	}
	ksort($dat);
	foreach($dat as $a1 => $a2){
		$tmp_set++;
		if($a2["id"]){
			$sql	 ="UPDATE `".TABLE_KEY."_sch_table` SET sort={$tmp_set} WHERE id={$a2["id"]}";
			mysqli_query($mysqli,$sql);
			$tmp_auto	=$a2["id"];
			$tmp_name	=$a2["name"];
			$tmp_time	=$a2["time"];
			$html.="<div class=\"sche_in\">";

		}else{
			$sql	  ="INSERT INTO `".TABLE_KEY."_sch_table` (`in_out`,`sort`,`name`,`time`,`del`)";
			$sql	 .=" VALUES('out','{$tmp_set}','{$name}','{$time}','0')";
			mysqli_query($mysqli,$sql);
			$tmp_auto=mysqli_insert_id($mysqli);
			$tmp_name	=$name;
			$tmp_time	=$time;
			$html.="<div class=\"sche_in now_set\">";
		}	
		$html.="<input id=\"schen_{$tmp_auto}\" type=\"text\" name=\"in_name[{$tmp_auto}]\" class=\"set_box_sch\" value=\"{$tmp_name}\" style=\"margin-right:20px;\">";
		$html.="<input id=\"schet_{$tmp_auto}\" type=\"text\" name=\"in_name[{$tmp_auto}]\" class=\"set_box_sch\" value=\"{$tmp_time}\" style=\"margin-right:15px;\">";
		$html.="<button id=\"schec_{$tmp_auto}\" type=\"button\" class=\"prof_btn sch_chg_btn\">変更</button>";
		$html.="<button id=\"sched_{$tmp_auto}\" type=\"button\" class=\"prof_btn sch_del_btn\" style=\"margin:0 5px;\">削除</button>";
		$html.="</div>";
	}
}
echo $html;
exit();
?>

