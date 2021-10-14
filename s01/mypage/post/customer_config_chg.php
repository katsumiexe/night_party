<?
/*
MEMO4変更
*/
include_once('../../library/sql_post.php');

$c_id		=$_POST["c_id"];

if($_POST["id"]){
	$dat		=explode("_",$_POST["id"]);
	$app=" {$dat[0]}='{$dat[1]}'";

	$sql	 ="UPDATE wp00000_customer SET";
	$sql	.=$app;
	$sql	.=" WHERE id='{$c_id}'";
	mysqli_query($mysqli,$sql);
	echo $sql;

}else{

	$sql	 ="UPDATE wp00000_customer SET";
	$sql	.=" del=1";
	$sql	.=" WHERE id='{$c_id}'";
	mysqli_query($mysqli,$sql);

$sel		=$_POST["sel"]+0;
$asc		=$_POST["asc"]+0;
$fil		=$_POST["fil"];

if($fil>0){
	$app1=" AND c_group={$fil}";
}

if($sel==1){
	$app2	="h_date";
	$prm="hist_view";

	if($asc==1){
		$app3	="ASC";
	}else{
		$app3	="DESC";
	}

}elseif($sel==2){
	$app2	="fav";
	$prm="reg_view";

	if($asc==1){
		$app3	="ASC";
	}else{
		$app3	="DESC";
	}

}elseif($sel==3){
	$app2	="birth_day";
	$prm="birth_view";

	if($asc==1){
		$app3	="ASC";
	}else{
		$app3	="DESC";
	}

}else{
	$app2	="C.id";
	$prm="reg_view";

	if($asc==1){
		$app3	="ASC";
	}else{
		$app3	="DESC";
	}
}

//■カスタマーソート
$sql	 ="SELECT id, nickname,name,regist_date,birth_day,fav,c_group,face,tel,mail,twitter,insta,facebook,line,web,block,MAX(L.sdate) AS h_date FROM wp00000_customer AS C";
$sql	.=" LEFT JOIN wp00000_cast_log AS L ON C.id=L.customer_id";
$sql	.=" WHERE C.cast_id='{$cast_data["id"]}'";
$sql	.=" AND C.del=0";
$sql	.=$app1;
$sql	.=" GROUP BY C.id";
$sql	.=" ORDER BY {$app2} {$app3}";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if(!$row["nickname"]){
			$tmp_name=$row["name"]."様";
		}else{	
			$tmp_name=$row["nickname"];
		} 
		$birth_md	=substr($row["birth_day"],4,4);

		$birth_dat[$birth_md]="n1";
		$birth_all[$birth_md][$row["id"]]["name"]=$tmp_name;
		$birth_all[$birth_md][$row["id"]]["year"]=substr($row["birth_day"],0,4);

		if($row["face"]){
			$row["face"]="<img src=\"data:image/jpg;base64,{$row["face"]}\" class=\"mail_img\">";

		}else{
			$row["face"]="<img src=\"../img/customer_no_image.png?t=".time()."\" class=\"mail_img\">";
		}

		if(!$row["birth_day"] || $row["birth_day"]=="00000000"){
			$row["yy"]="----";
			$row["mm"]="--";
			$row["dd"]="--";
			$row["ag"]="--";

		}else{
			$row["yy"]=substr($row["birth_day"],0,4);
			$row["mm"]=substr($row["birth_day"],4,2);
			$row["dd"]=substr($row["birth_day"],6,2);
			$row["ag"]= floor(($now_8-$row["birth_day"])/10000);
			$row["birth_view"]="<div class=\"customer_list_birth\"><span class=\"customer_list_icon\"></span>".$row["yy"].".".$row["mm"].".".$row["dd"]." (".$row["ag"]."歳)</div>";
		}
		$tmp_date=str_replace("-",".",substr($row["regist_date"],0,10));
		$row["reg_view"]="<div class=\"customer_list_birth\"><span class=\"customer_list_icon\"></span>".$tmp_date."</div>";

		if($row["h_date"]){
		$tmp_hist=str_replace("-",".",substr($row["h_date"],0,10));
		$row["hist_view"]="<div class=\"customer_list_birth\"><span class=\"customer_list_icon\"></span>".$tmp_hist."</div>";
		}
		$customer[]=$row;
		$cnt_coustomer++;
	}
}

for($n=0;$n<$cnt_coustomer;$n++){
	$html.="<div id=\"clist{$customer[$n]["id"]}\" class=\"customer_list\">";
	$html.="{$customer[$n]["face"]}";
	$html.="<div class=\"customer_list_fav\">";

for($f=1;$f<6;$f++){
	$html.="<span id=\"fav_{$customer[$n]["id"]}_{$f}\" class=\"customer_list_fav_icon";

if($customer[$n]["fav"]>=$f){
	$html.=" fav_in";
}
	$html.="\"></span>";
}

	$html.="</div>";
	$html.="{$customer[$n][$prm]}";
	$html.="<div class=\"customer_list_name\">{$customer[$n]["name"]} 様</div>";
	$html.="<div class=\"customer_list_nickname\">{$customer[$n]["nickname"]}</div>";
	$html.="<span class=\"mail_al\"></span>";
	$html.="<input type=\"hidden\" class=\"customer_hidden_fav\" value=\"{$customer[$n]["fav"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_yy\" value=\"{$customer[$n]["yy"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_mm\" value=\"{$customer[$n]["mm"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_dd\" value=\"{$customer[$n]["dd"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_ag\" value=\"{$customer[$n]["ag"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_group\" value=\"{$customer[$n]["c_group"]}\">";

	$html.="<input type=\"hidden\" class=\"customer_hidden_mail\" value=\"{$customer[$n]["mail"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_tel\" value=\"{$customer[$n]["tel"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_twitter\" value=\"{$customer[$n]["twitter"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_facebook\" value=\"{$customer[$n]["facebook"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_insta\" value=\"{$customer[$n]["insta"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_line\" value=\"{$customer[$n]["line"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_web\" value=\"{$customer[$n]["web"]}\">";
	$html.="</div>";
}
echo $html;




}
exit();
?>
