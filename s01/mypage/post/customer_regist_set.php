<?
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
include_once('../../library/sql_post.php');
$group	=$_POST["group"];
$name	=$_POST["name"];
$nick	=$_POST["nick"];
$fav	=$_POST["fav"];
$img_code	=$_POST["img_code"];

$yy		=$_POST["yy"];
$mm		=$_POST["mm"];
$dd		=$_POST["dd"];
$ag		=$_POST["ag"];

if($yy && $mm && $dd){
	$birth=$yy.$mm.$dd;
}else{
	$birth="00000000";
}

$sql ="INSERT INTO wp00000_customer (`cast_id`,`nickname`,`name`,`regist_date`,`birth_day`,`face`,`fav`,`c_group`)";
$sql .=" VALUES('{$cast_data["id"]}','{$nick}','{$name}','{$now}','{$birth}','{$img_code}','{$img_code}','{$group}')";
mysqli_query($mysqli,$sql);
$tmp_auto=mysqli_insert_id($mysqli);

if($img_code){
	$tmp_img="<img src=\"data:image/jpg;base64,{$img_code}\" class=\"mail_img\">";
}else{
	$tmp_img="<img src=\"../img/customer_no_image.png\" class=\"mail_img\">";
}

for($s=1;$s<6;$s++){
	$html_fav.="<span id=\"fav_{$tmp_auto}_{$s}\" class=\"customer_list_fav_icon";
	if($fav>=$s){
		$html_fav.=" fav_in";
	}
	$html_fav.="\"></span>";
}

$html.="<div id=\"clist{$tmp_auto}\" class=\"customer_list\">";
$html.=$tmp_img;
$html.="<div class=\"customer_list_fav\">";
$html.=$html_fav;
$html.="</div>";

$html.="<div class=\"customer_list_name\">{$name} 様</div>";
$html.="<div class=\"customer_list_nickname\">{$nick}</div>";
$html.="<span class=\"mail_al\"></span>";
$html.="<input type=\"hidden\" class=\"customer_hidden_fav\" value=\"{$fav}\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_yy\" value=\"{$yy}\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_mm\" value=\"{$mm}\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_dd\" value=\"{$dd}\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_ag\" value=\"{$ag}\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_group\" value=\"{$group}\">";

$html.="<input type=\"hidden\" class=\"customer_hidden_mail\" value=\"\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_tel\" value=\"\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_twitter\" value=\"\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_facebook\" value=\"\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_insta\" value=\"\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_line\" value=\"\">";
$html.="<input type=\"hidden\" class=\"customer_hidden_web\" value=\"\">";
$html.="</div>";
echo $html;
exit();
?>
