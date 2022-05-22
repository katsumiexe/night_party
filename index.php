<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-Party</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="./z_js/main.js?t=<?=time()?>"></script>

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
	position	:fixed;
	top			:0;
	left		:0;
	right		:0;
	margin		:auto;
	height		:40px;
	z-index		:10;
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

#block_6{
	z-index:7;
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
	position			:relative;
	margin				:0 auto;
	display				:flex;
	width				:170vh;
	height				:90vh;
	padding-top			:10vh;
	background			:rgba(255,255,255,0.6);
	justify-content		:space-between
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

.box_top{
	position		:fixed;
	top				:0;
	left			:0;
	right			:0;
	margin			:auto;
	display			:block;
	width			:170vh;
	height			:100vh;
	background		:rgba(255,255,255,0.5);
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
	border			:1vh solid #60a0f0;
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
	border			:1vh solid #60a0f0;
	border-radius	:2vh;
	opacity			:0;
}

.box_item{
	position		:absolute;
	width			:57vh;
	padding			:0;
	height			:25vh;
	transform		:rotate(-15deg);
	opacity			:0;
	transform-origin:top right;
}

.box_item_in{
	position		:absolute;
	top				:1vh;
	left			:1vh;
	right			:1vh;
	bottom			:1vh;
	margin			:auto;
	width			:53vh;
	height			:21vh;
	border			:1vh solid #60a0f0;
	padding			:0;
	background		:linear-gradient(#fffafa,#fff0f0);
	background		:#fafafa;
	text-align		:left;
	color			:#202020;
}


.box_item_title{
	position		:relative;
	background		:#e8f0ff;
	color			:#0000c0;
	font-weight		:800;
	font-size		:2.5vh;
	height			:5vh;
	line-height		:5vh;
	margin			:0 auto;
	padding-left	:2vh;
	font-weight		:700;
}

.box_item_p{
	dispaly			:block;
	position		:relative;
	height			:12.5vh;
	width			:50vh;	
	font-size		:2vh;
	line-height		:3.2vh;
	padding			:1vh;
	margin			:0 auto;
	color			:#303030;
}

.box_s{
	position		:absolute;
	bottom			:0vh;
	left			:2vh;
	font-size		:1.8vh;
	line-height		:2.5vh;
	color			:#4040600;
}

.box_item_icon{
	display			:inline-block;
	position		:absolute;
	top				:0;
	bottom			:0;
	right			:1vh;
	margin			:auto;
	font-size		:2vh;
	height			:3.5vh;
	line-height		:3.3vh;
	width			:12vh;
	background		:#a0c0ff;
	border			:0.2vh solid #ffffff;
	color			:#ffffff;
	text-align		:left;
	padding			:0 0 0 0.5vh;
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

	border-bottom	:2px solid #ffffff;
	border-right	:2px solid #ffffff;
	transform		:rotate(-45deg);
}


#block_4 .box_flex_left, #block_4 .box_flex_right, #block_4 .box_item_in{
	border			:1vh solid #ffc0e0;
}

#block_4 .box_item_title{
	background		:#ffe8f0;
	color			:#c00000;
}


#block_4 .box_item_icon{
	background		:#ffa0c0;
}

.box_item2{
	margin			:1.5vh;
	width			:39vh;
	height			:40vh
	font-size		:2vh;
	line-height		:3vh;
	color			:#303030;	
}

.box_item2_img{
	position		:absolute;
	bottom			:1vh;
	right			:0;
	left			:0;
	margin			:auto;
	width			:38vh;
}

.box_1_0{
	margin			:4vh auto 2.5vh auto;
	width			:135vh;
	padding			:1.5vh;
	background		:linear-gradient(135deg,#fafafa,#eaeaea);
	background		:#fcfcfc;
	height			:18vh;
	line-height		:4.5vh;
	text-align		:left;
	color			:#384240;
	font-size		:2.5vh;
	border-bottom	:3px solid #c00000;
	opacity			:0;
}

.box_1_0_title{
	font-weight	:800; 
	font-size	:2.5vh;
}
.border{
	padding			:0 0.5vh;
	font-weight		:700;
	background		:linear-gradient(transparent 50%, #f0f030 50%,#f0f030 100%);
}

#box_item_1{
	left			:3vh;
}

#box_item_2{
	left			:58.5vh;
}

#box_item_3{
	left			:114vh;
}

.box_1_1{
	position		:absolute;
	top				:67vh;
	width			:53vh;
	padding			:0;
	height			:30vh;
}

.box_1_1_text{
	position		:absolute;
	top				:9.5vh;
	left			:0;
	width			:49vh;
	border			:1vh solid #FE7F9C;
	border-radius	:2vh;
	background		:#fafafa;
	height			:16vh;
	line-height		:2.7vh;
	text-align		:left;
	color			:#202020;
	font-size		:2vh;
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
	left			:0;
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
	top				:-102vh;
}

#ball2{
	left			:-54.5vh;
	top				:-91vh;
}

#ball3{
	left			:-110vh;
	top				:-80vh;
}

.box_2_0{
	display			:flex;
	justify-content	:space-between;
	margin			:10vh auto 1vh auto;
	width			:160vh;
	padding			:0;
	height			:50vh;
}

.box_2_1{
	position		:relative;
	width			:46vh;
	padding			:0;
	height			:46vh;
	border			:2vh solid #e0c0f0;
	border-radius	:3vh;
	line-height		:3vh;
	text-align		:left;
	color			:#384240;
	font-size		:2.1vh;
	background		:linear-gradient(135deg,#e0e8f0,#d0d8e0);
}

.box_2_1_text{
	position		:absolute;
	bottom			:2vh;
	left			:0;
	right			:0;
	margin			:auto;	
	width			:40vh;
	padding			:0;
	height			:18vh;
	border			:1px solid #303030;
	border-radius	:5px;
	line-height		:3vh;
	text-align		:left;
	color			:#384240;
	font-size		:2vh;
	padding			:1.5vh 1vh 1vh 1.5vh;
	background		:#f0f0f0;

	box-shadow		:0.2vh 0.2vh 0.5vh rgba(30,30,30,0.4) inset;

}


.comm_p{
	width			:53vh;
	margin			:0 auto;
	padding			:0.5vh 0.5vh 1vh 0.5vh;
	text-align		:left;
	line-height		:2.7vh;
	font-size		:1.8vh;
	color			:#101520;
}

.box_4_left{
	position			:relative;
	margin				:1vh auto;
	display				:flex;
	flex-wrap			:wrap;
	width				:111vh;
	flex-basis			:111vh;
	justify-content		:flex-start;
	align-items			:flex-start;
	align-content		:flex-start;
}

.box_4_right{
	position			:relative;
	margin				:1vh auto;
	flex-wrap			:wrap;
	display				:flex;
	width				:55vh;
	flex-basis			:55vh;
	justify-content		:flex-start;
	align-items			:flex-start;
	align-content		:flex-start;
}



.box_4_title{
	position		:relative;
	margin			:0 auto 1vh auto;
	width			:111vh;
	height			:6vh;
	line-height		:7vh;
	border-bottom	:0.5vh solid #202020;
	font-size		:3.5vh;
	font-weight		:700;
	color			:#101520;
	text-align		:left;
}


.box_4_title_s{
	display			:inline-block;
	margin			:0 0.5vh;
	height			:6vh;
	line-height		:9vh;
	font-size		:2vh;
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

.box_4_0_title{
	position		:relative;
	margin			:1vh auto;
	width			:110vh;
	flex-basis		:110vh;
	text-align		:left;
	font-size		:2.5vh;
	font-weight		:700;
	height			:4.5vh;
	line-height		:5.5vh;
	border-bottom	:1px solid #101010;
}


.box_4_1{
	position		:relative;
	margin			:1vh;
	width			:53vh;
	flex-basis		:53vh;
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

.box_4_1_title_s{
	margin			:0;
	text-align		:left;
	font-size		:1.8vh;
	height			:3.5vh;
	line-height		:4vh;
}

.box_4_0_title_p{
	position		:absolute;
	right			:0.5vh;
	bottom			:0vh;
	width			:53vh;
	text-align		:right;
	font-size		:2.8vh;
	font-weight		:700;
		height		:3.5vh;
	line-height		:3.5vh;
	color			:#e00000;
}

.box_4_1_title_p{
	position		:absolute;
	right			:0.5vh;
	bottom			:0vh;
	width			:53vh;
	text-align		:right;
	font-size		:2.2vh;
	font-weight		:700;
	height			:3.5vh;
	line-height		:3.5vh;
	color			:#e00000;
}

.top_comm{
	position	:absolute;
	left		:5vh;
	top			:40vh;
	width		:66vh;
	height		:16vh;
	background	:rgba(240,240,240,0.8);
	padding		:2vh;
}

.top_title{
	font-size	:4vh;
	font-weight	:900;
	text-align	:left;
	margin		:0 0 1vh 0;
	padding		:0; 
}

.top_p{
	font-size	:2.2vh;
	text-align	:left;
	line-height	:3.5vh;
	padding		:0;
	margin		:0;
}


</style>
</head>

<body class="body">
<header id="header">
	<div class="menu">
		<span id="menu0" class="menu_in">TOP</span>
		<span id="menu1" class="menu_in">機能</span>
		<span id="menu2" class="menu_in">サイトサンプル</span>
		<span id="menu3" class="menu_in">CMS</span>
		<span id="menu4" class="menu_in">ヒメカルテ</span>
		<span id="menu5" class="menu_in">お申込み</span>
		<span id="menu6" class="menu_in">お問合せ</span>
	</div>
</header>
<section class="main">
	<article id="block_0" class="box_top">
		<div class="top_comm">
			<h2 class="top_title">管理型CMS「Night-Party」</h2>
			<p class="top_p">
				Night-Partyは、ナイトワークに特化したCMS連動型サイトです。<br>
				キャバクラ、デリヘル、メンズエステ、ガールズバーなど、<br>
				キャストを売り込むタイプの接客業を対象に作られました。<br>
			</p>
		</div>
	</article>

	<article id="block_1" class="box">
		<div class="box_ab">
			<h2 class="h2">定額制サイトの「見えない罠」</h2>
			<div id="block_1_box_1" class="box_1_0">
				<span class="box_1_0_title">そのホームページは「御社」のものですか？</span><br>
				定額制サイトはその所有権が制作会社にあるため、使われている画像やロゴ等を<span class="border">自由に使う事が出来ません。</span><br>
				更新の依頼や修正、イベントバナーの作成に至るまで他社に依頼ができないので<span class="border">必然的に囲いこまれてしまいます。</span><br>
				そんな制作会社が最も力を入れるのは新規顧客の獲得。<span class="border">そのような環境に未来はありますか？</span><br>
			</div>

			<div id="block_1_box_2" class="box_1_0">
				<span class="box_1_0_title">管理は制作会社に任せずにご自身で！</span><br>
				Night-Partyは買い切りシステムですので、<span class="border">完成したその時から全てが御社の所有物になります。</span><br>
				月額管理費がかからない他、サイトの更新や変更の際は、弊社以外の他の制作会社に依頼することも可能です。<br>
				もちろん弊社も末永く使っていただけますよう頑張ります！　<span class="border">切磋琢磨する環境だからこそ良い物が生まれるのです。</span><br>
			</div>

			<div id="box_item_1" class="box_1_1">
				<div id="ball1" class="box_1_ball"><span class="ball_txt">月額料金0円</span><span class="ball_icon"></span></div>
				<p class="box_1_1_text">
				買い切り型のシステムですので毎月の保守費用は0円。また、ホームページ、写真等制作物全ての所有権もお客様のものとなります。<br>
				継続サポートももちろん歓迎です。必要に応じてご依頼くださいませ。
				</p>
			</div>

			<div id="box_item_2" class="box_1_1">
				<div id="ball2" class="box_1_ball"><span class="ball_txt">自動WebP変換</span><span class="ball_icon"></span></div>
				<p class="box_1_1_text">
				次世代画像フォーマット「Webp（ウェッピー）」に標準対応。CMSからも、キャストがアップロードしたものも、全て自動でWebP変換します。<br>
				</p>
			</div>

			<div id="box_item_3" class="box_1_1">
				<div id="ball3" class="box_1_ball"><span class="ball_txt">3段階レスポンシブ</span><span class="ball_icon"></span></div>
				<p class="box_1_1_text">
					パソコン、スマホ対応はもちろんのこと、さらにタブレットも最適化した3段階レスポンシブを採用しています。<br>
					タブレット利用者も増えています。「スマホと同じでいいや」では大事なお客様を逃がしてしまいます。
				</p>
			</div>
		</div>
		<div class="detail"></div>
	</article>

	<article id="block_2" class="box">
		<div class="box_ab">
			<h2 class="h2">サンプルサイト</h2>
			<div class="box_1_0">
				営業形態や地域、対象顧客によって効果的なサイトの形式は千差万別です。<br>
				「Night-Paty」は大きく3種類のテンプレートをご用意させていただいていますが、御社のイメージに合わせた形でカスタマイズさせていただいています。	<br>
			</div>

			<div class="box_2_0">
				<div class="box_2_1">
				<div class="box_2_1_text">
					キャスト情報を前面に出す、オーソドックスなスタイルです。<br>
					ページ構成は複雑になりますが、多くのキャストを表示したい際には最適です。<br>
					キャスト数が多く、入れ替えも頻繁でキャストの露出を増やしていきたい店舗様用です。<br>
				</div>
				</div>

				<div class="box_2_1">
				<div class="box_2_1_text">
					店舗イベントの告知に特化したスタイルです。<br>
					キャストの露出は最小限にし、イベント告知を前面に押し出します。<br>
					キャストの入れ替えが少なく、日替わりでイベントを告知したい店舗様には最適です。<br>
				</div>
				</div>

				<div class="box_2_1">
				<div class="box_2_1_text">
					コンテンツを1ページにまとめたシンプルなスタイルです。<br>
					キャストスケジュール、ブログを廃し、更新関連はスタッフブログがメインとなります。<br>
					キャスト数が少なく、サイトの更新自体を少なめにしたい店舗様用です。<br>
				</div>
				</div>
			</div>
		</div>
	</article>
	<article id="block_3" class="box">
		<div class="box_ab">
			<h2 class="h2">Night-Party CMS</h2>
			<div class="h2_s">　</div>
			<div class="box_flex_left">
				<div id="box_item_a1" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">イベント機能<button id="box_3_icon_1" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
						<p class="box_item_p">
							トップページに表示するイベントを設定できます。イベントはバナーのみかリンク有かの設定できます。<br>
						</p>
					</div>
				</div>

				<div id="box_item_a2" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">ニュース機能<button id="box_3_icon_2" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
						<p class="box_item_p">
							イベント更新、キャストデビューなどが行われた際、自動で更新されます。<br>
							リンクのあり／なしと注目設定が可能です。注目ニュースは日付関係なくTOPに表示されます。
						</p>
					</div>
				</div>

				<div id="box_item_a3" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">キャスト管理<button id="box_3_icon_3" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
						<p class="box_item_p">
							キャストのプロフィールや写真のほか、管理に便利なステータスやキャストの個人情報等も登録できます。
						</p>
					</div>
				</div>

				<div id="box_item_a4" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">シフト管理<button id="box_3_icon_4" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
						<p class="box_item_p">
							キャストのシフトを1週間単位で一覧で表示、変更することができます。<br>
						</p>
					</div>
				</div>

				<div id="box_item_a5" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">ブログ管理<button id="box_3_icon_5" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
						<p class="box_item_p">
							キャストブログ、スタッフブログの投稿、修正、削除、非表示を行えます。
						</p>
					</div>
				</div>

				<div id="box_item_a6" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">お問い合わせ<button id="box_3_icon_6" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
						<p class="box_item_p">
							キャストからの応募メールをCMSで確認することができます。対応日時、履歴も残せますので、誰が見てもわかるようにできます。
						</p>
					</div>
				</div>

			</div>

			<div id="box_right_a" class="box_flex_right">
				<div class="box_item2">
	不要な機能を排除し、シンプルに簡単、便利さを追求しました。<br>
	サイト更新、キャスト管理、応募の確認、全てこれ一つでOKです。<br>
				<img src="./z_img/img2.webp" class="box_item2_img" alt="staff_image">
				</div>
			</div>
		</div>
	</article>


	<article id="block_4" class="box">
		<div class="box_ab">
			<h2 class="h2">キャスト用マイページHIME-Karte</h2>
			<div class="h2_s">　</div>
			<div class="box_flex_left">
				<div id="box_item_b1" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">TOP<button id="box_4_icon_1" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
						<p class="box_item_p">
							スケジュールと「顧客リスト」で登録したお客様の誕生日、本日より3日分が表示されます。<br>
							お店からの連絡事項が表示されます。<br>
						</p>
					</div>
				</div>

				<div id="box_item_b2" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">カレンダー<button id="box_4_icon_2" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
						<p class="box_item_p">
							お客様の誕生日やシフトが表示され、日ごとの個人メモを残すことも可能です。<br>
							シフト提出もここから行えます。<br>
						</p>
					</div>
				</div>

				<div id="box_item_b3" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">顧客リスト<button id="box_4_icon_3" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
						<p class="box_item_p">
							お客様の詳細や、来店履歴、利用金額やバック額を記載できます。<br>
							ランク評価、顔写真投稿、<span class="box_l">グループ分けも可能</span>ですので、わかりやすく管理することができます。<br>
						</p>
					</div>
				</div>

				<div id="box_item_b4" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">EasyTalk<button id="box_4_icon_4" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
						<p class="box_item_p">
							タイムライン仕様のコミュニケーションツールで、キャストは自身のアカウントをお客様に伝えることなく利用できます。<br>
							<span class="box_s">お客様側のメールアドレスが必要です。</span>
						</p>
					</div>
				</div>

				<div id="box_item_b5" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">ブログ<button id="box_4_icon_5" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
						<p class="box_item_p">
							写真付きブログの投稿、編集ができます。<br>
							投稿写真は編集画面でリサイズ、調整、部分マスク等の簡易調整が可能です。<br>
						</p>
					</div>
				</div>

				<div id="box_item_b6" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">アナリティクス<button id="box_4_icon_6" type="button" class="box_item_icon">SAMPLE<span class="al"></span></button></div>
						<p class="box_item_p">
							時給・バックから月の収入目安を算出します。<br>
							バック項目や顧客ごとのランキング表示も可能です。<br>
						</p>
					</div>
				</div>
			</div>

			<div id="box_right_b" class="box_flex_right">
				<div class="box_item2">
				HIME-Karte（ヒメカルテ）は『お客様ノート』と『スケジュール帳』の機能を併せ持つ、サイト連動型のキャスト用マイページです。<br>
				実際働くキャストがどのようなものを望んでいるのか、何に困っているかなど、現場の声を多く集めて作られました。<br>
				キャストに働きやすい環境を提供するのもお店の務めです。HIME-Karteを使う事で普段のルーティーン業務をシステム化し、ミスと負担を減らします。<br>
				<img src="./z_img/img3.webp" class="box_item2_img" alt="cast_image">
				</div>
			</div>
		</div>
	</article>

	<article id="block_5" class="box">
		<div class="box_flex">
			<h2 class="h2">お見積り</h2>
			<div class="h2_s">　</div>
			<div class="box_4_left">
				<div class="box_4_title">基本料金<span class="box_4_title_p">120,000円</span></div>
				<div class="box_4_0_title">Night-partyシステム一式<span class="box_4_0_title_p">50,000円</span></div>
				<div class="box_4_0_title">基本制作費<span class="box_4_0_title_p">70,000円</span></div>

				<div class="box_4_1">
					<div class="box_4_1_title">ページ構成　<span class="box_4_1_title_s">※仕様により変わることがあります</span></div>
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
					<div class="box_4_1_title">その他</div>

					<p class="comm_p">
					専用CMS<br>
					　※パソコン専用のサイトになります
					</p>

					<p class="comm_p">
					HIME-Karte<br>
					　※レスポンシブはパソコン/スマホの二段階になります<br>
					</p>

					<p class="comm_p">
					トップバナー(1200px×480px)1枚<br>
					サイドバナー(600px×150px)1枚<br>
					SSL化<br>
					内部SEO対策<br>
					sitemap.xml<br>
					Google アナリティクス導入<br>
					Google サーチコンソール導入<br>
					Twitterタイムラインの埋め込み<br>
					FAVICON設定<br>
					スタッフデータ入力代行<br>
					</p>
				</div>
			</div>

			<div class="box_4_right">
				<div class="box_4_title" style="width:53vh;flex-basis:53vh;">有料オプション</div>

				<div class="box_4_1">
					<div class="box_4_1_title">レンタルサーバー・ドメイン取得<span class="box_4_1_title_p">10,000円</span></div>
					<p class="comm_p">
						WebP対応、アダルトOKのSSD高速レンタルサーバー、comドメインで手配させていただきます。<br>
						<span style="font-weight:700">初回10カ月分込み</span>。それ以降はサーバー、ドメイン併せて年間で10000円前後かかります。<br>
					</p>

					<div class="box_4_1_title">トップバナー追加(1200px × 480px)<span class="box_4_1_title_p">10,000円</span></div>
					<p class="comm_p">
					2枚目以降はスライド表示となります。<br>
					</p>

					<div class="box_4_1_title">サイドバナー追加(600px × 150px)<span class="box_4_1_title_p">5,000円</span></div>
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
					<div class="box_4_1_title">ロゴ作成<span class="box_4_1_title_p">10,000円</span></div>
					<p class="comm_p">
					1200px × 1200px 単色<br>
					著作権は譲渡致します。サイト以外でもご自由にご利用いただけます。<br>
					</p>
				</div>
			</div>
		</div>
	</article>

	<article id="block_6" class="box">
		<div class="box_flex">
			<h2 class="h2">ご依頼・お問合せ</h2>
			<div class="h2_s">ただいまお問合せ、ご依頼は「Coconara（ココナラ）様にて承っています。</div>

		</div>
	</article>
</section>

<form id="form_box_4" action="./sub/mypage/index.php" method="post" target="_blank">
	<input type="hidden" id="h_box_4" name="prm" value="0">
</form>

<form id="form_box_3" action="./sub/admin/index.php" method="post" target="_blank">
	<input type="hidden" id="h_box_3" name="prm" value="0">
</form>
</body>
</html>
