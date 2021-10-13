$(function(){ 
	var Chg_s=[];
	var Chg_e=[];
	var Sch_d=[];

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
		$('#wform').submit();
	});

	$('#p_week').on('click',function(){	
		$('#page').val('p');
		$('#wform').submit();
	});

	$('#n_week').on('click',function(){	
		$('#page').val('n');
		$('#wform').submit();
	});

	$('.menu').on('click',function () {
		Tmp=$(this).attr('id');
		$('#menu_post').val(Tmp);
		$('#form_menu').submit();
	});

	$('.staff_hime').on('click',function () {
		TmpId	=$(this).parents().parents().attr('id').replace('sort_item','');
		TmpName	=$(this).parents(). prev('td').children('.st_name').text();
		TmpMail	=$('#ml'+TmpId).val();
		if(TmpMail){
			$('.pop_msg').html(TmpName +"<br>送信先:"+TmpMail+"<br>HIMEカルテへのリンクを送信します。");
			$('.back').fadeIn(100);
		}else{
			alert('メールアドレスがありません');
		}
	});

	$('#pop_ng,.pop_out').on('click',function () {
		$('.back').fadeOut(500);
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
			$('.back').delay(2000).fadeOut(500);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});

	});

/*
	$('#prof').sortable({
		axis: 'y',
        handle: '.handle',

		stop:function(){
			var Cnt = 1;
			$(this).children('.tr').each(function(){
				$(this).children('.config_prof_sort').children('.prof_sort').val(Cnt);
				Cnt++;
			});

			ChgList=$(this).sortable("toArray");
			$.ajax({
				url:'./post/config_charm_sort.php',
				type: 'post',
				data:{
					'list[]':ChgList,
				},

			}).done(function(data, textStatus, jqXHR){
				console.log(data)

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		},
	});
*/



	$('.list_sort').sortable({
		axis: 'y',
        handle: '.handle',

		stop : function(){
			var Cnt = 1;
			ChgList=$(this).sortable("toArray");

console.log(ChgList);

			Tmp=$(this).attr('id');
			if(Tmp == 'staff_sort'){
				$(this).children('.tr').each(function(){
					$(this).children('.w40').children('.box_sort').val(Cnt);
					Cnt++;
				});

			}else if(Tmp == 'contents_sort'){
				$(this).children('.sort_item').each(function(){
					$(this).find('.box_sort').val(Cnt);
					Cnt++;
				});
			}

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
});

