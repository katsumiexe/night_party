<?
/*
*/
include_once('../../library/sql_post.php');
include_once("../../library/inc_code.php");

$item_name	=$_POST["item_name"];
$item_icon	=$_POST["item_icon"];
$item_color	=$_POST["item_color"];

$price		=$_POST["price"];

$sql ="SELECT MAX(`sort`) AS od FROM wp00000_cast_log_table";
$sql.=" WHERE cast_id='{$cast_data["id"]}'";
if($result = mysqli_query($mysqli,$sql)){
	$row = mysqli_fetch_assoc($result);
	$odr=$row["od"];
}
$odr++;

$sql ="INSERT INTO wp00000_cast_log_table(`cast_id`,`item_name`,`item_icon`,`item_color`,`price`,`sort`) VALUES ";
$sql.=" ('{$cast_data["id"]}','{$item_name}','{$item_icon}','{$item_color}','{$price}','{$odr}')";
mysqli_query($mysqli,$sql);


$tmp_auto=mysqli_insert_id($mysqli);

$html="<tr id=\"i{$tmp_auto}\">";
$html.="<td class=\"log_td_del\"><span class=\"log_td_del_in\"></span></td>";
$html.="<td class=\"log_td_order\">{$odr}</td>";
$html.="<td class=\"log_td_color\">";
$html.="<div class=\"item_color\" style=\"background:{$c_code[$item_color]}\"></div>";
$html.="<div class=\"color_picker\">";

foreach($c_code as $b1 => $b2){
$html.="<span cd=\"{$b1}\" class=\"color_picker_list\" style=\"background:{$b2};\"></span>";
}
$html.="</div>";
$html.="<input id=\"item_color_hidden_{$tmp_auto}\" class=\"color_hidden\" type=\"hidden\" value=\"{$item_color}\">";
$html.="</td>";

$html.="<td class=\"log_td_icon\" style=\"color:{$c_code[$item_color]}\">";
$html.="<div class=\"item_icon\">{$i_code[$item_icon]}</div>";
$html.="<div class=\"icon_picker\">";

foreach($i_code as $b1 => $b2){
	$html.="<span cd=\"{$b1}\" class=\"icon_picker_list\">{$b2}</span>";
}

$html.="</div>";
$html.="<input id=\"item_icon_hidden_{$tmp_auto}\" type=\"hidden\" value=\"{$item_icon}\">";
$html.="</td>";
$html.="<td class=\"log_td_name\"><input id=\"item_name_{$tmp_auto}\" type=\"text\" value=\"{$item_name}\" class=\"item_name\"></td>";
$html.="<td class=\"log_td_price\"><input id=\"item_price_{$tmp_auto}\" type=\"text\" value=\"{$price}\" class=\"item_price\"></td>";
$html.="<td class=\"log_td_handle\"></td></tr>";

echo $html;
exit();
?>
