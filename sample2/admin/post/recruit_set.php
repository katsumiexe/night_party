<?
include_once('../../library/sql_post_admin.php');

$name	=$_POST['name'];
$type	=$_POST['type'];
$ck		=$_POST['ck'];
$sel[$type]="selected=\"selected\"";

$sql	 ="SELECT COUNT(id) AS cnt FROM ".TABLE_KEY."_contact_table";
$sql	.=" WHERE block='1'";
$sql	.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sort=$row["cnt"];
	}
}
$sort++;
$sql	 ="INSERT INTO ".TABLE_KEY."_contact_table (`block`,`sort`,`name`,`type`,`ck`)";
$sql	 .=" VALUES('1','{$sort}','{$name}','{$type}','{$ck}')";
mysqli_query($mysqli,$sql);
$tmp_auto=mysqli_insert_id($mysqli);

$log=<<<ABC

<tr id="contact_sort{$tmp_auto}" class="tr bg sort_item">
	<td class="config_prof_handle handle"></td>
	<td class="config_prof_sort" style="text-align:center;"><input type="text" value="{$sort}" class="box_sort" disabled></td>
	<td class="config_prof_name"><input id="name{$tmp_auto}" type="text" value="{$name}" class="chg1 prof_name rec_tbl_chg"></td>
	<td class="config_prof_style">
		<select id="type{$tmp_auto}" class="chg1 prof_option rec_tbl_chg">
			<option value="1" {$sel[1]}>一行</option>
			<option value="2" {$sel[2]}>複数行</option>
			<option value="3" {$sel[3]}>MAIL</option>
			<option value="4" {$sel[4]}>数字</option>
		</select>
	</td>
	<td class="config_prof_styl">
		<button id="chg{$tmp_auto}" type="button" class="prof_btn rec_bg{$ck}">必須</button>
		<button id="del{$tmp_auto}" type="button" class="prof_btn del_btn">削除</button>
	</td>
</tr>
ABC;
echo $log;
exit();
?>
