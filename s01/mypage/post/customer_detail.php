<?
/*
顧客情報読み込み
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

if($dat["face"]){
	$face="<img id=\"customer_img\" src=\"data:image/jpg;base64,{$dat["face"]}\" class=\"customer_detail_img\" alt=\"会員\">";
}else{
	$face="<img id=\"customer_img\" src=\"../img/customer_no_image.png?t=".time()."\" class=\"customer_detail_img\" alt=\"会員\">";
}

$sql	 ="SELECT * FROM wp00000_customer_group";
$sql	 .=" WHERE del=0";
$sql	 .=" AND cast_id='{$c_id}'";
$sql	 .=" ORDER BY sort";

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
	$mm.="<option value=\"{$n}\"";
	if($b_mm == $n){
		$mm.=" selected=\"selected\"";
	}
	$mm.=">{$n}</option>";
}

for($n=1;$n<32;$n++){
	$dd.="<option value=\"{$n}\"";
	if($b_dd == $n){
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


$html = <<<INA
	<div class="customer_detail_in">
		<table class="customer_base">
			<tr>
				<td class="customer_base_img" rowspan="3">{$face}</td>
				<td class="customer_base_tag">タグ</td>
				<td class="customer_base_item">
				<select id="customer_group" name="cus_group" class="item_group cas_set">
				<option value="0">通常</option>
				{$group}
				</select>
				</td>
			</tr>
			<tr>
				<td class="customer_base_tag">名前</td>
				<td id="c_name" class="customer_base_item">
					<input type="text" id="customer_detail_name" name="cus_name" class="item_basebox cas_set" value="{$dat["name"]}">
				</td>
			</tr>
			<tr>
				<td class="customer_base_tag">呼び名</td>
				<td id="c_nick" class="customer_base_item"><input id="customer_detail_nick" name="cus_nick" type="text" class="item_basebox cas_set" value="{$dat["nickname"]}"></td>
			</tr>
			<tr>
				<td class="customer_base_fav">{$fav}</td>
				<td class="customer_base_tag">誕生日</td>
				<td id="c_birth" class="customer_base_item">
				<select id="customer_detail_yy" name="cus_b_y" class="item_basebox_yy cas_set2">{$yy}</select>/<select id="customer_detail_mm" name="cus_b_m" class="item_basebox_mm cas_set2">{$mm}</select>/<select id="customer_detail_dd" name="cus_b_d" class="item_basebox_mm cas_set2">{$dd}</select><span class="detail_age"><select id="customer_detail_ag" name="cus_b_a" class="item_basebox_ag cas_set2">{$ag}</select>歳</span>
				</td>
			</tr>
		</table>
		<table class="customer_sns">
			<tr>
				<td class="customer_sns_1"><span id="customer_mail" class="customer_sns_btn{$mail_on}"></span></td>
				<td class="customer_sns_1"><span id="customer_line" class="customer_sns_btn{$line_on}"></span></td>
				<td class="customer_sns_1"><span id="customer_twitter" class="customer_sns_btn{$twitter_on}"></span></td>
				<td class="customer_sns_1"><span id="customer_insta" class="customer_sns_btn{$insta_on}"></span></td>
				<td class="customer_sns_1"><span id="customer_facebook" class="customer_sns_btn{$facebookl_on}"></span></td>
				<td class="customer_sns_1"><span id="customer_web" class="customer_sns_btn{$web_on}"></span></td>
				<td class="customer_sns_1"><span id="customer_tel" class="customer_sns_btn{$tel_on}"></span></td>
			</tr>
			<tr class="customer_sns_tr">
				<td class="customer_sns_2"><span id="a_customer_mail" class="sns_arrow_a{$mail_on}"></span></td>
				<td class="customer_sns_2"><span id="a_customer_line" class="sns_arrow_a{$line_on}"></span></td>
				<td class="customer_sns_2"><span id="a_customer_twitter" class="sns_arrow_a{$twitter_on}"></span></td>
				<td class="customer_sns_2"><span id="a_customer_insta" class="sns_arrow_a{$insta_on}"></span></td>
				<td class="customer_sns_2"><span id="a_customer_facebook" class="sns_arrow_a{$facebook_on}"></span></td>
				<td class="customer_sns_2"><span id="a_customer_web" class="sns_arrow_a{$web_on}"></span></td>
				<td class="customer_sns_2"><span id="a_customer_tel" class="sns_arrow_a{$tel_on}"></span></td>
			</tr>
		</table>
		<div class="customer_sns_box">
			<div class="sns_jump"><span class="regist_icon2"></span><span class="regist_txt2">移動</span></div>
			<input type="text" class="sns_text" inputmode="url">
			<div class="sns_btn"><span class="regist_icon2"></span><span class="regist_txt2">登録</span></div>
			<div class="customer_sns_ttl"></div>
		</div>

		<div class="customer_tag">
			<div id="tag_3" class="tag_set tag_set_ck"  style="height:8vw;">履歴</div>
			<div id="tag_2" class="tag_set">メモ</div>
			<div id="tag_1" class="tag_set">項目</div>
			<div id="tag_4" class="tag_set">設定</div>
			<div class="customer_memo_set"><span class="customer_set_icon"></span>新規</div>
			<div class="customer_log_set"><span class="customer_set_icon"></span>新規</div>
		</div>
	</div>
	<div class="customer_box">
12<br>
2<br>
3<br>
4<br>
5<br>
6<br>
7<br>
8<br>
9<br>
12<br>
2<br>
3<br>
4<br>
5<br>
6<br>
7<br>
8<br>
9<br>
12<br>
2<br>
3<br>
4<br>
5<br>
6<br>
7<br>
8<br>
9<br>
12<br>
2<br>
3<br>
4<br>
5<br>
6<br>
7<br>
8<br>
9<br>


	</div>
INA;

echo $html;
exit();
?>
