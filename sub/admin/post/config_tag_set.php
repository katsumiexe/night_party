<?
include_once('../../library/sql_post.php');
$name		=$_POST['name'];
$color		=$_POST['color'];
$group		=str_replace('_set','',$_POST['group']);

if(!$color) $color="#ff90a0";

$sql=" SELECT MAX(sort) as max FROM ".TABLE_KEY."_tag ";
$sql.=" WHERE tag_group='{$group}'";
$sql.=" AND del<2";

$result = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_assoc($result);
$sort=$row["max"]+1;

$sql=" INSERT INTO ".TABLE_KEY."_tag";
$sql.=" (sort,	tag_group,tag_name,tag_icon,`del`)";
$sql.=" VALUES('{$sort}','{$group}','{$name}','{$color}','0')";

mysqli_query($mysqli,$sql);
$tmp_auto=mysqli_insert_id($mysqli);

if($group == "prof"){
$tmp[2]=" selected=\"selected\"";
echo <<< EOM
	<tr id="tr_n_{$tmp_auto}" class="tr bg0">
		<input type="hidden" value="0" name="prof_del">
		<td class="config_prof_handle handle"></td>
		<td class="config_prof_sort"><input type="text" value="{$sort}" class="prof_sort" disabled></td>
		<td class="config_prof_name"><input id="charm-{$tmp_auto}" type="text" name="prof_name[{$tmp_auto}]" value="{$name}" class="chg2 prof_name"></td>
		<td class="config_prof_style">
			<select id="style-{$tmp_auto}" name="prof_style[{$tmp_auto}]" class="chg2 prof_option">
				<option value="1">一行</option>
				<option value="2"{$tmp[$color]}>複数行</option>
			</select>
		</td>
		<td class="config_prof_style">
			<button type="button" class="prof_btn view_btn bg0">非表示</button>
			<button type="button" class="prof_btn del_btn">削除</button>
		</td>
	</tr>
EOM;

}elseif($group == "notice_category" || $group == "cast_group" ){
echo <<< EOM
	<tr id="tr_n_{$tmp_auto}" class="tr bg0">
		<td class="config_prof_sort"><input type="text" value="{$sort}" class="prof_sort" disabled></td>
		<td class="config_prof_name"><input id="tag_name-{$tmp_auto}" type="text" name="news_name[{$tmp_auto}]" value="{$name}" class="prof_name chg1"></td>
		<td class="config_prof_style">
			<button type="button" class="prof_btn view_btn bg0">非表示</button>
			<button type="button" class="prof_btn del_btn">削除</button>
		</td>
	</tr>
EOM;


}elseif($group == "ribbon" || $group == "news" ){
echo <<< EOM
	<tr id="tr_n_{$tmp_auto}" class="tr bg0">
		<input type="hidden" value="0" name="prof_view">
		<td class="config_prof_sort"><input type="text" value="{$sort}" class="prof_sort" disabled></td>
		<td class="config_prof_name"><input id="tag_name-{$tmp_auto}" type="text" name="news_name[{$tmp_auto}]" value="{$name}" class="prof_name chg1"></td>
		<td class="config_prof_style"><input id="tag_icon-{$tmp_auto}" type="text" name="news_icon[{$tmp_auto}]" value="{$color}" class="prof_name chg1"></td>
		<td class="config_prof_style">
			<button type="button" class="prof_btn view_btn bg0">非表示</button>
			<button type="button" class="prof_btn del_btn">削除</button>
		</td>
	</tr>
EOM;

}elseif($group == "blog"){

$sel[$color]="selected=\"selected\"";

echo <<< EOM
	<tr id="tr_n_{$tmp_auto}" class="tr bg0">
		<td class="config_prof_sort"><input type="text" value="{$sort}" class="prof_sort" disabled></td>
		<td class="config_prof_sort">
		<select class="chg1 blog_select">
			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>

			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>
			<option value="" {$sel[""]}></option>
		</select>
		</td>
		<td class="config_prof_name"><input id="tag_name-{$tmp_auto}" type="text" name="news_name[{$tmp_auto}]" value="{$name}" class="prof_name chg1"></td>
		<td class="config_prof_style">
			<button type="button" class="prof_btn view_btn bg0">非表示</button>
			<button type="button" class="prof_btn del_btn">削除</button>
		</td>
	</tr>
EOM;

}else{
echo <<< EOM
	<tr id="tr_n_{$tmp_auto}" class="tr bg0">
		<input type="hidden" value="0" name="prof_view">
		<td class="config_prof_handle handle"></td>
		<td class="config_prof_sort"><input type="text" value="{$sort}" class="prof_sort" disabled></td>
		<td class="config_prof_name"><input id="tag_name-{$tmp_auto}" type="text" name="news_name[{$tmp_auto}]" value="{$name}" class="prof_name chg1"></td>
		<td class="config_prof_style"><input id="tag_icon-{$tmp_auto}" type="text" name="news_icon[{$tmp_auto}]" value="{$color}" class="prof_name chg1"></td>
		<td class="config_prof_style">
			<button type="button" class="prof_btn view_btn bg0">非表示</button>
			<button type="button" class="prof_btn del_btn">削除</button>
		</td>
	</tr>
EOM;
}
exit();
?>
