<?
/*
MEMO2読み込み
*/

include_once('../../library/sql_post.php');
$c_id		=$_POST["c_id"];

$sql	 ="SELECT block, opt FROM wp00000_customer";
$sql	 .=" WHERE del=0";
$sql	 .=" AND id='{$c_id}'";

if($result	 = mysqli_query($mysqli,$sql)){
$row	 = mysqli_fetch_assoc($result);

for($n=0;$n<4;$n++){
	if($n!=$row["block"]){
		$msg[$n]="style=\"display:none\"";
	}
	if($n!=$row["opt"]){
		$msg_opt[$n]="style=\"display:none\"";
	}
}

$sel[$row["block"]]=" checked=\"checked\"";
$opt_sel[$row["opt"]]=" checked=\"checked\"";

if($row["block"] == 3){
	$bk=" disabled=\"disabled\"";
}
$dat.="<div style=\"height:5px\"></div>";
$dat.="<div class=\"block_title\"><span class=\"block_title_in\"></span>Easy Talk送信設定</div>";
$dat.="<div class=\"block_flex\">";
$dat.="<input id=\"block_0\" class=\"block_r\" type=\"radio\" name=\"block\" value=\"0\"{$bk}{$sel[0]}><label for=\"block_0\" class=\"block_radio\"> 通　常 </label>";
$dat.="<input id=\"block_1\" class=\"block_r\" type=\"radio\" name=\"block\" value=\"1\"{$bk}{$sel[1]}><label for=\"block_1\" class=\"block_radio\">画像不可</label>";
$dat.="<input id=\"block_2\" class=\"block_r\" type=\"radio\" name=\"block\" value=\"2\"{$bk}{$sel[2]}><label for=\"block_2\" class=\"block_radio\">ブロック</label>";
$dat.="</div>";
$dat.="<div class=\"block_msg\">";
$dat.="<span id=\"msg_block_0\" {$msg[0]}>EasyTalkのご利用が可能です</span>";
$dat.="<span id=\"msg_block_1\" {$msg[1]}>EasyTalkのご利用は可能ですが、画像添付ができません</span>";
$dat.="<span id=\"msg_block_2\" {$msg[2]}>EasyTalkのご利用はできません</span>";
$dat.="<span id=\"msg_block_3\" {$msg[3]}>相手側でEasyTalkの受取りを拒否しています。</span>";
$dat.="</div>";

$dat.="<div class=\"block_title\"><span class=\"block_title_in\"></span>Easy Talk通知設定</div>";
$dat.="<div class=\"block_flex\">";
$dat.="<input id=\"opt_0\" class=\"block_r\" type=\"radio\" name=\"opt\" value=\"0\"{$bk}{$opt_sel[0]}><label for=\"opt_0\" class=\"block_radio\">通知ON</label>";
$dat.="<input id=\"opt_1\" class=\"block_r\" type=\"radio\" name=\"opt\" value=\"1\"{$bk}{$opt_sel[1]}><label for=\"opt_1\" class=\"block_radio\">通知OFF</label>";
$dat.="</div>";

$dat.="<div class=\"block_msg\">";
$dat.="<span id=\"msg_opt_0\" {$msg_opt[0]}>EasyTalk受信時、登録アドレスにお知らせが入ります</span>";
$dat.="<span id=\"msg_opt_1\" {$msg_opt[1]}>EasyTalk受信時のお知らせを受け取りません</span>";
$dat.="</div>";

$dat.="<div class=\"block_title\"><span class=\"block_title_in\"></span>登録削除</div>";
$dat.="<div class=\"block_del\">リストから削除する</div>";
$dat.="<div class=\"block_msg\">顧客情報は削除されます。戻すことは出来ません。アナリティクスの売上とお相手のEasyTalkは消えません。</div>";
echo $dat;
}

exit();
?>
