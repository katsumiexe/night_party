<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title>Night-party</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js?t=<?=time()?>"></script>
<script src="./js/main.js?t=<?=time()?>"></script>
<script src="./js/jquery.exif.js?t=<?=time()?>"></script>
<script src="./js/easytalk.js?t=<?=time()?>" defer></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./css/style.css?t=<?=time()?>">
<link rel="stylesheet" href="./css/style_t.css?t=<?=time()?>">
<link rel="stylesheet" href="./css/style_s.css?t=<?=time()?>">
<link rel="stylesheet" href="./css/easytalk_guest.css?t=<?=time()?>">
<script>
const ImgSrc="./img/customer_no_img.jpg?t_<?=time()?>";
const CastId="<?=$ssid["cast_id"]?>";
const CId="<?=$ssid["customer_id"]?>";
var Page=1;
var SS='<?=$ss?>'
</script>

<style>
@font-face {
	font-family: at_icon;
	src: url("./font/nightparty_icon.ttf") format('truetype');
}
@font-face{
	font-family: at_frame;
	src: url("./font/nightparty_frame.ttf") format('truetype');
}

@font-face {
	font-family: at_font1;
	src: url("./font/Courgette-Regular.ttf") format('truetype');
}
</style>

</head>
<body class="body">
<header class="easytalk_head">
	<?if($admin_config["webp_select"] == 1){?>
		<a href="<?=$admin_config["main_url"]?>" class="head_logo"><img src="./img/page/logo/logo_300.webp" class="head_img" alt="店舗ロゴ"></a>
	<?}else{?>
		<a href="<?=$admin_config["main_url"]?>" class="head_logo"><img src="./img/page/logo/logo_300.png" class="head_img" alt="店舗ロゴ"></a>
	<? } ?>
	<table class="head_b_table">
		<tr>
			<td colspan="2" class="head_b_1">
				西武新宿駅徒歩5分　誰もが落ち着ける新スタイルのNew Club</span>
			</td>
		</tr>
		<tr>
			<td class="head_b_2">営業時間</td>
			<td class="head_b_3">19：00～LAST</td>
		</tr>

		<tr>
			<td class="head_b_2">電話番号</td>
			<td class="head_b_3">03<span>-</span>1234<span>-</span>5678</span></td>
		</tr>
	</table>
</header>
<div class="easytalk_main">
