<?php
/*
Night-Party SETUP
2022.04.11
*/

$db		=$_POST["db"];
$user	=$_POST["user"];
$pass	=$_POST["pass"];
$dbn	=$_POST["dbn"];
$key	=$_POST["key"];


$ad_id	=$_POST["ad_id"];
$ad_ps	=$_POST["ad_ps"];
$ad_ml	=$_POST["ad_ml"];

$ad_f	=$_POST["ad_f"];
$hime_f	=$_POST["hime_f"];

$now=date("Y-m-d H:i:s");
/*
echo "data　".$db."<br>\n";
echo "user　".$user."<br>\n";
echo "pass　".$pass."<br>\n";
echo "dbn 　".$dbn."<br>\n";
echo "key 　".$key."<br>\n";
*/

if($user && $pass && $key && $db && $dbn && $ad_id && $ad_ps && $ad_ml && $ad_f && $hime_f && $ad_f !== $hime_f){

$mysqli = mysqli_connect($db, $user, $pass, $dbn);
if(!$mysqli){
	$msg="接続エラー!";
	die("接続エラー");
}
echo "DB SETUP<br>\n";

$sql=<<<SQX
CREATE TABLE `{$key}_encode` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `gp` int(3) DEFAULT NULL,
  `key` varchar(2) COLLATE utf8mb4_bin DEFAULT NULL,
  `value` varchar(1) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQX;
mysqli_query($mysqli, $sql);

$ea=array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");

shuffle($ea);
for($n=0;$n<36;$n++){
	for($s=0;$s<36;$s++){
		$dat_e[]=$ea[$n].$ea[$s];
	}
}

shuffle($dat);

$sql="INSERT INTO `{$key}_encode` (`gp`, `key`,`value`) VALUES";

for($t=0;$t<720;$t++){
	$u1=floor($t/36);
	$u2=$t % 36;
	$sql.="('{$u1}','{$dat_e[$t]}','{$ea[$u2]}'),";
}

$sql	=substr($sql,0,-1);
mysqli_query($mysqli, $sql);


$sql=<<<SSS
CREATE TABLE `{$key}_cast` (
  `regist_id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id` int(10) DEFAULT NULL,
  `ctime` varchar(8) COLLATE utf8mb4_bin DEFAULT NULL,
  `box_no` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `genji` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `genji_kana` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `twitter` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `facebook` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `cast_mail` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `cast_rank` int(3) DEFAULT NULL,
  `cast_group` int(2) DEFAULT NULL,
  `cast_sort` int(3) DEFAULT NULL,
  `login_id` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `login_pass` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `cast_status` int(10) DEFAULT NULL COMMENT '0:通常/1:準備/2:休職/3:退職/4:停止/99:削除',
  `del` int(1) DEFAULT NULL,
  `week_st` int(2) DEFAULT NULL,
  `times_st` int(2) DEFAULT NULL,
  `cast_salary` int(10) DEFAULT NULL,
  `ribbon_use` int(1) DEFAULT NULL COMMENT '0:使う/1:使わない',
  `cast_ribbon` int(2) DEFAULT NULL,
  `prm` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SSS;
mysqli_query($mysqli, $sql);


$sql=<<<SQA
CREATE TABLE `{$key}_cast_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cast_id` int(10) DEFAULT NULL,
  `c_sort_main` int(10) DEFAULT NULL,
  `c_sort_asc` int(10) DEFAULT NULL,
  `c_sort_group` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQA;
mysqli_query($mysqli, $sql);


$sql=<<<SQB
CREATE TABLE `{$key}_cast_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime DEFAULT NULL,
  `sdate` date DEFAULT NULL,
  `stime` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `edate` varchar(8) COLLATE utf8mb4_bin DEFAULT NULL,
  `etime` varchar(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `cast_id` int(10) DEFAULT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `action_id` int(10) DEFAULT NULL,
  `del` int(1) DEFAULT NULL,
  `log` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `days` date DEFAULT NULL,
  `pts` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQB;
mysqli_query($mysqli, $sql);


$sql=<<<SQC
CREATE TABLE `{$key}_cast_log_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `master_id` int(10) DEFAULT NULL,
  `action_id` int(10) DEFAULT NULL,
  `log_color` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `log_icon` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `log_comm` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `log_price` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `del` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQC;
mysqli_query($mysqli, $sql);


$sql=<<<SQD
CREATE TABLE `{$key}_cast_log_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cast_id` int(10) DEFAULT NULL,
  `item_name` varchar(12) COLLATE utf8mb4_bin DEFAULT NULL,
  `item_icon` int(5) DEFAULT NULL,
  `item_color` int(5) DEFAULT NULL,
  `price` int(10) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  `del` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQD;
mysqli_query($mysqli, $sql);


$sql=<<<SQE
CREATE TABLE `{$key}_charm_sel` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `list_id` int(10) DEFAULT NULL,
  `cast_id` int(10) DEFAULT NULL,
  `log` varchar(3000) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQE;
mysqli_query($mysqli, $sql);


$sql=<<<SQF
CREATE TABLE `{$key}_charm_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `sort` int(3) DEFAULT NULL,
  `charm` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `style` int(1) DEFAULT NULL,
  `view` int(1) DEFAULT NULL,
  `del` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQF;
mysqli_query($mysqli, $sql);


$sql=<<<SQG
CREATE TABLE `{$key}_check_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `host_id` int(10) DEFAULT NULL,
  `list_sort` int(10) DEFAULT NULL,
  `list_title` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `del` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQG;
mysqli_query($mysqli, $sql);


$sql=<<<SQH
CREATE TABLE `{$key}_check_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `sort` int(10) DEFAULT NULL,
  `title` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `style` int(1) DEFAULT NULL,
  `del` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQH;
mysqli_query($mysqli, $sql);


$sql=<<<SQI
CREATE TABLE `{$key}_check_sel` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `list_id` int(10) DEFAULT NULL,
  `cast_id` int(10) DEFAULT NULL,
  `sel` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQI;
mysqli_query($mysqli, $sql);


$sql=<<<SQJ
CREATE TABLE `{$key}_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `config_key` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `config_value` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQJ;
mysqli_query($mysqli, $sql);


$id=$dat[810].$dat[920].$dat[980];
$ps=$dat[800].$dat[900].$dat[960].$dat[999];

$open_day=date("Ymd");
$main_url=(empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$main_url=str_replace("/nightparty_setup.php","",$main_url);


$sql=<<<SQK
INSERT INTO `{$key}_config` (`config_key`, `config_value`) VALUES
('admin_id', '{$ad_id}'),
('admin_pass', '{$ad_ps}'),
('admin_mail', '{$ad_ml}'),
('store_name', ''),
('main_url', '{$main_url}'),
('main_mail', ''),
('main_tel', ''),
('admin_url', '{$ad_f}'),
('cast_url', '{$hime_f}'),
('start_time', '9'),
('start_week', '0'),
('jst', '9'),
('ribbon', '1'),
('new_commer_cnt', '30'),
('today_commer', '1'),
('coming_soon', '1'),
('open_day', '{$open_day}'),
('jpg_select', '1'),
('webp_select', '1'),
('twitter', ''),
('twitter_view', ''),
('instagram', ''),
('instagram_view', ''),
('facebook', ''),
('facebook_view', '');

SQK;
mysqli_query($mysqli, $sql);

$sql=<<<SQL
CREATE TABLE `{$key}_contact_list` (
	`list_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`host_id` int(11) NOT NULL,
	`date` datetime DEFAULT NULL,
	`send_date` datetime DEFAULT NULL,
	`tag_group` int(5) DEFAULT NULL,
	`q0` varchar(60) DEFAULT NULL,
	`a0` varchar(1000) DEFAULT NULL,
	`q1` varchar(60) DEFAULT NULL,
	`a1` varchar(1000) DEFAULT NULL,
	`q2` varchar(60) DEFAULT NULL,
	`a2` varchar(1000) DEFAULT NULL,
	`q3` varchar(60) DEFAULT NULL,
	`a3` varchar(1000) DEFAULT NULL,
	`q4` varchar(60) DEFAULT NULL,
	`a4` varchar(1000) DEFAULT NULL,
	`q5` varchar(60) DEFAULT NULL,
	`a5` varchar(1000) DEFAULT NULL,
	`q6` varchar(60) DEFAULT NULL,
	`a6` varchar(1000) DEFAULT NULL,
	`q7` varchar(60) DEFAULT NULL,
	`a7` varchar(1000) DEFAULT NULL,
	`q8` varchar(60) DEFAULT NULL,
	`a8` varchar(1000) DEFAULT NULL,
	`q9` varchar(60) DEFAULT NULL,
	`a9` varchar(1000) DEFAULT NULL,
	`res_kind` int(2) DEFAULT NULL,
	`log` varchar(5000) DEFAULT NULL,
	`staff` varchar(50) DEFAULT NULL,
	`del` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQL;
mysqli_query($mysqli, $sql);


$sql=<<<SQM
CREATE TABLE `{$key}_contact_table` (
`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
`block` int(10) NOT NULL,
`sort` int(2) NOT NULL,
`name` varchar(30) COLLATE utf8mb4_bin NOT NULL,
`type` int(1) NOT NULL,
`ck` int(1) NOT NULL,
`del` int(1) DEFAULT NULL,
`sel_0` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
`sel_1` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
`sel_2` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
`sel_3` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
`sel_4` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
`sel_5` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
`sel_6` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
`sel_7` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
`sel_8` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
`sel_9` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQM;
mysqli_query($mysqli, $sql);


$sql=<<<SQN
CREATE TABLE `{$key}_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime DEFAULT NULL,
  `display_date` datetime DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `sort` int(3) DEFAULT '0',
  `page` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `category` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `contents_key` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `contents` varchar(2000) COLLATE utf8mb4_bin DEFAULT NULL,
  `tag` int(2) DEFAULT NULL,
  `status` int(1) DEFAULT NULL COMMENT '0:表示/1:表示前/2:注目/3:非表示/4:削除',
  `prm` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQN;
mysqli_query($mysqli, $sql);


$sql=<<<SQO
INSERT INTO `{$key}_contents` (`date`, `display_date`, `event_date`, `sort`, `page`, `category`, `contents_key`, `title`, `contents`, `tag`, `status`, `prm`) VALUES
('{$now}','{$now}','{$now}', NULL, 0, 'recruit', 'top', '', '集客力に自信があります！', '新規オープンにつきコンパニオン大募集!!\r\n忙しすぎてキャスト様が足りていません!!\r\n急な出費にも嬉しい完全全額日払い制です！\r\n当日出勤も100％OKなので、貴女のライフスタイルに合わせて働けます！\r\n週に1度、少しの時間でもOK♪\r\nその他嬉しい特典もいっぱいご用意しております。\r\n働きやすい環境でいっぱい貴女の魅力を発揮してください!!\r\n', 0, 0, '0'),
('{$now}','{$now}','{$now}', 1, 'recruit', 'list', '', '職種', 'フロアレディ', 0, 0, '0'),
('{$now}','{$now}','{$now}', 2, 'recruit', 'list', '', '勤務時間', '20:00～LAST\r\n週1からOK\r\n終電上がり可\r\n', 0, 0, '0'),
('{$now}','{$now}','{$now}', 3, 'recruit', 'list', '', 'その他', '18歳以上（高校生不可）\r\n◇未経験者歓迎\r\n◇経験者超優遇\r\n◇学生・Wワーク・フリーターOK\r\n◇ブランクありOK\r\n◇即日体入OK\r\n◇友達同士の応募OK', 0, 4, '0'),
('{$now}','{$now}','{$now}', 0, 'recruit', 'mail', '', NULL, NULL, NULL, 0, '0'),
('{$now}','{$now}','{$now}', 0, 'recruit', 'tel', '', NULL, NULL, NULL, 0, '0'),
('{$now}','{$now}','{$now}', 0, 'recruit', 'line', '', NULL, NULL, NULL, 0, '0'),
('{$now}','{$now}','{$now}', 0, 'recruit', 'call', '', NULL, NULL, NULL, 0, '0'),
('{$now}','{$now}','{$now}', 0, 'policy', NULL, '', 'プライバシーポリシー', '<div class=\"system_box\">\r\n『Night★Party』（以下，「当社」といいます。）は，本ウェブサイト上で提供するサービス（以下,「本サービス」といいます。）における，ユーザーの個人情報の取扱いについて，以下のとおりプライバシーポリシー（以下，「本ポリシー」といいます。）を定めます。\r\n</div>\r\n\r\n<div class=\"system_title\">第1条　個人情報</div>\r\n<div class=\"system_box\">\r\n「個人情報」とは，個人情報保護法にいう「個人情報」を指すものとし，生存する個人に関する情報であって，当該情報に含まれる氏名，生年月日，住所，電話番号，連絡先その他の記述等により特定の個人を識別できる情報及び容貌，指紋，声紋にかかるデータ，及び健康保険証の保険者番号などの当該情報単体から特定の個人を識別できる情報（個人識別情報）を指します。\r\n</div>\r\n\r\n<div class=\"system_title\">第2条　個人情報の収集方法</div>\r\n<div class=\"system_box\">\r\n当社は，ユーザーが利用登録をする際に氏名，生年月日，住所，電話番号，メールアドレス，銀行口座番号，クレジットカード番号，運転免許証番号などの個人情報をお尋ねすることがあります。また，ユーザーと提携先などとの間でなされたユーザーの個人情報を含む取引記録や決済に関する情報を,当社の提携先（情報提供元，広告主，広告配信先などを含みます。以下，｢提携先｣といいます。）などから収集することがあります。\r\n</div>\r\n\r\n<div class=\"system_title\">第3条　個人情報の利用目的</div>\r\n<div class=\"system_box\">\r\n当社が個人情報を収集・利用する目的は，以下のとおりです。\r\n<span class=\"system_box_in\">\r\n当社サービスの提供・運営のため<br>\r\nユーザーからのお問い合わせに回答するため（本人確認を行うことを含む）<br>\r\nユーザーが利用中のサービスの新機能，更新情報，キャンペーン等及び当社が提供する他のサービスの案内のメールを送付するため<br>\r\nメンテナンス，重要なお知らせなど必要に応じたご連絡のため<br>\r\n利用規約に違反したユーザーや，不正・不当な目的でサービスを利用しようとするユーザーの特定をし，ご利用をお断りするため<br>\r\nユーザーにご自身の登録情報の閲覧や変更，削除，ご利用状況の閲覧を行っていただくため<br>\r\n</span>\r\n</div>\r\n', NULL, 0, '0'),
('{$now}','{$now}','{$now}', 0, 'access', NULL, 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6480.493699549161!2d139.698772026149!3d35.6955426207637!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188cd84e865c35%3A0x33418e00dfeefac!2z44CSMTYwLTAwMjEg5p2x5Lqs6YO95paw5a6_5Yy65q2M6Iie5LyO55S6!5e0!3m2!1sja!2sjp!4v1623568073631!5m2!1sja!2sjp', 'ACCESS', '<h1 class=\"access_h1\">Night★Party</h1>\r\n<div class=\"access_tag\">住所</div>\r\n<div class=\"access_box\">\r\n	〒160-0021<br>\r\n	東京都新宿区歌舞伎町1-1-1 新宿ビルB1F<br>\r\n</div>\r\n<div class=\"access_tag\">アクセス</div>\r\n<div class=\"access_box\">\r\n	JR線 新宿駅東口より徒歩3分<br> \r\n	西武新宿線西武新宿駅より徒歩3分<br>\r\n</div>\r\n<div class=\"access_tag\">電話番号</div>\r\n<div class=\"access_box\">\r\n	<span>03</span>-<span>6457</span>-<span>6156</span>\r\n</div>\r\n<div class=\"access_tag\">営業時間</div>\r\n<div class=\"access_box\">\r\n	20:00～LAST<br>\r\n</div>\r\n', NULL, 0, '0'),
('{$now}','{$now}','{$now}', 0, 'system', NULL, '', 'SYSTEM', '<div class=\"system_title\">MAIN GUEST</div>\r\n<div class=\"system_box\">\r\n<span class=\"system_box_1\">18:00-20:00</span><span class=\"system_box_2\">60min</span><span class=\"system_box_3\">￥8,000</span><br>\r\n<span class=\"system_box_1\">20:00-22:00</span><span class=\"system_box_2\">60min</span><span class=\"system_box_3\">￥9,000</span><br>\r\n<span class=\"system_box_1\">22:00-LAST</span><span class=\"system_box_2\">60min</span><span class=\"system_box_3\">￥12,000</span><br>\r\n<span class=\"system_box_1\">延長</span><span class=\"system_box_2\">30min</span><span class=\"system_box_3\">￥4,000</span><br>\r\n</div>\r\n<div class=\"system_title\">V.I.P GUEST</div>\r\n<div class=\"system_box\">\r\n<span class=\"system_box_1\">18:00-LAST</span><span class=\"system_box_2\">60min</span><span class=\"system_box_3\">￥12,000</span><br>\r\n<span class=\"system_box_1\">延長</span><span class=\"system_box_2\">30min</span><span class=\"system_box_3\">￥6,000</span><br>\r\n</div>\r\n<div class=\"system_title\">その他</div>\r\n<div class=\"system_box\">\r\n<span class=\"system_box_1\">場内指名</span><span class=\"system_box_2\">　</span><span class=\"system_box_3\">￥2,000</span><br>\r\n<span class=\"system_box_1\">本指名</span><span class=\"system_box_2\">　</span><span class=\"system_box_3\">￥3,000</span><br>\r\n</div>\r\n<div class=\"system_title\">クレジットカード</div>\r\n<div class=\"system_box\">\r\n<span class=\"system_box_1\">VISA</span><br>\r\n<span class=\"system_box_1\">JCB</span><br>\r\n<span class=\"system_box_1\">AMEX</span><br>\r\n</div>', NULL, 0, NULL)
SQO;
mysqli_query($mysqli, $sql);

$sql=<<<SQP
CREATE TABLE `{$key}_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cast_id` int(11) DEFAULT NULL,
  `nickname` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `regist_date` datetime DEFAULT NULL,
  `birth_day` varchar(8) COLLATE utf8mb4_bin DEFAULT NULL,
  `fav` int(2) DEFAULT NULL,
  `c_group` int(10) DEFAULT NULL,
  `tel` varchar(12) COLLATE utf8mb4_bin DEFAULT NULL,
  `mail` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `twitter` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `insta` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `facebook` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `line` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `web` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `del` int(2) DEFAULT NULL,
  `block` int(2) DEFAULT NULL,
  `opt` int(1) DEFAULT NULL,
  `face` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `prm` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQP;
mysqli_query($mysqli, $sql);


$sql=<<<SQQ
CREATE TABLE `{$key}_customer_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `group_id` int(2) DEFAULT NULL,
  `cast_id` int(10) DEFAULT NULL,
  `sort` int(3) DEFAULT NULL,
  `tag` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `del` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQQ;
mysqli_query($mysqli, $sql);


$sql=<<<SQR
CREATE TABLE `{$key}_customer_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `gp` int(3) DEFAULT NULL,
  `style` int(3) DEFAULT NULL,
  `item_name` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `del` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQR;
mysqli_query($mysqli, $sql);


$sql=<<<SQS
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
SQS;
mysqli_query($mysqli, $sql);


$sql=<<<SQT
CREATE TABLE `{$key}_customer_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cast_id` int(10) DEFAULT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `item` int(3) DEFAULT NULL,
  `comm` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `del` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQT;
mysqli_query($mysqli, $sql);


$sql=<<<SQU
CREATE TABLE `{$key}_customer_memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime DEFAULT NULL,
  `cast_id` int(10) DEFAULT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `tag` int(5) DEFAULT NULL,
  `log` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `del` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQU;
mysqli_query($mysqli, $sql);


$sql=<<<SQV
CREATE TABLE `{$key}_easytalk` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `send_date` datetime DEFAULT NULL,
  `watch_date` datetime DEFAULT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `cast_id` int(10) DEFAULT NULL,
  `send_flg` int(1) DEFAULT NULL,
  `log` varchar(2000) COLLATE utf8mb4_bin DEFAULT NULL,
  `img` mediumtext COLLATE utf8mb4_bin,
  `mail_del` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQV;
mysqli_query($mysqli, $sql);


$sql=<<<SQW
CREATE TABLE `{$key}_easytalk_tmpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cast_id` int(10) DEFAULT NULL,
  `sort` int(2) DEFAULT NULL,
  `title` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `log` varchar(2000) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQW;
mysqli_query($mysqli, $sql);

$sql=<<<SQY
CREATE TABLE `{$key}_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime DEFAULT NULL,
  `ref` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `ua` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `ip` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `page` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `parm` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `value` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `days` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
SQY;
mysqli_query($mysqli, $sql);


$sql=<<<SQZ
CREATE TABLE `{$key}_mypage_chg` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cast_id` int(11) DEFAULT NULL,
  `base_mail` varchar(100) DEFAULT NULL,
  `new_mail` varchar(100) DEFAULT NULL,
  `base_pass` varchar(100) DEFAULT NULL,
  `new_pass` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL,
  `done` int(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SQZ;
mysqli_query($mysqli, $sql);


$sql=<<<TQA
CREATE TABLE `{$key}_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime DEFAULT NULL,
  `title` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `log` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `category` int(2) DEFAULT NULL,
  `writer` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `cast_group` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `del` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
TQA;
mysqli_query($mysqli, $sql);


$sql=<<<TQB
CREATE TABLE `{$key}_notice_ck` (
  `ck_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `view_date` datetime DEFAULT NULL,
  `notice_id` int(10) DEFAULT NULL,
  `cast_id` int(10) DEFAULT NULL,
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
TQB;
mysqli_query($mysqli, $sql);


$sql=<<<TQC
CREATE TABLE `{$key}_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime DEFAULT NULL,
  `view_date` datetime DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `log` varchar(2000) COLLATE utf8mb4_bin DEFAULT NULL,
  `cast` int(10) DEFAULT NULL,
  `tag` int(2) DEFAULT NULL,
  `img` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `img_del` int(1) DEFAULT NULL,
  `status` int(2) DEFAULT NULL COMMENT '0:表示/1:予約/2:個人/3:非表示/4:削除',
  `prm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
TQC;
mysqli_query($mysqli, $sql);


$sql=<<<TQD
CREATE TABLE `{$key}_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date` datetime DEFAULT NULL,
  `sche_date` varchar(8) COLLATE utf8mb4_bin DEFAULT NULL,
  `cast_id` int(10) DEFAULT NULL,
  `stime` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `etime` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `signet` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
TQD;
mysqli_query($mysqli, $sql);


$sql=<<<TQE
CREATE TABLE `{$key}_schedule_memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date_8` varchar(8) COLLATE utf8mb4_bin DEFAULT NULL,
  `log` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `cast_id` int(10) DEFAULT NULL,
  `del` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
TQE;
mysqli_query($mysqli, $sql);


$sql=<<<TQF
CREATE TABLE `{$key}_sch_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `in_out` varchar(3) COLLATE utf8mb4_bin DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  `name` varchar(6) COLLATE utf8mb4_bin DEFAULT NULL,
  `time` varchar(4) COLLATE utf8mb4_bin DEFAULT NULL,
  `del` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
TQF;
mysqli_query($mysqli, $sql);


$sql=<<<TQG
CREATE TABLE `{$key}_ssid` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ssid` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `cast_id` int(10) DEFAULT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `del` int(1) DEFAULT NULL,
  `effect` int(1) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `mail` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
TQG;
mysqli_query($mysqli, $sql);


$sql=<<<TQH
CREATE TABLE `{$key}_staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `sort` int(10) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `kana` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `tel` varchar(11) COLLATE utf8mb4_bin DEFAULT NULL,
  `line` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `mail` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `address` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `birthday` varchar(8) COLLATE utf8mb4_bin DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `registday` varchar(8) COLLATE utf8mb4_bin DEFAULT NULL,
  `rank` int(2) DEFAULT NULL,
  `group` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `position` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `pf1` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `pf2` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `pf3` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `pf4` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `pf5` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `pf6` varchar(500) COLLATE utf8mb4_bin DEFAULT NULL,
  `del` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin auto_increment = 12345;
TQH;

mysqli_query($mysqli, $sql);


$sql=<<<TQI
CREATE TABLE `{$key}_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tag_group` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `tag_name` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `tag_icon` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `del` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
TQI;

mysqli_query($mysqli, $sql);


$sql=<<<TQJ
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

('cast_group', 1, 'キャスト', '', 0),
('cast_group', 2, 'スタッフ', '', 0),

('notice_category', 1, '業務関連', '', 0),
('notice_category', 2, 'イベント', '', 0),
('notice_category', 3, '緊急', '', 0),
('notice_category', 4, 'その他', '', 0);
TQJ;
mysqli_query($mysqli, $sql);

$f=file_get_contents("./library/connect.php");

$f=str_replace("AAA",$db,$f);
$f=str_replace("BBB",$user,$f);
$f=str_replace("CCC",$pass,$f);
$f=str_replace("DDD",$dbn,$f);
$f=str_replace("EEE",$key,$f);
file_put_contents("./library/connect.php",$f);


if($ad_f != "admin"){
	rename("/admin","/".$ad_f);
}

if($hime_f != "mypage"){
	rename("/mypage","/".$ad_f);
}


}else{
	echo "パラメータエラー";
}
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-party</title>

<style>
table{
	margin			:5px;
	border-bottom	:1px solid #909090;
}

input{
	padding			:5px;
	height			:40px;
	width			:200px;
	font-size		:18px;
}

td{
	vertical-align	:middle;
	font-size		:18px;
	width			:200px;
	text-align		:right;
}
</style>
</head>
<body>
<?if(!$f){?>
<form method="post">
<table>
<tr>
<td colspan="2" style="background:#909090;color:#fafafa;text-align:center;font-size:15px;">Night-Party SETUP</td>
</tr>

<tr>
<td>DB</td>
<td><input type="text" name="db" value="<?=$db?>"></td>
</tr>


<tr>
<td>user</td>
<td><input type="text" name="user" value="<?=$user?>"></td>
</tr>

<tr>
<td>pass</td>
<td><input type="text" name="pass" value="<?=$pass?>"></td>
</tr>

<tr>
<td>DBname</td>
<td><input type="text" name="dbn" value="<?=$dbn?>"></td>
</tr>

<tr>
<td>TBLname</td>
<td><input type="text" name="key" value="<?=$key?>"></td>
</tr>
</table>

<table>
<tr>
<td>ADMIN_ID</td>
<td><input type="text" name="ad_id" value="<?=$ad_id?>"></td>
</tr>

<tr>
<td>ADMIN_PASS</td>
<td><input type="text" name="ad_ps" value="<?=$ad_ps?>"></td>
</tr>

<tr>
<td>ADMIN_MAIL</td>
<td><input type="text" name="ad_ml" value="<?=$ad_ml?>"></td>
</tr>
</table>

<table>
<tr>
<td>ADMIN_Folder</td>
<td><input type="text" name="ad_f" value="<?=$ad_f?>"></td>
</tr>
<tr>
<td>HIME-Karte_folder</td>
<td><input type="text" name="hime_f" value="<?=$hime_f?>"></td>
</tr>
</table>
<?}?>

<button type="submit"style="width:410px; height:40px;">SET</button>
</form>
</body>
</html>
