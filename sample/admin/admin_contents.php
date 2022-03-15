<?
/*
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);
*/
/*
st
0 表示
1 表示前
2 非表示
3 削除
*/

/*-----event_status*/
$st[0]="表示中";
$st[1]="表示前";
$st[2]="注目";
$st[3]="非表示";
$st[4]="削除";
$cat[0]="none";
$cat[1]="event";
$cat[2]="page";
$cat[3]="person";
$cat[4]="outer";


$sel_id			=$_POST["sel_id"];
$post_id		=$_POST["post_id"];

if(!$post_id) $post_id="event";

if($post_id == "page") $post_id="system";

$event_set_id	=$_POST["event_set_id"];
$page_log		=$_POST["page_log"];
$post_id_set	=$_POST["post_id_set"];
$base_now=date("Y-m-d");

$pg		=$_POST["pg"];
if($pg<1) $pg=1;

$pg_st	=($pg-1)*20;
$pg_ed	=$pg_st+20;

if($event_set_id){
	$event_title	=$_POST["event_title"];
	$event_tag		=$_POST["event_tag"]+0;
	$display_date	=$_POST["display_date"];
	$event_date		=$_POST["event_date"];
	$event_status	=$_POST["event_status"]+0;
	$event_contents	=$_POST["event_contents"];
	$category		=$_POST["category"];
	$event_key		=$_POST["event_key"];
	$prm			=$_POST["prm"]+1;

	if(!$display_date) $display_date=date("Y-m-d");
	$display_date.=" 00:00:00";

	if(!$event_date) $event_date=date("Y-m-d");
	$event_date.=" 00:00:00";

	if($event_set_id == "new" || $event_set_id == "top"){
		$sql	 ="INSERT INTO wp00000_contents(`date`,`display_date`,`event_date`,`sort`,`page`,`category`,`title`,`contents`,`contents_key`,`tag`,`status`)";
		$sql	.=" VALUES('{$now}','{$display_date}','{$event_date}','0','{$post_id}','{$category}','{$event_title}','{$event_contents}','{$event_key}','{$event_tag}','{$event_status}')";
		mysqli_query($mysqli,$sql);
		$tmp_auto=mysqli_insert_id($mysqli);


		if($_POST["news_check"] == 1){
			$sql	 ="INSERT INTO wp00000_contents(`date`,`display_date`,`event_date`,`sort`,`page`,`category`,`title`,`contents_key`,`tag`,`status`)";
			$sql	.=" VALUES('{$now}','{$display_date}','{$event_date}','0','news','{$post_id}','{$event_title}','{$tmp_auto}','13','{$event_status}')";
			mysqli_query($mysqli,$sql);
			echo $sql;
		}

	}else{
		$sql	 ="UPDATE wp00000_contents SET";
		$sql	.=" `title`='{$event_title}',";
		$sql	.=" `event_date`='{$event_date}',";
		$sql	.=" `display_date`='{$display_date}',";
		$sql	.=" `tag`='{$event_tag}',";
		$sql	.=" `contents`='{$event_contents}',";
		$sql	.=" `category`='{$category}',";
		$sql	.=" `contents_key`='{$event_key}',";
		$sql	.=" status='{$event_status}',";
		$sql	.=" prm='{$prm}'";
		$sql	.=" WHERE `id`='{$event_set_id}'";
		mysqli_query($mysqli,$sql);
		$tmp_auto=$event_set_id;
	}

	if(isset($_FILES) && isset($_FILES['upd_img']) && is_uploaded_file($_FILES['upd_img']['tmp_name'])){
		$img_reg=getimagesize($_FILES['upd_img']['tmp_name']);
		if($img_reg["mime"] =="image/jpeg"){
			$img_tmp 		= imagecreatefromjpeg($_FILES['upd_img']['tmp_name']);
			$kk=".jpg";

		}elseif($img_reg["mime"] =="image/webp"){
			$img_tmp 		= imagecreatefromwebp($_FILES['upd_img']['tmp_name']);
			$kk=".webp";

		}elseif($img_reg["mime"] =="image/png"){
			$img_tmp 		= imagecreatefrompng($_FILES['upd_img']['tmp_name']);
			$kk=".png";

		}elseif($img_reg["mime"] =="image/gif"){
			$img_tmp 		= imagecreatefromgif($_FILES['upd_img']['tmp_name']);
			$kk=".gif";
		}

		$dst = imagecreatetruecolor(imagesx($img_tmp),imagesy($img_tmp));
		$dst2 = imagecopy($dst,$img_tmp,0,0,0,0,imagesx($img_tmp),imagesy($img_tmp));

		imagepalettetotruecolor($img_tmp);

		if($post_id=="recruit"){

			imagejpeg($img_tmp,"../img/page/contents/recruit_top.jpg",100);
			imagewebp($img_tmp,"../img/page/contents/recruit_top.webp");

			$sql	 ="UPDATE wp00000_contents SET";
			$sql	.=" prm='{$prm}'";
			$sql	.=" WHERE `page`='recruit'";
			$sql	.=" AND `category`='top'";
			mysqli_query($mysqli,$sql);

		}else{

			imagejpeg($img_tmp,"../img/page/{$post_id}/{$post_id}_{$tmp_auto}.jpg",100);
			imagepng($img_tmp,"../img/page/{$post_id}/{$post_id}_{$tmp_auto}.png");
			imagewebp($img_tmp,"../img/page/{$post_id}/{$post_id}_{$tmp_auto}.webp");
		}
	}

	if($post_id=="recruit" && $event_status=="4"){
		unlink("../img/page/contents/recruit_top.webp");
		unlink("../img/page/contents/recruit_top.jpg");
	}

}elseif($post_id_set){
	$post_id	=$_POST["post_id_set"];
	$page_log	=$_POST["page_log"];
	$page_title	=$_POST["page_title"];
	$page_key	=$_POST["page_key"];

	$sql	 ="INSERT INTO  wp00000_contents (`date`,`page`,`title`,`contents`,`contents_key`,`status`)";
	$sql	.=" VALUES('{$now}','{$post_id}','{$page_title}','{$page_log}','{$page_key}','0')";
	mysqli_query($mysqli,$sql);
}



if($post_id == "news"){
	$hdn=$_POST["hdn"]+0;

	$sql	 ="SELECT * FROM wp00000_contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status<4";
	if($hdn>0){
	$sql	.=" AND `tag`={$hdn}";
	}
	$sql	.=" ORDER BY event_date DESC, id DESC";
	$sql	.=" LIMIT {$pg_st}, 20";


	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){
			$res["event_date"]	=substr($res["event_date"],0,10);
			$res["display_date"]	=substr($res["display_date"],0,10);

			if($res["status"] ==0 && $res["display_date"] > date("Y-m-d")){
				$res["status"]=1;
			}
/*
			if($res["status"] == 2){
				$dat0[$res["id"]]=$res;

			}else{
				$dat1[$res["id"]]=$res;
			}
*/
				$dat[]=$res;
		}
	}

//	$dat = (array)$dat0 + (array)$dat1;


	$sql	 ="SELECT * FROM wp00000_tag";
	$sql	.=" WHERE tag_group='news'";
	$sql	.=" AND del=0";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$tag[$row["id"]]=$row;
		}
	}
}elseif($post_id == "event"){

	$sql	 ="SELECT * FROM wp00000_contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status<4";
	$sql	.=" ORDER BY sort ASC";
	$sql	.=" LIMIT {$pg_st}, 20";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){
			$res["display_date"]	=substr($res["display_date"],0,10);

			if (file_exists("../img/page/event/event_{$res["id"]}.webp")) {
				$res["img"]="../img/page/event/event_{$res["id"]}.webp?t={$res["prm"]}";			

			}elseif (file_exists("../img/page/event/event_{$res["id"]}.jpg")) {
				$res["img"]="../img/page/event/event_{$res["id"]}.jpg?t={$res["prm"]}";			

			}elseif (file_exists("../img/page/event/event_{$res["id"]}.png")) {
				$res["img"]="../img/page/event/event_{$res["id"]}.png?t={$res["prm"]}";			

			}elseif (file_exists("../img/page/event/event_{$res["id"]}.gif")) {
				$res["img"]="../img/page/event/event_{$res["id"]}.gif?t={$res["prm"]}";			

			}else{
				$res["img"]="../img/event_no_image.png";			
			}

			$dat[$res["id"]]=$res;
		}
	}

}elseif($post_id == "info"){
	$sql	 ="SELECT * FROM wp00000_contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status<4";
	$sql	.=" ORDER BY sort ASC";
	$sql	.=" LIMIT {$pg_st}, 20";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){
			$res["display_date"]	=substr($res["display_date"],0,10);

			if (file_exists("../img/page/info/info_{$res["id"]}.webp")) {
				$res["img"]="../img/page/info/info_{$res["id"]}.webp?t={$res["prm"]}";

			}elseif (file_exists("../img/page/info/info_{$res["id"]}.jpg")) {
				$res["img"]="../img/page/info/info_{$res["id"]}.jpg?t={$res["prm"]}";

			}elseif (file_exists("../img/page/info/info_{$res["id"]}.png")) {
				$res["img"]="../img/page/info/info_{$res["id"]}.png?t={$res["prm"]}";

			}else{
				$res["img"]="../img/info_no_image.png?t={$day_time}";			
			}

			$dat[$res["id"]]=$res;
		}
	}

}elseif($post_id == "recruit"){
	$sql	 ="SELECT * FROM wp00000_contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status<4";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){

			if($res["category"] == "top"){
				$recruit_title		=$res["title"];
				$recruit_contents	=$res["contents"];
				$recruit_id			=$res["id"];
				$prm				=$res["prm"];


			}elseif($res["category"] == "list"){
				$dat[$res["id"]]=$res;

			}else{
				$contact[$res["category"]]=$res["contents_key"];
			}
		}
	}

	if (file_exists("../img/page/contents/recruit_top.webp") && $admin_config["webp_select"] == 1) {
		$recruit_img="../img/page/contents/recruit_top.webp?t={$prm}";

	}elseif (file_exists("../img/page/contents/recruit_top.jpg")) {
		$recruit_img="../img/page/contents/recruit_top.jpg?t={$prm}";

	}elseif (file_exists("../img/page/contents/recruit_top.png")) {
		$recruit_img="../img/page/contents/recruit_top.png?t={$prm}";
	}else{
		$recruit_img="../img/event_no_image.png";			
	}
	if(!$recruit_id) $recruit_id="top";


	$sql	 ="SELECT * FROM wp00000_contact_table";
	$sql	.=" WHERE id='1'";
	$result = mysqli_query($mysqli,$sql);
	$row = mysqli_fetch_assoc($result);
	
	for($n=1;$n<10;$n++){
		$tmp="log_{$n}_type";
		$tname="log_{$n}_name";
		if($row[$tmp]){
			$contact_table[$n]["name"]=$row[$tname];
			$contact_table[$n]["type"]=substr($row[$tmp],0,1);
			$contact_table[$n]["check"]=substr($row[$tmp],1,1);
		}
	}


}else{
	$sql	 ="SELECT * FROM wp00000_contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status=0";
	$sql	.=" ORDER BY date DESC";
	$sql	.=" LIMIT 1";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){

			if($res["category"] == "top"){
				$recruit_title		=$res["title"];
				$recruit_contents	=$res["contents"];
				$recruit_id			=$res["id"];

			}elseif($res["category"] == "image"){
				$recruit_img	=$res["contents_key"];

			}else{
				$dat[$res["sort"]]=$res;
			}
		}
	}
	if(!$recruit_id) $recruit_id="top";
}


$sql	 ="SELECT COUNT(id) AS cnt FROM wp00000_contents";
$sql	.=" WHERE status<4";
$sql	.=" AND page='{$post_id}'";
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
<style>
<!--
.rec_bg0, .rec_bg{
	background	:#eeeeee;
	color		:#808080;
}

.rec_bg1{
	background	:#d00000;
	color		:#fafafa;
}

-->
</style>
<script>

$(function(){ 
	$('.sel_contents').on('click',function(){
		Tmp=$(this).attr('id');
		$('#sel_ck').val(Tmp);
		$('#form').submit();
	});

	$('#page_set_btn').on('click',function(){
		if (!confirm('変更します。よろしいですか')) {
			return false;
		}else{
			$('#page_set').submit();
		}
	});

	$('.rec_tbl_chg').on('change',function(){
		Tmp=$(this).attr('id');
		$.ajax({
			url:'./post/recruit_chg.php',
			type: 'post',
			data:{
				'id'	:Tmp,
				'dat'	:$(this).val(),
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});


	$('.prof_btn').on('click',function(){
		Tmp=$(this).attr('id');

		if($(this).hasClass('rec_bg1')){
			$(this).removeClass('rec_bg1').addClass('rec_bg0');
			Dat=0;
		}else{
			$(this).removeClass('rec_bg0 rec_bg').addClass('rec_bg1');
			Dat=1;
		}

		$.ajax({
			url:'./post/recruit_chg.php',
			type: 'post',
			data:{
				'id'	:Tmp,
				'dat'	:Dat,
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.main_box').on('change','.cate_v',function(){
		Chk=$(this).val();
		if( Chk=='person' || Chk=='blog' || Chk=='page'){

			$(this).next('.cate_s').hide();
		}else{
			$(this).next('.cate_s').show();
		}
	});


	$('.upd_file').on('change',function(e){
		Tmp=$(this).attr('id');

		Ck=Tmp.substr(3,1);
		if(Ck=="i"){
			Ck_h=200;
			Ck_w=600;

		}else{
			Ck_h=480;
			Ck_w=1200;
		}

		var file = e.target.files[0];	
		var reader = new FileReader();

		if(file.type.indexOf("image") < 0){
			alert("NO IMAGE FILES");
			return false;
		}
		var img = new Image();

		reader.onload = (function(file){
			return function(e){
				img.src = e.target.result;
				img.onload = function() {
					if(img.height != Ck_h || img.width != Ck_w){
						if (!confirm('画像が推奨サイズではありませんがよろしいですか\n※推奨サイズ　縦'+Ck_h+'px 横'+ Ck_w+'px' +img.height+'/'+img.width)) {
							return false;
						}else{
							$("#top_"+Tmp).attr('src', e.target.result);
						}
					}else{
							$("#top_"+Tmp).attr('src', e.target.result);
					}
				}
			}
		})(file);
		reader.readAsDataURL(file);
	});

	$('.event_tag_btn,.event_set_btn').on('click',function(){
		Tmp	=$(this).attr('id').substr(0,3);
		Tmp2=$(this).attr('id').substr(3);

console.log(Tmp2);

		if(Tmp == 'chg'){
			if (!confirm('変更します。よろしいですか')) {
				return false;
			}else{
				$('#f'+Tmp2).submit();
			}

		}else if(Tmp == 'del'){
			if (!confirm('削除します。よろしいですか')) {
				return false;

			}else{
				$('#st'+Tmp2).val('4');
				$('#f'+Tmp2).submit();
			}

		}else if(Tmp == 'cov'){
			Tmp3=$('#st'+Tmp2).val();
			if(Tmp3 == 3){
				$('#st'+Tmp2).val('0');

			}else{
				$('#st'+Tmp2).val('3');
			}
			$('#f'+Tmp2).submit();
		}
	});


	$(".event_tag_label").on("change",function(){
		var Tmp=$(this).attr("id").replace("sid","");
		$(".event_tag_label").removeClass("lavel_on");
		$(this).addClass("label_on");
		$("#hdn").val(Tmp);
	});


});
</script>

<header class="head">
<div id="event" class="sel_contents <?if($post_id == "event"){?> sel_ck<?}?>">イベント</div>
<div id="news"  class="sel_contents <?if($post_id == "news"){?> sel_ck<?}?>">NEWS</div>
<div id="info"  class="sel_contents <?if($post_id == "info"){?> sel_ck<?}?>">INFO</div>

<div id="page"  class="sel_contents <?if($post_id == "system" || $post_id == "access" || $post_id == "recruit" || $post_id == "policy"){?> sel_ck<?}?>">PAGE</div>
<?if($post_id == "news" ||$post_id == "event" ||$post_id == "info"){?>
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
<?}?>
</header>
<div class="top_page"><?if($post_id == "news" ||$post_id == "event" ||$post_id == "info"){?>(<?=$pg_st?> - <?=$pg_ed?> / <?=$res_max?>件)<?}?></div>
<div class="wrap">
	<?if($post_id == "news"){?>
		<div class="main_box">
			<form id="fnew" action="./index.php" method="post">
				<input type="hidden" name="post_id" value="news">
				<input type="hidden" name="menu_post" value="contents">
				<input type="hidden" name="event_set_id" value="new">

				<table class="news_table" style="background:#fafada">
					<tr>
						<td style="font-size:0;">
							<span class="event_tag">日付</span><input type="date" name="event_date" class="w140 news_box" value="<?=$base_now?>"> 
							<span class="event_tag">公開日</span><input type="date" name="display_date" class="w140 news_box" value="<?=$base_now?>"> 
							<span class="event_tag">状態</span>
							<select class="w120 news_box" name="event_status">
								<option value="0">表示</option>
								<option value="2">注目</option>
								<option value="3">非表示</option>
								<option value="4">削除</option>
							</select>
							<button id="chgnew" type="button" class="event_tag_btn">登録</button>
						</td>
					</tr>

					<tr>
						<td style="font-size:0;">
							<span class="event_tag">タグ</span>
							<select name="event_tag" class="w140 news_box">
								<?foreach($tag as $b1 => $b2){?><option value="<?=$b2["id"]?>"><?=$b2["tag_name"]?></option>
								<? } ?>	
							</select>
							<span class="event_tag">リンク</span><select name="category" class="w140 news_box">
								<option value="">なし</option>
								<option value="news">ニュース</option>
								<option value="event">イベント</option>
								<option value="person">CAST</option>
								<option value="blog">ブログ</option>
								<option value="page">リンク</option>
							</select>
							<input type="text" name="event_key" class="news_box" style="border:1px solid #303030;width:185px;" value=""> 
						</td>
					</tr>

					<tr>
						<td>
							<textarea name="event_title" class="news_title"></textarea>
						</td>
					</tr>
				</table>
			</form>

			<?foreach($dat as $a1 => $a2){?>
				<form id="f<?=$a2["id"]?>" action="./index.php" method="post">
					<input type="hidden" name="post_id" value="news">
					<input type="hidden" name="menu_post" value="contents">
					<input type="hidden" name="event_set_id" value="<?=$a2["id"]?>">

					<table class="news_table c<?=$a2["status"]?>">
						<tr>
							<td style="font-size:0;">
								<span class="event_tag">日付</span><input type="date" name="event_date" class="w140 news_box" value="<?=$a2["event_date"]?>" autocomplete="off"> 
								<span class="event_tag">公開日</span><input type="date" name="display_date" class="w140 news_box" value="<?=$a2["display_date"]?>" autocomplete="off"> 
								<span class="event_tag">状態</span>
								<select class="w120 news_box" name="event_status">
									<option value="0" <?if($a2["status"] == 0){?> selected="selected"<?}?>>表示</option>
									<option value="2" <?if($a2["status"] == 2){?> selected="selected"<?}?>>注目</option>
									<option value="3" <?if($a2["status"] == 3){?> selected="selected"<?}?>>非表示</option>
									<option value="4" <?if($a2["status"] == 4){?> selected="selected"<?}?>>削除</option>
								</select>
								<button id="chg<?=$a2["id"]?>" type="button" class="event_tag_btn">変更</button>
							</td>
						</tr>

						<tr>
							<td style="font-size:0;">
								<span class="event_tag">タグ</span>
								<select name="event_tag" class="w140 news_box">
									<?foreach($tag as $b1 => $b2){?><option value="<?=$b2["id"]?>" <?if($b2["id"] == $a2["tag"]){?> selected="selected"<?}?>><?=$b2["tag_name"]?></option>
									<? } ?>	
								</select>
								<span class="event_tag">リンク</span><select name="category" class="w140 news_box">
									<option value="">なし</option>
									<option value="news"   <?if($a2["category"] == "news"){?> selected="selected"<?}?>>ニュース</option>
									<option value="event"  <?if($a2["category"] == "event"){?> selected="selected"<?}?>>イベント</option>
									<option value="person" <?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
									<option value="blog"   <?if($a2["category"] == "blog"){?> selected="selected"<?}?>>ブログ</option>
									<option value="page"   <?if($a2["category"] == "page"){?> selected="selected"<?}?>>リンク</option>
								</select>
								<input type="text" name="event_key" class="news_box" style="border:1px solid #303030;width:185px;" value="<?=$a2["contents_key"]?>"> 
							</td>
						</tr>

						<tr>
							<td>
								<textarea name="event_title" class="news_title"><?=$a2["title"]?></textarea>
							</td>
						</tr>
					</table>
					<input id="hdn" type="hidden" name="hdn" value="<?=$hdn?>">
				</form>
			<?}?>
		</div>
		<div class="sub_box">
				<span id="sid0" class="event_tag_label <?if($hdn == 0){?>c1<?}?>">全て</span><br>
			<?foreach($tag as $a1 => $a2){?>
				<span id="sid<?=$a1?>" class="event_tag_label <?if($hdn == $a1){?>c1<?}?>"><?=$a2["tag_name"]?></span><br>
			<?}?>
		</div>



<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
	<?}elseif($post_id == "info"){?>
		<div class="main_box">
		<table class="event_table" style="background:#fafada; width:750px;">
			<form id="fnew" action="./index.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="post_id" value="info">
			<input type="hidden" name="menu_post" value="contents">
			<input type="hidden" name="event_set_id" value="new">
			<tr>
				<td class="event_td_0" rowspan="2"><span class="event_td_0_in">新規作成</span></td>

				<td class="event_td_3">
					<span class="event_tag">公開日</span>
					<input type="date" name="display_date" class="w140" value="<?=$base_now?>" autocomplete="off">
					<button  type="submit" class="event_reg_btn">登録</button>
				</td>

				<td class="event_td_7" rowspan="2">
					<label for="updinew" class="info_img"><img id="top_updinew" src="../img/info_no_image.png" style="width:210px; height:70px;"></label>
					<input id="updinew" name="upd_img" type="file" class="upd_file" style="display:none;">
				</td>
			</tr>

			<tr>
				<td  class="event_td_5">
					<span class="event_tag">リンク</span><select name="category" class="w140">
						<option value="">なし</option>
						<option value="info"  <?if($a2["category"] == "info"){  ?> selected="selected"<?}?>>インフォ</option>
						<option value="event" <?if($a2["category"] == "event"){ ?> selected="selected"<?}?>>イベント</option>
						<option value="person"<?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
						<option value="blog"  <?if($a2["category"] == "blog"){  ?> selected="selected"<?}?>>ブログ</option>
						<option value="page"  <?if($a2["category"] == "page"){  ?> selected="selected"<?}?>>リンク</option>
					</select>
					<input type="text" name="event_key" style="width:175px;margin-left:5px;" value=""> 
				</td>
			</form>
		</table>

		<div id="contents_sort" class="main_list list_sort">
			<?foreach($dat as $a1 => $a2){?>
			<table id="sort_item<?=$a1?>" class="event_table sort_item c<?=$a2["status"]?>" style=" width:750px;">
				<form id="f<?=$a1?>" action="./index.php" method="post" enctype="multipart/form-data">
	
				<input type="hidden" name="post_id" value="info">
				<input type="hidden" name="menu_post" value="contents">
				<input type="hidden" name="event_set_id" value="<?=$a1?>">

				<input type="hidden" name="prm" value="<?=$a2["prm"]?>">
				<tbody>
					<tr>
						<td class="event_td_1 handle" rowspan="2"></td>
						<td class="event_td_2" rowspan="2">
							<input type="text" value="<?=$a2["sort"]?>" class="box_sort" disabled>
						</td>

						<td class="event_td_3">
							<span class="event_tag">公開日</span>
							<input type="date" name="display_date" class="w140" value="<?=$a2["display_date"]?>" autocomplete="off">
							<button id="cov<?=$a1?>" type="button" class="event_set_btn"><?=$st[$a2["status"]]?></button>
							<button id="chg<?=$a1?>" type="button" class="event_set_btn">更新</button>
							<button id="del<?=$a1?>" type="button" class="event_set_btn">削除</button>
						</td>

						<td class="event_td_7" rowspan="2">
							<label for="updi<?=$a1?>" class="info_img"><img id="top_updi<?=$a1?>" src="<?=$a2["img"]?>" style="width:210px; height:70px;"></span>
							<input id="updi<?=$a1?>" name="upd_img" type="file" class="upd_file" style="display:none;">
							<input id="st<?=$a1?>" type="hidden" name="event_status" value="<?=$a2["status"]?>">
						</td>
					</tr>
					<tr>
						<td  class="event_td_5">
							<span class="event_tag">リンク</span><select name="category" class="w140">
								<option value="">なし</option>
								<option value="info"   <?if($a2["category"] == "info"){?> selected="selected"<?}?>>インフォ</option>
								<option value="event"  <?if($a2["category"] == "event"){?> selected="selected"<?}?>>イベント</option>
								<option value="person" <?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
								<option value="blog"   <?if($a2["category"] == "blog"){?> selected="selected"<?}?>>ブログ</option>
								<option value="page"   <?if($a2["category"] == "page"){?> selected="selected"<?}?>>リンク</option>
							</select>
							<input type="text" name="event_key" style="width:175px;margin-left:5px;" value="<?=$a2["contents_key"]?>"> 
						</td>
					</tr>
				</tbody>
				</form>
			</table>
			<? } ?>
		</div>
		</div>
		<div class="sub_box"></div>
<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
	<?}elseif($post_id == "event"){?>
		<div class="main_box">
		<table class="event_table" style="background:#fafada;">
			<form id="fnew" action="./index.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="post_id" value="event">
			<input type="hidden" name="menu_post" value="contents">
			<input type="hidden" name="event_set_id" value="new">
			<tr>
				<td class="event_td_0" rowspan="4"><span class="event_td_0_in">新規作成</span></td>
				<td class="event_td_3">
					<span class="event_tag">公開日</span>
					<input type="date" name="display_date" class="w140" value="<?=$base_now?>" autocomplete="off">
					<button  type="submit" class="event_reg_btn">登録</button>

					<label for="news_check" class="ribbon_use" style="margin-left:30px;display:inline-block">
						<span class="check2">
							<input id="news_check" type="checkbox" name="news_check" class="ck0" value="1" checked="checked">
							<span class="check1"></span>
						</span>
						<span>NEWS登録</span>
					</label>
				</td>

				<td class="event_td_6" rowspan="3">
					<label for="updenew" class="event_img"><img id="top_updenew" src="../img/event_no_image.png" style="width:275px; height:110px;"></label>
					<input id="updenew" name="upd_img" type="file" class="upd_file" style="display:none;">
				</td>

			</tr><tr>
				<td  class="event_td_5">
					<span class="event_tag">リンク</span><select name="category" class="cate_v w140">
						<option value="">なし</option>
						<option value="event"  <?if($a2["category"] == "event"){?> selected="selected"<?}?>>イベント</option>
						<option value="person" <?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
						<option value="blog"   <?if($a2["category"] == "blog"){?> selected="selected"<?}?>>ブログ</option>
						<option value="page"   <?if($a2["category"] == "page"){?> selected="selected"<?}?>>リンク</option>
					</select>
					<input type="text" name="event_key" class="cate_s" style="width:200px;margin-left:5px;" value=""> 
				</td>

			</tr><tr>
				<td  class="event_td_5">
					<span class="event_tag">TITLE</span>
					<input type="text" name="event_title" style="width:345px;" value="<?=$a2["title"]?>">
				</td>

			</tr><tr>
				<td  class="event_td_4" colspan="2"><textarea name="event_contents" class="event_td_4_in"><?=$a2["contents"]?></textarea></td>
			</tr>
			</form>
		</table>

		<div id="contents_sort" class="main_list list_sort">
			<?foreach($dat as $a1 => $a2){?>
			<table id="sort_item<?=$a1?>" class="event_table sort_item c<?=$a2["status"]?>">
				<form id="f<?=$a1?>" action="./index.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="post_id" value="event">
				<input type="hidden" name="menu_post" value="contents">
				<input type="hidden" name="event_set_id" value="<?=$a1?>">
				<input id="st<?=$a1?>" type="hidden" name="event_status" value="<?=$a2["status"]?>">
				<input type="hidden" name="prm" value="<?=$a2["prm"]?>">
				<tbody>
				<tr>
					<td class="event_td_0" colspan="2"><span class="event_td_0_in"><?=$a2["id"]?></span></td>
						<td class="event_td_3">
						<span class="event_tag">公開日</span>
						<input type="date" name="display_date" class="w140" value="<?=$a2["display_date"]?>" autocomplete="off">
						<button id="cov<?=$a1?>" type="button" class="event_set_btn"><?=$st[$a2["status"]]?></button>
						<button id="chg<?=$a1?>" type="button" class="event_set_btn">更新</button>
						<button id="del<?=$a1?>" type="button" class="event_set_btn">削除</button>
					</td>

					<td class="event_td_6" rowspan="3">
						<label for="upde<?=$a1?>" class="event_img"><img id="top_upde<?=$a1?>" src="<?=$a2["img"]?>" style="width:275px; height:110px;"></span>
						<input id="upde<?=$a1?>" name="upd_img" type="file" class="upd_file" style="display:none;">
					</td>
				</tr><tr>
					<td rowspan="3"  class="event_td_1 handle"></td>
					<td rowspan="3"  class="event_td_2">
						<input type="text" value="<?=$a2["sort"]?>" class="box_sort" disabled>
					</td>

					<td  class="event_td_5">
						<span class="event_tag">リンク</span><select name="category" class="cate_v w140">
							<option value="">なし</option>
							<option value="event"  <?if($a2["category"] == "event"){?> selected="selected"<?}?>>イベント</option>
							<option value="person" <?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
							<option value="blog"   <?if($a2["category"] == "blog"){?> selected="selected"<?}?>>ブログ</option>
							<option value="page"   <?if($a2["category"] == "page"){?> selected="selected"<?}?>>リンク</option>

						</select>
						<input type="text" name="event_key" class="cate_s" style="width:200px;margin-left:5px;" value="<?=$a2["contents_key"]?>"> 
					</td>

				</tr><tr>
					<td  class="event_td_5">
						<span class="event_tag">TITLE</span>
						<input type="text" name="event_title" style="width:345px;" value="<?=$a2["title"]?>">
					</td>

				</tr><tr>
					<td  class="event_td_4" colspan="2"><textarea name="event_contents" class="event_td_4_in"><?=$a2["contents"]?></textarea></td>
				</tr>
				</tbody>
				</form>
			</table>
			<? } ?>
		</div>
		</div>

		<div class="sub_box">
			<div>新規作成</div>
		</div>

<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
	<?}else{?>
		<?if($post_id == "recruit"){?>
			<div class="main_box">
				<div  class="recruit_img_out">
					<form id="fimg" action="./index.php" method="post" enctype="multipart/form-data">
						<button id="chgimg" type="button" class="event_set_btn">更新</button>
						<button id="delimg" type="button" class="event_set_btn">削除</button>
						<label for="updr_img" class="recruit_img"><img id="top_updr_img" src="<?=$recruit_img?>" style="width:800px" ></label>
						<input id="updr_img" name="upd_img" type="file" class="upd_file" style="display:none;">

						<input type="hidden" name="prm" value="<?=$prm?>">
						<input type="hidden" name="post_id" value="recruit">
						<input type="hidden" name="menu_post" value="contents">
						<input type="hidden" name="event_set_id" value="recruit_img">
						<input type="hidden" name="category" value="image">
						<input id="stimg" type="hidden" name="event_status" value="">
					</form>
				</div>

				<table class="recuruit_table">
					<form id="f<?=$recruit_id?>" action="./index.php" method="post">
					<input type="hidden" name="post_id" value="recruit">
					<input type="hidden" name="menu_post" value="contents">
					<input type="hidden" name="event_set_id" value="<?=$recruit_id?>">
					<input type="hidden" name="category" value="top">
					<tr>
						<td colspan="2" style="width:88px;background:#b0c0ff;text-align:center;">TOP</td>
						<td class="recruit_td3">
							<input type="text" name="event_title" class="recruit_title" value="<?=$recruit_title?>">
							<button id="cov<?=$recruit_id?>" type="button" class="event_set_btn">非表示</button>
							<button id="chg<?=$recruit_id?>" type="button" class="event_set_btn">更新</button>
							<button id="del<?=$recruit_id?>" type="button" class="event_set_btn">削除</button>
							<textarea name="event_contents" class="recruit_contents"><?=$recruit_contents?></textarea>
						</td>
					</tr>
					</form>
				</table>

				<table class="recuruit_table">
					<tr class="tr sort_item">
						<form id="fnew" action="./index.php" method="post">
							<input type="hidden" name="post_id" value="recruit">
							<input type="hidden" name="menu_post" value="contents">
							<input type="hidden" name="event_set_id" value="new">
							<input type="hidden" name="category" value="list">

							<td class="event_td_1 handle" style="background:#ffd090; width:88px;font-size:18px;color:#a04000;">新規作成</td>
							<td class="recruit_td3" style="background:#fafada;">
								<input type="text" name="event_title" class="recruit_title" value="" style="background:#ffffe0;">
								<button id="chgnew" type="button" class="event_set_btn">登録</button>
								<textarea name="event_contents" class="recruit_contents"></textarea>
							</td>
						</form>
					</tr>
				</table>

				<table class="recuruit_table">
					<tbody id="contents_sort" class="list_sort">
						<?foreach($dat as $a1 => $a2){?>
							<tr id="sort_item<?=$a1?>" class="tr sort_item">
								<form id="f<?=$a1?>" action="./index.php" method="post">
									<input type="hidden" name="post_id" value="recruit">
									<input type="hidden" name="menu_post" value="contents">
									<input type="hidden" name="event_set_id" value="<?=$a1?>">
									<input type="hidden" name="category" value="list">

									<input id="st<?=$a1?>" type="hidden" name="event_status" value="<?=$a2["status"]?>">
									<td class="event_td_1 handle"></td>
									<td class="event_td_2 c<?=$a2["status"]?>"><input type="text" value="<?=$a2["sort"]?>" class="box_sort" disabled></td>
									<td class="recruit_td3 c<?=$a2["status"]?>">
										<input type="text" name="event_title" class="recruit_title c<?=$a2["status"]?>" value="<?=$a2["title"]?>">
										<button id="cov<?=$a1?>" type="button" class="event_set_btn">非表示</button>
										<button id="chg<?=$a1?>" type="button" class="event_set_btn">更新</button>
										<button id="del<?=$a1?>" type="button" class="event_set_btn">削除</button>
										<textarea name="event_contents" class="recruit_contents c<?=$a2["status"]?>"><?=$a2["contents"]?></textarea>
									</td>
								</form>
							</tr>
						<? } ?>
					</tbody>
				</table>

				<div class="config_title">コンタクトフォーム</div>
				<table class="config_sche">
					<thead>
						<tr>
							<td class="config_sche_top" style="width:40px">替</td>
							<td class="config_sche_top" style="width:40px">順番</td>
							<td class="config_sche_top" style="width:240px">名前</td>
							<td class="config_sche_top" style="width:120px">スタイル</td>
							<td class="config_sche_top" style="width:40px"></td>
						</tr>
					</thead>

					<tbody id="prof_set_list" class="tb">
						<?for($n=1;$n<10;$n++){?>
							<tr class="tr bg">
								<td class="config_prof_handle handle"></td>
								<td class="config_prof_sort"><input type="text" value="<?=$n?>" class="prof_sort" disabled></td>
								<td class="config_prof_name"><input id="name<?=$n?>" type="text" value="<?=$contact_table[$n]["name"]?>" class="chg1 prof_name rec_tbl_chg"></td>
								<td class="config_prof_style">

									<select id="type<?=$n?>" class="chg1 prof_option rec_tbl_chg">
										<option value="1">一行</option>
										<option value="4" <?if($contact_table[$n]["type"] == 4){?>selected="selected"<?}?>>複数行</option>
										<option value="2" <?if($contact_table[$n]["type"] == 2){?>selected="selected"<?}?>>MAIL</option>
										<option value="3" <?if($contact_table[$n]["type"] == 3){?>selected="selected"<?}?>>数字</option>
									</select>
								</td>

								<td class="config_prof_styl">
									<button id="chg<?=$n?>" type="button" class="prof_btn view_btn rec_bg<?=$contact_table[$n]["check"]?>">必須</button>
								</td>
							</tr>
						<? } ?>
					</tbody>
				</table>

				<table class="config_sche">
					<tr class="tr">
						<td class="config_prof_name">受付：メール</td>
						<td class="config_prof_style"><input id="rec_mail" type="text" value="<?=$contact["mail"]?>" class="chg0 prof_name rec_tbl_chg"></td>
					</tr>

					<tr class="tr">
						<td class="config_prof_name">受付：電話</td>
						<td class="config_prof_style"><input id="rec_tel" type="text" value="<?=$contact["tel"]?>" class="chg0 prof_name rec_tbl_chg"></td>
					</tr>

					<tr class="tr">
						<td class="config_prof_name">受付：LINE</td>
						<td class="config_prof_style"><input id="rec_line" type="text" value="<?=$contact["line"]?>" class="chg0 prof_name rec_tbl_chg"></td>
					</tr>

					<tr class="tr">
						<td class="config_prof_name">通知メール</td>
						<td class="config_prof_style"><input id="rec_call" type="text" value="<?=$contact["call"]?>" class="chg0 prof_name rec_tbl_chg"></td>
					</tr>
				</table>
			</div>

	<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
		<?}else{?>
			<div class="main_box">
				<form id="page_set" method="post">
					<div class="page_top">
						<div style="font-size:15px;font-weight:600;margin-top:10px;">TITLE</div>
						<input type="text" name="page_title" style="width:640px;" value="<?=$dat[0]["title"]?>"><button id="page_set_btn" type="button" class="event_set_btn">変更</button>
						<div style="font-size:15px;font-weight:600;margin-top:10px;">本文</div>
						<textarea class="page_area" name="page_log"><?=$dat[0]["contents"]?></textarea><br>

<?if($post_id =="access"){?>
						<div style="font-size:15px;font-weight:600;margin-top:10px;">MAP</div>
						<textarea name="page_key" class="rec_link"><?=$dat[0]["contents_key"]?></textarea>				
<?}?>
					<input type="hidden" name="post_id_set" value="<?=$post_id?>">
					<input type="hidden" name="menu_post" value="contents">
					</div>			
				</form>
			</div>
		<?}?>

	<div class="sub_box">
		<div id="system"  class="sel_contents <?if($post_id == "system"){?> sel_ck<?}?>">SYSTEM</div>
		<div id="access"  class="sel_contents <?if($post_id == "access"){?> sel_ck<?}?>">ACCESS</div>
		<div id="recruit" class="sel_contents <?if($post_id == "recruit"){?> sel_ck<?}?>">RECRUIT</div>
		<div id="policy"  class="sel_contents <?if($post_id == "policy"){?> sel_ck<?}?>">ポリシー</div>
	</div>

<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
	<? } ?>
</div>

<form id="main_form" method="post">
	<input id="pg" type="hidden" name="pg">
	<input type="hidden" name="send" value="1">
	<input type="hidden" name="post_id" value="<?=$post_id?>">
	<input type="hidden" name="menu_post" value="contents">
	<input type="hidden" name="sub_group">
</form>

<form id="form" method="post">
	<input id="sel_ck" type="hidden" name="post_id">
	<input type="hidden" name="menu_post" value="contents">
</form>
