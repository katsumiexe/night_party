<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</script>

<style>
@font-face {
	font-family: at_icon;
	src: url("./font/font_1/fonts/icomoon.ttf") format('truetype');
}

@font-face {
	font-family: at_frame1;
	src: url("./font/font_3/fonts/icomoon.ttf") format('truetype');
}

@font-face {
	font-family: at_frame2;
	src: url("./font/border/frame2.ttf") format('truetype');
}


@font-face {
	font-family: at_font1;
	src: url("./font/Courgette-Regular.ttf") format('truetype');
}
</style>

</head>
<body class="body">
<header class="easytalk_head">
	<div class="easytalk_head_box">
		<div class="easytalk_head_msg">Easy Talk</div>
		<a href="<?=$admin_config["main_url"]?>"><img src="./img/page/logo/logo_300.png?t=<?=time()?>" class="easytalk_head_logo"></a>
	</div>
</header>
<div class="easytalk_main">
