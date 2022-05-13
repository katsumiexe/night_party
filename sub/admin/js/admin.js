$(function(){ 
	var Chg_s=[];
	var Chg_e=[];
	var Sch_d=[];
	var Tmpid="";

	$('.sche_reset').on('click',function(){	
		Tmp =$(this).attr("id").substr(3);
		for(var i=0;i<7;i++){
			$('#s_'+Tmp + "_" + i).val($('#hs_'+Tmp + "_" + i).val());
			$('#e_'+Tmp + "_" + i).val($('#he_'+Tmp + "_" + i).val());
		}
		$(this).parents().siblings('td').css('background','#fafafa');
	});

	$('.sche_submit').on('click',function(){	
		$(this).parents().siblings('td').css('background','#fafafa');

		Tmp =$(this).attr("id").substr(3);
		for(var i=0;i<7;i++){
			if(
				$('#s_'+Tmp + "_" + i).val() != $('#hs_'+Tmp + "_" + i).val() ||
				$('#e_'+Tmp + "_" + i).val() != $('#he_'+Tmp + "_" + i).val()
			){

				if($('#s_'+Tmp + "_" + i).val() == "休み"){
					$('#e_'+Tmp + "_" + i).val('');
				}

				$('#hs_'+Tmp + "_" + i).val($('#s_'+Tmp + "_" + i).val());
				$('#he_'+Tmp + "_" + i).val($('#e_'+Tmp + "_" + i).val());

				Chg_s[i]=$('#s_'+Tmp + "_" + i).val();		
				Chg_e[i]=$('#e_'+Tmp + "_" + i).val();		
				Sch_d[i]=$('#d_'+Tmp + "_" + i).val();		
			}
		}

		$.post({
			url:"./post/sch_chg.php",
			data:{
				'sch_d[]'	:Sch_d,
				'chg_s[]'	:Chg_s,
				'chg_e[]'	:Chg_e,
				'cast_id'	:Tmp,
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.sel_inout').on('change',function(){	
		Tmp =$(this).attr("id").substr(2);
		if($('#s_'+Tmp).val() == $('#hs_'+Tmp).val() && $('#e_'+Tmp).val() == $('#he_'+Tmp).val() ){
			$(this).parents('.td_inout').css('background','#fafafa');

		}else{
			$(this).parents('.td_inout').css('background','#f0f0c0');
		}
	});

	$('.sel_radio, #sel_date, .status_check_box').on('change',function(){	
		$('#page').val('');
		$('#main_form').submit();
	});

	$('#p_week').on('click',function(){	
		$('#page').val('p');
		$('#main_form').submit();
	});

	$('#n_week').on('click',function(){	
		$('#page').val('n');
		$('#main_form').submit();
	});

	$('.menu').on('click',function () {
		Tmp=$(this).attr('id');
		$('#menu_post').val(Tmp);
		$('#form_menu').submit();
	});

	$('.staff_hime').on('click',function () {
		TmpId	=$(this).parents().parents().attr('id').replace('sort_item','');
		TmpLogIn=$(this).next().val();
		TmpName	=$(this).parents(). prev('td').children('.st_name').text();

		TmpMail	=$('#ml'+TmpId).val();
		if(!TmpMail){
			alert('メールアドレスが登録されていません');

		}else if(!TmpLogIn){
			alert('ログインID、ログインPASSが設定されていません');

		}else{
			$('.pop_msg').html(TmpName +"<br>送信先:"+TmpMail+"<br>HIMEカルテへのリンクを送信します。");
			$('.back,.pop').fadeIn(100);
		}
	});

	$("#ps_ck").on("click",function(){
		TmpId="0";
		$(".pop_msg").html("adminのメールにPASSWORD確認用のメールを送信します。<br>※ログインの有効期限は10分です<br>");
		$(".back,.pop").fadeIn();
	});

	$('#pop_ng,.pop_out').on('click',function () {
		$('.back,.pop').fadeOut(500);
	});

	$('.news_chg').on('change',function () {
		$('#news_select').submit();
	});


	$('#pop_ok').on('click',function () {
		$.post({
			url:"./post/hime_login.php",
			data:{
				'id'		:TmpId
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			$('.pop_msg').html('送信しました');
			$('.back,.pop').delay(1000).fadeOut(500);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});

	});

	$('.sort_main').sortable({
		axis: 'y',
        handle: '.handle',
		start : function(){
		},
		stop : function(){
			ChgList=$(this).sortable("toArray");
			Tmp=$(this).attr('id');
			var Cnt=1;
			$(this).children('.sort_item').each(function(){
				$(this).find('.box_sort').val(Cnt);
				Cnt++;
			});

			$.ajax({
				url:'./post/admin_sort.php',
				type: 'post',
				data:{
					'list[]':ChgList,
					'group':Tmp,
				},
//				dataType: 'json',

			}).done(function(data, textStatus, jqXHR){
				console.log(data)

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});


	$('.contact_set').on('click',function(){
		Tmp=$(this).attr('id').replace('send','');
		Tmp2="radio"+Tmp;

		if($('#staff' + Tmp).val()==''){
			alert('スタッフが空欄です');
		}else{

			$.ajax({
				url:'./post/contact_set.php',
				type: 'post',
				data:{
					'id':Tmp,
					'staff'	:$('#staff' + Tmp).val(),
					'log'	:$('#log' + Tmp).val(),
					'radio'	:$("input[name='"+Tmp2+"']:checked").val(),
				},


			}).done(function(data, textStatus, jqXHR){
				console.log(data);
				alert('更新されました。');

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});

	$('.pg_off').on('click',function(){
		Tmp=$(this).attr('id').replace('pg','').replace('pp','').replace('nn','');
		$('#pg').val(Tmp);
		$('#main_form').submit();
	});

	$('.sel_contents').on('click',function(){
		Tmp=$(this).attr('id');
		$('#sel_ck').val(Tmp);
		$('#form').submit();
	});

	$('#page_set_btn').on('click',function(){
		if (!confirm('変更します。よろしいですか')) {
			return false;
		}else{
			$('#page_set').submit();
		}
	});

	$('.rec_tbl_chg').on('change',function(){
		Tmp=$(this).attr('id');
		$.ajax({
			url:'./post/recruit_chg.php',
			type: 'post',
			data:{
				'no'	:1,
				'id'	:Tmp,
				'dat'	:$(this).val(),
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});


	$('.recruit_check').on('click',function(){
		Tmp=$(this).attr('id');

		if($(this).hasClass('rec_bg1')){
			$(this).removeClass('rec_bg1').addClass('rec_bg0');
			Dat=0;
		}else{
			$(this).removeClass('rec_bg0 rec_bg').addClass('rec_bg1');
			Dat=1;
		}

		if(Tmp == "new_label"){
			$('#new_ck').val(Dat);

		}else{
			$.ajax({
				url:'./post/recruit_chg.php',
				type: 'post',
				data:{
					'no'	:1,
					'id'	:Tmp,
					'dat'	:Dat,
				},

			}).done(function(data, textStatus, jqXHR){
				console.log(data);

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});

	$('.recruit_check').on('click',function(){
		Tmp=$(this).attr('id');

		if($(this).hasClass('rec_bg1')){
			$(this).removeClass('rec_bg1').addClass('rec_bg0');
			Dat=0;

		}else{
			$(this).removeClass('rec_bg0 rec_bg').addClass('rec_bg1');
			Dat=1;
		}


		if(Tmp == "new_label"){
			$('#new_ck').val(Dat);

		}else{
			$.ajax({
				url:'./post/recruit_chg.php',
				type: 'post',
				data:{
					'no'	:1,
					'id'	:Tmp,
					'dat'	:Dat,
				},

			}).done(function(data, textStatus, jqXHR){
				console.log(data);

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}

	});

	$('.recruit_del').on('click',function(){
		Tmp=$(this).attr('id').replace("del","");

		if (!confirm('削除します。よろしいですか')) {
			return false;
		}else{
			$.ajax({
				url:'./post/recruit_del.php',
				type: 'post',
				data:{
					'id'	:Tmp,
				},

			}).done(function(data, textStatus, jqXHR){
				$("#contact_sort"+Tmp).remove();
				console.log(data);

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});

	$('.main_box').on('change','.cate_v',function(){
		Chk=$(this).val();
		if( Chk=='person' || Chk=='blog' || Chk=='page'){

			$(this).next('.cate_s').hide();
		}else{
			$(this).next('.cate_s').show();
		}
	});


	$('.upd_file').on('change',function(e){
		Tmp=$(this).attr('id');

		Ck=Tmp.substr(3,1);
		if(Ck=="i"){
			Ck_h=150;
			Ck_w=600;

		}else{
			Ck_h=480;
			Ck_w=1200;
		}

		var file = e.target.files[0];	
		var reader = new FileReader();

		if(file.type.indexOf("image") < 0){
			alert("NO IMAGE FILES");
			return false;
		}
		var img = new Image();

		reader.onload = (function(file){
			return function(e){
				img.src = e.target.result;
				img.onload = function() {
					if(img.height != Ck_h || img.width != Ck_w){
						if (!confirm('画像が推奨サイズではありませんがよろしいですか\n※推奨サイズ　縦'+Ck_h+'px 横'+ Ck_w+'px' +img.height+'/'+img.width)) {
							return false;
						}else{
							$("#top_"+Tmp).attr('src', e.target.result);
						}
					}else{
							$("#top_"+Tmp).attr('src', e.target.result);
					}
				}
			}
		})(file);
		reader.readAsDataURL(file);
	});

	$('.event_tag_btn,.event_set_btn').on('click',function(){
		Tmp	=$(this).attr('id').substr(0,3);
		Tmp2=$(this).attr('id').substr(3);

		if(Tmp == 'chg'){
			if (!confirm('変更します。よろしいですか')) {
				return false;
			}else{
				$('#f'+Tmp2).submit();
			}

		}else if(Tmp == 'del'){
			if (!confirm('削除します。よろしいですか')) {
				return false;

			}else{
				$('#st'+Tmp2).val('4');
				$('#f'+Tmp2).submit();
			}

		}else if(Tmp == 'cov'){
			Tmp3=$('#st'+Tmp2).val();
			if(Tmp3 == 3){
				$('#st'+Tmp2).val('0');

			}else{
				$('#st'+Tmp2).val('3');
			}
			$('#f'+Tmp2).submit();
		}
	});

	$(".event_tag_label").on("change",function(){
		Tmp=$(this).attr("id").replace("sid","");
		$("#news_chg").submit();
	});

	$('#new_set').on('click',function(){
		if($("#new_name").val()){
			$.ajax({
				url:'./post/recruit_set.php',
				type: 'post',
				data:{
					'name'	:$("#new_name").val(),
					'type'	:$("#new_type").val(),
					'ck'	:$("#new_ck").val(),
				},

			}).done(function(data, textStatus, jqXHR){
				console.log(data);
				$("#contact_sort").append(data);
				$("#new_name").val("");
				$("#new_type").val("1")
				$("#new_ck").val("0")
				$("#new_label").addClass('rec_bg0').removeClass('rec_bg1')

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});
});
