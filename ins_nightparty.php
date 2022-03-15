<?php
$db		=$_POST["db"];
$user	=$_POST["user"];
$pass	=$_POST["pass"];
$dbn	=$_POST["dbn"];
$key	=$_POST["key"];

$now=date("Y-m-d H:i:s");
echo "data　".$db."<br>\n";
echo "user　".$user."<br>\n";
echo "pass　".$pass."<br>\n";
echo "dbn 　".$dbn."<br>\n";
echo "key 　".$key."<br>\n";

if($user && $pass && $key && $db && $dbn){
$mysqli = mysqli_connect($db, $user, $pass, $dbn);
if(!$mysqli){
	$msg="接続エラー!";
	die("接続エラー");
}
echo "DB SETUP<br>\n";

$sql="CREATE TABLE `{$key}_cast`(";
$sql.="`regist_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
$sql.="`id` int(10) NOT NULL,";
$sql.="`ctime` varchar(8) NOT NULL,";
$sql.="`box_no` varchar(20) NOT NULL,";
$sql.="`genji` varchar(50) NOT NULL,";
$sql.="`genji_kana` varchar(50) NOT NULL,";
$sql.="`twitter` varchar(50) NOT NULL,";
$sql.="`facebook` varchar(50) NOT NULL,";
$sql.="`cast_mail` varchar(50) NOT NULL,";
$sql.="`cast_rank` int(3) NOT NULL,";
$sql.="`cast_group` int(2) NOT NULL,";
$sql.="`cast_sort` int(3) NOT NULL,";
$sql.="`login_id` varchar(50) NOT NULL,";
$sql.="`login_pass` varchar(50) NOT NULL,";
$sql.="`cast_status` int(10) NOT NULL COMMENT '0:通常/1:準備/2:休職/3:退職/4:停止/99:削除',";
$sql.="`del` int(1) NOT NULL,";
$sql.="`remove` int(2) NOT NULL,";
$sql.="`week_st` int(2) NOT NULL,";
$sql.="`times_st` int(2) NOT NULL,";
$sql.="`cast_salary` int(10) NOT NULL,";
$sql.="`ribbon_use` int(1) NOT NULL COMMENT '0:使う/1:使わない',";
$sql.="`cast_ribbon` int(2) NOT NULL,";
$sql.="index (regist_id)";
$sql.=") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;";
mysqli_query($mysqli, $sql);

$sql="ALTER TABLE `{$key}_cast` AUTO_INCREMENT = 12345";
mysqli_query($mysqli, $sql);

$sql=<<<SQA
CREATE TABLE `{$key}_cast_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cast_id` int(10) NOT NULL,
  `c_sort_main` int(10) NOT NULL,
  `c_sort_asc` int(10) NOT NULL,
  `c_sort_group` int(10) NOT NULL,
  index (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQA;
mysqli_query($mysqli, $sql);

$sql=<<<SQB
CREATE TABLE `{$key}_cast_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime NOT NULL,
  `sdate` date NOT NULL,
  `stime` varchar(5) NOT NULL,
  `edate` varchar(8) NOT NULL,
  `etime` varchar(5) NOT NULL,
  `cast_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `action_id` int(10) NOT NULL,
  `del` int(1) NOT NULL,
  `log` varchar(500) NOT NULL,
  `days` date NOT NULL,
  `pts` int(8) NOT NULL,
  index (log_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQB;
mysqli_query($mysqli, $sql);


$sql=<<<SQC
CREATE TABLE `{$key}_cast_log_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `master_id` int(10) NOT NULL,
  `action_id` int(10) NOT NULL,
  `log_color` varchar(50) NOT NULL,
  `log_icon` varchar(10) NOT NULL,
  `log_comm` varchar(100) NOT NULL,
  `log_price` varchar(10) NOT NULL,
  `del` int(1) NOT NULL,
  index (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQC;
mysqli_query($mysqli, $sql);


$sql=<<<SQD
CREATE TABLE `{$key}_cast_log_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cast_id` int(10) NOT NULL,
  `item_name` varchar(12) NOT NULL,
  `item_icon` int(5) NOT NULL,
  `item_color` int(5) NOT NULL,
  `price` int(10) NOT NULL,
  `sort` int(10) NOT NULL,
  `del` int(1) NOT NULL,
  index (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQD;
mysqli_query($mysqli, $sql);


$sql=<<<SQE
CREATE TABLE `{$key}_charm_sel` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `list_id` int(10) NOT NULL,
  `cast_id` int(10) NOT NULL,
  `log` varchar(3000) NOT NULL,
  index (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQE;
mysqli_query($mysqli, $sql);


$sql=<<<SQF
CREATE TABLE `{$key}_charm_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `sort` int(3) NOT NULL,
  `charm` varchar(50) NOT NULL,
  `style` int(1) NOT NULL,
  `view` int(1) NOT NULL,
  `del` int(1) NOT NULL,
  index (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQF;
mysqli_query($mysqli, $sql);


$sql=<<<SQG
CREATE TABLE `{$key}_check_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `host_id` int(10) NOT NULL,
  `list_sort` int(10) NOT NULL,
  `list_title` varchar(50) NOT NULL,
  `del` int(11) NOT NULL,
  index (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQG;
mysqli_query($mysqli, $sql);


$sql=<<<SQH
CREATE TABLE `{$key}_check_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `sort` int(10) NOT NULL,
  `title` varchar(20) NOT NULL,
  `style` int(1) NOT NULL,
  `del` int(1) NOT NULL,
  index (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQH;
mysqli_query($mysqli, $sql);


$sql=<<<SQI
CREATE TABLE `{$key}_check_sel` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `list_id` int(10) NOT NULL,
  `cast_id` int(10) NOT NULL,
  `sel` int(1) NOT NULL,
  index (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQI;
mysqli_query($mysqli, $sql);


$sql=<<<SQJ
CREATE TABLE `{$key}_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `config_key` varchar(100) NOT NULL,
  `config_value` varchar(200) NOT NULL,
  index (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQJ;
mysqli_query($mysqli, $sql);


$sql=<<<SQK
CREATE TABLE `{$key}_contact_list` (
  `list_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime NOT NULL,
  `type` varchar(1000) NOT NULL,
  `log_0` varchar(1000) NOT NULL,
  `log_1` varchar(1000) NOT NULL,
  `log_2` varchar(1000) NOT NULL,
  `log_3` varchar(1000) NOT NULL,
  `log_4` varchar(1000) NOT NULL,
  `log_5` varchar(1000) NOT NULL,
  `log_6` varchar(1000) NOT NULL,
  `log_7` varchar(1000) NOT NULL,
  `log_8` varchar(1000) NOT NULL,
  `log_9` varchar(1000) NOT NULL,
  `res_radio` int(2) NOT NULL,
  `res_log` varchar(1000) NOT NULL,
  `staff` varchar(10) NOT NULL,
  `res_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQK;
mysqli_query($mysqli, $sql);


$sql=<<<SQL
CREATE TABLE `{$key}_contact_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `log_0_name` varchar(200) NOT NULL,
  `log_0_type` varchar(10) NOT NULL,
  `log_1_name` varchar(200) NOT NULL,
  `log_1_type` varchar(10) NOT NULL COMMENT '1:text/2:mail/3:number/4:comment■1:必須',
  `log_2_name` varchar(200) NOT NULL,
  `log_2_type` varchar(10) NOT NULL,
  `log_3_name` varchar(200) NOT NULL,
  `log_3_type` varchar(10) NOT NULL,
  `log_4_name` varchar(200) NOT NULL,
  `log_4_type` varchar(10) NOT NULL,
  `log_5_name` varchar(200) NOT NULL,
  `log_5_type` varchar(10) NOT NULL,
  `log_6_name` varchar(200) NOT NULL,
  `log_6_type` varchar(10) NOT NULL,
  `log_7_name` varchar(200) NOT NULL,
  `log_7_type` varchar(10) NOT NULL,
  `log_8_name` varchar(200) NOT NULL,
  `log_8_type` varchar(10) NOT NULL,
  `log_9_name` varchar(200) NOT NULL,
  `log_9_type` varchar(10) NOT NULL,
  `return_mail_log` varchar(1000) NOT NULL,
  `to_mail` varchar(1000) NOT NULL,
  `call_mail_address1` varchar(100) NOT NULL,
  `call_mail_address2` varchar(100) NOT NULL,
  `call_mail_address3` varchar(100) NOT NULL,
  `call_mail_address4` varchar(100) NOT NULL,
  `call_mail_address5` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQL;
mysqli_query($mysqli, $sql);


$sql=<<<SQM
CREATE TABLE `{$key}_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime NOT NULL,
  `display_date` datetime NOT NULL,
  `event_date` date NOT NULL,
  `sort` int(3) NOT NULL,
  `page` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `contents_key` varchar(500) NOT NULL,
  `title` varchar(100) NOT NULL,
  `contents` varchar(2000) NOT NULL,
  `tag` int(2) NOT NULL,
  `status` int(1) NOT NULL COMMENT '0:表示/1:表示前/2:注目/3:非表示/4:削除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQM;
mysqli_query($mysqli, $sql);


$sql=<<<SQN
CREATE TABLE `{$key}_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cast_id` int(11) NOT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `regist_date` datetime NOT NULL,
  `birth_day` varchar(8) NOT NULL,
  `fav` int(2) NOT NULL,
  `c_group` int(10) NOT NULL,
  `face` longtext NOT NULL,
  `tel` varchar(12) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `twitter` varchar(100) NOT NULL,
  `insta` varchar(100) NOT NULL,
  `facebook` varchar(100) NOT NULL,
  `line` varchar(50) NOT NULL,
  `web` varchar(100) NOT NULL,
  `del` int(2) NOT NULL,
  `block` int(2) NOT NULL,
  `opt` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQN;
mysqli_query($mysqli, $sql);


$sql=<<<SQO
CREATE TABLE `{$key}_customer_flag` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cast_id` int(10) NOT NULL,
  `color` int(2) NOT NULL,
  `tag` varchar(20) NOT NULL,
  `del` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

SQO;
mysqli_query($mysqli, $sql);


$sql=<<<SQP
CREATE TABLE `{$key}_customer_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `group_id` int(2) NOT NULL,
  `cast_id` int(10) NOT NULL,
  `sort` int(3) NOT NULL,
  `tag` varchar(20) NOT NULL,
  `del` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQP;
mysqli_query($mysqli, $sql);


$sql=<<<SQQ
CREATE TABLE `{$key}_customer_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `gp` int(3) NOT NULL,
  `style` int(3) NOT NULL,
  `item_name` varchar(30) NOT NULL,
  `del` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQQ;
mysqli_query($mysqli, $sql);


$sql=<<<SQR
CREATE TABLE `{$key}_customer_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cast_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `item` int(3) NOT NULL,
  `comm` varchar(500) NOT NULL,
  `del` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQR;
mysqli_query($mysqli, $sql);


$sql=<<<SQS
CREATE TABLE `{$key}_customer_memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime NOT NULL,
  `cast_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `tag` int(5) NOT NULL,
  `log` varchar(1000) NOT NULL,
  `del` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQS;
mysqli_query($mysqli, $sql);


$sql=<<<SQT
CREATE TABLE `{$key}_easytalk` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `send_date` datetime NOT NULL,
  `watch_date` datetime NOT NULL,
  `customer_id` int(10) NOT NULL,
  `cast_id` int(10) NOT NULL,
  `send_flg` int(1) NOT NULL,
  `log` varchar(2000) NOT NULL,
  `img` mediumtext  NOT NULL,
  `mail_del` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQT;
mysqli_query($mysqli, $sql);


$sql=<<<SQU
CREATE TABLE `{$key}_easytalk_tmpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cast_id` int(10) NOT NULL,
  `sort` int(2) NOT NULL,
  `title` varchar(50) NOT NULL,
  `log` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQU;
mysqli_query($mysqli, $sql);


$sql=<<<SQV
CREATE TABLE `{$key}_encode` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `gp` int(3) NOT NULL,
  `key` varchar(2) NOT NULL,
  `value` varchar(1) NOT NULL,
  `etc` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQV;
mysqli_query($mysqli, $sql);


$sql=<<<SQW
CREATE TABLE `{$key}_item_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `item_id` int(10) NOT NULL,
  `item_group` varchar(50) NOT NULL,
  `item_color` varchar(50) NOT NULL,
  `del` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQW;
mysqli_query($mysqli, $sql);


$sql=<<<SQX
CREATE TABLE `{$key}_item_icon` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `item_id` int(10) NOT NULL,
  `item_group` varchar(50) NOT NULL,
  `item_icon` varchar(50) NOT NULL,
  `del` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQX;
mysqli_query($mysqli, $sql);


$sql=<<<SQY
CREATE TABLE `{$key}_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime NOT NULL,
  `ref` varchar(500) NOT NULL,
  `ua` varchar(500) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `page` varchar(100) NOT NULL,
  `parm` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQY;
mysqli_query($mysqli, $sql);


$sql=<<<SQZ
CREATE TABLE `{$key}_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime NOT NULL,
  `title` varchar(30) NOT NULL,
  `log` varchar(1000) NOT NULL,
  `category` int(2) NOT NULL,
  `writer` varchar(100) NOT NULL,
  `cast_group` varchar(50) NOT NULL,
  `del` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQZ;
mysqli_query($mysqli, $sql);


$sql=<<<SRA
CREATE TABLE `{$key}_notice_ck` (
  `ck_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `view_date` datetime NOT NULL,
  `notice_id` int(10) NOT NULL,
  `cast_id` int(10) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SRA;
mysqli_query($mysqli, $sql);


$sql=<<<SRB
CREATE TABLE `{$key}_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `blog_id` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `view_date` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `log` varchar(2000) NOT NULL,
  `cast` int(10) NOT NULL,
  `tag` int(2) NOT NULL,
  `img` varchar(20) NOT NULL,
  `img_del` int(1) NOT NULL,
  `status` int(2) NOT NULL COMMENT '0:表示/1:予約/2:個人/3:非表示/4:削除',
  `revision` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SRB;
mysqli_query($mysqli, $sql);


$sql=<<<SRC
CREATE TABLE `{$key}_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime NOT NULL,
  `sche_date` varchar(8) NOT NULL,
  `cast_id` int(10) NOT NULL,
  `stime` varchar(10) NOT NULL,
  `etime` varchar(10) NOT NULL,
  `signet` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SRC;
mysqli_query($mysqli, $sql);


$sql=<<<SRD
CREATE TABLE `{$key}_schedule_memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date_8` varchar(8) NOT NULL,
  `log` varchar(500) NOT NULL,
  `cast_id` int(10) NOT NULL,
  `del` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SRD;
mysqli_query($mysqli, $sql);


$sql=<<<SRE
CREATE TABLE `{$key}_sch_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `in_out` varchar(3) NOT NULL,
  `sort` int(10) NOT NULL,
  `name` varchar(6) NOT NULL,
  `time` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SRE;
mysqli_query($mysqli, $sql);


$sql=<<<SRF
CREATE TABLE `{$key}_ssid` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ssid` varchar(100) NOT NULL,
  `cast_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `del` int(1) NOT NULL,
  `effect` int(1) NOT NULL,
  `date` datetime NOT NULL,
  `mail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SRF;
mysqli_query($mysqli, $sql);


$sql=<<<SRG
CREATE TABLE `{$key}_staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `sort` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `kana` varchar(50) NOT NULL,
  `tel` varchar(11) NOT NULL,
  `line` varchar(100) NOT NULL,
  `mail` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `birthday` varchar(8) NOT NULL,
  `sex` int(11) NOT NULL,
  `registday` varchar(8) NOT NULL,
  `rank` int(2) NOT NULL,
  `group` varchar(20) NOT NULL,
  `position` varchar(20) NOT NULL,
  `pf1` varchar(500) NOT NULL,
  `pf2` varchar(500) NOT NULL,
  `pf3` varchar(500) NOT NULL,
  `pf4` varchar(500) NOT NULL,
  `pf5` varchar(500) NOT NULL,
  `pf6` varchar(500) NOT NULL,
  `del` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SRG;
mysqli_query($mysqli, $sql);


$sql=<<<SRH
CREATE TABLE `{$key}_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tag_group` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  `tag_name` varchar(20) NOT NULL,
  `tag_icon` varchar(10) NOT NULL,
  `del` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SRH;
mysqli_query($mysqli, $sql);

/*
$sql=<<<SRI
SRI;
mysqli_query($mysqli, $sql);
*/


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
shuffle($dat);
$t0=0;	
for($t1=0;$t1<20;$t1++){
	for($t2=0;$t2<36;$t2++){
		$e_dat[$t1][$dat[$t0]]=$d[$t2];		
		$t0++;
	}
}

$sql="INSERT INTO {$key}_encode (`gp`, `key`, `value`) VALUES";
for($n=0;$n<20;$n++){
	foreach($e_dat[$n] as $a1 =>$a2){
		$sql.="('{$n}','{$a1}','{$a2}'),";
	}
}
$sql=substr($sql,0,-1);
mysqli_query($mysqli, $sql);

$sql=<<<SRI
INSERT INTO `{$key}_config` (`id`, `config_key`, `config_value`) VALUES
(1, 'start_time', ''),
(2, 'start_week', ''),

(3, 'ribbon', ''),
(4, 'new_commer_cnt', ''),
(5, 'today_commer', ''),
(6, 'coming_soon', ''),

(7, 'open_day', ''),
(8, 'main_url', ''),
(9, 'store_name', ''),

(10, 'jpg_select', ''),
(11, 'webp_select', ''),

(12, 'twitter', ''),
(13, 'twitter_view', ''),
(14, 'instagram', ''),
(15, 'instagram_view', ''),
(16, 'facebook', ''),
(17, 'facebook_view', '')
SRI;
mysqli_query($mysqli, $sql);


$sql=<<<SRJ
INSERT INTO `{$key}_contact_table` (`log_0_name`, `log_0_type`, `log_1_name`, `log_1_type`, `log_2_name`, `log_2_type`, `log_3_name`, `log_3_type`, `log_4_name`, `log_4_type`, `log_5_name`, `log_5_type`, `log_6_name`, `log_6_type`, `log_7_name`, `log_7_type`, `log_8_name`, `log_8_type`, `log_9_name`, `log_9_type`, `return_mail_log`, `to_mail`, `call_mail_address1`, `call_mail_address2`, `call_mail_address3`, `call_mail_address4`, `call_mail_address5`) VALUES ('0', '0', '名前', '11', 'メールアドレス', '21', '住所', '10', '年齢', '30', '当店へのご質問', '40', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
SRJ;
mysqli_query($mysqli, $sql);



$sql=<<<SRK
INSERT INTO `{$key}_contents` (`date`, `display_date`, `event_date`, `sort`, `page`, `category`, `contents_key`, `title`, `contents`, `tag`, `status`) VALUES
('{$now}', '{$now}', '0000-00-00', 0, 'policy', '', '0', 'プライバシーポリシー', '<div class=\"system_box\">\r\n『Night★Party』（以下，「当社」といいます。）は，本ウェブサイト上で提供するサービス（以下,「本サービス」といいます。）における，ユーザーの個人情報の取扱いについて，以下のとおりプライバシーポリシー（以下，「本ポリシー」といいます。）を定めます。\r\n</div>\r\n\r\n<div class=\"system_title\">第1条　個人情報</div>\r\n<div class=\"system_box\">\r\n「個人情報」とは，個人情報保護法にいう「個人情報」を指すものとし，生存する個人に関する情報であって，当該情報に含まれる氏名，生年月日，住所，電話番号，連絡先その他の記述等により特定の個人を識別できる情報及び容貌，指紋，声紋にかかるデータ，及び健康保険証の保険者番号などの当該情報単体から特定の個人を識別できる情報（個人識別情報）を指します。\r\n</div>\r\n\r\n<div class=\"system_title\">第2条　個人情報の収集方法</div>\r\n<div class=\"system_box\">\r\n当社は，ユーザーが利用登録をする際に氏名，生年月日，住所，電話番号，メールアドレス，銀行口座番号，クレジットカード番号，運転免許証番号などの個人情報をお尋ねすることがあります。また，ユーザーと提携先などとの間でなされたユーザーの個人情報を含む取引記録や決済に関する情報を,当社の提携先（情報提供元，広告主，広告配信先などを含みます。以下，｢提携先｣といいます。）などから収集することがあります。\r\n</div>\r\n\r\n<div class=\"system_title\">第3条　個人情報の利用目的</div>\r\n<div class=\"system_box\">\r\n当社が個人情報を収集・利用する目的は，以下のとおりです。\r\n<span class=\"system_box_in\">\r\n当社サービスの提供・運営のため<br>\r\nユーザーからのお問い合わせに回答するため（本人確認を行うことを含む）<br>\r\nユーザーが利用中のサービスの新機能，更新情報，キャンペーン等及び当社が提供する他のサービスの案内のメールを送付するため<br>\r\nメンテナンス，重要なお知らせなど必要に応じたご連絡のため<br>\r\n利用規約に違反したユーザーや，不正・不当な目的でサービスを利用しようとするユーザーの特定をし，ご利用をお断りするため<br>\r\nユーザーにご自身の登録情報の閲覧や変更，削除，ご利用状況の閲覧を行っていただくため<br>\r\n</span>\r\n</div>\r\n', 0, 0),
('{$now}', '{$now}', '0000-00-00', 0, 'system', '', '0', 'SYSTEM', '<div class=\"system_title\">MAIN GUEST</div>\r\n<div class=\"system_box\">\r\n<span class=\"system_box_1\">18:00-20:00</span><span class=\"system_box_2\">60min</span><span class=\"system_box_3\">￥8,000</span><br>\r\n<span class=\"system_box_1\">20:00-22:00</span><span class=\"system_box_2\">60min</span><span class=\"system_box_3\">￥9,000</span><br>\r\n<span class=\"system_box_1\">22:00-LAST</span><span class=\"system_box_2\">60min</span><span class=\"system_box_3\">￥12,000</span><br>\r\n<span class=\"system_box_1\">延長</span><span class=\"system_box_2\">30min</span><span class=\"system_box_3\">\\4000</span><br>\r\n</div>\r\n<div class=\"system_title\">V.I.P GUEST</div>\r\n<div class=\"system_box\">\r\n<span class=\"system_box_1\">18:00-LAST</span><span class=\"system_box_2\">60min</span><span class=\"system_box_3\">￥12,000</span><br>\r\n<span class=\"system_box_1\">延長</span><span class=\"system_box_2\">30min</span><span class=\"system_box_3\">￥6,000</span><br>\r\n</div>\r\n<div class=\"system_title\">その他</div>\r\n<div class=\"system_box\">\r\n<span class=\"system_box_1\">場内指名</span><span class=\"system_box_2\">　</span><span class=\"system_box_3\">￥2,000</span><br>\r\n<span class=\"system_box_1\">本指名</span><span class=\"system_box_2\">　</span><span class=\"system_box_3\">￥3,000</span><br>\r\n</div>\r\n<div class=\"system_title\">クレジットカード</div>\r\n<div class=\"system_box\">\r\n<span class=\"system_box_1\">VISA</span><br>\r\n<span class=\"system_box_1\">JCB</span><br>\r\n<span class=\"system_box_1\">AMEX</span><br>\r\n</div>', 0, 0),
('{$now}', '{$now}', '0000-00-00', 3, 'recruit', 'list', '', '給与', '5,000円以上\r\n日払いあり', 0, 0),
('{$now}', '{$now}', '0000-00-00', 1, 'recruit', 'list', '', '職種', 'フロアレディ', 0, 0),
('{$now}', '{$now}', '0000-00-00', 2, 'recruit', 'list', '', '勤務時間', '20:00～LAST\r\n週1からOK\r\n終電上がり可\r\n', 0, 0),
('{$now}', '{$now}', '0000-00-00', 4, 'recruit', 'list', '', 'その他', '18歳以上（高校生不可）\r\n◇未経験者歓迎\r\n◇経験者超優遇\r\n◇学生・Wワーク・フリーターOK\r\n◇ブランクありOK\r\n◇即日体入OK\r\n◇友達同士の応募OK', 0, 0),
('{$now}', '{$now}', '0000-00-00', 0, 'access', 'map', '', 'ACCESS', '<h1 class=\"access_h1\">Night☆Party</h1>\r\n<div class=\"access_tag\">住所</div>\r\n<div class=\"access_box\">\r\n				〒160-0021<br>\r\n				東京都新宿区歌舞伎町1-1-1 新宿ビルB1F<br>\r\n			</div>\r\n			<div class=\"access_tag\">アクセス</div>\r\n			<div class=\"access_box\">\r\n				JR線 新宿駅東口より徒歩3分<br> \r\n				西武新宿線西武新宿駅より徒歩3分<br>\r\n			</div>\r\n			<div class=\"access_tag\">電話番号</div>\r\n			<div class=\"access_box\">\r\n				<span>03</span>-<span>6457</span>-<span>6156</span>\r\n			</div>\r\n			<div class=\"access_tag\">営業時間</div>\r\n			<div class=\"access_box\">\r\n				20:00～LAST<br>\r\n			</div>\r\n', 0, 0),
('{$now}', '{$now}', '0000-00-00', 0, 'recruit', 'mail', '', '', '', 0, 0),
('{$now}', '{$now}', '0000-00-00', 0, 'recruit', 'form', '1', '', '', 0, 0),
('{$now}', '{$now}', '0000-00-00', 0, 'recruit', 'line', '@onlyme_staff\r\n', '', '', 0, 0),
('{$now}', '{$now}', '0000-00-00', 0, 'recruit', 'tel', '03-1234-5678', '', '', 0, 0)
SRK;
mysqli_query($mysqli, $sql);



$sql=<<<SRL
INSERT INTO `{$key}_customer_item` (`gp`, `style`, `item_name`, `del`) VALUES
(0, 1, '住まい', 0),
(0, 2, '結婚', 0),
(0, 1, '最寄り駅', 0),
(0, 1, '出身地', 0),
(0, 1, '会社名', 0),
(0, 1, '役職', 0),
(0, 1, '仕事内容', 0),
(0, 3, '血液型', 0),
(0, 1, '趣味', 0),
(0, 1, '特技', 1),
(0, 1, 'お酒', 0),
(0, 1, '食べ物', 0),
(0, 1, 'たばこ', 0),
(0, 1, 'ブランド', 0),
(0, 1, '車', 0),
(1, 1, '電話番号', 0),
(1, 1, 'メール', 0),
(1, 1, 'LINE', 0),
(1, 1, 'twitter', 0),
(1, 1, 'FaceBook', 0),
(1, 1, 'Instagram', 0),
(1, 1, 'blog', 0),
(1, 1, 'WEB', 0);
SRL;
mysqli_query($mysqli, $sql);


$sql=<<<SRM
INSERT INTO `{$key}_sch_table` (`in_out`, `sort`, `name`, `time`) VALUES
('in', 0, '19:00', '1900'),
('in', 1, '19:30', '1930'),
('in', 2, '20:00', '2000'),
('out', 0, '23:00', '2300'),
('out', 1, '23:30', '2330'),
('out', 2, '00:00', '0000'),
('out', 3, 'LAST', '0030'),
('out', 4, 'LAST', '0100'),
('out', 5, 'LAST', '0130'),
('out', 6, 'LAST', '0200')
SRM;
mysqli_query($mysqli, $sql);
echo $sql;

$sql=<<<SRN
INSERT INTO `{$key}_tag` (`tag_group`, `sort`, `tag_name`, `tag_icon`, `del`) VALUES
('ribbon', 1, '近日入店', '#0000d0', 0),
('ribbon', 2, '本日入店', '#008000', 0),
('ribbon', 3, '新人', '#d00000', 0),

('blog', 1, 'Diary', '', 0),
('blog', 2, '日常', '', 0),
('blog', 3, 'お仕事', '', 0),
('blog', 4, '趣味', '', 0),
('blog', 5, '告知', '', 0),
('blog', 6, '買い物', '', 0),
('blog', 7, 'ファッション', '', 0),

('news', 1, 'お知らせ', '#ffe0f0', 0),
('news', 2, '入店情報', '#c0e0ff', 0),
('news', 3, 'イベント', '#ffe090', 0),

('cast_group', 1, '新宿昼', '', 0),
('cast_group', 2, '新宿夜', '', 0),
('cast_group', 3, '池袋昼', '', 0),
('cast_group', 4, '池袋夜', '', 0),
('cast_group', 5, 'スタッフ', '', 0),
('notice_category', 1, '業務関連', '', 0),
('notice_category', 2, 'イベント', '', 0),
('notice_category', 3, '緊急', '', 0),
('notice_category', 4, 'その他', '', 0)
SRN;
mysqli_query($mysqli, $sql);
/*

INSERT INTO `{$key}_item_color` (`id`, `item_id`, `item_group`, `item_color`, `del`) VALUES
(1, 0, 'color', '#303030', 0),
(2, 1, 'color', '#000080', 0),
(3, 2, 'color', '#008000', 0),
(4, 3, 'color', '#9acd32', 0),
(5, 4, 'color', '#800000', 0),
(6, 5, 'color', '#500080', 0),
(7, 6, 'color', '#b22222', 0),
(8, 7, 'color', '#d2b48c', 0),
(9, 8, 'color', '#c0c0c0', 0),
(10, 9, 'color', '#ffd700', 0),
(11, 10, 'color', '#ffc0cb', 0),
(12, 11, 'color', '#b0e0e6', 0);


INSERT INTO `{$key}_item_icon` (`id`, `item_id`, `item_group`, `item_icon`, `del`) VALUES
(1, 0, 'icon', '', 0),
(2, 1, 'icon', '', 0),
(3, 2, 'icon', '', 0),
(4, 3, 'icon', '', 0),
(5, 4, 'icon', '', 0),
(6, 5, 'icon', '', 0),
(7, 6, 'icon', '', 0),
(8, 7, 'icon', '', 0),
(9, 8, 'icon', '', 0),
(10, 9, 'icon', '', 0),
(11, 10, 'icon', '', 0),
(12, 11, 'icon', '', 0);



*/
}
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-party</title>
</head>
<body>

<form method="post">
data<input type="text" name="db"><br>
user<input type="text" name="user"><br>
pass<input type="text" name="pass"><br>
db_n<input type="text" name="dbn"><br>
key_<input type="text" name="key"><br>

<button type="submit">SET</button>
</form>
</body>
</html>

