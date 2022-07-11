<?
$gd_info=gd_info();
if($gd_info["WebP Support"] != 1){
	$no_webp=1;
}

$start_time=$admin_config["start_time"];
$start_week=$admin_config["start_week"];

$sql ="SELECT * FROM ".TABLE_KEY."_check_main";
$sql.=" WHERE del=0";
$sql.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$c_main_dat[$row["id"]]=$row;
	}
}

$sql ="SELECT * FROM ".TABLE_KEY."_check_list";
$sql.=" ORDER BY host_id ASC, list_sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$c_list_dat[$row["host_id"]][$row["id"]]=$row;
		$count_list++;
	}
}

$sql ="SELECT * FROM ".TABLE_KEY."_sch_table";
$sql.=" WHERE del=0";
$sql.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$table_dat[$row["in_out"]][$row["id"]]=$row;
	}
}

$sql ="SELECT * FROM ".TABLE_KEY."_tag";
$sql.=" WHERE del<2";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag_dat[$row["tag_group"]][$row["id"]]=$row;
		$tag_count++;
	}
}
?>
<script>
ids='<?=$count_list+1?>';

$(function(){
	$('.prof_sort').on('change',function(){
		Tmp=$(this).parent('.plof_list').attr('id').replace('prof_b','');
		Tmp2=$(this).val();
		$('#prof_b'+Tmp2).children('.prof_sort').val(Tmp);
		$('#prof_b'+Tmp2).css('order',Tmp);
		$('#prof_b'+Tmp).css('order',Tmp2);
	});

	$('.main_1').on('change','.chg0',function(){
		Tmp=$(this).attr('id');
		$.ajax({
			url:'./post/config_chg.php',
			type: 'post',
			data:{
				'id':Tmp,
				'val':$(this).val(),
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data)

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.main_1').on('change','.chg1',function(){
		Tmp=$(this).attr('id');
		$.ajax({
			url:'./post/config_tag_chg.php',
			type: 'post',
			data:{
				'id':Tmp,
				'val':$(this).val(),
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data)

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.ck0').on('change',function(){
		Tmp=$(this).attr('id');

		if($(this).prop('checked') == true){
			TmpVal=1;
	
		}else{
			TmpVal=0;
		}

		$.ajax({
			url:'./post/config_chg.php',
			type: 'post',
			data:{
				'id':Tmp,
				'val':TmpVal,
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data)

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.ck1').on('change',function(){
		Tmp="coming_soon";
		
		$.ajax({
			url:'./post/config_chg.php',
			type: 'post',
			data:{
				'id':Tmp,
				'val':$(this).val(),
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data)

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.ck2').on('change',function(){
		Tmp="today_commer";

		$.ajax({
			url:'./post/config_chg.php',
			type: 'post',
			data:{
				'id':Tmp,
				'val':$(this).val(),
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data)

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.set_box').on('change',function(){
		Tmp=$(this).attr('id');
		$.ajax({
			url:'./post/config_chg.php',
			type: 'post',
			data:{
				'id':Tmp,
				'val':$(this).val(),
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data)

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#prof_set_list').sortable({
		axis: 'y',
        handle: '.handle',

		stop:function(){
			var Cnt = 1;
			$(this).children('.tr').each(function(){
				$(this).children('.config_prof_sort').children('.prof_sort').val(Cnt);
				Cnt++;
			});

			ChgList=$(this).sortable("toArray");

			$.ajax({
				url:'./post/config_charm_sort.php',
				type: 'post',
				data:{
					'list[]':ChgList,
				},

			}).done(function(data, textStatus, jqXHR){
				console.log(data)

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		},
	});

	$('#sort_option_table').sortable({
		axis: 'y',
        handle: '.handle',

		stop:function(){
			ChgList=$(this).sortable("toArray");

			$.ajax({
				url:'./post/config_option_table_sort.php',
				type: 'post',
				data:{
					'list[]':ChgList,
				},

			}).done(function(data, textStatus, jqXHR){
				console.log(data)

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		},
	});

	$('.option_flex').sortable({
		containment: 'parent',
		handle: '.sel_move',
		stop : function(){
			ChgList=$(this).sortable("toArray");

			Tmp=$(this).attr('id');
			var Cnt = 1;

			$('.'+Tmp).each(function(){
				$(this).children('.sel_hidden').val(Cnt);
				Cnt++;
			});

			$.ajax({
				url:'./post/config_option_sort.php',
				type: 'post',
				data:{
					'list[]':ChgList,
				},

			}).done(function(data, textStatus, jqXHR){
				console.log(data)

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});

	$('.main_1').on('change','.sel_ck',function() {
		if($(this).prop('checked')){
			$(this).parents('.sel_flex').addClass('sel_ck_off');	
			$(this).siblings().addClass('sel_ck_off');	

		}else{
			$(this).parents('.sel_flex').removeClass('sel_ck_off');	
			$(this).siblings().removeClass('sel_ck_off');	
		}
	});

	$('.option_add').on('click',function(){
		Tmp=$(this).attr('id').replace("ad_","");
		Cnt = $("#no_" + Tmp + " > div").length;
		Cnt++;	

		Lst="<div class=\"sel_flex no_"+Tmp+"\"><span class=\"sel_move\"></span><input id=\"itm_"+ Tmp +"_"+ Cnt +"\" type=\"text\" name=\"sel[" + Cnt + "]\" class=\"sel_text\"><input id=\"sel_del" + Cnt + "\" type=\"checkbox\" name=\"del[" + Cnt + "]\" class=\"sel_ck\" value=\"0\"><label for=\"sel_del" + Cnt + "\" class=\"sel_del\">×</label><input type=\"hidden\" name=\"sort[<?=$b1?>]\" value=\"" + Cnt + "\" class=\"sel_hidden\"></div>";
		$('#no_'+Tmp).append(Lst);
	});

	$('#prof_set').on('click',function() {
		if($('#prof_name_new').val()==''){
			alert('プロフィール名がありません');
			return false;
		}else{
			$('#new_prof_set').submit()
		}
	});

	$('.set_btn').on('click',function() {
		Tmp=$(this).attr('id');

		if(!$('#'+Tmp + '_name').val()){
			alert('タグ名がありません');
			return false;
		}else{
			$.post({
				url:"./post/config_tag_set.php",
				data:{
					'name'	:$('#'+Tmp + '_name').val(),
					'color'	:$('#'+Tmp + '_clr').val(),
					'group' :Tmp,
				},

			}).done(function(data, textStatus, jqXHR){
				$('#'+Tmp + '_name').val('');
				$('#'+Tmp + '_clr').val('');
				$('#'+Tmp + '_list').append(data);

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});

	$('#in_new_set').on('click',function() {
		Name=$('#in_name_new').val();
		Time=$('#in_time_new').val();
		if(Time && Name){
			$.post({
				url:"./post/config_sch_chg.php",
				data:{
					'name'	:Name,
					'time'	:Time,
					'val'	:3,
				},
			}).done(function(data, textStatus, jqXHR){
				console.log(data);
				$('#list_in').html(data);
				$('.now_set').slideDown(400);

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}else{
			alert('時間か名前がありません');
			return false;
		}
	});

	$('#out_new_set').on('click',function() {
		Name=$('#out_name_new').val();
		Time=$('#out_time_new').val();
		if(Time && Name){
			$.post({
				url:"./post/config_sch_chg.php",
				data:{
					'name'	:Name,
					'time'	:Time,
					'val'	:4,
				},

			}).done(function(data, textStatus, jqXHR){
				console.log(data);
				$('#list_out').html(data);
				$('.now_set').slideDown(400);

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}else{
			alert('時間か名前がありません');
			return false;
		}
	});

	$('.main_1').on('click','.view_btn',function() {
		Tmp=$(this).parent().parent().attr('id');

		if($(this).hasClass('bg1')){
			$(this).removeClass('bg1');
			$(this).parent().parent('.tr').removeClass('bg1');	

			$.post({
				url:"./post/config_list_chg.php",
				data:{
					'id'	:Tmp,
					'val'	:0,
				},
			});

		}else{
			$(this).addClass('bg1');
			$(this).parent().parent('.tr').addClass('bg1');

			$.post({
				url:"./post/config_list_chg.php",
				data:{
					'id'	:Tmp,
					'val'	:1,
				},
			}).done(function(data, textStatus, jqXHR){
				console.log(data);

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});

	$('.main_1').on('click','.sch_del_btn',function() {
		if (!confirm('削除します。よろしいですか')) {
			return false;
		}else{
			Tmp=$(this).attr('id').replace('sched_','');
			Name=$('#schen_'+Tmp).val();
			Time=$('#schet_'+Tmp).val();

			$(this).parent('.tr').remove();

			$.post({
				url:"./post/config_sch_chg.php",
				data:{
					'id'	:Tmp,
					'val'	:2,
					'name'	:Name,
					'time'	:Time,
				},
			}).done(function(data, textStatus, jqXHR){



			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});

		}
	});

	$('.main_1').on('click','.sch_chg_btn',function() {
		if (!confirm('変更します。よろしいですか')) {
			return false;

		}else{
			Tmp=$(this).attr('id').replace('schec_','');
			Name=$('#schen_'+Tmp).val();
			Time=$('#schet_'+Tmp).val();

			$(this).parent('.tr').hide();
			$.post({
				url:"./post/config_sch_chg.php",
				data:{
					'id'	:Tmp,
					'val'	:1,
					'name'	:Name,
					'time'	:Time,
				},
			}).done(function(data, textStatus, jqXHR){
				console.log(data);

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});

		}

	});


	$('.main_1').on('click','.del_btn',function() {
		if (!confirm('削除します。よろしいですか')) {
			return false;
		}else{
			Tmp=$(this).parent().parent().attr('id');
			$(this).parent().parent('.tr').hide();
			$.post({
				url:"./post/config_list_chg.php",
				data:{
					'id'	:Tmp,
					'val'	:2,
				},
			}).done(function(data, textStatus, jqXHR){
				console.log(data);

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});

		}
	});

	$('.main_1').on('click','.option_del',function() {
		if (!confirm('削除します。よろしいですか')) {
			return false;
		}else{
			Tmp=$(this).attr('id').replace('dl_','');
			$.post({
				url:"./post/config_option_del.php",
				data:{
					'id'	:Tmp,
				},
			}).done(function(data, textStatus, jqXHR){
				$('#tbl' + Tmp).hide()
				
			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});

	$('.main_1').on('change','.option_ttl, .option_select, .sel_text',function() {
		Tmp=$(this).attr('id');

		$.post({
			url:"./post/config_option_chg.php",
			data:{
				'key'	:Tmp,
				'value'	:$(this).val(),
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(Tmp);
			console.log(data);
			if(data){
				$("#"+Tmp).attr('id',data);
			}

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#option_set').on('click',function() {
		if($('#option_ttl_new').val()==''){
			alert('名前がありません');
			return false;
		}else{
			$('#option_new_set').submit()
		}
	});
});
</script>
<style>
.sel_ck_off{
	background		:linear-gradient(#e0e0e0,#d0d0d0);
	color			:#a0a0a0;
}

td{
	padding:5px;
}

.no_alert{
	font-size:12px;
	color:#c00000;
}
.sche_in{
	padding		:5px;
	text-align	:left;
}

.now_set{
	display:none;
}

.blog_select{
	font-family:at_icon;
	width:50px;
	font-size:20px;
}


</style>
<header class="head">
</header>
<div class="wrap">
<div class="main_1">
<div class="config_title">カレンダースタート</div>
<table class="config_sche">	
	<tr>
		<td class="config_sche_top" style="width:120px;">開始時間</td>
		<td class="config_sche_list">
			<select id="start_time" name="set_time" class="set_box">
			<option value="0">24時</option>
			<option value="1" <?if($start_time=="1"){?> selected="selected"<?}?>>01時</option>
			<option value="2" <?if($start_time=="2"){?> selected="selected"<?}?>>02時</option>
			<option value="3" <?if($start_time=="3"){?> selected="selected"<?}?>>03時</option>
			<option value="4" <?if($start_time=="4"){?> selected="selected"<?}?>>04時</option>
			<option value="5" <?if($start_time=="5"){?> selected="selected"<?}?>>05時</option>
			<option value="6" <?if($start_time=="6"){?> selected="selected"<?}?>>06時</option>
			<option value="7" <?if($start_time=="7"){?> selected="selected"<?}?>>07時</option>
			<option value="8" <?if($start_time=="8"){?> selected="selected"<?}?>>08時</option>
			<option value="9" <?if($start_time=="9"){?> selected="selected"<?}?>>09時</option>
			<option value="10" <?if($start_time=="10"){?> selected="selected"<?}?>>10時</option>
			<option value="11" <?if($start_time=="11"){?> selected="selected"<?}?>>11時</option>
			<option value="12" <?if($start_time=="12"){?> selected="selected"<?}?>>12時</option>
			<option value="13" <?if($start_time=="13"){?> selected="selected"<?}?>>13時</option>
			<option value="14" <?if($start_time=="14"){?> selected="selected"<?}?>>14時</option>
			<option value="15" <?if($start_time=="15"){?> selected="selected"<?}?>>15時</option>
			<option value="16" <?if($start_time=="16"){?> selected="selected"<?}?>>16時</option>
			<option value="17" <?if($start_time=="17"){?> selected="selected"<?}?>>17時</option>
			<option value="18" <?if($start_time=="18"){?> selected="selected"<?}?>>18時</option>
			<option value="19" <?if($start_time=="19"){?> selected="selected"<?}?>>19時</option>
			<option value="20" <?if($start_time=="20"){?> selected="selected"<?}?>>20時</option>
			<option value="21" <?if($start_time=="21"){?> selected="selected"<?}?>>21時</option>
			<option value="22" <?if($start_time=="22"){?> selected="selected"<?}?>>22時</option>
			<option value="23" <?if($start_time=="23"){?> selected="selected"<?}?>>23時</option>
			</select>
		</td>
		<td class="config_sche_top" style="width:120px;">開始曜日</td>
		<td class="config_sche_list">
			<select id="start_week" name="set_week" class="set_box">
			<option value="0">日曜日</option>
			<option value="1" <?if($start_week=="1"){?> selected="selected"<?}?>>月曜日</option>
			<option value="2" <?if($start_week=="2"){?> selected="selected"<?}?>>火曜日</option>
			<option value="3" <?if($start_week=="3"){?> selected="selected"<?}?>>水曜日</option>
			<option value="4" <?if($start_week=="4"){?> selected="selected"<?}?>>木曜日</option>
			<option value="5" <?if($start_week=="5"){?> selected="selected"<?}?>>金曜日</option>
			<option value="6" <?if($start_week=="6"){?> selected="selected"<?}?>>土曜日</option>
			</select>
		</td>
	</tr>
</table>

<div class="config_title">使用画像形式</div>
<table class="config_sche">
	<tr class="tr">
		<td class="config_prof_sort">
		<label for="webp_select" class="ribbon_use">
			<span class="check2">
				<input id="webp_select" type="checkbox" class="ck0" value="1" <?if($no_webp == 1){?>disabled<?}elseif($admin_config["webp_select"] ==1){?>checked="checked"<?}?>>
				<span class="check1"></span>
			</span>
		</label>
		</td>
		<td class="config_prof_name">webP<?if($no_webp == 1){?><span class="no_alert"><br>※利用できません</span><?}?></td>
	</tr>

	<tr class="tr">
		<td class="config_prof_sort">
		<label for="jpg_select" class="ribbon_use">
			<span class="check2">
				<input id="jpg_select" type="checkbox" class="ck0" value="1" <?if($admin_config["jpg_select"] ==1){?>checked="checked"<?}?>>
				<span class="check1"></span>
			</span>
		</label>
		</td>
		<td class="config_prof_name">jpeg</td>
	</tr>

	<tr class="tr">
		<td class="config_prof_sort">
		<label for="png_select" class="ribbon_use">
			<span class="check2">
				<input id="png_select" type="checkbox" class="ck0" value="1"checked="checked" disabled>
				<span class="check1"></span>
			</span>
		</label>
		</td>
		<td class="config_prof_name">png</td>
	</tr>
</table>

<div class="config_title">スケジュール</div>

<table class="config_sche">	
	<tr>
		<td colspan="3" class="config_sche_top">IN</td>
		<td colspan="3" class="config_sche_top">OUT</td>
	</tr>
	<tr>
		<td class="config_sche_top w110">表示</td>
		<td class="config_sche_top w110">時間</td>
		<td class="config_sche_top w130"></td>

		<td class="config_sche_top w110">表示</td>
		<td class="config_sche_top w110">時間</td>
		<td class="config_sche_top w130"></td>
	</tr>

	<tr>
		<td id="list_in" class="config_sche_list" colspan="3">
		<?foreach($table_dat["in"] as $a1 => $a2){?>
		<div class="sche_in">
			<input id="schen_<?=$a1?>" type="text" name="in_name[<?=$a1?>]" class="set_box_sch" value="<?=$a2["name"]?>" style="margin-right:20px;">
			<input id="schet_<?=$a1?>" type="text" name="in_name[<?=$a1?>]" class="set_box_sch" value="<?=$a2["time"]?>" style="margin-right:15px;">
			<button id="schec_<?=$a1?>" type="button" class="prof_btn sch_chg_btn">変更</button>
			<button id="sched_<?=$a1?>" type="button" class="prof_btn sch_del_btn" style="margin:0 5px;">削除</button>
		</div>
		<?}?>
		</td>

		<td id="list_out" class="config_sche_list" colspan="3">
		<?foreach($table_dat["out"] as $a1 => $a2){?>
		<div class="sche_in">
			<input id="schen_<?=$a1?>" type="text" name="in_name[<?=$a1?>]" class="set_box_sch" value="<?=$a2["name"]?>" style="margin-right:20px;">			
			<input id="schet_<?=$a1?>" type="text" name="in_name[<?=$a1?>]" class="set_box_sch" value="<?=$a2["time"]?>" style="margin-right:15px;">
			<button id="schec_<?=$a1?>" type="button" class="prof_btn sch_chg_btn">変更</button>
			<button id="sched_<?=$a1?>" type="button" class="prof_btn sch_del_btn" style="margin:0 5px;">削除</button>
		</div>
		<?}?>
		</td>
	</tr>
</table>

<table class="config_sche">	
	<tr>
		<td class="config_sche_list w110" style="background:#ffe0f0"><input type="text" id="in_name_new" class="set_box_sch" value=""></td>
		<td class="config_sche_list w110" style="background:#ffe0f0"><input type="text" id="in_time_new" class="set_box_sch" value=""></td>
		<td class="config_sche_del w130" style="border-right:1px solid #303030;background:#ffe0f0">
			<button id="in_new_set" type="button" class="prof_btn">追加</button>
		</td>

		<td class="config_sche_list w110" style="background:#ffe0f0"><input type="text" id="out_name_new" class="set_box_sch" value=""></td>
		<td class="config_sche_list w110" style="background:#ffe0f0"><input type="text" id="out_time_new" class="set_box_sch" value=""></td>
		<td class="config_sche_del w130" style="border-right:1px solid #303030;background:#ffe0f0">
			<button id="out_new_set" type="button" class="prof_btn">追加</button>
		</td>
	</tr>
</table>

<div class="config_title">SNS</div>
<table class="config_sche">
	<tr class="tr">
		<td class="config_prof_sort">
		<label for="twitter_view" class="ribbon_use">
			<span class="check2">
				<input id="twitter_view" type="checkbox" class="ck0" value="1" <?if($admin_config["twitter_view"] ==1){?>checked="checked"<?}?>>
				<span class="check1"></span>
			</span>
		</label>
		</td>
		<td class="config_prof_name">twitter</td>
		<td class="config_prof_style"><input id="twitter" type="text" value="<?=$admin_config["twitter"]?>" class="chg0 prof_name"></td>
	</tr>
<!--
	<tr class="tr">
		<td class="config_prof_sort"></td>
		<td class="config_prof_name">Instagram</td>
		<td class="config_prof_style"><input type="text" value="<?=$admin_config["instagram"]?>" class="chg0 prof_name"></td>
	</tr>

	<tr class="tr">
		<td class="config_prof_sort"></td>
		<td class="config_prof_name">FACEBOOK</td>
		<td class="config_prof_style"><input type="text" value="<?=$admin_config["facebook"]?>" class="chg0 prof_name"></td>
	</tr>
-->
</table>

<div class="config_title">リボン</div>
<label for="ribbon" class="ribbon_use">
	<span class="check2">
		<input id="ribbon" type="checkbox" class="ck0" value="1" <?if($admin_config["ribbon"] ==1){?>checked="checked"<?}?>>
		<span class="check1"></span>
	</span>
	<span>リボンを使用する</span>
</label>

<table class="config_sche">	
	<tr>
		<td class="config_sche_top">入店前</td>
		<td class="config_td">
			<label for="cs1" class="ck_free">
				<span class="check2">
					<input id="cs1" type="radio" name="comming_soon" value="1" class="ck1" <?if($admin_config["coming_soon"] ==1){?>checked="checked"<?}?>>
					<span class="check1"></span>
				</span>
				あり
			</label>
			<label for="cs0" class="ck_free">
				<span class="check2">
					<input id="cs0" type="radio" name="comming_soon" value="0" class="ck1" <?if($admin_config["coming_soon"] !=1){?>checked="checked"<?}?>>
					<span class="check1"></span>
				</span>
				なし
			</label>
		</td>
	</tr>

	<tr>
		<td class="config_sche_top">入店日</td>
		<td class="config_td">
			<label for="cs3" class="ck_free">
				<span class="check2">
					<input id="cs3" type="radio" name="today_commer" value="1" class="ck2" <?if($admin_config["today_commer"] ==1){?>checked="checked"<?}?>>
					<span class="check1"></span>
				</span>
				あり
			</label>
			<label for="cs2" class="ck_free">
				<span class="check2">
					<input id="cs2" type="radio" name="today_commer" value="0" class="ck2" <?if($admin_config["today_commer"] !=1){?>checked="checked"<?}?>>
					<span class="check1"></span>
				</span>
				なし
			</label>
		</td>
	</tr>

	<tr>
		<td class="config_sche_top">新人期間</td>
		<td class="config_td"><input type="text" id="new_commer_cnt" name="new_commer_cnt" class="set_box" value="<?=$admin_config["new_commer_cnt"]?>"></td>
	</tr>
</table>
<bR>

<table class="config_sche">	
<thead>
	<tr>
		<td class="config_sche_top" style="width:30px">順番</td>
		<td class="config_sche_top" style="width:240px">名前</td>
		<td class="config_sche_top" style="width:240px">色コード</td>
		<td class="config_sche_top" style="width:120px"></td>
	</tr>
</thead>

<tbody id="ribbon_set_list">
<?$tmp_sort=0;?>
<?foreach($tag_dat["ribbon"] as $a1 => $a2){?>
<?$tmp_sort++;?>
	<tr id="tr_n_<?=$a1?>" class="tr bg<?=$a2["del"]?>">
		<input type="hidden" value="<?=$a2["del"]?>" name="prof_view">

		<td class="config_prof_sort"><input type="text" value="<?=$a2["sort"]?>" class="prof_sort" disabled></td>
		<td class="config_prof_name"><input id="tag_name-<?=$a1?>" type="text" name="news_name[<?=$a1?>]" value="<?=$a2["tag_name"]?>" class="chg1 prof_name"></td>
		<td class="config_prof_style"><input id="tag_icon-<?=$a1?>" type="text" name="news_icon[<?=$a1?>]" value="<?=$a2["tag_icon"]?>" class="chg1 prof_name"></td>
		<td class="config_prof_style">
<?if($a2["sort"]>3){?>
			<button type="button" class="prof_btn view_btn bg<?=$a2["del"]?>">非表示</button>
			<button type="button" class="prof_btn del_btn">削除</button>
<? } ?>
		</td>
	</tr>
<? } ?>
</tbody>
</table>

<table class="config_sche">
	<tr>
		<input type="hidden" name="menu_post" value="config">
		<input type="hidden" value="<?=$tag_count+1?>" name="tag_sort_new">
		<td style="width:30px; background:#ffe0f0;text-align:center;font-weight:600;color:#900000;">新</td>
		<td class="config_prof_name" style=" background:#ffe0f0"><input id="ribbon_set_name" type="text" value="" class="prof_name"></td>
		<td class="config_prof_style" style=" background:#ffe0f0"><input id="ribbon_set_clr" type="text" value="" class="prof_name bg<?=$a2["view"]?>"></td>
		<td class="config_prof_style" style=" background:#ffe0f0">
			<button id="ribbon_set" type="button" class="prof_btn set_btn">追加</button>
		</td>
	</tr>
</table>

<div class="config_title">ニュースタグ</div>
<table class="config_sche">	
<thead>
	<tr>
		<td class="config_sche_top" style="width:30px">順番</td>
		<td class="config_sche_top" style="width:240px">名前</td>
		<td class="config_sche_top" style="width:240px">色コード</td>
		<td class="config_sche_top" style="width:120px"></td>
	</tr>
</thead>

<tbody id="news_set_list">
<?$tmp_sort=0;?>
<?foreach($tag_dat["news"] as $a1 => $a2){?>
<?$tmp_sort++;?>
	<tr id="tr_n_<?=$a1?>" class="tr bg<?=$a2["del"]?>">
		<input type="hidden" value="<?=$a2["view"]?>" name="prof_view">

		<td class="config_prof_sort"><input type="text" value="<?=$a2["sort"]?>" class="prof_sort" disabled></td>
		<td class="config_prof_name"><input id="tag_name-<?=$a1?>" type="text" name="news_name[<?=$a1?>]" value="<?=$a2["tag_name"]?>" class="chg1 prof_name"></td>
		<td class="config_prof_style"><input id="tag_icon-<?=$a1?>" type="text" name="news_icon[<?=$a1?>]" value="<?=$a2["tag_icon"]?>" class="chg1 prof_name"></td>
		<td class="config_prof_style">
			<button type="button" class="prof_btn view_btn bg<?=$a2["del"]?>">非表示</button>
			<button type="button" class="prof_btn del_btn">削除</button>
		</td>
	</tr>
<? } ?>
</tbody>
</table>

<table class="config_sche">
	<tr>
		<input type="hidden" name="menu_post" value="config">
		<input type="hidden" value="<?=$tag_count+1?>" name="tag_sort_new">
		<td style="width:30px; background:#ffe0f0;text-align:center;font-weight:600;color:#900000;">新</td>
		<td class="config_prof_name" style=" background:#ffe0f0"><input id="news_set_name" type="text" value="" class="prof_name"></td>
		<td class="config_prof_style" style=" background:#ffe0f0"><input id="news_set_clr" type="text" value="" class="prof_name bg<?=$a2["view"]?>"></td>
		<td class="config_prof_style" style=" background:#ffe0f0">
			<button id="news_set" type="button" class="prof_btn set_btn">追加</button>
		</td>
	</tr>
</table>


<div class="config_title">プロフィール</div>
<table class="config_sche">
<thead>
	<tr>
		<td class="config_sche_top" style="width:30px">替</td>
		<td class="config_sche_top" style="width:30px">順番</td>
		<td class="config_sche_top" style="width:240px">名前</td>
		<td class="config_sche_top" style="width:120px">スタイル</td>
		<td class="config_sche_top" style="width:120px"></td>
	</tr>
</thead>

<tbody id="prof_set_list" class="tb">
<?foreach($tag_dat["prof"] as $a1 => $a2){?>
	<tr id="tr_p_<?=$a1?>" class="tr bg<?=$a2["del"]?>">
		<input type="hidden" value="<?=$a2["del"]?>" name="prof_del">
		<td class="config_prof_handle handle"></td>
		<td class="config_prof_sort"><input type="text" value="<?=$a2["sort"]?>" class="prof_sort" disabled></td>
		<td class="config_prof_name"><input id="tag_name-<?=$a1?>" type="text" name="prof_name[<?=$a1?>]" value="<?=$a2["tag_name"]?>" class="chg1 prof_name"></td>
		<td class="config_prof_style">

			<select id="tag_icon-<?=$a1?>" name="prof_style[<?=$a1?>]" class="chg1 prof_option">
				<option value="1">一行</option>
				<option value="2" <?if($a2["tag_icon"]== 2){?>selected="selected"<?}?>>複数行</option>
			</select>
		</td>
		<td class="config_prof_style">
			<button type="button" class="prof_btn view_btn bg<?=$a2["del"]?>">非表示</button>
			<button type="button" class="prof_btn del_btn">削除</button>
		</td>
	</tr>
<? } ?>
</tbody>
</table>

<table class="config_sche">
	<tr>
	<input type="hidden" name="menu_post" value="config">
	<input type="hidden" value="<?=$max_charm+1?>" name="prof_sort_new">
		<td style="width:71px; background:#ffe0f0;text-align:center;font-weight:600;color:#900000;" colspan="2">追加</td>
		<td class="config_prof_name" style=" background:#ffe0f0"><input id="prof_set_name" type="text" name="prof_name_new" value="" class="prof_name"></td>
		<td class="config_prof_style" style=" background:#ffe0f0">

			<select id="prof_set_clr" name="prof_style_new" class="prof_option">
				<option value="1">一行</option>
				<option value="2">複数行</option>
			</select>

		</td>
		<td class="config_prof_style" style=" background:#ffe0f0">
			<button id="prof_set" type="button" class="prof_btn set_btn">追加</button>
		</td>
	</form>
	</tr>
</table>


<div class="config_title">オプション</div>
<div id="sort_option_table">
<?foreach($c_main_dat as $a1 => $a2){?>
	<table id="tbl<?=$a1?>" class="option_table">
		<tr>
			<td class="option_handle handle"></td>
			<td class="option_top">
			<input id="ttl_<?=$a1?>" type="text" name="" value="<?=$a2["title"]?>" class="option_ttl">
			<span class="option_tag">未選択</span>
			<select id="sel_<?=$a1?>" class="option_select">
				<option value="0">非表示</option>
				<option value="1"<?if($a2["style"] == 1){?> selected="selected"<?}?>>表示</option>
			</select>
			<span id="ad_<?=$a1?>" class="option_add">＋項目追加</span>
			<span id="dl_<?=$a1?>" class="option_del">×オプション削除</span>
			</td>
		</tr>

		<tr>
			<td id="no_<?=$a1?>" class="option_flex" colspan="2">
				<?foreach($c_list_dat[$a1] as $b1 => $b2){?>
				<?$u++?>
				<div id="item_<?=$a1?>_<?=$b1?>" class="sel_flex no_<?=$a1?>">
					<span class="sel_move"></span>
					<input id="itm_<?=$a1?>_<?=$b1?>" type="text" name="sel[<?=$b1?>]" value="<?=$b2["list_title"]?>" class="sel_text">
					<input id="sel_del<?=$b1?>" type="checkbox" name="del[<?=$b1?>]" class="sel_ck" value="0">
					<label for="sel_del<?=$b1?>" class="sel_del">×</label>
					<input type="hidden" name="sort[<?=$b1?>]" value="<?=$u?>" class="sel_hidden">
				</div>
				<? } ?>
				<?$u=0?>
			</td>
		</tr>
	</table>
<? } ?>

	<table id="tblnew" class="option_table">
	<form id="option_new_set" action="" method="post">
		<input type="hidden" name="menu_post" value="config">
		<tr>
			<td style="background:#ffe0f0;text-align:center;font-weight:600;color:#900000; width:40px;">追加</td>
			<td class="option_top" style="background:#ffe0f0;color:#900000;">
			<input id="ttl_new" type="text" name="option_new_title" value="" class="option_ttl_new">
			<span class="option_tag">未選択</span>
			<select id="sel_new" name="option_new_select" class="option_select_new">
				<option value="0">非表示</option>
				<option value="1" selected="selected">表示</option>
			</select>
			<button id="option_set" type="button" class="prof_btn">追加</button>
			</td>
		</tr>
		</form>
	</table>
</div>

<div class="config_title">ブログカテゴリ</div>
<table class="config_sche">	
<thead>
	<tr>
		<td class="config_sche_top" style="width:30px">順番</td>
		<td class="config_sche_top" style="width:50px">タグ</td>
		<td class="config_sche_top" style="width:240px">名前</td>
		<td class="config_sche_top" style="width:120px"></td>
	</tr>
</thead>

<tbody id="blog_set_list">
<?$tmp_sort=0;?>
<?foreach($tag_dat["blog"] as $a1 => $a2){?>
<?$tmp_sort++;?>
	<tr id="tr_n_<?=$a1?>" class="tr bg<?=$a2["del"]?>">
		<td class="config_prof_sort"><input type="text" value="<?=$tmp_sort?>" class="prof_sort" disabled></td>
		<td class="config_prof_sort">
		<select id="tag_icon-<?=$a1?>" class="chg1 blog_select">
			<option value=""></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>

			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
			<option value="" <?if($a2["tag_icon"] == ""){?>selected="selected"<?}?>></option>
		</select>
		</td>
		<td class="config_prof_name"><input id="tag_name-<?=$a1?>" type="text" value="<?=$a2["tag_name"]?>" class="chg1 prof_name"></td>
		<td class="config_prof_style">
			<button type="button" class="prof_btn view_btn bg<?=$a2["del"]?>">非表示</button>
			<button type="button" class="prof_btn del_btn">削除</button>
		</td>0
	</tr>
<? } ?>
</tbody>
</table>

<table class="config_sche">
	<tr>
		<td style="width:30px; background:#ffe0f0;text-align:center;font-weight:600;color:#900000;">新</td>
		<td class="config_prof_sort" style="width:50px; background:#ffe0f0">
		<select id="blog_set_clr" class="chg1 blog_select">
			<option value=""></option>
			<option value=""></option>
			<option value=""></option>
			<option value=""></option>
			<option value=""></option>
			<option value=""></option>
			<option value=""></option>

			<option value=""></option>
			<option value=""></option>
			<option value=""></option>
			<option value=""></option>
			<option value=""></option>
			<option value=""></option>
			<option value=""></option>
			<option value=""></option>
			<option value=""></option>
		</select>
		</td>
		<td class="config_prof_name" style=" background:#ffe0f0"><input id="blog_set_name" type="text" value="" class="prof_name"></td>
		<td class="config_prof_style" style=" background:#ffe0f0">
			<button id="blog_set" type="button" class="prof_btn set_btn">追加</button>
		</td>
	</tr>
</table>


<div class="config_title">キャストグループ</div>
<table class="config_sche">	
<thead>
	<tr>
		<td class="config_sche_top" style="width:30px">順番</td>
		<td class="config_sche_top" style="width:240px">名前</td>
		<td class="config_sche_top" style="width:120px"></td>
	</tr>
</thead>

<tbody id="cast_group_set_list">
<?$tmp_sort=0;?>
<?foreach($tag_dat["cast_group"] as $a1 => $a2){?>
<?$tmp_sort++;?>
	<tr id="tr_n_<?=$a1?>" class="tr bg<?=$a2["del"]?>">
		<td class="config_prof_sort"><input type="text" value="<?=$tmp_sort?>" class="prof_sort" disabled></td>
		<td class="config_prof_name"><input id="tag_name-<?=$a1?>" type="text" value="<?=$a2["tag_name"]?>" class="chg1 prof_name"></td>
		<td class="config_prof_style">
			<button type="button" class="prof_btn view_btn bg<?=$a2["del"]?>">非表示</button>
			<button type="button" class="prof_btn del_btn">削除</button>
		</td>
	</tr>
<? } ?>
</tbody>
</table>
<table class="config_sche">
	<tr>
		<td style="width:30px; background:#ffe0f0;text-align:center;font-weight:600;color:#900000;">新</td>
		<td class="config_prof_name" style=" background:#ffe0f0"><input id="cast_group_set_name" type="text" value="" class="prof_name"></td>
		<td class="config_prof_style" style=" background:#ffe0f0">
		<button id="cast_group_set" type="button" class="prof_btn set_btn">追加</button>
		</td>
	</tr>
</table>

<div class="config_title">お知らせカテゴリ</div>
<table class="config_sche">	
<thead>
	<tr>
		<td class="config_sche_top" style="width:30px">順番</td>
		<td class="config_sche_top" style="width:240px">名前</td>
		<td class="config_sche_top" style="width:120px"></td>
	</tr>
</thead>
<tbody id="notice_category_set_list">
<?$tmp_sort=0;?>
<?foreach($tag_dat["notice_category"] as $a1 => $a2){?>
<?$tmp_sort++;?>
	<tr id="tr_n_<?=$a1?>" class="tr bg<?=$a2["del"]?>">
		<td class="config_prof_sort"><input type="text" value="<?=$tmp_sort?>" class="prof_sort" disabled></td>
		<td class="config_prof_name"><input id="tag_name-<?=$a1?>" type="text" value="<?=$a2["tag_name"]?>" class="chg1 prof_name"></td>
		<td class="config_prof_style">
			<button type="button" class="prof_btn view_btn bg<?=$a2["del"]?>">非表示</button>
			<button type="button" class="prof_btn del_btn">削除</button>
		</td>
	</tr>
<? } ?>
</tbody>
</table>


<table class="config_sche">
	<tr>
		<td style="width:30px; background:#ffe0f0;text-align:center;font-weight:600;color:#900000;">新</td>
		<td class="config_prof_name" style=" background:#ffe0f0"><input id="notice_category_set_name" type="text" value="" class="prof_name"></td>
		<td class="config_prof_style" style=" background:#ffe0f0">
			<button id="notice_category_set" type="button" class="prof_btn set_btn">追加</button>
		</td>
	</tr>
</table>

<div class="config_title">基本設定</div>
<table class="config_sche">
	<tr class="tr">
		<td class="config_prof_name">店舗名</td>
		<td class="config_prof_style"><input id="store_name" type="text" value="<?=$admin_config["store_name"]?>" class="chg0 prof_name w400"></td>
	</tr>

	<tr class="tr">
		<td class="config_prof_name">メインURL</td>
		<td class="config_prof_style"><input id="main_url" type="text" value="<?=$admin_config["main_url"]?>" class="chg0 prof_name w400"></td>
	</tr>

	<tr class="tr">
		<td class="config_prof_name">メールアドレス</td>
		<td class="config_prof_style"><input id="main_mail" type="text" value="<?=$admin_config["main_mail"]?>" class="chg0 prof_name w400"></td>
	</tr>

	<tr class="tr">
		<td class="config_prof_name">電話番号</td>
		<td class="config_prof_style"><input id="main_tel" type="text" value="<?=$admin_config["main_tel"]?>" class="chg0 prof_name w400"></td>
	</tr>
</table>
<div style="height:20px">　</div>
</div>
</div>
