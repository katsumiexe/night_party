<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-Party</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<style>
html {
  touch-action: manipulation;
}
a{
	text-decoration:none;
	color: initial;
}

.body{
	background		:#000000;
	background		:linear-gradient(90deg,#3a3830 0%, #9a9890 50%, #3a3830 100%);
	margin			:0;
	padding			:0;
	line-height		:1.2;
	color			:#333;
	font-size		:0;
	font-family		:"Hiragino Kaku Gothic ProN","Hiragino Sans",Meiryo,sans-serif;
	text-align		:center;
}

header{
	position		:fixed;
	top				:0;
	left			:0;
	right			:0;
	margin			:auto;
	height			:40px;
	z-index			:10;
}

.main{
	width		:100%;
	height		:200vh;
	font-size	:0;
	text-align	:center;
	margin		:0;
	padding		:0;
	overflow	:hidden;
}

@font-face {
	font-family: at_icon;
	src: url("./z_font/nightparty_icon.ttf") format('truetype');
}

.menu{
	display			:flex;
	display			:none;
	background		:rgba(250,250,250,0.8);
	height			:36px;
	width			:500px;
	margin			:0;
	border-radius	:0 0 20px 0;
	justify-content	:center;
	border-bottom	:2px solid #fe7f9c;
	border-right	:2px solid #fe7f9c;
}

.menu_in{
	display			:block;
	width			:80px;
	flex-basis		:80px;
	height			:20px;
	line-height		:20px;
	text-align		:center;
	font-size		:14px;
	font-weight		:800;
	margin			:8px 0;
	border-right	:1px solid #d0d0d0;
}

#menu6{
	border:none;
}

.box{
	position	:fixed;
	top			:100vh;
	display		:block;
	width		:100vw;
	height		:100vh;
	padding		:0;
	margin		:0 auto;
}

.detail{
	position	:absolute;
	top			:0;
	left		:0;
	right		:0;
	margin		:auto;
	display		:block;
	width		:100%;
	height		:100vh;
	padding		:0;
	margin		:0 auto;
}

#block_0{
	z-index		:1;
	top			:0;
}
#block_1{
	z-index:2;
}

#block_2{
	z-index:3;
}

#block_3{
	z-index:4;
}

#block_4{
	z-index:5;
}

#block_5{
	z-index:6;
}

.h2{
	position		:absolute;
	top				:2vh;
	left			:-2vh;
	width			:70vh;
	height			:7vh;
	line-height		:7vh;
	text-align		:left;
	background		:linear-gradient(#cc0000,#900000);	
	color			:#fafafa;
	font-size		:4vh;
	border-radius	:0.5vh 3vh 3vh 0.5vh;
	margin			:0;
	padding-left 	:1vh;
	box-shadow		:2px 2px 2px rgba(30,30,30,0.6);
}

.h2_s{
	position			:absolute;
	top					:6vh;
	left				:-2vh;
	width				:2.4vh;
	height				:3vh;
	z-index				:-1;
	background			:#101520;	
	transform-origin	:left bottom;
	transform			:rotate(20deg);
}



.box_flex{
	position		:relative;
	margin			:0 auto;
	display			:flex;
	width			:170vh;
	height			:90vh;
	padding-top		:10vh;
	background:		rgba(255,255,255,0.6);
	justify-content:space-between
}

.box_ab{
	position		:relative;
	margin			:0 auto;
	display			:block;
	width			:170vh;
	height			:90vh;
	padding-top		:10vh;
	background:		rgba(255,255,255,0.5);
}

.box_flex_left{
	position		:absolute;
	top				:11vh;
	left			:2vh;
	display			:block;
	flex-wrap		:wrap;
	width			:114vh;
	height			:75vh;
	padding			:1vh;
	background		:#fafafa;
	border			:1vh solid #0060a0;
	border-radius	:2vh;
}

.box_flex_right{
	position		:absolute;
	top				:11vh;
	right			:-20vh;
	display			:block;
	width			:42vh;
	height			:75vh;
	padding			:1vh;
	font-size		:2vh;
	line-height		:2.8vh;
	text-align		:left;
	background		:#fafafa;
	border			:1vh solid #0060a0;
	border-radius	:10px;
	opacity			:0;
}

.box_item{
	position		:absolute;
	width			:53vh;
	border			:1vh solid #0090c0;
	padding			:0;
	background		:linear-gradient(#fffafa,#fff0f0);
	background		:#fafafa;
	height			:21vh;
	text-align		:left;
	color			:#202020;
	margin			:2vh;
	transform		:rotate(-15deg);
	opacity			:0;
	transform-origin:top right;
}


.box_item_title{
	position	:relative;
	background	:#e8f0ff;
	color		:#0000c0;
	font-weight	:800;
	font-size	:2.5vh;
	height		:5vh;
	line-height	:5vh;
	margin		:0 auto;
	padding-left:2vh;
	font-weight	:700;
}

.box_item_p{
	font-size		:2.2vh;
	line-height		:3vh;
	padding			:1vh;
	margin			:0 auto;
}

.box_item_icon{
	display		:inline-block;
	position	:absolute;
	top			:0;
	bottom		:0;
	right		:1vh;
	margin		:auto;
	font-size	:2vh;
	height		:3.5vh;
	line-height	:3.3vh;
	width		:12vh;
	background	:#a0c0ff;
	border		:0.2vh solid #ffffff;
	color		:#ffffff;
	text-align	:left;
	padding		:0 0 0 0.5vh;
}

.al{
	display		:block;
	position	:absolute;
	top			:0;
	bottom		:0;
	right		:1vh;
	margin		:auto;

	height		:0.8vh;
	width		:0.8vh;

	border-bottom:2px solid #ffffff;
	border-right:2px solid #ffffff;
	transform:rotate(-45deg);
}


#block_3 .box_flex_left, #block_3 .box_flex_right, #block_3 .box_item{
	border			:5px solid #ffc0e0;
}


#block_3 .box_item_title{
	background	:#ffe8f0;
	color		:#c00000;
}


#block_3 .box_item_icon{
	background	:#ffa0c0;
}


	position		:absolute;
	top				:11vh;
	left			:2vh;
	display			:block;
	flex-wrap		:wrap;
	width			:114vh;
	height			:75vh;
	padding			:1vh;
	background		:#fafafa;
	border			:1vh solid #0060a0;
	border-radius	:2vh;


$({Deg:-10, Opc:0, Top:20, Lef:5})

#box_item_a1,#box_item_b1{
	top			:150px;
	left		:60px;
}

#box_item_a2,#box_item_b2{
	top			:150px;
	left		:460px;
}

#box_item_a3,#box_item_b3{
	top			:300px;
	left		:60px;
}

#box_item_a4,#box_item_b4{
	top			:300px;
	left		:460px;
}

#box_item_a5,#box_item_b5{
	top			:450px;
	left		:60px;
}

#box_item_a6,#box_item_b6{
	top			:450px;
	left		:460px;
}

.box_item2_img{
	position		:absolute;
	bottom			:1vh;
	right			:0;
	left			:0;
	margin			:auto;
	width			:30vh;
}


#box_item_1{
	left:3vh;

}

#box_item_2{
	left:58.5vh;

}

#box_item_3{
	left:114vh;

}


.box_1_1{
	position		:absolute;
	top				:45.5vh;
	width			:53vh;
	padding			:0;
	height			:45vh;
}

.box_1_1_text{
	position		:absolute;
	top				:9.5vh;
	left			:0;
	width			:49vh;
	border			:1vh solid #FE7F9C;
	border-radius	:2vh;
	background		:#fafafa;
	height			:31vh;
	line-height		:3vh;
	text-align		:left;
	color			:#202020;
	font-size		:2.2vh;
	padding			:1vh;
	margin:0;
}

.box_1_ball{
	position		:absolute;
	width			:49vh;
	height			:9vh;
	color			:#fafafa;
	
}

.ball_txt{
	position		:absolute;
	bottom			:0.5vh;
	left			:0px;
	display			:inline-block;
	width			:42.5vh;
	height			:7.5vh;
	line-height		:7.5vh;
	text-align		:left;
	font-size		:4.5vh;
	font-weight		:800;
	background		:#FE7F9C;
	box-shadow		:3px 3px 5px #e05070;
	border-radius	:1vh;
	overflow		:hidden;
	padding-left	:10vh;
}


.ball_icon{
	font-family		:at_icon;
	height			:8vh;
	line-height		:8vh;
	width			:8vh;
	text-align		:center;
	font-size		:7vh;
	background		:#fafafa;
	border-radius	:1vh;
	position		:absolute;
	bottom			:0.5vh;
	left			:0px;
	border			:0.5vh solid #FE7F9C;
	color			:#FE7F9C;
}

#ball1{
	left			:1vh;
	top				:-88vh;
}

#ball2{
	left			:-54.5vh;
	top				:-77vh;
}

#ball3{
	left			:-110vh;
	top				:-66vh;
}

.comm_p{
	width			:53vh;
	margin			:0 auto;
	padding			:0.5vh 0.5vh 1vh 0.5vh;
	text-align		:left;
	line-height		:2.6vh;
	font-size		:1.8vh;
	color			:#101520;
}

.box_4_title{
	position		:relative;
	margin			:0 auto;
	width			:111vh;
	height			:6vh;
	line-height		:7vh;
	border-bottom	:0.5vh solid #202020;
	margin-bottom	:2vh;
	font-size		:3.5vh;
	font-weight		:700;
	color			:#101520;
	text-align		:left;
}

.box_4_title_p{
	position		:absolute;
	bottom			:0px;
	right			:1vh;
	height			:6vh;
	line-height		:6vh;
	font-size		:4.5vh;
	font-weight		:700;
	color			:#d00000;
	text-align		:right;
}

.box_4_1{
	position		:relative;
	margin			:1vh;
	width			:55vh;
	flex-basis		:55vh;
	text-align		:left;
}

.box_4_1_title{
	position		:relative;
	margin			:1vh auto 0 auto;
	width			:53vh;
	flex-basis		:53vh;
	text-align		:left;
	font-size		:2.2vh;
	font-weight		:700;
	height			:3.5vh;
	line-height		:3.5vh;
	border-bottom	:1px solid #101010;
}

.box_4_1_title_p{
	position		:absolute;
	right			:0.5vh;
	width			:53vh;
	text-align		:right;
	font-size		:16px;
	font-weight		:700;
	height			:24px;
	line-height		:24px;
	color			:#e00000;
}

</style>

<script>
$(function(){ 
	var SC=0;
	var BoxView=0;
	var Lock=0;
	var BgColor=["#f0f0e0","#f0e0ff","#609070","#ffe8f8","#c8b880","#c00020"];

	$(window).on('scroll',function () {

		if(200 < $(this).scrollTop() && BoxView<5 && Lock == 0){//■■↓
			Lock=1;
			BoxView++;

			if(BoxView == 1){
				$('#block_'+BoxView).delay(150).animate({
					"top":"0",
					"background-color":BgColor[BoxView]
				},700,function(){
					Lock=0;
				});
				DownBall();

			}else{
				$('#block_'+BoxView).animate({
					"top":"0",
					"background-color":BgColor[BoxView]
				},600,function(){
					Lock=0;
				});


				if(BoxView == 2){
					$({Deg:-10, Opc:0, Top:20, Lef:5}).animate({Deg:0, Opc:1, Top:0, Lef:0}, {
						duration:800,
						progress:function() {
							$('#box_item_a1').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});


					$({Deg:-10, Opc:0, Top:20, Lef:67}).delay(200).animate({Deg:0, Opc:1, Top:0, Lef:57}, {
						duration:800,
						progress:function() {
							$('#box_item_a2').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});


					$({Deg:-10, Opc:0, Top:45, Lef:5}).delay(200).animate({Deg:0, Opc:1, Top:25, Lef:0}, {
						duration:800,
						progress:function() {
							$('#box_item_a3').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});

					$({Deg:-10, Opc:0, Top:45, Lef:67}).delay(400).animate({Deg:0, Opc:1, Top:25, Lef:57}, {
						duration:800,
						progress:function() {
							$('#box_item_a4').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});

					$({Deg:-10, Opc:0, Top:70, Lef:5}).delay(400).animate({Deg:0, Opc:1, Top:50, Lef:0}, {
						duration:800,
						progress:function() {
							$('#box_item_a5').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});


					$({Deg:-10, Opc:0, Top:70, Lef:67}).delay(600).animate({Deg:0, Opc:1, Top:50, Lef:57}, {
						duration:800,
						progress:function() {
							$('#box_item_a6').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});
					$('#box_right_a').delay(600).animate({"right":"2vh","opacity":"1"},800);
				}

				if(BoxView == 3){
					$({Deg:-10, Opc:0, Top:20, Lef:5}).animate({Deg:0, Opc:1, Top:0, Lef:0}, {
						duration:800,
						progress:function() {
							$('#box_item_b1').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});


					$({Deg:-10, Opc:0, Top:20, Lef:67}).delay(200).animate({Deg:0, Opc:1, Top:0, Lef:57}, {
						duration:800,
						progress:function() {
							$('#box_item_b2').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});


					$({Deg:-10, Opc:0, Top:45, Lef:5}).delay(200).animate({Deg:0, Opc:1, Top:25, Lef:0}, {
						duration:800,
						progress:function() {
							$('#box_item_b3').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});

					$({Deg:-10, Opc:0, Top:45, Lef:67}).delay(400).animate({Deg:0, Opc:1, Top:25, Lef:57}, {
						duration:800,
						progress:function() {
							$('#box_item_b4').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});

					$({Deg:-10, Opc:0, Top:70, Lef:5}).delay(400).animate({Deg:0, Opc:1, Top:50, Lef:0}, {
						duration:800,
						progress:function() {
							$('#box_item_b5').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});


					$({Deg:-10, Opc:0, Top:70, Lef:67}).delay(600).animate({Deg:0, Opc:1, Top:50, Lef:57}, {
						duration:800,
						progress:function() {
							$('#box_item_b6').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});
					$('#box_right_b').delay(600).animate({"right":"2vh","opacity":"1"},800);
				}
			}
		}

		if(200 > $(this).scrollTop() && BoxView>0 && Lock == 0){//■■↑
			Lock=1;

			if(BoxView == 1){
				$('#block_'+BoxView).delay(150).animate({
					"top":"100vh",
					"background-color":"#fafafa"
				},700,function(){
					Lock=0;
					BoxView--;
				});
				UpBall();

			}else{
				$('#block_'+ BoxView).animate({
					"top":"100vh",
					"background-color":"#fafafa"
				},600,function(){
					Lock=0;
					BoxView--;
				});
			}
		}
		$(window).scrollTop(200);
	});

	$(".box_1_ball").on('click',function(){
		if(BoxView == 0){
			Lock=1;
			BoxView++;
			$('#block_'+BoxView).delay(300).animate({
				"top":"0",
				"background-color":BgColor[BoxView]
			},700,function(){
				Lock=0;
			});
			DownBall();

		}else{
			Lock=1;
			$('#block_'+ BoxView).animate({
				"top":"100vh",
				"background-color":"#fafafa"
			},700,function(){
				Lock=0;
				BoxView--;
			});
			UpBall();
		}
	});
});

function UpBall() {
	var VH=$(window).height();
	$(".ball_txt").animate({'width':0,'padding':0},150).delay(700).animate({'width':'42.5vh',"padding-left":'10vh'},150);
	$(".ball_icon").animate({'border-radius':'30px'},150).delay(700).animate({"border-radius":'10px'},150);
	$('#ball1').delay(200).animate({'left':'170vh','top':'-40vh'},400).animate({'left':'1vh','top': "-88vh"},300);
	$('#ball2').delay(200).animate({'left':'170vh','top':'-45vh'},450).animate({'left':'-54.5vh','top':"-77vh"},250);
	$('#ball3').delay(200).animate({'left':'170vh','top':'-50vh'},500).animate({'left':'-110vh','top':"-66vh"},200);
}

function DownBall() {
	$(".ball_txt").animate({'width':0,'padding':0},150).delay(700).animate({'width':'42.5vh',"padding-left":'10vh'},150);
	$(".ball_icon").animate({"border-radius":'5vh'},150).delay(700).animate({"border-radius":'1vh'},150);
	$('#ball1').delay(200).animate({'left':'170vh','top':'-40vh'},400).animate({'left':'0px','top':'0'},300);
	$('#ball2').delay(200).animate({'left':'170vh','top':'-40vh'},450).animate({'left':'0px','top':'0'},250);
	$('#ball3').delay(200).animate({'left':'170vh','top':'-40vh'},500).animate({'left':'0px','top':'0'},200);
}
</script>
</head>
<body class="body">
<header id="header">
	<div class="menu">
		<span id="menu0" class="menu_in">TOP</span>
		<span id="menu1" class="menu_in">機能</span>
		<span id="menu2" class="menu_in">CMS</span>
		<span id="menu3" class="menu_in">ヒメカルテ</span>
		<span id="menu4" class="menu_in">お申込み</span>
		<span id="menu5" class="menu_in">お問合せ</span>
	</div>
</header>
<section class="main">

<article id="block_0" class="box">
<div class="detail"></div>
</article>

<article id="block_1" class="box">
	<div class="box_ab">
		<div id="box_item_0" class="box_1_1"></div>

		<div id="box_item_1" class="box_1_1">
			<div id="ball1" class="box_1_ball"><span class="ball_txt">月額料金0円</span><span class="ball_icon"></span></div>
			<p class="box_1_1_text">
			「Night-Party」買い切り型なので毎月の保守費用はかかりません。ドメイン代、サーバー代のみですので年間6,000円程度と、大幅なコストカットが可能です。<br>
			<span class="box_s">※弊社で用意させていただいた場合</span>
			</p>
		</div>

		<div id="box_item_2" class="box_1_1">
			<div id="ball2" class="box_1_ball"><span class="ball_txt">自動WebP変換</span><span class="ball_icon"></span></div>
			<p class="box_1_1_text">
			Webp（ウェッピー）とはGoogleがWEB用に開発した軽量、高画質の画像フォーマットで、サイトの軽量化、表示の高速化を可能にすることで、SEO対策面では欠かすことができないものです。<br>
			「Night-Party」ではCMSやキャストがアップロードした画像も全て自動でWebPに変換されます。<br>
			<span class="box_s">※使えない環境ではpng/jpegになります。</span>
			</p>
		</div>

		<div id="box_item_3" class="box_1_1">
			<div id="ball3" class="box_1_ball"><span class="ball_txt">3段階レスポンシブ</span><span class="ball_icon"></span></div>
			<p class="box_1_1_text">
				PC/SP対応はもちろんのこと、Night-Partyはさらにタブレットにも対応した3段階レスポンシブを採用しています。
			</p>
		</div>
	</div>
<div class="detail"></div>
</article>

<article id="block_2" class="box">
	<div class="box_ab">
		<h2 class="h2">Night-Party専用CMS</h2>
		<div class="h2_s">　</div>
		<div class="box_flex_left">
			<div id="box_item_a1" class="box_item">
				<div class="box_item_title">バナー設定機能<button id="box_3_icon_1" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
				<p class="box_item_p">
					ページトップに大バナー、ページ脇に小バナーの設定ができます。バナーはそれぞれイベントページへのリンクあり／無を設定ができます。<br>
				</p>
			</div>

			<div id="box_item_a2" class="box_item">
				<div class="box_item_title">ニュース機能<button id="box_3_icon_2" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
				<p class="box_item_p">
					イベント更新、キャストデビューなどが行われた際、自動で更新されます。<br>
					リンクのあり／なしと注目設定が可能です。注目ニュースの設定も可能で、日付関係なくTOPに表示されます。
				</p>
			</div>

			<div id="box_item_a3" class="box_item">
				<div class="box_item_title">キャスト管理<button id="box_3_icon_3" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
				<p class="box_item_p">
					キャストのプロフィールや写真のほか、管理に便利なステータスやキャストの個人情報等も登録できます。
				</p>
			</div>

			<div id="box_item_a4" class="box_item">
				<div class="box_item_title">シフト管理<button id="box_3_icon_4" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
				<p class="box_item_p">
					キャストのシフトを1週間単位で一覧で表示、変更することができます。<br>
					※出勤シフトはHIME-Karteからのセットも可能です。
				</p>
			</div>

			<div id="box_item_a5" class="box_item">
				<div class="box_item_title">ブログ管理<button id="box_3_icon_5" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
				<p class="box_item_p">
					キャストの投稿したブログの修正、削除、写真の非表示を行えます。
				</p>
			</div>

			<div id="box_item_a6" class="box_item">
				<div class="box_item_title">お問い合わせ<button id="box_3_icon_6" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
				<p class="box_item_p">
					キャストからのリクルートメール等を管理で受けられます。処理履歴も残せますので、誰が見てもわかるようにできます。
				</p>
			</div>
		</div>

		<div id="box_right_a" class="box_flex_right">
			<div class="box_item2">
不要な機能を排除し、シンプルに簡単、便利さを追求しました。<br>
サイト更新、キャスト管理、応募の確認、全てこれ一つでOKです。<br>

			<img src="./z_img/img2.webp" class="box_item2_img">
			</div>
		</div>
	</div>
</article>



<article id="block_3" class="box">
	<div class="box_ab">
		<h2 class="h2">キャスト用マイページHIME-Karte</h2>
		<div class="h2_s">　</div>
		<div class="box_flex_left">
			<div id="box_item_b1" class="box_item">
				<div class="box_item_title">TOP<button id="box_4_icon_1" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
				<p class="box_item_p">
					当日、翌日、翌々日の自身のスケジュールと、誕生日のお客様が表示されます。<br>
					また、お店からの連絡が表示されます。<br>
				</p>
			</div>

			<div id="box_item_b2" class="box_item">
				<div class="box_item_title">カレンダー<button id="box_4_icon_2" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
				<p class="box_item_p">
					お客様の誕生日やシフト日などが表示されます。<br>
					また、日ごとの個人メモを残すことも可能です。<br>
					シフト提出もここから行えます。<br>
				</p>
			</div>

			<div id="box_item_b3" class="box_item">
				<div class="box_item_title">顧客リスト<button id="box_4_icon_3" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
				<p class="box_item_p">
					お客様の詳細や、来店履歴、利用金額やバック額を記載できます。<br>
					ランク評価、顔写真投稿、<span class="box_l">グループ分けも可能</span>ですので、わかりやすく管理することができます。<br>
				</p>
			</div>

			<div id="box_item_b4" class="box_item">
				<div class="box_item_title">EasyTalk<button id="box_4_icon_4" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
				<p class="box_item_p">
					タイムライン仕様のコミュニケーションツールで、キャストは自身のアカウントをお客様に伝えることなく利用できます。<br>
					<span class="box_s">お客様側のメールアドレスが必要です。<br></span>
				</p>
			</div>

			<div id="box_item_b5" class="box_item">
				<div class="box_item_title">ブログ<button id="box_4_icon_5" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
				<p class="box_item_p">
					写真付きブログの投稿、編集ができます。<br>
					投稿写真は編集画面でリサイズ、位置補正、部分マスク等の調整も可能です。<br>
				</p>
			</div>

			<div id="box_item_b6" class="box_item">
				<div class="box_item_title">アナリティクス<button id="box_4_icon_6" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
				<p class="box_item_p">
					時給・バックから月の収入目安を算出します。<br>
					バック項目や顧客ごとのランキング表示も可能です。<br>
				</p>
			</div>
		</div>

		<div id="box_right_b" class="box_flex_right">
			<div class="box_item2">
			キャストに働きやすい環境を提供するのもお店の務めです。<br>
			「HIME-Karte（ヒメカルテ）」はお店で働くキャストの声を集められて作られた、サイト連動型のマイページです。<br>
			急なシフトの登録やブログの投稿もHIME-Karteから直接可能<br>、
			顧客管理もシステム化していますので、キャスト、スタッフの負担を大幅に減らせます。<br>
			<img src="./z_img/img3.webp" class="box_item2_img">
			</div>
		</div>
	</div>
</article>

<article id="block_4" class="box">
<div class="box_flex">
<h2 class="h2">お見積り</h2>
<div class="h2_s">　</div>
<div class="box_4_1">
	<div class="box_4_title">Night-Party<span class="box_4_title_p">120,000円</span></div>
	<div class="box_4_1_title">基本ページ構成</div>
	<p class="comm_p">
	▼TOPページ(index.php)<br>
	　┗イベント(event.php)<br>
	　┗ニュース一覧(news_list.php)<br>
	　┗プライバシーポリシー(policy.php)<br>
	</p>
	<p class="comm_p">
	▼システム(system.php)<br>
	</p>
	<p class="comm_p">
	▼キャスト一覧(cast.php)<br>
	　┗キャスト個別(person.php)<br>
	</p>
	<p class="comm_p">
	▼キャストスケジュール(schedule.php)<br>
	</p>
	<p class="comm_p">
	▼ブログ一覧(castblog.php)<br>
	　┗ブログ個別(article.php)<br>
	</p>
	<p class="comm_p">
	▼アクセス(access.php)<br>
	</p>
	<p class="comm_p">
	▼求人(recruit.php)<br>
	</p>
	<p class="comm_p">
	▼EasyTalk(easytalk.php)<br>
	</p>
</div>
<div class="box_4_1">
<div style="height:7.5vh"></div>
	<div class="box_4_1_title">その他</div>

<p class="comm_p">
専用CMS<br>
　※PC専用のサイトになります
</p>

<p class="comm_p">
Hime-karte<br>
　※レスポンシブはPC/SPの二段階になります<br>
</p>

<p class="comm_p">
トップバナー(1200px×480px)1枚<br>
サイドバナー(600px×200px)1枚<br>
SSL化<br>
内部SEO対策<br>
Google アナリティクス導入<br>
Google サーチコンソール導入<br>
Twitterタイムラインの埋め込み<br>
FAVICON設定<br>
スタッフデータ入力代行<br>
</p>
</div>
<div class="box_4_1">
	<div class="box_4_title" style="width:53vh;">有料オプション</div>

<div class="box_4_1_title">レンタルサーバー・ドメイン取得<span class="box_4_1_title_p">10,000円</span></div>
<p class="comm_p">
WebP対応、アダルトOKのSSD高速レンタルサーバー、comドメインで手配させていただきます。<br>
<span style="font-weight:700">初回10カ月分込み</span>。それ以降はサーバー、ドメイン併せて年間で10000円前後かかります。<br>
</p>

<div class="box_4_1_title">トップバナー追加(1200px-480px)<span class="box_4_1_title_p">10,000円</span></div>
<p class="comm_p">
2枚目以降はスライド表示となります。<br>
</p>

<div class="box_4_1_title">サイドバナー追加(600px-200px)<span class="box_4_1_title_p">5,000円</span></div>
<p class="comm_p">
2枚目以降は下に並びます。<br>
</p>

<div class="box_4_1_title">ページ追加<span class="box_4_1_title_p">12,000円～</span></div>
<p class="comm_p">ご相談下さい。</p>

<div class="box_4_1_title">出張撮影<span class="box_4_1_title_p">20,000円</span></div>
<p class="comm_p">
キャスト・お食事・店内撮影など。2時間<br>
お時間、曜日はご相談下さい。場所は東京都・神奈川県・千葉県・埼玉県に限らせていただきます。<br>
撮影した写真の著作権は譲渡致します。サイト以外でもご自由にご利用いただけます。<br>
</p>

<div class="box_4_1_title">ロゴ作成<span class="box_4_1_title_p">20,000円</span></div>
<p class="comm_p">
1200px-1200px 単色<br>
著作権は譲渡致します。サイト以外でもご自由にご利用いただけます。<br>
</p>
</div>
</article>

<article id="block_5" class="box">
	<div class="box_flex">
		<h2 class="h2">お見積り</h2>
		<div class="h2_s">　</div>
	</div>
</article>
</section>
</body>
</html>
