<?

$s=0;
$pg		=$_POST["pg"];
if($pg<1) $pg=1;

$pg_st	=($pg-1)*20;
$pg_ed	=$pg_st+20;

$st_ck=$_POST["st_ck"];
if($st_ck){
	$st=$st_ck." 00:00:00";
	$app.=" AND view_date>='{$st}'";
}

$ed_ck=$_POST["ed_ck"];
if($ed_ck){
	$ed=date("Y-m-d 00:00:00",strtotime($ed_ck)+86400);
	$app.=" AND view_date<='{$ed}'";
}

$cast_ck=$_POST["cast_ck"];
if($cast_ck){
	$app.=" AND cast='{$cast_ck}'";
}

$log_ck=$_POST["log_ck"];
if($log_ck){
	$app.=" AND log LIKE '%{$log_ck}%'";
}

if(!$post_filter) $post_filter="view_date";
if(!$post_sort) $post_sort="DESC";

$sql	 ="SELECT P.id,P.date, P.view_date, P.title, P.log, P.cast, P.tag, P.img, P.img_del, P.status, P.prm , C.genji,C.cast_status FROM ".TABLE_KEY."_posts AS P";
$sql	.=" LEFT JOIN ".TABLE_KEY."_cast AS C ON P.cast=C.id";
$sql	.=" WHERE P.status<4 ";
$sql	.=" AND P.log <>''";
$sql	.=" AND P.title <>''";
$sql	.=$app;
$sql	.=" ORDER BY {$post_filter} {$post_sort}";
$sql	.=" LIMIT {$pg_st}, 20";

echo $sql;

if($result = mysqli_query($mysqli,$sql)){
	while($res = mysqli_fetch_assoc($result)){

		if($res["status"] ==0 && $res["view_date"] > $now){
			$res["status"]=1;
		}

		if (file_exists("../img/profile/{$res["cast"]}/{$res["img"]}_s.webp") && $admin_config["webp_select"] == 1) {
			$res["img_link"]="../img/profile/{$res["cast"]}/{$res["img"]}_s.webp?t={$row["prm"]}";

		}elseif (file_exists("../img/profile/{$res["cast"]}/{$res["img"]}_s.png")) {
			$res["img_link"]="../img/profile/{$res["cast"]}/{$res["img"]}_s.png?t={$row["prm"]}";			

		}else{
			$res["img_link"]="../img/blog_no_image.png";
		}

		if($res["cast"] == 0){
			$res["img_cast"]="../img/staff_image.png";
			$res["genji"]="STAFF";

		}else{
			if(file_exists("../img/profile/{$res["cast"]}/0_s.jpg")){
				$res["img_cast"]="../img/profile/{$res["cast"]}/0_s.jpg";
			}else{
				$res["img_cast"]="../img/cast_no_image.jpg";
			}
		}
		$res["view_date"]	=substr($res["view_date"],0,10)."T".substr($res["view_date"],11,5);
		$dat[$res["id"]]=$res;
	}
}


$sql	 ="SELECT tag_name,tag_icon,id FROM ".TABLE_KEY."_tag";
$sql	.=" WHERE tag_group='blog'";
$sql	.=" AND del=0";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[$row["id"]]=$row["tag_name"];
	}
}

$sql	 ="SELECT COUNT(id) AS cnt FROM ".TABLE_KEY."_posts";
$sql	.=" WHERE status<4";
$sql	.= $app;

$result = mysqli_query($mysqli,$sql);
$res	= mysqli_fetch_assoc($result);

$res_max=$res["cnt"];
$pg_max	=ceil($res["cnt"]/20);
if($pg_ed>$res_max){
	$pg_ed = $res_max;
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
<script>
$(function(){ 
	$('.event_set_btn').on('click',function(){

		Tmp	=$(this).attr('id').substr(0,3);
		Tmp2=$(this).attr('id').substr(3);

		if(Tmp == 'chg'){
			if (!confirm('変更します。よろしいですか')) {
				return false;
			}else{

				$.post({
					url:"./post/blog_chg.php",
					data:{
						'id'			:Tmp2,
						'date'			:$('#blog_date'+Tmp2).val(),
						'status'		:$('#blog_status'+Tmp2).val(),
						'title'			:$('#blog_title'+Tmp2).val(),
						'tag'			:$('#blog_tag'+Tmp2).val(),
						'log'			:$('#blog_log'+Tmp2).val(),
						'img_del'		:$('#img_del'+Tmp2).val(),
						'img_url'		:$('#img_url'+Tmp2).val(),
					},

				}).done(function(data, textStatus, jqXHR){
					console.log(data);

				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log(textStatus);
					console.log(errorThrown);
				});
			}

		}else if(Tmp == 'del'){
			if (!confirm('削除します。よろしいですか')) {
				return false;
			}else{
				$('#tbl'+Tmp2).fadeOut(400);

				$.post({
					url:"./post/blog_chg.php",
					data:{
						'id'			:Tmp2,
						'del'			:4,
					},

				}).done(function(data, textStatus, jqXHR){
					console.log(data);

				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log(textStatus);
					console.log(errorThrown);
				});
				return false;
			}

		}else if(Tmp == 'cov'){
			Tmp3=$('#st'+Tmp2).val();
			if(Tmp3 == 3){
				$('#st'+Tmp2).val('0');

			}else{
				$('#st'+Tmp2).val('3');
			}
			$('#f'+Tmp2).submit();
			return false;

		}else if(Tmp == 'ich'){


		}else if(Tmp == 'idl'){
			$('#img_hide'+Tmp2).hide();
			if($('#img_del'+Tmp2).val() == 2){
				$('#img_del'+Tmp2).val('0');
				$('#img_src'+Tmp2).attr('src',$('#img_url'+Tmp2).val());

			}else{
				$('#img_del'+Tmp2).val('2');
				$('#img_src'+Tmp2).attr('src','../img/blog_no_image.png');
			}

		}else if(Tmp == 'ihd'){
			if($('#img_del'+Tmp2).val() == 1){
				$('#img_del'+Tmp2).val('0');
				$('#img_hide'+Tmp2).hide();

			}else if($('#img_del'+Tmp2).val() == 0){
				$('#img_del'+Tmp2).val('1');
				$('#img_hide'+Tmp2).show();
			}
		}
	});
});
</script>
<header class="head">
<form id="main_form" method="post">
	<input id="pg" type="hidden" name="pg">
	<input type="hidden" name="send" value="1">
	<input type="hidden" name="menu_post" value="blog">

	<span class="event_tag" style="margin:10px 0">開始</span>
	<input type="date" name="st_ck" class="w140" value="<?=$st_ck?>" style="margin:10px 5px 10px 0" autocomplete="off">
	
	<span class="event_tag" style="margin:10px 0">終了</span>
	<input type="date" name="ed_ck" class="w140" value="<?=$ed_ck?>" style="margin:10px 5px 10px 0" autocomplete="off">

	<span class="event_tag" style="margin:10px 0">CAST</span>
	<input type="text" name="cast_ck" class="w80" value="<?=$cast_ck?>" style="margin:10px 5px 10px 0" autocomplete="off">

	<span class="event_tag" style="margin:10px 0">検索</span>
	<input type="text" name="log_ck" class="w140" value="<?=$log_ck?>" style="margin:10px 5px 10px 0" autocomplete="off">
	<button  type="submit" class="event_reg_btn">検索</button>
</form>

<div class="pager">
<div id="pp<?=$pg_p?>" class="page_p pg_off">前へ</div>
<?for($s=$pager_st;$s<$pager_ed+1;$s++){?>
<?if($pg == $s){?>
<div class="page pg_on"><?=$s?></div>
<?}else{?>
<div id="pg<?=$s?>" class="page pg_off"><?=$s?></div>
<?}?>
<?}?>
<div id="nn<?=$pg_n?>" class="page_n pg_off">次へ</div>
</div>
</header>
<div class="top_page">(<?=$pg_st+1?> - <?=$pg_ed?> / <?=$res_max?>件)</div>
<div class="wrap">
<div class="main_1">
	<?foreach($dat as $a1 => $a2){?>
		<table id="tbl<?=$a1?>" class="blog_table" style="border:1px solid #303030;margin:5px;background:#fafafa">
			<tr>
				<td style="width:60px;" rowspan="2">
					<img src="<?=$a2["img_cast"]?>" style="width:60px;"><br>
				</td>

				<td style="height:40px;">
					<span class="event_tag2" style="vertical-align:top"><?=$a2["cast"]?>　<?=$a2["genji"]?></span>
					<span class="event_tag" style="vertical-align:top">公開日</span>
					<input id="blog_date<?=$a1?>" type="datetime-local" name="view_date" class="w200" value="<?=$a2["view_date"]?>" style="vertical-align:top" autocomplete="off">
					<select id="blog_status<?=$a1?>" class="w120 news_box" style="vertical-align:top">

<?if($a2["status"]==1){?>
					<option value="0">予約</option>
<?}else{?>
					<option value="0">通常</option>
<? } ?>
					<option value="2" <?if($a2["status"]==2){?> selected="selected"<?}?>>非公開</option>
					<option value="3" <?if($a2["status"]==3){?> selected="selected"<?}?>>非表示</option>
					</select>
					<button id="chg<?=$a1?>" class="event_set_btn" style="vertical-align:top">更新</button>
					<button id="del<?=$a1?>" class="event_set_btn" style="vertical-align:top">削除</button>
				</td>

				<td class="blog_td_img" rowspan="3">
					<img src="<?=$a2["img_link"]?>" id="img_src<?=$a1?>" style="width:200px;height:200px;margin:55px;border:1px solid #303030"><br>
					<div id="img_hide<?=$a1?>" class="img_hide" <?if($a2["img_del"] != 1){?>style="display:none"<?}?>>非表示</div>
					<!--button id="ich<?=$a1?>" class="event_set_btn">変更</button-->
					<button id="ihd<?=$a1?>" class="event_set_btn" <?if($a2["img_link"] == "../img/blog_no_image.png"){?> disabled<?}?>>非表示</button>
					<button id="idl<?=$a1?>" class="event_set_btn" <?if($a2["img_link"] == "../img/blog_no_image.png"){?> disabled<?}?>>削除</button><br>
					<input id="img_del<?=$a1?>" type="hidden" value="<?=$a2["img_del"]+0?>">
					<input id="img_url<?=$a1?>" type="hidden" value="<?=$a2["img_link"]?>">
				</td>
			</tr>

			<tr>
				<td style="height:40px;">
					<span class="event_tag1"><?=$a1?></span>
					<span class="event_tag">TITLE</span><input id="blog_title<?=$a1?>" type="text" name="event_title" style="width:360px;padding-left:5px;" value="<?=$a2["title"]?>">
					<span class="event_tag">タグ</span>
					<select id="blog_tag<?=$a1?>" class="w160 news_box">
					<?foreach($tag as $b1 => $b2){?>
					<option value="<?=$b1?>"><?=$b2?></option>
					<?}?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<textarea id="blog_log<?=$a1?>" name="event_title" class="news_title" style="width:760px;height:280px;"><?=$a2["log"]?></textarea>
				</td>
			</tr>
		</table>
	<? } ?>
</div>
</div>
