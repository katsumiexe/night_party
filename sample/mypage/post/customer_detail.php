<?
/*
顧客情報読み込み
*/
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/


include_once('../../library/sql_post.php');
$cus	=array();
$c_id	=$_POST["c_id"];

$sql	 ="SELECT * FROM wp00000_customer";
$sql	 .=" WHERE del=0";
$sql	 .=" AND id='{$c_id}'";
$sql	 .=" LIMIT 1";

$result = mysqli_query($mysqli,$sql);
$dat = mysqli_fetch_assoc($result);

$b_yy=substr($dat["birth_day"],0,4);
$b_mm=substr($dat["birth_day"],4,2);
$b_dd=substr($dat["birth_day"],6,2);
$b_ag=floor( ( date("Ymd") - $dat["birth_day"] ) / 10000 );

if($dat["mail"]){
	$mail_on=" c_customer_mail";
}

if($dat["twitter"]){
	$twitter_on=" c_customer_twitter";
}

if($dat["insta"]){
	$insta_on=" c_customer_insta";
}

if($dat["facebook"]){
	$facebook_on=" c_customer_faccebook";
}

if($dat["line"]){
	$line_on=" c_customer_line";
}

if($dat["web"]){
	$web_on=" c_customer_web";
}

if($dat["tel"]){
	$tel_on=" c_customer_tel";
}

if (file_exists("../../img/cast/{$box_no}/c/{$dat["face"]}.webp") && $admin_config["webp_select"] == 1) {
	$face="<img id=\"customer_img\" src=\"../img/cast/{$box_no}/c/{$dat["face"]}.webp?t={$dat["prm"]}\" class=\"customer_detail_img\" alt=\"会員\">";

}elseif (file_exists("../../img/cast/{$box_no}/c/{$dat["face"]}.png") ) {
	$face="<img id=\"customer_img\" src=\"../img/cast/{$box_no}/c/{$dat["face"]}.png?t={$dat["prm"]}\" class=\"customer_detail_img\" alt=\"会員\">";

}else{
	$face="<img id=\"customer_img\" src=\"../img/customer_no_image.png?t=".time()."\" class=\"customer_detail_img\" alt=\"会員\">";
}



for($n=0;$n<4;$n++){
	if($n!=$dat["block"]){
		$msg[$n]="style=\"display:none\"";
	}
	if($n!=$dat["opt"]){
		$msg_opt[$n]="style=\"display:none\"";
	}
}

$sel[$dat["block"]]=" checked=\"checked\"";
$opt_sel[$dat["opt"]]=" checked=\"checked\"";

if($dat["block"] == 3){
	$bk=" disabled=\"disabled\"";
}


$sql	 ="SELECT * FROM wp00000_customer_group";
$sql	 .=" WHERE del=0";
$sql	 .=" AND cast_id='{$cast_data["id"]}'";
$sql	 .=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$group.="<option value=\"{$row["id"]}\"";
		if($dat["c_group"] == $row["id"]){
			$group.=" selected=\"selected\"";
		}
		$group.=">{$row["tag"]}</option>";
	}
}

for($n=1;$n<6;$n++){
	$fav.="<span id=\"fav_{$n}\" class=\"customer_fav";
	if($n <= $dat["fav"]){
		$fav.=" fav_in";
	}
	$fav.="\"></span>";
}


for($n=1930;$n<date("Y");$n++){
	$yy.="<option value=\"{$n}\"";
	if($b_yy == $n){
		$yy.=" selected=\"selected\"";
	}
	$yy.=">{$n}</option>";
}

for($n=1;$n<13;$n++){
	$tmp=substr("0".$n,-2,2);
	$mm.="<option value=\"{$tmp}\"";
	if($b_mm == $tmp){
		$mm.=" selected=\"selected\"";
	}
	$mm.=">{$n}</option>";
}

for($n=1;$n<32;$n++){
	$tmp=substr("0".$n,-2,2);
	$dd.="<option value=\"{$tmp}\"";
	if($b_dd == $tmp){
		$dd.=" selected=\"selected\"";
	}
	$dd.=">{$n}</option>";
}

for($n=0;$n<100;$n++){
	$ag.="<option value=\"{$n}\"";
	if($b_ag == $n){
		$ag.=" selected=\"selected\"";
	}
	$ag.=">{$n}</option>";
}

$sql	 ="SELECT * FROM wp00000_cast_log";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND customer_id='{$c_id}'";
$sql	.=" AND del='0'";
$sql	.=" ORDER BY sdate DESC, stime DESC";
$sql	.=" LIMIT 20";

if($result = mysqli_query($mysqli,$sql)){
	while($dat1 = mysqli_fetch_assoc($result)){
		$t_date=str_replace("-",".",$dat1["sdate"]);
		$s_time=$dat1["stime"];
		$e_time=$dat1["etime"];

		$dat1["log"]=str_replace("\n","<br>",$dat1["log"]);

		$app1.="<div class=\"customer_memo_log\">";
			$app1.="<span class=\"customer_detail_in\"></span>";
			$app1.="<div class=\"customer_memo_date\"><span class=\"customer_detail_in\"></span><span class=\"customer_log_icon\"></span><span class=\"customer_log_date_detail\">{$t_date} {$s_time}-{$e_time}</span>";
				$app1.="<div id=\"l_chg{$dat1["log_id"]}\" class=\"customer_log_chg\"></div>";
				$app1.="<div id=\"l_del{$dat1["log_id"]}\" class=\"customer_log_del\"></div>";
			$app1.="</div>";

		$app1.="<div id=\"tr_log_detail{$dat1["log_id"]}\" class=\"customer_memo_log_in\">";
			$app1.="<div class=\"customer_log_memo customer_detail_in\">";
			$app1.="{$dat1["log"]}";
			$app1.="</div>";

			$app1.="<div class=\"customer_log_item item_pts\" style=\"border:1px solid #606090; background:#606090; color:#fafafa;\">";
			$app1.="<span class=\"customer_detail_in\"></span>";
			$app1.="<span class=\"sel_log_icon_s\"></span>";
			$app1.="<span class=\"sel_log_comm_s\">利用総額</span>";
			$app1.="<span class=\"sel_log_price_s\">{$dat1["pts"]}</span>";
			$app1.="</div>";


			$app1.="<div class=\"customer_log_list\"　>";
			$sql	 ="SELECT * FROM wp00000_cast_log_list";
			$sql	.=" WHERE master_id='{$dat1["log_id"]}'";
			$sql	.=" ORDER BY wp00000_cast_log_list.id DESC";

			if($result2 = mysqli_query($mysqli,$sql)){
				while($dat3 = mysqli_fetch_assoc($result2)){
					$app1.="<div class=\"customer_log_item\" style=\"border:1px solid {$dat3["log_color"]}; color:{$dat3["log_color"]};\">";
					$app1.="<span class=\"sel_log_icon_s\">{$dat3["log_icon"]}</span>";
					$app1.="<span class=\"sel_log_comm_s\">{$dat3["log_comm"]}</span>";
					$app1.="<span class=\"sel_log_price_s\">{$dat3["log_price"]}</span>";
					$app1.="</div>";
				}
			}
			$app1.="</div>";
		$app1.="</div>";
		$app1.="</div>";
	}
}
if(!$app1){
	$app1="<div style=\"height:5px;\"></div><div id=\"customer_log_nodata\" class=\"customer_memo_nodata\"\">まだ何もありません</div>";
}

$sql	 ="SELECT * FROM wp00000_customer_memo";
$sql	 .=" WHERE del=0";
$sql	 .=" AND customer_id='{$c_id}'";
$sql	 .=" AND `log` IS NOT NULL";
$sql	 .=" ORDER BY `date` DESC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$row["date"]=str_replace("-",".",$row["date"]);
		$row["date"]=substr($row["date"],0,16);
		$log=str_replace("\n","<br>",$row["log"]);

		$app2.="<div class=\"customer_memo_log\">";
		$app2.="<div class=\"customer_memo_date\"><span class=\"customer_log_icon\"></span>{$row["date"]}";
		$app2.="<div id=\"m_chg{$row["id"]}\" class=\"customer_memo_chg\"></div>";
		$app2.="<div id=\"m_del{$row["id"]}\" class=\"customer_memo_del\"></div>";
		$app2.="</div>";
		$app2.="<div id=\"tr_memo_detail{$row["id"]}\" class=\"customer_memo_log_in\">{$log}</div>";
		$app2.="</div>";

	}
}
if(!$app2){
	$app2="<div style=\"height:5px;\"></div><div id=\"customer_memo_nodata\" class=\"customer_memo_nodata\"\">まだ何もありません</div>";
}


$sql	 ="SELECT * FROM wp00000_customer_list";
$sql	 .=" WHERE del=0";
$sql	 .=" AND customer_id='{$c_id}'";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$cus[$row["item"]]=$row["comm"];
	}
}


$sql	 ="SELECT * FROM wp00000_customer_item";
$sql	 .=" WHERE `del`=0";
$sql	 .=" AND `gp`=0";

$app3.="<table id=\"cs3\" style=\"margin:0 auto\"><tr><td colspan=\"2\" style=\"height:10px;\"></td></tr>";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($row["style"] == 2){
			$s2[$cus[$row["id"]]]=" checked=\"checked\"";
			$app3.="<tr><td class=\"customer_memo_tag\">{$row["item_name"]}</td>";
			$app3.="<td class=\"customer_memo_item\">";
			$app3.="<input id=\"m_a\" type=\"radio\" name=\"cus{$row["id"]}\" value=\"1\" {$s2[1]} class=\"rd\"><label for=\"m_a\" class=\"cousomer_marrige\">既婚</label>";
			$app3.="<input id=\"m_b\" type=\"radio\" name=\"cus{$row["id"]}\" value=\"2\" {$s2[2]} class=\"rd\"><label for=\"m_b\" class=\"cousomer_marrige\">未婚</label>";
			$app3.="<input id=\"m_c\" type=\"radio\" name=\"cus{$row["id"]}\" value=\"3\" {$s2[3]} class=\"rd\"><label for=\"m_c\" class=\"cousomer_marrige\">離婚</label>";
			$app3.="</td></tr>";
			
		}elseif($row["style"] == 3){
			$s3[$cus[$row["id"]]]=" checked=\"checked\"";
			$app3.="<tr><td class=\"customer_memo_tag\">{$row["item_name"]}</td>";
			$app3.="<td class=\"customer_memo_item\">";
			$app3.="<input id=\"b_a\" type=\"radio\" name=\"cus{$row["id"]}\" value=\"1\" {$s3[1]} class=\"rd\"><label for=\"b_a\" class=\"cousomer_blood\">Ａ</label>";
			$app3.="<input id=\"b_b\" type=\"radio\" name=\"cus{$row["id"]}\" value=\"2\" {$s3[2]} class=\"rd\"><label for=\"b_b\" class=\"cousomer_blood\">Ｂ</label>";
			$app3.="<input id=\"b_o\" type=\"radio\" name=\"cus{$row["id"]}\" value=\"3\" {$s3[3]} class=\"rd\"><label for=\"b_o\" class=\"cousomer_blood\">Ｏ</label>";
			$app3.="<input id=\"b_ab\" type=\"radio\" name=\"cus{$row["id"]}\" value=\"4\" {$s3[4]} class=\"rd\"><label for=\"b_ab\" class=\"cousomer_blood\">AB</label>";
			$app3.="</td></tr>";

		}else{
			$app3.="<tr><td class=\"customer_memo_tag\">{$row["item_name"]}</td>";
			$app3.="<td class=\"customer_memo_item\"><input id=\"tbl_a_{$row["id"]}\" type=\"text\" value=\"{$cus[$row["id"]]}\" class=\"item_textbox\" autocomplete=\"off\"></td></tr>";
		}
	}
}
$app3.="</table>";


$app4.="<div class=\"customer_et_config\">";
$app4.="<div class=\"block_return\">×</div>";
$app4.="<div class=\"block_title\"><span class=\"block_title_in\"></span>Easy Talk送信設定</div>";
$app4.="<div class=\"block_flex\">";
$app4.="<input id=\"block_0\" class=\"block_r\" type=\"radio\" name=\"block\" value=\"0\"{$bk}{$sel[0]}><label for=\"block_0\" class=\"block_radio\"> 通　常 </label>";
$app4.="<input id=\"block_1\" class=\"block_r\" type=\"radio\" name=\"block\" value=\"1\"{$bk}{$sel[1]}><label for=\"block_1\" class=\"block_radio\">画像不可</label>";
$app4.="<input id=\"block_2\" class=\"block_r\" type=\"radio\" name=\"block\" value=\"2\"{$bk}{$sel[2]}><label for=\"block_2\" class=\"block_radio\">ブロック</label>";
$app4.="</div>";
$app4.="<div class=\"block_msg\">";
$app4.="<span id=\"msg_block_0\" {$msg[0]}>EasyTalkのご利用が可能です</span>";
$app4.="<span id=\"msg_block_1\" {$msg[1]}>EasyTalkのご利用は可能ですが、画像添付ができません</span>";
$app4.="<span id=\"msg_block_2\" {$msg[2]}>EasyTalkのご利用はできません</span>";
$app4.="<span id=\"msg_block_3\" {$msg[3]}>相手側でEasyTalkの受取りを拒否しています。</span>";
$app4.="</div>";

$app4.="<div class=\"block_title\"><span class=\"block_title_in\"></span>Easy Talk通知設定</div>";
$app4.="<div class=\"block_flex\">";
$app4.="<input id=\"opt_0\" class=\"block_r\" type=\"radio\" name=\"opt\" value=\"0\"{$bk}{$opt_sel[0]}><label for=\"opt_0\" class=\"block_radio\">通知ON</label>";
$app4.="<input id=\"opt_1\" class=\"block_r\" type=\"radio\" name=\"opt\" value=\"1\"{$bk}{$opt_sel[1]}><label for=\"opt_1\" class=\"block_radio\">通知OFF</label>";
$app4.="</div>";

$app4.="<div class=\"block_msg\">";
$app4.="<span id=\"msg_opt_0\" {$msg_opt[0]}>EasyTalk受信時、登録アドレスにお知らせが入ります</span>";
$app4.="<span id=\"msg_opt_1\" {$msg_opt[1]}>EasyTalk受信時のお知らせを受け取りません</span>";
$app4.="</div>";
$app4.="</div>";

$app4.="<div class=\"sp_only_div\">";
$app4.="<div class=\"block_title\"><span class=\"block_title_in\"></span>登録削除</div>";
$app4.="<div class=\"block_del\">リストから削除する</div>";
$app4.="<div class=\"block_msg\">顧客情報を削除します。<br>戻すことは出来ません。アナリティクスの売上とお相手のEasyTalkは削除されません。</div>";
$app4.="</div>";
$app4.="<div class=\"tag_pc pc_only\">";
$app4.="<div class=\"tag_pc_mail\"><span class=\"tag_pc_icon\"></span>Easytalk設定</div>";
$app4.="<div class=\"tag_pc_remove\"><span class=\"tag_pc_icon\"></span>削除</div>";
$app4.="</div>";

$html = <<<INA
<div class="customer_detail_box">
	<div class="customer_detail_in"></div>

	<div class="customer_base">
		<div class="customer_base_img">{$face}</div>
		<div class="customer_base_tag cb1"><span class="customer_detail_in"></span>タグ</div>

		<div class="customer_base_item cb1">
		<select id="customer_group" name="cus_group" class="item_group cas_set">
		<option value="0">通常</option>
		{$group}
		</select>
		</div>

		<div class="customer_base_tag cb2"><span class="customer_detail_in"></span>名前</div>
		<div class="customer_base_item cb2">
			<input type="text" id="customer_detail_name" name="cus_name" class="item_basebox cas_set" value="{$dat["name"]}">
		</div>

		<div class="customer_base_tag cb3"><span class="customer_detail_in"></span>呼び名</div>
		<div class="customer_base_item cb3"><input id="customer_detail_nick" name="cus_nick" type="text" class="item_basebox cas_set" value="{$dat["nickname"]}"></div>

		<div class="customer_base_tag2"><span class="customer_detail_in"></span>好感度</div>
		<div class="customer_base_fav">{$fav}</div>

		<div class="customer_base_tag cb4"><span class="customer_detail_in"></span>誕生日</div>
		<div class="customer_base_item cb4">
		<select id="customer_detail_yy" name="cus_b_y" class="item_basebox_yy cas_set2">{$yy}</select>/<select id="customer_detail_mm" name="cus_b_m" class="item_basebox_mm cas_set2">{$mm}</select>/<select id="customer_detail_dd" name="cus_b_d" class="item_basebox_mm cas_set2">{$dd}</select><span class="detail_age"><select id="customer_detail_ag" name="cus_b_a" class="item_basebox_ag cas_set2">{$ag}</select>歳</span>
		</div>
	</div>

	<table class="customer_sns">
		<tr>
			<td class="customer_sns_1"><span class="customer_detail_in"></span><span id="customer_mail" class="customer_sns_btn{$mail_on}"></span></td>
			<td class="customer_sns_1"><span class="customer_detail_in"></span><span id="customer_line" class="customer_sns_btn{$line_on}"></span></td>
			<td class="customer_sns_1"><span class="customer_detail_in"></span><span id="customer_twitter" class="customer_sns_btn{$twitter_on}"></span></td>
			<td class="customer_sns_1"><span class="customer_detail_in"></span><span id="customer_insta" class="customer_sns_btn{$insta_on}"></span></td>
			<td class="customer_sns_1"><span class="customer_detail_in"></span><span id="customer_facebook" class="customer_sns_btn{$facebookl_on}"></span></td>
			<td class="customer_sns_1"><span class="customer_detail_in"></span><span id="customer_web" class="customer_sns_btn{$web_on}"></span></td>
			<td class="customer_sns_1"><span class="customer_detail_in"></span><span id="customer_tel" class="customer_sns_btn{$tel_on}"></span></td>
		</tr>
		<tr class="customer_sns_tr">
			<td class="customer_sns_2"><span class="customer_detail_in"></span><span id="a_customer_mail" class="sns_arrow_a{$mail_on}"></span></td>
			<td class="customer_sns_2"><span class="customer_detail_in"></span><span id="a_customer_line" class="sns_arrow_a{$line_on}"></span></td>
			<td class="customer_sns_2"><span class="customer_detail_in"></span><span id="a_customer_twitter" class="sns_arrow_a{$twitter_on}"></span></td>
			<td class="customer_sns_2"><span class="customer_detail_in"></span><span id="a_customer_insta" class="sns_arrow_a{$insta_on}"></span></td>
			<td class="customer_sns_2"><span class="customer_detail_in"></span><span id="a_customer_facebook" class="sns_arrow_a{$facebook_on}"></span></td>
			<td class="customer_sns_2"><span class="customer_detail_in"></span><span id="a_customer_web" class="sns_arrow_a{$web_on}"></span></td>
			<td class="customer_sns_2"><span class="customer_detail_in"></span><span id="a_customer_tel" class="sns_arrow_a{$tel_on}"></span></td>
		</tr>
	</table>

	<div class="customer_sns_box">
		<span class="customer_detail_in"></span>
		<div class="sns_jump"><span class="regist_icon2"></span><span class="regist_txt2">移動</span></div>
		<input type="text" class="sns_text" inputmode="url">
		<div class="sns_btn"><span class="regist_icon2"></span><span class="regist_txt2">登録</span></div>
		<div class="customer_sns_ttl"></div>
	</div>
	<div class="customer_tag">
		<span class="customer_detail_in"></span>
		<div id="tag_1" class="tag_set tag_set_ck">履歴</div>
		<div id="tag_2" class="tag_set">メモ</div>
		<div id="tag_3" class="tag_set">項目</div>
		<div id="tag_4" class="tag_set">設定</div>
		<div class="customer_memo_set"><span class="customer_set_icon"></span>新規</div>
		<div class="customer_log_set"><span class="customer_set_icon"></span>新規</div>
	</div>
</div>

<div id="tag_1_tbl" class="customer_memo">{$app1}</div>
<div id="tag_2_tbl" class="customer_memo">{$app2}</div>
<div id="tag_3_tbl" class="customer_memo">{$app3}</div>
<div id="tag_4_tbl" class="customer_memo">{$app4}</div>

<div class="customer_detail_back">
<span class="customer_detail_in back_slide">
	<div class="customer_detail_back_in"></div>
</span>
</div>

<input id="h_customer_tel" type="hidden" value="{$dat["tel"]}">
<input id="h_customer_mail" type="hidden" value="{$dat["mail"]}">
<input id="h_customer_twitter" type="hidden" value="{$dat["twitter"]}">
<input id="h_customer_facebook" type="hidden" value="{$dat["facebook"]}">
<input id="h_customer_insta" type="hidden" value="{$dat["insta"]}">
<input id="h_customer_line" type="hidden" value="{$dat["line"]}">
<input id="h_customer_web" type="hidden" value="{$dat["web"]}">
<input id="es_block" type="hidden" value="{$dat["block"]}">
<input id="es_opt" type="hidden" value="{$dat["opt"]}">

INA;
echo $html;
exit();
?>
