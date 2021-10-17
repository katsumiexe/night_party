$(function(){ 

	var Width_l	=$('.img_box_out2').width();
	var Width_s	=$('.img_box_out1').width();
	var VwBase	=$(window).width()/100;

	var ImgId		='';
	var Fav			=0;
	var cvs_A		=0;
	var Rote		=0;
	var Zoom		=100;
	var Zoom		=100;
	var Chg			='';
	var base_64		='';
	var Box			=[];
	var Tmp			='';

	$('.color_picker,.icon_picker').hide();
	$('.head_mymenu').on('click',function(){
		if($(this).hasClass('on')){
			$(this).removeClass('on');
			$('.slide').animate({'left':'-70vw'},150);
			$('.mymenu_b').fadeIn(150);

			$('.mymenu_a,.mymenu_c').animate({'left':'1vw','width':'8vw'},150);
			$('.head_mymenu').animate({'border-radius':'1vw'},150);

			$({deg:-23}).animate({deg:0}, {
				duration:150,
				progress:function() {
					$('.mymenu_a').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

			$({deg:23}).animate({deg:0}, {
				duration:150,
				progress:function() {
					$('.mymenu_c').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

		}else{
			$(this).addClass('on');
			$('.slide').animate({'left':'0'},150);
			$('.mymenu_b').fadeOut(150);
			$('.mymenu_a,.mymenu_c').animate({'left':'0.5vw','width':'7vw'},150);
			$('.head_mymenu').animate({'border-radius':'5vw'},150);

			$({deg:0}).animate({deg:-45}, {
				duration:150,
				progress:function() {
					$('.mymenu_a').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});

			$({deg:0}).animate({deg:45}, {
				duration:150,
				progress:function() {
					$('.mymenu_c').css({
						transform:'rotate(' + this.deg + 'deg)'
					});
				},
			});
		}
	});

	$('.tag_set').on('click',function () {

console.log("■");

		if($(this).hasClass('tag_set_ck')!='true'){
			$(window).scrollTop(0);

			Tmp_tr=$(this).attr('id')+"_tbl";
			$('.tag_set_ck').removeClass('tag_set_ck').animate({'height':'5.5vw'},200);
			$(this).addClass('tag_set_ck').animate({'height':'8vw'},200);

			$('.customer_memo').hide();
			$('#'+Tmp_tr).fadeIn(300);

			Tmp=$(this).attr('id').replace("tag_","");
			$('#h_customer_page').val(Tmp);

			if(Tmp == 2){
				$('.customer_memo_set').show();
				$('.customer_log_set').hide();
				$.post({
					url:"./post/customer_memo_read.php",
					data:{
						'cast_id'	:CastId,
						'c_id':C_Id,
					},
				}).done(function(data, textStatus, jqXHR){
					if(data){
						$('#tag_2_tbl').html(data);
					}
				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log(textStatus);
					console.log(errorThrown);
				});

			}else if(Tmp == 3){
				$('.customer_log_set').show();
				$('.customer_memo_set').hide();
				$.post({
					url:"./post/customer_log_read.php",
					data:{
						'cast_id'	:CastId,
						'c_id'		:C_Id,
					},
				}).done(function(data, textStatus, jqXHR){
					if(data){
						$('#tag_3_tbl').html(data);
					}
				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log(textStatus);
					console.log(errorThrown);
				});

			}else if(Tmp == 4){
				$('.customer_log_set').hide();
				$('.customer_memo_set').hide();
				$.post({
					url:"./post/customer_config_read.php",
					data:{
						'c_id'		:C_Id,
					},
				}).done(function(data, textStatus, jqXHR){
					if(data){
						$('#tag_4_tbl').html(data);
					}
				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log(textStatus);
					console.log(errorThrown);
				});

			}else{
				$('.customer_log_set').hide();
				$('.customer_memo_set').hide();

				$.post({
					url:"./post/customer_detail_read.php",
					data:{
						'c_id':C_Id,
					},

				}).done(function(data, textStatus, jqXHR){
					$('#tag_1_tbl').html(data);

				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log(textStatus);
					console.log(errorThrown);
				});
			}
		}
	});

	$('#tag_4_tbl').on('change','.block_r',function () {

		Tmp=$(this).attr('id');
		$('#msg_'+Tmp).siblings().hide();
		$('#msg_'+Tmp).show();


		$.post({
			url:"./post/customer_config_chg.php",
			data:{
				'c_id'		:C_Id,
				'id'		:Tmp,
			},
		}).done(function(data, textStatus, jqXHR){

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#tag_4_tbl').on('click','.block_del',function () {
		Del_ID=C_Id;
		$('.set_back,.customer_memo_del_back_in').fadeIn(200);
		Flg="customer";
	});

	$('.blog_list').on('click','.blog_hist',function () {
		if($(this).next('.hist_log').css('display')=='none'){
			var TMp=$(this).children('.hidden_tag').val();

			$('.blog_hist').not(this).hide();
			$(this).next('.hist_log').slideDown(200);

			$('#regist_blog').fadeOut(200);
			$('.blog_ad,.blog_next').hide();

			$('#h_blog_tag').val($(this).children('.hidden_tag').val());
			$('#h_blog_status').val($(this).children('.hidden_status').val());
			$('#blog_chg').val($(this).attr('id').replace('blog_hist_',''));

			$('#h_blog_yy').val($(this).children('.hist_date').text().substr(0,4));
			$('#h_blog_mm').val($(this).children('.hist_date').text().substr(5,2));
			$('#h_blog_dd').val($(this).children('.hist_date').text().substr(8,2));
			$('#h_blog_hh').val($(this).children('.hist_date').text().substr(11,2));
			$('#h_blog_ii').val($(this).children('.hist_date').text().substr(14,2));

			$('#h_blog_title').val($(this).children('.hist_title').text());
			$('#h_blog_log').val($(this).next('.hist_log').children('.blog_log').html());
			$('#h_blog_img').val($(this).children('.hist_img').attr('id').replace('b_img_',''));
	
			if($(this).children('.hidden_status').val() ==2){
				$('.blog_open_no').addClass('no_on');
				$('.blog_open_yes').removeClass('yes_on');
			
			}else{
				$('.blog_open_no').removeClass('no_on');
				$('.blog_open_yes').addClass('yes_on');
			}

		}else{
			$('#blog_open').val('0');
			$('.hist_log').slideUp(200);
			$('.blog_hist').slideDown(200);
			$('#regist_blog').fadeIn(200);
			$('#blog_chg').val('');
			$('.blog_ad,.blog_next').show();
		}
	});

	$('.blog_list').on('click','.hist_log',function () {
		$('.hist_log').slideUp(200);
		$('.blog_hist').slideDown(200);
		$('#regist_blog').fadeIn(200);
		$('#blog_chg').val('');
	});

	$('.blog_open_yes').on('click',function () {
		$(this).addClass('yes_on');
		$('.blog_open_no').removeClass('no_on');
		$('#blog_status').val('0');
	});

	$('.blog_open_no').on('click',function () {
		$(this).addClass('no_on');
		$('.blog_open_yes').removeClass('yes_on');
		$('#blog_status').val('2');
	});

	$('.blog_list').on('click','.blog_next',function () {
		$('.blog_ad,.blog_next').hide();
		bId=$(this).attr('id').replace('blog_next_','');

		$.post({
			url:"./post/blog_reload.php",
			data:{
				'cast_id':CastId,
				'blog_id':bId,
			},
		}).done(function(data, textStatus, jqXHR){
			if(data){
				$('.blog_list').append(data);
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.customer_detail').on('click','.customer_fav',function () {
		if(Fav == 0){
			Fav=$(this).attr('id').replace('fav_','');
			$('.customer_base_fav').children().slice(0,Fav).css('color','#ff3030');
		}else{
			Fav=0;
			$('.customer_fav').css('color','#cccccc');
		}

		$.post({
			url:"./post/customer_detail_set3.php",
			data:{
			'c_id'		:C_Id,
			'fav'		:Fav,
			},

		}).done(function(data, textStatus, jqXHR){
			$('#h_customer_fav').val(Fav);
			$('#clist'+C_Id).children('.customer_hidden_fav').val(Fav);

			if(Fav>0){
				$('#fav_'+C_Id+'_1').addClass('fav_in');
			}else{
				$('#fav_'+C_Id+'_1').removeClass('fav_in');
			}

			if(Fav>1){
				$('#fav_'+C_Id+'_2').addClass('fav_in');
			}else{
				$('#fav_'+C_Id+'_2').removeClass('fav_in');
			}

			if(Fav>2){
				$('#fav_'+C_Id+'_3').addClass('fav_in');
			}else{
				$('#fav_'+C_Id+'_3').removeClass('fav_in');
			}

			if(Fav>3){
				$('#fav_'+C_Id+'_4').addClass('fav_in');
			}else{
				$('#fav_'+C_Id+'_4').removeClass('fav_in');
			}

			if(Fav>4){
				$('#fav_'+C_Id+'_5').addClass('fav_in');
			}else{
				$('#fav_'+C_Id+'_5').removeClass('fav_in');
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#tag_1_tbl').on('change','.item_textbox,.rd',function(){
		Tmp=$(this).attr('id');
		$.post({
			url:"./post/customer_detail_set4.php",
			data:{
				'tmp'		:Tmp,
				'c_id'		:C_Id,
				'value'		:$(this).val(),
			},
		}).done(function(data, textStatus, jqXHR){

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.tmpl_tag').on('click',function () {
		$('.tmpl_tag').removeClass('notice_sel');
		$(this).addClass('notice_sel');

		Tmp=$(this).attr('id').replace('tag','box');
		$('.tmpl_box').hide();
		$('#'+Tmp).show();
	});


	$('.mail_select').on('click',function () {
		Tmp=$(this).attr('id');
		$('.mail_select').removeClass('mail_select_on');
		$(this).addClass('mail_select_on');
		$('.mail_select_box').hide();
		$('#box_' + Tmp).fadeIn(300);
	});

	$('.mail_detail_in').on('click','.mail_box_new_list',function () {

		Tmp=$(this).attr('id').replace('tmpl_list','');
		Tmp2=$('#tmpl_area' + Tmp).val().replace('[名前]',Customer_Name).replace('[呼び名]',Customer_Nick);
		$('#easytalk_text').val(Tmp2);
		$('.filter_err').text('');
	});

	$('.tmpl_sel').on('change',function () {
		Tmp_n=$(this).val();
		if(Tmp_n==""){
			$('#tmpl_area9').val('')

		}else{
			Tmp=$('#tmpl_area' +Tmp_n).val();
			$('#tmpl_area9').val(Tmp);
		}
	});

	$('#filter_send_btn').on('click',function(){
		if($('#tmpl_area9').val() == ''){
			$('.filter_err').text('送信文がありません')
			return false
		}
		var Cnt=0;
		$('.filter_list').each(function(){
			if($(this).children('.filter_list_check').prop('checked') == true){
				Box[Cnt]=$(this).attr('id').replace('filter_list','');
				Cnt++;				
			}
		});

		if(Cnt == 0){
			$('.filter_err').text('送信対象ががいません')
			return false
		}
		console.log($('#tmpl_area9').val());
	
		$('#wait').show();
		$.post({
			url:"./post/easytalk_multi.php",
			data:{
				'log'		:$('#tmpl_area9').val(),
				'img_code'	:$('#easytalk_f_img').attr("src").replace(/^data:image\/jpeg;base64,/, ""),
				'list[]'	:Box,
			},
		}).done(function(data, textStatus, jqXHR){
			$('#wait').hide();
			$('.filter_main3').html(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.filter_main3').on('change','.filter_list_check',function () {
		if($(this).prop('checked') == true){
			$(this).next('.filter_list_send').find('.filter_list_check1,.filter_list_check3').show();		
		
		}else{
			$(this).next('.filter_list_send').find('.filter_list_check1,.filter_list_check3').hide();		
		}
	});

	$('.filter_btn').on('click',function (){
		$('#wait').show();
		var Yet=0;

		if($('#f_yet').prop('checked') == true){
			Yet=1;
		}

		$.post({
			url:"./post/easytalk_filter.php",
			data:{
				'yet'		:Yet,
				'type'		:$('#f_type').val(),
				'date'		:$('#f_date').val(),
				'tag'		:$('#filter_tag').val(),
				'fav'		:$('#fav_tag').val(),
			},
		}).done(function(data, textStatus, jqXHR){
		$('#wait').hide();
			$('.filter_main3').html(data);

			Tmp = $('.filter_main3').offset().top - VwBase*30;
			$('html,body').animate({'scrollTop':Tmp}, 1000, 'swing');

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.easytalk_top_name,.al_l').on('click',function (){
		$('.mail_detail').animate({'right':'-100vw'},100);
		$(".easytalk_top_name").text('');
		$('.easytalk_top').fadeOut(200);
		$('.mail_detail_in').html('');
	});

	$('.mail_hist').on('click',function () {
/*
		var Mail_block =$(this).children('.mail_block').val();
		if(Mail_block ==0){
			$('#easytalk_img').attr('id','easytalk_img').attr('src','../img/blog_no_image.png');
			$("#easytalk_text").prop("disabled", false);
			$(".write_box_out").hide();

		}else if(Mail_block ==1){
			$('#easytalk_img').attr('id','').attr('src','../img/blog_no_image_out.png');
			$("#easytalk_text").prop("disabled", false);
			$(".write_box_out").hide();

		}else{
			$(".write_box_out").show();
		}
*/
		Page=1;
		Customer_id		=$(this).attr('id').replace('mail_hist','');
		Customer_Nick	=$(this).children('.mail_nickname').text();
		Customer_Name	=$(this).children('.mail_name').val();
		Customer_mail	=$(this).children('.mail_address').val();

		$.post({
			url:"./post/easytalk_hist.php",
			data:{
				'c_id'		:Customer_id,
				'st'		:'0',
			},

		}).done(function(data, textStatus, jqXHR){
			Tmp="./index.php?cast_page=2&c_id="+Customer_id;

			console.log(Tmp);
			$('.mail_detail').animate({'right':'0'},100);
			$(".easytalk_top_name").text(Customer_Nick);
			$('.easytalk_top').fadeIn(200);
			$('.mail_detail_in').html(data);
			$('.easytalk_link').attr('href',Tmp);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.mail_detail').on('scroll', function() {
		var Pnt= $('.mail_detail').scrollTop();
		var	Hgt= $('.mail_detail_in').height();

		if($('.mail_detail_in_btm').length){
			var Lmt= $('.mail_detail_in_btm').offset().top;

			if(Pnt >Lmt){
				$('.mail_detail_in_btm').remove();
				$.post({
					url:"./post/easytalk_hist.php",
					data:{
						'st'		:Page,
						'c_id'		:Customer_id,
						'pnt'		:Pnt,
					},

				}).done(function(data, textStatus, jqXHR){
					Page++;
					$('.mail_detail_in').append(data);

				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log(textStatus);
					console.log(errorThrown);
				});
			}
		}
	});

	$('.mail_detail_in').on('click','.mail_box_new_msg',function () {
		if($('.mail_box_new_in').css('display') =='none'){
			$('.mail_box_new_in').slideDown(300);
			$('.mail_box_new_del').fadeIn(400);

		}else{
			$('.mail_box_new_in').slideUp(200);
			$('.mail_box_new_del').fadeOut(200);
		}
	});
/*
	$('.detail_modal_link').on('click','.modal_link_point',function () {
		Img=$(this).attr('id').replace('point_','');
		$('.link_point_on').removeClass('link_point_on');
		$(this).addClass('link_point_on');
		$('.detail_modal_img').attr('src',$('#' +Img + Tmp).val()).hide().fadeIn(100);
	});
*/

	$('.mail_detail_tmp').on('click',function () {
		Img=$(this).attr('id').replace('sum_','');
		$('.detail_modal').animate({'top':'0'},100);
		$('.detail_modal_img').attr('src',$('#' +Img + Tmp).val());
		$('#point_'+Img).addClass('link_point_on');
	});

	$('.detail_modal_out').on('click',function () {
		$('.detail_modal').animate({'top':'110vh'},100);
		$('.link_point_on').removeClass('link_point_on');
	});

	$('.regist_mail_set').on('click',function () {
		$('.mail_write').slideDown();
	});

	$('.head').on('click','.arrow_mail',function () {
		$(this).removeClass('arrow_mail');
		$('.mail_detail').animate({'right':'-100vw'},200);
		$('.head_mymenu_ttl').text('Easy Talk');
	});

	$('.reg_fav').on('click',function () {
		if($('#regist_fav').val()== 0){
			Tmp=$(this).attr('id').replace('reg_fav_','');
			$('.regist_fav').children().slice(0,Tmp).css('color','#ff3030');
			$('#regist_fav').val(Tmp);

		}else{
			$('.reg_fav').css('color','#cccccc');
			$('#regist_fav').val('0');
		}
	});

	$('#customer_regist_set').on('click',function () {
		if($('#regist_name').val() =='' && $('#regist_nick').val() ==''){
			alert('「名前」か「呼び名」どちらかは必要です');		
			return false;

		}else{
			$.post({
				url:"./post/customer_regist_set.php",
				data:{
					'group'		:$('#regist_group').val(),
					'name'		:$('#regist_name').val(),
					'nick'		:$('#regist_nick').val(),
					'fav'		:$('#regist_fav').val(),

					'yy'		:$('#reg_yy').val(),
					'mm'		:$('#reg_mm').val(),
					'dd'		:$('#reg_dd').val(),
					'ag'		:$('#reg_ag').val(),
					'img_code'	:base_64,
				},

			}).done(function(data, textStatus, jqXHR){
				$('.customer_all_in').append(data);
				$('.customer_regist').animate({'top':'100vh'},200);
				$('.set_back').fadeOut(100);

				$('#regist_group').val('0');
				$('#regist_name').val('');
				$('#regist_nick').val('');
				$('#regist_fav').val('0');

				$('#reg_yy').val('1980');
				$('#reg_mm').val('01');
				$('#reg_dd').val('01');
				$('#reg_ag').val('30');
				$('.reg_fav').css('color','#cccccc');

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});

	$('#reg_yy,#reg_mm,#reg_dd').on('change', function(){
		var Tmp=$('#reg_mm').val()+$('#reg_dd').val();
		if(Now_md <Tmp){
			Tmp2= Now_Y - parseInt($('#reg_yy').val(), 10)-1;

		}else{
			Tmp2= Now_Y - parseInt($('#reg_yy').val(), 10);
		}
		$('#reg_ag').val(Tmp2);
	});

	$('#reg_ag').on('change', function(){
		var Tmp=$('#reg_mm').val()+$('#reg_dd').val();

		if(Now_md <Tmp){
			Tmp2= Now_Y - parseInt($('#reg_ag').val(), 10)-1;

		}else{
			Tmp2= Now_Y - parseInt($('#reg_ag').val(), 10);
		}
		$('#reg_yy').val(Tmp2);
	});

	$('.menu_1').on('click',function () {
		$('.slide').animate({'left':'-70vw'},10);
		Tmp=$(this).attr('id').replace('m','');
		 window.location.href = './index.php?cast_page='+Tmp;
	});

	$('#regist_customer').on('click',function () {
		$('.set_back').fadeIn(100);
		$('.customer_regist').animate({'top':'20vh'},200);
		C_Id_Tmp=C_Id;
		C_Id=0;	
	});

	$('.customer_regist_no').on('click',function () {
		$('.customer_regist').animate({'top':'100vh'},200);
		$('.set_back').fadeOut(100);
	});

	$('#regist_blog').on('click',function () {
		if($('.blog_write').css('display') == 'none'){
			var now = new Date();
			var yy = now.getFullYear();
			var mm = now.getMonth() + 1;
			var mm = "0" + mm;
			var dd = "0" + now.getDate();
			var hh = "0" + now.getHours();
			var ii = "0" + now.getMinutes();

			$('.blog_write').slideDown(100);
			$('.blog_list').hide();
			$('#blog_yy').val(yy);
			$('#blog_mm').val(mm.substr(-2));
			$('#blog_dd').val(dd.substr(-2));
			$('#blog_hh').val(hh.substr(-2));
			$('#blog_ii').val(ii.substr(-2));

			$('#blog_title').val('');
			$('#blog_log').val('');
			$('#blog_status').val('');
			$('#blog_tag').val('5');

			$('.blog_img').attr('src','../img/blog_no_image.png');

		}else{
			$('.blog_write').slideUp(50);
			$('.blog_list').show();
		}
	});

	$('#regist_blog_fix').on('click',function () {
		if($('.blog_write').css('display') == 'none'){
			$('.blog_write').slideDown(100);
			$('.blog_list').hide();

			TmpLog=$('#h_blog_log').val().replace(/(<br>|<br \/>)/gi, '\n');
			$('#blog_yy').val($('#h_blog_yy').val());
			$('#blog_mm').val($('#h_blog_mm').val());
			$('#blog_dd').val($('#h_blog_dd').val());
			$('#blog_hh').val($('#h_blog_hh').val());
			$('#blog_ii').val($('#h_blog_ii').val());
			$('#blog_title').val($('#h_blog_title').val());
			$('#blog_log').val(TmpLog);

			$('#blog_status').val($('#h_blog_status').val());
			if($('#h_blog_status').val() == 1){
				$('.blog_open_yes').removeClass('yes_on');
				$('.blog_open_no').addClass('no_on');
			}


			$('#blog_tag').val($('#h_blog_tag').val());
			if($('#h_blog_img').val()){
				$('.blog_img').attr('src','../img/profile/'+ CastId +'/' + $('#h_blog_img').val() + '_s.png');
				ImgId=$('#h_blog_img').val();

			}else{
				$('.blog_img').attr('src','../img/blog_no_image.png');
				ImgId='';
			}

		}else{
			$('.blog_write').slideUp(50);
			$('.blog_list').show();
		}
	});

	$('#upd').on('change', function(e){
		var Zoom		=100;
		var Left		=Width_s;
		var Top			=Width_s;
		var Rote		=0;
		$("#cvs1").css({'width': Width_l,'height': Width_l,'left': Width_s,'top': Width_s, 'transform':'rotate(0deg)'});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
		$('#input_zoom').val(Zoom);

		var file = e.target.files[0];	
		var reader = new FileReader();

		if(file.type.indexOf("image") < 0){
			alert("NO IMAGE FILES");
			return false;
		}

		var img = new Image();
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');

		reader.onload = (function(file){
			return function(e){
				img.src = e.target.result;
				$("#view").attr("src", e.target.result);
				$("#view").attr("title", file.name);

				img.onload = function() {
					img_W=img.width;
					img_H=img.height;
					img_S2=60*VwBase;

					if(img_H > img_W){
						cvs_W=600;
						cvs_H=Math.ceil(img_H*(cvs_W/img_W));
						cvs_A=cvs_H;

						cvs_X=Math.ceil((cvs_H-cvs_W)/2);
						cvs_Y=0;

						css_W=Width_l;
						css_H=Math.ceil(img_H*(css_W/img_W));
						css_A=css_H;

						css_B=Math.ceil(Width_s - (css_A-Width_l)/2);

						css_inY=0;
						css_inX=Math.ceil( (css_A - img_S2) / 2);


					}else{
						cvs_H=600;
						cvs_W=Math.ceil(img_W*(cvs_H/img_H));
						cvs_A=cvs_W;

						cvs_Y=Math.ceil((cvs_W-cvs_H)/2);
						cvs_X=0;

						css_H=Width_l;
						css_W=Math.ceil(img_W*(css_H/img_H));
						css_A=css_W;
						css_B=Math.ceil(Width_s - (css_A-Width_l)/2);

						css_inX=0;
						css_inY=Math.ceil( (css_A - img_S2) / 2 );
					}				




					$("#cvs1").attr({'width': cvs_A,'height': cvs_A}).css({'width': css_A,'height': css_A,'left': css_B,'top': css_B});
					ctx.drawImage(img, 0,0, img_W, img_H,cvs_X, cvs_Y, cvs_W, cvs_H);
					ImgCode = cvs.toDataURL("image/jpeg");

					$('#img_top').val(css_B);
					$('#img_left').val(css_B);

						ImgWidth	=css_A;
						ImgHeight	=css_A;
						ImgTop		=css_B;
						ImgLeft		=css_B;
						Rote		=0;
						Zoom		=100;
				}
			};
		})(file);

		reader.readAsDataURL(file);

		$('#upd').fileExif(function(exif) {

			if (exif['Orientation']) {

				switch (exif['Orientation']) {
				case 3:
					Rote = 180;
					$('#cvs1').css({
						'transform':'rotate(180deg)',
					});

					break;

				case 8:
					Rote = 270;
					$('#cvs1').css({
						'transform':'rotate(270deg)',

					});
					break;

				case 6:
					Rote = 90;
					$('#cvs1').css({
						'transform':'rotate(90deg)',
					});
					break;
				}
			}
		});
	});


	$("#cvs1").draggable({
		drag: function( event, ui ){
			if(ui.position.top > Math.floor(VwBase*10-css_inY*Zoom/100)){
				ui.position.top=Math.floor(VwBase*10-css_inY*Zoom/100);
			}
			if(ui.position.left > Math.floor(VwBase*10 -css_inX*Zoom/100)){
				ui.position.left=Math.floor(VwBase*10  -css_inX*Zoom/100);

			}
			 if(ui.position.top  < Math.floor(VwBase * 70 - (css_A - css_inY) * Zoom / 100) ){
				ui.position.top=Math.floor(VwBase * 70 - (css_A - css_inY) * Zoom / 100);
			}

			 if(ui.position.left  < Math.floor( VwBase * 70 - ( css_A - css_inX ) * Zoom / 100) ){
				ui.position.left=Math.floor( VwBase * 70 - ( css_A - css_inX) * Zoom / 100);
			}
		}
	});

	$("#cvs1").on("mousemove", function() {
		ImgLeft = $("#cvs1").css("left");
		ImgTop = $("#cvs1").css("top");

		$('#img_top').val(ImgTop);
		$('#img_left').val(ImgLeft);
	});


	$('.head').on('click','.arrow_top',function(){
		 window.location.href = './';


	});

	$('.head').on('click','.arrow_customer',function(){
		$('.head_mymenu_comm').removeClass('arrow_customer').addClass('arrow_top');
		$('.customer_detail').animate({'left':'100vw'},150).css('top','0');

		$('#regist_customer').fadeIn(150);
		$('.head_mymenu_ttl').html('顧客リスト');
		$('.menu').css({'heigh':'auto'});
		$('.pg3').hide();
		$('.pg2').show();

		$('.customer_sns_box').hide();
		$('.customer_sns_tr').hide();
		$('.sns_arrow_a').hide();
		$('.sns_text').val('');

		$('.customer_sns_box,.sns_arrow_a,.customer_sns_btn').removeClass('c_customer_twitter c_customer_facebook c_customer_insta c_customer_web c_customer_line c_customer_tel c_customer_mail');
		$('.sns_jump').removeClass('jump_on');

		$('.tag_set').removeClass('tag_set_ck').animate({'height':'5.5vw'},300);
		$('#tag_3').addClass('tag_set_ck').animate({'height':'8vw'},300);

		$('.customer_memo').hide();
		$('#tag_3_tbl').show();
		$('.customer_fav').css('color','#cccccc');
		$('.main').css('position','static');

		$('#h_customer_id,#h_customer_set,#h_customer_page,#h_customer_fav,#h_customer_tel,#h_customer_mail,#h_customer_twitter,#h_customer_facebook,#h_customer_insta,#h_customer_web,#h_customer_line').val('');
		$('#tag_2_tbl,#tag_1_tbl').empty();
	});


	$('.customer_detail').draggable({
		axis: 'x',
		handle:'.customer_detail_in',
		start: function( event, ui ) {
			startPosition = ui.position.left;
		},
		drag: function( event, ui ) {
			if(ui.position.left < startPosition) ui.position.left = startPosition;
		},
		stop: function( event, ui ) {
			if(ui.position.left > 50){
				$('.customer_detail').animate({'left':'100vw'},200);

				$('.head_mymenu_comm').removeClass('arrow_customer').addClass('arrow_top');
				$('.customer_detail').animate({'left':'100vw'},150).css('top','0');

				$('#regist_customer').fadeIn(150);
				$('.head_mymenu_ttl').html('顧客リスト');
				$('.menu').css({'heigh':'auto'});
				$('.pg3').hide();
				$('.pg2').show();
				$('.customer_sns_box').hide();
				$('.customer_sns_tr').hide();
				$('.sns_arrow_a').hide();
				$('.sns_text').val('');

				$('.customer_sns_box,.sns_arrow_a,.customer_sns_btn').removeClass('c_customer_twitter c_customer_facebook c_customer_insta c_customer_web c_customer_blog c_customer_tel c_customer_mail');

				$('.sns_jump').removeClass('jump_on');

				$('.tag_set').removeClass('tag_set_ck').animate({'height':'5.5vw'},300);
				$('#tag_3').addClass('tag_set_ck').animate({'height':'8vw'},300);


				$('.tag_set').removeClass('tag_set_ck').animate({'height':'5.5vw'},300);
				$('#tag_3').addClass('tag_set_ck').animate({'height':'8vw'},300);

				$('.customer_memo').hide();
				$('#tag_3_tbl').show();
				$('.customer_fav').css('color','#cccccc');

			}else{
				$('.customer_detail').animate({'left':'0vw'},200);
				$('.menu').css({'heigh':'auto'});
			}
		}
	});


	$('#customer_up').on('click',function () {
		$(this).fadeOut(150);
		$('.customer_detail').animate({'top':'-44vw'},500);

		if($('.customer_sns_box').css('display') !== 'none'){
			$('.pg3').animate({'margin-top':'58vw'},500);
		}else{
			$('.pg3').animate({'margin-top':'38vw'},500);
		}
	});

	$('#customer_down').on('click',function () {
		$('#customer_up').fadeIn(150);
		$('.customer_detail').animate({'top':'0'},500);

		if($('.customer_sns_box').css('display') !== 'none'){
			$('.pg3').animate({'margin-top':'102vw'},500);
		}else{
			$('.pg3').animate({'margin-top':'82vw'},500);
		}
	});

	$('.body').on('click','.clist',function(){
		$('.head_mymenu_comm').addClass('arrow_customer').removeClass('arrow_top');
		$('.customer_detail').animate({'left':'0'},200);

		C_Id=$(this).attr('id').replace('clist','');
		$.post({
			url:"./post/customer_detail.php",
			data:{
				'c_id'		:C_Id,
			},

		}).done(function(data, textStatus, jqXHR){
			$('.customer_detail').html(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});


	});

/*
	$('.main').on('click','.customer_list',function(){
		$('.head_mymenu_comm').addClass('arrow_customer').removeClass('arrow_top');
		$('.pg2').delay(200).fadeOut(0);
		$('.pg3').delay(200).fadeIn(0).scrollTop(0);

		ListTop=$(window).scrollTop()
		$(window).scrollTop(0);

		C_Id=$(this).attr('id').replace('clist','');

		Tmp=$(this).children('.mail_img').attr('src');
		$('#customer_img').attr('src',Tmp);

		Tmp=$(this).children('.customer_list_name').html().replace(' 様','');
		$('#customer_detail_name').val(Tmp);

		Tmp2=$(this).children('.customer_list_nickname').html();
		if(Tmp2){
			$('#customer_detail_nick').val(Tmp2);
			$('.head_mymenu_ttl').html(Tmp2);
		}else{
			$('.head_mymenu_ttl').html(Tmp+"様");
		}

		Tmp=$(this).children('.customer_hidden_fav').val();
			if(Tmp>0){
				$('#fav_1').css('color','#ff3030');
			}
			if(Tmp>1){
				$('#fav_2').css('color','#ff3030');
			}

			if(Tmp>2){
				$('#fav_3').css('color','#ff3030');
			}

			if(Tmp>3){
				$('#fav_4').css('color','#ff3030');
			}

			if(Tmp>4){
				$('#fav_5').css('color','#ff3030');
			}
		Fav=Tmp;

		$('#area').val(1);
		$('#h_customer_id').val(C_Id);
		$('#h_customer_set').val("1");
		$('#h_customer_page').val("1");

		Tmp=$(this).children('.customer_hidden_group').val();
		$('#customer_group').val(Tmp);

		Tmp=$(this).children('.customer_hidden_yy').val();
		$('#customer_detail_yy').val(Tmp);

		Tmp=$(this).children('.customer_hidden_mm').val();
		$('#customer_detail_mm').val(Tmp);

		Tmp=$(this).children('.customer_hidden_dd').val();
		$('#customer_detail_dd').val(Tmp);

		Tmp=$(this).children('.customer_hidden_ag').val();
		$('#customer_detail_ag').val(Tmp);

		Tmp=$(this).children('.customer_hidden_face').val();
		$('#img_url').val(Tmp);

		Tmp=$(this).children('.customer_hidden_fav').val();
		$('#h_customer_fav').val(Tmp);

		Tmp=$(this).children('.customer_hidden_tel').val();
		$('#h_customer_tel').val(Tmp);
		if(Tmp){
			$('#customer_tel').addClass('c_customer_tel');		
		}

		Tmp=$(this).children('.customer_hidden_mail').val();
		$('#h_customer_mail').val(Tmp);
		if(Tmp){
			$('#customer_mail').addClass('c_customer_mail');		
		}

		Tmp=$(this).children('.customer_hidden_twitter').val();
		$('#h_customer_twitter').val(Tmp);
		if(Tmp){
			$('#customer_twitter').addClass('c_customer_twitter');		
		}

		Tmp=$(this).children('.customer_hidden_facebook').val();
		$('#h_customer_facebook').val(Tmp);
		if(Tmp){
			$('#customer_facebook').addClass('c_customer_facebook');		
		}

		Tmp=$(this).children('.customer_hidden_insta').val();
		$('#h_customer_insta').val(Tmp);
		if(Tmp){
			$('#customer_insta').addClass('c_customer_insta');		
		}

		Tmp=$(this).children('.customer_hidden_line').val();
		$('#h_customer_line').val(Tmp);
		if(Tmp){
			$('#customer_line').addClass('c_customer_line');		
		}

		Tmp=$(this).children('.customer_hidden_web').val();
		$('#h_customer_web').val(Tmp);
		if(Tmp){
			$('#customer_web').addClass('c_customer_web');		
		}

		$('.customer_detail').animate({'left':'0'},200);
		$('.menu').css({'height':'100vh'});
		$('#regist_customer').fadeOut(150);

		$.post({
			url:"./post/customer_log_read.php",
			data:{
				'c_id'		:C_Id,
			},

		}).done(function(data, textStatus, jqXHR){
			$('#tag_3_tbl').html(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});
*/


	$('.config_btn').on('click',function(){
		$('.set_back').fadeIn(200);
		$('.customer_regist').animate({'top':'20vh'},200);
	});


	$('#blog_set').on('click',function(){

		$('#blog_hist_'+$('#blog_chg').val()).remove();
		$.post({
			url:"./post/blog_set.php",
			data:{
				'ttl':$('#blog_title').val(),
				'log':$('#blog_log').val(),
				'tag':$('#blog_tag').val(),
				'chg':$('#blog_chg').val(),
				'status':$('#blog_status').val(),

				'yy':$('#blog_yy').val(),
				'mm':$('#blog_mm').val(),
				'dd':$('#blog_dd').val(),
				'hh':$('#blog_hh').val(),
				'ii':$('#blog_ii').val(),

				'img_id':ImgId,
				'img_code':base_64
			},

		}).done(function(data, textStatus, jqXHR){
			$('.blog_write').slideUp(300);
			$('.blog_list').show().prepend(data);
			$('.no_data').hide();
			var base_64='';

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.sns_btn').on('click',function(){
		$.post({
			url:"./post/customer_sns_set.php",
			data:{
				'c_id':C_Id,
				'text':$('.sns_text').val(),
				'kind':Tmp.replace('customer_',''),
			},

		}).done(function(data, textStatus, jqXHR){
			if($('.sns_text').val()){
				$('#'+Tmp).addClass('c_'+Tmp);		
				$('.customer_sns_box').addClass('c1_'+Tmp);		
				$('#a_'+Tmp).addClass('c_'+Tmp);
				$('.sns_jump').addClass('jump_on c2_'+Tmp);

			}else{

				$('#'+Tmp).removeClass('c_'+Tmp);		
				$('.customer_sns_box').removeClass('c1_'+Tmp);		
				$('#a_'+Tmp).removeClass('c_'+Tmp);
				$('.sns_jump').removeClass('jump_on c2_'+Tmp);
			}

			$('#h_customer_'+data).val($('.sns_text').val());

			$('#clist'+C_Id).children('.customer_hidden_'+data).val($('.sns_text').val());

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#regist_schedule').on('click',function(){
		$('.cal_weeks').animate({'top':'18vw'},200);
		$('.set_back').fadeIn(100);
	});

	$('.customer_detail').on('click','.customer_sns_btn',function(){

		if($('.customer_sns_box').css('display') !== 'none'){

			if($('#customer_up').css('display') !== 'none'){
				$('.pg3').animate({'margin-top':'82vw'},100);
			}else{
				$('.pg3').animate({'margin-top':'38vw'},100);
			}
			$('.customer_sns_box').slideUp(100);
			$('.customer_sns_tr').slideUp(100);
			$('.sns_arrow_a').hide();
			$('.sns_text').val('');

			$('.customer_sns_box').removeClass('c1_'+Tmp);
			$('.sns_jump').removeClass('jump_on c2_'+Tmp);
		}

		if(Tmp != $(this).attr('id')){
			Tmp=$(this).attr('id');
			$('#a_'+Tmp).show();
			TmpH=$('#h_'+Tmp).val();

			if(TmpH){
				SnsColor=$(this).css('background');
				
				$('.sns_text').val($('#h_'+Tmp).val());
				$('#a_'+Tmp).addClass('c_'+Tmp);
				$('.customer_sns_box').addClass('c1_'+Tmp);

				if(Tmp == 'customer_mail'){
					$('.sns_jump').addClass('jump_on c2_'+Tmp).attr('href',SNS_LINK[Tmp]);

					$('#sns_form').attr('action',SNS_LINK[Tmp]);
					$('#sns_form_hidden').val('3');
					$('#sns_form_customer').val(C_Id);

				}else{
					$('.sns_jump').addClass('jump_on c2_'+Tmp);
					$('#sns_form').attr('action',SNS_LINK[Tmp]+$('#h_'+Tmp).val());
				}

				$('.customer_sns_ttl').css('color',SnsColor).text($('#n_'+Tmp).val());
			}

			$('.customer_sns_box').slideDown(200);
			$('.customer_sns_tr').slideDown(200);
//			$('.pg3').animate({'margin-top':'102vw'},200);

			if($('#customer_up').css('display') !== 'none'){
				$('.pg3').animate({'margin-top':'102vw'},200);
			}else{
				$('.pg3').animate({'margin-top':'58vw'},200);
			}

		}else{
			Tmp='';
		}
	});



	$('.customer_detail').on('click','.jump_on',function(){
		if($(this).hasClass('c2_customer_mail')){
			 window.location.href = './index.php?cast_page=3&c_id='+C_Id;

		}else{
			$('#sns_form').submit();
		}
	});

	$('.blog_td_img').on('click',function(){
		Task="blog";
		$('.img_box').animate({'top':'10vw'},200);
		$('.set_back').fadeIn(100);
/*
		var ChgImg = new Image();
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');

		ChgImg.src	='./img/profile/'+ CastId +'/' + ImgId + '.png';
		ImgWidth	=Width_l;
		ImgHeight	=Width_l;
		ImgTop		=Width_s;
		ImgLeft		=Width_s;
		Rote		=0;
		Zoom		=100;

		cvs_A		=800;
		cvs_W		=800;
		cvs_H		=800;
		cvs_X		=0;
		cvs_Y		=0;

		css_l		=Width_l;
		css_p		=Width_s;
		css_A		=Width_l;
		css_B		=Width_s;

		$("#cvs1").attr({'width': 800,'height': 800}).css({'width':ImgWidth,'height':ImgHeight,'top':ImgTop,'left':ImgLeft});
		ctx.drawImage(ChgImg, 0, 0, 600,600,0,0,800, 800);
		ImgCode = cvs.toDataURL("image/jpeg");
//----------------------------
*/
	});


	$('#easytalk_f_img').on('click',function(){
		Task="filter";
		$('.img_box').animate({'top':'10vw'},200);
		$('.set_back').fadeIn(100);
	});


	$('#set_new_img').on('click',function(){
		$('.img_box').animate({'top':'10vw'},200);
		$('.set_back').fadeIn(100);
		$('#img_code').val('');
		Task="regist";
	});

	$('.customer_detail_img').on('click',function(){
		$('.img_box').animate({'top':'10vw'},200);
		$('.set_back').fadeIn(100);
		$('#img_code').val('');
		Task="chg";

		Img=$(this).attr("src");
		var ChgImg = new Image();
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');

		ChgImg.src=Img;
		cvs_A=300;
		cvs_W=300;
		cvs_H=300;

		cvs_X=300;
		cvs_Y=300;
		cvs_B=50;

		css_l=300;
		css_p=50;

		css_A=60*VwBase;
		css_B=10*VwBase;


		ImgTop		=css_p;
		ImgLeft		=css_p;

		$("#cvs1").attr({'width': 300,'height': 300}).css({'width': '60vw','height': '60vw','left': '10vw','top': '10vw'});
		ctx.drawImage(ChgImg, 0, 0, 300,300,0,0,300, 300);
		ImgCode = cvs.toDataURL("image/jpeg");
	});

	$('.mail_detail_in').on('click','#easytalk_img',function(){
		$('.img_box').animate({'top':'10vw'},200);
		$('.set_back').fadeIn(100);
		Task="mail";

		if($('#easytalk_img').attr('src') != '../img/blog_no_image.png'){

			Img=$('#easytalk_img').attr("src");
			var ChgImg = new Image();
			var cvs = document.getElementById('cvs1');
			var ctx = cvs.getContext('2d');

			ChgImg.src=Img;
			cvs_A=300;
			cvs_W=300;
			cvs_H=300;

			cvs_X=300;
			cvs_Y=300;
			cvs_B=50;

			css_l=300;
			css_p=50;

			css_A=60*VwBase;
			css_B=10*VwBase;

			ImgTop		=css_p;
			ImgLeft		=css_p;

			$("#cvs1").attr({'width': 300,'height': 300}).css({'width': '60vw','height': '60vw','left': '10vw','top': '10vw'});
			ctx.drawImage(ChgImg, 0, 0, 600,600,0,0,300, 300);
			ImgCode = cvs.toDataURL("image/jpeg");
		}
	});

	$('#img_set').on('click',function(){	
		$('#wait').show();
		$.post({
			url:"./post/img_set.php",
			data:{
				'img_code'	:ImgCode.replace(/^data:image\/jpeg;base64,/, ""),

				'img_top'	:ImgTop,
				'img_left'	:ImgLeft,
				'img_width'	:cvs_W,
				'img_height':cvs_H,

				'img_zoom'	:Zoom,
				'img_rote'	:Rote,

				'width_s'	:Width_s,
				'width_l'	:Width_l,

				'task'		:Task,
				'post_id'	:C_Id,
			},

		}).done(function(data, textStatus, jqXHR){
			base_64=data;

			$('.img_box').animate({'top':'120vh'},200);
			var cvs = document.getElementById('cvs1');
			var ctx = cvs.getContext('2d');
			ctx.clearRect(0, 0, cvs_A,cvs_A);

			if(Task=="blog"){
				if(base_64){
					$('.blog_img').attr('src',"data:image/jpg;base64,"+ base_64);
				}else{
					$('.blog_img').attr('src',"../img/blog_no_image.png");
				}
				$('.set_back').fadeOut(200);

			}else if(Task=="regist"){
				if(base_64){
					$('.regist_img').attr('src',"data:image/jpg;base64,"+ base_64);
				}else{
					$('.regist_img').attr('src',"../img/customer_no_image.png");
				}

			}else if(Task=="chg"){
				if(base_64){
					$('.customer_detail_img').attr('src',"data:image/jpg;base64,"+ base_64);
					$('#clist' +C_Id).children('.mail_img').attr('src',"data:image/jpg;base64,"+ base_64);
				}else{
					$('.customer_detail_img').attr('src',"../img/customer_no_image.png");
					$('#clist' +C_Id).children('.mail_img').attr('src',"../img/customer_no_image.png");
				}

				$('.set_back').fadeOut(200);

			}else if(Task=="filter"){
				if(base_64){
					$('#easytalk_f_img').attr('src',"data:image/jpg;base64,"+ base_64);
				}else{
					$('#easytalk_f_img').attr('src',"../img/blog_no_image.png");
				}
				$('.set_back').fadeOut(200);

			}else if(Task=="mail"){
				if(base_64){
					$('#easytalk_img').attr('src',"data:image/jpg;base64,"+base_64);
				}else{
					$('#easytalk_f_img').attr('src',"../img/blog_no_image.png");
				}
				$('.set_back').fadeOut(200);
			}
			$('.filter_err').text('');
			$('#img_hidden').val(base_64);
			$('#wait').hide();
			$('.zoom_box').text('100');
			$('#img_zoom').val('100');
			$('#input_zoom').val('100');
			Rote=0;

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#img_close').on('click',function(){	
		$('.set_back').fadeOut(200);
		$('.img_box	').animate({'top':'120vh'},200);

		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');
		ctx.clearRect(0, 0, cvs_A,cvs_A);
	});

	$('.mail_detail_in').on('click','.mail_box_del',function(){
		Tmp=$(this).attr('id').replace('m_del','');
	});

	$('.upload_trush').on('click',function(){	
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');
		ctx.clearRect(0, 0, cvs_A,cvs_A);
		$('.mail_img_view').hide().attr('src',"");
		ImgCode='';
	});

	$('.upload_rote').on('click',function(){
		$({deg:Rote}).animate({deg:-90 + Rote}, {
			duration:500,
			progress:function() {
				$('#cvs1').css({
					'transform':'rotate(' + this.deg + 'deg)',
				});
			},
		});
		Rote -=90;
		if(Rote <0){
			Rote+=360;
		}
		Tmp			=css_inX;
		css_inX		=css_inY;
		css_inY		=Tmp;
	});

	$('.zoom_mi').on( 'click', function () {
		Zoom--;
		if(Zoom <100){
			Zoom=100;
		}

		var css_An	=Math.floor(Zoom*css_A/100);
		$("#cvs1").css({'width':css_An,'height':css_An});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
		$('#input_zoom').val(Zoom);
	});

	$( '.zoom_pu' ).on( 'click', function () {
		Zoom++;
		if(Zoom >300){
			Zoom=300;
		}

		var css_An	=Math.floor(Zoom*css_A/100);
		$("#cvs1").css({'width':css_An,'height':css_An});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
		$('#input_zoom').val(Zoom);
	});

	$( '#input_zoom' ).on( 'input', function () {
		Zoom=$(this).val();
		if(Zoom > 300){
			Zoom=300;
		}
		if(Zoom < 100){
			Zoom=100;	
		}

		var css_An	=Math.floor(Zoom*css_A/100);
		$("#cvs1").css({'width':css_An,'height':css_An});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
	});

	$('#img_reset').on( 'click', function () {
		Zoom=100;
		Left=css_B;
		Right=css_B;
		Rote=0;
		$("#cvs1").css({'width': css_A,'height': css_A,'left': css_B,'top': css_B, 'transform':'rotate(0deg)'});

		$('.zoom_box').text(Zoom);
		$('#img_zoom').val(Zoom);
		$('#input_zoom').val(Zoom);
	});

	$('.img_open').on( 'click', function () {
		$('.back').fadeIn(500);
	});

	$('.sch_set').on('click',function () {
		  $.ajax({
				url:'./post/sch_set.php',
				type: 'post',
				data:{
					'base_day':$('#base_day').val(),
					'sel_in[0]':$('.cal_weeks_box_2').children().eq(7).children('.sch_time_in').val(),
					'sel_in[1]':$('.cal_weeks_box_2').children().eq(8).children('.sch_time_in').val(),
					'sel_in[2]':$('.cal_weeks_box_2').children().eq(9).children('.sch_time_in').val(),
					'sel_in[3]':$('.cal_weeks_box_2').children().eq(10).children('.sch_time_in').val(),
					'sel_in[4]':$('.cal_weeks_box_2').children().eq(11).children('.sch_time_in').val(),
					'sel_in[5]':$('.cal_weeks_box_2').children().eq(12).children('.sch_time_in').val(),
					'sel_in[6]':$('.cal_weeks_box_2').children().eq(13).children('.sch_time_in').val(),

					'sel_out[0]':$('.cal_weeks_box_2').children().eq(7).children('.sch_time_out').val(),
					'sel_out[1]':$('.cal_weeks_box_2').children().eq(8).children('.sch_time_out').val(),
					'sel_out[2]':$('.cal_weeks_box_2').children().eq(9).children('.sch_time_out').val(),
					'sel_out[3]':$('.cal_weeks_box_2').children().eq(10).children('.sch_time_out').val(),
					'sel_out[4]':$('.cal_weeks_box_2').children().eq(11).children('.sch_time_out').val(),
					'sel_out[5]':$('.cal_weeks_box_2').children().eq(12).children('.sch_time_out').val(),
					'sel_out[6]':$('.cal_weeks_box_2').children().eq(13).children('.sch_time_out').val(),
				},
				dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$.each(data, function(a1, a2){
				if(a2){
					$('#c'+a1).children('.cal_i2').addClass('n2');
				}else{
					$('#c'+a1).children('.cal_i2').removeClass('n2');
				}
			})
			$('.sch_set_done').fadeIn(500).delay(1500).fadeOut(1000);
			$('.cal_weeks').animate({'top':'100vh'},200);
			$('.set_back').fadeOut(100);


		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#sch_set_arrow').on('click',function () {
		$('.cal_weeks').animate({'top':'100vh'},200);
		$('.set_back').fadeOut(100);
	});

	$('#sch_set_trush').on('click',function () {
//		$('.sch_time_in,.sch_time_out').val("");
		$('.cal_weeks_box_2').children().slice(7,14).children('.sch_time_in,.sch_time_out').val("");
	});

	$('#memo_del').on('click',function () {
		$('.customer_memo_new_txt').val("");
	});

	$('#memo_reset').on('click',function () {
		$('.set_back').fadeOut(200);
		$('.customer_memo_in').animate({'top':'100vh'},200);
		$('#memo_chg_id').val('');
	});

	$('.customer_memo_set').on('click',function () {
		if($('.set_back').css('display') ==='none'){
			$('.set_back').fadeIn(200);
			$('.customer_memo_in').animate({'top':'20vh'},200);
		
		}else{
			$('#memo_chg_id').val('');
			$('.set_back').fadeOut(200);
			$('.customer_memo_in').animate({'top':'100vh'},200);
		}
	});

	$('.customer_log_set').on('click',function () {
		if($('.set_back').css('display') ==='none'){
			$('.set_back').fadeIn(200);
			$('.customer_log_in').animate({'top':'20vh'},200);
		
		}else{
			$('.set_back').fadeOut(200);
			$('.customer_log_in').animate({'top':'100vh'},200);
		}
	});

	$('#tag_3_tbl').on('click','.customer_log_chg',function () {
		if($('.set_back').css('display') ==='none'){
			Chg=$(this).attr('id').replace('l_chg','');
			$('.set_back').fadeIn(200);
			$('.customer_log_in').animate({'top':'20vh'},200);

			TmpLog=$(this).next().next().html().replace(/(<br>|<br \/>)/gi, '\n');
			TmpTag=$(this).next().next().next().next().html();

			TmpPts=$(this).next().next().next().children('.sel_log_price_s').text();
			TmpD=$(this).prev().children('.customer_log_date_detail').text().substr(0,4)+"-"+$(this).prev().children('.customer_log_date_detail').text().substr(5,2)+"-"+$(this).prev().children('.customer_log_date_detail').text().substr(8,2);

			$('#local_dt').val(TmpD);
			$('#local_st').val($(this).prev().children('.customer_log_date_detail').text().substr(11,5));
			$('#local_ed').val($(this).prev().children('.customer_log_date_detail').text().substr(17,5));

			$('#sel_log_area').val(TmpLog);
			$('.customer_log_right').html(TmpTag);
			$('.customer_log_right div').removeClass('customer_log_item').addClass('sel_log_option_s').append('<span class=\"sel_log_del_s\"></span>');

			$('#sel_log_pts').val(TmpPts);

		}else{
			Chg='';
			$('.set_back').fadeOut(200);
			$('.customer_log_in').animate({'top':'100vh'},200);
		}
	});

	$('#memo_set').on('click',function () {
		Log=$('.customer_memo_new_txt').val();
		var TmpMemoId=$('#memo_chg_id').val();

		$.post({
			url:"./post/customer_memo_set.php",
			data:{
				'c_id'		:C_Id,
				'log'		:Log,
				'memo_id'	:TmpMemoId,
			},

		}).done(function(data, textStatus, jqXHR){
			if($('#memo_chg_id').val('')){
				$('#tr_memo_detail'+TmpMemoId).remove();
				$('#tr_memo_log'+TmpMemoId).remove();
				$('#customer_memo_nodata').hide();
			}

			$('.set_back').fadeOut(200);
			$('.customer_memo_in').animate({'top':'100vh'},200);
			$('#tag_2_tbl').prepend(data);
			$('.customer_memo_new_txt').val('');

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#tag_2_tbl').on('click','.customer_memo_chg',function () {

		Tmp=$(this).attr('id').replace("m_chg","");
		$('.set_back').fadeIn(200);
		$('.customer_memo_in').animate({'top':'20vh'},200);
		$('#memo_chg_id').val(Tmp);
		TmpLog=$('#m_log'+Tmp).html().replace(/(<br>|<br \/>)/gi, '\n')
		$('.customer_memo_new_txt').val(TmpLog);
	});

	$('#item_sort').on('click','.log_td_del',function () {
		$('.set_back,.log_list_del').fadeIn(200);
		Tmp_DelList=$(this).parents('tr').attr('id').replace("i","");

		$('.log_list_del_icon').text($(this).next().next().next().children('.item_icon').text());
		$('.log_list_del_name').text($(this).next().next().next().next().children('.item_name').val());
		$('.log_list_del_price').text($(this).next().next().next().next().next().children('.item_price').val());
		$('.log_list_del_item').css({'color':$(this).next().next().next().css('color'),'border-color':$(this).next().next().next().css('color')});
	});


	$(".mail_detail_in").on('click','#easytalk_send',function(){
		if($('#easytalk_text').val() || $('#img_hidden').val()){
			$('#wait').show();
			$.post({
				url:"./post/easytalk_send.php",
				data:{
					'log'			:$('#easytalk_text').val(),
					'send'			:'1',
					'img_code'		:$('#img_hidden').val(),

					'customer_id'	:Customer_id,
					'customer_name'	:Customer_Name,
					'customer_mail'	:Customer_mail,
				},

			}).done(function(data, textStatus, jqXHR){
				console.log(data);
			$('#wait').hide();

				$('.new_set').after(data)
				$('#easytalk_img').attr('src','../img/blog_no_image.png');
				$('.mail_detail').animate({ scrollTop:0}, 200);
				$('.mail_box_new_in').slideUp(100);
				$('#easytalk_text').val('');
				$('#img_hidden').val('');

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});

		}else{
			$('.filter_err').text('送信文がありません');
		}
	});

	$('.mail_detail_in').on('keyup','#easytalk_text',function (){
			$('.filter_err').text('');
	});

	$('#log_list_del_set').on('click',function () {
		$.post({
			url:"./post/log_item_del.php",
			data:{
				'cast_id'	:CastId,
				'list_id'	:Tmp_DelList,
			},
		}).done(function(data, textStatus, jqXHR){
			$('.set_back,.customer_memo_del_back_in').fadeOut(500);
			$("#i"+Tmp_DelList).remove();
			$('#memo_chg_id').val('');

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#log_list_del_back').on('click',function () {
		$('.set_back,.log_list_del').fadeOut(100);
	});



	$('.mail_detail_in').on('click','.mail_box_del',function () {
		Del_ID=$(this).attr('id').replace('m_del','');
		$('.set_back,.customer_memo_del_back_in').fadeIn(200);
		Flg="mail";
	});

	$('#tag_2_tbl').on('click','.customer_memo_del',function () {
		$('.set_back,.customer_memo_del_back_in').fadeIn(200);
		Del_ID=$(this).attr('id').replace("m_del","");
		Flg="memo";
	});

	$('#memo_del_back').on('click',function () {
		$('.set_back,.customer_memo_del_back_in').fadeOut(100);
		Del_ID="";
		Flg="";
	});


	$('.cas_set').on('change',function () {
		if($(this).attr('id')=='customer_detail_name'){
			$('#clist'+C_Id).children('.customer_list_name').html($(this).val()+' 様');

		}else if($(this).attr('id')=='customer_detail_nick'){
			$('#clist'+C_Id).children('.customer_list_nickname').html($(this).val());

		}else if($(this).attr('id')=='customer_group'){
			$('#clist'+C_Id).children('.customer_hidden_group').val($(this).val());
		}

		$.post({
			url:"./post/customer_detail_set.php",
			data:{
			'c_id'		:C_Id,
			'id'		:$(this).attr('id'),
			'param'		:$(this).val(),
			},
		}).done(function(data, textStatus, jqXHR){
		});
	});

	$('.cas_set2').on('change',function () {
		$.post({
			url:"./post/customer_detail_set2.php",
			data:{
			'c_id'		:C_Id,
			'id'		:$(this).attr('id'),
			'yy'		:$('#customer_detail_yy').val(),
			'mm'		:$('#customer_detail_mm').val(),
			'dd'		:$('#customer_detail_dd').val(),
			'ag'		:$('#customer_detail_ag').val(),
			},
			dataType: 'json',
		}).done(function(data, textStatus, jqXHR){
			$('#customer_detail_yy').val(data.yy),
			$('#customer_detail_mm').val(data.mm),
			$('#customer_detail_dd').val(data.dd),
			$('#customer_detail_ag').val(data.ag),
			$('#clist'+C_Id).children('.customer_hidden_yy').val(data.yy);
			$('#clist'+C_Id).children('.customer_hidden_mm').val(data.mm);
			$('#clist'+C_Id).children('.customer_hidden_dd').val(data.dd);
			$('#clist'+C_Id).children('.customer_hidden_ag').val(data.ag);
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#memo_del_set').on('click',function () {
		console.log(Flg);
		console.log(Del_ID);

		if(Flg == "customer"){
			$.post({
				url:"./post/customer_config_chg.php",
				data:{
					'c_id'		:C_Id,
					'flg'		:Flg,
					'sel'		:$('#customer_sort_sel').val(),
					'asc'		:$('#customer_sort_asc').val(),
					'fil'		:$('#customer_sort_fil').val()
				},

			}).done(function(data, textStatus, jqXHR){

				$('.customer_all_in').html(data);
				if($('#customer_sort_fil').val() > 0){
					$('.sort_alert').show();
				}else{
					$('.sort_alert').hide();
				}

				$('.head_mymenu_comm').removeClass('arrow_customer').addClass('arrow_top');
				$('.customer_detail').animate({'left':'100vw'},150).css('top','0');
				$(window).scrollTop(ListTop);

				$('#regist_customer').fadeIn(150);

				$('.head_mymenu_ttl').html('顧客リスト');
				$('.menu').css({'heigh':'auto'});
				$('.pg3').hide();
				$('.pg2').show();

				$('.customer_sns_box').hide();
				$('.customer_sns_tr').hide();
				$('.sns_arrow_a').hide();
				$('.sns_text').val('');

				$('.customer_sns_box,.sns_arrow_a,.customer_sns_btn').removeClass('c_customer_twitter c_customer_facebook c_customer_insta c_customer_web c_customer_line c_customer_tel c_customer_mail');
				$('.sns_jump').removeClass('jump_on');

				$('.tag_set').removeClass('tag_set_ck').animate({'height':'5.5vw'},300);
				$('#tag_3').addClass('tag_set_ck').animate({'height':'8vw'},300);

				$('.customer_memo').hide();
				$('#tag_3_tbl').show();
				$('.customer_fav').css('color','#cccccc');
				$('.main').css('position','static');

				$('#h_customer_id,#h_customer_set,#h_customer_page,#h_customer_fav,#h_customer_tel,#h_customer_mail,#h_customer_twitter,#h_customer_facebook,#h_customer_insta,#h_customer_web,#h_customer_line').val('');
				$('#tag_2_tbl,#tag_1_tbl').empty();

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});

		}else{
			if(Flg == "mail"){
console.log("△");
				$('#mail_box_'+ Del_ID).slideUp(200);

			}else{
console.log("▲");
				$('#tr_'+Flg+'_detail' + Del_ID).slideUp(200);
			}

			$.post({
				url:"./post/customer_memo_del.php",
				data:{
					'memo_id'	:Del_ID,
					'flg'		:Flg
				},

			}).done(function(data, textStatus, jqXHR){
				console.log(Flg);
				console.log(Del_ID);



			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}

		$('.set_back,.customer_memo_del_back_in').fadeOut(100);
		Del_ID="";
		Flg="";
	});



	$('.cal').on('click','.cal_btn_on1',function () {
		$('.cal_circle').animate({'left':'0vw'},200);
		$('.cal_btn_on1').animate({'color':'#f17766'},200);
		$('.cal_btn_on2').animate({'color':'#b0b0a0'},200);
	});

	$('.cal').on('click','.cal_btn_on2',function () {
		$('.cal_circle').animate({'left':'12vw'},200);
		$('.cal_btn_on2').animate({'color':'#f17766'},200);
		$('.cal_btn_on1').animate({'color':'#b0b0a0'},200);
	});

	$('.cal').on('click','.cal_prev',function () {
		$.post({
			url:"./post/calendar_set.php",
			data:{
				'c_month'	:$('#c_month').val(),
				'pre'		:'1',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){

			$('.cal').prepend(data.html).animate({'left':'-100vw'},0);
			$(".cal").children().last().remove();
			$('#c_month').val(data.date);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.cal').on('click','.cal_next',function () {
		$.post({
			url:"./post/calendar_set.php",
			data:{
				'c_month'	:$('#c_month').val(),
				'pre'		:'2',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){

			$('.cal').append(data.html).animate({'left':'-100vw'},0);
			$(".cal").children().first().remove();
			$('#c_month').val(data.date);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});


	$('.cal').draggable({
		axis: 'x',
		drag: function( event, ui ) {

		},
		stop: function( event, ui ) {
			if(ui.position.left > VwBase*(-90)){/*■先月*/
				$('.cal').animate({'left':'0'},200);

				$.post({
					url:"./post/calendar_set.php",
					data:{
						'c_month'	:$('#c_month').val(),
						'pre'		:'1',
					},
					dataType: 'json',

				}).done(function(data, textStatus, jqXHR){

					$('.cal').prepend(data.html).animate({'left':'-100vw'},0);
					$(".cal").children().last().remove();
					$('#c_month').val(data.date);

				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log(textStatus);
					console.log(errorThrown);
				});

			}else if(ui.position.left < VwBase*(-110)){/*■来月*/
				$('.cal').animate({'left':'-200vw'},200);
				$.post({
					url:"./post/calendar_set.php",
					data:{
						'c_month'	:$('#c_month').val(),
						'pre'		:'2',
					},
					dataType: 'json',

				}).done(function(data, textStatus, jqXHR){
					$('.cal').append(data.html).animate({'left':'-100vw'},0);
					$(".cal").children().first().remove();
					$('#c_month').val(data.date);

				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log(textStatus);
					console.log(errorThrown);
				});

			}else{
				$('.cal').animate({'left':'-100vw'},100);
			}
		},
	});

	$('.cal_weeks_prev').on('click',function (){
/*		$('.cal_weeks_box_2').animate({'top':'0'},2000);*/
		$.post({
			url:"./post/chg_weeks.php",
			data:{
				'c_month':$('#c_month').val(),
				'base_day':$('#base_day').val(),
				'pre':'1',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$('.cal_weeks_box_2').prepend(data.html).animate({'top':'-73.5vw'},2000);
			$('.cal_weeks_box_2').children().slice(-7).remove();
			$('#base_day').val(data.date);

console.log(data.html);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.cal_weeks_next').on('click',function (){
/*		$('.cal_weeks_box_2').animate({'top':'-73.5vw'},200);*/
		$.post({
			url:"./post/chg_weeks.php",
			data:{
				'c_month':$('#c_month').val(),
				'base_day':$('#base_day').val(),
				'pre':'2',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$('.cal_weeks_box_2').children().slice(0,7).remove();
			$('.cal_weeks_box_2').append(data.html).css({'top':'-73.5vw'});
			$('#base_day').val(data.date);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.cal_weeks_box_2').draggable({
		axis: 'y',
		start: function( event, ui ) {
			startPosition = ui.position.top;
		},
		drag: function( event, ui ) {
		},
		stop: function( event, ui ) {//前週
			if(ui.position.top > VwBase*(-65)){
				$('.cal_weeks_box_2').animate({'top':'0'},100);
				$.post({
					url:"./post/chg_weeks.php",
					data:{
						'c_month':$('#c_month').val(),
						'base_day':$('#base_day').val(),
						'pre':'1',
					},
					dataType: 'json',

				}).done(function(data, textStatus, jqXHR){
					$.when(
						$('.cal_weeks_box_2').prepend(data.html)
					)
					.done(function(data_a, data_b) {
						$('.cal_weeks_box_2').css('top','-73.5vw');
						$('.cal_weeks_box_2').children().slice(-7).remove();
						$('#base_day').val(data.date);
					})
					.fail(function() {
					});
				});

			}else if(ui.position.top < VwBase*(-95)){//翌週
				$('.cal_weeks_box_2').animate({'top':'-147vw'},100);
				$.post({
					url:"./post/chg_weeks.php",
					data:{
						'c_month'	:$('#c_month').val(),
						'base_day'	:$('#base_day').val(),
						'pre'		:'2',
					},
					dataType: 'json',

				}).done(function(data, textStatus, jqXHR){

					$.when(
						$('.cal_weeks_box_2').append(data.html)
					)
					.done(function(data_a, data_b) {
						$('.cal_weeks_box_2').children().slice(0,7).remove();
						$('.cal_weeks_box_2').css('top','-73.5vw');
						$('#base_day').val(data.date);
					})
					.fail(function() {
					});
				});

			}else{
				$('.cal_weeks_box_2').animate({'top':'-73.5vw'},100);
			}
		},
	});

	$('.notice_ttl_in').on('click',function(){
		if(!$(this).hasClass('notice_sel')){
			Tmp=$(this).attr('id');
			$('#h_'+Tmp).val();
			$('#notice_day').hide().fadeIn(800).text($('#h_'+Tmp).val());

			Tmp2=$(this).attr('id').replace('ttl','box');
			$('.notice_ttl_in').removeClass('notice_sel');
			$(this).addClass('notice_sel');
			$('.notice_box').hide();
			$('#'+Tmp2).fadeIn(0);
		}
	});

	$('.notice_ttl').on('change','.notice_month',function(){
		Tmp=0;
		$.post({
			url:"./post/notice_page.php",
			data:{
				'p':'n',
				'page':Tmp,
				'month':$('.notice_month').val(),
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			console.log(data.next);
			Tmp++;
			$('.notice_box_log').hide();
			$('.notice_list').html(data.html);
			$('.notice_list_s').text(Tmp);

			$('.notice_list_l').removeClass('notice_prev');

			if(data.next ==1){
				$('.notice_list_r').removeClass('notice_next');
			}else{
				$('.notice_list_r').addClass('notice_next');
			}

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.notice_ttl').on('click','.notice_next',function(){
		Tmp=$('.notice_list_s').text();
		$.post({
			url:"./post/notice_page.php",
			data:{
				'p':'n',
				'page':Tmp,
				'month':$('.notice_month').val(),
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			console.log(data.next);
			Tmp++;
			$('.notice_box_log').hide();
			$('.notice_list').html(data.html);
			$('.notice_list_s').text(Tmp);
			$('.notice_list_l').addClass('notice_prev');

			if(data.next ==1){
				$('.notice_list_r').removeClass('notice_next');
			}

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.notice_ttl').on('click','.notice_prev',function(){
		Tmp=$('.notice_list_s').text()-2;
		$.post({
			url:"./post/notice_page.php",
			data:{
				'p':'p',
				'page':Tmp,
				'month':$('.notice_month').val(),
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			Tmp++;
			$('.notice_box_log').hide();
			$('.notice_list').html(data.html);
			$('.notice_list_s').text(Tmp);
			$('.notice_list_r').addClass('notice_next');
			if(Tmp <2){
				$('.notice_list_l').removeClass('notice_prev');
			}

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});



/*
	$('.notice_box_item2').on('click',function (){
		Tmp=$(this).attr('id').replace("title","hidden");
		$('.notice_box_log').show().html($('#'+Tmp).val());
		$('.notice_box_item1,.notice_box_item2').removeClass('notice_box_sel');
		$(this).addClass('notice_box_sel');
	});
*/



	$('.notice_list').on('click','.notice_box_item',function(){
		Nid=$(this).attr('id').replace("notice_box_title","");

		$(this).removeClass('nt1');
		$(this).children('.notice_yet1').removeClass('notice_yet1').addClass('notice_yet2');

		$('.notice_box_item').removeClass('notice_box_sel');
		$(this).addClass('notice_box_sel');

		$.post({
			url:"./post/notice_ck.php",
			data:{
				'n_id':Nid,
			},

		}).done(function(data, textStatus, jqXHR){
			$('.notice_box_log').show().html(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});




	$('.log_item_set').on('click','.item_color',function (){
		$('.color_picker,.icon_picker').slideUp(100);
		if($(this).next().css('display')=='none'){
			$(this).next().slideDown(100);
		}
	});

	$('.log_item_set').on('click','.color_picker_list',function (){
		$('.color_picker,.icon_picker').slideUp(100);
		Tmp=$(this).parent().attr('id');
		Clr=$(this).css('background');
		Cds=$(this).attr('cd');
		$(this).parent().prev().css('background',Clr);
		$(this).parent().next().val(Cds);
		$(this).parent().parent().next().css('color',Clr);

		if(Tmp){
			$.post({
				url:"./post/log_item_chg.php",
				data:{
				'sort'		:Tmp,
	/*			'cast_id'	:CastId,*/
				'clr'		:Cds,
				},
			}).done(function(data, textStatus, jqXHR){

	console.log(data);

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);

			});
		}	
	});

	$('.log_item_set').on('click','.item_icon',function (){
		$('.icon_picker,.color_picker').slideUp(100);
		if($(this).next().css('display')=='none'){
			$(this).next().slideDown(100);
		}
	});

	$('.log_item_set').on('click','.icon_picker_list',function (){
		Tmp=$(this).parent().attr('id');
		Cds=$(this).attr('cd');
		Clr=$(this).text();
		$(this).parent().prev().text(Clr);
		$(this).parent().next().val(Cds);
		$('.color_picker,.icon_picker').slideUp(100);

		if(Tmp){
			$.post({
				url:"./post/log_item_chg.php",
				data:{
				'sort'		:Tmp,
	/*			'cast_id'	:CastId,*/
				'cds'		:Cds,
				},
			}).done(function(data, textStatus, jqXHR){
	console.log(data);

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}

	});

	$('.log_item_set').on('change','.item_name',function (){
		var Tmp=$(this).attr('id').replace('item_name_','');
		var Name=$(this).val();
		if(Tmp != 'name_new'){
			$.post({
				url:"./post/log_item_chg.php",
				data:{
				'sort'		:Tmp,
				'name'		:Name,
				},
			}).done(function(data, textStatus, jqXHR){
	console.log(data);
			});
		}
	});

	$('.log_item_set').on('change','.item_price',function (){
		var Tmp=$(this).attr('id').replace('item_price_','');
		var Cds=$(this).val();
		if(Tmp != 'price_new'){
			$.post({
				url:"./post/log_item_chg.php",
				data:{
				'sort'		:Tmp,
				'price'		:Cds,
				},
			});
		}

	});


	$('#gp_set').on('click',function (){
		var Tmp=$('#gp_sort tr').length;
		$.post({
			url:"./post/gp_set.php",
			data:{
			'sort'		:Tmp,
			'cast_id'	:CastId,
			'name'		:$('#gp_new').val(),
			},

		}).done(function(data, textStatus, jqXHR){
			$('#gp_sort').append(data);
			$('#count_gp').val(Tmp);
			$('#gp_new').val('');
		});
	});

	$('#gp_sort').on('change','.gp_name',function (){
		Tmp=$(this).attr('id').replace('gp_name_','');
		Cds=$(this).val();
		$.post({
			url:"./post/gp_chg.php",
			data:{
			'id'		:Tmp,
			'name'		:Cds,
			},
		}).done(function(data, textStatus, jqXHR){
			console.log(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});
/*
	$('#gp_sort').on('click','.gp_del_in',function (){
		Tmp=$(this).attr('id').replace('gp_name_','');
		Cds=$(this).val();
		$.post({
			url:"./post/gp_del.php",
			data:{
			'sort'		:Tmp,
			'cast_id'	:CastId,
			'name'		:Cds,
			},
		}).done(function(data, textStatus, jqXHR){

		});
	});
*/
	$('#gp_sort').on('click','.gp_del_in',function (){
		$('.set_back,.log_gp_del').fadeIn(200);
		Tmp_DelList=$(this).parents('tr').attr('id').replace("gp","");

		$('.log_gp_del_name').text($(this).parents().next().next().children('.gp_name').val());

	});

	$('#log_gp_del_back').on('click',function (){
		$('.set_back,.log_gp_del').fadeOut(200);
	});


	$('.config_pass').on('click',function (){
		$('.config_text1').attr('type','text');
	});


	$('#config_week_start').on('change',function (){
		Tmp=String($(this).val());
		$.post({
			url:"./post/config_week_chg.php",
			data:{
			'week'		:Tmp,
			'cast_id'	:CastId,
			},
		}).done(function(data, textStatus, jqXHR){
		});
	});

	$('#config_day_start').on('change',function (){
		Tmp=String($(this).val());
		$.post({
			url:"./post/config_day_chg.php",
			data:{
			'times'		:Tmp,
			'cast_id'	:CastId,
			},
		}).done(function(data, textStatus, jqXHR){

		});
	});

	$('.cal_days_memo').on('change',function (){
		TmpLog=$('.cal_days_memo').val();
		TmpCal='cal_m_'+$('#set_date').val();
		$('.'+TmpCal).removeClass(TmpCal);

		$.post({
			url:"./post/calendar_memo_set.php",
			data:{
			'set_date'	:$('#set_date').val(),
			'cast_id'	:CastId,
			'log'		:TmpLog,
			},
		}).done(function(data, textStatus, jqXHR){
			Tmp=$('#set_date').val().substr(0,6)
			$('#para'+Tmp).append(data);
			if(TmpLog){
				$('#c'+$('#set_date').val()).children('.cal_i3').addClass('n3');
				$('#customer_memo_nodata').hide();
			}else{
				$('#c'+$('#set_date').val()).children('.cal_i3').removeClass('n3');
			}
		});
	});

	$('.cal').on('click','.cal_td',function (){
		$('.cal_td').removeClass('cc8');
		$(this).addClass('cc8');
		DaySet =$(this).attr('id').replace("c","");
		$('#set_date').val(DaySet);

		$.post({
			url:"./post/calendar_day_sel.php",
			data:{
			'set_date'	:DaySet,
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$('.cal_days_date').html(data.date);
			$('#days_sche').html(data.sche);
			$('.cal_days_birth').html(data.birth);
			$('.cal_days_memo').val(data.memo);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});


	$('.slide').draggable({
		axis: 'x',
		start: function( event, ui ) {
			startPosition = ui.position.left;
		},
		drag: function( event, ui ) {
			if(ui.position.left > startPosition) ui.position.left = startPosition;
		},

		stop: function( event, ui ) {
			if(ui.position.left < -50){
				$('.slide').animate({'left':'-70vw'},200);

				$('.head_mymenu').removeClass('on');
				$('.mymenu_b').fadeIn(150);

				$('.mymenu_a,.mymenu_c').animate({'left':'1vw','width':'8vw'},100);
				$('.head_mymenu').animate({'border-radius':'1vw'},100);

				$({deg:-23}).animate({deg:0}, {
					duration:100,
					progress:function() {
						$('.mymenu_a').css({
							transform:'rotate(' + this.deg + 'deg)'
						});
					},
				});

				$({deg:23}).animate({deg:0}, {
					duration:100,
					progress:function() {
						$('.mymenu_c').css({
							transform:'rotate(' + this.deg + 'deg)'
						});
					},
				});
			}else{
				$('.slide').animate({'left': '0vw'},100);
			}
		}
	})

	$('#item_sort').sortable({
		axis: 'y',
        handle: '.log_td_handle',
		stop : function() {
			$('.color_picker,.icon_picker').hide();
			ChgList=$(this).sortable("toArray");
			var Cnt=ChgList.length;
			var N=0;
			var ItemName	=[];
			var ItemPrice	=[];
			var ItemIcon	=[];
			var ItemColor	=[];

			for(i=0;i<Cnt;i++){
				Tmp_i=ChgList[i].replace('i','');
				ItemName[i]=$('#item_name_'+Tmp_i).val();
				ItemPrice[i]=$('#item_price_'+Tmp_i).val();
				ItemIcon[i]=$('#item_icon_hidden_'+Tmp_i).val();
				ItemColor[i]=$('#item_color_hidden_'+Tmp_i).val();
			}

			$.post({
				url:"./post/log_item_set.php",
				data:{
				'cast_id'		:CastId,
				'chglist[]'		:ChgList,
				'item_name[]'	:ItemName,
				'item_price[]'	:ItemPrice,
				'item_icon[]'	:ItemIcon,
				'item_color[]'	:ItemColor,

				},
			}).done(function(data, textStatus, jqXHR){
				$('#item_sort').html(data);
				$('.icon_picker,.color_picker').hide();

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});

        }
	});


	$('#gp_sort').sortable({
		axis: 'y',
        handle: '.gp_handle',


		stop:function(){
			var Cnt = 1;

			$(this).children('tr').each(function(){
				$(this).children('.log_td_order').text(Cnt);
				Cnt++;
			});

			ChgList=$(this).sortable("toArray");
				console.log(ChgList)

			$.post({
				url:"./post/gp_sort.php",
				data:{
					'list[]':ChgList,
				},

			}).done(function(data, textStatus, jqXHR){

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
        }
	});

	$('#new_set').on('click',function(){
		$.post({
			url:"./post/log_item_new.php",
			data:{
			'cast_id'		:CastId,
			'price'			:$('#price_new').val(),
			'item_name'		:$('#name_new').val(),
			'item_icon'		:$('#icon_new').val(),
			'item_color'	:$('#color_new').val(),
			'sort'			:$('#item_count').val(),
			},

		}).done(function(data, textStatus, jqXHR){
			$('#item_sort').append(data);
			$('.color_picker,.icon_picker').hide();
			$('#new_color').css('background','#008080');
			$('#new_icon').css('color','#008080');

			$('#price_new').val('0');
			$('#name_new').val('');
			$('#icon_new').val('0');
			$('#color_new').val('0');

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#sel_log_box').on('click','.sel_log_option',function(){
		colorS	=$(this).css('color');
		iconS	=$(this).children('.sel_log_icon').text();
		commS	=$(this).children('.sel_log_comm').text();
		priceS	=$(this).children('.sel_log_price').text();
		$('#sel_log_box').slideUp(100);
		$('.customer_log_right').append('<div class="sel_log_option_s" style="color:'+colorS+';border:1px solid '+colorS+'"><span class="sel_log_icon_s">'+iconS+'</span><span class="sel_log_comm_s">'+commS+'</span><span class="sel_log_price_s">'+priceS+'</span><span class="sel_log_del_s"></span></div>');
	});

	$('.customer_log_right').on('click','.sel_log_del_s',function(){
		$(this).parent().remove()
	});

	$('#sel_log_reset').on('click',function(){
		$('.set_back').fadeOut(200);
		$('#local_dt, #local_st, #local_ed,#sel_log_pts,#sel_log_area').val('');
		$('.customer_log_right').empty();
		$('#sel_log_area').val('');
		$('.customer_log_in').animate({'top':'100vh'},200);
		Chg='';
	});

	$('#sel_log_set').on('click',function(){
		var N=0;
		var ItemName	=[];
		var ItemPrice	=[];
		var ItemIcon	=[];
		var ItemColor	=[];

		 $('.sel_log_option_s').each(function() {
			ItemColor[N]	=$(this).css('color');
			ItemIcon[N]		=$(this).children('.sel_log_icon_s').text();
			ItemName[N]		=$(this).children('.sel_log_comm_s').text();
			ItemPrice[N]	=$(this).children('.sel_log_price_s').text();
			N++;
		});


		$.post({
			url:"./post/customer_log_set.php",
			data:{

			'chg'		:Chg,
			'log'		:$('#sel_log_area').val(),
			'local_dt'	:$('#local_dt').val(),
			'local_st'	:$('#local_st').val(),
			'local_ed'	:$('#local_ed').val(),
			'pts'		:$('#sel_log_pts').val(),

			'c_id'			:C_Id,
			'item_color[]'	:ItemColor,
			'item_icon[]'	:ItemIcon,
			'item_name[]'	:ItemName,
			'item_price[]'	:ItemPrice

			},
		}).done(function(data, textStatus, jqXHR){

			if(Chg){
				$('#tr_log_detail'+Chg).after(data);
				$('#tr_log_detail'+Chg).remove();

			}else{
				$('#tag_3_tbl').prepend(data);
			}

				$('.set_back').fadeOut(200);
				$('.customer_log_right').empty();
				$('#sel_log_area').val('');
				$('.customer_log_in').animate({'top':'100vh'},200);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#sel_log_del').on('click',function(){
		$('.customer_memo_del_back_in').fadeIn(100);
	});




	$('#tag_3_tbl').on('click','.customer_log_del',function () {
		$('.set_back,.customer_memo_del_back_in').fadeIn(100);
		Del_ID=$(this).attr('id').replace("l_del","");
		Flg="log";
	});

	$('#log_del_back').on('click',function () {
		$('.set_back,.customer_memo_del_back_in').fadeOut(100);
		Del_ID="";
		Flg="";
	});

	$('#sel_log_main').on('click',function(){
		if($('#sel_log_box').css('display')=='none'){
			$('#sel_log_box').slideDown(200);

		}else{
			$('#sel_log_box').slideUp(200);
		}
	});

	$('.customer_sort_sel').on('change',function(){
		$.post({
			url:"./post/customer_sort.php",
			data:{
			'sel'		:$('#customer_sort_sel').val(),
			'fil'		:$('#customer_sort_fil').val(),
			'asc'		:$('#customer_sort_asc').val(),
			},
		}).done(function(data, textStatus, jqXHR){

			$('.customer_all_in').html(data);
			if($('#customer_sort_fil').val() > 0){
				$('.sort_alert').show();
			}else{
				$('.sort_alert').hide();
			}
		});
	});

	$('.sort_btn_on0').on('click',function () {
		$('.sort_circle').animate({'left':'0vw'},200).css({'border-radius':'10px 0 0 10px','right':'auto'});
		$('.sort_btn_on0').animate({'color':'#0000d0'},200);
		$('.sort_btn_on1').animate({'color':'#b0b0a0'},200);
		$('#customer_sort_asc').val('0');

		$.post({
			url:"./post/customer_sort.php",
			data:{
			'sel'		:$('#customer_sort_sel').val(),
			'fil'		:$('#customer_sort_fil').val(),
			'asc'		:$('#customer_sort_asc').val(),
			},

		}).done(function(data, textStatus, jqXHR){
			$('.customer_all_in').html(data);
			if($('#customer_sort_fil').val() > 0){
				$('.sort_alert').show();
			}else{
				$('.sort_alert').hide();
			}
		});
	});

	$('.sort_btn_on1').on('click',function () {
		$('.sort_circle').animate({'right':'0'},200).css({'border-radius':'0 10px 10px 0','left':'auto'});
		$('.sort_btn_on1').animate({'color':'#0000d0'},200);
		$('.sort_btn_on0').animate({'color':'#b0b0a0'},200);
		$('#customer_sort_asc').val('1');

		$.post({
			url:"./post/customer_sort.php",
			data:{
			'sel'		:$('#customer_sort_sel').val(),
			'fil'		:$('#customer_sort_fil').val(),
			'asc'		:$('#customer_sort_asc').val(),
			},
		}).done(function(data, textStatus, jqXHR){
			$('.customer_all_in').html(data);
			if($('#customer_sort_fil').val() > 0){
				$('.sort_alert').show();
			}else{
				$('.sort_alert').hide();
			}
		});
	});

	$('.ana_box_out').on('click','.ana_detail',function () {
		TMP=$(this).attr('id');
		$('.ana_detail').removeClass('ana_on');
		$('.ana_arrow').removeClass('ana_arrow_on');
		$('.ana_list_div').slideUp(300);
		$('.ana_list').not('#l'+TMP).delay(300).fadeOut(0);
		if($('#d'+TMP).css('display')=='none'){
			$('#l'+TMP).show();
			$(this).addClass('ana_on');
			$(this).children('.ana_arrow').addClass('ana_arrow_on');
			$('#d'+TMP).slideDown(300);
		}else{
			$('#l'+TMP).delay(300).fadeOut(0);
		}
	});

	$('input:radio[name="ana_sele"]').on('change',function () {
		Tmp=$('input:radio[name="ana_sele"]:checked').val();
		$('.ana_box').hide();
		$('#an'+Tmp).fadeIn(300);

	});

	$('.ana_sel').on('change',function () {
		$('.ana_box').slideUp(200);
		$.post({
			url:"./post/ana_chg.php",
			data:{
			'ym'		:$('.ana_sel').val(),
			'ck'		:$('input:radio[name="ana_sele"]:checked').val(),
			},

		}).done(function(data, textStatus, jqXHR){
			$('.ana_box_out').html(data).delay(100).slideDown(100);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.tmpl_dataset').on('click', function() {
		Tmp=$(this).attr('id').replace('ins_set','');
		$.post({
			url:"./post/easytalk_tmpl_chg.php",
			data:{
			'id'		:Tmp,
			'title'		:$('#tmpl_title'+Tmp).val(),
			'log'		:$('#tmpl_area'+Tmp).val(),

			},
		}).done(function(data, textStatus, jqXHR){
			$('.set_back,.chg_alert').fadeIn(500).delay(1000).fadeOut(1000);


		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});


	$('.tmpl_btn').on('click', function() {
		Tmp=$(this).attr('id').replace('ins_name','').replace('ins_nick','');
		var bN = $(this).val();
		var Str_A = $('#tmpl_area'+Tmp).val();
		var Str_P = $('#tmpl_area'+Tmp).get(0).selectionStart;
		var Str_T = Str_A.substr(0, Str_P);
		var Str_B = Str_A.substr(Str_P, Str_A.length);
//		var Str_A = $('#tmpl_area'+Tmp).val(Str_T + bN + Str_B);
		$('#tmpl_area'+Tmp).val(Str_T + bN + Str_B);
	});

});

