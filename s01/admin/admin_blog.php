<?
$fil_st		=$_POST["fil_st"];
$fil_ed		=$_POST["fil_ed"];

$fil_key	=$_POST["fil_key"];
$fil_cast	=$_POST["fil_cast"];
$fil_tag	=$_POST["fil_tag"];

$post_filter=$_POST["post_filter"];
$post_sort	=$_POST["post_sort"];


if($fil_st){
	$app.="AND view_date>='{$fil_st}'";
}

if($fil_ed){
	$app.="AND view_date>='{$fil_ed}'";
}

if($fil_key){
	$app.="AND log LIKE '%{$fil_key}%'";
}

if($fil_cast){
	$app.="AND P.cast ='{$fil_cast}'";
}

if($fil_tag){
	$app.="AND P.tag ='{$fil_tag}'";
}

if(!$post_filter) $post_filter="view_date";
if(!$post_sort) $post_sort="DESC";

$sql	 ="SELECT P.id,P.blog_id,P.date, P.view_date, P.title, P.log, P.cast, P.tag, P.img, P.img_del, P.status, C.genji,C.cast_status FROM wp00000_posts AS P";
$sql	.=" LEFT JOIN wp00000_cast AS C ON P.cast=C.id";
$sql	.=" WHERE P.status<4 ";
$sql	.=" AND P.log <>''";
$sql	.=" AND P.title <>''";
$sql	.=$app;
$sql	.=" ORDER BY {$post_filter} {$post_sort}";
$sql	.=" LIMIT 20";

if($result = mysqli_query($mysqli,$sql)){
	while($res = mysqli_fetch_assoc($result)){

		if($res["status"] ==0 && $res["view_date"] > $now){
			$res["status"]=1;
		}

		if($res["img"] && $res["img_del"]<2){
			$res["img_link"]="../img/profile/{$res["cast"]}/{$res["img"]}.png";

		}else{
			$res["img_link"]="../img/blog_no_image.png";
		}

		$res["img_cast"]="../img/profile/{$res["cast"]}/0_s.jpg";
		$res["view_date"]	=substr($res["view_date"],0,10)."T".substr($res["view_date"],11,5);
		$dat[$res["id"]]=$res;
	}
}

$sql	 ="SELECT tag_name,tag_icon,id FROM wp00000_tag";
$sql	.=" WHERE tag_group='blog'";
$sql	.=" AND del=0";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[$row["id"]]=$row["tag_name"];
	}
}

?>
<style>
</style>
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
						'img_code'		:$('#img_code'+Tmp2).val(),
						'img_del'		:$('#img_del'+Tmp2).val(),
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
				$('#tbl'+Tmp2).hide();

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
</header>
<div class="wrap">
<div class="main_1">
	<?foreach($dat as $a1 => $a2){?>

		<table id="tbl<?=$a1?>" class="blog_table" style="border:1px solid #303030;margin:5px;background:#fafafa">
			<tr>
				<td style="width:60px;" rowspan="2">
					<img src="<?=$a2["img_cast"]?>" style="width:60px;"><br>
				</td>

				<td style="height:40px;">
					<span class="event_tag2"><?=$a2["cast"]?>　<?=$a2["genji"]?></span>
					<span class="event_tag">公開日</span>
					<input id="blog_date<?=$a1?>" type="datetime-local" name="view_date" class="w200" value="<?=$a2["view_date"]?>" autocomplete="off">
					<select id="blog_status<?=$a1?>" class="w140 news_box">

<?if($a2["status"]==1){?>
					<option value="0">予約</option>
<?}else{?>
					<option value="0">通常</option>
<? } ?>
					<option value="2" <?if($a2["status"]==2){?> selected="selected"<?}?>>非公開</option>
					<option value="3" <?if($a2["status"]==3){?> selected="selected"<?}?>>非表示</option>
					</select>
					<button id="chg<?=$a1?>" class="event_set_btn">更新</button>
					<button id="del<?=$a1?>" class="event_set_btn">削除</button>
				</td>

				<td class="blog_td_img" rowspan="3">
					<img src="<?=$a2["img_link"]?>" id="img_src<?=$a1?>" style="width:300px;height:300px;margin:5px;border:1px solid #303030"><br>
					<div id="img_hide<?=$a1?>" class="img_hide" <?if($a2["img_del"] != 1){?>style="display:none"<?}?>>非表示</div>
					<!--button id="ich<?=$a1?>" class="event_set_btn">変更</button-->
					<button id="ihd<?=$a1?>" class="event_set_btn">非表示</button>
					<button id="idl<?=$a1?>" class="event_set_btn">削除</button><br>
					<input id="img_del<?=$a1?>" type="hidden" value="<?=$a2["img_del"]?>">
					<input id="img_url<?=$a1?>" type="hidden" value="<?=$a2["img_link"]?>">
				</td>
			</tr>

			<tr>
				<td style="height:40px;">
					<span class="event_tag1"><?=$a1?></span>
					<span class="event_tag">TITLE</span><input id="blog_title<?=$a1?>" type="text" name="event_title" style="width:360px;padding-left:5px;" value="<?=$a2["title"]?>">
					<span class="event_tag">タグ</span>
					<select id="blog_tag<?=$a1?>" class="w140 news_box">
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

<footer class="foot"></footer> 
