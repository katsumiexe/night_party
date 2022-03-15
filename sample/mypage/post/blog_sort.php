<?
include_once('../../library/sql_post.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$fil		=$_POST["fil"];
$sel		=$_POST["sel"]+0;
$gp			=$_POST["gp"]+0;
$page		=$_POST["page"]+0;

$s_page		=$page*12;

$blog_status=array("公開","予約","非公開","非表示","削除");

if($sel==0){
	$app0=" ORDER BY view_date DESC";
}else{
	$app0=" ORDER BY cnt DESC";
}

if($fil>0){
	$app1=" AND tag={$fil}";
}

if($gp<9){
	$app1.=" AND status={$gp}";
}
$sql ="SELECT * FROM wp00000_tag";
$sql.=" WHERE tag_group='blog'";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[$row["id"]]=$row;
	}
}

$sql	 ="SELECT  P.id, P.view_date,  P.title, P.log, P.tag, P.img, P.img_del, P.status, P.prm, COUNT(L.days) AS cnt FROM wp00000_posts AS P ";
$sql	 .=" LEFT JOIN (SELECT `days`,`ip`,`ua`,page,value FROM wp00000_log WHERE page='article.php' GROUP BY value, days,ip,ua) AS L ON P.id=L.value ";
$sql	.=" WHERE cast='{$cast_data["id"]}'";
$sql	.=" AND P.status<4";
$sql	.=" AND (P.log <>'' OR img <>'')";
$sql	.=" AND P.title <>''";
$sql	.=$app1;
$sql	.=" AND P.cast={$cast_data["id"]}";
$sql	.=" GROUP BY P.id";
$sql	.=$app0;
$sql	.=" LIMIT {$s_page}, 12";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$ck=1;
		$row["log"]=str_replace("\n","<br>",$row["log"]);
		$row["date"]=substr(str_replace("-",".",$row["view_date"]),0,16);

		if($row["view_date"] > $now && $row["status"]==0){
			$row["status"]=1; 
		}

		if($row["img"]){
			if (file_exists("../../img/profile/{$cast_data["id"]}/{$row["img"]}_s.webp") && $admin_config["webp_select"] == 1) {
				$row["img_s"]="../img/profile/{$cast_data["id"]}/{$row["img"]}_s.webp?t={$row["prm"]}";			
				$row["img_l"]="../img/profile/{$cast_data["id"]}/{$row["img"]}.webp?t={$row["prm"]}";			

			}elseif (file_exists("../../img/profile/{$cast_data["id"]}/{$row["img"]}_s.png")) {
				$row["img_s"]="../img/profile/{$cast_data["id"]}/{$row["img"]}_s.png?t={$row["prm"]}";
				$row["img_l"]="../img/profile/{$cast_data["id"]}/{$row["img"]}.png?t={$row["prm"]}";
			}

		}else{
			$row["img_s"]="../img/blog_no_image.png";			
		}

		if($row["img_del"] !=1){
			$img_del="display:none";
		}else{
			$img_del="";
		}

		if(!$row["img"]){
			$img="display:none";
		}else{
			$img="";
		}

		$html.="<div id=\"blog_hist_{$row["id"]}\" class=\"blog_hist\">";
		$html.="<input type=\"hidden\" class=\"hidden_tag\" value=\"{$row["tag"]}\">";
		$html.="<input type=\"hidden\" class=\"hidden_status\" value=\"{$row["status"]}\">";
		$html.="<img src=\"{$row["img_s"]}\" class=\"hist_img\">";
		$html.="<div class=\"img_block\" style=\"{$img_del}\">非表示</div>";

		$html.="<span class=\"hist_date\">{$row["date"]}</span>";
		$html.="<span class=\"hist_title\">{$row["title"]}</span>";
		$html.="<span class=\"hist_tag\">";
		$html.="<span class=\"hist_tag_i\">{$tag[$row["tag"]]["tag_icon"]}</span>";
		$html.="<span class=\"hist_tag_name\">{$tag[$row["tag"]]["tag_name"]}</span>";
		$html.="</span>";
		$html.="<span class=\"hist_watch\"><span class=\"hist_i\"></span><span class=\"hist_watch_c\">{$row["cnt"]}</span></span>";
		$html.="<span class=\"hist_status hist_{$row["status"]}\">{$blog_status[$row["status"]]}</span>";
		$html.="</div>";

		$html.="<div class=\"hist_log\">";
		$html.="<div class=\"hist_img_in\"  style=\"{$img_del}\">";
		$html.="<img src=\"{$row["img_l"]}\" class=\"hist_img_on\" alt=\"ブログ\">";
		$html.="<div class=\"hist_img_hide\" style=\"{$img_del}\">非表示</div>";
		$html.="</div>";
		$html.="<span class=\"blog_log\">{$row["log"]}</span>";
		$html.="</div>";
	}
}

if(!$ck && $page==0){
	$html.="<div class=\"no_data\">投稿されているブログはありません</div>";
}



echo $html;
exit();
?>
