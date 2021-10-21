<?
include_once('./library/sql.php');

/*
$d=array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");

for($s1=0;$s1<720;$s1++){
	$rnd=rand(1,4);
	if($rnd == 4){
		$s3+=2;
	}else{
		$s3++;
	}

	$s4=floor($s3/36)+0;
	$s5=$s3 % 36;

	$s6=$d[$s4].$d[$s5];
	$dat[$s1]=$s6;
}
echo $s3."/1296<br>\n";
shuffle($dat);
$t0=0;	
for($t1=0;$t1<20;$t1++){
	for($t2=0;$t2<36;$t2++){
		$e_dat[$t1][$dat[$t0]]=$d[$t2];		
		$t0++;
	}
}

$sql="CREATE TABLE {$tbl_name}encode (";
$sql.="`id` int(10) AUTO_INCREMENT NOT NULL PRIMARY KEY,";
$sql.="`gp` int(3) NOT NULL,";
$sql.="`key` varchar(2) NOT NULL,";
$sql.="`value` varchar(2) NOT NULL";
$sql.=") ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$sql="INSERT INTO {$tbl_name}encode (`gp`, `key`, `value`) VALUES";
for($n=0;$n<20;$n++){
	foreach($e_dat[$n] as $a1 =>$a2){
		$sql.="('{$n}','{$a1}','{$a2}'),";
	}
}
$sql=substr($sql,0,-1);
*/


$id=1;

$sql="INSERT INTO wp00000_contact_list ";
$sql.="(`date`,`type`,`log_0`,`log_1`,`log_2`,`log_3`,`log_4`,`log_5`,`log_6`,`log_7`,`log_8`,`log_9`) VALUES";

for($n=0;$n<120;$n++){

$now1=date("Y-m-d H:i:s",time()+($n*40000));

$dat[1]="ぽんすけ".$n;
$dat[2]="mail@mail".$n;
$dat[3]="大阪".$n;
$dat[4]=$n;
$dat[5]="わんわんこ";
$sql.=" ('{$now1}','{$id}','{$dat[0]}','{$dat[1]}','{$dat[2]}','{$dat[3]}','{$dat[4]}','{$dat[5]}','{$dat[6]}','{$dat[7]}','{$dat[8]}','{$dat[9]}'),";
}
$sql=substr($sql,0,-1);
mysqli_query($mysqli,$sql);

echo $sql;

?>
