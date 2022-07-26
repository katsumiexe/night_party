<?
$tag["cast_group"][0]		="全て";

$s=0;
$pg		=$_POST["pg"];
if($pg<1) $pg=1;

$pg_st	=($pg-1)*20;
$pg_ed	=$pg_st+10;

$pg = $_POST["pg"];
if( $pg + 0 == 0 ) $pg = 1;

$pg_st	=($pg-1) * 10;
$pg_ed	=$pg_st + 10;

$notice_month	=$_POST["notice_month"];
if(!$notice_month) $notice_month=date("Y-m");

//■キャストリスト----
$sql	 ="SELECT * FROM ".TABLE_KEY."_staff AS S ";
$sql	.=" LEFT JOIN ".TABLE_KEY."_cast AS C ON S.staff_id=C.id";
$sql	.=" WHERE S.del=0";
$sql	.=" ORDER BY S.sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($row["genji"]){
			$row["user_name"]=$row["genji"];

		}else{
			$row["user_name"]=$row["name"];
		}

		$gp[$row["group"]][$row["staff_id"]]=1;
		$staff_dat[]=$row;
	}
}

//■グループ名・カテゴリ名----
$sql	 ="SELECT id, tag_group, tag_name, sort FROM ".TABLE_KEY."_tag";
$sql	.=" WHERE del=0";
$sql	.=" AND( tag_group='cast_group' OR tag_group='notice_category')";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[$row["tag_group"]][$row["id"]]=$row["tag_name"];
	}
}

if($_POST["notice_set"]){
	$display_date		=$_POST["display_date"];
	$notice_category	=$_POST["notice_category"];
	$notice_title		=$_POST["notice_title"];
	$notice_contents	=$_POST["notice_contents"];
	$gp_check			=$_POST["gp_check"];
	$notice_log_id		=$_POST["notice_log_id"];

	foreach($gp_check as $a1 => $a2){
		if($a1 >0 && $a2>0){
			$cast_group.=$a1.",";
			$n_cnt++;
		}
	}

	$display_date		=substr($display_date,0,10)." ".substr($display_date,11,5).":00";
	$cast_group=substr($cast_group,0,-1);

	if($notice_log_id){
		$sql	 ="UPDATE ".TABLE_KEY."_notice SET";
		$sql	 .="`date`='{$display_date}',";
		$sql	 .="`title`='{$notice_title}',";
		$sql	 .="`log`='{$notice_contents}',";
		$sql	 .="`category`='{$notice_category}',";
		$sql	 .="`cast_group`='{$cast_group}'";
		$sql	 .=" WHERE id='{$notice_log_id}'";
		mysqli_query($mysqli,$sql);

	}else{
		$sql	 ="INSERT INTO ".TABLE_KEY."_notice(`date`,`title`,`log`,`category`,`cast_group`,`del`)";
		$sql	 .=" VALUES('{$display_date}','{$notice_title}','{$notice_contents}','{$notice_category}','{$cast_group}','0')";
		mysqli_query($mysqli,$sql);
		$tmp_auto=mysqli_insert_id($mysqli);

		foreach($gp_check as $a1 => $a2){
			if($a1 >0 && $a2>0){
				foreach($gp[$a1] as $b1 => $b2){
					$app_ck.="('{$tmp_auto}','{$b1}','1'),";
				}
			}
		}
		$app_ck=substr($app_ck,0,-1);
		
		$sql	 ="INSERT INTO ".TABLE_KEY."_notice_ck(`notice_id`,`cast_id`,`status`) VALUES ";
		$sql	 .=$app_ck;
		mysqli_query($mysqli,$sql);
	}
}

$sql	 ="SELECT * FROM ".TABLE_KEY."_notice";
$sql	.=" WHERE del=0";
$sql	.=" AND date LIKE '{$notice_month}%'";
$sql	.=" ORDER BY `date` DESC, id DESC";

$c=0;
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if($c >= $pg_st && $pg_ed > $c){
			$s=explode(",",$row["cast_group"]);

			$row["group"]="";
			for($n=0;$n<count($s);$n++){
				$row["group"].="<span class=\"group_item\">{$tag["cast_group"][$s[$n]]}</span>/";
				$row["gp_val"].=$s[$n]."|";
			}
			$row["group"]=substr($row["group"],0,-1);
			$row["gp_val"]=substr($row["gp_val"],0,-1);

			$row["log"]=str_replace("\r\n","<br>",$row["log"]);
			$row["log"]=str_replace("\r","<br>",$row["log"]);
			$row["log"]=str_replace("\n","<br>",$row["log"]);
			$row["date_val"]=substr($row["date"],0,10)."T".substr($row["date"],11,18);

			$row["date"]=str_replace("-",".",substr($row["date"],0,16));

			$sql	 ="SELECT id, genji, cast_group, K.status FROM ".TABLE_KEY."_notice_ck AS K";
			$sql	.=" LEFT JOIN  ".TABLE_KEY."_cast AS C ON K.cast_id=C.id";
			$sql	.=" WHERE C.del=0";
			$sql	.=" AND notice_id={$row["id"]}";
			if($result2 = mysqli_query($mysqli,$sql)){
				while($row2 = mysqli_fetch_assoc($result2)){
					$dat2[$row["id"]][]=$row2;
				}
			}
			$dat[]=$row;
			$count_dat++;
		}
		$c++;
	}
}

/*
$pg_max=ceil($c/10);
$ck_cnt=count($tag["cast_group"])-1;

*/


//$res_max=$res["cnt"];



$pg_max	=ceil($c/10);
if($pg_ed>$c){
	$pg_ed = $c;
}

if($pg_max<8){
	$pager_st=1;
	$pager_ed=$pg_max;

}elseif($pg<5){
	$pager_st=1;
	$pager_ed=7;

}elseif($pg_max-$pg<3){
	$pager_st=$pg-3;
	$pager_ed=$pg_max;

}else{
	$pager_st=$pg-3;
	$pager_ed=$pg+3;
}

if($pg>1){
	$pg_p=$pg-1;
}

if($pg<$pg_max){
	$pg_n=$pg+1;
}
?>

<style>
<!--
.sel_contents{
	display			:inline-block;
	background		:#bbbbbb;
	width			:150px;
	height			:30px;
	line-height		:30px;
	margin			:5px;
	border-radius	:5px;
	color			:#fafafa;
	font-size		:18px;
	font-weight		:600;
	text-align		:center;
}

input[type=radio]:checked + label{
	background		:linear-gradient(#ff0000,#d00000);
}

.cate_title{
	display			:inline-block;
	width			:170px;
	height			:30px;
	line-height		:30px;
	font-size		:15px;
	padding-left	:5px;
	text-align		:left;
	margin-left		:5px;
	color			:#fafafa;
	font-weight		:600;
}

.cate_ul{
	width			:200px;
	margin			:10px 5px;
	border-radius	:5px;
	box-shadow		:3px 3px 3px rgba(30,30,30,0.5);
	padding			:5px;
}

.cate_li{
	display			:inline-block;
	width			:185px;
	height			:30px;
	line-height		:30px;
	margin			:0 0 1px 10px;
	padding-left	:5px;
	font-size		:15px;
	color			:#ffffff;	
}

.c_pink{
	background:#ff7090;
}
.c_pink2{
	background:#e0e0e0;
}
.c_pink2:hover{
	background:#ff7898;
}

.done1{
	background:#ffd0f0;
}
.done2{
	background:#ffa0c0;
}

.c_blue{
	background:#4068e0;
}
.c_blue2{
	background:#80a8e0;
}

.c_blue2:hover{
	background:#6088e0;
}


.c_green{
	background:#00a010;
}

.c_green2{
	background:#30e040;
}

.c_green2:hover{
	background:#00b020;
}

.notice_table{
	margin			:5px auto;
	background		:#fafafa;
	border			:1px solid #303030;
}

.notice_list{
	border			:1px solid #303030;
	color			:#202020;
	height			:20px;
	line-height		:20px;
	padding-left	:5px;
	font-size		:14px;
}

.notice_title_in{
	display			:inline-block;
	height			:20px;
	width			:294px;
	overflow		:hidden;
}
.notice_category_in{
	display			:inline-block;
	height			:20px;
	width			:94px;
	overflow		:hidden;
}

.notice_txt{
	resize			:none;
	font-size		:15px;
	line-height		:20px;
	padding			:5px;
	border			:1px solid #303030;
	margin			:5px;
	width			:840px;
	height			:300px;
	background		:#fafafa;
}

.notice_hidden{
	display:none;
}

.tr_list{
	cursor:pointer;
}

.tr_list:hover{
	background:#f0e8d0;
}

.notice_log{
	margin			:5px auto;
	width			:840px;
	height			:400px;
	padding			:10px;
	font-size		:14px;
	line-height		:24px;
	border			:1px solid #303030;
	border-radius	:5px;
	background		:#fafafa;
	overflow-y		:scroll;
	display			:none;
}

.group_box{
	font-size		:0;
	display			:flex;
	flex-wrap		:wrap;
	background		:#eeeeee;
	margin			:5px auto;
	padding			:5px;
	width			:830px;
}


.gp_check{
	display			:none;
}
.notice_regist{
	background		:#e0e0e0;
	width			:850px;
	margin			:5px auto;
	padding			:5px;
	border			:1px solid #303030;
	display			:none;
}

.notice_pager{
	display			:inline-block;
	height			:20px;
	line-height		:20px;
	width			:20px;
	margin			:5px;
	padding			:5px;
	text-align		:center;
	border			:1px solid #303030;
	cursor			:pointer;
}

.p_check_btn{
	display			:inline-block;
	font-size		:15px;
	padding			:5px 10px;
	margin			:2px;
	background		:#c0c0c0;
	text-align		:left;
	width			:82px;
	border-radius	:5px;
	color			:#fafafa;
	font-weight		:600;
	cursor			:pointer;
}

.gp_check:checked + label{
	background		:#d00000;
}

#p_check0{
	width			:60px;
	background		:#c0c0ff;
}

#gp_check0			:checked + label{
	background		:#0000d0;
}

#notice_log_del,#notice_log_chg{
	display:none;
}
-->
</style>
<script>
$(function(){ 
	var Cnt=0;

	$('#notice_new').on('click',function(){ 
		$('.notice_log').slideUp(200);
		$('#notice_log_del,#notice_log_chg').hide();

		if($(this).hasClass('c1')){
			$(this).removeClass('c1')
			$('.notice_regist').slideUp(200);

		}else{
			$(this).addClass('c1')
			$('.notice_regist').slideDown(200);
			$('#notice_log_id').val("");
		}
	});

	$('#notice_log_del').on('click',function(){ 
		if (!confirm('削除します。よろしいですか')) {
			return false;
		}else{
			TmpId=$('#notice_log_id').val();
			$.ajax({
				url:'./post/notice_del.php',
				type: 'post',
				data:{
					'id':TmpId,
				},
			}).done(function(data, textStatus, jqXHR){
				$('.notice_log').html("").slideUp(200);
				$('#tr_list'+TmpId).hide();


			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});

	$('#notice_log_chg').on('click',function(){ 
		$('.gp_check').prop('checked',false);
		var TmpId=$('#notice_log_id').val();
		$('#notice_log_del,#notice_log_chg').hide();
		$('.notice_log').html("").slideUp(200);
		$('.notice_regist').slideDown(200);

		$('#notice_reg_date').val($('#tr_list'+TmpId).find('.date_val').val());
		$('#notice_reg_title').val($('#tr_list'+TmpId).find('.notice_title_in').html());
		$('#notice_reg_cate').val($('#tr_list'+TmpId).find('.cate_val').val());
		$('#notice_reg_text').val($('#tr_list'+TmpId).children('.notice_hidden').html().replace(/<br>/g,'\n'));

		TmpGp=$('#tr_list'+TmpId).find('.gp_val').val().split('|');
		$.each(TmpGp, function(index, value) {
			$('#gp_check' + value).prop('checked',true);
		});

	});

	$('.tr_list').on('click',function(){ 
		var TmpId=$(this).attr('id').replace('tr_list','');
		var Tmp=$(this).children('.notice_hidden').html();
		$('.notice_log').html(Tmp).slideDown(200);
		$('#notice_log_del,#notice_log_chg').show();
		$('.notice_regist').slideUp(200);
		$('#notice_log_id').val(TmpId);

		$('.c_pink2').removeClass('done1 done2');
		$.ajax({
			url:'./post/notice_read.php',
			type: 'post',
			data:{
				'id':TmpId,
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$.each(data, function(index, value) {
				$('#m' + index).addClass('done' + value);
			});

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#gp_check0').on('change',function(){ 
		if($(this).prop('checked')==true){
			$('.gp_check').prop('checked', true);

		}else{
			$('.gp_check').prop('checked', false);
		}
	});

	$('#sel_date, #sel_category, #sel_group').on('change',function(){ 
		$.post({
			url:"./post/notice_date_chg.php",
			data:{
				'month'		:$('#sel_date').val(),
				'category'	:$('#sel_category').val(),
				'group'		:$('#sel_group').val(),
			},

		}).done(function(data, textStatus, jqXHR){
			$('.notice_table').html(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});
});
</script>
<header class="head">
<form id="main_form" method="post">
	<input id="pg" type="hidden" name="pg">
	<input type="hidden" name="send" value="1">
	<input type="hidden" name="menu_post" value="notice">
	<span class="notice_tag" style="margin:10px 0">日付</span><input id="sel_date" type="month" name="notice_month" value="<?=$notice_month?>" class="w140" style="margin:10px 10px 10px 0;height:30px; font-size:16px;">

<span class="notice_tag" style="margin:10px 0">カテゴリ</span>
<select id="sel_category" class="w140" style="margin:10px 10px 10px 0;height:30px; font-size:16px;">
	<option value="">全て</span>
	<?foreach($tag["notice_category"] as $a1 => $a2){?>
		<option value="<?=$a1?>"><?=$a2?></span>
	<?}?>
</select>

<span class="notice_tag" style="margin:10px 0">グループ</span>
<select id="sel_group" class="w140" style="margin:10px 10px 10px 0;height:30px; font-size:16px;">
	<?foreach($tag["cast_group"] as $a1 => $a2){?>
		<option value="<?=$a1?>"><?=$a2?></span>
	<?}?>
</select>
<button id="notice_new" type="button" class="event_reg_btn">新規</button>
</form>

<div class="pager">
<div id="pp<?=$pg_p?>" class="page_p pg_off">前へ</div>
<?for($s=$pager_st;$s<$pager_ed+8;$s++){?>
<?if($pg == $s){?>
<div class="page pg_on"><?=$s?></div>
<?}else{?>
<div id="pg<?=$s?>" class="page pg_off"><?=$s?></div>
<?}?>
<?}?>
<div id="nn<?=$pg_n?>" class="page_n pg_off">次へ</div>
</div>
</header>
<div class="top_page">(<?=$pg_st+1?> - <?=$pg_ed?> / <?=$c?>件)</div>
<div class="wrap">
	<div class="main_box">
		<table class="notice_table">
			<tr>
				<td class="td_top w150">日時</td>
				<td class="td_top w300">件名</td>
				<td class="td_top w100">カテゴリ</td>
				<td class="td_top w300">グループ</td>
			</tr>
			<?for($n=0;$n<$count_dat;$n++){?>
			<tr id="tr_list<?=$dat[$n]["id"]?>" class="tr_list">
				<td class="notice_list"><?=$dat[$n]["date"]?></td>
				<td class="notice_list"><div class="notice_title_in"><?=$dat[$n]["title"]?></div></td>
				<td class="notice_list"><div class="notice_category_in"><?=$tag["notice_category"][$dat[$n]["category"]]?></td>
				<td class="notice_list"><?=$dat[$n]["group"]?></td>
				<td class="notice_hidden"><?=$dat[$n]["log"]?></td>

				<input type="hidden" value="<?=$dat[$n]["gp_val"]?>" class="gp_val">
				<input type="hidden" value="<?=$dat[$n]["category"]?>" class="cate_val">
				<input type="hidden" value="<?=$dat[$n]["date_val"]?>" class="date_val">
			</tr>
			<?}?>
		</table>

		<div class="notice_regist">
			<form action="./index.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="menu_post" value="notice">
				<input type="hidden" name="notice_set" value="new">

				<span class="event_tag">日付</span>
				<input id="notice_reg_date" type="datetime-local" name="display_date" class="w200" value="<?=date("Y-m-d",$now_time)?>T<?=date("H:i",$now_time)?>" autocomplete="off">

				<span class="event_tag" style="width:70px;">カテゴリ</span>
				<select id="notice_reg_cate" name="notice_category" style="width:120px;">
					<?foreach($tag["notice_category"] as $a1 => $a2){?>
						<option value="<?=$a1?>"><?=$a2?></option>
					<? } ?>
				</select>
				<span class="event_tag">TITLE</span>
				<input id="notice_reg_title" type="text" name="notice_title" style="width:270px;" value="">
				<button type="submit" class="event_reg_btn">登録</button><br>

				<div class="group_box">
					<?foreach($tag["cast_group"] as $a1 => $a2){?>
						<input id="gp_check<?=$a1?>" type="checkbox" name="gp_check[<?=$a1?>]" class="gp_check" value="1" checked="checked">
						<label id="p_check<?=$a1?>" for="gp_check<?=$a1?>" class="p_check_btn"><?=$a2?></label>
					<?}?>
				</div>
				<textarea id="notice_reg_text" name="notice_contents" class="notice_txt"></textarea>
				<input id="notice_log_id" name="notice_log_id" type="hidden">
			</form>
		</div>

		<div class="notice_log"></div>
		<button id="notice_log_del" type="button" class="event_reg_btn c2">削除</button>　
		<button id="notice_log_chg" type="button" class="event_reg_btn c4">修正</button>

	</div>
	<div class="sub_box">
		<ul class="cate_ul c_pink">
			<li class="cate_title">スタッフ</li>
			<?foreach($staff_dat as $a1 => $a2){?>
			<li id="m<?=$a2["id"]?>" class="cate_li c_pink2"><?=$a2["user_name"]?></li><?}?>
		</ul>
	</div>
</div>
