<?
include_once('./z_library/connect.php');
if($code=="coconala"){
	$keyword="Night-Party,ナイトパーティ,HIME-Karte,ヒメカルテ,メイド喫茶,コンカフェ,ガールズバー,アイドルカフェ,CMS";
	$description="メイド喫茶・アイドルカフェ・コンカフェ・ガールズバーなどキャストによる接客を行う店舗に特化したCMSです。買い切り型のCMSですので月額管理費0円。お客様ノート『HIME-Karte（ヒメカルテ）』との連動し、さらに便利になりました";
	$top_word="Night-Partyは、ナイトワークに特化したCMS連動型サイトです。<br>メイド喫茶、コンカフェ、アイドルカフェ、ガールズバーなど、キャストによる接客を行う店舗を対象に作られました。<br>";
}else{
	$keyword="Night-Party,ナイトパーティ,HIME-Karte,ヒメカルテ,キャバクラ,風俗,セクキャバ,コンカフェ,CMS";
	$description="キャバクラ・ガールズバー・セクキャバ・コンカフェ・ホストクラブなど水商売に特化したCMSです。買い切り型のCMSですので月額管理費0円。お客様ノート『HIME-Karte（ヒメカルテ）』との連動し、さらに便利になりました";
	$top_word="Night-Partyは、ナイトワークに特化したCMS連動型サイトです。<br>キャバクラ、デリヘル、メンズエステ、ガールズバーなど、キャストによる接客を行う店舗を対象に作られました。<br>";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="keywords" content="<?=$keyword?>">
<meta name="description" content="<?=$description?>">
<meta name="author" content="Katsumi">
<meta name="copyright" content="copyright 2022 NightParty all right reserved.">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="robots" content="max-image-preview:large">

<meta property="fb:app_id" content="">
<meta property="og:locale" content="ja_JP">
<meta property="og:image" content="https://night-party.com/z_img/top.jpg">
<meta property="og:title" content="Night-Party|ナイトパーティ">
<meta property="og:type" content="website">
<meta property="og:url" content="https://night-party.com/">
<meta property="og:site_name" content="Night-Party">
<meta property="og:description" content="<?=$description?>">

<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@serra_geddon">
<title>NightParty『ナイトパーティ』ナイトワーク向け高性能CMS</title>

<link rel="canonical" href="https://night-party.com/">
<link rel="icon" href="z_img/fav.png">
<link rel="apple-touch-icon" href="z_img/fav.png">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="./z_css/style.css">
<link rel="stylesheet" href="./z_css/style_s.css">
<style></style>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-3LMPEPRX6G"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-3LMPEPRX6G');
</script>
<script src="./z_js/main.js"></script>
<script src="./z_js/main_s.js"></script>
</head>
<body class="body">
<header id="header">
	<div class="menu">
		<span id="menu0" class="menu_in">TOP</span>
		<span id="menu1" class="menu_in">機能</span>
		<span id="menu2" class="menu_in">サイトサンプル</span>
		<span id="menu3" class="menu_in">CMS</span>
		<span id="menu4" class="menu_in">HIME-Karte</span>
		<span id="menu5" class="menu_in">お見積もり</span>
		<span id="menu6" class="menu_in">お申込み</span>
	</div>
</header>

<section class="main">
<img src="./z_img/top_0.webp" class="top_0" alt="top写真0">
<img src="./z_img/top_1.png" class="top_1" alt="top写真1">
	<article id="block_0" class="box_top">
		<div class="top_comm">
			<h2 class="top_title">Night-Party</h2>
			<p class="top_p"><?=$top_word?></p>
		</div>
	</article>

	<article id="block_1" class="box">
		<div class="box_ab">
			<h2 class="h2">定額制サイトの「見えない罠」</h2>
			<div class="h2_s">　</div>
			<div id="block_1_box_0" class="box_1">
				<div id="block_1_box_1" class="box_1_0">
					<span class="box_1_0_title">そのホームページは「御社」のものですか？</span><br>
					定額制サイトはその所有権が制作会社にあるため、使われている画像やロゴ等を<span class="border">自由に使う事が出来ません。</span><br>
					更新や修正、イベントバナーの作成に至るまで他社に依頼ができないので<span class="border">必然的に囲いこまれてしまいます。</span><br>
					そんな制作会社が最も力を入れるのは新規顧客の獲得。<span class="border">そのような環境に未来はありますか？</span><br>
				</div>

				<div id="block_1_box_2" class="box_1_0">
					<span class="box_1_0_title">管理は制作会社に任せずにご自身で！</span><br>
					Night-Partyは買い切りシステムですので、<span class="border">完成したその時から全てが御社の所有物になります。</span><br>
					月額管理費がかからない他、サイトの更新や変更を弊社以外の他の制作会社に依頼することも可能です。<br>
					もちろん弊社も末永く使っていただけますよう頑張ります！　<span class="border">切磋琢磨する環境だからこそ良い物が生まれるのです。</span><br>
				</div>
				<img src="./z_img/img1.webp" class="box_item1_img" alt="staff_image">
			</div>
			

			<div class="box_1_2">Night-Party 3つのポイント</div>
			<div id="box_item_1" class="box_1_1">
				<p class="box_1_1_text">
				買い切り型ですので毎月の保守費用は0円。ホームページ、写真等制作物全ての所有権もお客様のものとなります。<br>
				継続サポートももちろん歓迎です。必要に応じてご依頼くださいませ。
				</p>
			</div>

			<div id="box_item_2" class="box_1_1">
				<p class="box_1_1_text">
				次世代画像フォーマット「Webp（ウェッピー）」に標準対応。キャストがスマホからアップロードしたブログ用の写真も全て自動でWebP変換します。<br>
				</p>
			</div>

			<div id="box_item_3" class="box_1_1">
				<p class="box_1_1_text">
					パソコン、スマホ対応はもちろんのこと、さらにタブレットも最適化した3段階レスポンシブを採用しています。<br>
					タブレット利用者も増えています。「スマホと同じでいいや」では大事なお客様を逃がしてしまいます。
				</p>
			</div>
			<div class="box_1_out">
				<div id="ball1" class="box_1_ball"><span class="ball_txt">月額料金0円</span><span class="ball_icon"></span></div>
				<div id="ball2" class="box_1_ball"><span class="ball_txt">自動WebP変換</span><span class="ball_icon"></span></div>
				<div id="ball3" class="box_1_ball"><span class="ball_txt">3段階レスポンシブ</span><span class="ball_icon"></span></div>
			</div>
		</div>
	</article>

	<article id="block_2" class="box">
		<div class="box_ab">
			<h2 class="h2">サンプルサイト</h2>
			<div class="h2_s">　</div>
			<div id="block_2_box_0" class="box_2">
			<div class="box_2_0">
				「Night-Paty」は大きく2種類のテーマをご用意させていただきました。ここからお店の形態やイメージに合わせてカスタマイズさせていただきます。<br>
				同じデザインを他店舗で使用することはありませんのでオリジナリティを出すことができます。<br>
				完全オリジナルデザインも大歓迎です。担当にお客様のイメージをお伝えくださいませ。<br>
			</div>
				<img src="./z_img/img0.webp" class="box_item1_img" alt="staff_image">
			</div>

			<div class="box_2_flex">
				<a href="./sample2" target="_BLANK" id="block_2_box_1" class="box_2_1">
					<img src="./z_img/mock_1.webp" class="box_2_1_img" alt="mock_image">
					<div class="box_2_1_title">テーマ01:コーマ</div>
					<div class="box_2_1_text">
						コンテンツを1ページにまとめたスタイルです。<br>
						スケジュール、ブログを廃し、更新関連はスタッフブログがメインとなります。<br>
						キャスト数が少なく、サイトの更新自体を少なめにしたい店舗様用です。<br>
					</div>
				</a>
				<a href="./sample1" target="_BLANK" id="block_2_box_2" class="box_2_1">
					<img src="./z_img/mock_2.webp" class="box_2_1_img" alt="mock_image">
					<div class="box_2_1_title">テーマ02:ソワレ</div>

					<div class="box_2_1_text">
						キャスト情報を前面に出す、オーソドックスなスタイルです。<br>
						スケジュールや写真ブログでキャストの露出を高めてアピールします。<br>
						キャスト数が多く、入れ替えも頻繁な店舗様用です。<br>
					</div>
				</a>

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
						<div class="box_item_title">ページ管理
							<span id="box_3_icon_1" class="box_item_icon pc_only">
								<span class="box_item_icon_1"></span>
								<span class="box_item_icon_2"></span>
							</span>
						</div>

						<p class="box_item_p">
							バナーやニュース、トップあいさつ等の管理、アクセス、リクルート、プライバシーポリシーなどの固定ページの更新がここからできます。
						</p>
					</div>
				</div>

				<div id="box_item_a2" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">コンフィグ
							<span id="box_3_icon_2" class="box_item_icon pc_only">
								<span class="box_item_icon_1"></span>
								<span class="box_item_icon_2"></span>
							</span>
						</div>

						<p class="box_item_p">
							サイトの表示に関することや、キャストのプロフィール項目などの設定を行えます。
						</p>
					</div>
				</div>

				<div id="box_item_a3" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">キャスト管理
							<span id="box_3_icon_3" class="box_item_icon pc_only">
								<span class="box_item_icon_1"></span>
								<span class="box_item_icon_2"></span>
							</span>
						</div>
						<p class="box_item_p">
							キャストのプロフィールや写真のほか、管理に便利なステータスやキャストの個人情報等も登録できます。
						</p>
					</div>
				</div>

				<div id="box_item_a4" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">シフト管理
							<span id="box_3_icon_4" class="box_item_icon pc_only">
								<span class="box_item_icon_1"></span>
								<span class="box_item_icon_2"></span>
							</span>
						</div>
						<p class="box_item_p">
							キャストのシフトを1週間単位で一覧で表示、変更することができます。<br>
						</p>
					</div>
				</div>

				<div id="box_item_a5" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">ブログ管理
							<span id="box_3_icon_5" class="box_item_icon pc_only">
								<span class="box_item_icon_1"></span>
								<span class="box_item_icon_2"></span>
							</span>
						</div>						<p class="box_item_p">
							キャストブログ、スタッフブログの投稿、修正、削除、非表示を行えます。
						</p>
					</div>
				</div>

				<div id="box_item_a6" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">お問い合わせ
							<span id="box_3_icon_6" class="box_item_icon pc_only">
								<span class="box_item_icon_1"></span>
								<span class="box_item_icon_2"></span>
							</span>
						</div>
						<p class="box_item_p">
							キャストの応募メールをCMSで確認することができます。対応履歴も残せますので、誰が見てもわかるようにできます。
						</p>
					</div>
				</div>
			</div>

			<div id="box_right_a" class="box_flex_right">
				<div class="box_item2">
	不要な機能を排除し、シンプルに簡単、便利さを追求しました。<br>
	サイト更新、キャスト管理、応募の確認、全てこれ一つで対応できます。<br>
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
						<div class="box_item_title">TOP
							<span id="box_4_icon_1" class="box_item_icon">
								<span class="box_item_icon_3"></span>
								<span class="box_item_icon_2"></span>
							</span>
						</div>
						<p class="box_item_p">
							スケジュールと登録したお客様の誕生日が、本日より3日分表示されます。<br>
							お店からの連絡事項が表示されます。<br>
						</p>
					</div>
				</div>

				<div id="box_item_b2" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">カレンダー
							<span id="box_4_icon_2" class="box_item_icon">
								<span class="box_item_icon_3"></span>
								<span class="box_item_icon_2"></span>
							</span>
						</div>
						<p class="box_item_p">
							お客様の誕生日やシフトが表示され、日ごとの個人メモを残すことも可能です。<br>
							シフト提出もここから行えます。<br>
						</p>
					</div>
				</div>

				<div id="box_item_b3" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">顧客リスト
							<span id="box_4_icon_3" class="box_item_icon">
								<span class="box_item_icon_3"></span>
								<span class="box_item_icon_2"></span>
							</span>
						</div>
						<p class="box_item_p">
							顧客の詳細や、来店履歴、利用の詳細を記載できます。<br>
							写真設定、評価設定、グループ分けも可能です。<br>
						</p>
					</div>
				</div>

				<div id="box_item_b4" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">EasyTalk
							<span id="box_4_icon_4" class="box_item_icon">
								<span class="box_item_icon_3"></span>
								<span class="box_item_icon_2"></span>
							</span>
						</div>
						<p class="box_item_p">
							タイムライン仕様のコミュニケーションツールで、キャストは自身のアカウントをお客様に伝えることなく利用できます。<br>
						</p>
					</div>
				</div>

				<div id="box_item_b5" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">ブログ
							<span id="box_4_icon_5" class="box_item_icon">
								<span class="box_item_icon_3"></span>
								<span class="box_item_icon_2"></span>
							</span>
						</div>

						<p class="box_item_p">
							写真付きブログの投稿、編集ができます。<br>
							写真はリサイズ、調整、部分マスク等の簡易調整が可能です。<br>
						</p>
					</div>
				</div>

				<div id="box_item_b6" class="box_item">
					<div class="box_item_in">
						<div class="box_item_title">アナリティクス
							<span id="box_4_icon_6" class="box_item_icon">
								<span class="box_item_icon_3"></span>
								<span class="box_item_icon_2"></span>
							</span>
						</div>
						<p class="box_item_p">
							時給・バックから月の収入目安を算出します。<br>
							バック項目や顧客ごとのランキング表示も可能です。<br>
						</p>
					</div>
				</div>
			</div>

			<div id="box_right_b" class="box_flex_right">
				<div class="box_item2">
				HIME-Karte（ヒメカルテ）は『お客様ノート』と『スケジュール帳』の機能を併せ持つ、キャスト用マイページです。<br>
				シフト提出やブログ投稿もHIME-Karteから可能ですので、キャストの負担を大きく減らすことができます。
				<img src="./z_img/img3.webp" class="box_item2_img" alt="cast_image">
				</div>
			</div>
		</div>
	</article>
		
	<article id="block_5" class="box">
		<div class="box_flex">
			<h2 class="h2">お見積り</h2>
			<div class="h2_s">　</div>

			<div class="box_5_left">
				<div id="block_5_box_0" class="box_5_title">基本料金<span class="box_5_title_p">120,000円</span></div>

				<div id="block_5_box_1" class="box_5_0">
				<div class="box_5_0_title">Night-partyシステム一式<span class="box_5_0_title_p">50,000円</span></div>
				<div class="box_5_0_title">基本制作費<span class="box_5_0_title_p">70,000円</span></div>
				</div>

				<div id="block_5_box_3" class="box_5_1">
					<div class="box_5_1_title">ページ構成　<span class="box_5_1_title_s">※仕様により変わることがあります</span></div>
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

				<div id="block_5_box_4" class="box_5_1">
					<div class="box_5_1_title">その他</div>
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

			<div class="box_5_right">
				<div id="block_5_box_5" class="box_5_title">有料オプション</div>


				<div id="block_5_box_6" class="box_5_1">
					<p class="box_5_1_title">レンタルサーバー・ドメイン取得<span class="box_5_1_title_p">10,000円</span></p>
					<p class="comm_p2">
						WebP対応、SSD高速レンタルサーバー、comドメインで手配させていただきます。<br>
						<span style="font-weight:700">初回10カ月分込み</span>。それ以降はサーバー、ドメイン併せて年間で10000円前後かかります。<br>
					</p>

					<p class="box_5_1_title">トップバナー追加(1200px × 480px)<span class="box_5_1_title_p">10,000円</span></p>
					<p class="comm_p2">
					2枚目以降はスライド表示となります。<br>
					</p>

					<p class="box_5_1_title">サイドバナー追加(600px × 150px)<span class="box_5_1_title_p">5,000円</span></p>
					<p class="comm_p2">
					2枚目以降は下に並びます。<br>
					</p>

					<p class="box_5_1_title">ページ追加<span class="box_5_1_title_p">12,000円～</span></p>
					<p class="comm_p2">ご相談下さい。</p>

					<p class="box_5_1_title">出張撮影<span class="box_5_1_title_p">20,000円</span></p>
					<p class="comm_p2">
					キャスト・お食事・店内撮影など。2時間<br>
					お時間、曜日はご相談下さい。場所は東京都・神奈川県・千葉県・埼玉県に限らせていただきます。<br>
					撮影した写真の著作権は譲渡します。サイト以外でもご自由にご利用いただけます。<br>
					</p>
					<p class="box_5_1_title">ロゴ作成<span class="box_5_1_title_p">10,000円</span></p>
					<p class="comm_p2">
					1200px × 1200px 単色<br>
					著作権は譲渡します。サイト以外でもご自由にご利用いただけます。<br>
					</p>
				</div>
			</div>
		</div>
	</article>

	<article id="block_6" class="box">
		<div class="box_ab">
			<h2 class="h2">ご依頼・お問合せ</h2>
			<div class="h2_s">　</div>
			<div id="block_6_box_0" class="box_6_0">
				<div class="box_6_0_1">
				ただ今の期間のお問合せ、ご依頼は「Coconara（ココナラ）」様にて承っています。
				<div class="box_6_0_2">
				<span style="font-weight:800; color:#d00000">2022.09.30まで</span><br>
				ココナラからのお申込みを30,000円引で承っています。<br>
				</div>
				</div>
				<a href="https://coconala.com/services/2374687" class="box_6_1">ココナラへ移動する</a>
			</div>
		</div>
		<div></div>
		<footer class="footer">copyright 2022 NightParty all right reserved.</footer>
	</article>
</section>
<form id="form_b" action="./sample1/mypage/index.php" method="post" target="_blank">
	<input type="hidden" id="h_b" name="prm" value="0">
	<input type="hidden" name="pg" value="top">
</form>
<form id="form_a" action="./sample1/admin/index.php" method="post" target="_blank">
	<input type="hidden" id="h_a" name="prm" value="0">
	<input type="hidden" name="pg" value="top">
</form>
</body>
</html>
