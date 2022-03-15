$(function(){ 
var Box	=$('.stamp_w').width()/2;
var Roll=0;
var Op	=100;
var StampCnt=30;
const Stamp_w=$('.img_stamp').width();
const Stamp_h=$('.img_stamp').height();


	$('#cvs1').on('click',function(){	
		$('.stamp_config').fadeOut(100);
		$('.img_ctrl').hide();
		$('.img_stamp').css('border','none');
	});

	$('.stamp_config_3').on('click',function(){	
		var Tmp_Old=$("#stamp"+TmpCtrl).css("z-index");
//		console.log(TmpKey[0]);
		
		
		console.log(Tmp_Old);
		console.log(StSort.length);

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
		$('#stamp'+StampCnt).css({'display':'block'});	
		cssOp=1;
		StSort[StampCnt]=StampCnt;
		StampCnt++;
	});


	$('.img_stamp').on('click',function(){
		TmpCtrl=$(this).attr('id').replace("stamp","");
		$('.stamp_config').fadeIn(100);
		TmpSrc=$(this).children('.img_stamp_in').attr('src');
		$('#st_0').attr('src',TmpSrc);

		$('.img_ctrl').hide();
		$('.img_stamp').css('border','none');

		$(this).children('.img_ctrl').show();
		$(this).css('border','1px solid #ff3030');
	});


	$('.ctrl_bar_in').on('click',function(){
		Tmp=$(this).attr("id").replace("op","");
		$(this).nextAll().css({'background':"#a0a0ff"});
		$(this).prevAll().css({'background':"#0000d0"});
		if(Tmp == Op){
			$(this).css({'background':"#a0a0ff"});
			Op=$(this).prev().attr("id").replace("op","");
		}else{
			$(this).css({'background':"#0000d0"});
			Op=Tmp;
		}		
		cssOp=Op/100;
		$("#st_0, #stamp"+TmpCtrl).css({'opacity':cssOp});
		$(".stamp_config_op").text(100-Op);
	});

	$('.stamp_u').on('click',function(){
		$('.stamp_u').hide();
		var Tmp=Roll * (-1)
		$('.stamp_u_open').css({'transform':'rotate('+Tmp+'deg)'}).slideDown(200);
	});

	$('.stamp_u_close').on('click',function(){
		$('.stamp_u').show();
		$('.stamp_u_open').slideUp(100);
		$('.stamp_u_open').slideUp(100);
	});

	$('.ctrl_reset').on('click',function(){
		$(this).parents('.img_stamp').css({'width':Stamp_w,'height':Stamp_h,'transform':'rotate(0)'});
		$(this).parents('.img_stamp').find('.img_stamp_in').css({'opacity':'1'});
		$(this).parents('.stamp_u_open').css({'transform':'rotate(0)'});
		$(this).parents('.stamp_u_open').find('.ctrl_bar_in').css({'background':"#0000d0"});
		Roll=0;
	});

	$('.stamp_h').draggable({
		axis: 'y',
		start: function( event, ui ) {
			tmp_x=$(this).parent('.img_stamp').offset().left;
			tmp_y=$(this).parent('.img_stamp').offset().top;
			tmp_w=$(this).parent('.img_stamp').width();
			tmp_h=$(this).parent('.img_stamp').height();
		},

		drag: function(e, ui) {
			$(this).parent('.img_stamp').css('height',ui.position.top+Box);
			$(this).css('background','#0000d0');
		},
		stop: function( event, ui ) {
			console.log("X:" + tmp_x);
			console.log("Y:" + tmp_y);
			console.log("W:" + tmp_w);
			console.log("H:" + ui.position.top+Box);
			$(this).css('background','#fafafa');
		}
	});

	$('.stamp_w').draggable({
		axis: 'x',
		start: function( event, ui ) {
			tmp_x=$(this).parent('.img_stamp').offset().left;
			tmp_y=$(this).parent('.img_stamp').offset().top;
			tmp_w=$(this).parent('.img_stamp').width();
			tmp_h=$(this).parent('.img_stamp').height();
		},

		drag: function(e, ui) {
			tmp_w=Math.floor(ui.position.left+Box);
			$(this).parent('.img_stamp').css('width',tmp_w);
			$(this).css('background','#0000d0');
		},

		stop: function( event, ui ) {
			$(this).css('background','#fafafa');
		}
	});

	$('.stamp_z').draggable({
		start: function( event, ui){
			tmp_x=$(this).parent('.img_stamp').offset().left;
			tmp_y=$(this).parent('.img_stamp').offset().top;
			tmp_w=$(this).parent('.img_stamp').width();
			tmp_h=$(this).parent('.img_stamp').height();
		},

		drag: function(e, ui) {
			if(ui.position.left>ui.position.top){
				Box_w=ui.position.left+Box;
				Box_h=tmp_h + ui.position.left-tmp_w+Box;

			}else{
				Box_h=ui.position.top+Box;
				Box_w=tmp_w + ui.position.top-tmp_h+Box;
			}	

			$(this).parent('.img_stamp').css({'width':Box_w,'height':Box_h});
			$(this).css('background','#0000d0');

			$('#bx').text(tmp_x);
			$('#by').text(tmp_y);
			$('#x').text(Box_w);
			$('#y').text(Box_h);

		},

		stop: function( event, ui ) {
			console.log("X:" + tmp_x);
			console.log("Y:" + tmp_y);
			console.log("W:" + Box_w);
			console.log("H:" + Box_h);
			$(this).css('background','#fafafa');
		}
	});

	$('.stamp_d').draggable({
		start: function( event, ui ) {
			tmp_x=$(this).parent('.img_stamp').offset().left;
			tmp_y=$(this).parent('.img_stamp').offset().top;
			tmp_w=$(this).parent('.img_stamp').width();
			tmp_h=$(this).parent('.img_stamp').height();
		},

		drag: function(e, ui) {
			Box_w=Math.floor(ui.position.left*(-1)+tmp_w-Box);
			Box_h=Math.floor(ui.position.top+Box);
			Box_x=Math.floor(ui.position.left + tmp_x+	Box);

			$(this).parent('.img_stamp').css({'width':Box_w,'height':Box_h,'left':Box_x});
			$(this).css('background','#0000d0');

			$('#bx').text(Box_x);
			$('#by').text(tmp_y);
			$('#x').text(Box_w);
			$('#y').text(Box_h);

		},

		stop: function( event, ui ) {
			$(this).css('background','#fafafa');
		}
	});

	$('.stamp_r').draggable({
		start: function( event, ui ) {
			X_position=ui.position.left;
			Y_position=ui.position.top;
		},

		drag: function(e, ui) {
			if(Roll>=360){
				Roll-=360;			
			}

			if(Roll<0){
				Roll+=360;			
			}

			if(Roll<45 || Roll>315 ){
				if(X_position < ui.position.left || Y_position<ui.position.top){
					Roll++;
				}else{
					Roll--;
				}
				$(this).parent('.img_stamp').css({'transform':'rotate('+Roll+'deg)'});

			}else if(Roll<135){
				if(X_position > ui.position.left || Y_position<ui.position.top){
					Roll++;
				}else{
					Roll--;
				}
				$(this).parent('.img_stamp').css({'transform':'rotate('+Roll+'deg)'});

			}else if(Roll<215){
				if(X_position > ui.position.left || Y_position>ui.position.top){
					Roll++;
				}else{
					Roll--;
				}
				$(this).parent('.img_stamp').css({'transform':'rotate('+Roll+'deg)'});

			}else{
				if(X_position < ui.position.left || Y_position>ui.position.top){
					Roll++;
				}else{
					Roll--;
				}
				$(this).parent('.img_stamp').css({'transform':'rotate('+Roll+'deg)'});
			}
			X_position=ui.position.left;
			Y_position=ui.position.top;
			console.log(Roll);
			$(this).css('background','#0000d0');
			$('#r').text(Roll);
		},

		stop: function( event, ui ) {
			$(this).css('background','#fafafa');
		}
	});

	$('.img_stamp').draggable({
		drag: function(e, ui) {
			$(this).css("opacity",'0.5');
			$('.img_ctrl').hide();
			$('.img_stamp').css('border','none');

			tmp_x=$(this).offset().left;
			tmp_y=$(this).offset().top;
			tmp_w=$(this).width();
			tmp_h=$(this).height();

			$('#bx').text(tmp_x);
			$('#by').text(tmp_y);
			$('#x').text(tmp_w);
			$('#y').text(tmp_h);
		},



		stop: function( event, ui ) {
			$(this).css({'opacity':cssOp});
			$('.img_ctrl').show();
			$(this).css('border','1px solid #ff3030');
		}
	});
});



