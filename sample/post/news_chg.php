<?
include_once('../library/sql.php');

$date		=$_POST['date'];
$tag		=$_POST['tag'];

$sql	 ="SELECT tag_name, tag, tag_icon, status, `display_date`,event_date, category, contents_key, title, contents FROM wp00000_contents";
$sql	.=" LEFT JOIN wp00000_tag ON tag=wp00000_tag.id";
$sql	.=" WHERE status<3";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND `event_date` LIKE '{$date}%'";
$sql	.=" AND page='news'";
$sql	.=" ORDER BY `event_date` DESC";

//echo $sql;


if($result = mysqli_query($mysqli,$sql)){
	while($dat = mysqli_fetch_assoc($result)){
		$dat["news_date"]=str_replace("-",".",$dat["event_date"]);

		if($dat["status"] ==2){
			$dat["caution"]="news_caution";
		}else{
			$dat["caution"]="";
		
		} 

		if($dat["category"]){
			$html.="<table class=\"main_b_notice tag{$dat["tag"]} {$dat["caution"]}\">";
			$html.="<tr>";
			$html.="<td  class=\"main_b_td_1\">";
			$html.="<span class=\"main_b_notice_date\">{$dat["news_date"]}</span>";
			$html.="<span class=\"main_b_notice_tag\" style=\"background:{$dat["tag_icon"]}\">{$dat["tag_name"]}</span>";
			$html.="</td>";

			$html.="<td  class=\"main_b_td_2\">";
			$html.="<a href=\"{$dat["category"]}.php?post_id={$dat["contents_key"]}\" class=\"main_b_notice_link\">";
			$html.="<span class=\"main_b_notice_title\">{$dat["title"]}</span>";
			$html.="</a>";
			$html.="</td>";
			$html.="<td class=\"main_b_td_3\">";
			$html.="<span class=\"main_b_notice_arrow\"><a href=\"{$dat["category"]}.php?post_id={$dat["contents_key"]}\" class=\"main_b_notice_alink\"></a></span>";
			$html.="</td>";
			$html.="</tr>";
			$html.="</table>";

		}else{
			$html.="<table class=\"main_b_notice tag{$dat["tag"]} {$dat["caution"]}\">";
			$html.="<tr>";
			$html.="<td class=\"main_b_td_1\">";
			$html.="<span class=\"main_b_notice_date\">{$dat["news_date"]}</span>";
			$html.="<span class=\"main_b_notice_tag\" style=\"background:{$dat["tag_icon"]}\">{$dat["tag_name"]}</span>";
			$html.="</td>";
			$html.="<td class=\"main_b_td_2\">";
			$html.="<span class=\"main_b_notice_title\">{$dat["title"]}</span>";
			$html.="</td>";
			$html.="</tr>";
			$html.="</table>";
		}
	}
}

echo $html;
exit();
?>
