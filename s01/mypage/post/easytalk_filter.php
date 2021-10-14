<?
/*
mail_hist
*/
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

include_once('../../library/sql_post.php');

$yet		=$_POST['yet'];
$type		=$_POST['type'];
$date		=$_POST['date'];
$tag		=$_POST['tag'];
$fav		=$_POST['fav'];

if($date){
	if($type == 1){
		$app.=" AND regist_date LIKE '{$date}%'";
	}elseif($type == 2){
		$app_0.=" LEFT JOIN wp00000_cast_log AS L ON C.id=L.customer_id";
		$app_1.=" ,MAX(sdate) AS sd";
		$app.=" AND days='{$date}'";

	}elseif($type == 3){
		$bd=substr($date,5,2).substr($date,8,2);
		$app.=" AND birth_day LIKE '%{$bd}'";
	}
}

if($tag>0){
	$app.=" AND c_group='{$tag}'";
}

if($fav !=9){
	$app.=" AND fav='{$fav}'";
}

if($yet == 1){
	$tmp_date=date("Y-m-d H:i:s",strtotime($day_8)+$config["start_time"]*3600);
	$app_0.=" LEFT JOIN wp00000_easytalk AS E ON C.id=E.customer_id";
	$app_1.=" ,MAX(send_date) AS se";
	$app.=" AND (send_flg=1 OR send_flg IS NULL)";
}

$sql	 ="SELECT C.id,C.name,C.nickname,C.face,C.mail,C.block {$app_1} FROM wp00000_customer AS C";
$sql	.=$app_0;
$sql	.=" WHERE C.cast_id='{$cast_data["id"]}'";
$sql	.=" AND `block`<2";
$sql	.=" AND C.`mail`<>''";
$sql	.=$app;

$sql	.=" GROUP BY C.id";
$sql	.=" ORDER BY C.id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($row["se"] <$tmp_date || !$row["se"]){
			if($row["face"]){
				$row["face"]="<img src=\"data:image/jpg;base64,{$row["face"]}\" class=\"filter_list_img\">";

			}else{
				$row["face"]="<img src=\"../img/customer_no_image.png?t=".time()."\" class=\"filter_list_img\">";
			}

			$html.="<div id=\"filter_list{$row["id"]}\" class=\"filter_list\">";
			$html.=$row["face"];

			$html.="<span class=\"filter_list_name\">{$row["name"]}</span>";
			$html.="<span class=\"filter_list_nickname\">{$row["nickname"]}</span>";
			$html.="<input type=\"checkbox\" id=\"f_send{$row["id"]}\" class=\"filter_list_check\" value=\"1\" checked=\"checked\">";
			$html.="<label for=\"f_send{$row["id"]}\" class=\"filter_list_send\">";
			$html.="<span class=\"filter_list_check2\"><span class=\"filter_list_check1\"></span></span>";
			$html.="<span class=\"filter_list_check3\">送信</span>";
			$html.="</label>";
			$html.="</div>";
		}
	}
}

if(!$html){
$html="<div id=\"filter_list{$row["id"]}\" class=\"filter_list\">";
$html.="該当する顧客はいません。";
$html.="</div>";
}

mysqli_query($mysqli,$sql);
echo $html;
exit();
?>
