<?
include_once('../library/sql_cast.php');
include_once('../library/inc_code.php');
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$week[0]="日";
$week[1]="月";
$week[2]="火";
$week[3]="水";
$week[4]="木";
$week[5]="金";
$week[6]="土";
$blog_status[0]="公開";
$blog_status[1]="予約";
$blog_status[2]="非公開";
$blog_status[3]="非表示";
$blog_status[4]="削除";

$local_dt=date("Y-m-d");
$local_st=date("H:00");
$local_ed=date("H:00",time()+3600);

//Sche-----------------------
if($cast_data){
$c_month=$_POST["c_month"];
if(!$c_month) $c_month=date("Y-m-01");

$calendar[0]=date("Y-m-01",strtotime($c_month)-86400);
$calendar[1]=$c_month;
$calendar[2]=date("Y-m-01",strtotime($c_month)+3456000);
$calendar[3]=date("Y-m-01",strtotime($calendar[2])+3456000);

$month_ym[0]=substr(str_replace("-","",$calendar[0]),0,6);	
$month_ym[1]=substr(str_replace("-","",$calendar[1]),0,6);	
$month_ym[2]=substr(str_replace("-","",$calendar[2]),0,6);	

$base_w		=$day_w-$config["start_week"];
if($base_w<0) $base_w+=7;

$base_day		=$day_time-($base_w+7)*86400;
$week_st		=date("Ymd",$base_day);
$week_ed		=date("Ymd",$base_day+604800);
$month_st		=date("Ymd",strtotime($calendar[0]));
$month_ed		=date("Ymd",strtotime($calendar[3]));

$ana_ym=$_POST["ana_ym"];
if(!$ana_ym) $ana_ym=substr($day_8,0,6);
$ana_t=date("t",strtotime($ana_ym));


//analytics-----------------------
$week_01		=date("w",strtotime($c_month));
$ana_line[$config["start_week"]]=" ana_line";

if($cast_page == 1){
	$page_title="カレンダー";

}elseif($cast_page == 2){
	$page_title="顧客リスト";

}elseif($cast_page == 3){
	$page_title="Easy Talk";

}elseif($cast_page == 4){
	$page_title="ブログ";

}elseif($cast_page == 5){
	$page_title="アナリティクス";

}elseif($cast_page == 6){
	$page_title="各種設定";

}else{
	$page_title="トップページ";
}

$sql ="SELECT * FROM wp01_0cast_config";
$sql.=" WHERE cast_id='{$cast_data["id"]}'";
$sql.=" ORDER BY id DESC";
$sql.=" LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$c_sort = mysqli_fetch_assoc($result);

	if($c_sort["c_sort_main"]==1){
		$app2	="h_date";
		$prm="hist_view";

		if($c_sort["c_sort_asc"]==1){
			$app3	="ASC";
		}else{
			$app3	="DESC";
		}

	}elseif($c_sort["c_sort_main"]==2){
		$app2	="fav";
		$prm="reg_view";

		if($c_sort["c_sort_asc"]==1){
			$app3	="ASC";
		}else{
			$app3	="DESC";
		}

	}elseif($c_sort["c_sort_main"]==3){
		$app2	="birth_day";
		$prm="birth_view";

		if($c_sort["c_sort_asc"]==1){
			$app3	="ASC";
		}else{
			$app3	="DESC";
		}

	}else{
		$app2	="C.id";
		$prm="reg_view";

		if($c_sort["c_sort_asc"]==1){
			$app3	="ASC";
		}else{
			$app3	="DESC";
		}
	}
}

/*--■スケジュール--*/
$tmp_today[$day_8]="cc8";
$sql ="SELECT * FROM wp01_0sch_table";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sche_table_name[$row["in_out"]][$row["id"]]	=$row["name"];
		$sche_table_time[$row["in_out"]][$row["id"]]	=$row["time"];
		$sche_table_calc[$row["in_out"]][$row["name"]]	=$row["time"];
	}
}

//■カレンダー　スケジュール
$sql	 ="SELECT * FROM wp01_0schedule";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND sche_date BETWEEN '{$month_st}' AND '{$month_ed}'";
$sql   	.=" ORDER BY id ASC";

$ana_sche[$day_8]="<span class=\"sche_s\">休み</span>";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if($row["stime"] && $row["etime"]){
			$sche_dat[$row["sche_date"]]="n2";

			$stime[$row["sche_date"]]=$row["stime"];
			$etime[$row["sche_date"]]=$row["etime"];

			if(substr($row["stime"],2,1) == 3){
				$tmp_s=$row["stime"]+20;

			}else{
				$tmp_s=$row["stime"]+0;
			}
			
			if(substr($row["etime"],2,1) == 3){
				$tmp_e=$row["etime"]+20;

			}else{
				$tmp_e=$row["etime"]+0;
			}

			if($tmp_s<$config["start_time"]*100){
				$tmp_s+= 2400;
			}

			if($tmp_e < $config["start_time"]*100){
				$tmp_e+= 2400;
			}

			$ana_time[$row["sche_date"]]=($tmp_e-$tmp_s)/100;
			$ana_sche[$row["sche_date"]]="<span class=\"sche_s\">".substr($row["stime"],0,2).":".substr($row["stime"],2,2)."</span><span class=\"sche_m\">-</span><span class=\"sche_e\">".substr($row["etime"],0,2).":".substr($row["etime"],2,2)."</span>";

		}else{
			$sche_dat[$row["sche_date"]]="";
			$stime[$row["sche_date"]]="";
			$etime[$row["sche_date"]]="";

			$ana_time[$row["sche_date"]]=0;
			$ana_sche[$row["sche_date"]]="<span class=\"sche_s\"></span>";
		}
	}
}

if(is_array($ana_time)){
	foreach($ana_time as $a1 => $a2){
		if($ana_ym ==substr($a1,0,6)){
			if($a1<=$day_8){
				$ana_salary[$a1]=$a2*$cast_data["cast_salary"];	
				$ana_salary_all+=$a2*$cast_data["cast_salary"];	
			}
				$ana_salary_y[$a1]=$a2*$cast_data["cast_salary"];	
				$ana_salary_y_all+=$a2*$cast_data["cast_salary"];	
		}
	}
}

//■------------------
$sql ="SELECT * FROM wp01_0cast_log_table";
$sql.=" WHERE cast_id='{$cast_data["id"]}'";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$log_item[$row["id"]]=$row;
//		$log_list_cnt.='"i'.$row["sort"].'",';

		$log_item_cnt++;

	}
//	$log_list_cnt=substr($log_list_cnt,0,-1);
}

$ana_y_m=substr($ana_ym,0,4)."-".substr($ana_ym,4,2);

$sql ="SELECT log_id, sdate, SUM(log_price) AS pts, nickname,name, A.days, customer_id FROM wp01_0cast_log AS A ";
$sql.=" LEFT JOIN wp01_0cast_log_list AS B ON B.master_id=A.log_id";
$sql.=" LEFT JOIN wp01_0customer AS C ON A.customer_id=C.id";

$sql.=" WHERE A.cast_id='{$cast_data["id"]}'";
$sql.=" AND A.days LIKE '{$ana_y_m}%'";
$sql.=" AND A.del=0";
$sql.=" AND B.del=0";
$sql.=" GROUP BY log_id";
$sql.=" ORDER BY sdate ASC,stime ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$t_days=str_replace("-","",$row["days"]);
		if(!$row["nickname"]){
			$row["nickname"]=$row["name"];
		}

		$dat_ana[$t_days][]	 =$row;
		$pay_item[$t_days]	+=$row["pts"];

		if($t_days<=$day_8){
			$pay_item_all					+=$row["pts"];
		}
			$pay_item_yet					+=$row["pts"];
	}
}

$sql ="SELECT count(log_id) AS cnt, sum(pts) AS kin, sum(log_price) AS bk,nickname,name,L.customer_id FROM wp01_0cast_log AS L ";
$sql.=" LEFT JOIN wp01_0cast_log_list AS S ON L.log_id=S.master_id";
$sql.=" LEFT JOIN wp01_0customer AS C ON L.customer_id=C.id";

$sql.=" WHERE L.del=0";
$sql.=" AND (S.del=0 OR S.del IS NULL)";
$sql.=" AND L.days LIKE '{$ana_y_m}%'";

$sql.=" AND L.cast_id={$cast_data["id"]}";
$sql.=" GROUP BY L.customer_id";
$sql.=" ORDER BY cnt DESC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if(!$row["nickname"]){
			$row["nickname"]=$row["name"];
		}
		$ana_customer[]=$row;
	}
}


$sql ="SELECT log_icon, log_comm, log_price, log_color, count(log_id) AS cnt, sum(log_price) AS bk FROM wp01_0cast_log_list AS S ";
$sql.=" LEFT JOIN wp01_0cast_log AS L ON L.log_id=S.master_id";
$sql.=" WHERE L.del=0";
$sql.=" AND S.del=0";
$sql.=" AND L.days LIKE '{$ana_y_m}%'";
$sql.=" GROUP BY S.log_comm, log_icon, log_price, log_color ";
$sql.=" ORDER BY cnt DESC, log_price DESC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$ana_item[]=$row;
	}
}




$ana_st=substr($cast_data["ctime"],0,6)-1;
$ana_ed=date("Ym",strtotime($day_month)+3456000);

for($n=$ana_ed;$n>$ana_st;$n--){
	if(substr($n,-2,2) == "00"){
		$n-=88;
	}
	$ana_sel[$n]=substr($n,0,4)."年".substr($n,4,2)."月";
}

//■カレンダー　メモ
$sql	 ="SELECT * FROM wp01_0schedule_memo";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND date_8>='{$month_st}'";
$sql	.=" AND date_8<'{$month_ed}'";
$sql	.=" AND `log` IS NOT NULL";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if(trim($row["log"])){
			$memo_dat[$row["date_8"]]="n3";
	
			if($row["date_8"] == $day_8){
				$days_memo=$row["log"];
			}
		}
	}
}

//■カレンダー　ブログカウント
$sql	 ="SELECT * FROM wp01_0posts";
$sql	.=" WHERE cast='{$cast_data["id"]}'";
$sql	.=" AND status='0'";
$sql	.=" AND view_date>='{$calendar[0]}'";
$sql	.=" AND view_date<'{$calendar[3]}'";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tmp_date=substr($row["view_date"],0,4).substr($row["view_date"],5,2).substr($row["view_date"],8,2);
		$blog_dat[$tmp_date]="n4";
	}
}

//■カスタマーソート
$sql	 ="SELECT id, nickname,name,regist_date,birth_day,fav,c_group,face,tel,mail,twitter,insta,facebook,line,web,block,MAX(L.date) AS h_date FROM wp01_0customer AS C";
$sql	.=" LEFT JOIN wp01_0cast_log AS L ON C.id=L.customer_id";
$sql	.=" WHERE C.cast_id='{$cast_data["id"]}'";
$sql	.=" AND C.del=0";
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
			$row["face"]="<img src=\"data:image/jpg;base64,{$row["face"]}\" class=\"mail_img\" alt=\"会員\">";

		}else{
			$row["face"]="<img src=\"../img/customer_no_image.png?t=".time()."\" class=\"mail_img\" alt=\"会員\">";
		}

		if($c_id==$row["id"]){
			$easy_cas=$row;
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
		if($row["name"]){
			$row["name"]=$row["name"]." 様";
		}
		$customer[]=$row;
		$cnt_coustomer++;
	}
}

for($n=0;$n<3;$n++){
	$now_month	=date("m",strtotime($calendar[$n]));
	$now_ym		=date("ym",strtotime($calendar[$n]));
	$t			=date("t",strtotime($calendar[$n]));

	$wk=$config["start_week"]-date("w",strtotime($calendar[$n]));
	if($wk>0) $wk-=7;

	$st=strtotime($calendar[$n])+($wk*86400);//初日

	$v_year[$n]	=substr($calendar[$n],0,4)."年";
	$v_month[$n]=substr($calendar[$n],5,2)."月";

	for($m=0; $m<42;$m++){
		$tmp_ymd	=date("Ymd",$st+($m*86400));
		$tmp_ym		=date("ym",$st+($m*86400));
		$tmp_month	=date("m",$st+($m*86400));
		$tmp_day	=date("d",$st+($m*86400));
		$tmp_week	=date("w",$st+($m*86400));

		$app_n1="";
		$app_n2="";
		$app_n3="";
		$app_n4="";

		$tmp_w	=$m % 7;
		if($tmp_w==0){
			if($now_ym<$tmp_ym){
				break 1;
			}else{
				$cal[$n].="</tr><tr>";
			}
		}
		if($ob_holiday[$tmp_ymd]){
			$tmp_week=0;

		}elseif($tmp_ymd ==$day_8){
			$tmp_week=7;
		}

		if($now_month!=$tmp_month){
				$day_tag=" outof";

		}else{
			$day_tag=" nowmonth";

			$app_n1=$birth_dat[substr($tmp_ymd,4,4)];
			$app_n2=$sche_dat[$tmp_ymd];
			$app_n3=$memo_dat[$tmp_ymd];
			$app_n4=$blog_dat[$tmp_ymd];
		}

		$cal[$n].="<td id=\"c{$tmp_ymd}\" week=\"{$week[$tmp_w]}\" class=\"cal_td cc{$tmp_week} {$tmp_today[$tmp_ymd]} \">";
		$cal[$n].="<span class=\"dy{$tmp_week}{$day_tag}\">{$tmp_day}</span>";

		$cal[$n].="<span class=\"cal_i1 {$app_n1}\"></span>";
		$cal[$n].="<span class=\"cal_i2 {$app_n2}\"></span>";
		$cal[$n].="<span class=\"cal_i3 {$app_n3}\"></span>";
		$cal[$n].="<span class=\"cal_i4 {$app_n4}\"></span>";
		$cal[$n].="</td>";
	}
}

$tmp=date("Y-m-01 00:00:00",strtotime($day_month)+3456000);

$sql	 ="SELECT * FROM wp01_0notice";
$sql	.=" LEFT JOIN wp01_0notice_ck ON wp01_0notice.id=wp01_0notice_ck.notice_id";
$sql	.=" WHERE del='0'";
$sql	.=" AND cast_id='{$cast_data["id"]}'";
$sql	.=" AND status>0";
$sql	.=" AND date between '{$day_month}' AND '{$tmp}'";
$sql	.=" ORDER BY wp01_0notice.date DESC";
$sql	.=" LIMIT 6";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$notice[]=$row;
		$notice_count++;
	}
}

if($notice_count>5){
	$notice_count=5;
	$notice_next=" notice_next";
}

//$notice_prev=" notice_prev";

$sql	 ="SELECT * FROM wp01_0customer_item";
$sql	.=" WHERE del='0'";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$c_list_name[$row["gp"]][$row["id"]]=$row["item_name"];
		$c_list_style[$row["id"]]=$row["style"];
	}
}

$sql	 ="SELECT * FROM wp01_0customer_group";
$sql	.=" WHERE `del`='0'";
$sql	.=" AND group_id='1'";
$sql	.=" AND cast_id='{$cast_data["id"]}'";
$sql	.=" ORDER BY `sort` ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$cus_group_sel[$row["id"]]=$row;
		$cnt_cus_group_sel++;
	}
}

//■Blog------------------
$sql ="SELECT * FROM wp01_0posts";
$sql.=" WHERE cast='{$cast_data["id"]}'";
$sql.=" AND status<4";
$sql.=" AND log <>''";
$sql.=" AND title <>''";

$sql.=" ORDER BY view_date DESC";
$sql.=" LIMIT 11";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$row["log"]=str_replace("\n","<br>",$row["log"]);
		$row["date"]=substr(str_replace("-",".",$row["view_date"]),0,16);

		if($row["view_date"] > $now && $row["status"]==0){
			$row["status"]=1; 
		}

		$sql ="SELECT LEFT(`date`,10) AS t_date,COUNT(id) as cnt, value FROM wp01_0log";
		$sql.=" WHERE value='{$row["id"]}'";
		$sql.=" AND page='article.php'";
		$sql.=" GROUP BY t_date, ua, ip";

		if($result2 = mysqli_query($mysqli,$sql)){
			while($cnt = mysqli_fetch_assoc($result2)){
				$row["cnt"]++;
			}
		}
		$blog[]=$row;
		$blog_max++;
	}

	if($blog_max>10){
		$blog_max=10;
		$blog_next=1;
	}
}

$sql ="SELECT * FROM wp01_0tag";
$sql.=" WHERE tag_group='blog'";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[$row["id"]]=$row;
	}
}

$sql	 ="SELECT nickname,name, M.mail_del, M.customer_id, C.mail,C.block, M.log, MAX(M.send_date) AS last_date,COUNT((M.send_flg = 2 and M.watch_date='0000-00-00 00:00:00') or null) AS r_count,face,M.send_flg";
$sql	.=" FROM wp01_0easytalk AS M";
$sql	.=" INNER JOIN wp01_0customer AS C ON M.customer_id=C.id AND C.cast_id=M.cast_id";
$sql	.=" LEFT JOIN wp01_0easytalk AS M2 ON (M.customer_id = M2.customer_id AND M.send_date < M2.send_date)";
$sql	.=" WHERE M.cast_id='{$cast_data["id"]}'";
$sql	.=" AND M2.send_date IS NULL";
$sql	.=" AND C.del='0'";
//$sql	.=" AND M.mail_del='0'";
$sql	.=" GROUP BY M.customer_id";
$sql	.=" ORDER BY last_date DESC";

$n=0;
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if(!$row["name"]){
			$row["name"]=$row["nickname"];
		}

		if(!$row["nickname"]){
			$row["nickname"]=$row["name"];
		}

		if($row["mail_del"] ==1){

			$row["log_p"]="この投稿は削除されました";
		}else{
			$row["log_p"]=mb_substr($row["log"],0,39);
			if(mb_strlen($row["log"])>39){
				$row["log_p"].="...";
			}
		}

		$row["last_date"]=date("Y.m.d H:i",strtotime($row["last_date"]));
		$mail_data[]=$row;
	}

	if(is_array($mail_data)){
		$cnt_mail_data=count($mail_data);
	}
}

$sql	 ="SELECT * FROM wp01_0easytalk_tmpl";
$sql	 .=" WHERE cast_id={$cast_data["id"]}";
$sql	.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$easytalk_list[$row["sort"]]=$row;
	}
}

$c=strlen($cast_data["login_id"]);
for($n=0;$n<$c;$n++){
	$tmp_rnd=rand(0,19);
	$tmp_enc=substr($cast_data["login_id"],$n,1);
	$log_enc.=$dec[$tmp_rnd][$tmp_enc];
}

$log_enc.="0h";
$tmp_rnd=rand(0,19);
$tmp_set=rand(1,floor(strlen($log_enc)/2));

$c=strlen($cast_data["login_pass"]);
for($n=0;$n<$c;$n++){
	$tmp_rnd=rand(0,19);
	$tmp_enc=substr($cast_data["login_pass"],$n,1);
	$log_enc.=$dec[$tmp_rnd][$tmp_enc];
}

$set_a=substr($log_enc,0,$tmp_set*2);
$set_b=substr($log_enc,$tmp_set*2);
$log_enc=$set_b.$set_a;
$log_enc="ss".$dec[$tmp_rnd][$tmp_set].$log_enc;
}
?>

<!DOCTYPE html lang="ja"><head>
<meta charset="UTF-8">
<meta name="robots" content="noindex,nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ヒメカルテ</title>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./css/cast_sp.css?t=<?=time()?>">
<link rel="stylesheet" href="./css/cast_pc.css?t=<?=time()?>">
<link rel="stylesheet" href="./css/easytalk.css?t=<?=time()?>">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

<script src="../js/jquery.exif.js?t=<?=time()?>"></script>
<script src="./js/cast.js?t=<?=time()?>"></script>
<script src="../js/jquery.ui.touch-punch.min.js?t=<?=time()?>"></script>

<script>
const CastId='<?=$cast_data["id"] ?>'; 
const CastName='<?=$cast_data["genji"] ?>'; 

const Now_md=<?=date("md")+0?>;
const Now_Y	=<?=date("Y")+0?>;
var C_Id=0;
var C_Id_tmp=0;
/*var ChgList=[<?=$log_list_cnt?>];*/

const SNS_LINK={
	customer_line:"https://line_me/",
	customer_twitter:"https://twitter.com/",
	customer_insta:"https://instagram.com/",
	customer_facebook:"https://facebook.com/",
	customer_tel:"tel",
	customer_web:"",
};

$(function(){ 
<?if($c_sort["c_sort_group"] >0){?> 
	$('.sort_alert').show();
<?}?>

<?if($cast_page==3 && $c_id){?>
	Page=1;
	$('.mail_detail').css({'right':'0'});
	$('.easytalk_top').show();
	$(".easytalk_top_name").text('<?=$easy_cas["nickname"]?>');
	$('.easytalk_link').attr('href',"./index.php?cast_page=2&c_id=<?=$easy_cas["id"]?>");

	Customer_id		='<?=$easy_cas["id"]?>';
	Customer_Nick	='<?=$easy_cas["nickname"]?>';
	Customer_Name	='<?=$easy_cas["name"]?>';
	Customer_mail	='<?=$easy_cas["mail"]?>';

	$.post({
		url:"./post/easytalk_hist.php",
		data:{
			'c_id'		:'<?=$easy_cas["id"]?>',
			'st'		:'0',
		},
	}).done(function(data, textStatus, jqXHR){
		if(data){
			$('.mail_detail_in').html(data);
		}
	});

<?}elseif($cast_page==2 && $c_id){?>
	$('.head_mymenu_comm').addClass('arrow_customer').removeClass('arrow_top');
	ListTop=0;
	C_Id='<?=$c_id?>';

	Tmp=$('#clist'+C_Id).children('.mail_img').attr('src');
	$('#customer_img').attr('src',Tmp);

	Tmp=$('#clist'+C_Id).children('.customer_list_name').html().replace(' 様','');
	$('#customer_detail_name').val(Tmp);

	Tmp2=$('#clist'+C_Id).children('.customer_list_nickname').html();
	if(Tmp2){
		$('#customer_detail_nick').val(Tmp2);
		$('.head_mymenu_ttl').html(Tmp2);
	}else{
		$('.head_mymenu_ttl').html(Tmp+"様");
	}

	Tmp=$('#clist'+C_Id).children('.customer_hidden_fav').val();
		if(Tmp>0){
			$('#fav_1').css('color','#ff3030');
		}
		if(Tmp>1){
			$('#fav_2').css('color','#ff3030');
		}

		if(Tmp>2){
			$('#fav_3').css('color','#ff3030');
		}

		if(Tmp>3){
			$('#fav_4').css('color','#ff3030');
		}

		if(Tmp>4){
			$('#fav_5').css('color','#ff3030');
		}
	Fav=Tmp;

	$('#area').val(1);
	$('#h_customer_id').val(C_Id);
	$('#h_customer_set').val("1");
	$('#h_customer_page').val("1");

	Tmp=$('#clist'+C_Id).children('.customer_hidden_group').val();
	$('#customer_group').val(Tmp);

	Tmp=$('#clist'+C_Id).children('.customer_hidden_yy').val();
	$('#customer_detail_yy').val(Tmp);

	Tmp=$('#clist'+C_Id).children('.customer_hidden_mm').val();
	$('#customer_detail_mm').val(Tmp);

	Tmp=$('#clist'+C_Id).children('.customer_hidden_dd').val();
	$('#customer_detail_dd').val(Tmp);

	Tmp=$('#clist'+C_Id).children('.customer_hidden_ag').val();
	$('#customer_detail_ag').val(Tmp);

	Tmp=$('#clist'+C_Id).children('.customer_hidden_face').val();
	$('#img_url').val(Tmp);

	Tmp=$('#clist'+C_Id).children('.customer_hidden_fav').val();
	$('#h_customer_fav').val(Tmp);

	Tmp=$('#clist'+C_Id).children('.customer_hidden_tel').val();
	$('#h_customer_tel').val(Tmp);
	if(Tmp){
		$('#customer_tel').addClass('c_customer_tel');		
	}

	Tmp=$('#clist'+C_Id).children('.customer_hidden_mail').val();
	$('#h_customer_mail').val(Tmp);
	if(Tmp){
		$('#customer_mail').addClass('c_customer_mail');		
	}

	Tmp=$('#clist'+C_Id).children('.customer_hidden_twitter').val();
	$('#h_customer_twitter').val(Tmp);
	if(Tmp){
		$('#customer_twitter').addClass('c_customer_twitter');		
	}

	Tmp=$('#clist'+C_Id).children('.customer_hidden_facebook').val();
	$('#h_customer_facebook').val(Tmp);
	if(Tmp){
		$('#customer_facebook').addClass('c_customer_facebook');		
	}

	Tmp=$('#clist'+C_Id).children('.customer_hidden_insta').val();
	$('#h_customer_insta').val(Tmp);
	if(Tmp){
		$('#customer_insta').addClass('c_customer_insta');		
	}

	Tmp=$('#clist'+C_Id).children('.customer_hidden_line').val();
	$('#h_customer_line').val(Tmp);
	if(Tmp){
		$('#customer_line').addClass('c_customer_line');		
	}

	Tmp=$('#clist'+C_Id).children('.customer_hidden_web').val();
	$('#h_customer_web').val(Tmp);
	if(Tmp){
		$('#customer_web').addClass('c_customer_web');		
	}

	$('.menu').css({'height':'100vh'});
	$('#regist_customer').fadeOut(150);

	$.post({
		url:"./post/customer_log_read.php",
		data:{
			'c_id'		:C_Id,
		},

	}).done(function(data, textStatus, jqXHR){
		$('#tag_3_tbl').html(data);

	}).fail(function(jqXHR, textStatus, errorThrown){
		console.log(textStatus);
		console.log(errorThrown);
	});

<?}elseif($c_sort["c_sort_asc"] ==1){?> 
	$('.sort_circle').css({'left':'10vw','border-radius':'0 10px 10px 0'});
	$('.sort_btn_on1').css({'color':'#0000d0'});
	$('.sort_btn_on0').css({'color':'#b0b0a0'});
<?}?>
});
</script>

<style>
@font-face {
	font-family: at_icon;
	src: url("../font/font_0/fonts/icomoon.ttf") format('truetype');
}

<?if($cast_page==2 && $c_id){?>
.pg2{
	display:none;
}
.pg3{
	display:block;
}

.customer_detail{
	left:0;
}
<?}?>
</style>
</head>

<body class="body">
<? if(!$cast_data){ ?>
	<div class="login_box">
		<form action="./index.php" method="post">
			<span class="login_name">IDCODE</span>
			<input type="text" class="login" name="log_in_set">
			<span class="login_name">PASSWORD</span>
			<input type="password" class="login" name="log_pass_set">
			<button id="cast_login" type="submit" class="login_btn" value="send">ログイン</button>
		</form>
	</div>
	<?if($err){?>
		<div class="err">
			<?=$err?>
		</div>
	<? }?>

<?}else{?>
	<div class="head">
		<div class="head_mymenu">
			<div class="mymenu_a"></div>
			<div class="mymenu_b"></div>
			<div class="mymenu_c"></div>
		</div>	
		<div class="head_mymenu_comm">
			<div class="head_mymenu_arrow <?if($cast_page>0){?>arrow_top<?}?>"></div>
			<span class="head_mymenu_ttl"><?=$page_title?></span>
		</div>

	<?if($cast_page==1){?>
		<div id="regist_schedule" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">登録</span>
		</div>

	<?}elseif($cast_page==2){?>
		<div id="customer_down" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">通常</span>
		</div>

		<div id="customer_up" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">拡張</span>
		</div>

		<div id="regist_customer" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">新規</span>
		</div>

	<?}elseif($cast_page==30){?>
		<div id="regist_mail_set" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">作成</span>
		</div>

	<?}elseif($cast_page==4){?>
		<div id="regist_blog_fix" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">修正</span>
		</div>
		<div id="regist_blog" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">投稿</span>
		</div>

	<?}elseif($cast_page==50){?>
		<div id="regist_blog" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">変更</span>
		</div>
	<?}?>
</div>



<div class="slide">
	<?if(file_exists("../img/profile/{$cast_data["id"]}/0_s.jpg")){?>
	<img src="../img/profile/<?=$cast_data["id"]?>/0_s.jpg?t_<?=time()?>" class="slide_img" alt="TOP画像">
	<?}else{?>
	<img src="../img/cast_no_image.jpg?t_<?=time()?>" class="slide_img" alt="TOP画像">
	<?}?>
	<div class="slide_name"><?=$cast_data["genji"]?></div>
	<ul class="menu">
		<li id="m0" class="menu_1<?if($cast_page+0==0){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">トップページ</span></li>
		<li id="m1" class="menu_1<?if($cast_page+0==1){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">カレンダー</span></li>
		<li id="m2" class="menu_1<?if($cast_page+0==2){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">顧客リスト</span></li>
		<li id="m3" class="menu_1<?if($cast_page+0==3){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">EasyTalk</span></li>
		<li id="m4" class="menu_1<?if($cast_page+0==4){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">ブログ</span></li>
		<li id="m5" class="menu_1<?if($cast_page+0==5){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">アナリティクス</span></li>
		<li id="m6" class="menu_1<?if($cast_page+0==6){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">各種設定</span></li>
		<li id="m99" class="menu_1 menu_out"><span class="menu_i"></span><span class="menu_s">ログアウト</span></li>
	</ul>
</div>

<?if($cast_page==1){?>
	<div class="main_sch">
		<input id="c_month" type="hidden" value="<?=$c_month?>" name="c_month">
		<input id="week_start" type="hidden" value="<?=$config["start_week"]?>">
		<div class="cal">
			<?for($c=0;$c<3;$c++){?>
				<div>
					<table class="cal_table">
						<tr>
							<td class="cal_top" colspan="7">
								<div class="cal_title">
									<span class="cal_prev"></span>
									<span class="cal_table_ym"><span class="v_year"><?=$v_year[$c]?></span><span class="v_month"><?=$v_month[$c]?></span></span>
									<span class="cal_next"></span>
								</div>
								<div class="cal_btn">
									<div class="cal_btn_on1"></div>
									<div class="cal_btn_on2"></div>
									<div class="cal_circle"></div>
								</div>
							</td>
						</tr>

						<tr>
							<?
							for($s=0;$s<7;$s++){
							$w=($s+$config["start_week"]) % 7;
							?>
							<td class="cal_th <?=$week_tag[$w]?>"><?=$week[$w]?></td>
							<? } ?>
							<?=$cal[$c]?>
						</tr>
					</table>
				</div>
			<?}?>
		</div>
		<?$tmp_8=date("Ymd",$day_time)?>
		<?$tmp_y=date("Y",$day_time)?>
		<?$tmp_4=date("md",$day_time)?>
		<div class="cal_days">
			<span class="cal_days_date"><?=date("m月d日",$day_time)?>[<?=$week[$day_w]?>]</span>
			<span class="cal_days_sche"><span class="flex_icon"></span><span id="days_sche"><?=$ana_sche[$day_8]?></span></span>
			<span class="cal_days_birth">
				<?foreach((array)$birth_all[$tmp_4] as $a1 => $a2){?>
					<?$tmp_age=$tmp_y - $a2["year"]?>
					<span id="clist<?=$a1?>" class="cal_days_birth_in clist">
						<span class="days_icon"></span>
						<span class="days_birth"><?=$a2["name"]?>(<?=$tmp_age?>)</span>
					</span>
				<?}?>
			</span>
			<textarea class="cal_days_memo"><?=$days_memo?></textarea>
			<input id="set_date" type="hidden" value="<?=$day_8?>">
		</div>
	</div>

<?}elseif($cast_page==2){?>
	<div class="customer_sort_box">
		<select id="customer_sort_sel" class="customer_sort_sel">
			<option value="0">登録順</option>
			<option value="1" <?if($c_sort["c_sort_main"] == 1){?> selected="selected"<?}?>>履歴順</option>
			<option value="2" <?if($c_sort["c_sort_main"] == 2){?> selected="selected"<?}?>>好感順</option>
			<option value="3" <?if($c_sort["c_sort_main"] == 3){?> selected="selected"<?}?>>年齢順</option>
		</select>

		<div class="sort_btn">
			<div class="sort_btn_on0"></div>
			<div class="sort_btn_on1"></div>
			<div class="sort_circle"></div>
			<input id="customer_sort_asc" type="hidden" value="<?=$c_sort["c_sort_asc"]?>">
		</div>
		<select id="customer_sort_fil" class="customer_sort_sel">
		<option value="0">全て</option>
		<?if($cnt_cus_group_sel>0){?>
			<?foreach($cus_group_sel as $a1=>$a2){?>
				<option value="<?=$a1?>" <?if($c_sort["c_sort_group"] == $a1){?> selected="selected"<?}?>><?=$a2["tag"]?></option>
			<?}?>
		<?}?>
		</select>
		<span class="customer_sort_tag"></span>
	</div>



	<div class="main pg2">
		<div class="sort_alert">非表示になっている顧客がいます</div>

		<div class="customer_all_in">
			<?if (is_array($customer)) {?>
				<?for($n=0;$n<count($customer);$n++){?>
					<div id="clist<?=$customer[$n]["id"]?>" class="customer_list clist">
						<?=$customer[$n]["face"]?>
						<div class="customer_list_fav">
							<?for($s=1;$s<6;$s++){?>
								<span id="fav_<?=$customer[$n]["id"]?>_<?=$s?>" class="customer_list_fav_icon<?if($customer[$n]["fav"]>=$s){?> fav_in<?}?>"></span>
							<?}?>
						</div>
						<?=$customer[$n][$prm]?>
						<div class="customer_list_name"><?=$customer[$n]["name"]?></div>
						<div class="customer_list_nickname"><?=$customer[$n]["nickname"]?></div>
						<span class="mail_al"></span>
					</div>
				<?}?>

			<?}else{?>	
				<div class="no_data">登録はありません。</div>
			<? } ?>
		</div>
	</div>

<?}elseif($cast_page==3){?>
		<div class="main">
			<div class="mail_select_out">
				<div id="mail_select1" class="mail_select mail_select_on">一覧</div>
				<div id="mail_select2" class="mail_select">一括送信</div>
				<div id="mail_select3" class="mail_select">定型文</div>
			</div>
			<div id="box_mail_select1" class="mail_select_box">
				<?for($n=0;$n<$cnt_mail_data;$n++){?>
					<div id="mail_hist<?=$mail_data[$n]["customer_id"]?>" class="mail_hist <?if($mail_data[$n]["watch_date"] =="0000-00-00 00:00:00"){?> mail_yet<?}?>">
						<?if($mail_data[$n]["face"]){?>
							<img src="data:image/jpg;base64,<?=$mail_data[$n]["face"]?>" class="mail_img" alt="会員">
						<?}else{?>
							<img id="mail_img<?=$s?>" src="../img/customer_no_image.png?t=<?=time()?>" class="mail_img" alt="会員">
						<? } ?>
						<span class="mail_date"><?=$mail_data[$n]["last_date"]?></span>
						<span class="mail_log"><?=$mail_data[$n]["log_p"]?></span>
						<span class="mail_gp"></span><span id="mail_nickname<?=$s?>" class="mail_nickname"><?=$mail_data[$n]["nickname"]?></span>
						<?if($mail_data[$n]["r_count"]>0 || $mail_data[$n]["r_count"]=="9+"){?>
							<span class="mail_count"><?=$mail_data[$n]["r_count"]?></span>
						<?}?>
						<input type="hidden" class="mail_name" value="<?=$mail_data[$n]["name"]?>">
						<input type="hidden" class="mail_address" value="<?=$mail_data[$n]["mail"]?>">
						<input type="hidden" class="mail_block" value="<?=$mail_data[$n]["block"]?>">
						<?if($a1["img"]){?><input id="img_a<?=$s?>" type="hidden" value='../img/cast/mail/<?=$cast_data["id"]?>/<?=$a1["img"]?>'><? } ?>
					</div>
				<?}?>

				<?if($n < 1){ ?>
					<div class="no_data">送信履歴はありません。</div>
				<? } ?>
				<div class="mail_detail">
					<div class="mail_detail_in"></div>
				</div>

				<div class="easytalk_top">
				<span class="al_l"><span class="al_l_in"></span></span>
				<span class="easytalk_top_name"></span>
				<a href="" class="easytalk_link"><span class="notice_icon"></span> Profile</a>
				</div>
			</div>

<!--■■■■■■■■■■■■■■■-->
			<div id="box_mail_select2" class="mail_select_box">
				<div class="tmpl_send_box">
					<div class="filter_main1">
						<div class="filter_flex_in">
							<div class="filter_box">
								<span class="filter_icon"></span>
								<select id="f_type" class="filter_select">
									<option value="0">全て</option>
									<option value="1">登録日</option>
									<option value="2">利用日</option>
									<option value="3">誕生日</option>
								</select>
							</div>

							<div class="filter_box">
								<span class="filter_icon"></span>
								<input id="f_date" type="date"  value="<?=$local_dt?>" class="filter_select icon_out">
							</div>

							<div class="filter_box">
								<span class="filter_icon"></span>
								<select id="filter_tag" class="filter_select">
									<option value="0">全て</option>
									<?if($cnt_cus_group_sel > 0){?>
										<?foreach($cus_group_sel as $a1=>$a2){?>
											<option value="<?=$a1?>"><?=$a2["tag"]?></option>
										<?}?>
									<?}?>
								</select>
							</div>

							<div class="filter_box">
								<span class="filter_icon"></span>
								<select id="fav_tag" class="filter_select">
								<option value="9">全て</option>
								<option value="5">★★★★★</option>
								<option value="4">★★★★☆</option>
								<option value="3">★★★☆☆</option>
								<option value="2">★★☆☆☆</option>
								<option value="1">★☆☆☆☆</option>
								<option value="0">☆☆☆☆☆</option>
								</select>
							</div>
						</div>
						<div class="filter_box_l">
							<button class="filter_btn" type="button">検索</button>
							<label for="f_yet" class="mail_filter">
								<span class="check2">
									<input type="checkbox" id="f_yet" class="filter_check" value="1" checked="checked">
									<span class="check1"></span>
								</span>
								本日未送信
							</label>
						</div>
					</div>


					<div class="filter_main2">
						<div class="filter_flex">
							<button id="ins_name9" type="button" class="tmpl_btn" value="[本名]">本名</button>
							<button id="ins_nick9" type="button" class="tmpl_btn" value="[呼び名]">呼び名</button>
							<select class="tmpl_sel">
							<option>テンプレート選択</option>
							<?for($n=0;$n<5;$n++){?>
							<option value="<?=$n?>"><?=$easytalk_list[$n]["title"]?></option>
							<?}?>
							</select>
						</div>

						<div class="tmpl_send_out">
							<textarea id="tmpl_area9" class="tmpl_area"></textarea>
						</div>

						<div class="tmpl_send_flex">
							<img id="easytalk_f_img" src="../img/blog_no_image.png" class="mail_box_f_img">
							<button id="filter_send_btn" class="filter_send_btn" type="button"><span class="mail_box_icon"></span>メッセージを送信する</button>
						</div>
						<div class="filter_err"></div>	
					</div>
					<div class="filter_main3"></div>
				</div>
			</div>

			<div id="box_mail_select3" class="mail_select_box">
				<div class="tmpl_list">
					<div class="notice_ttl" style="justify-content: flex-end;">
						<div id="tmpl_tag0" class="tmpl_tag notice_sel">定型1</div>
						<div id="tmpl_tag1" class="tmpl_tag">定型2</div>
						<div id="tmpl_tag2" class="tmpl_tag">定型3</div>
						<div id="tmpl_tag3" class="tmpl_tag">定型4</div>
						<div id="tmpl_tag4" class="tmpl_tag lr">定型5</div>
					</div>

					<?for($n=0;$n<5;$n++){?>
						<div id="tmpl_box<?=$n?>" class="tmpl_box">
							<div class="filter_flex">
								<button id="ins_name<?=$n?>" type="button" class="tmpl_btn" value="[本名]">本名</button>
								<button id="ins_nick<?=$n?>" type="button" class="tmpl_btn" value="[呼び名]">呼び名</button>
								<button id="ins_set<?=$n?>" type="button" class="tmpl_dataset">更新</button>
							</div>
							<input id="tmpl_title<?=$n?>" type="text" value="<?=$easytalk_list[$n]["title"]?>" class="tmpl_title">
							<div class="tmpl_send_out">
								<textarea id="tmpl_area<?=$n?>" class="tmpl_area"><?=$easytalk_list[$n]["log"]?></textarea>
							</div>
						</div>
					<?}?>
				</div>
			</div>
		</div>

<!--■■■■■■■■■■■■■■■-->
	<?}elseif($cast_page==4){?>
		<div class="main">
			<div class="blog_write">
				<div class="blog_pack">
					<span class="blog_title_tag">投稿日</span><br>
					<div class="blog_box">	
						<select id="blog_yy" name="blog_yy" class="blog_4">
							<?for($n=2018;$n<date("Y")+3;$n++){?>
								<?$n1=substr("00".$n,-2,2)?>
								<option value="<?=$n?>"<?if($n == date("Y",$jst)){?> selected="selected"<?}?>><?=$n?></option>
							<?}?>
						</select>年
						<select id="blog_mm" name="blog_mm" class="blog_2">
							<?for($n=1;$n<13;$n++){?>
								<?$n1=substr("00".$n,-2,2)?>
								<option value="<?=$n1?>"<?if($n1 == date("m",$jst)){?> selected="selected"<?}?>><?=$n1?></option>
							<?}?>
						</select>月
						<select id="blog_dd" name="blog_dd" class="blog_2">
							<?for($n=1;$n<32;$n++){?>
								<?$n1=substr("00".$n,-2,2)?>
								<option value="<?=$n1?>"<?if($n1 == date("d",$jst)){?> selected="selected"<?}?>><?=$n1?></option>
							<?}?>
						</select>日　
						<select id="blog_hh" name="blog_hh" class="blog_2">
							<?for($n=0;$n<24;$n++){?>
								<?$n1=substr("00".$n,-2,2)?>
								<option value="<?=$n1?>"<?if($n1 == date("H",$jst)){?> selected="selected"<?}?>><?=$n1?></option>
							<?}?>
						</select>
						：
						<select id="blog_ii" name="blog_ii" class="blog_2">
							<?for($n=0;$n<60;$n++){?>
							<?$n1=substr("00".$n,-2,2)?>
								<option value="<?=$n1?>"<?if($n1 == date("i",$jst)){?> selected="selected"<?}?>><?=$n1?></option>
							<?}?>
						</select>
						<br>
					</div>

					<span class="blog_title_tag">タイトル</span><br>
					<input id="blog_title" type="text" name="blog_title" class="blog_title_box"><br>

					<span class="blog_title_tag">本文</span><br>
					<textarea id="blog_log" type="text" name="blog_log" class="blog_log_box"></textarea><br>
					<div class="blog_open">
						<div class="blog_open_yes yes_on">公開</div>
						<div class="blog_open_no">非公開</div>
						<input type="hidden" id="blog_status" value="0">
					</div>

					<table class="blog_table_set">
						<tr>
							<td  class="blog_td_img" rowspan="2">
							<span class="blog_img_pack">
							<img src="../img/blog_no_image.png?t=<?=time()?>" class="blog_img" alt="BLOG">

							</span>
							<span class="customer_camera"></span>
							</td>
							<td class="blog_tag_td">
								<span class="tag_icon"></span>
								<select id="blog_tag" name="blog_tag" class="blog_tag_sel">
								<?foreach($tag as $a1=> $a2){?>
									<option value="<?=$a1?>"><?=$a2["tag_name"]?></option>
								<?}?>
								</select>
								<span class=" tag_ttl">タグ</span>
							</td>
						</tr>
						<tr>
							<td class="blog_tag_td">
								<div id="blog_set" class="btn btn_l1">登録</div>　
							</td>
						</tr>
					</table>
				</div>
				<input id="blog_chg" type="hidden">
			</div>

			<div class="blog_list">
				<?for($n=0;$n<$blog_max;$n++){?>
				<div id="blog_hist_<?=$blog[$n]["id"]?>" class="blog_hist">
					<input type="hidden" class="hidden_tag" value="<?=$blog[$n]["tag"]?>">
					<input type="hidden" class="hidden_status" value="<?=$blog[$n]["status"]?>">

					<?if($blog[$n]["img"] && $blog[$n]["img_del"]<2){?>
						<img id="b_img_<?=$blog[$n]["img"]?>" src="../img/profile/<?=$cast_data["id"]?>/<?=$blog[$n]["img"]?>_s.png?t_<?=time()?>" class="hist_img">
					<?}else{?>
						<img id="b_img_" src="../img/blog_no_image.png?t_<?=time()?>" class="hist_img">
					<?}?>

					<span class="hist_date"><?=$blog[$n]["date"]?></span>
					<span class="hist_title"><?=$blog[$n]["title"]?></span>
					<span class="hist_tag">
						<span class="hist_tag_i"><?=$tag[$blog[$n]["tag"]]["tag_icon"]?></span>
						<span class="hist_tag_name"><?=$tag[$blog[$n]["tag"]]["tag_name"]?></span>
					</span>
					<span class="hist_watch"><span class="hist_i"></span><span class="hist_watch_c"><?=$blog[$n]["cnt"]+0?></span></span>
					<span class="hist_status hist_<?=$blog[$n]["status"]?>"><?=$blog_status[$blog[$n]["status"]]?></span>
				</div>

				<div class="hist_log">
					<?if($blog[$n]["img"] && $blog[$n]["img_del"]<2){?>
					<div class="hist_img_in">
						<img src="../img/profile/<?=$cast_data["id"]?>/<?=$blog[$n]["img"]?>.png?t_<?=time()?>" class="hist_img_on" alt="ブログ">
						<div class="hist_img_hide"<?if( $blog[$n]["img_del"] != 1 ){?> style="display:none;" <? } ?> >非表示</div>
					</div>
					<?}?>
					<span class="blog_log"><?=$blog[$n]["log"]?></span>
				</div>
				<? } ?>
				<?if($blog_max>10){?>
					<div class="blog_ad"><img src="../img/page/ad/bn.jpg?t=<?=time()?>" style="width:100%;" alt="AD"></div>
					<div id="blog_next_<?=$blog[10]["date"]?>" class="blog_next">続きを読む</div>
				<? } ?>
				<?if(!$blog_max){?>
					<div class="no_data">投稿されているブログはありません</div>
				<? } ?>
			</div>
		</div>

	<?}elseif($cast_page==5){?>
		<div class="main">
			<div class="mail_select_out">
				<select class="ana_sel">
				<?foreach($ana_sel as $a1 => $a2){?>
					<option value="<?=$a1?>"<?if($a1 == $ana_ym){?> selected="selected"<?}?>><?=$a2?></option>
				<?}?>
				</select>
				<input id="ana_select1" type="radio" name="ana_sele" class="rd" value="1" checked="checked"><label for="ana_select1" class="mail_select">日別</label>
				<input id="ana_select2" type="radio" name="ana_sele" class="rd" value="2"><label for="ana_select2" class="mail_select">項目別</label>
				<input id="ana_select3" type="radio" name="ana_sele" class="rd" value="3"><label for="ana_select3" class="mail_select">顧客別</label>
			</div>

			<div class="ana_box_out">

			<div id="an1" class="ana_box">
				<div class="ana_total">
					<div class="ana_res"><span class="ana_res_t">確定</span><?=number_format($ana_salary_all+$pay_item_all)?>円</div>
					<div class="ana_res"><span class="ana_res_t">全体</span><?=number_format($ana_salary_y_all+$pay_item_yet)?>円</div>
				</div>
				<table class="ana"><tr><td class="ana_top" colspan="5">日別</td></tr>
				<tr>
					<td class="ana_top">日時</td>
					<td class="ana_top">シフト</td>
					<td class="ana_top">時間</td>
					<td class="ana_top" colspan="2">給与・バック</td>
				</tr>

<?for($n=1;$n<$ana_t+1;$n++){?>
	<?
		$ana_c	=$ana_ym*100+$n;
		$ana_week	=($week_01+$n-1)%7;
		$ana_all = number_format($ana_salary_y[$ana_c] +$pay_item[$ana_c]);
		if($ana_c >$day_8){
			$f_day="ana_f";
		}
	?>
				<tr>
					<td rowspan="2" class="ana_month <?=$f_day?> <?=$ana_line[$ana_week]?>"><?=$n?>(<?=$week[$ana_week]?>)</td>
					<td rowspan="2" class="ana_sche <?=$f_day?> <?=$ana_line[$ana_week]?>"><?=$ana_sche[$ana_c]?></td>
					<td class="ana_time <?=$f_day?> <?=$ana_line[$ana_week]?>"><?=$ana_time[$ana_c]?></td>
					<td class="ana_pay <?=$f_day?> <?=$ana_line[$ana_week]?>">	
						<span class="ana_pay_all"><?=$ana_all?>円</span>
					</td>
					<td id="ana_<?=$n?>" class="ana_detail<?if($ana_all ==0){?>_n<?}?> <?=$ana_line[$ana_week]?>"><span class="ana_arrow"></span></td>
				</tr>

				<tr>
					<td id="lana_<?=$n?>" class="ana_list" colspan="3">
						<div id="dana_<?=$n?>" class="ana_list_div">
<?if($cast_data["cast_salary"]>0){?>
							<span class="ana_list_c lc1">
								<span class="ana_list_item">時給</span>
								<span class="ana_list_pts"><?=number_format($ana_salary_y[$ana_c])?>円</span>
							</span>
<?}?>
					<?$tmp_line=0;?>
					<?foreach((array)$dat_ana[$ana_c] as $a1){?>
						<?$tmp_lc=$tmp_line % 2;?>
							<span class="ana_list_c lc<?=$tmp_lc?>">
								<span class="ana_list_item"><?=$a1["nickname"]?>様</span>
								<span class="ana_list_pts"><?=number_format($a1["pts"])?>円</span>
							</span>
						<?$tmp_line++;?>
					<? } ?>
						</div>
					</td>
				</tr>
<?}?>
			</table>
		</div>

		<div class="ana_box_m">
			<div id="an3" class="ana_box">
				<table class="ana"><tr><td class="ana_top" colspan="4">顧客別</td></tr>
				<tr><td class="ana_top">名前</td><td class="ana_top">来店</td><td class="ana_top">利用金額</td><td class="ana_top">バック</td></tr>
					<?foreach((array)$ana_customer as $a1){?>
						<tr>
							<td class="ana_name"><a href="./index.php?c_id=<?=$a1["customer_id"]?>&cast_page=2" class="cal_days_birth_in"><?=$a1["nickname"]?></a></td>
							<td class="ana_ken"><?=$a1["cnt"]?></td>
							<td class="ana_pts"><?=number_format($a1["kin"])?></td>
							<td class="ana_pts"><?=number_format($a1["bk"])?></td>
						</tr>
					<?}?>
				</table>
			</div>

			<div id="an2" class="ana_box">
				<table class="ana"><tr><td class="ana_top" colspan="4">項目別</td></tr>
				<tr><td class="ana_top">項目</td><td class="ana_top">単価</td><td class="ana_top">件数</td><td class="ana_top">バック</td></tr>
					<?foreach((array)$ana_item as $a1){?>
						<tr>
							<td class="ana_name" style="color:<?=$a1["log_color"]?>"><span class="ana_icon"><?=$a1["log_icon"]?></span><?=$a1["log_comm"]?></td>
							<td class="ana_pts"><?=number_format($a1["log_price"])?></td>
							<td class="ana_ken"><?=$a1["cnt"]?></td>";
							<td class="ana_pts"><?=number_format($a1["bk"])?></td>
						</tr>
					<?}?>
				</table>
			</div>


		</div>
	</div>
	</div>
	<?}elseif($cast_page==6){?>
<div class="main">
<!--

<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">基本情報</span></div></h2>
<table class="config_img">
	<tr>
		<td class="config_img_a" rowspan="3"><img src="<?=$user_face?>?t=<?=time()?>" class="config_img_a1"></td>

//		<td id="line_face1" class="config_img_b">
//			<img id="sumb1" src="<?=$prof_img[1]?>?t=<?=time()?>" class="config_img_b1">
//			<div id="s1" class="img_btn1<?if(strpos($prof_img[1],"noimage") === FALSE){?> btn_chg<?}?><?if($user["reg_pic"]== 1){?> img_sel<?}?>">
//				<span class="icon_img icon_5s img_btn_icon"></span>
//				<span class="img_btn_txt">選択</span>
//			</div>
//			<a href="line://nv/profile" class="config_img_line"><span class="icon_img icon_line"></span><span class="text_line">LINE</span></a>
//		</td>

		<td id="line_face2" class="config_img_b">
			<img id="sumb1" src="<?=$prof_img[1]?>?t=<?=time()?>" class="config_img_b1">
			<div id="s1" class="img_btn1<?if(strpos($prof_img[1],"noimage") === FALSE){?> btn_chg<?}?><?if($user["reg_pic"]== 1){?> img_sel<?}?>">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">選択</span>
			</div>
			<div id="t1" class="img_btn1 btn_set">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">登録</span>
			</div>
			<div id="d1" class="img_btn1<?if(strpos($prof_img[1],"noimage") === FALSE){?> btn_del<?}?>">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">削除</span>
			</div>
		</td>
	</tr>
	<tr>
		<td class="config_img_b">
			<img id="sumb2" src="<?=$prof_img[2]?>?t=<?=time()?>" class="config_img_b1">
			<div id="s2" class="img_btn1<?if(strpos($prof_img[2],"noimage") === FALSE){?> btn_chg<?}?><?if($user["reg_pic"]== 2){?> img_sel<?}?>">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">選択</span>
			</div>
			<div id="t2" class="img_btn1 btn_set">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">登録</span>
			</div>
			<div id="d2" class="img_btn1<?if(strpos($prof_img[2],"noimage") === FALSE){?> btn_del<?}?>">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">削除</span>
			</div>
		</td>
	</tr>
	<tr>
		<td class="config_img_b">
			<img id="sumb3" src="<?=$prof_img[3]?>?t=<?=time()?>" class="config_img_b1">
			<div id="s3" class="img_btn1<?if(strpos($prof_img[3],"noimage") === FALSE){?> btn_chg<?}?><?if($user["reg_pic"]== 3){?> img_sel<?}?>">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">選択</span>
			</div>
			<div id="t3" class="img_btn1 btn_set">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">登録</span>
			</div>
			<div id="d3" class="img_btn1<?if(strpos($prof_img[3],"noimage") === FALSE){?> btn_del<?}?>">
				<span class="img_btn_icon"></span>
				<span class="img_btn_txt">削除</span>
			</div>
		</td>
	</tr>
</table>

<div class="config_box">
	<span class="config_tag1">USER_ID</span><span class="config_text2"><?=$cast_data["cast_id"]?></span><br>
	<span class="config_tag1">PASSWORD</span><input type="password" value="<?=$cast_data["cast_pass"]?>" class="config_text1" autocomplete="new-password"><br>
	<span class="config_tag1">名前</span><input type="text" value="<?=$cast_data["genji"]?>" class="config_text1"><br>
	<span class="config_tag1">メール</span><input type="text" value="<?=$cast_data["cast_mail"]?>" class="config_text1"><br>
	<span class="config_tag1">時給</span><input id="hourly" type="text" value="<?=$cast_data["cast_salary"]?>" class="config_text1"><br>
	<span class="config_tag2">LINE連携</span>
	<span class="config_tag2">Twitter連携</span>
</div>
<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">切替時間設定</span></div></h2>
<div class="config_box">
<div class="config_tag3">
<select id="config_day_start" class="config_tag3_sel">
<option value="0"<?if($cast_data["times_st"]==0){?> selected="selected"<?}?>>00:00</option>
<option value="1"<?if($cast_data["times_st"]==1){?> selected="selected"<?}?>>01:00</option>
<option value="2"<?if($cast_data["times_st"]==2){?> selected="selected"<?}?>>02:00</option>
<option value="3"<?if($cast_data["times_st"]==3){?> selected="selected"<?}?>>03:00</option>
<option value="4"<?if($cast_data["times_st"]==4){?> selected="selected"<?}?>>04:00</option>
<option value="5"<?if($cast_data["times_st"]==5){?> selected="selected"<?}?>>05:00</option>
<option value="6"<?if($cast_data["times_st"]==6){?> selected="selected"<?}?>>06:00</option>
<option value="7"<?if($cast_data["times_st"]==7){?> selected="selected"<?}?>>07:00</option>
<option value="8"<?if($cast_data["times_st"]==8){?> selected="selected"<?}?>>08:00</option>
<option value="9"<?if($cast_data["times_st"]==9){?> selected="selected"<?}?>>09:00</option>
<option value="10"<?if($cast_data["times_st"]==10){?> selected="selected"<?}?>>10:00</option>
<option value="11"<?if($cast_data["times_st"]==11){?> selected="selected"<?}?>>11:00</option>
<option value="12"<?if($cast_data["times_st"]==12){?> selected="selected"<?}?>>12:00</option>
<option value="13"<?if($cast_data["times_st"]==13){?> selected="selected"<?}?>>13:00</option>
<option value="14"<?if($cast_data["times_st"]==14){?> selected="selected"<?}?>>14:00</option>
<option value="15"<?if($cast_data["times_st"]==15){?> selected="selected"<?}?>>15:00</option>
<option value="16"<?if($cast_data["times_st"]==16){?> selected="selected"<?}?>>16:00</option>
<option value="17"<?if($cast_data["times_st"]==17){?> selected="selected"<?}?>>17:00</option>
<option value="18"<?if($cast_data["times_st"]==18){?> selected="selected"<?}?>>18:00</option>
<option value="19"<?if($cast_data["times_st"]==19){?> selected="selected"<?}?>>19:00</option>
<option value="20"<?if($cast_data["times_st"]==20){?> selected="selected"<?}?>>20:00</option>
<option value="21"<?if($cast_data["times_st"]==21){?> selected="selected"<?}?>>21:00</option>
<option value="22"<?if($cast_data["times_st"]==22){?> selected="selected"<?}?>>22:00</option>
<option value="23"<?if($cast_data["times_st"]==23){?> selected="selected"<?}?>>23:00</option>
</select>
<span class="config_tag3_in">一日の開始時間</span>
</div>
<div class="config_tag3">
<select id="config_week_start" class="config_tag3_sel">
<option value="0"<?if($cast_data["week_st"]==0){?> selected="selected"<?}?>>日曜日</option>
<option value="1"<?if($cast_data["week_st"]==1){?> selected="selected"<?}?>>月曜日</option>
<option value="2"<?if($cast_data["week_st"]==2){?> selected="selected"<?}?>>火曜日</option>
<option value="3"<?if($cast_data["week_st"]==3){?> selected="selected"<?}?>>水曜日</option>
<option value="4"<?if($cast_data["week_st"]==4){?> selected="selected"<?}?>>木曜日</option>
<option value="5"<?if($cast_data["week_st"]==5){?> selected="selected"<?}?>>金曜日</option>
<option value="6"<?if($cast_data["week_st"]==6){?> selected="selected"<?}?>>土曜日</option>
</select>
<span class="config_tag3_in">週の開始曜日</span>
</div>
</div>
-->

<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">顧客グループ設定</span></div></h2>
<div class="config_box">

<table class="log_item_set">
<thead>
	<tr>
		<td></td>
		<td class="log_td_top">順</td>
		<td class="log_td_top">名前</td>
		<td class="log_td_top">替</td>
	</tr>
</thead>
<tbody id="gp_sort">
	<?if($cnt_cus_group_sel > 0){?>
	<?foreach($cus_group_sel as $a1 => $a2){?>
		<tr id="gp<?=$a1?>">
			<td class="log_td_del"><span class="gp_del_in"></span></td>
			<td class="log_td_order"><?=$a2["sort"]?></td>

			<td class="log_td_name">
				<input id="gp_name_<?=$a1?>" type="text" value="<?=$a2["tag"]?>" class="gp_name">
			</td>
			<td class="gp_handle"></td>
		</tr>
	<?}?>
	<?}?>
</tbody>
	<tr>
		<td colspan="4" style="height:5px;"></td>
	</tr><tr>
		<td class="log_td_order_new" colspan="2">追加</td>
		<td class="log_td_name">
			<input id="gp_new" type="text" class="gp_name_new">
		</td>
		<td class="log_td_handle"><span id="gp_set"></span></td>
	</tr>
</table>
</div>
<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">履歴アイテム設定</span></div></h2>
<div class="config_box">
<table class="log_item_set">
<thead>
	<tr>
		<td></td>
		<td class="log_td_top">順</td>
		<td class="log_td_top">色</td>
		<td class="log_td_top">絵</td>
		<td class="log_td_top">名前(8文字)</td>
		<td class="log_td_top">金額(6桁)</td>
		<td class="log_td_top">替</td>
	</tr>
</thead>
<tbody id="item_sort">
	<?foreach($log_item as $a1 => $a2){?>
		<tr id="i<?=$a1?>">
			<td class="log_td_del"><span class="log_td_del_in"></span></td>
			<td class="log_td_order"><?=$a2["sort"]?></td>

			<td class="log_td_color">
				<div class="item_color" style="background:<?=$c_code[$a2["item_color"]]?>"></div>
				<div id="c_div<?=$a1?>" class="color_picker">
					<?foreach($c_code as $b1 => $b2){?>
						<span cd="<?=$b1?>" class="color_picker_list" style="background:<?=$b2?>;"></span>
					<?}?>
				</div>
				<input id="item_color_hidden_<?=$a1?>" class="color_hidden" type="hidden" value="<?=$a2["item_color"]?>">
			</td>

			<td class="log_td_icon" style="color:<?=$c_code[$a2["item_color"]]?>">
				<div class="item_icon"><?=$i_code[$a2["item_icon"]]?></div>
				<div id="i_div<?=$a1?>" class="icon_picker">
					<?foreach($i_code as $b1 => $b2){?>
						<span cd="<?=$b1?>" class="icon_picker_list"><?=$b2?></span>
					<?}?>
				</div>

				<input id="item_icon_hidden_<?=$a1?>" type="hidden" value="<?=$a2["item_icon"]?>">
			</td>
			<td class="log_td_name">
				<input id="item_name_<?=$a1?>" type="text" value="<?=$a2["item_name"]?>" class="item_name" maxlength="8">
			</td>
			<td class="log_td_price">
				<input id="item_price_<?=$a1?>" inputmode="numeric" type="text" inputmode="numeric" value="<?=$a2["price"]?>" class="item_price" maxlength="6">
			</td>
			<td class="log_td_handle"></td>
		</tr>
	<?}?>
</tbody>
	<tr>
		<td colspan="7" style="height:5px;"></td>
	</tr><tr>
		<td class="log_td_order_new" colspan="2">追加</td>
		<td class="log_td_color">
			<div id="new_color" class="item_color" style="background:<?=$c_code[10]?>"></div>
			<div class="color_picker">
				<?foreach($c_code as $b1 => $b2){?>
					<span cd="<?=$b1?>" class="color_picker_list" style="background:<?=$b2?>;"></span>
				<?}?>
			</div>
			<input id="color_new" type="hidden" value="10">
		</td>

		<td class="log_td_icon" style="color:<?=$c_code[0]?>">
			<div id="new_icon" class="item_icon"><?=$i_code[0]?></div>
			<div class="icon_picker">
				<?foreach($i_code as $b1 => $b2){?>
					<span cd="<?=$b1?>" class="icon_picker_list"><?=$b2?></span>
				<?}?>
			</div>
			<input id="icon_new" type="hidden" value="0">
		</td>

		<td class="log_td_name">
			<input id="name_new" type="text" value=" " class="item_name_new" maxlength="8">
		</td>
		<td class="log_td_price">
			<input id="price_new" type="text" inputmode="numeric" value="0" class="item_price_new" maxlength="6">
		</td>
		<td class="log_td_handle"><span id="new_set"></span></td>
	</tr>
</table>
</div>
<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">基本情報</span></div></h2>
<div class="config_box">
	<span class="config_tag1">ログインID</span><span class="config_text2"><?=$cast_data["login_id"]?></span><br>
	<span class="config_tag1">PASSWORD<span class="config_pass"></span></span><input type="password" value="<?=$cast_data["login_pass"]?>" class="config_text1" autocomplete="new-password"><br>
	<span class="config_tag1">メール</span><input type="text" value="<?=$cast_data["mail"]?>" class="config_text1"><br>
	<button type="submit" class="config_btn">変更する</button>
	<div class="config_notice">
	ログインIDは変更できません。<br>
	PASSWORD、メールを変更する際はログアウトされ、変更後のメールアドレスにログインURLが送信されます。30分以内にそちらからログインすることで変更が有効となります<br>
	</div>
</div>
<!--
<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">お問合せ</span></div></h2>
<div class="config_menu">お問合せ</div>
<div class="config_menu">退会</div>
<div class="config_menu">プライバシーポリシー</div>
<div class="config_menu">ご利用規約</div>
-->
</div>

	<?}else{?>
		<div class="main">
			<div class="notice_ttl">
				<div class="notice_ttl_day"><span id="notice_day"><?=date("m月d日",$day_time)?>[<?=$week[date("w",$day_time)]?>]</span></div>
				<div id="notice_ttl_0" class="notice_ttl_in notice_sel">本日</div>
				<div id="notice_ttl_1" class="notice_ttl_in">明日</div>
				<div id="notice_ttl_2" class="notice_ttl_in lr">明後日</div>
			</div>

			<?for($i=0;$i<3;$i++){?>
				<?$tmp_8=date("Ymd",$day_time+(86400*$i))?>
				<?$tmp_y=date("Y",$day_time+(86400*$i))?>
				<?$tmp_4=date("md",$day_time+(86400*$i))?>
				<input id="h_notice_ttl_<?=$i?>" type="hidden" value="<?=date("m月d日",$day_time+(86400*$i))?>[<?=$week[date("w",$day_time+(86400*$i))]?>]">
				<div id="notice_box_<?=$i?>" class="notice_box">
					<div class="notice_box_sche"><span class="notice_icon"></span><?if($ana_sche[$tmp_8]){print($ana_sche[$tmp_8]);}else{?><span class="sche_s">休み</span><?}?></div>
					<div class="notice_box_birth">				
						<?foreach((array)$birth_all[$tmp_4] as $a1 => $a2){?>
						<?$tmp_age=$tmp_y - $a2["year"]?>
						<a href="./index.php?cast_page=2&c_id=<?=$a1?>" id="c<?=$a1?>" class="cal_days_birth_in">
							<span class="days_icon"></span>
							<span class="days_birth"><?=$a2["name"]?>(<?=$tmp_age?>)</span>
						</a>
						<?}?>
					</div>
				</div>
			<?}?>

			<div class="notice_ttl">
				<div class="notice_list_in">連絡事項</div>
				<div class="notice_list_l<?=$notice_prev?>"><div class="notice_list_l2"></div></div>
				<div class="notice_list_s">1</div>
				<div class="notice_list_r<?=$notice_next?>"><div class="notice_list_r2"></div></div>
				<div class="notice_list_d">
					<select class="notice_month">
					<?foreach($ana_sel as $a1 => $a2){?>
						<option value="<?=$a1?>"<?if($a1 == $ana_ym){?> selected="selected"<?}?>><?=$a2?></option>
					<?}?>
					</select>
				</div>
			</div>

			<div class="notice_list">
				<?if($notice_count>0){?>
					<?for($n=0;$n<$notice_count;$n++){?>
						<div id="notice_box_title<?=$notice[$n]["id"]?>" class="notice_box_item nt<?=$notice[$n]["status"]?>">
							<span class="notice_d"><?=substr($notice[$n]["date"],5,2)?>月<?=substr($notice[$n]["date"],8,2)?>日</span>
							<span class="notice_t"><?=$notice[$n]["title"]?></span>
							<span class="notice_yet<?=$notice[$n]["status"]?>"></span>
						</div>
					<? } ?>
				<? }else{ ?>
						<div class="notice_box_no">お知らせはありません	</div>
				<? } ?>
			</div>
			<div class="notice_box_log"></div>
			<input type="hidden" id="notice_page" value="1">
		</div>
	<? } ?>
</div>


<div class="customer_detail">
	<div class="customer_detail_in">
		<table class="customer_base">
			<tr>
				<td class="customer_base_img" rowspan="3">
				<img id="customer_img" src="" class="customer_detail_img">
				<span class="customer_camera"></span>
				</td>
				<td class="customer_base_tag">タグ</td>
				<td class="customer_base_item">
				<select id="customer_group" name="cus_group" class="item_group cas_set">
				<option value="0">通常</option>
				<?if($cnt_cus_group_sel > 0){?>
				<?foreach($cus_group_sel as $a1=>$a2){?>
				<option value="<?=$a1?>"><?=$a2["tag"]?></option>
				<?}?>
				<?}?>
				</select>
				</td>
			</tr>
			<tr>
				<td class="customer_base_tag">名前</td>
				<td id="c_name" class="customer_base_item">
					<input type="text" id="customer_detail_name" name="cus_name" class="item_basebox cas_set">
				</td>
			</tr>
			<tr>
				<td class="customer_base_tag">呼び名</td>
				<td id="c_nick" class="customer_base_item"><input id="customer_detail_nick" name="cus_nick" type="text" class="item_basebox cas_set"></td>
			</tr>
			<tr>
				<td class="customer_base_fav">
					<span id="fav_1" class="customer_fav"></span>
					<span id="fav_2" class="customer_fav"></span>
					<span id="fav_3" class="customer_fav"></span>
					<span id="fav_4" class="customer_fav"></span>
					<span id="fav_5" class="customer_fav"></span>
				</td>
				<td class="customer_base_tag">誕生日</td>
				<td id="c_birth" class="customer_base_item">
				<select id="customer_detail_yy" name="cus_b_y" class="item_basebox_yy cas_set2">
					<?for($n=1930;$n<date("Y");$n++){?>
					<option value="<?=$n?>"><?=$n?></option>
					<?}?>
				</select>/<select id="customer_detail_mm" name="cus_b_m" class="item_basebox_mm cas_set2">
					<?for($n=1;$n<13;$n++){?>
					<option value="<?=substr("0".$n,-2,2)?>"><?=substr("0".$n,-2,2)?></option>
					<?}?>
				</select>/<select id="customer_detail_dd" name="cus_b_d" class="item_basebox_mm cas_set2">
					<?for($n=1;$n<32;$n++){?>
					<option value="<?=substr("0".$n,-2,2)?>"><?=substr("0".$n,-2,2)?></option>
					<?}?>
				</select><span class="detail_age">
					<select id="customer_detail_ag" name="cus_b_a" class="item_basebox_ag cas_set2">
						<?for($n=0;$n<date("Y")-1930;$n++){?>
						<option value="<?=$n?>"><?=$n?></option>
						<?}?>
					</select>
				歳</span>
				</td>
			</tr>
		</table>
		<table class="customer_sns">
			<tr>
				<td class="customer_sns_1"><span id="customer_mail" class="customer_sns_btn"></span></td>
				<td class="customer_sns_1"><span id="customer_line" class="customer_sns_btn"></span></td>
				<td class="customer_sns_1"><span id="customer_twitter" class="customer_sns_btn"></span></td>
				<td class="customer_sns_1"><span id="customer_insta" class="customer_sns_btn"></span></td>
				<td class="customer_sns_1"><span id="customer_facebook" class="customer_sns_btn"></span></td>
				<td class="customer_sns_1"><span id="customer_web" class="customer_sns_btn"></span></td>
				<td class="customer_sns_1"><span id="customer_tel" class="customer_sns_btn"></span></td>
			</tr>
			<tr class="customer_sns_tr">
				<td class="customer_sns_2"><span id="a_customer_mail" class="sns_arrow_a"></span></td>
				<td class="customer_sns_2"><span id="a_customer_line" class="sns_arrow_a"></span></td>
				<td class="customer_sns_2"><span id="a_customer_twitter" class="sns_arrow_a"></span></td>
				<td class="customer_sns_2"><span id="a_customer_insta" class="sns_arrow_a"></span></td>
				<td class="customer_sns_2"><span id="a_customer_facebook" class="sns_arrow_a"></span></td>
				<td class="customer_sns_2"><span id="a_customer_web" class="sns_arrow_a"></span></td>
				<td class="customer_sns_2"><span id="a_customer_tel" class="sns_arrow_a"></span></td>
			</tr>
		</table>
		<div class="customer_sns_box">
			<div class="sns_jump"><span class="regist_icon2"></span><span class="regist_txt2">移動</span></div>
			<input type="text" class="sns_text" inputmode="url">
			<div class="sns_btn"><span class="regist_icon2"></span><span class="regist_txt2">登録</span></div>
			<div class="customer_sns_ttl"></div>
		</div>

		<div class="customer_tag">
			<div id="tag_3" class="tag_set tag_set_ck"  style="height:8vw;">履歴</div>
			<div id="tag_2" class="tag_set">メモ</div>
			<div id="tag_1" class="tag_set">項目</div>
			<div id="tag_4" class="tag_set">設定</div>
			<div class="customer_memo_set"><span class="customer_set_icon"></span>新規</div>
			<div class="customer_log_set"><span class="customer_set_icon"></span>新規</div>
		</div>
	</div>

	<div class="pg3">
		<div id="tag_3_tbl" class="customer_memo"></div>
		<div id="tag_2_tbl" class="customer_memo"></div>
		<table id="tag_1_tbl" class="customer_memo"><tr><td></td></tr></table>
		<div id="tag_4_tbl" class="customer_memo"></div>
	</div>
	<input id="h_customer_id" type="hidden" name="cus_id" value="0">
	<input id="h_customer_set" type="hidden" name="cus_set" value="1">
	<input id="h_customer_page" type="hidden" name="cus_page" value="1">
	<input id="h_customer_fav" type="hidden" name="cus_fav" value="0">

	<input id="h_customer_tel" type="hidden" value="">
	<input id="h_customer_mail" type="hidden" value="">
	<input id="h_customer_twitter" type="hidden" value="">
	<input id="h_customer_facebook" type="hidden" value="">
	<input id="h_customer_insta" type="hidden" value="">
	<input id="h_customer_line" type="hidden" value="">
	<input id="h_customer_web" type="hidden" value="">

	<input id="n_customer_tel" type="hidden" value="">
	<input id="n_customer_mail" type="hidden" value="">
	<input id="n_customer_twitter" type="hidden" value="">
	<input id="n_customer_facebook" type="hidden" value="">
	<input id="n_customer_insta" type="hidden" value="">
	<input id="n_customer_line" type="hidden" value="">
	<input id="n_customer_web" type="hidden" value="">
</div>





<div class="sch_set_done">スケジュールが登録されました</div>
<div class="set_back">
	<div class="cal_weeks">
		<div id="sch_set_arrow" class="sch_set_arrow">×</div>
		<div class="cal_weeks_prev">前週</div>
		<div class="cal_weeks_box">
			<div class="cal_weeks_box_2">
				<?for($n=0;$n<21;$n++){
					$tmp_wk=($n+$config["start_week"])%7;
					$sche_8=date("Ymd",$base_day+86400*$n);
				?>
					<div class="cal_list">
						<div class="cal_day <?=$week_tag2[$tmp_wk]?>"><?=substr($sche_8,4,2)?>月<?=substr($sche_8,6,2)?>日(<?=$week[$tmp_wk]?>)</div>

						<select id="sel_in<?=$n?>" name="sel_in<?=$n?>" class="sch_time_in" <?if($day_8>$sche_8){?> style="background:#fff0fa; pointer-events: none;"<?}?>>
							<option value=""></option>
							<?foreach($sche_table_time["in"] as $a1 => $a2){?>
								<option value="<?=$a2?>" <?if($stime[$sche_8]===$a2){?> selected="selected"<?}?>><?=substr($a2,0,2)?>:<?=substr($a2,2,2)?></option>
							<?}?>
						</select>

						<div class="sch_time_m"></div>
						<select id="sel_out<?=$n?>" name="sel_out<?=$n?>" class="sch_time_out" <?if($day_8>$sche_8){?> style="background:#fff0fa; pointer-events: none;"<?}?>>
							<option class="sel_txt"></option>
							<?foreach($sche_table_time["out"] as $a1 => $a2){?>
								<option value="<?=$a2?>" <?if($etime[$sche_8]===$a2){?> selected="selected"<?}?>><?=substr($a2,0,2)?>:<?=substr($a2,2,2)?></option>
							<?}?>
						</select>

					</div>
				<? } ?>
			</div>
		</div>
		<div class="cal_weeks_next">翌週</div>
		<div class="sch_set">登録</div>
		<div id="sch_set_trush" class="sch_set_btn"></div>
		<!--div id="sch_set_copy" class="sch_set_btn"></div-->
	</div>

	<div class="customer_memo_del_back_in">
			削除します。よろしいですか
		<div class="customer_memo_del_back_in_btn">
			<div id="memo_del_set" class="btn btn_c2">削除</div>　
			<div id="memo_del_back" class="btn btn_c1">戻る</div>
		</div>
	</div>

	<div class="chg_alert">
			変更しました
	</div>

	<div class="config_mail_chg">
		登録情報を変更します。<br>
		一旦ログアウトされます。登録されるメールアドレスからログインすることで変更が有効になります。<br>

		<div class="customer_memo_del_back_in_btn">
			<div id="log_del_set" class="btn btn_c2">変更</div>　
			<div id="log_del_back" class="btn btn_c1">戻る</div>
		</div>
	</div>


	<div class="log_list_del">
		<div class="log_list_del_item">
			<span class="log_list_del_icon"></span>
			<span class="log_list_del_name">恐ろしい安酒</span>
			<span class="log_list_del_price">999999</span>
		</div>
		<div class="log_list_del_comm">
			削除します。よろしいですか<br> 
			※既に登録された履歴は削除されません。
		</div>

		<div class="log_list_del_btn">
			<div id="log_list_del_set" class="btn btn_c2">削除</div>　
			<div id="log_list_del_back" class="btn btn_c1">戻る</div>
		</div>
	</div>

	<div class="log_gp_del">
		<div class="log_gp_del_name">
			ぐるーぷ
		</div>
		<div class="log_list_del_comm">
			削除します。よろしいですか<br> 
		</div>

		<div class="log_list_del_btn">
			<div id="log_gp_del_set" class="btn btn_c2">削除</div>　
			<div id="log_gp_del_back" class="btn btn_c1">戻る</div>
		</div>
	</div>

	<div class="customer_memo_in">
		<textarea class="customer_memo_new_txt"></textarea>

		<div class="customer_log_bottom">
		<div id="memo_set" class="btn btn_c2">登録</div>
		　<div id="memo_reset" class="btn btn_c1">戻る</div>
		　<div id="memo_del" class="btn btn_c3">削除</div>
		</div>
	</div>
	<div class="customer_regist">
		<div class="customer_regist_ttl">新規顧客登録</div>
		<span class="customer_regist_no">×</span>
		<table class="customer_regist_base">
			<tr>
				<td id="set_new_img" class="customer_base_img" rowspan="3">
					<span class="regist_img_pack"><img src="../img/customer_no_image.png?t=<?=time()?>" class="regist_img" alt="会員"></span>					
					<span class="customer_camera"></span>
				</td>
				<td class="customer_base_tag">タグ</td>
					<td class="customer_base_item">
				<select id="regist_group" name="cus_group" class="item_group">
				<option value="0">通常</option>
				<?if($cnt_cus_group_sel > 0){?>
				<?foreach($cus_group_sel as $a1=>$a2){?>
				<option value="<?=$a1?>"><?=$a2["tag"]?></option>
				<?}?>
				<?}?>	
				</select>
				</td>
			</tr>

			<tr>
				<td class="customer_base_tag">名前</td>
				<td class="customer_base_item"><input type="text" id="regist_name" name="cus_name" class="item_basebox"></td>
			</tr>

			<tr>
				<td class="customer_base_tag">呼び名</td>
				<td class="customer_base_item"><input type="text" id="regist_nick" name="cus_nick" class="item_basebox"></td>
			</tr>
			<tr>
				<td class="regist_fav">
					<span id="reg_fav_1" class="reg_fav"></span>
					<span id="reg_fav_2" class="reg_fav"></span>
					<span id="reg_fav_3" class="reg_fav"></span>
					<span id="reg_fav_4" class="reg_fav"></span>
					<span id="reg_fav_5" class="reg_fav"></span>
				</td>
				<td class="customer_base_tag">誕生日</td>
				<td class="customer_base_item">
				<select id="reg_yy" name="cus_b_y" class="item_basebox_yy">
					<?for($n=1930;$n<date("Y");$n++){?>
					<option value="<?=$n?>" <?if($n==1980){?> selected="selected"<?}?>><?=$n?></option>
					<?}?>
				</select>/<select id="reg_mm" name="cus_b_m" class="item_basebox_mm">
					<?for($n=1;$n<13;$n++){?>
					<option value="<?=substr("0".$n,-2,2)?>" <?if($n==1){?> selected="selected"<?}?>><?=substr("0".$n,-2,2)?></option>
					<?}?>
				</select>/<select id="reg_dd" name="cus_b_d" class="item_basebox_mm">
					<?for($n=1;$n<32;$n++){?>
					<option value="<?=substr("0".$n,-2,2)?>" <?if($n==1){?> selected="selected"<?}?>><?=substr("0".$n,-2,2)?></option>
					<?}?>
				</select><span class="detail_age">
					<select id="reg_ag" name="cus_b_a" class="item_basebox_ag">
						<?for($n=0;$n<date("Y")-1930;$n++){?>
						<option value="<?=$n?>" <?if($n==41){?> selected="selected"<?}?>><?=$n?></option>
						<?}?>
					</select>
				歳</span>
				</td>
			</tr>
		</table>
		<div id="customer_regist_set" class="btn btn_l2">登録</div>
		<input id="regist_fav" type="hidden" value="0">
	</div>

	<div class="img_box">
		<div class="img_box_in">
			<canvas id="cvs1" width="800" height="800"></canvas>
			<div class="img_box_out1"></div>
			<div class="img_box_out2"></div>
			<div class="img_box_out3"></div>
			<div class="img_box_out4"></div>
			<div class="img_box_out5"></div>
			<div class="img_box_out6"></div>
			<div class="img_box_out7"></div>
			<div class="img_box_out8"></div>
		</div>
<!--
		<div class="img_box_in2">
			<label for="upd" class="upload_icon"></label>
			<span id="img_set_line" class="upload_icon"></span>
			<span id="img_set_twitter" class="upload_icon"></span>
			<span id="img_set_insta" class="upload_icon"></span>
			<span id="img_set_facebook" class="upload_icon"></span>　
			<span class="upload_icon upload_rote"></span>
			<span class="upload_icon upload_trush"></span>
		</div>
-->
		<div class="img_box_in2">
			<label for="upd" class="upload_btn"><span class="upload_icon_p"></span><span class="upload_txt">画像選択</span></label>
			<span class="upload_icon upload_rote"></span>
			<span class="upload_icon upload_trush"></span>
		</div>
		<div class="img_box_in3">
			<div class="zoom_mi">-</div>
			<div class="zoom_rg"><input id="input_zoom" type="range" name="num" min="100" max="300" step="1" value="100" class="range_bar"></div>
			<div class="zoom_pu">+</div><div class="zoom_box">100</div>
		</div>

		<div class="img_box_in4">
			<div id="img_set" class="btn btn_c2">登録</div>　
			<div id="img_close" class="btn btn_c1">戻る</div>　
			<div id="img_reset" class="btn btn_c3">リセット</div>
		</div>
	</div>

	<div class="customer_log_in">
		<div class="customer_log_top">
			<span class="date_icon"></span>
			<input id="local_dt" type="date" value="<?=$local_dt?>" class="local_date icon_out">
			<span class="date_icon"></span>
			<input id="local_st" type="time" value="<?=$local_st?>" class="local_time icon_out">
			<span class="local_kara">～</span>
			<input id="local_ed" type="time" value="<?=$local_ed?>" class="local_time icon_out">
		</div>

		<div class="customer_log_left">
		<div class="customer_log_left_in">
			<span class="local_tag">利用額</span>
			<input id="sel_log_pts" type="text" inputmode="numeric" class="sel_log_pts">
			<span class="sel_log_y">円</span>
		</div>
		<textarea id="sel_log_area" class="sel_log_area" placeholder="メモ："></textarea>
		</div>

		<div class="customer_log_right_out">
			<div id="sel_log_main" class="sel_log_option_top">
				<span class="sel_log_icon"></span>
				<span class="sel_log_comm">バック</span>
			</div>
			<div id="sel_log_box" class="sel_log_box">
				<?foreach($log_item as $a1){?>
				<div id="ls<?=$a1["sort"]?>" class="sel_log_option" style="color:<?=$c_code[$a1["item_color"]]?>;border:1px solid <?=$c_code[$a1["item_color"]]?>">
					<span class="sel_log_icon"><?=$i_code[$a1["item_icon"]]?></span>
					<span class="sel_log_comm"><?=$a1["item_name"]?></span>
					<span class="sel_log_price"><?=$a1["price"]?></span>
				</div>
				<?}?>
			</div>
			<div class="customer_log_right"></div>
		</div>


		<div class="customer_log_bottom">
		<div id="sel_log_set" class="btn btn_c2">登録</div>
		　<div id="sel_log_reset" class="btn btn_c1">戻る</div>
		　<div id="sel_log_del" class="btn btn_c3">削除</div>
		</div>
	</div>
</div>
<div id="wait" class="wait">
<div class="wait_in"></div>
</div>

<input id="page" type="hidden" value="<?=$cast_page?>">
<input id="img_top" type="hidden" name="img_top" value="10">
<input id="img_left" type="hidden" name="img_left" value="10">
<input id="img_width" type="hidden" name="img_width" value="10">
<input id="img_height" type="hidden" name="img_height" value="10">
<input id="img_zoom" type="hidden" name="img_zoom" value="100">
<input id="img_url" type="hidden" name="img_url" value="">
<input id="img_code" type="hidden" name="img_code" value="">
<input id="img_hidden" type="hidden" name="img_hidden" value="">

<input id="h_blog_id" type="hidden" value="">
<input id="h_blog_yy" type="hidden" value="">
<input id="h_blog_mm" type="hidden" value="">
<input id="h_blog_dd" type="hidden" value="">
<input id="h_blog_hh" type="hidden" value="">
<input id="h_blog_ii" type="hidden" value="">
<input id="h_blog_title" type="hidden" value="">
<input id="h_blog_log" type="hidden" value="">
<input id="h_blog_tag" type="hidden" value="">
<input id="h_blog_img" type="hidden" value="">
<input id="h_blog_status" type="hidden" value="">

<input id="memo_chg_id" type="hidden">
<input id="easytalk_page" type="hidden" value="1">
<input id="upd" type="file" accept="image/*" style="display:none;">
<input id="base_day" type="hidden" value="<?=$base_day?>" dd="<?=date("Ymd",$base_day)?>">
<input id="cast_id" type="hidden" value="<?=$cast_data["id"]?>">


<form id="logout" method="post">
	<input type="hidden" value="1" name="log_out">
</form>
<form id="sns_form" action="" method="post" target="_blank"></form>

<? }?>
</body>
</html>
