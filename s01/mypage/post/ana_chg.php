<?
include_once('../../library/sql_post.php');

$ana_ym	=$_POST["ym"];
$ck		=$_POST["ck"];

if($ck==1){
	$app[1]="style=\"display:block\"";
}else{
	$app[1]="style=\"display:none\"";
}

if($ck==2){
	$app[2]="style=\"display:block\"";
}else{
	$app[2]="style=\"display:none\"";
}

if($ck==3){
	$app[3]="style=\"display:block\"";
}else{
	$app[3]="style=\"display:none\"";
}

$ana_y_m=substr($ana_ym,0,4)."-".substr($ana_ym,4,2);

	$ana_line[$config["start_week"]]=" ana_line";
	$week_01	=date("w",strtotime($ana_ym."01"));
	$ana_t		=date("t",strtotime($ana_ym."01"));
	$week=array("日","月","火","水","木","金","土");

	$sql ="SELECT * FROM wp00000_sch_table";
	$sql.=" ORDER BY sort ASC";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$sche_table_name[$row["in_out"]][$row["sort"]]	=$row["name"];
			$sche_table_time[$row["in_out"]][$row["sort"]]	=$row["time"];
			$sche_table_calc[$row["in_out"]][$row["name"]]	=$row["time"];
		}
	}

	$sql	 ="SELECT * FROM wp00000_schedule";
	$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
	$sql	.=" AND sche_date LIKE '{$ana_ym}%'";
	$sql   	.=" ORDER BY id ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			if($row["stime"] && $row["etime"]){
				$days_sche[$row["sche_date"]]="<span class=\"sche_b\"><span class=\"sche_s\">".substr($row["stime"],0,2).":".substr($row["stime"],2,2)."</span>-<span class=\"sche_e\">".substr($row["etime"],0,2).":".substr($row["etime"],2,2)."</span></span>";

				if(substr($row["stime"],2,1) == 3){
					$tmp_s=$row["stime"]+20;
				}else{
					$tmp_s=$row["stime"];
				}		

				if(substr($row["etime"],2,1) == 3){
					$tmp_e=$row["etime"]+20;
				}else{
					$tmp_e=$row["etime"];
				}		

				if($tmp_e<$tmp_s){
					$tmp_e+=2400;
				}

				$ana_time[$row["sche_date"]]=($tmp_e-$tmp_s)/100;

			}else{
				$days_sche[$row["sche_date"]]="<span class=\"sche_s\"></span>";
				$sche_dat[$row["sche_date"]]="";
				$ana_time[$row["sche_date"]]=0;
			}
		}
	}

	if(is_array($ana_time)){
		foreach($ana_time as $a1 => $a2){

			if($a1<=$day_8){
				$ana_salary[$a1]=$a2*$cast_data["cast_salary"];	
				$ana_salary_all+=$a2*$cast_data["cast_salary"];	
			}
				$ana_salary_y[$a1]=$a2*$cast_data["cast_salary"];	
				$ana_salary_y_all+=$a2*$cast_data["cast_salary"];	
		}
	}

//■------------------
	$sql ="SELECT log_id, sdate, SUM(log_price) AS pts, nickname,name, A.days, customer_id FROM wp00000_cast_log AS A ";
	$sql.=" LEFT JOIN wp00000_cast_log_list AS B ON B.master_id=A.log_id";
	$sql.=" LEFT JOIN wp00000_customer AS C ON A.customer_id=C.id";

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


	$dat["html"].="<div id=\"an1\" class=\"ana_box\" {$app[1]}>";
	$dat["html"].="<div class=\"ana_total\">";	
	$dat["html"].="<div class=\"ana_res\"><span class=\"ana_res_t\">確定</span>".number_format($ana_salary_all+$pay_item_all)."円</div>";
	$dat["html"].="<div class=\"ana_res\"><span class=\"ana_res_t\">全体</span>".number_format($ana_salary_y_all+$pay_item_yet)."円</div>";
	$dat["html"].="</div>";

	$dat["html"].="<table class=\"ana\"><tr><td class=\"ana_top\" colspan=\"5\">日別</td></tr>";
	$dat["html"].="<td class=\"ana_top\">日時</td>";
	$dat["html"].="<td class=\"ana_top\">シフト</td>";
	$dat["html"].="<td class=\"ana_top\">時間</td>";
	$dat["html"].="<td class=\"ana_top\" colspan=\"2\">給与・バック</td>";
	$dat["html"].="</tr>";

	for($n=1;$n<$ana_t+1;$n++){
		$ana_c	=$ana_ym*100+$n;
		$ana_week	=($week_01+$n-1)%7;
		$ana_all = number_format($ana_salary_y[$ana_c] +$pay_item[$ana_c]);

		if($ana_c >$day_8){
			$f_day="ana_f";
		}

		$dat["html"].="<tr>";
		$dat["html"].="<td rowspan=\"2\" class=\"ana_month {$f_day} {$ana_line[$ana_week]}\">{$n}({$week[$ana_week]})</td>";
		$dat["html"].="<td rowspan=\"2\" class=\"ana_sche {$f_day} {$ana_line[$ana_week]}\">{$days_sche[$ana_c]}</td>";
		$dat["html"].="<td class=\"ana_time {$f_day} {$ana_line[$ana_week]}\">{$ana_time[$ana_c]}</td>";
		$dat["html"].="<td class=\"ana_pay {$f_day} {$ana_line[$ana_week]}\">";
		$dat["html"].="<span class=\"ana_pay_all\">{$ana_all}円</span>";
		$dat["html"].="</td>";
		$dat["html"].="<td id=\"ana_{$n}\" class=\"ana_detail";
		if($ana_all ==0){
			$dat["html"].="_n";
		}
		$dat["html"].="{$ana_line[$ana_week]}\"><span class=\"ana_arrow\"></span></td>";

		$dat["html"].="</tr>";
		$dat["html"].="<tr>";
		$dat["html"].="<td id=\"lana_{$n}\" class=\"ana_list\" colspan=\"3\">";
		$dat["html"].="<div id=\"dana_{$n}\" class=\"ana_list_div\">";

		if($cast_data["cast_salary"]>0){
			$dat["html"].="<span class=\"ana_list_c lc1\">";
			$dat["html"].="<span class=\"ana_list_item\">時給</span>";
			$dat["html"].="<span class=\"ana_list_pts\">".number_format($ana_salary[$ana_c])."円</span>";
			$dat["html"].="</span>";
		}

		$tmp_line=0;
		foreach((array)$dat_ana[$ana_c] as $a1){
			$tmp_lc=$tmp_line % 2;

			$dat["html"].="<span class=\"ana_list_c lc{$tmp_lc}\">";
			$dat["html"].="<span class=\"ana_list_item\">{$a1["nickname"]}様</span>";
			$dat["html"].="<span class=\"ana_list_pts\">".number_format($a1["pts"])."円</span>";
			$dat["html"].="</span>";
			$tmp_line++;
		}
		$dat["html"].="</div>";
		$dat["html"].="</td>";
		$dat["html"].="</tr>";
	}
	$dat["html"].="</table>";
	$dat["html"].="</div>";


/*-----------------------------------------------------------------------------*/
	$sql ="SELECT count(log_id) AS cnt, sum(pts) AS kin, sum(log_price) AS bk,nickname,name,L.customer_id FROM wp00000_cast_log AS L ";
	$sql.=" LEFT JOIN wp00000_cast_log_list AS S ON L.log_id=S.master_id";
	$sql.=" LEFT JOIN wp00000_customer AS C ON L.customer_id=C.id";

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

		

	$dat["html"].="<div class=\"ana_box_m\">";
	$dat["html"].="<div id=\"an2\" class=\"ana_box\" {$app[2]}>";

	$dat["html"].="<table class=\"ana\"><tr><td class=\"ana_top\" colspan=\"5\">顧客別</td></tr>";
	$dat["html"].="<tr><td class=\"ana_top\">名前</td><td class=\"ana_top\">来店</td><td class=\"ana_top\">利用金額</td><td class=\"ana_top\">バック</td></tr>";
	foreach((array)$ana_customer as $a1){
		$dat["html"].="<tr>";
		$dat["html"].="<td class=\"ana_name\"><a href=\"./index.php?c_id={$a1["customer_id"]}&cast_page=2\" class=\"cal_days_birth_in\">{$a1["nickname"]}</a></td>";
		$dat["html"].="<td class=\"ana_ken\">{$a1["cnt"]}</td>";
		$dat["html"].="<td class=\"ana_pts\">".number_format($a1["kin"])."</td>";
		$dat["html"].="<td class=\"ana_pts\">".number_format($a1["bk"])."</td>";
		$dat["html"].="</tr>";
	}
	$dat["html"].="</table>";
	$dat["html"].="</div>";

/*-----------------------------------------------------------------------------*/
	$sql ="SELECT log_icon, log_comm, log_price, log_color, count(log_id) AS cnt, sum(log_price) AS bk FROM wp00000_cast_log_list AS S ";
	$sql.=" LEFT JOIN wp00000_cast_log AS L ON L.log_id=S.master_id";
	$sql.=" WHERE L.del=0";
	$sql.=" AND S.del=0";
	$sql.=" AND S.log_comm<>''";
	$sql.=" AND S.log_icon<>''";
	$sql.=" AND S.log_price>0";
	$sql.=" AND S.log_color<>''";
	$sql.=" AND L.days LIKE '{$ana_y_m}%'";
	$sql.=" GROUP BY S.log_comm, log_icon, log_price, log_color ";
	$sql.=" ORDER BY cnt DESC, log_price DESC";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$ana_item[]=$row;
		}
	}

	$dat["html"].="<div id=\"an3\" class=\"ana_box\" {$app[3]}>";

				
	$dat["html"].="<table class=\"ana\"><tr><td class=\"ana_top\" colspan=\"4\">項目別</td></tr>";
	$dat["html"].="<tr><td class=\"ana_top\">項目</td><td class=\"ana_top\">単価</td><td class=\"ana_top\">件数</td><td class=\"ana_top\">バック</td></tr>";

	foreach((array)$ana_item as $a1){
		$dat["html"].="<tr>";
		$dat["html"].="<td class=\"ana_name\" style=\"color:{$a1["log_color"]}\"><span class=\"ana_icon\">{$a1["log_icon"]}</span>{$a1["log_comm"]}</td>";
		$dat["html"].="<td class=\"ana_pts\">".number_format($a1["log_price"])."</td>";
		$dat["html"].="<td class=\"ana_ken\">{$a1["cnt"]}</td>";
		$dat["html"].="<td class=\"ana_pts\">".number_format($a1["bk"])."</td>";
		$dat["html"].="</tr>";
	}
	$dat["html"].="</table>";
	$dat["html"].="</div>";
	$dat["html"].="</div>";


echo $dat["html"];
exit();
