<?php 
include_once('./library/sql.php');
/*
$st=20211001;
$cnt=31;
$sql_a=" INSERT INTO wp01_0schedule(`date`,`sche_date`,`cast_id`,`stime`,`etime`) VALUES";


$sql=" SELECT * FROM wp01_0sch_table";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$t_table[$row["in_out"]][$row["sort"]]=$row["time"];
	}
}

$sql=" SELECT id, genji FROM wp01_0cast";
$sql.=" WHERE cast_status=0";
$sql.=" AND id>0";
$sql.=" AND genji IS NOT NULL";
$sql.=" ORDER BY cast_sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		for($n=0;$n<$cnt;$n++){
			$sch8=date("Ymd",strtotime($st)+(86400*$n));
			$t0=($row["id"]+$n) % 4;

			if($t0 > 0){
				$t1=rand(0,5);
				$t2=rand(5,12);
				$sql_b.="('{$now}','{$sch8}','{$row["id"]}','{$t_table["in"][$t1]}','{$t_table["out"][$t2]}'),";
			}
		}

		$sql_b=substr($sql_b,0,-1);
		mysqli_query($mysqli,$sql_a.$sql_b);
		$sql_b="";
	}
}
*/

$sql="INSERT INTO wp01_0posts ";
$sql.="(`date`, `view_date`, `title`, `log`, `cast`, `tag`, `img`, `status`)";
$sql.="VALUES";

for($n=0;$n<60;$n++){
$dt=date("Y-m-d H:i:00",strtotime("2021-05-01")+$n*86400);

$ids=ceil(1234+($n/2));
$tag=5+($n%7);

$sql.="('{$dt}','{$dt}','こんにちは！{$n}回目','こんにちは☺️\n\n季節関係なしに主食はアイスです⚆.⚆\n好きなのはチョコミント。\n冷蔵庫にストックがあると安心します。\n\n今週は火曜から土曜日までOPENーLASTで出勤です♪\n面白い話聞かせてほしいな。\n最近雨が多いから気を付けてね。\n','{$ids}','{$tag}','','0'),";
}
$sql=substr($sql,0,-1);
mysqli_query($mysqli,$sql);
echo $sql;



?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-party</title>
</head>
<body>
<div style="font-size:16px;">
■<?=time()?>
</div>
</body>
</html>

