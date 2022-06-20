<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-Party<?=$inc_title?></title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>
<script src="./js/main.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="./css/style_t.css">
<link rel="stylesheet" href="./css/style_s.css">
 
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
<img src="./img/back0.webp" class="back_img" alt="background">
<header class="head">
	<div class="head_b">
		<h1>
		<?if($admin_config["webp_select"] == 1){?>
			<a href="<?=$admin_config["main_url"]?>" class="head_logo"><img src="./img/page/logo/logo_300.webp" class="head_img" alt="西武新宿駅徒歩5分　誰もが落ち着ける新スタイルのNew Club『Night-Party』"></a>
		<?}else{?>
			<a href="<?=$admin_config["main_url"]?>" class="head_logo"><img src="./img/page/logo/logo_300.png" class="head_img" alt="西武新宿駅徒歩5分　誰もが落ち着ける新スタイルのNew Club『Night-Party』"></a>
		<? } ?>
		</h1>
		<table class="head_b_table">
			<tr>
				<td colspan="2" class="head_b_1">
					西武新宿駅徒歩5分　誰もが落ち着ける新スタイルのNew Club
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

		<div class="head_menu">
			<div class="menu_a"></div>
			<div class="menu_b"></div>
			<div class="menu_c"></div>
		</div>
	</div>

	<nav class="head_in">
		<ul id="menu-main" class="menu">
			<li class="menu_item"><a href="./index.php">Top Page</a></li>
			<li class="menu_item"><a href="./system.php">Sytem</a></li>
			<li class="menu_item"><a href="./cast.php">Cast</a></li>
			<li class="menu_item"><a href="./schedule.php">Schedule</a></li>
			<li class="menu_item"><a href="./castblog.php">Blog</a></li>
			<li class="menu_item"><a href="./access.php">Access</a></li>
			<li class="menu_item"><a href="./recruit.php">Recruit</a></li>
		</ul>
		<?if($admin_config["main_tel"]){?>
			<a href="tel:<?=$admin_config["main_tel"]?>" class="head_tel"></a>
		<? } ?>
	</nav>
</header>
<div class="main">
