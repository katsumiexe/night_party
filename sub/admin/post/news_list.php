<?
include_once('../../library/sql_post.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
$filter		=$_POST["filter"];
$view0		=$_POST["view0"];
$view1		=$_POST["view1"];
$view2		=$_POST["view2"];

$sql	 ="SELECT * FROM ".TABLE_KEY."_tag";
$sql	.=" WHERE tag_group='news'";
$sql	.=" AND del=0";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[$row["id"]]=$row["tag_name"];
	}
}

if($filter >0){
	$app0=" AND tag='{$filter}'";
}

if($view0== 1){
	$app1.="0,";
}

if($view1== 1){
	$app1.="1,";
}

if($view2== 1){
	$app1.="2,";
}
$app1=substr($app1,0,-1);

$sql	 ="SELECT * FROM ".TABLE_KEY."_contents";
$sql	.=" WHERE page='news'";
$sql	.=" AND status IN({$app1}) ";
$sql	.=" {$app0} ";
$sql	.=" ORDER BY date DESC";
$sql	.=" LIMIT 20";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

$status		=array();
$category	=array();
$app2="";

$status[$row["status"]]="selected=\"selected\"";
$category[$row["category"]]="selected=\"selected\"";

foreach($tag as $a1 => $a2){
	$app2.="<option value=\"{$a1}\"";
if($a1 == $row["tag"]){
	$app2.="selected=\"selected\"";
}
	$app2.="{$a2}</option>";
}

$dat=SQL<<<
<form id="f{$row["id"]}" action="./index.php" method="post">
	<input type="hidden" name="post_id" value="news">
	<input type="hidden" name="menu_post" value="contents">
	<input type="hidden" name="event_set_id" value="{$row["id"]}">

	<table class="news_table c{$row["status"]}">
		<tr>
			<td style="font-size:0;">
				<span class="event_tag">日付</span><input type="date" name="event_date" class="w140 news_box" value="{$row["event_date"]}" autocomplete="off"> 
				<span class="event_tag">公開日</span><input type="date" name="display_date" class="w140 news_box" value="{$row["display_date"]}" autocomplete="off"> 
				<span class="event_tag">状態</span>
				<select class="w120 news_box" name="event_status">
					<option value="0" {$status[0]}>表示</option>
					<option value="2" {$status[2]}>注目</option>
					<option value="3" {$status[3]}>非表示</option>
					<option value="4" {$status[4]}>削除</option>
				</select>
				<button id="chg{$row["id"]}" type="button" class="event_tag_btn">変更</button>
			</td>
		</tr>

		<tr>
			<td style="font-size:0;">
				<span class="event_tag">タグ</span>
				<select name="event_tag" class="w140 news_box">
					{$app2}
				</select>
				<span class="event_tag">リンク</span><select name="category" class="w140 news_box">
					<option value="">なし</option>
					<option value="news" {$category["news"]}>ニュース</option>
					<option value="event" {$category["event"]}>イベント</option>
					<option value="person" {$category["person"]}>CAST</option>
					<option value="blog" {$category["blog"]}>ブログ</option>
					<option value="page" {$category["page"]}>リンク</option>
				</select>
				<input type="text" name="event_key" class="news_box" style="border:1px solid #303030;width:185px;" value="{$row["contents_key"]}"> 
			</td>
		</tr>

		<tr>
			<td>
				<textarea name="event_title" class="news_title">{$row["title"]}</textarea>
			</td>
		</tr>
	</table>
	<input id="hdn" type="hidden" name="hdn" value="0">
</form>
SQL;
	}
}

echo $dat;

exit();
?>
