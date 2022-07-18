<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Night-Party ヒアリングシート</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

</script>
<style>
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
	padding-left:5px;
	border		:1px solid #303030;
	margin		:0 5px 5px 5px;
}

.td_title{
	background		:#e0e0ff;
	color			:#303030;
	font-size		:16px;
	height			:30px;
	line-height		:30px;
	text-align		:center;
}

.td_tag{
	display			:block;
	font-size		:14px;
	padding-left	:10px;
	width			:80px;
	font-weight		:700;
	height			:20px;
	line-height		:22px;
}



.ck_box0{
	display			:inline-block;
	verticcal-align:top;
	font-size		:14px;
	position		:relative;
	padding-left	:30px;
	height			:30px;
	line-height		:30px;
	margin			:5px;
	width			:110px;
}

.ck_box0:checked + .check1{
	display				:inline-block;
}

.ck_box3{
	display				:none;
	position			:absolute;
	left				:5px;
	bottom				:0;
	width				:20px;
	height				:14px;
	border-bottom		:4px solid #a00000;
	border-left			:4px solid #a00000;
	transform			:rotate(-50deg);
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
	left				:5px;
	top					:0;
	bottom				:0;
	margin				:auto;
	width				:16px;
	height				:16px;
	border				:2px solid #303030;
	background			:#fafafa;
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
		<input id="info_3" type="text" class="textbox w360">
	</td>
</tr>

<tr>
	<td colspan="3">
		<span class="td_tag">LINE</span>
		<input id="info_3" type="text" class="textbox w360">
	</td>
</tr>

<tr>
	<td colspan="3">
		<span class="td_tag">twitter</span>
		<input id="info_3" type="text" class="textbox w360">
	</td>
</tr>

<tr>
	<td colspan="3">
		<span class="td_tag">店舗形態</span>
		<select id="info_3" class="textbox w360">
			<option></option>
			<option value="info_3_1">キャバクラ</option>
			<option value="info_3_2">セクキャバ</option>
			<option value="info_3_3">ガールズバー</option>

			<option value="info_3_4">コンカフェ</option>
			<option value="info_3_5">メイドカフェ</option>
			<option value="info_3_6">アイドルカフェ</option>

			<option value="info_3_7">スポーツバー</option>
			<option value="info_3_8">ダーツバー</option>

			<option value="info_3_9">SMバー</option>
			<option value="info_3_10">ハプニングバー</option>
			<option value="info_3_11">デリヘル</option>

			<option value="info_3_12">その他</option>
		</select>
	</td>
</tr>


<tr>
	<td>
		<span class="td_tag">キャスト数</span>
		<input id="info_3" type="text" class="textbox w40">人
	</td>
	<td>
		<span class="td_tag">顧客年齢層</span>
		<input id="info_3" type="text" class="textbox w40">歳
	</td>
	<td>
		<span class="td_tag">営業時間</span>
		<input id="info_3" type="text" class="textbox w40">時 ～<input id="info_3" type="text" class="textbox w40">時
	</td>
</tr>
</table>

<table class="table_2">
	<tr>
		<td class="td_title" colspan="3">使用コンテンツ</td>
	</tr>

	<tr>
		<td>
			<label for="check_1" class="ck_box0">
				<span class="ck_box1">
					<input id="check_1" type="checkbox" class="ck_box2" value="1" <?if($dat["check_1"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>お知らせ</span>
			</label>

			<label for="check_2" class="ck_box0">
				<span class="ck_box1">
					<input id="check_2" type="checkbox" class="ck_box2" value="1" <?if($dat["check_2"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>EasyTalk</span>
			</label>

			<label for="check_3" class="ck_box0">
				<span class="ck_box1">
					<input id="check_3" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>スケジュール</span>
			</label>
		</td>

		<td>
			<label for="check_4" class="ck_box0">
				<span class="ck_box1">
					<input id="check_4" type="checkbox" class="ck_box2" value="1" <?if($dat["check_1"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>TOP挨拶</span>
			</label>
			<label for="check_5" class="ck_box0">
				<span class="ck_box1">
					<input id="check_5" type="checkbox" class="ck_box2" value="1" <?if($dat["check_2"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>ニュース</span>
			</label>

			<label for="check_6" class="ck_box0">
				<span class="ck_box1">
					<input id="check_6" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>アクセス</span>
			</label>

			<label for="check_7" class="ck_box0">
				<span class="ck_box1">
					<input id="check_7" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>リクルート</span>
			</label>

			<label for="check_8" class="ck_box0">
				<span class="ck_box1">
					<input id="check_8" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>プライバシー</span>
			</label>

			<label for="check_9" class="ck_box0">
				<span class="ck_box1">
					<input id="check_9" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>キャストブログ</span>
			</label>

			<label for="check_10" class="ck_box0">
				<span class="ck_box1">
					<input id="check_10" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>スタッフブログ</span>
			</label>

			<label for="check_11" class="ck_box0">
				<span class="ck_box1">
					<input id="check_11" type="checkbox" class="ck_box2" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="ck_box3"></span>
				</span>
				<span>システム</span>
			</label>



		</td>
		<td>




		</td>
	</tr>
</table>


▼使用コンテンツ

□
□
□
□アクセス
□リクルート
□キャストブログ
□スタッフブログ
□プライバシーポリシー

□Google アナリティクス
□Google サーチコンソール

▼使用キャスト情報
プロフィール
オプション

</body>
</html>
