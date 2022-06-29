<?
/*
*/
include_once('../../library/sql_post.php');
include_once('../../library/inc_code.php');
$n_id	=$_POST["n_id"];

$item_name	=$_POST["item_name"];
$item_icon	=$_POST["item_icon"];
$item_color	=$_POST["item_color"];
$item_price	=$_POST["item_price"];

$chglist	=$_POST["chglist"];


for($n=0;$n<count($chglist);$n++){
	$n1=$n+1;
	$tmp=str_replace("i","",$chglist[$n]);
	$sql=" UPDATE ".TABLE_KEY."_cast_log_table SET";
	$sql.=" item_name='{$item_name[$n]}',";
	$sql.=" item_icon='{$item_icon[$n]}',";
	$sql.=" item_color='{$item_color[$n]}',";
	$sql.=" price='{$item_price[$n]}',";
	$sql.=" sort='{$n1}'";
	$sql.=" WHERE id='{$tmp}'";

//	mysqli_query($mysqli,$sql);

	$html.="<tr id=\"i{$tmp}\">";
	$html.="<td class=\"log_td_del\"><span class=\"log_td_del_in\"></span></td>";
	$html.="<td class=\"log_td_order\">{$n1}</td>";
	$html.="<td class=\"log_td_color\">";
	$html.="<div class=\"item_color\" style=\"background:{$c_code[$item_color[$n]]}\"></div>";
	$html.="<div class=\"color_picker\">";

	foreach($c_code as $b1 => $b2){
	$html.="<span cd=\"{$b1}\" class=\"color_picker_list\" style=\"background:{$b2};\"></span>";
	}
	$html.="</div>";
	$html.="<input id=\"item_color_hidden_{$tmp}\" class=\"color_hidden\" type=\"hidden\" value=\"{$item_color[$n]}\">";
	$html.="</td>";

	$html.="<td class=\"log_td_icon\" style=\"color:{$c_code[$item_color[$n]]}\">";
	$html.="<div class=\"item_icon\">{$i_code[$item_icon[$n]]}</div>";
	$html.="<div class=\"icon_picker\">";

	foreach($i_code as $b1 => $b2){
		$html.="<span cd=\"{$b1}\" class=\"icon_picker_list\">{$b2}</span>";
	}

	$html.="</div>";
	$html.="<input id=\"item_icon_hidden_{$tmp}\" type=\"hidden\" value=\"{$item_icon[$n]}\">";
	$html.="</td>";
	$html.="<td class=\"log_td_name\"><input id=\"item_name_{$tmp}\" type=\"text\" value=\"{$item_name[$n]}\" class=\"item_name\"></td>";
	$html.="<td class=\"log_td_price\"><input id=\"item_price_{$tmp}\" type=\"text\" value=\"{$item_price[$n]}\" class=\"item_price\"></td>";
	$html.="<td class=\"log_td_handle\"></td></tr>";
}
echo $html;
exit();
?>
