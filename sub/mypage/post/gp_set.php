<?
include_once('../../library/sql_post.php');

$name		=$_POST["name"];
$sort		=$_POST["sort"]+1;

$sql	 =" INSERT INTO ".TABLE_KEY."_customer_group(`group_id`,`cast_id`,`sort`,`tag`,`del`)";
$sql	.=" VALUES('1','{$cast_data["id"]}','{$sort}','{$name}','0')";
mysqli_query($mysqli,$sql);
$tmp_auto=mysqli_insert_id($mysqli);


$list.="<tr id=\"gp{$tmp_auto}\">";
$list.="<td class=\"log_td_del\"><span class=\"gp_del_in\"></span></td>";
$list.="<td class=\"log_td_order\">{$sort}</td>";

$list.="<td class=\"log_td_name\">";
$list.="<input id=\"gp_name_{$tmp_auto}\" type=\"text\" value=\"{$name}\" class=\"gp_name\">";
$list.="</td>";
$list.="<td class=\"gp_handle\"></td>";
$list.="</tr>";

echo $list;
exit();
?>
