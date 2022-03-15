<?php
include_once('./library/sql.php');

$sql="SELECT * FROM wp00000_contents WHERE page='access' AND status='0' ORDER BY id DESC LIMIT 1";
$res = mysqli_query($mysqli,$sql);
$dat = mysqli_fetch_assoc($res);
$inc_title="｜当店までのアクセス・連絡先";

include_once('./header.php');

?>

<div class="footmark">
	<a href="./index.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">ACCESS</span>
	</div>
</div>

<?if($dat){?>
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
	<span class="sys_box_ttl"><?=$dat["title"]?></span><br>
	<div class="access_table">
		<div class="access_map">
			<iframe src="<?=trim($dat["contents_key"])?>" width="600" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0" class="access_map_in"></iframe>
		</div>
		<div class="access_sig"><?=trim($dat["contents"])?></div>
	</div>
</div>
<div class="corner box_1"></div>
<div class="corner box_2"></div>
<div class="corner box_3"></div>
<div class="corner box_4"></div>
</div>
</div>
<?}else{?>
<div class="main_e">
<span class="no_info">情報はまだありません</span><br>
</div>
<?}?>
<br>
<?include_once('./footer.php'); ?>
