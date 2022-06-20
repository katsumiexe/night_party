<?
include_once('../library/sql.php');

$id			=$_POST['id'];
$dat		=$_POST['dat'];

$sql="SELECT id,name FROM ".TABLE_KEY."_contact_table";
$sql.=" WHERE block='{$id}'";
$sql.=" AND del IS NULL";

if($result = mysqli_query($mysqli,$sql)){
	while($raw= mysqli_fetch_assoc($result)){
		$name[$raw["id"]]=$raw["name"];
	}
}

var_dump($dat);

foreach($name as $a1 => $a2){
	if($a2){
		$key1.="`q{$a1}`,`a{$a1}`,";
		$val1.="'{$a2}','{$dat[$a1]}',";
		$body.="▼{$a2}\n{$dat[$a1]}\n\n";				
	}
}

$sql="INSERT INTO ".TABLE_KEY."_contact_list ";
$sql.="({$key1}`date`,`host_id`)";
$sql.=" VALUES({$val1}'{$now}','{$id}')";
mysqli_query($mysqli,$sql);

echo $sql;

$sql="SELECT contents_key FROM ".TABLE_KEY."_contents";
$sql.=" WHERE page='recruit'";
$sql.=" AND category='call'";
$result = mysqli_query($mysqli,$sql);
$raw= mysqli_fetch_assoc($result);

if($raw["contents_key"] && $body){

mb_language("Japanese"); 
mb_internal_encoding("UTF-8");
$to			=$raw["contents_key"];
$title		="[Night Party]お問合せが入りました";


$from_mail	=$admin_config["main_mail"];
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
$body	.=$admin_config["store_name"]."\n";
$body	.=$admin_config["main_url"]."\n";

mb_send_mail($to, $title, $body, $header);

}
exit();
?>
