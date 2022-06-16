<?
include_once('../../library/sql_post_admin.php');

$month		=$_POST['month'];
$category	=$_POST['category'];
$group		=$_POST['group'];

$sql	 ="SELECT id, tag_group, tag_name, sort FROM ".TABLE_KEY."_tag";
$sql	.=" WHERE del=0";
$sql	.=" AND( tag_group='cast_group' OR tag_group='notice_category')";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[$row["tag_group"]][$row["id"]]=$row["tag_name"];
	}
}


$st=$month."-01 00:00:00";
$ed=date("Y-m-01 00:00:00",strtotime($st)+3456000);

$sql ="SELECT * FROM `".TABLE_KEY."_notice`";
$sql.=" WHERE date BETWEEN '{$st}' AND '{$ed}'";
$sql.=" AND del =0";

if($category>0){
	$sql.=" AND category ='{$category}'";
}

if($group>0){
	$sql.=" AND cast_group ='{$group}'";
}

$sql.=" ORDER BY id DESC";
$sql.=" LIMIT 10";

//echo $sql;

$dat="<tr><td class=\"td_top w150\">日時</td><td class=\"td_top w300\">件名</td><td class=\"td_top w100\">カテゴリ</td><td class=\"td_top w300\">グループ</td></tr>";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$dat.="<tr id=\"{$row["id"]}\" class=\"tr_list\">";
		$dat.="<td class=\"notice_list\">".str_replace("-",".",substr($row["date"],0,16))."</td>";
		$dat.="<td class=\"notice_list\"><div class=\"notice_title_in\">{$row["title"]}</div></td>";
		$dat.="<td class=\"notice_list\"><div class=\"notice_category_in\">{$tag["notice_category"][$row["category"]]}</td>";
		$dat.="<td class=\"notice_list\">{$row["group"]}</td>";
		$dat.="<td class=\"notice_hidden\">{$row["log"]}</td>";
		$dat.="</tr>";
	}
}
echo $dat;
exit();
?>
