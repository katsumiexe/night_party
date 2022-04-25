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

	$('.alert_d').draggable();

	$('.d_ck').on('change',function(){	
		Tmp =$(this).attr("id").replace("ck_","");
		$("d_"+Tmp).remove();

console.log(Tmp);
console.log($(this).val());

		$.post({
			url:"./post/d_check.php",
			data:{
				'key'		:Tmp,
				'value'		:$(this).val(),
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			if(data){
				$(this).css("background-color","#ff6060");
				$(".alert_d").fadeIn(500);
				$(".alert_d_2_out").prepend(data);
			}

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
					'fs':FS,
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


});


