<?
include_once('./library/sql_admin.php');
include_once('./library/inc_code.php');

$m[0]=date("Ym01");
$m[1]=date("Ym15",time()-864000);
$m[2]=date("Ym25",time()-864000);
$m[3]=date("Ym01",time()-864000);
$m[4]=date("Ym10");
$m[5]=date("Ym20");

$sch_st[0]="1900";
$sch_st[1]="1930";
$sch_st[2]="2000";
$sch_st[3]="1900";
$sch_st[4]="1900";

$sch_ed[0]="0000";
$sch_ed[1]="0030";
$sch_ed[2]="0100";
$sch_ed[3]="0100";
$sch_ed[4]="0100";

shuffle($m);

$sql="SELECT * FROM NP_cast_log_table";
$sql.=" WHERE cast_id='12346'";

if($res = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($res)){
		$item[$row["id"]]=$row;
	}
}

$s=0;
for($n=12351;$n<12357;$n++){
	$sql="UPDATE NP_cast SET ctime='{$m[$s]}' WHERE id='{$n}'";
	mysqli_query($mysqli,$sql);
	$s++;
}

$now	=date("Y-m-d H:i:s");
$t		=date("t");
$st_8	=date("Ym01");
$ed_8	=date("Ym01",strtotime($st_8)+3456000);

$sql="INSERT INTO NP_schedule (`date`,`sche_date`,`cast_id`,`stime`,`etime`,`signet`)VALUES";
for($n=12345;$n<12357;$n++){
	if($n != 12350){
		for($f=$st_8;$f<$st_8+$t;$f++){
			if(rand(1,10) > 4){
				$s1=rand(0,4);
				$e1=rand(0,4);
				$sql.="('{$now}','{$f}','{$n}','{$sch_st[$s1]}','{$sch_ed[$e1]}','1'),";

				if($n==12346){
					$check[$f]=$sch_st[$s1];
				}
			}
		}
	}
}
$sql=substr($sql,0,-1);
mysqli_query($mysqli,$sql);

$sql2="INSERT INTO NP_cast_log_list (`master_id`,`log_color`,`log_icon`,`log_comm`,`log_price`,`del`)VALUES";
foreach($check as $a1 => $a2){
	$r=rand(20,24);
	for($n=20;$n<$r;$n++){

		$l=rand(1,5);
		$log_list[0]="パチンコで{$l}万円勝ったそうでご機嫌";
		$log_list[1]="たばこ嫌い。明日娘の{$l}歳の誕生日";
		$log_list[2]="競馬で{$l}万円敗け。もうやらない宣言。";
		$log_list[3]="最近仕事が忙しいとのこと。";
		$log_list[4]="ずっと野球の話。阪神ファン。周りは巨人ファンが多いみたい";
		$log_list[5]="ソシャゲにはまる。今月はすでに{$l}万の課金";
		$log_list[6]="早く来て早く帰る。あさってまた来てくれる約束";
		$log_list[7]="青のドレスをめっちゃほめてきた。あとめっちゃ触ってきた";
		$log_list[8]="スマホ買い替え検討中。今度はiphoneにしようかと";
		$log_list[9]="麻雀で{$l}万勝ち。麻雀の話はよくわからん...";
		$log_list[10]="";
		$log_list[11]="";
		$log_list[12]="";

		$log=$log_list[rand(0,12)];	

		$days=substr($a1,0,4)."-".substr($a1,4,2)."-".substr($a1,6,2);	
		$stime=$n.":00";
		$etime=$n.":40";
		$pts=rand(5,30)*1000;
		$cust=rand(1,12);
		$sql="INSERT INTO NP_cast_log (`date`,`sdate`,`stime`,`etime`,`cast_id`,`customer_id`,`log`,`days`,`pts`,`del`)VALUES";
		$sql.="('{$now}','{$days}','{$stime}','{$etime}','12346','{$cust}','{$log}','{$days}','{$pts}','0')";
		mysqli_query($mysqli,$sql);

		$tmp_auto=	mysqli_insert_id($mysqli);
		$r2=rand(0,2)+rand(0,2);
		shuffle($item);
		$r3=0;
		for($n2=0;$n2<$r2;$n2++){
			$sql2.="('{$tmp_auto}','{$c_code[$item[$r3]["item_color"]]}','{$i_code[$item[$r3]["item_icon"]]}','{$item[$r3]["item_name"]}','{$item[$r3]["price"]}','0'),";
			$r3++;
		}
	}
}

$sql2=substr($sql2,0,-1);
mysqli_query($mysqli,$sql2);


for($n=0;$n<27;$n++){
	$tmp_t=($n % 24) *3600;
	$view[$n]	=date("Y-m-d H:i:s",strtotime($st_8)+86400*$n+$tmp_t);
}

$sql="INSERT INTO `NP_posts` (`date`, `view_date`, `title`, `log`, `cast`, `tag`, `img`, `img_del`, `status`, `prm`) VALUES";
$sql.="
('{$now}','{$view[0]}','牡羊座の今日の運勢', '総合運 \r\n人気度アップ。今日はあなたの持っている、ちょっとした情報や知識を披露すると、職場や学校で人気者になれそうです。それがきっかけで、友人の友人と親しくなれるかも。話をするとき相手の目をジッと見て話すと◎。\r\n\r\n恋愛運\r\nささいな事でふたりの仲が険悪になりそうです。いっときはお互い一歩も譲らない状態になってしまうかも。でもあなたが相手を大好きならば仲直りできます。仲直りの後は、ふたりの信頼と絆がより深まるハズ。\r\n\r\n金運\r\n浪費傾向アリ。装飾品やファッションなど、衝動的に買い物をしてしまっているようです。しかし必ずしも必要でないものにばかりお金を使っていると、いざというとき慌ててしまいます。貯蓄に回す努力をしましょう。\r\n\r\n仕事運\r\n吉凶混合運。トラブル発生の可能性があります。誰かのちょっとしたミスが全体責任に問われそう。しかし問題処理に向けて一致団結のムードが生まれ、結果、皆が信頼で結ばれるといったこともありそうです。\r\n\r\n健康運\r\nダイエットや体力アップの目標に向けてやりぬくことが出来る日です。もし、準備が面倒でまだできていないのであれば、今日中に整えてください。今日のあなたは体力が十分にあります。悩む前に行動に移すことが幸運の鍵です。\r\n', 12350, 4, 'p3773706551', NULL, 0, 0),
('{$now}','{$view[1]}','今日はおやすみ！', '　ある秋のことでした。二、三日雨がふりつづいたそのあいだ、ごんは、ほっとして穴（あな）からはい出しました。空はからっと晴れていて、もずの声がキンキンひびいていました。\r\n　ごんは、村の小川のつつみまで出てきました。あたりのすすきの穂（ほ）には、まだ雨のしずくが光っていました。川はいつもは水が少ないのですが、三日もの雨で、水がどっとましていました。ただのときは水につかることのない、川べりのすすきやはぎのかぶが、黄色くにごった水に横だおしになって、もまれています。ごんは川下の方へと、ぬかるみ道を歩いていきました。\r\n　ふと見ると、川の中に人がいて、何かやっています。ごんは、見つからないように、そうっと草の深いところへ歩きよって、そこからじっとのぞいてみました。\r\n「兵十だな。」と、ごんは思いました。兵十はぼろぼろの黒い着物をまくし上げて、腰（こし）のところまで水にひたりまがら、魚をとる、はりきりというあみをゆすぶっていました。はちまきをした顔の横っちょうに、まるいはぎの葉が一まい、大きなほくろのようにへばりついていました。\r\n', 12346, 6, 'p3773024419', NULL, 0, 0),
('{$now}','{$view[2]}','おきれたー', 'しばらくすると、兵十は、はりきりあみのいちばん後ろの、ふくろのようになったところを、水の中から持ち上げました。その中には、しばの根や、草の葉や、くさった木ぎれなどが、ごちゃごちゃ入っていましたが、でもところどころ、白いものがきらきら光っています。それは、ふというなぎの腹や、大きなきすの腹でした。兵十は、びくの中へ、そのうなぎやきすを、ごみといっしょにぶちこみました。そしてまた、ふくろの口をしばって、水の中に入れました。\n　兵十は、それから、びくを持って川から上がり、びくを土手においといて、何をさがしにか、川上の方へかけていきました。\n　兵十がいなくなると、ごんは、ぴょいと草の中からとび出して、びくのそばへかけつけました。ちょいと、いたずらがしたくなったのです。ごんはびくの中の魚をつかみ出しては、はりきりあみのかかっているところより下手（しもて）の川の中を目がけて、ぽんぽん投げこみました。どの魚も、「とぼん」と音を立てながら、にごった水の中へもぐりこみました。\n', 12346, 7, 'p3773024496', 0, 0, 0),
('{$now}','{$view[3]}','名言', '今日も一日。\n\nありがたい一言を\n\n頂こう。', 12351, 6, 'p3750557903', 0, 0, 1),
('{$now}','{$view[4]}','きもちのきりかえ', '「気持ちの切り替えが上手くない」というのも大きな理由の一つです。一つのことに捉われてしまうと、いつまでもそれが頭のなかをグルグルと駆け巡ってしまいます。\nネガティブな考えがさらなるネガティブな要素を呼んで、負のループからなかなか抜け出せなくなってしまうのです。\n \nまた、過去の恋愛で受けたトラウマが解消されていないことも、恋愛でネガティブになってしまう原因の大きな要素となるでしょう。\n頭では過去の恋人とは別人だとわかっていても、同じような結果になってしまうかもしれない、という恐れの気持ちをもち続けているパターンもあります。', 12352, 5, 'p3750213961', 0, 0, 1),
('{$now}','{$view[5]}','おうし座の運勢', '総合運 \n自分の進歩を実感できる出来事があるでしょう。また、伸び悩んでいた人はようやく勢いを取り戻せそう。突き抜けた、といった感覚を味わいそうです。いつものやり方を少し変えてみると、さらなる前進が期待できます。\n\n恋愛運\n今のふたりの関係は少し微妙です。ハッキリしない相手の態度やマンネリ化しつつあるデートコースなど、あなたの中でイライラが募っているのでは？　仲良しなふたりに戻りたければ、早めに話し合いをしましょう。\n\n金運\n今日は情報収集に励みたい日。保険や貯蓄、投資情報など、受けているサービスが、すでに古いタイプのものになっていると気が付くでしょう。より厚いサービスやより大きい利益が望めるものなど、見直しが必要だと感じそう。\n\n仕事運\n目の回るような忙しさでしょう。しかしそんな忙しさの中で鍛えられ、バリバリ働くことで、あなたの能力はよりいっそう磨きがかかるはずです。頑張りましょう。ただ、体力の過信は思わぬ病を招きかねません。注意。\n\n健康運\n体力が追い付かず、つまらないミスをおかしてしまいそう。また、ミスをした自分を強く責めてしまい、自己嫌悪に陥ってしまうかもしれません。周囲はあなたの頑張りを理解しているので、今日は甘えてみてはいかがでしょうか。\n', 12350, 5, 'p3773706702', 0, 0, 0),
('{$now}','{$view[6]}','お友達と一緒', 'いちばんしましいに、太いうなぎをつかみにかかりましたが、なにしろぬるぬるとすべりぬけるので、手ではつかめません。ごんはじれったくなって、頭をびくの中につっこんで、うなぎを口にくわえました。うなぎは、キュッといって、ごんの首へまき付きました。そのとたんに兵十が、向こうから、「うわあ、ぬすっとぎつねめ。」と、どなりたてました。ごんは、びっくりしてとび上がりました。うなぎをふりすててにげようとしましたが、うなぎは、ごんの首にまき付いたままはなれません。ごんは、そのまま横っとびにとび出していっしょうけんめいに、にげていきました。\r\n　ほら穴の近くの、はんの木の下でふりかえってみましたが、兵十は追っかけては来ませんでした。\r\n　ごんは、ほっとして、うなぎの頭をかみくだき、やっとはずして穴の外の、草の葉の上にのさえておきました。\r\n\r\n', 12346, 9, 'p3773024580', NULL, 0, 0),
('{$now}','{$view[7]}','長め。。。。。', '　十日ほどたって、ごんが、弥助（やすけ）というお百姓の家のうらをとおりかかりますと、そこの、いちじくの木のかげで、弥助の家内（かない）が、おはぐろを付けていました。かじ屋の新兵衛（しんべえ）の家のうらをとおると、新兵衛の家内が、かみをすいていました。ごんは、「ふふん。村に何かあるんだな。」と思いました。\r\n「なんだろう、秋祭りかな。祭りなら、たいこやふえの音がしそうなものだ。それに第一、お宮にのぼりがたつはずだが。」\r\n　こんなことを考えながらやってきますと、いつのまにか、表に赤い井戸がある、兵十の家の前へ来ました。その小さな、こわれかけた家の中には、おおぜいの人が集まっていました。よそいきの着物を着て、腰に手ぬぐいを下げたりした女たちが、表のかまどで火をたいています。大きななべの中では、何かぐずぐずにえています。\r\n「ああ、そう式だ。」と、ごんは思いました。\r\n「兵十の家のだれが死んだんだろう。」\r\n　お昼が過ぎると、ごんは、村の墓地（ぼち）に行って、六地蔵（ろくじぞう）さんのかげにかくれていました。いいお天気で、遠く向こうには、お城の屋根がわらが光っています。墓地には、ひがん花が、赤いきれのようにさき続いていました。と、村の方から、カーン、カーンと鐘（かね）が鳴ってきました。そう式の出る合図です。\r\n　やがて、白い着物を着たそう列の者たちがやってくるのがちらちら見え始めました。話し声も近くなりました。そう列は墓地へ入っていきました。人々が通った後には、ひがん花が、ふみ折られていました。\r\n　ごんはのび上がって見ました。兵十が、白いかみしもを付けて、位はいをさげています。いつもは赤いさつまいもみたいな元気のいい顔が、今日はなんだかしおれていました。\r\n「ははん。死んだのは兵十のおっかあだ。」\r\n　ごんは、そう思いながら、頭をひっこめました。\r\n　その晩（ばん）、ごんは、穴の中で考えました。\r\n「兵十のおっかあは、床（とこ）についていて、うなぎが食べたいといったにちがいない。それで兵十がはりきりあみを持ち出したんだ。ところが、わしがいたずらをして、うなぎを取って来てしまった。だから兵十は、おっかあにうなぎを食べさせることができなかった。そのままおっかあは、死んじゃったにちがいない。ああ、うなぎが食べたい、うなぎが食べたいと思いながら、死んだんだろう。ちょっ、あんないたずらをしなければよかった。」\r\n\r\n', 12346, 10, 'p3773024689', NULL, 0, 0),
('{$now}','{$view[8]}','ふたご座の運勢', '総合運 \n今日は自己主張が強くなりそうです。また、感情的になってしまいがちなので、周囲と険悪なムードになってしまうことも。調和を心がけましょう。感情の高ぶりを抑えるには、大きく深呼吸するといいでしょう。\n\n恋愛運\nあなたの魅力が光る日。異性からの視線を一身に集めそうです。普段からオシャレにはちょっとうるさいあなたですが、今日は普段以上に気をつかって◎。カップルはお互いの服の色味を揃えると、気持ちが寄り添います。\n\n金運\n勝負強い日です。大きく賭ければ、それにつり合うだけの利益が望めそうです。観察株のうち有望銘柄を買ってみたり、ギャンブルは賭け金を増やしてみたり。ただし、どちらもリスクがあるということをお忘れなく。\n\n仕事運\n自己主張が強くなりすぎる傾向があるようです。周囲からしてみれば、「困った人」。今日1日は周囲との協調を強く意識してみてください。円滑な人間関係が保たれてこそいい仕事もできるというものです。\n\n健康運\n今日はいきなり激しい運動をしようとせず、自宅でできる軽めのストレッチ程度に留めておきましょう。張り切って激しい運動に挑戦しても続かないだけでなく、思わぬケガにつながってしまいます。\n\n', 12350, 7, 'p3773706834', 0, 0, 0),
('{$now}','{$view[9]}','今日も一日ありがとう☺', '兵十が、赤い井戸のところで、麦をといでいました。兵十は今まで、おっかあと二人きりで貧しいくらしをしていたもので、おっかあが死んでしまっては、もうひとりぼっちでした。\r\n「おれと同じひとりぼっちの兵十か。」\r\n　こちらの物置の後ろから見ていたごんは、そう思いました。\r\n　ごんは物置のそばをはなれて、向こうにいきかけました。どこかで、いわしを売る声がします。\r\n「いわしの安売りだあい。生きのいい、いわしだあい。」\r\n　ごんは、その、いせいのいい声のする方へ走っていきました。と、弥助のおかみさんがうら戸口から、「いわしをおくれ。」と言いました。いわし売りは、いわしのかごをつかんだ車を、道ばたに置いて、ぴかぴか光るいわしを両手でつかんで、弥助の家の中へ持って入りました。ごんは、そのすきまに、かごの中から、五、六匹のいわしをつかみ出して、もと来た方へかけ出しました。そして、兵十の家の中へいわしを投げこんで、穴へ向かってかけもどりました。とちゅうの坂の上でふり返ってみますと、兵十がまだ、井戸のところで麦をといでいるのが小さく見えました。\r\n　ごんは、うなぎのつぐないでに、まず一つ、いいことをしたと思いました。\r\n　次の日には、ごんは山でくりをどっさり拾って、それをかかえて、兵十の家へ行きました。うら口からのぞいてみますと、兵十は、昼めしを食べかけて、茶わんを持ったまま、ぼんやりと考えこんでいました。変なことには、兵十のほっぺたに、かすりきずがついています。どうしたんだろうと、ごんが思っていますと、兵十がひとりごとを言いました。\r\n「いったいだれが、いわしなんかをおれの家へほうりこんでいったんだろう。おかげでおれは、ぬすびとと思われて、いわし屋のやつに、ひどい目にあわされた。」と、ぶつぶつ言っています。\r\n　ごんは、、これはしまったと思いました。かわいそうに兵十は、いわし屋にぶんなぐられて、あんなきずまで付けられたのか。\r\n　ごんは、こう思いながら、そっと物置の方へ回って、その入口にくりを置いて帰りました。\r\n　次の日も、その次の日も、ごんは、くりを拾っては、兵十の家へ持ってきてやりました。その次の日には、くりばかりでなく、松たけも、二、三本持っていきました。', 12346, 4, 'p3773024768', NULL, 0, 0),
('{$now}','{$view[10]}','しし座の運勢', '総合運 \r\n周囲の人の気持ちに敏感になれそう。相手の言いたいことやしたいことを先回りして気遣ってあげると、とても感謝されて人気運が急上昇身体に疲労を感じたら、休むよりむしろ散歩やストレッチなどが有効。\r\n\r\n恋愛運\r\n今日のあなたは社交性が高まっているようです。そのため誰とでもすぐ打ち解けられ、楽しいひとときを過ごせるでしょう。また、今日新たに得た人脈の中に、運命の赤い糸が混じっている可能性があります。\r\n\r\n金運\r\nマメに節約するのは大事なことですが、スキルアップや趣味、教養を身に着けるための予算はできるだけ多めに取りましょう。「絶対自分のためになる」と信じて、興味が引かれることへの投資はケチらないことです。\r\n\r\n仕事運\r\nわからないこと、不安なことはそのままにしないこと。思い込みで作業を進めて、最初からやり直しなんて事態を回避するためにも、上下間のコミュニケーションはマメに取りましょう。頼れる先輩をひとり見つけましょう。\r\n\r\n健康運\r\n健康に関しての有力な情報が手に入る日になりそう。友人との会話やインターネット、雑誌などアンテナを張り巡らせてみて下さい。あなたが普段気になっていた情報が今日なら見つかるかもしれません。', 12350, 10, 'p3773708114', NULL, 0, 0),
('{$now}','{$view[11]}','新しい朝が来た', '　月のいい晩でした。ごんは、ぶらぶら遊びに出かけました。中山さまのお城の下を通って少し行くと、細い道の向こうから、だれか来るようです。話し声が聞こえます。チンチロリン、チンチロリンと松虫が鳴いています。\n　ごんは、道の片側にかくれて、じっとしていました。話し声はだんだん近くなりました。それは、兵十と加助（かすけ）というお百姓でした。\n「そうそう、なあ加助。」と、兵十が言いました。\n「ああん？」\n「おれあ、このごろ、とても、ふしぎなことがあるんだ。」\n「何が？」\n「おっかあが死んでからは、だれだか知らんが、おれにくりや松たけなんかを、毎日、毎日くれるんだよ。」\n「ふうん。だれが？」\n「それが、わからんのだよ。おれの知らんうちに、置いていくんだ。」\n　ごんは、二人の後をつけていきました。\n「ほんとかい？」\n「ほんとだとも。うそと思うなら、あした見に来いよ。そのくりを見せてやるよ。」\n　それなり、二人はだまって歩いていきました。\n　加助がひょいと、後ろを見ました。ごんはびっくりして、小さくなって立ち止まりました。加助は、ごんには気が付かないで、そのままさっさと歩きました。吉兵衛（きちべえ）というお百姓の家まで来ると、二人はそこに入っていきました。ポンポンポンポンと木魚（もくぎょ）の音がしています。まどのしょうじにあかりがさしていて、大きなぼうず頭がうつって動いていました。ごんは、「お念仏（ねんぶつ）があるんだな。」と思いながら、井戸のそばにしゃがんでいました。しばらくすると、また三人ほど、人が連れ立って、吉兵衛の家に入っていきました。お経（きょう）を読む声が聞こえてきました。\n\n', 12346, 5, 'p3773035528', NULL, 0, 0),
('{$now}','{$view[12]}','コラム', 'いわき市の石炭・化石館入り口に珍しいセメント製の塑像が立つ。「坑夫の像」と書かれた台座の上で、筋肉隆々の青年二人がヘルメットをかぶり、一人は掘削機を肩にかかげ、もう一人は誇らしげに右手を高々と上げている\n\n太平洋戦争のさなかの一九四四（昭和十九）年、常磐炭砿磐城砿業所に動員されていた六人の美術家が手掛けた。\n\n\n金属は大砲や軍艦など軍事品製造のため国に供出され、木の枠組みをコンクリートで固め、セメントを塗って造形した。今はその歴史を知る人も少ない', 12353, 5, 'p3750558449', 0, 0, 1),
('{$now}','{$view[13]}','ねがてぶ', '恋愛に限ったことではありませんが、ネガティブな思考はさらによくない状況を引き寄せることもあります。\n「私なんか、どうせなにをしてもダメなんだ…。」と考えることで、行動をストップさせてしまう人も多いでしょう。\n \n実行すれば可能性は0ではありませんが、なにもしなければ可能性は0のまま終わってしまいます。せっかくの発展のチャンスを自ら握り潰しているのと同じことです。\n発展性がなくなってしまうのは、ネガティブな気持ちが引き寄せる大きなマイナスの要素となってしまいます。\n \nまた、ネガティブな思考は、自分で自分を苦しめているも同然です。\n苦しみや悲しみから自分を守るために色々と考えてしまうことで、実際にはなにも起きていないにもかかわらず辛い気持ちになっては自分自身を傷つけてしまっています。\n冷静に考えれば馬鹿馬鹿しくもなりますが、渦中にいるときはそれを大真面目にやってしまっているのです。', 12353, 0, 'p3750214057', 0, 0, 1),
('{$now}','{$view[14]}','かに座の運勢', '総合運 \n人気が高まる日。今まで没交渉だった人に積極的に話しかけてみましょう。実はあなたと全く同じ嗜好の人がいそうです。それがきっかけで、その人が未来の大親友になる可能性大。頷きながら相手の話を聞いてあげると◎。\n\n恋愛運\nふたりの間に何らかのトラブルがありそうです。事態は少し深刻かもしれません。でも悲観的にはならないで。ここを乗り越えれば、雨降って地固まるとの言葉通りふたりは、より強力な信頼と絆で結ばれそうです。\n\n金運\n今日のあなたは装飾品やファッションなどにお金をかけすぎる傾向があるようです。購入はそれが今、必要なものなのかを考えてから。本当に必要なときに使えるお金を残す努力が必要です。フリマやオークションを賢く利用して。\n\n仕事運\n吉凶混合運。今日はトラブル発生の可能性暗示。誰かのミスが全体責任に問われる、といったことがありそうです。しかし、トラブル解決に向けて協力しあうことで、逆に一致団結のいいムードが生まれるかも\n\n健康運\n健康的で活力にあふれる1日。粘り強く、物事と正面から向き合うことができます。今日大きな仕事を与えられたら、それはチャンスだと思って下さい。精一杯取り組むことができれば必ず成果が得られるでしょう。', 12350, 6, 'p3774248310', 0, 0, 0),
('{$now}','{$view[15]}','きもちをきりかえるために', 'ネガティブな思考の人は、まず最悪の事態から考え始めることが多いでしょう。そこからありとあらゆる状況を想定し始めます。\n予め念入りにものごとを考えることは、失敗を大幅に減らすことにも繋がるでしょう。その結果、考えなしに行動するよりも、良い結果を引き寄せることができます。\n \nまた、ネガティブな思考が先立つ人は、他人の気持ちをしっかりと考えることができる人です。\n自分のことだけでなく、他人を不快にさせたくないからこそ色々と考えてしまう面もあるでしょう。\n往々にして優しくて思いやりのある人ですから、自分自身が思っているよりも他人には好かれやすい人でもあります。\n問題があるとすれば、自己肯定感が低いことによって実行力に欠けることなのです。', 12354, 8, 'p3750214113', 0, 0, 2),
('{$now}','{$view[16]}','おしまい', '　ごんは、お念仏がすむまで、井戸のそばにしゃがんでいました。兵十と加助はまたいっしょに帰っていきます。ごんは、二人の話を聞こうと思って、ついていきました。兵十のかげほうしをふみふみいきました。\n　お城の前にまで来たとき、加助が言い出しました。\n「さっきの話は、きっと、そりゃあ、神さまのしわざだぞ。」\n「えっ？」と、兵十はびっくりして、加助の顔を見ました。\n「おれは、あれからずっと考えていたが、どうも、そりゃ、人間じゃない、神さまだ、神さまが、お前がたった一人になったのをあわれに思わっしゃって、いろんなものをめぐんでくださるんだよ。」\n「そうかなあ。」\n「そうだとも。だから、毎日、神さまにお礼を言うがいいよ。」\n「うん。」\n　ごんは、へえ、こいつはつまらないなと思いました。おれが、くりや松たけを持っていってやるのに、そのおれにはお礼を言わないで、神さまにお礼を言うんじゃあ、おれは、ひきあわないなあ。\n\n　その明くる日もごんは、くりを持って、兵十の家へ出かけました。兵十は物置でなわをなっていました。それでごんは、うら口から、こっそり中へ入りました。\n　そのとき兵十は、ふと顔を上げました。と、きつねが家の中へ入ったではありませんか。こないだうなぎをぬすみやがった、あのごんぎつねめが、またいたずらをしに来たな。\n　「ようし。」\n　兵十は、立ち上がって、納屋（なや）にかけてある火なわじゅうを取って、火薬をつめました。\n　そして足音をしのばせて近よって、今、戸口を出ようとするごんを、ドンとうちました。ごんはばたりとたおれました。兵十はかけよってきました。家の中を見ると、土間にくりが固めて置いてあるのが目につきました。\n「おや。」と、兵十はびっくりしてごんに目を落としました。\n「ごん、お前だったのか。いつもくりをくれたのは。」\n　ごんは、ぐったりと目をつぶったまま、うなづきました。\n　兵十は、火なわじゅうをばたりと取り落としました。青いけむりが、まだつつ口から細く出ていました。', 12346, 5, 'p3773036018', NULL, 0, 0),
('{$now}','{$view[17]}','おとめ座の運勢', '総合運 \n人気が高まる日。今まで没交渉だった人に積極的に話しかけてみましょう。実はあなたと全く同じ嗜好の人がいそうです。それがきっかけで、その人が未来の大親友になる可能性大。頷きながら相手の話を聞いてあげると◎。\n\n\n恋愛運\nふたりの間に何らかのトラブルがありそうです。事態は少し深刻かもしれません。でも悲観的にはならないで。ここを乗り越えれば、雨降って地固まるとの言葉通りふたりは、より強力な信頼と絆で結ばれそうです。\n\n\n金運\n今日のあなたは装飾品やファッションなどにお金をかけすぎる傾向があるようです。購入はそれが今、必要なものなのかを考えてから。本当に必要なときに使えるお金を残す努力が必要です。フリマやオークションを賢く利用して。\n\n\n仕事運\n吉凶混合運。今日はトラブル発生の可能性暗示。誰かのミスが全体責任に問われる、といったことがありそうです。しかし、トラブル解決に向けて協力しあうことで、逆に一致団結のいいムードが生まれるかも\n\n\n健康運\n健康的で活力にあふれる1日。粘り強く、物事と正面から向き合うことができます。今日大きな仕事を与えられたら、それはチャンスだと思って下さい。精一杯取り組むことができれば必ず成果が得られるでしょう。', 12350, 10, 'p3777083376', NULL, 0, 2),
('{$now}','{$view[18]}','しあわせになりたいっ', 'おはようございます????\n\n昨日は美容室でまたまた黒髪にしてきました♬\n\n久しぶりに天気がよいので気分もいいです☺\n\nではでは今日も、お店でお待ちしています。\n\nエル・プサイ・コングルゥ\n\n', 12348, 5, 'p3750557694', 0, 0, 1),
('{$now}','{$view[19]}','おはよっす。', 'こんにちは☺️\n\n季節関係なしに主食はアイスです⚆.⚆\n好きなのはチョコミント。\n冷蔵庫にストックがあると安心します。\n\n今週は火曜から土曜日までOPENーLASTで出勤です♪\n\n面白い話聞かせてほしいな。\n最近雨が多いから気を付けてね。\n', 12345, 5, 'p3749797088', 0, 0, 1),
('{$now}','{$view[20]}','深夜のカップラーメン', 'たまーにだけど、カップラーメン食べたくなるよね。\n\nちゃんとしたラーメンじゃなくて、安っぽいカップラーメン。\n\nしかも深夜に！　深夜に突然。\n\n\n日本のカップラーメンはおいしいからね。\n外国のお友達は日本に来たら、カップラーメンとポテトチップスをお土産に買って帰る人多いです。\n\nこれはこれで。\n\n', 12347, 0, 'p3749798261', 0, 0, 1),
('{$now}','{$view[21]}','誕生日です！ですです', 'としを重ねると油っぽいものが食べられなくなるというけど、かなり実感している。\n\n学生のころはあれだけ好きだった唐揚、最近見ると疲れてくる。。。\n\n大根の煮物とか、そういう優しい食べ物が食べたくなるにゅ。。\n\nそんな私ですが、今月15日で24歳になります♪\n\nお店でもバースデイベントやってくれるみたいですので、良かったら来てくださいね。\n\nはぴば　わたし', 12345, 9, 'p3749798780', 0, 0, 1),
('{$now}','{$view[22]}','こんにちは！', '髪の毛染めマシタ～\n可愛い～と一人でテンションあげています☺\n\n\n今日は21時からお店にいます。\n\nいつもより遅め。\n\n今週はお休みも多いですので、良かったら遊びに来てください。\n', 12348, 5, 'p3749850194', 0, 0, 1),
('{$now}','{$view[23]}','近況とやら', 'こんばんは\n\n昨日は大雨の予報だったので、傘を持って家を出たのに、\n朝だけであとは晴れた♪\n\n予定あった身としてはありがたかったε- (´ー`*) ﾌｩ\n\n本日　19:30-LAST\n明日　OPEN-LAST\n\n明日以降は少しお休みします。\n資格試験のおべんきょしなきゃ！\nこれでも学生なんで( *´꒳`*)\n\n\n', 12349, 7, 'p3777425932', 0, 0, 1),
('{$now}','{$view[24]}','やぎ座の運勢', '総合運 \n人気が高まる日。今まで没交渉だった人に積極的に話しかけてみましょう。実はあなたと全く同じ嗜好の人がいそうです。それがきっかけで、その人が未来の大親友になる可能性大。頷きながら相手の話を聞いてあげると◎。\n\n恋愛運\nふたりの間に何らかのトラブルがありそうです。事態は少し深刻かもしれません。でも悲観的にはならないで。ここを乗り越えれば、雨降って地固まるとの言葉通りふたりは、より強力な信頼と絆で結ばれそうです。\n\n金運\n今日のあなたは装飾品やファッションなどにお金をかけすぎる傾向があるようです。購入はそれが今、必要なものなのかを考えてから。本当に必要なときに使えるお金を残す努力が必要です。フリマやオークションを賢く利用して。\n\n仕事運\n吉凶混合運。今日はトラブル発生の可能性暗示。誰かのミスが全体責任に問われる、といったことがありそうです。しかし、トラブル解決に向けて協力しあうことで、逆に一致団結のいいムードが生まれるかも\n\n健康運\n健康的で活力にあふれる1日。粘り強く、物事と正面から向き合うことができます。今日大きな仕事を与えられたら、それはチャンスだと思って下さい。精一杯取り組むことができれば必ず成果が得られるでしょう。', 12350, 6, 'p3774248503', 0, 0, 0),
('{$now}','{$view[25]}','恋愛', '誰だって傷つくのはイヤですが、防衛本能が強い人ほどネガティブになってしまう傾向にあります。\nネガティブな気持ちになってしまう原因の多くを占めているのは、自己肯定感の低さです。\n「どうせ私なんか…。」という気持ちが強いと、なにをやっても失敗するような気がしてしまうでしょう。結果的にネガティブな思考に捉われることとなってしまいます。', 12351, 6, 'p3750213913', 0, 0, 1),
('{$now}','{$view[26]}','脱ネガティブ', '思考をポイッと捨てる想像をする\n瞑想をするのがオススメですが、ハードルが高い面もありますよね。\nネガティブなことをぐるぐると考えそうになったら、頭の中でその思考を箱に入れてポイッと捨てる想像をしてみましょう。川に流すのもいいですし、箱ごと燃やす想像をするのもいいですね。\n\n手を叩いて「おしまい！」\n切り替えがうまくいかないなら、大きく手を叩いてから「もうおしまい！」と口に出すのもよいでしょう。手を叩くことは、負の要素を祓う意味合いがありますよ。\n自分で上手く気持ちを切り替えられる方法を探してみてくださいね。\n\n簡単なことを毎日こなしてみる\nまた、毎日簡単なことを継続してカレンダーや手帳に丸をつけていくことで、自己肯定感を高める方法もあります。小さな積み重ねですが、それが大きな自信に繋がっていくでしょう。\n自己肯定感が高まれば、実行力は自ずとついてきますよ。', 12355, 6, 'p3750214192', 0, 0, 1),
('{$now}','{$view[0]}','毎週木曜日はコスプレデー', '毎週木曜日はコスプレデー\n\n普段のドレスを脱ぎ捨てて、メイドに、教師に、学生に大変身♪\n\n何になるかは当日来てのお楽しみ♪\n\n\n\n実はナイショなんだけれど、キャストにリクエストするのもありなんです。\n\nお店にない衣装は無理ですが、キャストが個人的に持っている衣装なら応相談。\n\nキャストがＯＫすれば、お客様の持ち込み衣装も着ちゃうかも！！！\n\n\n\n皆様のご来店お待ちしております', 1, 4, 'p3777342135', 0, 0, 1),
('{$now}','{$view[8]}','今週末はバースデーイベント！', '今週末は「みれいゆ」ちゃんのバースデー\n\nNight-Partyでも派手にお祝いします。\n\n\n\n▼イチゴのショートケーキ(1,000円)\n\nみれいゆちゃんの好きなイチゴのケーキです。\n\n\n\n▼記念チェキ(1,000円)\n\nみれいゆちゃんと一緒に記念写真を撮ろう！\n\n\n\nこの日はみれいゆちゃんは気合入れた衣装で来るとのことです。\n\nどんな衣装か今から楽しみですね♪\n\n\n\nお客様のご来店、スタッフ一同お待ちしています。\n\n\n\n', 1, 4, 'p3777341990', 0, 0, 1),
('{$now}','{$view[15]}','ご新規様歓迎キャンペーン！', 'ご新規のお客様限定の激得クーポン!!\r\n\r\n『HP見た』と言ってくださると\r\nALL TIME 40分4,000円\r\n&\r\n乾杯テキーラ1杯無料！！\r\n\r\nさらに場内指名を頂けたお客様に、次回来店時に使える「指名無料券」をプレゼント♪\r\n\r\n皆様のお越しをお待ちしています。\r\n', 1, 4, 'p3777342648', NULL, 0, 0),
('{$now}','{$view[20]}','伝説のイベント再動！', 'イベント第二弾は先月大好評だった『Tシャツイベント』開催です。\r\n身体のライン丸わかりのピチピチのサイズ\r\n履いてないかもしれないぐらいオーバーサイズなTシャツ女子達が揃ってます\r\n\r\n先月同様、女の子へのTシャツプレゼントも大歓迎☺\r\n\r\n素敵なあの子に着せてみたい、そんなTシャツをお持ちの方は是非ともお持ちください！\r\n\r\n※Ｔシャツを着てもらうには指名頂く必要があります。また、指名中の間のみとさせていただきます。\r\n\r\n\r\n', 1, 4, 'p3777343496', NULL, 0, 0)
";

mysqli_query($mysqli,$sql);
echo $now;

$sql="INSERT INTO `NP_notice` (`date`, `title`, `log`, `category`, `writer`, `cast_group`, `del`) VALUES
('{$view[1]}', 'おはようございます', '　ある古い家の、まっくらな天井裏に、「ツェ」という名まえのねずみがすんでいました。\r\n　ある日ツェねずみは、きょろきょろ四方を見まわしながら、床下街道ゆかしたかいどうを歩いていますと、向こうからいたちが、何かいいものをたくさんもって、風のように走って参りました。そしてツェねずみを見て、ちょっとたちどまって早口に言いました。\r\n「おい、ツェねずみ。お前んとこの戸棚とだなの穴から、金米糖こんぺいとうがばらばらこぼれているぜ。早く行ってひろいな。」\r\n　ツェねずみは、もうひげもぴくぴくするくらいよろこんで、いたちにはお礼も言わずに、いっさんにそっちへ走って行きました。ところが戸棚の下まで来たとき、いきなり足がチクリとしました。そして、「止まれ、だれかっ。」と言う小さな鋭い声がします。', 16, NULL, '14,15', 0),

('{$view[4]}', '本日の連絡', '「ここから内へはいってならん。早く帰れ。帰れ、帰れ。」蟻の特務曹長とくむそうちょうが、低い太い声で言いました。\r\n　ねずみはくるっと一つまわって、いちもくさんに天井裏へかけあがりました。そして巣の中へはいって、しばらくねころんでいましたが、どうもおもしろくなくて、おもしろくなくて、たまりません。蟻ありはまあ兵隊だし、強いからしかたもないが、あのおとなしいいたちめに教えられて、戸棚とだなの下まで走って行って蟻ありの曹長そうちょうにけんつくを食うとは、なんたるしゃくにさわることだとツェねずみは考えました。そこでねずみは巣からまたちょろちょろはい出して、木小屋の奥のいたちの家にやって参りました。\r\n　いたちはちょうど、とうもろこしのつぶを、歯でこつこつかんで粉にしていましたが、ツェねずみを見て言いました。', 16, NULL, '14,15', 0),

('{$view[8]}', '注意事項', '「どうだ。金米糖がなかったかい。」\r\n「いたちさん。ずいぶんお前もひどい人だね。私わたしのような弱いものをだますなんて。」\r\n「だましゃせん。たしかにあったのや。」\r\n「あるにはあっても、もう蟻が来てましたよ。」\r\n「蟻が、へい。そうかい。早いやつらだね。」\r\n「みんな蟻がとってしまいましたよ。私のような弱いものをだますなんて、償まどうてください。償うてください。」\r\n「それはしかたない。お前の行きようが少しおそかったのや。」\r\n「知らん、知らん。私のような弱いものをだまして。償うてください。償うてください。」\r\n「困ったやつだな。ひとの親切をさかさまにうらむとは。よしよし。そんならおれの金米糖をやろう。」\r\n「償うてください。償うてください。」', 16, NULL, '14,15', 0),

('{$view[10]}', 'お知らせ', '「えい、それ。持って行け。てめえの持てるだけ持ってうせちまえ。てめえみたいな、ぐにゃぐにゃした男らしくもねえやつは、つらも見たくねえ。早く持てるだけ持ってどっかへうせろ。」いたちはプリプリして、金米糖を投げ出しました。ツェねずみはそれを持てるだけたくさんひろって、おじぎをしました。いたちはいよいよおこって叫びました。\r\n「えい、早く行ってしまえ。てめえの取った、のこりなんかうじむしにでもくれてやらあ。」\r\n　ツェねずみは、いちもくさんに走って、天井裏の巣へもどって、金米糖をコチコチ食べました。\r\n　こんなぐあいですから、ツェねずみはだんだんきらわれて、たれもあんまり相手にしなくなりました。そこでツェねずみはしかたなしに、こんどは、柱だの、こわれたちりとりだの、バケツだの、ほうきだのと交際をはじめました。中でも柱とは、いちばん仲よくしていました。\r\n　柱がある日、ツェねずみに言いました。', 16, NULL, '14,15', 0),

('{$view[14]}', '週末のイベントに関して', '「ツェねずみさん、もうじき冬になるね。ぼくらはまたかわいてミリミリ言わなくちゃならない。お前さんも今のうちに、いい夜具のしたくをしておいた方がいいだろう。幸いぼくのすぐ頭の上に、すずめが春持って来た鳥の毛やいろいろ暖かいものがたくさんあるから、いまのうちに、すこしおろして運んでおいたらどうだい。僕ぼくの頭は、まあ少し寒くなるけれど、僕は僕でまたくふうをするから。」\r\n　ツェねずみはもっともと思いましたので、さっそく、その日から運び方にかかりました。\r\n　ところが、途中に急な坂が一つありましたので、ねずみは三度目に、そこからストンところげ落ちました。\r\n　柱もびっくりして、\r\n「ねずみさん、けがはないかい。けがはないかい。」と一生けん命、からだを曲げながら言いました。ねずみはやっと起き上がって、それからかおをひどくしかめながら言いました。', 17, NULL, '14,15', 0),

('{$view[17]}', 'シフト変更', '「柱さん。お前もずいぶんひどい人だ。僕のような弱いものをこんな目にあわすなんて。」\r\n　柱はいかにも申しわけがないと思ったので、\r\n「ねずみさん、すまなかった。ゆるしてください。」と一生けん命わびました。\r\n　ツェねずみは図にのって、\r\n「許してくれもないじゃないか。お前さえあんなこしゃくなさしずをしなければ、私はこんな痛い目にもあわなかったんだよ。償まどっておくれ。償っておくれ。さあ、償っておくれよ。」\r\n「そんなことを言ったって困るじゃありませんか。許してくださいよ。」\r\n「いいや、弱いものをいじめるのは私はきらいなんだから、償っておくれ。償っておくれ。さあ、償っておくれ。」\r\n　柱は困ってしまって、おいおい泣きました。そこでねずみも、しかたなく、巣へかえりました。それからは、柱はもうこわがって、ねずみに口をききませんでした。', 18, NULL, '15', 0)";
mysqli_query($mysqli,$sql);
?>

