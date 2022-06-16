<?
include_once('../../library/sql_post.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$sel		=$_POST["sel"]+0;
$asc		=$_POST["asc"]+0;
$fil		=$_POST["fil"];

if($fil>0){
	$app1=" AND c_group={$fil}";
}

$sql ="SELECT * FROM ".TABLE_KEY."_cast_config";
$sql.=" WHERE cast_id='{$cast_data["id"]}'";
$sql.=" ORDER BY id DESC";
$sql.=" LIMIT 1";

$result = mysqli_query($mysqli,$sql);
$c_sort = mysqli_fetch_assoc($result);

if($c_sort["cast_id"]){
	$sql="UPDATE ".TABLE_KEY."_cast_config SET";
	$sql.=" c_sort_main='{$sel}',";
	$sql.=" c_sort_asc='{$asc}'";
	$sql.=" WHERE cast_id='{$cast_data["id"]}'";
	mysqli_query($mysqli,$sql);

}else{
	$sql="INSERT INTO ".TABLE_KEY."_cast_config ";
	$sql.="(cast_id, c_sort_main, c_sort_asc)";
	$sql.="VALUES";
	$sql.="('{$cast_data["id"]}','{$sel}','{$asc}')";
	mysqli_query($mysqli,$sql);
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
$sql	 ="SELECT id, nickname,name,regist_date,birth_day,fav,c_group,face,tel,mail,twitter,insta,facebook,line,web,block,MAX(L.sdate) AS h_date FROM ".TABLE_KEY."_customer AS C";
$sql	.=" LEFT JOIN ".TABLE_KEY."_cast_log AS L ON C.id=L.customer_id";
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
			$row["face"]="<img src=\"../img/cast/{$box_no}/c/{$row["face"]}.png?t=".time()."\" class=\"mail_img\" alt=\"会員\">";

		}else{
			$row["face"]="<img src=\"../img/customer_no_image.png?t=".time()."\" class=\"mail_img\" alt=\"会員\">";
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
	$html.="<div id=\"clist{$customer[$n]["id"]}\" class=\"customer_list clist\">";
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
	$html.="</div>";
}
echo $html;
exit();
?>
