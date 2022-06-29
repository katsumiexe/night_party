<?
include_once('../../library/sql_post.php');
$id		=$_POST["id"];

$sort=1;

$sql =" SELECT * FROM ".TABLE_KEY."_customer_group";
$sql.=" WHERE del='0'";
$sql.=" AND cast_id='{$cast_data["id"]}'";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if($id==$row["id"]){
			$sql =" UPDATE ".TABLE_KEY."_customer_group SET";
			$sql.=" del='1'";
			$sql.=" WHERE id='{$row["id"]}'";
//			mysqli_query($mysqli,$sql);
echo $sql;
		}else{
			$sql =" UPDATE ".TABLE_KEY."_customer_group SET";
			$sql.=" `sort`='{$sort}'";
			$sql.=" WHERE id='{$row["id"]}'";
//			mysqli_query($mysqli,$sql);
echo $sql;

			$html.="<tr id=\"gp{$row["id"]}\">";
			$html.="<td class=\"log_td_del\"><span class=\"gp_del_in\"></span></td>";
			$html.="<td class=\"log_td_order\">{$sort}</td>";
			$html.="<td class=\"log_td_name\">";
			$html.="<input id=\"gp_name_{$row["id"]}\" type=\"text\" value=\"{$row["tag"]}\" class=\"gp_name\">";
			$html.="</td>";
			$html.="<td class=\"log_td_handle\"></td>";
			$html.="</tr>";
			$sort++;
		}
	}
}
echo $html;
exit();
?>
