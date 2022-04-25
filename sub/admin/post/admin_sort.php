<?
include_once('../../library/sql_post.php');
$list		=$_POST['list'];
$group		=$_POST['group'];
$fs			=$_POST['fs'];


if($group == "staff_sort"){
	$sql="SELECT cast_sort, id FROM ".TABLE_KEY."_cast";
	$sql.=" WHERE cast_sort>='{$fs}'";
	$sql.=" ORDER BY cast_sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$base[$row["id"]]=$row["cast_sort"];
		}
	}

	foreach($list as $a1 => $a2){
		$a2=str_replace('sort_item','',$a2);
		$sql="UPDATE ".TABLE_KEY."_cast SET";
		$sql.=" cast_sort='{$fs}'";
		$sql.=" WHERE id={$a2}";
		mysqli_query($mysqli,$sql);
		$fs++;
	}


}elseif($group == "box_sort"){
	$base	=$_POST["base"];
	$base_id=$_POST["base_id"];
	$sort	=$_POST["sort"];
	$pg_st	=$_POST["pg_st"]-1;
	$tmp_sort=$pg_st;

	$s=1;

	$cl_b=$_POST["cl_b"];
	$cl_c=$_POST["cl_c"];
	$cl_d=$_POST["cl_d"];
	$cl_e=$_POST["cl_e"];
	$cl_f=$_POST["cl_f"];

echo $cl_b."▼". $cl_c."▼". $cl_d."▼". $cl_e."▼". $cl_f."▼";

	$sql="SELECT cast_sort, id FROM ".TABLE_KEY."_cast";
	$sql.=" ORDER BY cast_sort ASC";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			if(
				($cl_b == 1 && $row["cast_status"] == 0 && $row["ctime"]<=$day_8) || 
				($cl_c == 1 && $row["cast_status"] == 0 && $row["ctime"]>$day_8) || 
				($cl_d == 1 && $row["cast_status"] == 2) || 
				($cl_e == 1 && $row["cast_status"] == 3) || 
				($cl_f == 1 && $row["cast_status"] == 4)
			){
				$tmp_sort++;
			}

			if($tmp_sort == $sort){
				$dat[$s]=$base_id;
				$s++;
			}

			if($base != $row["cast_sort"]){
				$dat[$s]=$row["id"];
				$s++;
			}else{
				$sort++;
			}

		}
	}

	foreach($dat as $a1 => $a2){
		$sql="UPDATE ".TABLE_KEY."_cast SET";
		$sql.=" cast_sort='{$a1}'";
		$sql.=" WHERE id={$a2}";
		mysqli_query($mysqli,$sql);
	}

	if(!$cl_b && !$cl_c && !$cl_d && !$cl_e && !$cl_f){
		$cl_b=1;
		$cl_c=1;
	}

	if($cl_b == 1){
		$app_set.=" OR ( cast_status =0 AND ctime<='{$day_8}')";
	}

	if($cl_c == 1){
		$app_set.=" OR ( cast_status =0 AND ctime>'{$day_8}')";
	}

	if($cl_d == 1){
		$app_set.=" OR cast_status =2";
	}

	if($cl_e == 1){
		$app_set.=" OR cast_status =3";
	}

	if($cl_f == 1){
		$app_set.=" OR cast_status =4";
	}

	$n=1;
	$sql	 ="SELECT * FROM ".TABLE_KEY."_tag";
	$sql	.=" WHERE del=0";
	$sql	.=" and tag_group='cast_group' OR tag_group='ribbon'";
	$sql	.=" ORDER BY sort ASC";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$cast_tag[$row["tag_group"]][$row["id"]]=$row["tag_name"];
		}
	}


	$sql	 ="SELECT id,staff_id,genji,genji_kana, cast_sort, C.del, `group`, ctime, login_id, login_pass, cast_status,name,kana,cast_ribbon, S.mail, C.prm FROM ".TABLE_KEY."_staff AS S";
	$sql	.=" INNER JOIN ".TABLE_KEY."_cast AS C ON S.staff_id=C.id";
	$sql	.=" WHERE id IS NOT NULL";
	$sql	.=" AND cast_status<5";
	$sql	.=" AND S.del=0";
	$sql	.=" AND C.del=0";
	$sql	.=" ORDER BY cast_sort ASC";

	if($rowult = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($rowult)){
			if($n>$pg_st && $n <= $pg_st+30){

				if(
					($cl_b == 1 && $row["cast_status"] == 0 && $row["ctime"]<=$day_8) || 
					($cl_c == 1 && $row["cast_status"] == 0 && $row["ctime"]>$day_8) || 
					($cl_d == 1 && $row["cast_status"] == 2) || 
					($cl_e == 1 && $row["cast_status"] == 3) || 
					($cl_f == 1 && $row["cast_status"] == 4)
				){
					if (file_exists("../img/profile/{$row["id"]}/0_s.webp")) {
						$row["face"]="../img/profile/{$row["id"]}/0_s.webp?t={$row["prm"]}";

					}elseif (file_exists("../img/profile/{$row["id"]}/0_s.jpg")) {
						$row["face"]="../img/profile/{$row["id"]}/0_s.jpg?t={$row["prm"]}";			

					}else{
						$row["face"]="../img/cast_no_image.jpg";			
					}

					if($row["cast_status"]==0 && $row["ctime"]>$day_8){
						$row["cast_status"]=1;
					}

					if($row["login_id"] && $row["login_pass"]){
						$row["login"]=1;
					}

					$set[$row["staff_id"]]=1;
					$row["view"]=1;


$html.= <<<INA
<tr id="sort_item{$row["staff_id"]}" class="tr b{$row["cast_status"]}">
<td class="td_sort handle w40"></td>
<td class="w40"><input id="s_box{$row["cast_sort"]}" type="text" value="{$n}" class="box_sort"></td>
<td class="w50"><img src="{$row["face"]}" style="width:48px; height:64px;"></td>
<td class="w140"><span class="st_name">{$row["genji"]}</span><br>[{$row["genji_kana"]}]</td>
<td class="w100">
	{$row["login_id"]}<br>
	<button type="button" class="staff_hime">HIMEカルテ</button>
	<input type="hidden" value="{$row["login"]}">
	<input id="ml{$row["staff_id"]}" type="hidden" value="{$row["mail"]}">
</td>

<td class="w100">{$row["id"]}</td>
<td class="w100">{$row["ctime"]}</td>
<td class="w80">{$cast_tag["cast_group"][$row["group"]]}</td>
<td class="w80">{$cast_status_select[$row["cast_status"]]}</td>
<td class="w80">{$cast_tag["ribbon"][$row["cast_ribbon"]]}</td>

<td class="w60" style="position:relative; text-align:center;">
	<form method="post" style="margin-block-end: 0;">
		<button type="submit" class="staff_submit">詳細</button>
		<input type="hidden" value="staff_fix" name="menu_post">
		<input type="hidden" name="staff_id" value="{$row["staff_id"]}">
	</form>
</td>
</tr>
INA;
			$n++;
				}else{

$html.= <<<INA
		<tr id="sort_item{$row["staff_id"]}" class="tr" style="display:none;">
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
INA;

				}

			}
		}
	}

echo $html;

}elseif($group=="contact_sort"){
	$n=0;
	foreach($list as $a1 => $a2){
		$n++;
		$a2=str_replace($group,'',$a2);
		$sql="UPDATE ".TABLE_KEY."_contact_table SET";
		$sql.=" sort='{$n}'";
		$sql.=" WHERE id={$a2}";
		mysqli_query($mysqli,$sql);
	}

echo $sql;

}else{
	$n=0;
	foreach($list as $a1 => $a2){
		$n++;
		$a2=str_replace($group,'',$a2);
		$sql="UPDATE ".TABLE_KEY."_contents SET";
		$sql.=" sort='{$n}'";
		$sql.=" WHERE id={$a2}";
		mysqli_query($mysqli,$sql);
	}

echo $sql;
}

exit();
?>
