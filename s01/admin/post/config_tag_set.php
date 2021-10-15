<?
include_once('../../library/sql_post.php');
$name		=$_POST['name'];
$color		=$_POST['color'];
$sort		=$_POST['sort']+1;
$group		=str_replace('_set','',$_POST['group']);

if(!$color) $color="#ff90a0";

$sql=" INSERT INTO wp00000_tag";
$sql.=" (sort,	tag_group,tag_name,tag_icon)";
$sql.=" VALUES('{$sort}','{$group}','{$name}','{$color}')";

mysqli_query($mysqli,$sql);
$tmp_auto=mysqli_insert_id($mysqli);

if($group != "ribbon" && $group != "news" ){
	$al="<td class=\"config_prof_handle handle bg\"></td>";
}

echo <<< EOM
	<tr id="tr_n_{$tmp_auto}" class="tr">
		<input type="hidden" value="0" name="prof_view">
		{$al}
		<td class="config_prof_sort bg"><input type="text" value="{$sort}" class="prof_sort" disabled></td>
		<td class="config_prof_name bg"><input id="tag_name-{$tmp_auto}" type="text" name="news_name[{$tmp_auto}]" value="{$name}" class="prof_name bg"></td>
		<td class="config_prof_style bg"><input id="tag_icon-{$tmp_auto}" type="text" name="news_icon[{$tmp_auto}]" value="{$color}" class="prof_name bg"></td>
		<td class="config_prof_style bg">
			<button type="button" class="prof_btn view_btn bg">非表示</button>
			<button type="button" class="prof_btn del_btn  bg">削除</button>
		</td>
	</tr>
EOM;
exit();
?>
