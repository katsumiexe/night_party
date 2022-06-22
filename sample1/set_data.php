<?
include_once('./library/sql_admin.php');
include_once('./library/inc_code.php');

$m[0]=date("Ym01");
$m[1]=date("Ym15",time()-864000);
$m[2]=date("Ym25",time()-864000);
$m[3]=date("Ym01",time()-864000);
$m[4]=date("Ym10");
$m[5]=date("Ym20");

$sch_st[0]="1900";
$sch_st[1]="1930";
$sch_st[2]="2000";
$sch_st[3]="1900";
$sch_st[4]="1900";

$sch_ed[0]="0000";
$sch_ed[1]="0030";
$sch_ed[2]="0100";
$sch_ed[3]="0100";
$sch_ed[4]="0100";

shuffle($m);

$sql="SELECT * FROM NP_cast_log_table";
$sql.=" WHERE cast_id='12346'";

if($res = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($res)){
		$item[$row["id"]]=$row;
	}
}

$s=0;
for($n=12351;$n<12357;$n++){
	$sql="UPDATE NP_cast SET ctime='{$m[$s]}' WHERE id='{$n}'";
	mysqli_query($mysqli,$sql);
	$s++;
}

$now	=date("Y-m-d H:i:s");
$t		=date("t");
$st_8	=date("Ym01");
$ed_8	=date("Ym01",strtotime($st_8)+3456000);

$sql="INSERT INTO NP_schedule (`date`,`sche_date`,`cast_id`,`stime`,`etime`,`signet`)VALUES";
for($n=12345;$n<12357;$n++){
	for($f=$st_8;$f<$st_8+$t;$f++){
		if(rand(1,10) > 4){
			$s1=rand(0,4);
			$e1=rand(0,4);
			$sql.="('{$now}','{$f}','{$n}','{$sch_st[$s1]}','{$sch_ed[$e1]}','1'),";

			if($n==12346){
				$check[$f]=$sch_st[$s1];
			}
		}

	}
}
$sql=substr($sql,0,-1);
mysqli_query($mysqli,$sql);

$sql2="INSERT INTO NP_cast_log_list (`master_id`,`log_color`,`log_icon`,`log_comm`,`log_price`,`del`)VALUES";
foreach($check as $a1 => $a2){
	$r=rand(20,24);
	for($n=20;$n<$r;$n++){

		$l=rand(1,5);
		$log_list[0]="パチンコで{$l}万円勝ったそうでご機嫌";
		$log_list[1]="たばこ嫌い。明日娘の{$l}歳の誕生日";
		$log_list[2]="競馬で{$l}万円敗け。もうやらない宣言。";
		$log_list[3]="最近仕事が忙しいとのこと。";
		$log_list[4]="ずっと野球の話。阪神ファン。周りは巨人ファンが多いみたい";
		$log_list[5]="ソシャゲにはまる。今月はすでに{$l}万の課金";
		$log_list[6]="早く来て早く帰る。あさってまた来てくれる約束";
		$log_list[7]="青のドレスをめっちゃほめてきた。あとめっちゃ触ってきた";
		$log_list[8]="スマホ買い替え検討中。今度はiphoneにしようかと";
		$log_list[9]="麻雀で{$l}万勝ち。麻雀の話はよくわからん...";
		$log_list[10]="";
		$log_list[11]="";
		$log_list[12]="";

		$log=$log_list[rand(0,12)];	

		$days=substr($a1,0,4)."-".substr($a1,4,2)."-".substr($a1,6,2);	
		$stime=$n.":00";
		$etime=$n.":40";
		$pts=rand(5,30)*1000;
		$cust=rand(1,12);
		$sql="INSERT INTO NP_cast_log (`date`,`sdate`,`stime`,`etime`,`cast_id`,`customer_id`,`log`,`days`,`pts`,`del`)VALUES";
		$sql.="('{$now}','{$days}','{$stime}','{$etime}','12346','{$cust}','{$log}','{$days}','{$pts}','0')";
		mysqli_query($mysqli,$sql);

		$tmp_auto=	mysqli_insert_id($mysqli);
		$r2=rand(0,2)+rand(0,2);
		shuffle($item);
		$r3=0;
		for($n2=0;$n2<$r2;$n2++){
			$sql2.="('{$tmp_auto}','{$c_code[$item[$r3]["item_color"]]}','{$i_code[$item[$r3]["item_icon"]]}','{$item[$r3]["item_name"]}','{$item[$r3]["price"]}','0'),";
			$r3++;
		}
	}
}

$sql2=substr($sql2,0,-1);
mysqli_query($mysqli,$sql2);
echo $sql2
?>

