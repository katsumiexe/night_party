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
</head>
<body>

<div class="box_1">ヒアリングシート</div>

<div class="box_2">
<table class="table_1">
	<tr>
		<td class="td_title">店舗基本情報</td>
	</tr>
<tr>
	<td>
		<span class="td_tag">店舗名</span>
		<input id="info_1" type="text" class="textbox">
	</td>
</tr>

<tr>
	<td>
		<span class="td_tag">住所</span>
		<input id="info_2" type="text" class="textbox">
	</td>
</tr>

<tr>
	<td>
		<span class="td_tag">電話番号</span>
		<input id="info_3" type="text" class="textbox">
	</td>
</tr>

<tr>
	<td>
		<span class="td_tag">メールアドレス</span>
		<input id="info_3" type="text" class="textbox">
	</td>
</tr>

<tr>
	<td>
		<span class="td_tag">LINE</span>
		<input id="info_3" type="text" class="textbox">
	</td>
</tr>

<tr>
	<td>
		<span class="td_tag">twitter</span>
		<input id="info_3" type="text" class="textbox">
	</td>
</tr>

<tr>
	<td>
		<span class="td_tag">店舗形態</span>
		<select id="info_3" class="textbox">
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
		<input id="info_3" type="text" class="textbox">
	</td>
</tr>


<tr>
	<td>
		<span class="td_tag">顧客年齢層</span>
		<input id="info_3" type="text" class="textbox">
	</td>
</tr>

<tr>
	<td>
		<span class="td_tag">営業時間</span>
		<input id="info_3" type="text" class="textbox">時 ～<input id="info_3" type="text" class="textbox">時
	</td>
</tr>
</table>

<table class="table_2">
	<tr>
		<td class="td_title" colspan="3">使用コンテンツ</td>
	</tr>

	<tr>
		<td>
			<label for="check_1" class="ribbon_use">
				<span class="check2">
					<input id="check_1" type="checkbox" class="ck0" value="1" <?if($dat["check_1"] ==1){?>checked="checked"<?}?>>
					<span class="check1"></span>
				</span>
				<span>お知らせ</span>
			</label>
		</td>
	</tr>

	<tr>

		<td>
			<label for="check_2" class="ribbon_use">
				<span class="check2">
					<input id="check_2" type="checkbox" class="ck0" value="1" <?if($dat["check_2"] ==1){?>checked="checked"<?}?>>
					<span class="check1"></span>
				</span>
				<span>EasyTalk</span>
			</label>
		</td>
	</tr>

	<tr>

		<td>
			<label for="check_1" class="ribbon_use">
				<span class="check2">
					<input id="check_1" type="checkbox" class="ck0" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="check1"></span>
				</span>
				<span>スケジュール</span>
			</label>
		</td>
	</tr>




	<tr>
		<td>
			<label for="check_1" class="ribbon_use">
				<span class="check2">
					<input id="check_1" type="checkbox" class="ck0" value="1" <?if($dat["check_1"] ==1){?>checked="checked"<?}?>>
					<span class="check1"></span>
				</span>
				<span>TOP挨拶</span>
			</label>
		</td>
	</tr>

	<tr>
		<td>
			<label for="check_2" class="ribbon_use">
				<span class="check2">
					<input id="check_2" type="checkbox" class="ck0" value="1" <?if($dat["check_2"] ==1){?>checked="checked"<?}?>>
					<span class="check1"></span>
				</span>
				<span>ニュース</span>
			</label>
		</td>
	</tr>

	<tr>
		<td>
			<label for="check_1" class="ribbon_use">
				<span class="check2">
					<input id="check_1" type="checkbox" class="ck0" value="1" <?if($dat["check_3"] ==1){?>checked="checked"<?}?>>
					<span class="check1"></span>
				</span>
				<span>システム</span>
			</label>
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
