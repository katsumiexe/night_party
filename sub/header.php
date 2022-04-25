<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-Party<?=$inc_title?></title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js?t=<?=time()?>"></script>
<script src="./js/main.js?t=<?=time()?>"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./css/style.css?t=<?=time()?>">
<link rel="stylesheet" href="./css/style_t.css?t=<?=time()?>">
<link rel="stylesheet" href="./css/style_s.css?t=<?=time()?>">
 
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
<img src="./img/back2.webp" class="back_img">

<header class="head">
	<div class="head_b">
		<div class="head_b_2">営業時間　19：00～LAST</div>
		<h1 class="head_b_1">
			<?if($admin_config["webp_select"] == 1){?>
				<a href="<?=$admin_config["main_url"]?>" class="head_logo"><img src="./img/page/logo/logo_300.webp" class="head_img" alt="Night-Party★誰もが落ち着ける新スタイルのNew Club"></a>
			<?}else{?>
				<a href="<?=$admin_config["main_url"]?>" class="head_logo"><img src="./img/page/logo/logo_300.png" class="head_img" alt="Night-Party★誰もが落ち着ける新スタイルのNew Club"></a>
			<? } ?>
		</h1>
		<div class="head_b_3">電話番号　03<span>-</span>1234<span>-</span>5678</span></div>
	</div>

	<nav class="head_a">
		<ul id="menu-main" class="menu">
			<li class="menu_item"><a href="./index.php">Top Page</a></li>
			<li class="menu_item"><a href="./cast.php">Maid</a></li>
			<li class="menu_item"><a href="./schedule.php">Schedule</a></li>
			<li class="menu_item"><a href="./castblog.php">Event</a></li>
			<li class="menu_item"><a href="./access.php">Access</a></li>
			<li class="menu_item"><a href="./recruit.php">Recruit</a></li>
		</ul>
		<?if($admin_config["main_tel"]){?>
			<a href="tel:<?=$admin_config["main_tel"]?>" class="head_tel"></a>
		<? } ?>
	</nav>
	<div class="head_menu">
		<div class="menu_a"></div>
		<div class="menu_b"></div>
		<div class="menu_c"></div>
	</div>
</header>
<div class="main">
