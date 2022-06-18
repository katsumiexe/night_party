<?php
include_once('./library/sql.php');

$h_time=$admin_config["start_time"]*100;
$sql  ="SELECT id, tag_name, tag_icon,sort FROM ".TABLE_KEY."_tag ";
$sql .=" WHERE tag_group='ribbon'";
$sql.=" AND del='0'";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$ribbon_sort[$row["sort"]]=$row["id"];
		$ribbon[$row["id"]]["name"]=$row["tag_name"];

		$tmp1=hexdec(substr($row["tag_icon"],1,2))+56;
		$tmp2=hexdec(substr($row["tag_icon"],3,2))+56;
		$tmp3=hexdec(substr($row["tag_icon"],5,2))+56;

		if($tmp1 > 255) $tmp1 =255;
		if($tmp2 > 255) $tmp2 =255;
		if($tmp3 > 255) $tmp3 =255;

		$tmp1=dechex($tmp1);
		$tmp2=dechex($tmp2);
		$tmp3=dechex($tmp3);

		$tmp="#".$tmp1.$tmp2.$tmp3;
	
		$ribbon[$row["id"]]["c1"]=$tmp;
		$ribbon[$row["id"]]["c2"]=$row["tag_icon"];
	}
}

$sql ="SELECT * FROM ".TABLE_KEY."_contents";
$sql.=" WHERE page='top'";
$sql.=" ORDER BY sort DESC";
$sql.=" LIMIT 1";
$result = mysqli_query($mysqli,$sql);
$top_comm = mysqli_fetch_assoc($result);



$sql2=" SELECT id, genji, prm, ctime, ribbon_use, cast_ribbon, prm FROM ".TABLE_KEY."_cast";
$sql2.=" WHERE cast_status<2";
$sql2.=" AND del=0";
$sql2.=" AND genji IS NOT NULL";
$sql2.=" ORDER BY cast_sort ASC";
$sql2.=" LIMIT 10";

if($result2 = mysqli_query($mysqli,$sql2)){
	while($row = mysqli_fetch_assoc($result2)){

		if($admin_config["ribbon"] ==1){
			if($ribbon[$row["cast_ribbon"]]["name"]){
				$row["ribbon_name"]	=$ribbon[$row["cast_ribbon"]]["name"];
				$row["ribbon_c1"]	=$ribbon[$row["cast_ribbon"]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$row["cast_ribbon"]]["c2"];

			}elseif($day_8 == $row["ctime"] && $admin_config["today_commer"]==1){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[2]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[2]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[2]]["c2"];

			}elseif($day_8 < $row["ctime"] && $admin_config["coming_soon"]==1){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[1]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[1]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[1]]["c2"];

			}elseif((strtotime($day_8) - strtotime($row["ctime"]))/86400<$admin_config["new_commer_cnt"]){
				$row["ribbon_name"]	=$ribbon[$ribbon_sort[3]]["name"];
				$row["ribbon_c1"]	=$ribbon[$ribbon_sort[3]]["c1"];
				$row["ribbon_c2"]	=$ribbon[$ribbon_sort[3]]["c2"];
			}
		}

		if (file_exists("./img/profile/{$row["id"]}/0.webp")) {
			$row["face"]="./img/profile/{$row["id"]}/0.webp?t={$row["prm"]}";

		}elseif (file_exists("./img/profile/{$row["id"]}/0.jpg")) {
			$row["face"]="./img/profile/{$row["id"]}/0.jpg?t={$row["prm"]}";

		}elseif (file_exists("./img/profile/{$row["id"]}/0.png")) {
			$row["face"]="./img/profile/{$row["id"]}/0.png?t={$row["prm"]}";

		}else{
			$row["face"]="./img/cast_no_image.jpg";			
		}

		$cast_dat[]=$row;
	}
}

if($cast_dat){
	ksort($cast_dat);
}
$sql	 ="SELECT * FROM ".TABLE_KEY."_contents";
$sql	.=" WHERE status=0";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='event'";
$sql	.=" ORDER BY sort ASC";
$sql	.=" LIMIT 6";

if($res0 = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res0)){

		if($a1["category"] == "event"){
			$a1["link"]="./event.php";
			$a1["code"]=$a1["id"];

		}elseif($a1["category"] == "person"){
			$a1["link"]="./person.php";
			$a1["code"]=$a1["contents_key"];

		}elseif($a1["category"]){
			$a1["link"]=$a1["contents_key"];
		}

		if (file_exists("./img/page/event/event_{$a1["id"]}.webp") && $admin_config["webp_select"] == 1) {
			$a1["img"]="./img/page/event/event_{$a1["id"]}.webp?t={$a1["prm"]}";

		}elseif (file_exists("./img/page/event/event_{$a1["id"]}.jpg")) {
			$a1["img"]="./img/page/event/event_{$a1["id"]}.jpg?t={$a1["prm"]}";

		}elseif (file_exists("./img/page/event/event_{$a1["id"]}.png")) {
			$a1["img"]="./img/page/event/event_{$a1["id"]}.png?t={$a1["prm"]}";
		}
		$event[]=$a1;
		$count_event++;
	}
}

$sql	 ="SELECT tag_name, tag_icon, date, status, display_date,event_date, category, contents_key, title, contents FROM ".TABLE_KEY."_contents";
$sql	.=" LEFT JOIN ".TABLE_KEY."_tag ON tag=".TABLE_KEY."_tag.id";
$sql	.=" WHERE status<3";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='news'";
$sql	.=" ORDER BY status DESC, event_date DESC";
$sql	.=" LIMIT 5";

if($res1 = mysqli_query($mysqli,$sql)){
	while($a2 = mysqli_fetch_assoc($res1)){
		$a2["date"]=substr(str_replace("-",".",$a2["event_date"]),0,10);

		if($a2["status"] ==2){
			$a2["caution"]="news_caution";
		} 

		if($a2["category"] == "person"){
			$a2["news_link"]="./person.php?post_id={$a2["contents_key"]}";

		}elseif($a2["category"] == "outer"){
			$a2["news_link"]=$a2["contents_key"];

		}elseif($a2["category"] == "event"){
			$a2["news_link"]="./event.php?post_id={$a2["contents_key"]}";

		}elseif($a2["category"] == "blog"){
			$a2["news_link"]="./article.php?post_id={$a2["contents_key"]}";

		}elseif($a2["category"] == "page"){
			$a2["news_link"]=$a2["contents_key"];
		}
		$news[]=$a2;
		$count_news++;
	}
}

$sql	 ="SELECT * FROM ".TABLE_KEY."_contents";
$sql	.=" WHERE status<4";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='info'";
$sql	.=" ORDER BY sort ASC";
$sql	.=" LIMIT 6";

if($res2 = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res2)){

		if($a1["category"] == "person" && $a1["contents_key"]){
			$a1["link"]="person.php?post_id=".$a1["contents_key"];

		}elseif($a1["category"] == "event" && $a1["contents_key"]){
			$a1["link"]="event.php?post_id=".$a1["contents_key"];

		}elseif($a1["contents_key"]){
			$a1["link"]=$a1["contents_key"];
		}

		if (file_exists("./img/page/info/info_{$a1["id"]}.webp") && $admin_config["webp_select"] == 1) {
			$a1["img"]="./img/page/info/info_{$a1["id"]}.webp?t={$a1["prm"]}";

		}elseif (file_exists("./img/info/info_/event_{$a1["id"]}.jpg")) {
			$a1["img"]="./img/page/info/info_{$a1["id"]}.jpg??t={$a1["prm"]}";

		}elseif (file_exists("./img/info/info_/event_{$a1["id"]}.png")) {
			$a1["img"]="./img/page/info/info_{$a1["id"]}.png??t={$a1["prm"]}";
		}

		$info[]=$a1;
		$info_count++;
	}
}
$sql	 ="SELECT * FROM ".TABLE_KEY."_contents";
$sql	.=" WHERE status<4";
$sql	.=" AND page IN ('system','recruit','access')";

if($res2 = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res2)){
		if($a1["page"]== "system"){
			$dat_system =$a1;

		}elseif($a1["page"]== "access"){
			$dat_access =$a1;

		}elseif($a1["page"]== "recruit"){
			$a1["contents"]=str_replace("\n","<br>",$a1["contents"]);

			if($a1["category"] == "list"){
				$dat_list[$a1["sort"]]=$a1;

			}else{
				$dat_recruit[$a1["category"]]=$a1;
			}
		}
	}
ksort($dat_list);
}

if($dat_recruit){
	$ck_tg["1"]="<span class=\"nec\">※必須項目</span>";
	$ck_jq["1"]="nec_ck";
	$ck_re["1"]="required";

	$form_dat ="<div class=\"recruit_contact_title\">◆お問い合わせ◆</div>";
	$form_dat.="<div class=\"recruit_contact_box\">";
	$form_dat.="<input id=\"contact_id\" type=\"hidden\" value=\"1\">";

	$sql="SELECT * FROM ".TABLE_KEY."_contact_table";
	$sql.=" WHERE block='1'";
	$sql.=" AND del IS NULL";
	$sql.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($c_form= mysqli_fetch_assoc($result)){
			$form_dat.="<div class=\"contact_tag\">{$c_form["name"]}{$ck_tg[$c_form["ck"]]}</div><span id=\"err{$c_form["id"]}\" class=\"contact_err\">必須項目です</span>";
			$form_p.="<div class=\"contact_p_tag\">{$c_form["name"]}</div>";

			if($c_form["type"]== 1){//text
				$form_dat.="<input id=\"contact{$c_form["id"]}\" type=\"text\" name=\"contact{$c_form["id"]}\" class=\"contact_list contact {$ck_jq[$c_form["ck"]]}\" autocomplete=\"off\" {$ck_re[$c_form["ck"]]}>";
				$form_p.="<div id=\"pcontact{$c_form["id"]}\" class=\"contact_p\"></div>";

			}elseif($c_form["type"]== 2){//comm
				$form_dat.="<textarea id=\"contact{$c_form["id"]}\" name=\"contact{$c_form["id"]}\" class=\"contact_list contact_area {$ck_jq[$c_form["ck"]]}\" autocomplete=\"off\" size=\"600\" {$ck_re[$c_form["ck"]]}></textarea>";
				$form_p.="<div id=\"pcontact{$c_form["id"]}\" class=\"contact_p\"></div>";

			}elseif($c_form["type"]== 3){//mail
				$form_dat.="<input id=\"contact{$c_form["id"]}\" type=\"url\" name=\"contact{$c_form["id"]}\" class=\"contact_list contact v_mail {$ck_jq[$c_form["ck"]]}\" autocomplete=\"off\" {$ck_re[$c_form["ck"]]}>";
				$form_p.="<div id=\"pcontact{$c_form["id"]}\" class=\"contact_p\"></div>";

			}elseif($c_form["type"]== 4){//number
				$form_dat.="<input id=\"contact{$c_form["id"]}\" type=\"number\" inputmode=\"numeric\" name=\"contact{$c_form["id"]}\" class=\"contact_list contact {$ck_jq[$c_form["ck"]]}\" autocomplete=\"off\" {$ck_re[$c_form["ck"]]}>";
				$form_p.="<div id=\"pcontact{$c_form["id"]}\" class=\"contact_p\"></div>";
			}
		}
	}
	$form_p.="<div class=\"contact_p_ck\">送信します。よろしいですか</div>";
	$form_p.="<button id=\"recruit_ok\" type=\"button\" class=\"recruit_send2\">送信</button>　<button id=\"recruit_ng\" type=\"button\" class=\"recruit_send2\">戻る</button><br><br>";
	$form_dat.="<button id=\"recruit_send\" type=\"button\" class=\"recruit_send\">送信</button>";
	$form_dat.="</div>";
}

$sql ="SELECT id, cast, view_date, title, img, img_del, log  FROM ".TABLE_KEY."_posts";
$sql.=" WHERE status=0";
$sql.=" AND cast=1";
$sql.=" AND view_date<='{$now}'";
$sql.=" AND log<>''";
$sql.=" AND title<>''";
$sql.=" ORDER BY view_date DESC";
$sql.=" LIMIT 3";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		$row["date"]=date("Y.m.d",strtotime($row["view_date"]));

		if($row["img"]){
			if (file_exists("./img/profile/{$row["cast"]}/{$row["img"]}_s.webp") && $admin_config["webp_select"] == 1) {
				$row["thumb"]="./img/profile/{$row["cast"]}/{$row["img"]}_s.webp";

			}else{
				$row["thumb"]="./img/profile/{$row["cast"]}/{$row["img"]}_s.png";
			}

		}else{
			$row["thumb"]="./img/blog_no_image.png";
		}

		$post_log[]=$row;
	}
}
include_once('./header.php');
?>
	<nav class="head_in">
		<ul id="menu-main" class="menu">
			<li id="menu0" class="menu_item">Top</li>
			<li id="menu1" class="menu_item">Event</li>
			<li id="menu2" class="menu_item">Cast</li>
			<li id="menu3" class="menu_item">Sytem</li>
			<li id="menu4" class="menu_item">Info</li>
			<li id="menu5" class="menu_item">Access</li>
			<li id="menu6" class="menu_item">Recruit</li>
		</ul>
	</nav>
</header>
<div class="main">
<style>
#slide_img0{
	left			:0;
	z-index			:1;
}

#slide_img1{
	z-index			:2;
}
</style>
<script>
var Cnt=<?=$count_event?>;
var NewCnt=1;
</script>
<form id="form_1" method="get" action="">
<input id="s_code" type="hidden" name="post_id">
</form>
<script src="./js/index.js?t=5"></script>

<section id="box_0" class="main_top">
<?if($count_event==1){?>
	<div class="slide">
		<div class="slide_img">
			<?if($event[0]["link"]){?>
			<a href="<?=$event[0]["link"]?>?post_id=<?=$event[0]["code"]?>">
				<img src="<?=$event[0]["img"]?>" class="top_img_in" alt="<?=$event[0]["title"]?>">;
			</a>
			<?}else{?>
				<img src="<?=$event[0]["img"]?>" class="top_img_in" alt="<?=$event[0]["title"]?>">;
			<?}?>
		</div>
	</div>

<?}elseif($count_event >1){?>
	<div class="slide">
		<div class="slide_img">
			<?for($n=0;$n<$count_event;$n++){?>
				<div id="slide_img<?=$n?>" s_link="<?=$event[$n]["link"]?>" s_code="<?=$event[$n]["code"]?>" class="top_img">
				<img src="<?=$event[$n]["img"]?>" class="top_img_in" alt="<?=$event[$n]["title"]?>">;
				</div>
			<?}?>	
			<div class="slide_img_cv"></div>
		</div>

		<span class="slide_point">
			<?for($n=0;$n<$count_event;$n++){?>
				<div id="dot<?=$n?>" class="slide_dot<?if($n == 0){?> dot_on<?}?>"></div>
			<?}?>
		</span>
	</div>
<?}?>

	<?if($top_comm){?>
	<article class="top_comm">
		<div class="top_comm_in">
			<h2 class="top_comm_title"><?=$top_comm["title"]?></h2>
			<p class="top_comm_log"><?=str_replace("\n","<br>",$top_comm["contents"])?></p>
		</div>
	</article>
	<?}?>


	<article id="box_1" class="box_0 box_back" style="justify-content:center;">
		<h2 class="box_title">
		<span class="title_main">EVENT</span>
		<span class="title_sub">イベント</span>
		<span class="title_0">
		<span class="title_u1"></span>
		<span class="title_u2"></span>
		<span class="title_d"></span>
		<span class="title_1"></span>
		<span class="title_2"></span>
		<span class="title_3"></span>
		<span class="title_4"></span>
		<span class="title_5"></span>
		<span class="title_6"></span>
		<span class="title_7"></span>
		<span class="title_8"></span>
		</span>
		</h2>

		<div class="box_1_in">		
		<?for($n=0;$n<count($post_log);$n++){?>
			<a href="./article.php?post_id=<?=$post_log[$n]["id"]?>" class="main_a">
				<div class="main_a_img_out"><img src="<?=$post_log[$n]["thumb"]?>" class="main_a_img"></div>
				<div class="main_a_comm">
				<div class="main_a_title"><?=$post_log[$n]["title"]?></div>
				<div class="main_a_date"><?=$post_log[$n]["date"]?></div>
				</div>
				<div class="main_al_0">
				<div class="main_al_1"></div>
				<div class="main_al_2"></div>
				<div class="main_al_3"></div>
				</div>
			</a>
		<?}?>
		</div>

		<a href="castblog.php" class="main_a_more">More</a>
	</article>

	<article id="box_2" class="box_0">
		<h2 class="box_title">
		<span class="title_main">CAST</span>
		<span class="title_sub">キャスト</span>
		<span class="title_0">
		<span class="title_u1"></span>
		<span class="title_u2"></span>
		<span class="title_d"></span>
		<span class="title_1"></span>
		<span class="title_2"></span>
		<span class="title_3"></span>
		<span class="title_4"></span>
		<span class="title_5"></span>
		<span class="title_6"></span>
		<span class="title_7"></span>
		<span class="title_8"></span>
		</span>
		</h2>
		<div class="box_2_in">
			<?if(is_array($cast_dat)){?>
				<? foreach($cast_dat as $b1 => $b2){?>
					<a href="./person.php?post_id=<?=$b2["id"]?>" id="i<?=$b1?>" class="main_b_1">
						<div class="main_b_1_1" style="background-image:url('<?=$b2["face"]?>')"></div>
						<span class="main_b_1_2_name"><?=$b2["genji"]?></span>
						<?if($b2["ribbon_name"]){?>
							<span class="main_b_1_ribbon">
								<span class="main_b_1_ribbon_2" style="border-color:<?=$b2["ribbon_c1"]?>;border-left-color:transparent;"></span>
								<span class="main_b_1_ribbon_3" style="border-color:<?=$b2["ribbon_c1"]?>;border-right-color:transparent;"></span>
								<span class="main_b_1_ribbon_4"></span>
								<span class="main_b_1_ribbon_5"></span>
								<span class="main_b_1_ribbon_0" style="background:linear-gradient(<?=$b2["ribbon_c1"]?>,<?=$b2["ribbon_c2"]?>)"></span>
								<span class="main_b_1_ribbon_1"><?=$b2["ribbon_name"]?></span>
							</span>
						<?}?>
					</a>
				<? } ?>
				<a href="cast.php" class="main_a_more">More</a>

			<? }else{ ?>
				<span class="no_blog">キャスト情報はありません</span>
			<? } ?>
		</div>
	</article>

<?if($dat_system["contents"]){?>
	<article id="box_3" class="box_0 box_back">
		<h2 class="box_title">
		<span class="title_main">SYSTEM</span>
		<span class="title_sub">システム</span>
		<span class="title_0">
		<span class="title_u1"></span>
		<span class="title_u2"></span>
		<span class="title_d"></span>
		<span class="title_1"></span>
		<span class="title_2"></span>
		<span class="title_3"></span>
		<span class="title_4"></span>
		<span class="title_5"></span>
		<span class="title_6"></span>
		<span class="title_7"></span>
		<span class="title_8"></span>
		</span>
		</h2>
		<div class="main_e">
			<div class="main_e_in">
				<span class="main_e_f c_tr"></span>
				<span class="main_e_f c_tl"></span>
				<span class="main_e_f c_br"></span>
				<span class="main_e_f c_bl"></span>
				<div class="corner_in box_in_1"></div>
				<div class="corner_in box_in_2"></div>
				<div class="corner_in box_in_3"></div>
				<div class="corner_in box_in_4"></div>

				<span class="sys_box_ttl"><?=$dat_system["title"]?></span><br>
				<span class="sys_box_log"><?=$dat_system["contents"]?></span><br>
			</div>
			<div class="corner box_1"></div>
			<div class="corner box_2"></div>
			<div class="corner box_3"></div>
			<div class="corner box_4"></div>
		</div>
	</article>
<?}?>
	<article id="box_4" class="box_0">
		<h2 class="box_title">
		<span class="title_main">InfoMation</span>
		<span class="title_sub">お知らせ</span>
		<span class="title_0">
		<span class="title_u1"></span>
		<span class="title_u2"></span>
		<span class="title_d"></span>
		<span class="title_1"></span>
		<span class="title_2"></span>
		<span class="title_3"></span>
		<span class="title_4"></span>
		<span class="title_5"></span>
		<span class="title_6"></span>
		<span class="title_7"></span>
		<span class="title_8"></span>
		</span>
		</h2>

		<div class="main_b">
			<?if($count_news){?>
			<h2 class="main_b_title">新着情報</h2>

	 		<div class="main_b_top">
				<?for($n=0;$n<$count_news;$n++){?>
					<?if($news[$n]["category"]){?>
						<table class="main_b_notice <?=$news[$n]["caution"]?>">
						<tr>
							<td  class="main_b_td_1">
								<span class="main_b_notice_date"><?=$news[$n]["date"]?></span>
								<span class="main_b_notice_tag" style="background:<?=$news[$n]["tag_icon"]?>"><?=$news[$n]["tag_name"]?></span>
							</td>

							<td  class="main_b_td_2">
								<a href="<?=$news[$n]["news_link"]?>" class="main_b_notice_link">
									<span class="main_b_notice_title"><?=$news[$n]["title"]?></span>
								</a>
							</td>
							<td class="main_b_td_3"><a href="<?=$news[$n]["news_link"]?>" class="main_b_notice_arrow">	</a></td>
						</tr>
						</table>

					<?}else{?>
						<table class="main_b_notice <?=$news[$n]["caution"]?>">
							<tr>
								<td  class="main_b_td_1">
									<span class="main_b_notice_date"><?=$news[$n]["date"]?></span>
									<span class="main_b_notice_tag" style="background:<?=$news[$n]["tag_icon"]?>"><?=$news[$n]["tag_name"]?></span>
								</td>
								<td  class="main_b_td_2">
									<span class="main_b_notice_title"><?=$news[$n]["title"]?></span>
								</td>
							</tr>
						</table>
					<?}?>
				<?}?>
			</div>
				<a href="news_list.php" class="main_a_more">More</a>

			<?}?>
			<div class="info_box">
				<?for($n=0;$n<$info_count;$n++){?>
					<?if($info[$n]["link"]){?>
						<a href="<?=$info[$n]["link"]?>" class="info_img_out">
							<img src="<?=$info[$n]["img"]?>" class="info_img">
						</a>
					<?}else{?>	
						<span class="info_img_out2">
							<img src="<?=$info[$n]["img"]?>" class="info_img">
						</span>
					<?}?>
				<?}?>
			</div>
		</div>

		<div class="main_c">
			<?if($admin_config["twitter_view"]==1 && $admin_config["twitter"]){?>
				<div class="twitter_title" style="text-align:center">◆　twitter　◆</div>
				<div class="twitter_tl"><a class="twitter-timeline" data-width="370" data-height="600" data-theme="dark" data-chrome="noscrollbar,transparent,noheader,nofooter" style="width:100%" href="https://twitter.com/<?=$admin_config["twitter"]?>?ref_src=twsrc%5Etfw">Tweets by serra_geddon</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
				</div>
				<div class="twitter_foot"><a href="https://twitter.com/<?=$admin_config["twitter"]?>" class="twitter_foot_in"><span class="twitter_icon"></span>フォローする</a></div>
			<?}?>
		</div>
	</article>

<?if($dat_access){?>
	<article id="box_5" class="box_0 box_back">
		<h2 class="box_title">
		<span class="title_main">ACCESS</span>
		<span class="title_sub">アクセス</span>
		<span class="title_0">
		<span class="title_u1"></span>
		<span class="title_u2"></span>
		<span class="title_d"></span>
		<span class="title_1"></span>
		<span class="title_2"></span>
		<span class="title_3"></span>
		<span class="title_4"></span>
		<span class="title_5"></span>
		<span class="title_6"></span>
		<span class="title_7"></span>
		<span class="title_8"></span>
		</span>
		</h2>
		<div class="access_table">
			<div class="access_map">
				<iframe src="<?=trim($dat_access["contents_key"])?>" width="600" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0" class="access_map_in"></iframe>
			</div>
			<div class="access_sig"><?=trim($dat_access["contents"])?></div>
		</div>
	</article>
<?}?>

<?if($dat_access){?>
	<article id="box_6" class="box_0">
		<h2 class="box_title">
		<span class="title_main">RECRUIT</span>
		<span class="title_sub">求人情報</span>
		<span class="title_0">
		<span class="title_u1"></span>
		<span class="title_u2"></span>
		<span class="title_d"></span>
		<span class="title_1"></span>
		<span class="title_2"></span>
		<span class="title_3"></span>
		<span class="title_4"></span>
		<span class="title_5"></span>
		<span class="title_6"></span>
		<span class="title_7"></span>
		<span class="title_8"></span>
		</span>
		</h2>
		<?if (file_exists("./img/page/contents/recruit_top.webp") && $admin_config["webp_select"] == 1) {?>
			<img src="./img/page/contents/recruit_top.webp?t=<?=$dat_config["top"]["prm"]?>" class="rec_img" alt="求人募集">

		<?}elseif (file_exists("./img/page/contents/recruit_top.jpg")) {?>
			<img src="./img/page/contents/recruit_top.jpg?t=<?=$dat_config["top"]["prm"]?>" class="rec_img" alt="求人募集">

		<?}elseif (file_exists("./img/page/contents/recruit_top.png")) {?>
			<img src="./img/page/contents/recruit_top.png?t=<?=$dat_config["top"]["prm"]?>" class="rec_img" alt="求人募集">

		<?}else{?>
		<?}?>

		<div class="main_e">
			<div class="main_e_in">
				<span class="main_e_f c_tr"></span>
				<span class="main_e_f c_tl"></span>
				<span class="main_e_f c_br"></span>
				<span class="main_e_f c_bl"></span>
				<div class="corner_in box_in_1"></div>
				<div class="corner_in box_in_2"></div>
				<div class="corner_in box_in_3"></div>
				<div class="corner_in box_in_4"></div>

				<span class="sys_box_ttl"><?=$dat_recruit["top"]["title"]?></span><br>
				<span class="sys_box_log"><?=$dat_recruit["top"]["contents"]?></span><br>
			</div>
			<div class="corner box_1"></div>
			<div class="corner box_2"></div>
			<div class="corner box_3"></div>
			<div class="corner box_4"></div>
		</div>

		<?foreach($dat_list as $a2){?>
			<div class="rec">
				<div class="rec_l"><?=$a2["title"]?></div>
				<div class="rec_r"><?=$a2["contents"]?></div>
			</div>
		<?}?>

		<div class="contact_box">
			<?if($dat_recruit["tel"]["contents_key"]){?>
				<?$dat_recruit["tel"]["contents_key"]=str_replace("-","<span>-</span>",$dat_recruit["tel"]["contents_key"])?>
				<div class="recruit_contact r_tel">
					<span class="contact_icon"></span>
					<span class="contact_comm">電話</span>
					<span class="contact_no"><?=$dat_recruit["tel"]["contents_key"]?></span>
				</div>
			<?}?>

			<?if($dat_recruit["line"]["contents_key"]){?>
				<div class="recruit_contact r_line">
					<span class="contact_icon"></span>
					<span class="contact_comm">LINE</span>
					<span class="contact_no"><?=$dat_recruit["line"]["contents_key"]?></span>
				</div>
			<?}?>
		</div>
		<?=$form_dat?>
		<div class="recruit_pop">
			<div class="recruit_pop_in"><?=$form_p?></div>
			<div class="recruit_pop_in2">
				送信しました。<br>
				折り返し担当スタッフより連絡致します。<br>
			</div>
		</div>
	</article>
<?}?>
</section>
<?include_once('./footer.php'); ?>
