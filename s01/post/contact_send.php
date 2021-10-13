<?
include_once('../library/sql.php');

$id			=$_POST['id'];
$dat		=$_POST['dat'];

echo $now;

$sql="INSERT INTO wp01_0contact_list ";
$sql.="(`date`,`type`,`log_0`,`log_1`,`log_2`,`log_3`,`log_4`,`log_5`,`log_6`,`log_7`,`log_8`,`log_9`)";
$sql.=" VALUES('{$now}','{$id}','{$dat[0]}','{$dat[1]}','{$dat[2]}','{$dat[3]}','{$dat[4]}','{$dat[5]}','{$dat[6]}','{$dat[7]}','{$dat[8]}','{$dat[9]}')";
mysqli_query($mysqli,$sql);

$sql="SELECT * FROM wp01_0contact_table";
$sql.=" WHERE type='{$id}'";

if($result = mysqli_query($mysqli,$sql)){
	$raw= mysqli_fetch_assoc($result);

	for($n=0;$n<10;$n++){
		$tmp="log_{$n}_name";

		if($raw[$tmp]){
			$body.="▼{$raw[$tmp]}\n{$dat[$n]}\n\n";				
		}
	}
}

if($raw["to_mail"] && $body){
mb_language("Japanese"); 
mb_internal_encoding("UTF-8");

$to			=$raw["to_mail"];
$title		="[Night Party]お問合せが入りました";

$from_mail	="info@arpino.fun";
$from		="NightParty";
$header = '';
$header .= "Content-Type: text/plain \r\n";
$header .= "Return-Path: " . $from_mail . " \r\n";
$header .= "From: " . $from ."<".$from_mail.">\r\n";
$header .= "Reply-To: " . $from_mail . " \r\n";
$header .= "Organization: " . $from_name . " \r\n";
$header .= "X-Sender: " . $from_mail . " \r\n";
$header .= "X-Priority: 3 \r\n";

$body	.="===========================\n";
$body	.="Night Party\n";
$body	.="https://arpino.fun/ngt\n";
$body	.="080-1111-1111\n";
$body	.="info@piyo-piyo.work\n";

mb_send_mail($to, $title, $body, $header);

}
exit();
?>
