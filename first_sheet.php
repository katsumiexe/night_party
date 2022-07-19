<?php

?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex,nofollow">
<title>Night-Party ヒアリングシート</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(function(){ 
	$('.ques').hover(function() {
		$(this).children('.ans').fadeIn(300);
	},function() {
		$('.ans').fadeOut(200);
	});
});

</script>
<style>
@font-face {
	font-family: at_icon;
	src: url("./sample1/font/nightparty_icon.ttf") format('truetype');
}

table{
	border			:1px solid #303030;
	margin			:5px;
	border-collapse	:collapse;
	width			:440px;
}

td{
	vertical-align:top;
}

input,select{
	height		:30px;
	line-height	:30px;
	padding-left:10px;
	border		:1px solid #303030;
	margin		:0 5px 5px 5px;
}

.textarea,.textarea2{
	height		:100px;
	font-size	:15px;
	line-height	:22px;
	padding		:5px;
	border		:1px solid #303030;
	margin		:0 5px 5px 5px;
	resize		:none;
}

.textarea2{
	height		:200px;
}

.td_title{
	background		:#000090;
	color			:#fafafa;
	font-size		:16px;
	height			:30px;
	line-height		:30px;
	text-align		:center;
}

.td_tag{
	display			:block;
	font-size		:14px;
	padding-left	:10px;
	font-weight		:700;
	height			:20px;
	line-height		:22px;
}

.ck_title{
	margin			:5px;
	background		:#906000;
	color			:#fafafa;
	height			:24px;
	line-height		:24px;
	font-size		:15px;
	font-weight		:700;
	text-align		:center;
}

.ck_box0{
	display			:inline-block;
	verticcal-align:top;
	font-size		:14px;
	position		:relative;
	padding-left	:20px;
	height			:30px;
	line-height		:30px;
	margin			:5px;
	width			:160px;
	border-bottom:1px solid #202020;
}

.ck_box0:checked + .check1{
	display				:inline-block;
}


.ck_box3{
	display				:none;
	position			:absolute;
	left				:6px;
	bottom				:0;
	width				:16px;
	height				:11px;
	border-bottom		:4px solid #a00000;
	border-left			:4px solid #a00000;
	transform			:rotate(-55deg);
	transform-origin	:left bottom
}

.ck_box2{
	display				:none;
}
.ck_box2:checked + .ck_box3{
	display				:inline-block;
}

.ck_box1{
	display				:inline-block;
	position			:absolute;
	left				:2px;
	top					:0;
	bottom				:0;
	margin				:auto;
	width				:12px;
	height				:12px;
	border				:2px solid #303030;
	background			:#fafafa;
}

.ques{
	display			:inline-block;
	width			:18px;
	height			:18px;
	line-height		:18px;
	text-align		:center;
	position		:absolute;
	top				:0;
	right			:5px;
	font-family		:at_icon;
	color			:#ff30c0;
}

.ans{
	display			:none;
	position		:absolute;
	top				:25px;
	right			:-5px;
	padding			:5px;
	font-size		:13px;
	background		:#fff0e0;
	border			:1px solid #202020;
	color			:#202020;	
	line-height		:18px;
	width			:150px;
	z-index			:3;
	text-align		:left;
}

.w100{
	width:100px;
}

.w160{
	width:160px;
}


.w240{
	width:240px;
}

.w360{
	width:400px;
}


.w60{
	width:60px;

}
.w40{
	width:40px;

}

</style>
</head>
<body>
<div class="box_1">ヒアリングシート</div>

<div class="box_2">
<table class="table_1">
	<tr>
		<td colspan="3" class="td_title">店舗基本情報</td>
	</tr>
	<tr>
		<td colspan="3">
			<span class="td_tag">店舗名</span>
			<input id="info_1" type="text" class="textbox w360">
		</td>
	</tr>

	<tr>
		<td colspan="3">
			<span class="td_tag">住所</span>
			<input id="info_2" type="text" class="textbox w360">
		</td>
	</tr>

	<tr>
		<td colspan="3">
			<span class="td_tag">電話番号</span>
			<input id="info_3" type="text" class="textbox w360">
		</td>
	</tr>

	<tr>
		<td colspan="3">
			<span class="td_tag">メールアドレス</span>
			<input id="info_4" type="text" class="textbox w360">
		</td>
	</tr>

	<tr>
		<td colspan="3">
			<span class="td_tag">LINE</span>
			<input id="info_5" type="text" class="textbox w360">
		</td>
	</tr>

	<tr>
		<td colspan="3">
			<span class="td_tag">twitter</span>
			<input id="info_6" type="text" class="textbox w360">
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<span class="td_tag">店舗形態</span>
			<select id="info_7" class="textbox w360">
				<option></option>
				<option value="キャバクラ">キャバクラ</option>
				<option value="セクキャバ">セクキャバ</option>
				<option value="ガールズバー">ガールズバー</option>
				<option value="デリヘル">デリヘル</option>
				<option value="コンカフェ">コンカフェ</option>
				<option value="メイドカフェ">メイドカフェ</option>
				<option value="アイドルカフェ">アイドルカフェ</option>
				<option value="スポーツバー">スポーツバー</option>
				<option value="ダーツバー">ダーツバー</option>
				<option value="SMバー">SMバー</option>
				<option value="ハプニングバー">ハプニングバー</option>
				<option value="その他">その他</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<span class="td_tag">キャスト数</span>
			<input id="info_8" type="text" class="textbox w40">人
		</td>
		<td>
			<span class="td_tag">顧客年齢層</span>
			<input id="info_9" type="text" class="textbox w40">歳
		</td>
		<td>
			<span class="td_tag">営業時間</span>
			<input id="info_10" type="text" class="textbox w40">時 ～<input id="info_11" type="text" class="textbox w40">時
		</td>
	</tr>
</table>

<table class="table_2">
	<tr>
		<td class="td_title" colspan="3">サイトデザイン</td>
	</tr>
		<td>
			<span class="td_tag">イメージカラー</span>
			<input id="dg_1" type="text" class="textbox w360">
		</td>
	</tr>
	<tr>
		<td>
			<span class="td_tag">イメージサイトURL</span>
			<input id="dg_2" type="text" class="textbox w360">
			<textarea id="dg_3" class="textarea w360"></textarea>
		</td>
	</tr>
	<tr>
		<td>
			<span class="td_tag">その他ご要望</span>
			<textarea id="dg_4" class="textarea2 w360"></textarea>
		</td>
	</tr>
</table>

<table class="table_3">
	<tr>
		<td class="td_title" colspan="3">使用コンテンツ</td>
	</tr>

	<tr>
		<td>
		<div class="ck_title">CMSコンテンツ</div>
			<label for="check_1" class="ck_box0">
				<span class="ck_box1">
					<input id="check_1" type="checkbox" class="ck_box2" value="1" <?if($dat["check_1"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>Notice</span>
				<span class="ques"><span class="ans">店舗からキャストへ連絡事項の告知をするためのものです。</span></span>
			</label>

			<label for="check_2" class="ck_box0">
				<span class="ck_box1">
					<input id="check_2" type="checkbox" class="ck_box2" value="1" <?if($dat["check_2"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>EasyTalk</span>
				<span class="ques"><span class="ans">キャストが顧客へ営業メールを送るためのものです。</span></span>
			</label>

			<label for="check_3" class="ck_box0">
				<span class="ck_box1">
					<input id="check_3" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>スケジュール</span>
				<span class="ques"><span class="ans">キャストの出勤日、時間を表示するためのものです。</span></span>
			</label>
		</td>

		<td>
			<div class="ck_title">サイト内ページ</div>
			<label for="check_4" class="ck_box0">
				<span class="ck_box1">
					<input id="check_4" type="checkbox" class="ck_box2" value="1" <?if($dat["check_1"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>TOP挨拶</span>
				<span class="ques"><span class="ans">ページのTOPに挨拶の一文を入れるためのものです。</span></span>
			</label>
			<label for="check_5" class="ck_box0">
				<span class="ck_box1">
					<input id="check_5" type="checkbox" class="ck_box2" value="1" <?if($dat["check_2"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>ニュース</span>
				<span class="ques"><span class="ans">イベントやキャストに関する様々なお知らせを告知するためのものです。</span></span>
			</label>

			<label for="check_11" class="ck_box0">
				<span class="ck_box1">
					<input id="check_11" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>システム</span>
				<span class="ques"><span class="ans">料金など、お店のシステムを告知するためのものです。</span></span>
			</label>

			<label for="check_9" class="ck_box0">
				<span class="ck_box1">
					<input id="check_9" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>キャストブログ</span>
				<span class="ques"><span class="ans">キャストがHIME-Karteより投稿するブログです。</span></span>
			</label>

			<label for="check_10" class="ck_box0">
				<span class="ck_box1">
					<input id="check_10" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>スタッフブログ</span>
				<span class="ques"><span class="ans">スタッフが投稿するブログです。</span></span>
			</label>

			<label for="check_6" class="ck_box0">
				<span class="ck_box1">
					<input id="check_6" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>アクセス</span>
				<span class="ques"><span class="ans">お店の住所、連絡先、MAPを表示します。</span></span>
			</label>

			<label for="check_7" class="ck_box0">
				<span class="ck_box1">
					<input id="check_7" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>リクルート</span>
				<span class="ques"><span class="ans">キャストの求人受付です。</span></span>
			</label>

			<label for="check_8" class="ck_box0">
				<span class="ck_box1">
					<input id="check_8" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>プライバシーポリシー</span>
				<span class="ques"><span class="ans">サイトとしての個人情報への取り組みを明記するためのものです。</span></span>
			</label>
		</td>

		<td>
			<div class="ck_title">システムコンテンツ</div>
			<label for="check_12" class="ck_box0">
				<span class="ck_box1">
					<input id="check_12" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>SSL設定</span>
				<span class="ques"><span class="ans">サイトを暗号化し、安全なものにするためのものです。</span></span>
			</label>

			<label for="check_13" class="ck_box0">
				<span class="ck_box1">
					<input id="check_13" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>アナリティクス</span>
				<span class="ques"><span class="ans">サイトへのアクセス状況を調べるためのものです。</span></span>
			</label>

			<label for="check_14" class="ck_box0">
				<span class="ck_box1">
				<input id="check_14" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
				<span class="ck_box3"></span>
				</span>
				<span>サーチコンソール</span>
				<span class="ques"><span class="ans">検索評価の確認をするためのものです。</span></span>
			</label>

			<label for="check_15" class="ck_box0">
				<span class="ck_box1">
					<input id="check_15" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>ファビコン</span>
				<span class="ques"><span class="ans">ブラウザのタイトルタブに自身のアイコンを表示します。</span></span>
			</label>
		</td>
	</tr>
</table>
</div>
</body>
</html>
