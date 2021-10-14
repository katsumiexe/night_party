<?
$radio_list[1]="電話連絡済";
$radio_list[2]="メール返信済";
$radio_list[3]="LINE返信済";
$radio_list[4]="その他連絡済";
$radio_list[5]="返信不要";
$radio_list[6]="保留";

$s=0;
$sql	 ="SELECT * FROM wp00000_contact_table AS T";
$sql	.=" LEFT JOIN wp00000_contact_list AS L ON T.id=L.type ";
$sql	.=" ORDER BY L.date DESC";
$sql	.=" LIMIT 20";
if($result = mysqli_query($mysqli,$sql)){
	while($res = mysqli_fetch_assoc($result)){
		$dat_id[$s]		=$res;

		$dat[$s][0]["res_radio"]=$res["res_radio"];
		if($res["log_0_type"]>0){
			$dat[$s][0]["name"]		=$res["log_0_name"];
			$dat[$s][0]["log"]		=$res["log_0"];
			$dat[$s][0]["type"]		=substr($res["log_0_type"],0,1);
		}

		if($res["log_1_type"]>0){
			$dat[$s][1]["name"]=$res["log_1_name"];
			$dat[$s][1]["log"]=$res["log_1"];
			$dat[$s][1]["type"]=substr($res["log_1_type"],0,1);
		}

		if($res["log_2_type"]>0){
			$dat[$s][2]["name"]=$res["log_2_name"];
			$dat[$s][2]["log"]=$res["log_2"];
			$dat[$s][2]["type"]=substr($res["log_2_type"],0,1);
		}

		if($res["log_3_type"]>0){
			$dat[$s][3]["name"]=$res["log_3_name"];
			$dat[$s][3]["log"]=$res["log_3"];
			$dat[$s][3]["type"]=substr($res["log_3_type"],0,1);
		}

		if($res["log_4_type"]>0){
			$dat[$s][4]["name"]=$res["log_4_name"];
			$dat[$s][4]["log"]=$res["log_4"];
			$dat[$s][4]["type"]=substr($res["log_4_type"],0,1);
		}

		if($res["log_5_type"]>0){
			$dat[$s][5]["name"]=$res["log_5_name"];
			$dat[$s][5]["log"]=$res["log_5"];
			$dat[$s][5]["type"]=substr($res["log_5_type"],0,1);
		}

		if($res["log_6_type"]>0){
			$dat[$s][6]["name"]=$res["log_6_name"];
			$dat[$s][6]["log"]=$res["log_6"];
			$dat[$s][6]["type"]=substr($res["log_6_type"],0,1);
		}

		if($res["log_7_type"]>0){
			$dat[$s][7]["name"]=$res["log_7_name"];
			$dat[$s][7]["log"]=$res["log_7"];
			$dat[$s][7]["type"]=substr($res["log_7_type"],0,1);
		}

		if($res["log_8_type"]>0){
			$dat[$s][8]["name"]=$res["log_8_name"];
			$dat[$s][8]["log"]=$res["log_8"];
			$dat[$s][8]["type"]=substr($res["log_8_type"],0,1);
		}

		if($res["log_9_type"]>0){
			$dat[$s][9]["name"]=$res["log_9_name"];
			$dat[$s][9]["log"]=$res["log_9"];
			$dat[$s][9]["type"]=substr($res["log_9_type"],0,1);
		}
		$s++;
	}
}

?>
<style>
.contact_top{
	margin-top		:20px;
	width			:1080px;
	border-top		:2px solid #202020;
	height			:50px;
	padding-top		:20px;
}

.contact_table{
	margin			:0 10px 20px 0;
	border			:1px solid #303030;
	width			:600px;
	display			:inline-block;
	vertical-align	:top;
}

.contact_date{
	font-size		:14px;
	padding			:1px 5px;
	border-bottom	:2px solid #202020;
	font-weight		:600;
//	background		:#fafafa;
}

.contact_tag{
	display			:inline-block;
	font-size		:14px;
	margin-right	:5px;
}

.contact_table td{
	font-size		:14px;
	padding			:3px;
	border			:1px solid #303030;
}

.contact_td_l{
	width			:150px;
	background		:#e0e0e0;
	min-height		:20px;
}

.contact_td_r{
	width			:450px;
	background		:#fafafa;
}

.contact_td_r_in{
	display			:block;
	width			:450px;
	font-size		:14px;
	line-height		:20px;
}
.contact_area{
	width			:460px;
	height			:200px;
	resize			:none;
	padding			:10px;
	font-size		:14px;
	vertical-align	:top;
}

</style>
<script>
$(function(){ 
	$('.submit_btn').on('click',function(){

		Tmp=$(this).attr('id').replace('send','');
		Tmp2="radio"+Tmp;

		if($('#staff' + Tmp).val()==''){
			alert('スタッフが空欄です');
		}else{

			$.ajax({
				url:'./post/contact_set.php',
				type: 'post',
				data:{
					'id':Tmp,
					'staff'	:$('#staff' + Tmp).val(),
					'log'	:$('#log' + Tmp).val(),
					'radio'	:$("input[name='"+Tmp2+"']:checked").val(),
				},


			}).done(function(data, textStatus, jqXHR){
				alert('更新されました。');

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});
});

</script>
<header class="head">
</header>

<div class="wrap">
<div class="main_1">
	<?foreach($dat as $a1 => $a2){?>
		<div class="contact_top">
			<span class="contact_date"><?=$dat_id[$a1]["date"]?></span>

			<?for($n=1;$n<7;$n++){?>
			<label for="rd<?=$dat_id[$a1]["list_id"]?>_<?=$n?>" class="ck_free2">
				<span class="check2">
					<input id="rd<?=$dat_id[$a1]["list_id"]?>_<?=$n?>" type="radio" name="radio<?=$dat_id[$a1]["list_id"]?>" value="<?=$n?>" class="ck1" <?if($dat_id[$a1]["res_radio"] ==$n){?>checked="checked"<?}?>>
					<span class="check1"></span>
				</span>
				<?=$radio_list[$n]?>
			</label>
			<?}?>
			<span class="contact_tag">担当：</span>
			<input id="staff<?=$dat_id[$a1]["list_id"]?>" type="text" value="<?=$dat_id[$a1]["staff"]?>" style="width:70px" name="staff">
			<button id="send<?=$dat_id[$a1]["list_id"]?>" type="button" class="submit_btn">登録</button>
		</div>

		<div class="contact_main">
			<table class="contact_table">
				<?for($n=0;$n<10;$n++){?>
					<?if($a2[$n]["name"]){?>
						<tr><td class="contact_td_l"><?=$a2[$n]["name"]?></td>
						<td class="contact_td_r"><div class="contact_td_r_in"><?=$a2[$n]["log"]?></div></td></tr>
					<? } ?>
				<? } ?>
			</table>
			<textarea id="log<?=$dat_id[$a1]["list_id"]?>" class="contact_area"><?=$dat_id[$a1]["res_log"]?></textarea>　
		</div>
	<? } ?>


</div>
</div>
<footer class="foot"></footer>
