$(function(){ 
	var Width_l	=$('.img_box_out2').width();
	var Width_s	=$('.img_box_out1').width();
	var VwBase	=$(window).width()/100;

	var CalH	=$(".cal_weeks_box").height()*(-1);

	var ImgId		='';
	var Fav			=0;
	var cvs_A		=0;
	var Rote		=0;
	var Zoom		=100;
	var Chg			='';
	var base_64		='';
	var Box			=[];
	var Tmp			='';

	var C_Page=0;
	var M_Page=0;
	var B_Page=0;

	var StSort=[];
	var St_top=[];
	var St_left=[];
	var St_width=[];
	var St_height=[];
	var St_url=[];
	var St_op=[];
	var St_rotate=[];

	var Roll=0;
	var Op	=100;
	var StampCnt=30;
	const Stamp_w=$('.img_stamp').width();
	const Stamp_h=$('.img_stamp').height();

	var CLength=17;
	var MLength=17;
	var BLength=13;
	var BLOCK=0;

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

	$('.customer_detail').on('click','.tag_set',function () {
		if($(this).hasClass('tag_set_ck')!='true'){

			$('.customer_log_set,.customer_memo_set').hide();

			$('.tag_set_ck').removeClass('tag_set_ck');
			$(this).addClass('tag_set_ck');
			Tmp=$(this).attr('id');
			$('.customer_memo').hide();
			$('#' + Tmp + '_tbl').fadeIn(200);

			if(Tmp =="tag_1"){
				$('.customer_log_set').show();

			}else if(Tmp =="tag_2"){
				$('.customer_memo_set').show();
			}
		}
	});

	$('.customer_detail').on('change','.block_r',function () {
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

	$('.blog_list').on('click','.blog_hist',function () {
		if($(this).next('.hist_log').css('display')=='none'){
			var TMp=$(this).children('.hidden_tag').val();

			$('.blog_hist').not(this).hide();
			$(this).next('.hist_log').slideDown(200);

			$('#regist_blog,#regist_blog_pc').fadeOut(0);
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
			$('#h_blog_img').val($(this).children('.hist_img').attr('src').replace('../img/blog_no_image.png',''));
	
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
			$('#regist_blog,#regist_blog_pc').fadeIn(200);
			$('#blog_chg').val('');
			$('.blog_ad,.blog_next').show();
		}
	});

	$('.blog_list').on('click','.hist_log',function () {
		$('.hist_log').slideUp(200);
		$('.blog_hist').slideDown(200);
		$('#regist_blog,#regist_blog_pc').fadeIn(200);
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

	$('.customer_detail').on('change','.item_textbox,.rd',function(){

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
		Tmp2=$('#tmpl_area' + Tmp).val();
		Tmp2=Tmp2.replace(/\[呼び名\]/g,Customer_Nick);
		Tmp2=Tmp2.replace(/\[名前\]/g,Customer_Name);

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
	
		$('#wait').show();

		$.ajax({
			url:"./post/easytalk_multi.php",
			type: 'post',
			data:{
				'log'		:$('#tmpl_area9').val(),
				'img_code'	:$('#easytalk_f_img').attr("src").replace("../img/blog_no_image.png", ""),
				'list[]'	:Box,
			},
			dataType: 'json'
		}).done(function(data, textStatus, jqXHR){

			$('#wait').hide();

			$('.filter_main3').html(data["result"]);
			$('#box_mail_select1').html(data["html"]);
			if(data["midoku"]==0){
				$('#m3').html("<span class=\"menu_i\"></span><span class=\"menu_s\">EasyTalk</span>");

			}else{
				$('#m3').html("<span class=\"menu_i\"></span><span class=\"menu_s\">EasyTalk</span><span class=\"easy_midoku\">"+data["midoku"]+"</span>");
			}



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

			Tmp = $('.filter_main3').offset().top -  Width_l/2;
			$('html,body').animate({'scrollTop':Tmp}, 1000, 'swing');

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.easytalk_top_comm,.al_l').on('click',function (){
		$('.mail_detail').animate({'left':'100vw'},200);
		$(".easytalk_top_name").text('');
		$('.easytalk_top').delay(200).fadeOut(200);
		$('.mail_detail_in').html('');

		if($('#send_ok').prop('checked') == true){
			var Yet=1;
		}else{
			var Yet=0;
		}


		$.ajax({
			url:'./post/easytalk_list.php',
			type:'post',
			data:{
				'send':Yet,
			},
			dataType: 'json',
		}).done(function(data, textStatus, jqXHR){
			Customer_id=0;

			$('#box_mail_select1').html(data["html"]);
			if(data["midoku"]==0){
				$('#m3').html("<span class=\"menu_i\"></span><span class=\"menu_s\">EasyTalk</span>");

			}else{
				$('#m3').html("<span class=\"menu_i\"></span><span class=\"menu_s\">EasyTalk</span><span class=\"easy_midoku\">"+data["midoku"]+"</span>");
			}
		});
	});

	$('#send_ok').on('change',function (){
		if($('#send_ok').prop('checked') == true){
			var Yet=1;
		}else{
			var Yet=0;
		}

		$.ajax({
			url:'./post/easytalk_list.php',
			type: 'post',
			data:{
				'send':Yet,
			},
			dataType: 'json'

		}).done(function(data, textStatus, jqXHR){
			Customer_id=0;
			$('#box_mail_select1').html(data["html"]);
			if(data["midoku"]==0){
				$('#m3').html("<span class=\"menu_i\"></span><span class=\"menu_s\">EasyTalk</span>");

			}else{
				$('#m3').html("<span class=\"menu_i\"></span><span class=\"menu_s\">EasyTalk</span><span class=\"easy_midoku\">"+data["midoku"]+"</span>");
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#box_mail_select1').on('click','.mail_hist',function () {
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
			$('.mail_detail').animate({'left':'0'},300);
			$(".easytalk_top_name").text(Customer_Nick);
			$('.easytalk_top').delay(200).fadeIn(200);
			$('.mail_detail_in').html(data);
			$('.easytalk_link').attr('id',"clist" + Customer_id);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});


	$(window).scroll(function() {
		var CH=$('.customer_all_in').height() -(window.screen.height);
		var MH=$('#box_mail_select1').height() -(window.screen.height);
		var BH=$('.blog_list').height() -(window.screen.height);
		var S=$(window).scrollTop();

		if(BLOCK == 0){
			if(CH<S){
				BLOCK=1;
				if( CLength > $('.customer_list').length){
					CLength+=16;
					C_Page++;
					$.post({
						url:"./post/customer_hist.php",
						data:{
							'fil'		:$('#customer_sort_fil').val(),
							'sel'		:$('#customer_sort_sel').val(),
							'asc'		:$('#customer_sort_asc').val(),
							'page'		:C_Page
						},
			
					}).done(function(data, textStatus, jqXHR){
						$('.customer_all_in').append(data);
						BLOCK=0;

					}).fail(function(jqXHR, textStatus, errorThrown){
						console.log(textStatus);
						console.log(errorThrown);
					});
				}

			}else if(MH<S){
				BLOCK=1;
				if( MLength > $('.mail_hist').length){
					MLength+=16;
					M_Page++;
					if($('#send_ok').prop('checked') == true){
						var Yet=1;
					}else{
						var Yet=0;
					}

					$.ajax({
						url:'./post/easytalk_list.php',
						type: 'post',
						dataType: 'json',
						data:{
							'send'		:Yet,
							'page'		:M_Page
						},
			
					}).done(function(data, textStatus, jqXHR){
						$('#box_mail_select1').append(data.html);
						BLOCK=0;

					}).fail(function(jqXHR, textStatus, errorThrown){
						console.log(textStatus);
						console.log(errorThrown);
					});
				}

			}else if(BH<S){
				BLOCK=1;
				if( BLength > $('.blog_hist').length){
					BLength+=12;
					B_Page++;
					$.post({
						url:"./post/blog_sort.php",
						data:{
							'sel'		:$('#blog_sel1').val(),
							'gp'		:$('#blog_sel2').val(),
							'fil'		:$('#blog_sel3').val(),
							'page'		:B_Page
						},

					}).done(function(data, textStatus, jqXHR){
						$('.blog_list').append(data);
						BLOCK=0;

					}).fail(function(jqXHR, textStatus, errorThrown){
						console.log(textStatus);
						console.log(errorThrown);
					});
				}
			}
		}
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
		$('.mail_detail').animate({'left':'100vw'},300);
		$('.head_mymenu_ttl').text('Easy Talk');
	});

	$('.reg_fav').on('click',function () {
		if($('#regist_fav').val()== 0){
			Tmp=$(this).attr('id').replace('reg_fav_','');
			$('#regist_fav_out').children().slice(0,Tmp).css('color','#ff3030');
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
				$('.no_data').hide();
				$('.customer_all_in').prepend(data);
				$('.set_back,.customer_regist').fadeOut(300);

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

	$('#regist_customer,#regist_customer_pc').on('click',function () {
		$('.set_back,.customer_regist').fadeIn(300);
		C_Id_Tmp=C_Id;
		C_Id=0;	
	});

	$('.customer_regist_no').on('click',function () {
		$('.set_back,.customer_regist').fadeOut(300);
	});



	$('#blog_back, #blog_back_pc').on('click',function () {
		$('.blog_write').animate({'left':'100vw'},200);

	});

	$('#regist_blog, #regist_blog_pc').on('click',function () {
		$('.head_mymenu_ttl').text('ブログ投稿　');
		$('.head_mymenu_arrow,#regist_blog_back').show();

		var now = new Date();
		var yy = now.getFullYear();
		var mm = now.getMonth() + 1;
		var mm = "0" + mm;
		var dd = "0" + now.getDate();
		var hh = "0" + now.getHours();
		var ii = "0" + now.getMinutes();

		$('.blog_write').animate({'left':'0'},300);
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
	});

	$('#regist_blog_fix, #regist_blog_fix_pc').on('click',function () {

		$('.head_mymenu_ttl').text('ブログ修正　');
		$('.head_mymenu_arrow,#regist_blog_back').show();

		$('.blog_write').animate({'left':'0','right':'0'},300);
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
			$('.blog_img').attr('src',$('#h_blog_img').val());
			ImgId=$('#h_blog_img').val();

		}else{
			$('.blog_img').attr('src','../img/blog_no_image.png');
			ImgId='';
		}
	});

	$('.head').on('click','.arrow_top',function(){
		 window.location.href = './';
	});

	$('#regist_blog_back, .blog_back').on('click',function(){
		$('.blog_write').animate({'left':'100vw','right':'0'},300);
		$('.head_mymenu_arrow,#regist_blog_back').fadeOut();
		$('.head_mymenu_ttl').text('ブログ　');
	});


	$('.head').on('click','.head_mymenu_arrow',function(){
		$('.head_mymenu_arrow,#regist_blog_back,#customer_up,#customer_down').fadeOut(200);

		$('.blog_write').animate({'left':'100vw','right':'0'},300);
		$('.head_mymenu_ttl').html(BaseTop);
		$('.customer_detail').animate({'left':'100vw'},200);

if(BaseTop =="顧客リスト　"){
		$('#regist_customer').fadeIn(200);

}else if(BaseTop =="ブログ投稿　" || BaseTop =="ブログ修正　" ){
		$('#regist_customer').fadeIn(200);
		$('.head_mymenu_ttl').text('ブログ　');
}
		$('.menu').css({'heigh':'auto'});
		$('.pg3').hide();
		$('.pg2').show();

		$('.customer_sns_box').hide();
		$('.customer_sns_tr').hide();
		$('.sns_arrow_a').hide();
		$('.sns_text').val('');

		$('.customer_sns_box,.sns_arrow_a,.customer_sns_btn').removeClass('c_customer_twitter c_customer_facebook c_customer_insta c_customer_web c_customer_line c_customer_tel c_customer_mail');
		$('.sns_jump').removeClass('jump_on');

		$('.tag_set').removeClass('tag_set_ck');
		$('#tag_1').addClass('tag_set_ck');

		$('.customer_memo').hide();
		$('#tag_3_tbl').show();
		$('.customer_fav').css('color','#cccccc');
		$('.main').css('position','static');

		$('#h_customer_id,#h_customer_set,#h_customer_page,#h_customer_fav,#h_customer_tel,#h_customer_mail,#h_customer_twitter,#h_customer_facebook,#h_customer_insta,#h_customer_web,#h_customer_line').val('');
		$('.customer_memo').empty();
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
				$('.customer_detail').animate({'left':'100vw'},100);

				$('.head_mymenu_ttl').text(BaseTop);
				$('.head_mymenu_arrow').fadeOut(200);
				$('#customer_up,#customer_down').fadeOut(150);
				$('.menu').css({'height':'auto'});
				$('.pg3').hide();
				$('.pg2').show();
				$('.customer_sns_box').hide();
				$('.customer_sns_tr').hide();
				$('.sns_arrow_a').hide();
				$('.sns_text').val('');

				$('.customer_sns_box,.sns_arrow_a,.customer_sns_btn').removeClass('c_customer_twitter c_customer_facebook c_customer_insta c_customer_web c_customer_blog c_customer_tel c_customer_mail');

				$('.sns_jump').removeClass('jump_on');

				$('.tag_set').removeClass('tag_set_ck');
				$('#tag_1').addClass('tag_set_ck');

				$('.customer_memo').hide();
				$('#tag_3_tbl').show();
				$('.customer_fav').css('color','#cccccc');

			}else{
				$('.customer_detail').animate({'left':'0vw','right':'0vw'},200);
				$('.menu').css({'height':'auto'});
				$('.head_mymenu_ttl').text('顧客（詳細）');
				$('.head_mymenu_arrow').delay(100).fadeIn(100);
			}
		}
	});

	$('.customer_detail').on('click','.back_slide',function(){
		$('.customer_detail').animate({'left':'120vw','right':'auto'},200);
		$('#customer_up,#customer_down').fadeOut(150);
	});

	$('#customer_up').on('click',function () {
		var c_w=$('.customer_detail').width()*(-0.4);
		var c_h=$('.customer_detail').height()-c_w;

		$(this).hide();
		$('.customer_detail').animate({'top':c_w,'height':c_h},300);
		$('.customer_detail_box').animate({'top':c_w},300);
	});

	$('#customer_down').on('click',function () {
		$('#customer_up').fadeIn(150);
		$('.customer_detail').animate({'top':'0','height':'100vh'},300);
		$('.customer_detail_box').animate({'top':0},300);
	});

	$('.body').on('click','.clist',function(){

		$('#regist_customer').fadeOut(150);
		C_Id=$(this).attr('id').replace('clist','');
		$.post({
			url:"./post/customer_detail.php",
			data:{
				'c_id'		:C_Id,
			},

		}).done(function(data, textStatus, jqXHR){
			$('.customer_detail').animate({'left':'0vw','right':'0vw'},300).html(data);
			$('#customer_up,#customer_down').delay(300).fadeIn(100);
			$('.head_mymenu_ttl').text('顧客（詳細）');
			$('.head_mymenu_arrow').show();
			$('#tag_2_tbl,#tag_3_tbl,#tag_4_tbl').hide();
			$('#tag_1_tbl').show();

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#blog_set').on('click',function(){
		$('#wait').show();

		$('#blog_hist_'+$('#blog_chg').val()).remove();
		$('#blog_hist_'+$('#blog_chg').val()).next('.hist_log').remove();

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
			$('.blog_write').animate({'left':'100vw'},300);
			$('.blog_list').prepend(data);
			$('.no_data, .hist_log, .head_mymenu_arrow, #regist_blog_back').hide();
			$('.blog_hist').show();
			base_64='';
			$('.head_mymenu_ttl').text('ブログ　');
			$('#wait').hide();

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.customer_detail').on('click','.sns_btn',function(){
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

	$('#regist_schedule,#regist_schedule_pc').on('click',function(){
		$('.set_back,.cal_weeks').fadeIn(300);
	});

	$('.customer_detail').on('click','.customer_sns_btn',function(){

		if($('.customer_sns_box').css('display') !== 'none'){

			$('.customer_memo').animate({'margin-top':'78vw'},200);
			$('.customer_detail_box').animate({'height':'78vw'},200);
			$('.customer_tag').animate({'top':'68vw'},200);


			$('.customer_sns_box').slideUp(200);
			$('.customer_sns_tr').slideUp(200);
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

				}else if(Tmp == 'customer_line'){
					$('.sns_jump').addClass('jump_on c2_'+Tmp);
					$('#sns_form').attr('action',SNS_LINK[Tmp]);

				}else{
					$('.sns_jump').addClass('jump_on c2_'+Tmp);
					$('#sns_form').attr('action',SNS_LINK[Tmp]+$('#h_'+Tmp).val());
				}

				$('.customer_sns_ttl').css('color',SnsColor).text($('#n_'+Tmp).val());
			}

			$('.customer_sns_box').slideDown(200);
			$('.customer_sns_tr').slideDown(200);
			$('.customer_tag').animate({'top':'86vw'},200);
			$('.customer_detail_box').animate({'height':'96vw'},200);
			$('.customer_memo').animate({'margin-top':'96vw'},200);

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

	$('.blog_img_pack').on('click',function(){
		Task="blog";
		$('.set_back,.img_box').fadeIn(300);

		Img=$(this).children('.blog_img').attr("src").replace('_s','');

		var ChgImg = new Image();
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');

		ChgImg.src=Img;

		cvs_A=600;
		cvs_W=600;
		cvs_H=600;

		cvs_X=600;
		cvs_Y=600;
		cvs_B=50;

		css_inX=0;
		css_inY=0;

		css_A=Width_l;
		css_B=Width_s;

		ImgTop		=Width_s;
		ImgLeft		=Width_s;

		$("#cvs1").css({
			'width': Width_l,
			'height': Width_l,
			'left':Width_s,
			'top': Width_s
		});

		if(Img != "../img/blog_no_image.png"){
			ctx.drawImage(ChgImg, 0, 0, 600,600,0,0,1800, 1800);
		}

		ImgCode = cvs.toDataURL("image/jpeg");
	});




	$('#easytalk_f_img').on('click',function(){
		Task="filter";
		$('.set_back,.img_box').fadeIn(300);
	});


	$('#set_new_img').on('click',function(){
		$('.set_back,.img_box').fadeIn(300);
		$('#img_code').val('');
		Task="regist";
	});

	$('.customer_detail').on('click','.customer_detail_img',function(){
		$('.set_back,.img_box').fadeIn(300);
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

		css_inX=0;
		css_inY=0;

		css_A=Width_l;
		css_B=Width_s;

		ImgTop		=css_p;
		ImgLeft		=css_p;

		$("#cvs1").css({
			'width': $(".img_box_out2").width(),
			'height': $(".img_box_out2").width(),
			'left': $(".img_box_out1").width(),
			'top': $(".img_box_out1").width()
		});

		ctx.drawImage(ChgImg, 0, 0, 300,300,0,0,1800, 1800);
		ImgCode = cvs.toDataURL("image/jpeg");
	});

	$('.mail_detail_in').on('click','#easytalk_img',function(){
		$('.set_back,.img_box').fadeIn(300);
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

			css_A=Width_l;
			css_B=Width_s;

			ImgTop		=css_p;
			ImgLeft		=css_p;

			$("#cvs1").css({
				'width': $(".img_box_out2").width(),
				'height': $(".img_box_out2").width(),
				'left': $(".img_box_out1").width(),
				'top': $(".img_box_out1").width()
			});
			ctx.drawImage(ChgImg, 0, 0, 300,300,0,0,1800, 1800);
			ImgCode = cvs.toDataURL("image/jpeg");
		}
	});


	$('.mail_detail_in').on('click','.mail_box_del',function(){
		Tmp=$(this).attr('id').replace('m_del','');
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
			$('.set_back,.cal_weeks').fadeOut(300);


		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#sch_set_arrow').on('click',function () {
		$('.set_back,.cal_weeks').fadeOut(300);
	});

	$('#sch_set_trush').on('click',function () {
		$('.cal_weeks_box_2').children().slice(7,14).children('.sch_time_in,.sch_time_out').val("");
	});

	$('#memo_del').on('click',function () {
		$('.customer_memo_new_txt').val("");
	});

	$('#memo_reset').on('click',function () {
		$('.set_back,.customer_memo_in').fadeOut(300);
		$('#memo_chg_id').val('');
	});

	$('.customer_detail').on('click','.customer_memo_set',function () {
		if($('.set_back').css('display') ==='none'){
			$('.set_back,.customer_memo_in').fadeIn(300);

		}else{
			$('#memo_chg_id').val('');
			$('.set_back,.customer_memo_in').fadeOut(300);
		}
	});

	$('.customer_detail').on('click','.customer_log_set',function () {
		if($('.set_back').css('display') ==='none'){
			$('.set_back,.customer_log_in').fadeIn(300);

			LocalNow = new Date();
			LocalY = LocalNow.getFullYear();

			Localm = "0"+(LocalNow.getMonth() + 1);
			Localm = Localm.substr(-2);

			Locald = "0"+LocalNow.getDate();
			Locald = Locald.substr(-2);

			LocalE = "0"+(LocalNow.getHours() + 1);
			LocalE = LocalE.substr(-2);

			Localh = "0"+LocalNow.getHours();
			Localh = Localh.substr(-2);


			$('#local_dt').val(LocalY+"-"+Localm+"-"+Locald)
			$('#local_st').val(Localh+":00")
			$('#local_ed').val(LocalE+":00")

		}else{
			$('.set_back,.customer_log_in').fadeOut(300);
		}
	});

	$('.customer_detail').on('click','.customer_log_chg',function () {
		if($('.set_back').css('display') ==='none'){
			Chg=$(this).attr('id').replace('l_chg','');
			$('.set_back,.customer_log_in').fadeIn(300);

			TmpLog=$('#tr_log_detail'+ Chg).children('.customer_log_memo').html().replace(/(<br>|<br \/>)/gi, '\n');
			TmpPts=$('#tr_log_detail'+ Chg).children('.customer_log_item').children('.sel_log_price_s').text();
			TmpD=$(this).prev('.customer_log_date_detail').text().substr(0,4)+"-"+$(this).prev('.customer_log_date_detail').text().substr(5,2)+"-"+$(this).prev('.customer_log_date_detail').text().substr(8,2);
			$('#local_dt').val(TmpD);

			$('#local_st').val($(this).prev('.customer_log_date_detail').text().substr(11,5));
			$('#local_ed').val($(this).prev('.customer_log_date_detail').text().substr(17,5));
			TmpTag=$('#tr_log_detail'+ Chg).children('.customer_log_list').html();

			$('#sel_log_area').val(TmpLog);
			$('.customer_log_right').html(TmpTag);
			$('.customer_log_right div').removeClass('customer_log_item').addClass('sel_log_option_s').append('<span class=\"sel_log_del_s\"></span>');

			$('#sel_log_pts').val(TmpPts);

		}else{
			Chg='';
			$('.set_back,.customer_log_in').fadeOut(300);
		}
	});

	$('#memo_set').on('click',function () {
		Log=$('.customer_memo_new_txt').val();
		var TmpMemoId=$('#memo_chg_id').val();
		$('#tr_memo_detail'+TmpMemoId).parents('.customer_memo_log').remove();

		$.post({
			url:"./post/customer_memo_set.php",
			data:{
				'c_id'		:C_Id,
				'log'		:Log,
				'memo_id'	:TmpMemoId,
			},


		}).done(function(data, textStatus, jqXHR){
			$('.set_back,.customer_memo_in').fadeOut(300);
			$('#tag_2_tbl').prepend(data);
			$('.customer_memo_new_txt').val('');

			$('#customer_memo_nodata').remove();

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.customer_detail').on('click','.customer_memo_chg',function () {

		Tmp=$(this).attr('id').replace("m_chg","");
		$('.set_back,.customer_memo_in').fadeIn(300);
		$('#memo_chg_id').val(Tmp);
		TmpLog=$('#tr_memo_detail'+Tmp).html().replace(/(<br>|<br \/>)/gi, '\n')
		$('.customer_memo_new_txt').val(TmpLog);
	});

	$('#item_sort').on('click','.log_td_del',function () {
		$('.set_back,.log_list_del').fadeIn(300);
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


	$('#customer_remove_set').on('click',function () {
		$.post({
			url:"./post/customer_remove.php",
			data:{
				'c_id'	:C_Id,
			},
		}).done(function(data, textStatus, jqXHR){
			$('#clist'+C_Id).remove();
			$('#customer_up,#customer_down,.customer_detail').css({'top':'0','left':'100vw'});
			$('.set_back,.customer_remove').fadeOut(200);

			$('.customer_detail_box').css({'top':0});

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});


	$('.mail_detail_in').on('click','.mail_box_del',function () {
		Del_ID=$(this).attr('id').replace('m_del','');
		$('.set_back,.customer_memo_del_back_in').fadeIn(200);
		Flg="mail";
	});

	$('.customer_detail').on('click','.customer_memo_del',function () {
		$('.set_back,.customer_memo_del_back_in').fadeIn(200);
		Del_ID=$(this).attr('id').replace("m_del","");
		Flg="memo";
	});

	$('.customer_detail').on('click','.customer_log_del',function () {
		$('.set_back,.customer_memo_del_back_in').fadeIn(200);
		Del_ID=$(this).attr('id').replace("l_del","");
		Flg="log";
	});

	$('.btn_c1').on('click',function () {
		$('.set_back,.popup').fadeOut(200);
		Del_ID="";
		Flg="";
	});
	

	$('.customer_detail').on('change','.cas_set',function () {
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

	$('.customer_detail').on('change','.cas_set2',function () {
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

				$('.head_mymenu_arrow').hide();
				$('.customer_detail').animate({'left':'100vw'},300);
				$('.customer_detail').delay(200).animate({'top':'0'},0);

				$(window).scrollTop(ListTop);

				$('#regist_customer').fadeIn(150);

				$('.head_mymenu_ttl').html(BaseTop);

				$('.menu').css({'heigh':'auto'});
				$('.pg3').hide();
				$('.pg2').show();

				$('.customer_sns_box').hide();
				$('.customer_sns_tr').hide();
				$('.sns_arrow_a').hide();
				$('.sns_text').val('');

				$('.customer_sns_box,.sns_arrow_a,.customer_sns_btn').removeClass('c_customer_twitter c_customer_facebook c_customer_insta c_customer_web c_customer_line c_customer_tel c_customer_mail');
				$('.sns_jump').removeClass('jump_on');

				$('.tag_set').removeClass('tag_set_ck');
				$('#tag_1').addClass('tag_set_ck');

				$('.customer_memo').hide();
				$('#tag_3_tbl').show();
				$('.customer_fav').css('color','#cccccc');
				$('.main').css('position','static');

				$('#h_customer_id,#h_customer_set,#h_customer_page,#h_customer_fav,#h_customer_tel,#h_customer_mail,#h_customer_twitter,#h_customer_facebook,#h_customer_insta,#h_customer_web,#h_customer_line').val('');
				$('.customer_memo').empty();

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});

		}else{
			if(Flg == "mail"){
				$('#mail_box_'+ Del_ID).slideUp(200);

			}else{
				$('#tr_'+Flg+'_detail' + Del_ID).parents('.customer_memo_log').slideUp(200);
			}

			$.post({
				url:"./post/customer_memo_del.php",
				data:{
					'memo_id'	:Del_ID,
					'flg'		:Flg
				},

			}).done(function(data, textStatus, jqXHR){

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}

		$('.set_back,.customer_memo_del_back_in').fadeOut(200);
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

	$('.main_sch').on('click','.cal_prev,.cal_0',function () {
		var Tmp=$('.cal_out').width();
		$.post({
			url:"./post/calendar_set.php",
			data:{
				'c_month'	:$('#c_month').val(),
				'pre'		:'1',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$.when(
				$('.cal').prepend(data.html).css({'left':Tmp*(-2)}),
				$('.cal_2').html($('.cal_1').html()),
				$('.cal_1').html($('.cal_0').html()),
				$('.cal_0').html(data.p),
				$('.cal_p_out').hide()

			).done(function(){
				$('.cal').animate({'left':Tmp*(-1)},500);
				$("#c"+DaySet).addClass('cc8');
				$(".cal").children().last().remove();
				$('#c_month').val(data.date);
				$('.cal_p_out').fadeIn(800);
			});

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.main_sch').on('click','.cal_next,.cal_2',function () {
		var Tmp=$('.cal_out').width();
		$.post({
			url:"./post/calendar_set.php",
			data:{
				'c_month'	:$('#c_month').val(),
				'pre'		:'2',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){

			$.when(
				$('.cal').append(data.html).css({'left':0}),
				$('.cal_0').html($('.cal_1').html()),
				$('.cal_1').html($('.cal_2').html()),
				$('.cal_2').html(data.p),
				$('.cal_p_out').hide()

			).done(function(){
				$('.cal').animate({'left':Tmp*(-1)},300);
				$("#c"+DaySet).addClass('cc8');
				$(".cal").children().first().remove();
				$('#c_month').val(data.date);
				$('.cal_p_out').fadeIn(800);
			});


		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.cal').draggable({
		axis: 'x',
		start: function( event, ui ) {
			startP = ui.position.left;
		},
		drag: function( event, ui ) {
			nowP = startP - ui.position.left;
		},

		stop: function( event, ui ) {


			var Tmp=$('.cal_out').width();
			if(nowP < -50){/*■先月*/
				$.post({
					url:"./post/calendar_set.php",
					data:{
						'c_month'	:$('#c_month').val(),
						'pre'		:'1',
					},
					dataType: 'json',

				}).done(function(data, textStatus, jqXHR){
					$.when(
						$('.cal').animate({'left':0},300),
						$('.cal_1').html($('.cal_0').html()),
						$('.cal_2').html($('.cal_1').html()),
						$('.cal_0').html(data.p),
						$('.cal_p_out').hide()

					).done(function(){
						$('.cal').prepend(data.html).css({'left':Tmp*(-1)}),
						$("#c"+DaySet).addClass('cc8');
						$(".cal").children().last().remove();
						$('#c_month').val(data.date);
						$('.cal_p_out').fadeIn(500);
					});

				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log(textStatus);
					console.log(errorThrown);
				});

			}else if(nowP > 50){/*■来月*/
				$.post({
					url:"./post/calendar_set.php",
					data:{
						'c_month'	:$('#c_month').val(),
						'pre'		:'2',
					},
					dataType		: 'json',

				}).done(function(data, textStatus, jqXHR){

					$.when(
						$('.cal').animate({'left':Tmp*(-2)},300),
						$('.cal_0').html($('.cal_1').html()),
						$('.cal_1').html($('.cal_2').html()),
						$('.cal_2').html(data.p),
						$('.cal_p_out').hide()

					).done(function(){
						$('.cal').append(data.html).css({'left':Tmp*(-1)}),
						$("#c"+DaySet).addClass('cc8');
						$(".cal").children().first().remove();
						$('#c_month').val(data.date);
						$('.cal_p_out').fadeIn(800);
					});

				}).fail(function(jqXHR, textStatus, errorThrown){
					console.log(textStatus);
					console.log(errorThrown);
				});

			}else{
				$('.cal').animate({'left':Tmp*(-1)},100);
			}
		},
	});

	$('.cal_weeks_prev').on('click',function (){
		$.post({
			url:"./post/chg_weeks.php",
			data:{
				'c_month':$('#c_month').val(),
				'base_day':$('#base_day').val(),
				'pre':'1',
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			$('.cal_weeks_box_2').prepend(data.html).animate({'top':CalH},2000);
			$('.cal_weeks_box_2').children().slice(-7).remove();
			$('#base_day').val(data.date);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('.cal_weeks_next').on('click',function (){
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
			$('.cal_weeks_box_2').append(data.html).css({'top':CalH});
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
			if(ui.position.top > CalH / 5){
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
						$('.cal_weeks_box_2').css('top',CalH);
						$('.cal_weeks_box_2').children().slice(-7).remove();
						$('#base_day').val(data.date);
					})
					.fail(function() {
					});
				});

			}else if(ui.position.top < CalH *1.2){//翌週
				$('.cal_weeks_box_2').animate({'top':CalH*2},100);
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
						$('.cal_weeks_box_2').css('top',CalH);
						$('#base_day').val(data.date);
					})
					.fail(function() {
					});
				});

			}else{
				$('.cal_weeks_box_2').animate({'top':CalH},100);
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

	$('.notice_month').on('change',function(){

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

	$('.notice_ttl_b').on('click','.notice_next',function(){
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

	$('.notice_ttl_b').on('click','.notice_prev',function(){
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

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#gp_sort').on('click','.log_td_del',function (){
		$('.set_back,.log_gp_del').fadeIn(200);
		Tmp_DelList=$(this).parents('tr').attr('id').replace("gp","");
		$('.log_gp_del_name').text($(this).next().next().children('.gp_name').val());
	});

	$('#log_gp_del_set').on('click',function (){
		Cds=$(this).val();
		$.post({
			url:"./post/gp_del.php",
			data:{
			'id'		:Tmp_DelList,
			},
		}).done(function(data, textStatus, jqXHR){
			$('#gp_sort').html(data);
			$('.set_back,.log_gp_del').fadeOut(100);
		});
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

	$('.set_back').on('click','.sel_log_del_s',function(){
		$(this).parent().remove()
	});

	$('#sel_log_reset').on('click',function(){
		$('#local_dt, #local_st, #local_ed,#sel_log_pts,#sel_log_area').val('');
		$('.customer_log_right').empty();
		$('#sel_log_area').val('');
		$('.set_back,.customer_log_in').fadeOut(300);
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
				$('#tr_log_detail'+Chg).parent('.customer_memo_log').after(data).remove();

			}else{
				$('#tag_1_tbl').prepend(data);
			}

				$('.set_back,.customer_log_in').fadeOut(300);
				$('.customer_log_right').empty();
				$('#sel_log_area').val('');
				$('#customer_log_nodata').remove();

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#sel_log_del').on('click',function(){
		$('.customer_memo_del_back_in').fadeIn(200);
	});

	$('.customer_detail').on('click','.block_del,.tag_pc_remove',function () {
		$('.set_back,.customer_remove').fadeIn(200);
	});

	$('.customer_detail').on('click','.tag_pc_mail',function () {
		$('.customer_et_config').fadeIn(200);
	});

	$('.customer_detail').on('click','.block_return',function () {
		$('.customer_et_config').fadeOut(200);
	});

	$('#config_chg').on('click',function () {
		if(MyMail != $('#mydata_m').val() || MyPass != $('#mydata_p').val()){
			$('.set_back,.config_mail_chg').fadeIn(200);
		}
	});


	$('#mydata_chg').on('click',function () {
		var Mydata_err="";
		if(!$('#mydata_p').val()){
			Mydata_err="passwordがありません<br>";
		}

		if(!$('#mydata_m').val()){
			Mydata_err +="メールアドレスがありません<br>";
		}

		if(!Mydata_err){

			$('.config_text1').attr('type','text');
			$.post({
				url:"./post/mydata_chg.php",
				data:{
					'new_mail':$('#mydata_m').val(),
					'new_pass':$('#mydata_p').val(),
				},

			}).done(function(data, textStatus, jqXHR){
				$('#logout_count').val('2');
				$('#logout').submit();

			}).fail(function(jqXHR, textStatus, errorThrown){
				console.log(textStatus);
				console.log(errorThrown);
			});
		}
	});


	$('.customer_sort_sel').on('change',function(){
		$.post({
			url:"./post/blog_sort.php",
			data:{
			'sel'		:$('#blog_sel1').val(),
			'gp'		:$('#blog_sel2').val(),
			'fil'		:$('#blog_sel3').val(),
			},
		}).done(function(data, textStatus, jqXHR){
			$('.blog_list').html(data);
		});
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
		$('#tmpl_area'+Tmp).val(Str_T + bN + Str_B);
	});

/*■■IMG-------------------------------------------------------------------------------*/
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
		ctx.clearRect(0, 0, 1800,1800);

		reader.onload = (function(file){
			return function(e){
				img.src = e.target.result;
				$("#view").attr("src", e.target.result);
				$("#view").attr("title", file.name);

				img.onload = function() {
					img_W=img.width;
					img_H=img.height;
					img_S2= Width_l;

					if(img_H > img_W){
						cvs_H=1800;
						cvs_W=Math.ceil(1800*img_W/img_H);
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
						cvs_W=1800;
						cvs_H=Math.ceil(1800*img_H/img_W);
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


					$("#cvs1").css({'width': css_A,'height': css_A,'left': css_B,'top': css_B});
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
			if(ui.position.top > Math.floor( Width_s-css_inY*Zoom/100)){
				ui.position.top=Math.floor( Width_s-css_inY*Zoom/100);
			}
			if(ui.position.left > Math.floor( Width_s -css_inX*Zoom/100)){
				ui.position.left=Math.floor( Width_s  -css_inX*Zoom/100);

			}
			 if(ui.position.top  < Math.floor( Width_s + Width_l - (css_A - css_inY) * Zoom / 100) ){
				ui.position.top=Math.floor(Width_s + Width_l - (css_A - css_inY) * Zoom / 100);
			}

			 if(ui.position.left  < Math.floor(Width_s + Width_l - ( css_A - css_inX ) * Zoom / 100) ){
				ui.position.left=Math.floor(Width_s + Width_l - ( css_A - css_inX) * Zoom / 100);
			}
		},
		stop: function( e, ui ) {
			$('#img_top').val(ui.position.left);
			$('#img_left').val(ui.position.top);
		}
	});


	$('#img_set').on('click',function(){	

	console.log(ImgCode);
	
		$('#wait').show();
		$.each(StSort, function(index, value){
			St_top[index]		=$("#stamp"+value).css('top');
			St_left[index]		=$("#stamp"+value).css('left');
			St_width[index]		=$("#stamp"+value).css('width');
			St_height[index]	=$("#stamp"+value).css('height');
			St_rotate[index]	=$("#rote"+value).val();
			St_url[index]		=$("#stamp"+value).children('.img_stamp_in').attr('src');
			St_op[index]		=$("#stamp"+value).children('.img_stamp_in').css('opacity');
		});

		$.post({
			url:"./post/img_set.php",
			data:{
				'img_code'	:ImgCode.replace(/^data:image\/jpeg;base64,/, ""),

				'task'		:Task,
				'post_id'	:C_Id,
				'css_a'		:css_A,
				'css_b'		:css_B,

				'img_top'		:$("#cvs1").css("top"),
				'img_left'		:$("#cvs1").css("left"),
				'img_width'		:$("#cvs1").css("width"),
				'img_height'	:$("#cvs1").css("height"),

				'img_zoom'		:Zoom,
				'img_rote'		:Rote,

				'width_s'		:Width_s,
				'width_l'		:Width_l,

				'st_top[]'		:St_top,
				'st_left[]'		:St_left,
				'st_width[]'	:St_width,
				'st_height[]'	:St_height,
				'st_url[]'		:St_url,
				'st_op[]'		:St_op,
				'st_rotate[]'	:St_rotate,

			},

		}).done(function(data, textStatus, jqXHR){
			base_64=$.trim(data);
			$('.img_box').fadeOut(300);

console.log(base_64);

			var cvs = document.getElementById('cvs1');
			var ctx = cvs.getContext('2d');
			ctx.clearRect(0, 0, 1800,1800);

			if(Task=="blog"){
				if(base_64){
					$('.blog_img').attr('src',"data:image/jpg;base64,"+ base_64);
				}else{
					$('.blog_img').attr('src',"../img/blog_no_image.png");
				}
				ImgId="";
				$('.set_back').fadeOut(300);
			}else if(Task=="regist"){
				if(base_64){
					$('.regist_img').attr('src',"data:image/jpg;base64,"+ base_64);
				}else{
					$('.regist_img').attr('src',"../img/customer_no_image.png");
				}

			}else if(Task=="chg"){
				if(base_64){
					$('.customer_detail_img').attr('src',data);
					$('#clist' +C_Id).children('.mail_img').attr('src',base_64);

				}else{
					$('.customer_detail_img').attr('src',"../img/customer_no_image.png");
					$('#clist' +C_Id).children('.mail_img').attr('src',"../img/customer_no_image.png");
				}

				$('.set_back').fadeOut(300);

			}else if(Task=="filter"){
				if(base_64){
					$('#easytalk_f_img').attr('src',"data:image/jpg;base64,"+ base_64);
				}else{
					$('#easytalk_f_img').attr('src',"../img/blog_no_image.png");
				}
				$('.set_back').fadeOut(300);

			}else if(Task=="mail"){
				if(base_64){
					$('#easytalk_img').attr('src',"data:image/jpg;base64,"+base_64);
				}else{
					$('#easytalk_f_img').attr('src',"../img/blog_no_image.png");
				}
				$('.set_back').fadeOut(300);
			}

			$('.filter_err').text('');
			$('#img_hidden').val(data);
			$('#wait').hide();

			$('.zoom_box').text('100');
			$('#img_zoom').val('100');
			$('#input_zoom').val('100');

			ctx.clearRect(0, 0, 1800,1800);
			Rote=0;

			var StSort=[];
			var StampCnt=30;

			for(var i=30; i<40; i++){
				$('#stamp'+i).css({'display':'none','width':Width_s*4,'height':Width_s*4,'transform':'rotate(0deg)','z-index':i,'top':25+(i-30)*10,'left':25+(i-30)*10});
			}
			$('.stamp_rote').val('0');
			$('.img_stamp_in').attr('src','');
			$('.stamp_box,.stamp_config').hide();


			var StSort=[];
			var St_top=[];
			var St_left=[];
			var St_width=[];
			var St_height=[];
			var St_url=[];
			var St_op=[];
			var St_rotate=[];

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});

	$('#img_close').on('click',function(){	
		$('.set_back,.img_box').fadeOut(300);
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');
		ctx.clearRect(0, 0, 1800,1800);

		var StSort=[];
		var StampCnt=30;

		for(var i=30; i<40; i++){
			$('#img_stamp'+i).css({'display':'none','width':Width_s*4,'height':Width_s*4,'transform':'rotate(0deg)','z-index':i,'top':25+(i-30)*10,'left':25+(i-30)*10});
		}
		$('.stamp_rote').val('0');
	});

	$('#cvs1').on('click',function(){	
		$('.stamp_config').fadeOut(100);
		$('.img_ctrl').hide();
		$('.img_stamp').css('border','none');
	});


	$('.stamp_config_0').on('click',function(){	
		if($(this).hasClass('color_10')){
			$("#stamp"+TmpCtrl).children('.img_stamp_in').css('opacity',1);
			$(this).removeClass('color_10');
		}else{
			$("#stamp"+TmpCtrl).children('.img_stamp_in').css('opacity',0.6);
			$(this).addClass('color_10');
		}
	});

	$('.stamp_config_1').on('click',function(){	
		StSort.splice(TmpCtrl, 1);

		$('#stamp'+TmpCtrl)
		.hide()
		.css({
			'z-index':'39',
			'width':Width_s*4,
			'height':Width_s*4,
			'opacity':1,
			'border':'1px solid #ff3030',
			"top":"115px",
			"left":"115px",
			'transform':'rotate(0deg)'
		})
		.attr('id','stamp40');

		$('#stamp'+TmpCtrl).children('.img_stamp_in').attr('src','');
		$("#rote3"+TmpCtrl).val(''); 

		for( var i=TmpCtrl-0 + 1 ;i < 41; i++){
			N=i - 1
			$('#stamp'+i).attr('id',"stamp"+ N);
		}
		StampCnt--;
		$('.stamp_config').fadeOut(200);
	});

	$('.stamp_config_2').on('click',function(){	
		$('#stamp'+TmpCtrl).css({'width':Width_s*4,'height':Width_s*4,'transform':'rotate(0deg)'});
		$('#rote'+TmpCtrl).val('0');
	});

	$('.stamp_config_3').on('click',function(){	
		var Tmp_Old=$("#stamp"+TmpCtrl).css("z-index");

		if($(this).attr('id') =='st_1' && Tmp_Old < StSort.length){	
			var	TmpKey=StSort.splice(Tmp_Old, 1);
			StSort.splice(Tmp_Old-0+1, 0, TmpKey[0]);
			$.each(StSort, function(index, value){
				$("#stamp"+value).css("z-index",index);
			})

		}else if($(this).attr('id') =='st_2' && Tmp_Old < StSort.length){	
			var	TmpKey=StSort.splice(Tmp_Old, 1);
			StSort.splice(StSort.length, 0, TmpKey[0]);
			$.each(StSort, function(index, value){
				$("#stamp"+value).css("z-index",index);
			})

		}else if($(this).attr('id') =='st_3' && Tmp_Old > 30){	
			var	TmpKey=StSort.splice(Tmp_Old, 1);
			StSort.splice(Tmp_Old-1, 0, TmpKey[0]);
			$.each(StSort, function(index, value){
				$("#stamp"+value).css("z-index",index);
			})

		}else if($(this).attr('id') =='st_4' && Tmp_Old > 30){	
			var	TmpKey=StSort.splice(Tmp_Old, 1);
			StSort.splice(30, 0, TmpKey[0]);
			$.each(StSort, function(index, value){
				$("#stamp"+value).css("z-index",index);
			})
		}
	});

	$('.stamp_box_in').on('click',function(){	
		Tmp=$(this).attr('id').replace('stamp_in','');
		TmpSrc=$(this).children('.stamp_box_img').attr('src');
		$('#stamp'+StampCnt).children('.img_stamp_in').attr('src',TmpSrc);
		$('#stamp'+StampCnt).children('.ui-draggable-handle,.ui-resizable-handle').show();
		$('#stamp'+StampCnt).css({'display':'block','border':'1px solid #ff3030'});
		cssOp=1;

		StSort[StampCnt]=StampCnt;
		StampCnt++;
 	}); 


	$('.stamp_d').draggable({

		start: function( event, ui ) {
			tmp_H	=$(this).parent('.img_stamp').height();
			tmp_Y	=ui.position.top;

			tmp_W	=$(this).parent('.img_stamp').width();
			tmp_X	=ui.position.left;

			$(this).css('background','#0000d0');
		},

		drag: function(e, ui) {
			Now_W=ui.position.left - tmp_X;
			Now_H=ui.position.top - tmp_Y;
			if(Now_H > Now_W){
				$(this).parent('.img_stamp').css({'height':tmp_H + Now_H,'width':tmp_W + Now_H});
			}else{
				$(this).parent('.img_stamp').css({'height':tmp_H + Now_W,'width':tmp_W + Now_W});
			}

		},
		stop: function( event, ui ) {
			console.log("X:" + tmp_X);
			console.log("Y:" + tmp_Y);
			console.log("W:" + tmp_W);
			console.log("H:" + tmp_H);
			$(this).css('background','#fafafa');
		}
	});

	$('.stamp_r').draggable({
		start: function( event, ui ) {
			X_position=ui.position.left;
			Y_position=ui.position.top;
			$(this).addClass("op05");
			Roll=$(this).parent('.img_stamp').next('.stamp_rote').val();
		},

		drag: function(e, ui) {
			if(Roll < 45 || Roll > 314 ){
				if(X_position < ui.position.left && Y_position<ui.position.top){
					Roll++;

				}else if(X_position > ui.position.left && Y_position > ui.position.top){
					Roll--;
				}

			}else if(Roll<135){
				if(X_position > ui.position.left && Y_position < ui.position.top){
					Roll++;

				}else if(X_position < ui.position.left && Y_position > ui.position.top){
					Roll--;
				}

			}else if(Roll<215){
				if(X_position > ui.position.left && Y_position > ui.position.top){
					Roll++;

				}else if(X_position < ui.position.left && Y_position < ui.position.top){
					Roll--;
				}

			}else{
				if(X_position < ui.position.left && Y_position > ui.position.top){
					Roll++;

				}else if(X_position > ui.position.left && Y_position < ui.position.top){
					Roll--;
				}
			}

			$(this).parent('.img_stamp').css({'transform':'rotate('+Roll+'deg)'});

			if(Roll>360){
				Roll-=360;			
			}

			if(Roll<0){
				Roll+=360;			
			}
			$(this).css('background','#0000d0');
		},

		stop: function( event, ui ) {
			$(this).css('background','#fafafa');
			Tmp = $(this).parent('.img_stamp').attr('id').replace('stamp','');
			$('#rote'+ Tmp).val(Roll);
			$(this).removeClass("op05");
		}
	});


	$('.img_stamp').on('click',function(){
		TmpCtrl=$(this).attr('id').replace("stamp","");
		TmpSrc=$(this).children('.img_stamp_in').attr('src');
		$('#st_0').attr('src',TmpSrc);

		$('.stamp_config').fadeIn(100);

		$('.img_stamp').css('border','none');
		$(this).css('border','1px solid #ff3030');
		$(this).children('.img_ctrl').fadeIn(100);



		if($(this).children('.img_stamp_in').css('opacity')=="1"){
			$('.stamp_config_0').removeClass('color_10');
		}else{
			$('.stamp_config_0').addClass('color_10');
		}
	});

	$('.img_stamp').draggable({
		start: function(e, ui) {
			TmpCtrl=$(this).attr('id').replace("stamp","");
			TmpSrc=$(this).children('.img_stamp_in').attr('src');

			$('.img_stamp').css('border','none');
			$('.img_ctrl').hide();
			$(this).addClass("op05");

			$('#st_0').attr('src',TmpSrc);
			$(this).css('border','1px solid #ff3030');
			$('.stamp_config').fadeIn(100);
		},


		stop: function( event, ui ) {
			$(this).css('border','1px solid #ff3030');
			$(this).children('.img_ctrl').fadeIn(100);
			$(this).removeClass("op05");
		}
	});
	$('.upload_trush').on('click',function(){	
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');
		ctx.clearRect(0, 0, 1800,1800);
		$('.mail_img_view').hide().attr('src',"");
		ImgCode='';
	});

	$('.upload_stamp').on('click',function(){	
		$('.img_stamp').css('border','none');
		$('.stamp_config,.stamp_box').fadeOut('200');

		if($('.stamp_box').css('display') ==="none"){
			$('.stamp_box').fadeIn('200');
		}else{
			$('.stamp_box').fadeOut('200');
		}		
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

		$('.img_stamp').hide();
		$('.stamp_rote').val('0');
		var StSort=[];

	});

	$('.img_open').on( 'click', function () {
		$('.back').fadeIn(500);
	});


});
