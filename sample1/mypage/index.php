<?
include_once('../library/sql_cast.php');
include_once('../library/inc_code.php');

/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/

$week=array("日","月","火","水","木","金","土");
$blog_status=array("公開","予約","非公開","非表示","削除");

$local_dt=date("Y-m-d",$now_time);
$local_st=date("H:00",$now_time);
$local_ed=date("H:00",$now_time+3600);

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

$base_w		=$day_w-$admin_config["start_week"];
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
$ana_line[$admin_config["start_week"]]=" ana_line";

if($cast_page == 1){
	$page_title="カレンダー";

}elseif($cast_page == 2){
	$page_title="顧客リスト　";

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

$sql ="SELECT * FROM ".TABLE_KEY."_cast_config";
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
$sql ="SELECT * FROM ".TABLE_KEY."_sch_table";
$sql.=" WHERE del=0";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sche_table_name[$row["in_out"]][$row["id"]]	=$row["name"];
		$sche_table_time[$row["in_out"]][$row["id"]]	=$row["time"];
		$sche_table_calc[$row["in_out"]][$row["name"]]	=$row["time"];
	}
}

//■カレンダー　スケジュール
$sql	 ="SELECT * FROM ".TABLE_KEY."_schedule";
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

			if($tmp_s<$admin_config["start_time"]*100){
				$tmp_s+= 2400;
			}

			if($tmp_e < $admin_config["start_time"]*100){
				$tmp_e+= 2400;
			}

			$ana_time[$row["sche_date"]]=($tmp_e-$tmp_s)/100;
			$ana_sche[$row["sche_date"]]="<span class=\"sche_s\">".substr($row["stime"],0,2).":".substr($row["stime"],2,2)."</span><span class=\"sche_m\">-</span><span class=\"sche_e\">".substr($row["etime"],0,2).":".substr($row["etime"],2,2)."</span>";

		}else{
			$sche_dat[$row["sche_date"]]="";
			$stime[$row["sche_date"]]="";
			$etime[$row["sche_date"]]="";

			$ana_time[$row["sche_date"]]=0;
//			$ana_sche[$row["sche_date"]]="<span class=\"sche_s\"></span>";
			$ana_sche[$row["sche_date"]]="<span class=\"sche_s\">休み</span>";
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
$sql ="SELECT * FROM ".TABLE_KEY."_cast_log_table";
$sql.=" WHERE cast_id='{$cast_data["id"]}'";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$log_item[$row["id"]]=$row;
		$log_item_cnt++;
	}
}

$ana_y_m=substr($ana_ym,0,4)."-".substr($ana_ym,4,2);

$sql ="SELECT log_id, sdate, pts, nickname, name, days, customer_id FROM ".TABLE_KEY."_cast_log AS A ";
$sql.=" LEFT JOIN ".TABLE_KEY."_customer AS C ON A.customer_id=C.id";
$sql.=" WHERE A.cast_id='{$cast_data["id"]}'";
$sql.=" AND A.days LIKE '{$ana_y_m}%'";
$sql.=" AND A.del=0";
$sql.=" ORDER BY sdate ASC,stime ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		$t_days=str_replace("-","",$row["days"]);
		if(!$row["nickname"]){
			$row["nickname"]=$row["name"];
		}

		$sql ="SELECT id, log_icon, log_color, log_comm, log_price FROM ".TABLE_KEY."_cast_log_list";
		$sql.=" WHERE master_id='{$row["log_id"]}'";
		$sql.=" AND del=0";

		if($result2 = mysqli_query($mysqli,$sql)){
			while($row2 = mysqli_fetch_assoc($result2)){

				$dat_ana[$t_days][$row["customer_id"]]["pts"]+=$row2["log_price"];

				$ana_customer[$row["customer_id"]]["kin2"]	+=$row2["log_price"];

				$ana_item[$row2["log_comm"]]["log_color"]	=$row2["log_color"];
				$ana_item[$row2["log_comm"]]["log_icon"]	=$row2["log_icon"];
				$ana_item[$row2["log_comm"]]["tan"]			=$row2["log_price"];
				$ana_item[$row2["log_comm"]]["kin"]			+=$row2["log_price"];
				$ana_item[$row2["log_comm"]]["ken"]++;


				$pay_item[$t_days]+=$row2["log_price"];

				if($t_days<=$day_8){
					$pay_item_all					+=$row2["log_price"];
				}
					$pay_item_yet					+=$row2["log_price"];

			}
		}

		$dat_ana[$t_days][$row["customer_id"]]["nickname"]=$row["nickname"];

		$ana_customer[$row["customer_id"]]["nickname"]	=$row["nickname"];
		$ana_customer[$row["customer_id"]]["ken"]++;
		$ana_customer[$row["customer_id"]]["kin"]	+=$row["pts"];


	}
}

/*



$sql.=" WHERE A.cast_id='{$cast_data["id"]}'";
$sql.=" AND A.days LIKE '{$ana_y_m}%'";
$sql.=" AND A.del=0";
$sql.=" AND B.del=0";
$sql.=" ORDER BY sdate ASC,stime ASC";


		$ana_data["date_kin"][$t_days]	+=$row["log_price"];
		$ana_data["cus_kin"][$row["customer_id"]]	+=$row["log_price"];
		$ana_data["cus_ken"][$row["customer_id"]]c
		$ana_data["cus_nam"][$row["customer_id"]]=$row["nickname"];
		$ana_customer[$row["customer_id"]]["nickname"]	=$row["nickname"];
//		$ana_customer[$row["customer_id"]]["ken"][$row["log_id"]]=1;
		$ana_customer[$row["customer_id"]]["kin"]	+=$row["pts"];
		$ana_customer[$row["customer_id"]]["kin2"]	+=$row["log_price"];



		$ana_data["item_kin"][$row["log_comm"]]	+=$row["log_price"];
		$ana_data["item_ken"][$row["log_comm"]][$row["id"]]=1;


	}
}

*/



/*
$sql ="SELECT log_id, pts, nickname, name, L.customer_id FROM ".TABLE_KEY."_cast_log AS L";
$sql.=" LEFT JOIN ".TABLE_KEY."_customer AS S ON L.customer_id=S.id";

$sql.=" WHERE L.del=0";
$sql.=" AND L.days LIKE '{$ana_y_m}%'";
$sql.=" AND L.cast_id={$cast_data["id"]}";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if(!$row["nickname"]){
			$row["nickname"]=$row["name"];
		}

		$sql ="SELECT SUM( log_price) AS kin2, master_id FROM ".TABLE_KEY."_cast_log_list";
		$sql.=" WHERE del=0";
		$sql.=" AND master_id={$row["log_id"]}";
		$sql.=" GROUP BY master_id";

		$result2 = mysqli_query($mysqli,$sql);
		$row2 = mysqli_fetch_assoc($result2);
		$row["kin2"]=$row2["kin2"];

		$ana_customer[$row["customer_id"]]["nickname"]=$row["nickname"];
		$ana_customer[$row["customer_id"]]["kin"]+=$row["pts"];
		$ana_customer[$row["customer_id"]]["ken"]++;
		$ana_customer[$row["customer_id"]]["kin2"]+=$row["kin2"];
	}
}


$sql ="SELECT log_icon, log_comm, log_price, log_color, count(log_id) AS cnt, sum(log_price) AS bk FROM ".TABLE_KEY."_cast_log_list AS S ";
$sql.=" LEFT JOIN ".TABLE_KEY."_cast_log AS L ON L.log_id=S.master_id";
$sql.=" WHERE L.del=0";
$sql.=" AND S.del=0";
$sql.=" AND L.days LIKE '{$ana_y_m}%'";
$sql.=" AND L.cast_id='{$cast_data["id"]}%'";

$sql.=" GROUP BY S.log_comm, log_icon, log_price, log_color ";
$sql.=" ORDER BY cnt DESC, log_price DESC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$ana_item[]=$row;
	}
}
*/


$ana_st=substr($cast_data["ctime"],0,6)-1;
$ana_ed=date("Ym",strtotime($day_month)+3456000);

for($n=$ana_ed;$n>$ana_st;$n--){
	if(substr($n,-2,2) == "00"){
		$n-=88;
	}
	$ana_sel[$n]=substr($n,0,4)."年".substr($n,4,2)."月";
}

//■カレンダー　メモ
$sql	 ="SELECT * FROM ".TABLE_KEY."_schedule_memo";
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
$sql	 ="SELECT * FROM ".TABLE_KEY."_posts";
$sql	.=" WHERE cast='{$cast_data["id"]}'";
$sql	.=" AND status='0'";
$sql	.=" AND view_date BETWEEN '{$calendar[0]}' AND '{$calendar[3]}'";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tmp_date=substr($row["view_date"],0,4).substr($row["view_date"],5,2).substr($row["view_date"],8,2);
		$blog_dat[$tmp_date]="n4";
	}
}

//■カスタマーソート
$sql	 ="SELECT id, nickname,name,regist_date,birth_day,fav,c_group,face,tel,mail,twitter,insta,facebook,line,web,block, prm, MAX(L.date) AS h_date FROM ".TABLE_KEY."_customer AS C";
$sql	.=" LEFT JOIN ".TABLE_KEY."_cast_log AS L ON C.id=L.customer_id";
$sql	.=" WHERE C.cast_id='{$cast_data["id"]}'";
$sql	.=" AND C.del=0";
$sql	.=" GROUP BY C.id";
$sql	.=" ORDER BY {$app2} {$app3}";
//$sql	.=" LIMIT 16";


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

		if (file_exists("../img/cast/{$box_no}/c/{$row["face"]}.webp") && $admin_config["webp_select"] == 1) {
			$row["face"]="<img src=\"../img/cast/{$box_no}/c/{$row["face"]}.webp?t={$row["prm"]}\" class=\"mail_img\" alt=\"会員\">";

		}elseif (file_exists("../img/cast/{$box_no}/c/{$row["face"]}.png") ) {

			$row["face"]="<img src=\"../img/cast/{$box_no}/c/{$row["face"]}.png?t={$row["prm"]}\" class=\"mail_img\" alt=\"会員\">";

		}else{
			$row["face"]="<img src=\"../img/customer_no_image.png\" class=\"mail_img\" alt=\"会員\">";
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

		if($c_id==$row["id"]){
			$easy_cas=$row;
			if(!$row["nickname"]){
				$easy_cas["nickname"]=$row["name"];
			} 
		}

		$customer[]=$row;
		$cnt_coustomer++;
	}
}

for($n=0;$n<3;$n++){
	$now_month	=date("m",strtotime($calendar[$n]));
	$now_ym		=date("ym",strtotime($calendar[$n]));
	$t			=date("t",strtotime($calendar[$n]));

	$wk=$admin_config["start_week"]-date("w",strtotime($calendar[$n]));
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
				$cal_p[$n].="</tr><tr>";
			}
		}

		if($tmp_ymd ==$day_8){
			$tmp_week=7;

		}elseif($ob_holiday[$tmp_ymd]){
			$tmp_week=0;
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

		$cal_p[$n].="<td class=\"cal_td_p cc{$tmp_week} {$tmp_today[$tmp_ymd]} \">";
		$cal_p[$n].="<span class=\"dy_p{$tmp_week}{$day_tag}\">{$tmp_day}</span>";
		$cal_p[$n].="<span class=\"cal_p_i1 {$app_n1}\"></span>";
		$cal_p[$n].="<span class=\"cal_p_i2 {$app_n2}\"></span>";
		$cal_p[$n].="<span class=\"cal_p_i3 {$app_n3}\"></span>";
		$cal_p[$n].="<span class=\"cal_p_i4 {$app_n4}\"></span>";
		$cal_p[$n].="</td>";
	}
}

$tmp=date("Y-m-01 00:00:00",strtotime($day_month)+3456000);

$sql	 ="SELECT * FROM ".TABLE_KEY."_notice";
$sql	.=" LEFT JOIN ".TABLE_KEY."_notice_ck ON ".TABLE_KEY."_notice.id=".TABLE_KEY."_notice_ck.notice_id";
$sql	.=" WHERE del='0'";
$sql	.=" AND cast_id='{$cast_data["id"]}'";
$sql	.=" AND status>0";
$sql	.=" AND date between '{$day_month}' AND '{$tmp}'";
$sql	.=" ORDER BY ".TABLE_KEY."_notice.date DESC";
$sql	.=" LIMIT 11";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$notice[]=$row;
		$notice_count++;
	}
}

if($notice_count>10){
	$notice_count=10;
	$notice_next=" notice_next";
}

//$notice_prev=" notice_prev";

$sql	 ="SELECT * FROM ".TABLE_KEY."_customer_item";
$sql	.=" WHERE del='0'";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$c_list_name[$row["gp"]][$row["id"]]=$row["item_name"];
		$c_list_style[$row["id"]]=$row["style"];
	}
}

$sql	 ="SELECT * FROM ".TABLE_KEY."_customer_group";
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
$sql ="SELECT * FROM ".TABLE_KEY."_posts";
$sql.=" WHERE cast='{$cast_data["id"]}'";
$sql.=" AND status<4";
$sql.=" AND log <>''";
$sql.=" AND(title <>'' OR img <>'')";

$sql.=" ORDER BY view_date DESC";
$sql.=" LIMIT 12";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$row["log"]=str_replace("\n","<br>",$row["log"]);
		$row["date"]=substr(str_replace("-",".",$row["view_date"]),0,16);

		if($row["view_date"] > $now && $row["status"]==0){
			$row["status"]=1; 
		}

		$sql ="SELECT LEFT(`date`,10) AS t_date,COUNT(id) as cnt, value FROM ".TABLE_KEY."_log";
		$sql.=" WHERE value='{$row["id"]}'";
		$sql.=" AND page='article.php'";
		$sql.=" GROUP BY t_date, ua, ip";

		if($result2 = mysqli_query($mysqli,$sql)){
			while($cnt = mysqli_fetch_assoc($result2)){
				$row["cnt"]++;
			}
		}

		if($row["img"]){

			if (file_exists("../img/profile/{$cast_data["id"]}/{$row["img"]}_s.webp") && $admin_config["webp_select"] == 1) {
				$row["img_s"]="../img/profile/{$cast_data["id"]}/{$row["img"]}_s.webp?t={$row["prm"]}";			
				$row["img_l"]="../img/profile/{$cast_data["id"]}/{$row["img"]}.webp?t={$row["prm"]}";			

			}elseif (file_exists("../img/profile/{$cast_data["id"]}/{$row["img"]}_s.png")) {
				$row["img_s"]="../img/profile/{$cast_data["id"]}/{$row["img"]}_s.png?t={$row["prm"]}";
				$row["img_l"]="../img/profile/{$cast_data["id"]}/{$row["img"]}.png?t={$row["prm"]}";
			}

		}else{
			$row["img_s"]="../img/blog_no_image.png";			
		}
		$blog[]=$row;
		$blog_max++;
	}
}

$sql ="SELECT * FROM ".TABLE_KEY."_tag";
$sql.=" WHERE tag_group='blog'";
$sql.=" AND  del=0";

$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[$row["id"]]=$row;
	}
}

//------------------------------

/*
$sql	 ="SELECT nickname,name, M.mail_del, M.customer_id, C.mail,C.block, M.log, MAX(M.send_date) AS last_date,COUNT((M.send_flg = 2 and M.watch_date='0000-00-00 00:00:00') or null) AS r_count,face,M.send_flg";
$sql	.=" FROM ".TABLE_KEY."_easytalk AS M";
$sql	.=" INNER JOIN ".TABLE_KEY."_customer AS C ON M.customer_id=C.id AND C.cast_id=M.cast_id";
$sql	.=" LEFT JOIN ".TABLE_KEY."_easytalk AS M2 ON (M.customer_id = M2.customer_id AND M.send_date < M2.send_date)";
$sql	.=" WHERE M.cast_id='{$cast_data["id"]}'";
$sql	.=" AND M2.send_date IS NULL";
$sql	.=" AND C.del='0'";
$sql	.=" AND M.mail_del='0'";
$sql	.=" GROUP BY M.customer_id";
$sql	.=" ORDER BY last_date DESC";
*/

$sql	 ="SELECT COUNT(M.mail_id) AS cnt, M.customer_id FROM ".TABLE_KEY."_easytalk AS M";
$sql	.=" LEFT JOIN ".TABLE_KEY."_customer AS C ON (M.customer_id = C.id )";
$sql	.=" WHERE watch_date IS NULL";
$sql	.=" AND block<2";
$sql	.=" AND send_flg='2'";
$sql	.=" AND M.cast_id='{$cast_data["id"]}'";
$sql	.=" GROUP BY M.customer_id"; 

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$easy_midoku++;
	}
}

if($easy_midoku>9){
$easy_midoku="9+";
}

$sql	 ="SELECT M.customer_id, C.name, C.nickname, C.block, C.face, C.mail, C.prm, MAX(send_date) AS l_date, MAX(mail_id) AS m_id FROM ".TABLE_KEY."_easytalk AS M";
$sql	 .=" LEFT JOIN ".TABLE_KEY."_customer AS C ON M.customer_id=C.id AND C.cast_id=M.cast_id";
$sql	 .=" WHERE M.cast_id='{$cast_data["id"]}'";
$sql	 .=" AND mail_del=0";
$sql	 .=" AND C.del=0";
$sql	 .=" AND C.opt=0";
$sql	 .=" AND C.block<2";
$sql	 .=" AND C.mail<>''";

$sql	 .=" GROUP BY M.customer_id";
$sql	 .=" ORDER BY l_date DESC";
$sql	 .=" LIMIT 16";

$n=0;
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if(!$row["name"]){
			$row["name"]=$row["nickname"];
		}

		if(!$row["nickname"]){
			$row["nickname"]=$row["name"];
		}
	
	
		if (file_exists("../img/cast/{$box_no}/c/{$row["face"]}.webp") && $admin_config["webp_select"] == 1) {
			$row["face"]="<img src=\"../img/cast/{$box_no}/c/{$row["face"]}.webp?t={$row["prm"]}\" class=\"mail_img\" alt=\"{$row["nickname"]}様\">";

		}elseif (file_exists("../img/cast/{$box_no}/c/{$row["face"]}.png") ) {
			$row["face"]="<img src=\"../img/cast/{$box_no}/c/{$row["face"]}.png?t={$row["prm"]}\" class=\"mail_img\" alt=\"{$row["nickname"]}様\">";

		}else{
			$row["face"]="<img src=\"../img/customer_no_image.png\" class=\"mail_img\" alt=\"会員\">";
		}


		$sql	 ="SELECT log, send_flg, watch_date FROM ".TABLE_KEY."_easytalk";
		$sql	 .=" WHERE mail_id='{$row["m_id"]}'";
		$sql	 .=" ORDER BY mail_id DESC";
		$sql	 .=" LIMIT 1";

		$result2 = mysqli_query($mysqli,$sql);
		$row2 = mysqli_fetch_assoc($result2);
	
		if($row2["send_flg"] == 2 && !$row2["watch_date"]){
		$row["yet"]=1;
		}

		$row["send_flg"]=$row2["send_flg"];
		$row["log_p"]=$row2["log"];

		$row["last_date"]=date("Y.m.d H:i",strtotime($row["l_date"]));
		$mail_data[]=$row;
		$cnt_mail_data++;
	}

}



$sql	 ="SELECT * FROM ".TABLE_KEY."_easytalk_tmpl";
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
<script src="../js/jquery.exif.js"></script>
<script src="../js/jquery.ui.touch-punch.min.js"></script>
<script src="./js/cast.js?a=21>"></script>


<script>
const CastId='<?=$cast_data["id"] ?>'; 
const CastName='<?=$cast_data["genji"]?>'; 
const BaseTop='<?=$page_title?>'; 

const Now_md=<?=date("md",$day_time)+0?>;
const Now_Y	=<?=date("Y",$day_time)+0?>;

var C_Id=0;
var Customer_id=0;
var C_Id_tmp=0;
var DaySet=<?=$day_8?>

const MyMail="<?=$cast_data["mail"]?>";
const MyPass="<?=$cast_data["login_pass"]?>";

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


<?if($c_sort["c_sort_asc"] ==1){?> 
	$('.sort_circle').css({'left':'auto','right':'0','border-radius':'0 10px 10px 0'});
	$('.sort_btn_on1').css({'color':'#0000d0'});
	$('.sort_btn_on0').css({'color':'#b0b0a0'});
<?}?>

<?if($cast_page==3 && $c_id){?>
	Page=1;
	Customer_id		='<?=$c_id?>';
	Customer_Nick	='<?=$easy_cas["nickname"]?>';
	Customer_Name	='<?=$easy_cas["name"]?>';
	Customer_mail	='<?=$easy_cas["mail"]?>';

	$.post({
		url:"./post/easytalk_hist.php",
		data:{
			'c_id'		:Customer_id,
			'st'		:'0',
		},
	}).done(function(data, textStatus, jqXHR){
		Tmp="./index.php?cast_page=2&c_id="+Customer_id;
		console.log(Tmp);
		$('.mail_detail').css({'left':'0'});
		$(".easytalk_top_name").text(Customer_Nick);
		$('.easytalk_top').fadeIn(200);
		$('.mail_detail_in').html(data);
		$('.easytalk_link').attr('id',"clist" + Customer_id);

	}).fail(function(jqXHR, textStatus, errorThrown){
		console.log(textStatus);
		console.log(errorThrown);
	});
<?}?>
});
</script>

<style>
@font-face {
	font-family: at_icon;
	src: url("../font/nightparty_icon.ttf") format('truetype');
}

<?if($cast_page==1){?>
#regist_schedule{
	display:block;
}

<?}elseif($cast_page==2){?>
#regist_customer{
	display:block;
}

<?}elseif($cast_page==3){?>
.midoku_btn{
	display:block;
}

<?}elseif($cast_page==4){?>
#regist_blog, #regist_blog_fix{
	display:block;
}
<?}?>

</style>
</head>
<body class="body">



<?if($_REQUEST["log_out"] == 2){ ?>
	<div class="login_box">
	<div class="login_box_in">
	変更を受け付けました。<br>
送られたメールよりログインいただくことで変更が有効になります。<br>
※30分以上経過すると変更が無効になります。
	</div>
	</div>

<?}elseif($chg_flg){ ?>
	<div class="login_box">
		<form action="./index.php" method="post">
			<div class="login_box_in">
				新しいパスワードを入力してください。<br>		
				※30分以上経過すると変更が無効になります。
			</div>
			<input type="text" class="login" name="log_pass_chg">
			<button id="cast_login" type="submit" class="login_btn" value="send">変更する</button>
			<input type="hidden" name="chg_flg" value="<?=$chg_flg?>">
		</form>
	</div>
	<?if($err){?>
		<div class="err">
			<?=$err?>
		</div>
	<? }?>


<?}else if(!$cast_data){ ?>
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
			<div class="head_mymenu_arrow"></div>
			<span class="head_mymenu_ttl"><?=$page_title?></span>
		</div>

		<?if($easy_midoku>0){?>
			<div class="midoku_btn midoku_on">
				<span class="midoku_icon"></span>
				<span class="midoku_count"><?=$easy_midoku?></span>
			</div>
		<?}else{?>
			<div class="midoku_btn">
				<span class="midoku_icon"></span>
				<span class="midoku_count" style="display:none">0</span>
			</div>
		<?}?>


		<div id="regist_schedule" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">登録</span>
		</div>

		<div id="regist_customer" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">新規</span>
		</div>

		<div id="regist_mail_set" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">作成</span>
		</div>

		<div id="regist_blog_fix" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">修正</span>
		</div>

		<div id="regist_blog" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">投稿</span>
		</div>

		<div id="regist_blog_back" class="regist_btn">
			<span class="regist_txt">戻る</span>
			<span class="regist_icon"></span>
		</div>

		<div id="customer_down" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">通常</span>
		</div>

		<div id="customer_up" class="regist_btn">
			<span class="regist_icon"></span>
			<span class="regist_txt">拡張</span>
		</div>
	</div>

<div class="slide">

	<?if (file_exists("../img/profile/{$cast_data["id"]}/0_s.webp") && $admin_config["webp_select"] == 1) {?>
	<img src="../img/profile/<?=$cast_data["id"]?>/0_s.webp?t_<?=$cast_data["prm"]?>" class="slide_img" alt="TOP画像">
	<?}elseif(file_exists("../img/profile/{$cast_data["id"]}/0_s.jpg")){?>
	<img src="../img/profile/<?=$cast_data["id"]?>/0_s.jpg?t_<?=$cast_data["prm"]?>" class="slide_img" alt="TOP画像">
	<?}else{?>
	<img src="../img/cast_no_image.jpg?t_<?=time()?>" class="slide_img" alt="TOP画像">
	<?}?>
	<div class="slide_name"><?=$cast_data["genji"]?></div>
	<ul class="menu">
		<li id="m0" class="menu_1<?if($cast_page+0==0){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">トップページ</span></li>
		<li id="m1" class="menu_1<?if($cast_page+0==1){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">カレンダー</span></li>
		<li id="m2" class="menu_1<?if($cast_page+0==2){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">顧客リスト</span></li>
		<li id="m3" class="menu_1<?if($cast_page+0==3){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">EasyTalk</span><?if($easy_midoku>0){?><span class="easy_midoku"><?=$easy_midoku?></span><?}?></li>
		<li id="m4" class="menu_1<?if($cast_page+0==4){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">ブログ</span></li>
		<li id="m5" class="menu_1<?if($cast_page+0==5){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">アナリティクス</span></li>
		<li id="m6" class="menu_1<?if($cast_page+0==6){?> menu_sel<?}?>"><span class="menu_i"></span><span class="menu_s">各種設定</span></li>
		<li id="m99" class="menu_1 menu_out"><span class="menu_i"></span><span class="menu_s">ログアウト</span></li>
	</ul>
</div>






<div class="body_in">
<?if($cast_page==1){?>
	<div class="main_sch">
		<input id="c_month" type="hidden" value="<?=$c_month?>" name="c_month">
		<input id="week_start" type="hidden" value="<?=$admin_config["start_week"]?>">
		<div class="cal_out">
			<div class="cal">
				<?for($c=0;$c<3;$c++){?>
					<div class="cal_pack">
						<table class="cal_table">
							<tr>
								<td class="cal_top" colspan="7">
									<div class="cal_title">
										<div class="cal_prev"></div>
										<div class="cal_table_ym"><span class="v_year"><?=$v_year[$c]?></span><span class="v_month"><?=$v_month[$c]?></span></div>
										<div class="cal_next"></div>
									</div>
								</td>
							</tr>
							<tr>
								<?
								for($s=0;$s<7;$s++){
								$w=($s+$admin_config["start_week"]) % 7;
								?>
								<td class="cal_th <?=$week_tag[$w]?>"><?=$week[$w]?></td>
								<? } ?>
								<?=$cal[$c]?>
							</tr>
						</table>
					</div>
				<?}?>
			</div>
		</div>

<?for($n=0;$n<3;$n++){?>
		<div class="cal_<?=$n?> pc_only">
		<div class="cal_p_out">
			<table class="cal_table_p">
				<tr>
					<td class="cal_top_p" colspan="7">
						<span class="v_year_p"><?=$v_year[$n]?></span>
						<span class="v_month_p"><?=$v_month[$n]?></span>
					</td>
				</tr>
				<tr>
					<?
					for($s=0;$s<7;$s++){
					$w=($s+$admin_config["start_week"]) % 7;
					?>
					<td class="cal_th_p <?=$week_tag[$w]?>"><?=$week[$w]?></td>
					<? } ?>
					<?=$cal_p[$n]?>
				</tr>
			</table>
		</div>
	</div>
<? } ?>
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
		<div id="regist_schedule_pc">
			<span class="regist_icon_sch"></span>
			<span class="regist_txt_sch">登録</span>
		</div>

	</div>

<?}elseif($cast_page==2){?>
	<div class="main main_top">
		<div class="sub_header">
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

			<span class="customer_sort_tag"></span>
			<select id="customer_sort_fil" class="customer_sort_sel">
				<option value="0">全て</option>
				<?if($cnt_cus_group_sel>0){?>
					<?foreach($cus_group_sel as $a1=>$a2){?>
						<option value="<?=$a1?>" <?if($c_sort["c_sort_group"] == $a1){?> selected="selected"<?}?>><?=$a2["tag"]?></option>
					<?}?>
				<?}?>
			</select>
			<div id="regist_customer_pc" class="regist_btn pc_only">
				<span class="regist_icon"></span>
				<span class="regist_txt">新規</span>
			</div>
		</div>

		<div class="customer_top">　</div>
		<div class="sort_alert_out"><span class="sort_alert">非表示になっている顧客がいます</span></div>
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
				<div id="cid0" class="customer_all_btm">

			<?}else{?>	
				<div class="no_data">登録はありません。</div>
			<? } ?>
		</div>
	</div>

<?}elseif($cast_page==3){?>
<script>
$(function(){
	$('.mail_yet').on('click',function(){
		$('.midoku_count,.easy_midoku').fadeOut(1000);
	})
});
</script>
	<div class="main main_top">
		<div class="sub_header">
			<div id="mail_select1" class="mail_select mail_select_on">一覧</div>
			<div id="mail_select2" class="mail_select">一括送信</div>
			<div id="mail_select3" class="mail_select">定型文</div>
			<label id="l_send_ok" for="send_ok" class="mail_filter">
				<span class="check2">
					<input type="checkbox" id="send_ok" class="filter_check" value="1" checked="checked">
					<span class="check1"></span>
				</span>
				送信可能のみ
			</label>
			<div class="midoku_btn_out pc_only">
				<?if($easy_midoku>0){?>
					<div class="midoku_btn midoku_on">
						<span class="midoku_icon"></span>
						<span class="midoku_count"><?=$easy_midoku?></span>
					</div>
				<?}else{?>
					<div class="midoku_btn">
						<span class="midoku_icon"></span>
						<span class="midoku_count" style="display:none">0</span>
					</div>
				<?}?>
			</div>
		</div>

		<div id="box_mail_select1" class="mail_select_box">
			<?for($n=0;$n<$cnt_mail_data;$n++){?>
				<div id="mail_hist<?=$mail_data[$n]["customer_id"]?>" class="mail_hist <?if($mail_data[$n]["yet"] == 1){?> mail_yet<?}?>">
					<?=$mail_data[$n]["face"]?>

					<span class="mail_date"><?=$mail_data[$n]["last_date"]?></span>
					<span class="mail_log"><?=$mail_data[$n]["log_p"]?></span>
					<span class="mail_gp"></span><span id="mail_nickname<?=$s?>" class="mail_nickname"><?=$mail_data[$n]["nickname"]?></span>
					<div class="mail_count"></div>
					<input type="hidden" class="mail_name" value="<?=$mail_data[$n]["name"]?>">
					<input type="hidden" class="mail_address" value="<?=$mail_data[$n]["mail"]?>">
					<input type="hidden" class="mail_block" value="<?=$mail_data[$n]["block"]?>">
					<?if($a1["img"]){?><input id="img_a<?=$s?>" type="hidden" value='../img/cast/mail/<?=$cast_data["id"]?>/<?=$a1["img"]?>'><? } ?>
				</div>
			<?}?>

			<?if($n < 1){ ?>
				<div class="no_data">送信履歴はありません。</div>
			<? } ?>
		</div>

			<div class="mail_detail">
				<div class="mail_detail_in"></div>
			</div>
			<div class="easytalk_top">
				<span class="al_l"><span class="al_l_in"></span></span><span class="easytalk_top_comm">一覧に戻る</span>
				<span id="clist<?=$customer[$n]["id"]?>" class="easytalk_link clist"><span class="easytalk_top_name"><?=$customer[$n]["nickname"]?></span>さんのProfile <span class="notice_icon"></span> </span>
			</div>

<!--■■■■■■■■-->
		<div id="box_mail_select2" class="mail_select_box">
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
					<button id="ins_name9" type="button" class="tmpl_btn" value="[名前]">名前</button>
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

<!--■■■■■■■■■■■■■■■-->
		<div id="box_mail_select3" class="mail_select_box">
			<div class="tmpl_list">
				<div class="tmpl_tab">
					<div id="tmpl_tag0" class="tmpl_tag notice_sel">定型1</div>
					<div id="tmpl_tag1" class="tmpl_tag">定型2</div>
					<div id="tmpl_tag2" class="tmpl_tag">定型3</div>
					<div id="tmpl_tag3" class="tmpl_tag">定型4</div>
					<div id="tmpl_tag4" class="tmpl_tag lr">定型5</div>
				</div>

				<?for($n=0;$n<5;$n++){?>
					<div id="tmpl_box<?=$n?>" class="tmpl_box">
						<div class="filter_flex">
							<button id="ins_name<?=$n?>" type="button" class="tmpl_btn" value="[名前]">名前</button>
							<button id="ins_nick<?=$n?>" type="button" class="tmpl_btn" value="[呼び名]">呼び名</button>
							<button id="ins_set<?=$n?>" type="button" class="tmpl_dataset">更新</button>
						</div>
						<input id="tmpl_title<?=$n?>" type="text" value="<?=$easytalk_list[$n]["title"]?>" class="tmpl_title">
						<div class="tmpl_send_out">
							<textarea id="tmpl_area<?=$n?>" class="tmpl_area" maxlength="10000"><?=$easytalk_list[$n]["log"]?></textarea>
						</div>
					</div>
				<?}?>
			</div>
		</div>

<!--■■■■■■■■■■■■■■■-->
<?}elseif($cast_page==4){?>
	<div class="main main_top">

		<div class="sub_header">
			<select id="blog_sel1" class="customer_sort_sel">
				<option value="0">登録順</option>
				<option value="1" <?if($c_sort["c_sort_main"] == 1){?> selected="selected"<?}?>>閲覧順</option>
			</select>

			<select id="blog_sel2" class="customer_sort_sel">
				<option value="9">全て</option>
				<option value="0">公開</option>
				<option value="1">予約</option>
				<option value="2">非公開</option>
				<option value="3">非表示</option>
			</select>

			<span class="customer_sort_tag"></span>

			<select id="blog_sel3" class="customer_sort_sel">
				<option value="0">全て</option>
				<?foreach($tag as $a1=> $a2){?>
					<option value="<?=$a1?>"><?=$a2["tag_name"]?></option>
				<?}?>
			</select>

			<div class="blog_pc pc_only">
				<div id="regist_blog_fix" class="regist_btn">
					<span class="regist_icon"></span>
					<span class="regist_txt">修正</span>
				</div>
				<div id="regist_blog" class="regist_btn">
					<span class="regist_icon"></span>
					<span class="regist_txt">投稿</span>
				</div>
			</div>
		</div>

		<div class="blog_list">
			<?for($n=0;$n<$blog_max;$n++){?>
			<div id="blog_hist_<?=$blog[$n]["id"]?>" class="blog_hist">
				<input type="hidden" class="hidden_tag" value="<?=$blog[$n]["tag"]?>">
				<input type="hidden" class="hidden_status" value="<?=$blog[$n]["status"]?>">
				<img src="<?=$blog[$n]["img_s"]?>" class="hist_img">

				<div class="img_block" <?if($blog[$n]["img_del"] !=1){?>style="display:none"<?}?>>非表示</div>
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
				<?if($blog[$n]["img_l"]){?>
				<div class="hist_img_in">
					<img src="<?=$blog[$n]["img_l"]?>" class="hist_img_on" alt="ブログ">
					<div class="hist_img_hide"<?if( $blog[$n]["img_del"] != 1 ){?> style="display:none;" <? } ?> >非表示</div>
				</div>
				<?}?>
				<span class="blog_log"><?=$blog[$n]["log"]?></span>
			</div>
			<? } ?>
			<?if(!$blog_max){?>
				<div class="no_data">投稿されているブログはありません</div>
			<? } ?>
		</div>

		<div class="blog_write">
			<div class="blog_pack">
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
					<div class="blog_back pc_only">
						<span class="regist_txt">戻る</span>
						<span class="regist_icon"></span>
					</div>
				</div>

				<input id="blog_title" type="text" name="blog_title" class="blog_title_box" placeholder="タイトル"maxlength="100";><br>
				<textarea id="blog_log" type="text" name="blog_log" class="blog_log_box" placeholder="本文" maxlength="10000";></textarea><br>

				<div class="blog_table_set">
					<span class="blog_img_pack">
						<img src="../img/blog_no_image.png?t=<?=time()?>" class="blog_img" alt="BLOG">
					</span>
					<div class="blog_open">
						<div class="blog_open_yes yes_on">公開</div>
						<div class="blog_open_no">非公開</div>
						<input type="hidden" id="blog_status" value="0">
					</div>
					<select id="blog_tag" name="blog_tag" class="blog_tag_sel">
					<?foreach($tag as $a1=> $a2){?>
						<option value="<?=$a1?>"><?=$a2["tag_name"]?></option>
					<?}?>
					</select>
					<span class="tag_ttl"><span class="tag_icon"></span>タグ</span>

					<div id="blog_set" class="btn btn_l1">登録</div>　
				</div>
			</div>
			<input id="blog_chg" type="hidden">
		</div>
	</div>

<?}elseif($cast_page==5){?>
	<div class="main main_top">
		<div class="sub_header">
			<select class="ana_sel">
			<?foreach($ana_sel as $a1 => $a2){?>
				<option value="<?=$a1?>"<?if($a1 == $ana_ym){?> selected="selected"<?}?>><?=$a2?></option>
			<?}?>
			</select>
			<input id="ana_select1" type="radio" name="ana_sele" class="rd" value="1" checked="checked"><label for="ana_select1" class="mail_select sp_only_div">日別</label>
			<input id="ana_select2" type="radio" name="ana_sele" class="rd" value="2"><label for="ana_select2" class="mail_select sp_only_div">項目別</label>
			<input id="ana_select3" type="radio" name="ana_sele" class="rd" value="3"><label for="ana_select3" class="mail_select sp_only_div">顧客別</label>
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
				<td rowspan="2" class="ana_sche <?=$f_day?> <?=$ana_line[$ana_week]?>"><?if($ana_time[$ana_c]>0){print($ana_sche[$ana_c]);}?></td>
				<td class="ana_time <?=$f_day?> <?=$ana_line[$ana_week]?>"><?if($ana_time[$ana_c]>0){print($ana_time[$ana_c]);}?></td>
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

				<?foreach((array)$dat_ana[$ana_c] as $a1 => $a2){?>
					<?$tmp_lc=$tmp_line % 2;?>
						<span class="ana_list_c lc<?=$tmp_lc?>">
							<span id="clist<?=$a1?>" class="ana_list_item clist"><?=$a2["nickname"]?>様</span>
								<span class="ana_list_pts"><?=number_format($a2["pts"])?>円</span>

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
			<div id="an2" class="ana_box">
				<table class="ana"><tr><td class="ana_top" colspan="4">項目別</td></tr>
				<tr><td class="ana_top ana_name">項目</td><td class="ana_top ana_pts">単価</td><td class="ana_top ana_ken">件数</td><td class="ana_top ana_pts">バック</td></tr>
					<?foreach((array)$ana_item as $a1 => $a2){?>
						<tr>
							<td class="ana_name" style="color:<?=$a2["log_color"]?>"><span class="ana_icon"><?=$a2["log_icon"]?></span><?=$a1?></td>
							<td class="ana_pts"><?=number_format($a2["tan"])?></td>
							<td class="ana_ken"><?=$a2["ken"]?></td>";
							<td class="ana_pts"><?=number_format($a2["kin"])?></td>
						</tr>
					<?}?>
				</table>
			</div>

			<div id="an3" class="ana_box">
				<table class="ana"><tr><td class="ana_top" colspan="4">顧客別</td></tr>
				<tr><td class="ana_top ana_name">名前</td><td class="ana_top ana_ken">来店</td><td class="ana_top ana_pts">利用金額</td><td class="ana_top ana_pts">バック</td></tr>
					<?foreach((array)$ana_customer as $a1 =>$a2){?>
						<tr>
							<td class="ana_name"><span id="clist<?=$a1?>" class="cal_days_birth_in clist"><?=$a2["nickname"]?></span></td>
							<td class="ana_ken"><?=$a2["ken"]?></td>
							<td class="ana_pts"><?=number_format($a2["kin"])?></td>
							<td class="ana_pts"><?=number_format($a2["kin2"])?></td>
						</tr>
					<?}?>
				</table>
			</div>
		</div>
	</div>
	</div>

<?}elseif($cast_page==6){?>
	<div class="main">
<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">顧客グループ設定</span></h2>
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

<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">履歴アイテム設定</span></h2>
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

<h2 class="h2_config"><div class="h2_config_1"></div><div class="h2_config_2"></div><div class="h2_config_3"></div><span class="h2_config_4">基本情報</span></h2>
<div class="config_box">
	<span class="config_tag1">ログインID</span><span class="config_text2"><?=$cast_data["login_id"]?></span><br>
	<span class="config_tag1">PASSWORD<span class="config_pass"></span></span><input id="mydata_p" type="password" value="<?=$cast_data["login_pass"]?>" class="config_text1"><br>
	<span class="config_tag1">メール</span><input id="mydata_m" type="text" value="<?=$cast_data["mail"]?>" class="config_text1"><br>

	<button id="config_chg" type="button" class="config_btn">変更する</button>

	<div class="config_notice">
		ログインIDは変更できません。<br>
		PASSWORD、メールを変更する際はログアウトされ、変更後のメールアドレスにログインURLが送信されます。30分以内にそちらからログインすることで変更が有効となります<br>
	</div>
</div>

<?}else{?>
	<div class="main">
		<div class="notice_ttl_a">
			<div class="notice_ttl_day"><span id="notice_day"><?=date("m月d日",$day_time)?>[<?=$week[date("w",$day_time)]?>]</span></div>
			<div id="notice_ttl_0" class="notice_ttl_in notice_sel">本日</div>

			<div id="notice_ttl_1" class="notice_ttl_in">明日</div>
			<div id="notice_ttl_2" class="notice_ttl_in lr">明後日</div>
		</div>

		<div class="notice_box_out">
		<?for($i=0;$i<3;$i++){?>
			<?$tmp_8=date("Ymd",$day_time+(86400*$i))?>
			<?$tmp_y=date("Y",$day_time+(86400*$i))?>
			<?$tmp_4=date("md",$day_time+(86400*$i))?>
			<input id="h_notice_ttl_<?=$i?>" type="hidden" value="<?=date("m月d日",$day_time+(86400*$i))?>[<?=$week[date("w",$day_time+(86400*$i))]?>]">
			<div id="notice_box_<?=$i?>" class="notice_box">
				<div class="pc_only notice_box_title"><?=date("m月d日",$day_time+(86400*$i))?>[<?=$week[date("w",$day_time+(86400*$i))]?>]</div>
				<div class="notice_box_sche"><span class="notice_icon"></span><?if($ana_sche[$tmp_8]){print($ana_sche[$tmp_8]);}else{?><span class="sche_s">休み</span><?}?></div>
				<div class="notice_box_birth">				
					<?foreach((array)$birth_all[$tmp_4] as $a1 => $a2){?>
					<?$tmp_age=$tmp_y - $a2["year"]?>
					<span id="clist<?=$a1?>" class="cal_days_birth_in clist">
						<span class="days_icon"></span>
						<span class="days_birth"><?=$a2["name"]?>(<?=$tmp_age?>)</span>
					</span>
					<?}?>
				</div>
			</div>
		<?}?>
		</div>


		<div class="notice_flex">
			<div class="notice_menu">
				<div class="notice_ttl_b">
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
			</div>
			<div class="notice_box_log"></div>
		</div>
		<input type="hidden" id="notice_page" value="1">
	</div>
<? } ?>
<div class="customer_detail"></div>
<div class="sch_set_done">スケジュールが登録されました</div>

<div class="set_back">
	<div class="cal_weeks popup">
		<div id="sch_set_arrow" class="sch_set_arrow">×</div>
		<div class="cal_weeks_prev">前週</div>
		<div class="cal_weeks_box">
			<div class="cal_weeks_box_2">
				<?for($n=0;$n<21;$n++){
					$tmp_wk=($n+$admin_config["start_week"])%7;
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

	<div class="customer_memo_del_back_in popup">
			削除します。よろしいですか
		<div class="customer_memo_del_back_in_btn">
			<div id="memo_del_set" class="btn btn_c2">削除</div>　
			<div id="memo_del_back" class="btn btn_c1">戻る</div>
		</div>
	</div>
	<div class="chg_alert popup">
			変更しました
	</div>

	<div class="config_mail_chg popup">
		<div class="customer_remove_in">
			登録情報を変更します。<br>一旦ログアウトされます。登録されるメールアドレスからログインすることで変更が有効になります。<br>
		</div>
		<div class="customer_memo_del_back_in_btn">
			<div id="mydata_chg" class="btn btn_c2">変更</div>　
			<div id="log_del_back" class="btn btn_c1">戻る</div>
		</div>
	</div>

	<div class="customer_remove popup">
		<div class="customer_remove_in">
			顧客情報を削除します。<br>戻すことは出来ません。<br>アナリティクスの売上とお相手のEasyTalkは削除されません。
		</div>
		<div class="customer_memo_del_back_in_btn">
			<div id="customer_remove_set" class="btn btn_c2">削除</div>　
			<div id="customer_remove_back" class="btn btn_c1">戻る</div>
		</div>
	</div>

	<div class="log_list_del popup">
		<div class="log_list_del_item">
			<span class="log_list_del_icon"></span>
			<span class="log_list_del_name">恐ろしい安酒</span>
			<span class="log_list_del_price">999999</span>
		</div>
		<div class="log_list_del_comm">
			削除します。よろしいですか<br> 
			※既に登録された履歴は削除されません。
		</div>

		<div class="customer_memo_del_back_in_btn">
			<div id="log_list_del_set" class="btn btn_c2">削除</div>　
			<div id="log_list_del_back" class="btn btn_c1">戻る</div>
		</div>
	</div>

	<div class="log_gp_del popup">
		<div class="log_gp_del_name">
			ぐるーぷ
		</div>
		<div class="log_list_del_comm">
			削除します。よろしいですか<br> 
		</div>

		<div class="customer_memo_del_back_in_btn">
			<div id="log_gp_del_set" class="btn btn_c2">削除</div>　
			<div id="log_gp_del_back" class="btn btn_c1">戻る</div>
		</div>
	</div>

	<div class="customer_log_in popup">
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
				<?foreach((array)$log_item as $a1){?>
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

	<div class="customer_memo_in popup">
		<textarea class="customer_memo_new_txt"></textarea>
		<div class="customer_log_bottom">
		<div id="memo_set" class="btn btn_c2">登録</div>
		　<div id="memo_reset" class="btn btn_c1">戻る</div>
		　<div id="memo_del" class="btn btn_c3">削除</div>
		</div>
	</div>

	<div class="customer_regist">
		<div class="customer_regist_ttl">新規顧客登録</div>
		<span class="customer_regist_no"></span>

		<div class="customer_regist_base">
			<div id="set_new_img" class="customer_base_img"><img src="../img/customer_no_image.png?t=<?=time()?>" class="regist_img" alt="会員"></div>
			<div class="customer_base_tag cb1"><span class="customer_detail_in"></span>タグ</div>

			<div class="customer_base_item cb1">
				<select id="regist_group" name="cus_group" class="item_group">
				<option value="0">通常</option>
				<?if($cnt_cus_group_sel > 0){?>
				<?foreach($cus_group_sel as $a1=>$a2){?>
				<option value="<?=$a1?>"><?=$a2["tag"]?></option>
				<?}?>
				<?}?>	
				</select>
			</div>

			<div class="customer_base_tag cb2"><span class="customer_detail_in"></span>名前</div>
			<div class="customer_base_item cb2"><input type="text" id="regist_name" name="cus_name" class="item_basebox"></div>

			<div class="customer_base_tag cb3"><span class="customer_detail_in"></span>呼び名</div>
			<div class="customer_base_item cb3"><input type="text" id="regist_nick" name="cus_nick" class="item_basebox"></div>

			<div class="customer_base_tag2"><span class="customer_detail_in"></span>好感度</div>
			<div id="regist_fav_out" class="customer_base_fav">
				<span id="reg_fav_1" class="reg_fav"></span>
				<span id="reg_fav_2" class="reg_fav"></span>
				<span id="reg_fav_3" class="reg_fav"></span>
				<span id="reg_fav_4" class="reg_fav"></span>
				<span id="reg_fav_5" class="reg_fav"></span>
			</div>

			<div class="customer_base_tag cb4"><span class="customer_detail_in"></span>誕生日</div>
			<div class="customer_base_item cb4">
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
			</div>
		</div>

		<div id="customer_regist_set" class="btn btn_l2">登録</div>
		<input id="regist_fav" type="hidden" value="0">
	</div>

	<div class="img_box">
		<div class="img_box_in">
			<canvas id="cvs1" width="1800" height="1800"></canvas>
			<div class="img_box_out1"></div>
			<div class="img_box_out2"></div>
			<div class="img_box_out3"></div>
			<div class="img_box_out4"></div>
			<div class="img_box_out5"></div>
			<div class="img_box_out6"></div>
			<div class="img_box_out7"></div>
			<div class="img_box_out8"></div>

			<?for($n=0;$n<10;$n++){?>
				<?$n1=$n*10+25?>
				<div id="stamp3<?=$n?>" class="img_stamp" style="z-index:3<?=$n?>;top:<?=$n1?>px;left:<?=$n1?>px;">
				<img class="img_stamp_in">
				<span class="img_ctrl stamp_r"></span>
				<span class="img_ctrl stamp_d"></span>
				</div>
				<input type="hidden" id="rote3<?=$n?>" class="stamp_rote">
			<? } ?>
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
			<span class="upload_icon upload_stamp"></span>
		</div>
		<div class="img_box_in3">
			<div class="zoom_mi">-</div>
			<div class="zoom_rg"><input id="input_zoom" type="range" name="num" min="100" max="300" step="1" value="100" class="range_bar"></div>
			<div class="zoom_pu">+</div><div class="zoom_box">100</div>
		</div>
		<div class="img_box_in4">
			<div id="img_set" class="btn btn_c5">登録</div>　
			<div id="img_close" class="btn btn_c4">戻る</div>　
			<div id="img_reset" class="btn btn_c6">リセット</div>
		</div>

		<table class="stamp_box">
			<tr>
			<td id="stamp_in0" class="stamp_box_in"><img src="../img/stamp/stamp_0.png" class="stamp_box_img"></td>
			<td id="stamp_in1" class="stamp_box_in"><img src="../img/stamp/stamp_1.png" class="stamp_box_img"></td>
			<td id="stamp_in2" class="stamp_box_in"><img src="../img/stamp/stamp_2.png" class="stamp_box_img"></td>
			<td id="stamp_in3" class="stamp_box_in"><img src="../img/stamp/stamp_3.png" class="stamp_box_img"></td>
			<td id="stamp_in4" class="stamp_box_in"><img src="../img/stamp/stamp_4.png" class="stamp_box_img"></td>
			<td id="stamp_in5" class="stamp_box_in"><img src="../img/stamp/stamp_5.png" class="stamp_box_img"></td>
			<td id="stamp_in6" class="stamp_box_in"><img src="../img/stamp/stamp_6.png" class="stamp_box_img"></td>
			<td id="stamp_in7" class="stamp_box_in"><img src="../img/stamp/stamp_7.png" class="stamp_box_img"></td>
			</tr>
		</table>

		<div class="stamp_config">
			<div class="stamp_config_0">半透明</div>
			<img src id="st_0" class="stamp_config_4">
			<div id="st_1" class="stamp_config_3"><span class="stamp_config_icon"></span>前面</div>
			<div id="st_2" class="stamp_config_3"><span class="stamp_config_icon"></span>最前面</div>
			<div id="st_3" class="stamp_config_3"><span class="stamp_config_icon"></span>背面</div>
			<div id="st_4" class="stamp_config_3"><span class="stamp_config_icon"></span>最背面</div>
			<div id="st_5" class="stamp_config_2"><span class="stamp_config_icon"></span>リセット</div>
			<div id="st_6" class="stamp_config_1"><span class="stamp_config_icon"></span>削除</div>
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
	<input id="logout_count" type="hidden" value="1" name="log_out">

</form>

<form id="sns_form" action="" method="post" target="_blank"></form>
<? }?>
</div>
</body>
</html>
