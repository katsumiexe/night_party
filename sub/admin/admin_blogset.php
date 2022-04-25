<?
$sql	 ="SELECT id,genji FROM ".TABLE_KEY."_cast";
$sql	.=" WHERE cast_status=0";
$sql	.=" ORDER BY cast_sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$cast[$row["id"]]=$row["genji"];
	}
}

$sql	 ="SELECT tag_name,tag_icon,id FROM ".TABLE_KEY."_tag";
$sql	.=" WHERE tag_group='blog'";
$sql	.=" AND del=0";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[$row["id"]]=$row["tag_name"];
	}
}
?>
<script>
$(function(){ 

	var Width_l	=$('.b_img_box_out2').width();
	var Width_s	=$('.b_img_box_out1').width();

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
/*
	$('.event_set_btn').on('click',function(){


		if($('#blog_img').attr('src') !=="../img/blog_no_image.png"){
			TmpImg=$('#blog_img').attr("src").replace(/^data:image\/jpeg;base64,/, "");
		}
		$.post({
			url:"./post/blog_chg.php",
			data:{
				'id'			:"new",
				'date'			:$('#blog_date').val(),
				'status'		:$('#blog_status').val(),
				'title'			:$('#blog_title').val(),
				'tag'			:$('#blog_tag').val(),
				'log'			:$('#blog_log').val(),
				'img_code'		:TmpImg,

			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});
*/
	$('#blog_img').on('click',function(){
		Task="blog";
		$('.back,.b_img_box').fadeIn(300);

		Img=$(this).attr("src").replace('_s','');

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

		$("#cvs1").attr({'width': 600,'height': 600}).css({
			'width': Width_l,
			'height': Width_l,
			'left':Width_s,
			'top': Width_s
		});

		if(Img != "../img/blog_no_image.png"){
			ctx.drawImage(ChgImg, 0, 0, 600,600,0,0,600, 600);
		}

		ImgCode = cvs.toDataURL("image/jpeg");
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
/*
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

*/

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
		}
	});

	$('#img_set').on('click',function(){	
/*
console.log(ImgCode);
console.log($("#cvs1").css("top"));

console.log(Zoom);
console.log(Rote);

console.log(Width_s);
console.log(Width_l);
*/
		$('#wait').show();
		$.each(StSort, function(index, value){
			St_top[index]		=$("#stamp"+value).css('top');
			St_left[index]		=$("#stamp"+value).css('left');
			St_width[index]		=$("#stamp"+value).css('width');
			St_height[index]	=$("#stamp"+value).css('height');
			St_rotate[index]	=$("#rote"+value).val();
			St_url[index]		=$("#stamp"+value).children('.b_img_stamp_in').attr('src');
			St_op[index]		=$("#stamp"+value).children('.b_img_stamp_in').css('opacity');
		});
/*
console.log(St_url);
console.log(StSort);
*/
		$.post({
			url:"./post/img_set.php",
			data:{
				'img_code'	:ImgCode.replace(/^data:image\/jpeg;base64,/, ""),

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
console.log(data);
			base_64=$.trim(data);
			var cvs = document.getElementById('cvs1');
			var ctx = cvs.getContext('2d');
			ctx.clearRect(0, 0, cvs_A,cvs_A);
			if(base_64){
				$('#blog_img').attr('src',"data:image/jpg;base64,"+ base_64);
				$('#img_code').val(base_64);
			}else{
				$('#blog_img').attr('src',"../img/blog_no_image.png");
				$('#img_code').val("");
			}
			ImgId="";

			$('.filter_err').text('');
			$('#img_hidden').val(data);
			$('#wait').hide();
			$('.back,.img_box').fadeOut(300);

			$('.zoom_box').text('100');
			$('#input_zoom').val('100');

			ctx.clearRect(0, 0, cvs_A,cvs_A);
			Rote=0;

			var StSort=[];
			var StampCnt=30;

			for(var i=30; i<40; i++){
				$('#stamp'+i).css({'display':'none','width':Width_s*4,'height':Width_s*4,'transform':'rotate(0deg)','z-index':i,'top':25+(i-30)*10,'left':25+(i-30)*10});
			}
			$('.stamp_rote').val('0');
			$('.img_stamp_in').attr('src','');
			$('.b_stamp_box,.b_stamp_config').hide();

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
		$('.back,.b_img_box').fadeOut(300);
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');
		ctx.clearRect(0, 0, cvs_A,cvs_A);

		var StSort=[];
		var StampCnt=30;

		for(var i=30; i<40; i++){
			$('#stamp'+i).css({'display':'none','width':Width_s*4,'height':Width_s*4,'transform':'rotate(0deg)','z-index':i,'top':25+(i-30)*10,'left':25+(i-30)*10});
		}
		$('.b_stamp_rote').val('0');
	});

	$('#cvs1').on('click',function(){	
		$('.b_stamp_config').fadeOut(100);
		$('.b_img_ctrl').hide();
		$('.b_img_stamp').css('border','none');
	});

	$('.b_stamp_config_0').on('click',function(){	
		if($(this).hasClass('color_10')){
			$("#stamp"+TmpCtrl).children('.img_stamp_in').css('opacity',1);
			$(this).removeClass('color_10');
		}else{
			$("#stamp"+TmpCtrl).children('.img_stamp_in').css('opacity',0.6);
			$(this).addClass('color_10');
		}
	});

	$('.b_stamp_config_1').on('click',function(){	
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
		$('.b_stamp_config').fadeOut(200);
	});

	$('.b_stamp_config_2').on('click',function(){	
		$('#stamp'+TmpCtrl).css({'width':Width_s*4,'height':Width_s*4,'transform':'rotate(0deg)'});
		$('#rote'+TmpCtrl).val('0');
	});

	$('.b_stamp_config_3').on('click',function(){	
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

	$('.b_stamp_box_in').on('click',function(){	
		Tmp=$(this).attr('id').replace('stamp_in','');
		TmpSrc=$(this).children('.b_stamp_box_img').attr('src');
		$('#stamp'+StampCnt).children('.b_img_stamp_in').attr('src',TmpSrc);
		$('#stamp'+StampCnt).children('.ui-draggable-handle,.ui-resizable-handle').show();
		$('#stamp'+StampCnt).css({'display':'block','border':'1px solid #ff3030'});
		cssOp=1;

		StSort[StampCnt]=StampCnt;
		StampCnt++;
 	}); 


	$('.b_stamp_d').draggable({

		start: function( event, ui ) {
			tmp_H	=$(this).parent('.b_img_stamp').height();
			tmp_Y	=ui.position.top;

			tmp_W	=$(this).parent('.b_img_stamp').width();
			tmp_X	=ui.position.left;

			$(this).css('background','#0000d0');
		},

		drag: function(e, ui) {
			Now_W=ui.position.left - tmp_X;
			Now_H=ui.position.top - tmp_Y;
			if(Now_H > Now_W){
				$(this).parent('.b_img_stamp').css({'height':tmp_H + Now_H,'width':tmp_W + Now_H});
			}else{
				$(this).parent('.b_img_stamp').css({'height':tmp_H + Now_W,'width':tmp_W + Now_W});
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

	$('.b_stamp_r').draggable({
		start: function( event, ui ) {
			X_position=ui.position.left;
			Y_position=ui.position.top;
			$(this).addClass("op05");
			Roll=$(this).parent('.b_img_stamp').next('.b_stamp_rote').val();
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

			$(this).parent('.b_img_stamp').css({'transform':'rotate('+Roll+'deg)'});

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
			Tmp = $(this).parent('.b_img_stamp').attr('id').replace('stamp','');
			$('#rote'+ Tmp).val(Roll);
			$(this).removeClass("op05");
		}
	});


	$('.b_img_stamp').on('click',function(){
		TmpCtrl=$(this).attr('id').replace("stamp","");
		TmpSrc=$(this).children('.b_img_stamp_in').attr('src');
		$('#st_0').attr('src',TmpSrc);

		$('.b_stamp_config').fadeIn(100);

		$('.b_img_stamp').css('border','none');
		$(this).css('border','1px solid #ff3030');
		$(this).children('.b_img_ctrl').fadeIn(100);



		if($(this).children('.b_img_stamp_in').css('opacity')=="1"){
			$('.b_stamp_config_0').removeClass('color_10');
		}else{
			$('.b_stamp_config_0').addClass('color_10');
		}
	});

	$('.b_img_stamp').draggable({
		start: function(e, ui) {
			TmpCtrl=$(this).attr('id').replace("stamp","");
			TmpSrc=$(this).children('.b_img_stamp_in').attr('src');

			$('.b_img_stamp').css('border','none');
			$('.b_img_ctrl').hide();
			$(this).addClass("op05");

			$('#st_0').attr('src',TmpSrc);
			$(this).css('border','1px solid #ff3030');
			$('.b_stamp_config').fadeIn(100);
		},
		stop: function( event, ui ) {
			$(this).css('border','1px solid #ff3030');
			$(this).children('.b_img_ctrl').fadeIn(100);
			$(this).removeClass("op05");
		}
	});

	$('.upload_trush').on('click',function(){	
		var cvs = document.getElementById('cvs1');
		var ctx = cvs.getContext('2d');
		ctx.clearRect(0, 0, cvs_A,cvs_A);
		$('.mail_img_view').hide().attr('src',"");
		ImgCode='';
	});

	$('.upload_stamp').on('click',function(){	
		$('.b_img_stamp').css('border','none');
		$('.b_stamp_config,.b_stamp_box').fadeOut('200');

		if($('.b_stamp_box').css('display') ==="none"){
			$('.b_stamp_box').fadeIn('200');
		}else{
			$('.b_stamp_box').fadeOut('200');
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

	$('.b_zoom_mi').on( 'click', function () {
		Zoom--;
		if(Zoom <100){
			Zoom=100;
		}

		var css_An	=Math.floor(Zoom*css_A/100);
		$("#cvs1").css({'width':css_An,'height':css_An});

		$('.b_zoom_box').text(Zoom);
		$('#b_input_zoom').val(Zoom);
	});

	$( '.b_zoom_pu' ).on( 'click', function () {
		Zoom++;
		if(Zoom >300){
			Zoom=300;
		}

		var css_An	=Math.floor(Zoom*css_A/100);
		$("#cvs1").css({'width':css_An,'height':css_An});

		$('.b_zoom_box').text(Zoom);
		$('#b_input_zoom').val(Zoom);
	});

	$( '#b_input_zoom' ).on( 'input', function () {
		Zoom=$(this).val();
		if(Zoom > 300){
			Zoom=300;
		}
		if(Zoom < 100){
			Zoom=100;	
		}

		var css_An	=Math.floor(Zoom*css_A/100);
		$("#cvs1").css({'width':css_An,'height':css_An});
		$('.b_zoom_box').text(Zoom);
	});

	$('#img_reset').on( 'click', function () {
		Zoom=100;
		Left=css_B;
		Right=css_B;
		Rote=0;
		$("#cvs1").css({'width': css_A,'height': css_A,'left': css_B,'top': css_B, 'transform':'rotate(0deg)'});
		$('.zoom_box').text(Zoom);
		$('#input_zoom').val(Zoom);

		$('.b_img_stamp').hide();
		$('.stamp_rote').val('0');
		var StSort=[];
	});

	$('.img_open').on( 'click', function () {
		$('.back').fadeIn(500);
	});

	$("#blog_cast").on("change",function(){
		Tmp=$(this).val();
		if(Tmp == 1){
			$("#blog_face").attr("src","../img/staff_image.png");

		}else{
			TmpImg="../img/profile/"+Tmp+"/0_n.jpg";
			$("#blog_face").attr("src",TmpImg);
		}
	});

	$("#blog_face").on("error",function(){
		$("#blog_face").attr("src","../img/cast_no_image.jpg");
	});

});
</script>
<style>
.b_img_box{
	position		:fixed;
	display			:none;
	top				:40px;
	left			:0;
	right			:0;
	margin			:auto;
	width			:360px;
	height			:525px;
	background		:#f0f0f0;
	text-align		:center;
	border-radius	:10px;
	z-index			:130;
	border			:2px solid #303030;
	box-shadow		:3px 3px 2px rgba(30,30,30,0.5); 
	font-size		:0;
}

.b_img_box_in{
	display			:block;
	position		:relative;
	margin			:30px auto 0 auto;
	width			:300px;
	height			:300px;
	border			:1px solid #606060;
	overflow		:hidden;
	text-align		:center;
	background		:#f0f0f0;

}
.b_img_box_in2{
	display			:flex;
	position		:relative;
	margin			:0 auto;
	width			:310px;
	height			:60px;
	border			:none;
	justify-content	:space-between;
}

.b_img_box_in3{
	display			:flex;
	margin			:0 auto;
	flex-wrap		:nowrap;
	width			:300px;
	height			:50px;
}

.b_img_box_in4{
	display			:flex;
	width			:300px;
	margin			:5px auto;
	height			:50px;
	justify-content	:space-between;
}

input[type=range] {
	-webkit-appearance	:none;
	appearance			:none;

	background		:#f17766;
	background		:#000090;
	height			:5px;
	width			:98%;
	display			:inline-block;
	border			:none;
	margin			:18px 0;
	border-radius	:0;
}

input[type=range]::-webkit-slider-thumb{
	-webkit-appearance:none;
	background		:#f17766;
	height			:20px;
	width			:20px;
	border-radius	:50%;
	border			:2px solid #800000;
}


input[type=range]::-ms-tooltip{
	display:none;
}


input[type=range]::-moz-range-track{
	height:0;
}

input[type=range]::-moz-range-thumb{
	background		:#fafafa;
	height			:40px;
	width			:40px;
	border-radius	:50%;
	border			:none;
}

.b_zoom_mi{
	display				:inline-block;
	height				:40px;
	width				:30px;
	flex-basis			:30px;
	border				:1px solid #f17766;
	border-radius		:10px 0 0 10px;
	line-height			:40px;
	text-align			:center;
	cursor				:pointer;
	background			:#ffe0f0;
	color				:#f17766;
	font-size			:24px;
	font-weight			:600;
}


.b_zoom_pu{
	display				:inline-block;
	height				:40px;
	width				:30px;
	flex-basis			:30px;
	border				:1px solid #f17766;
	border-radius		:0 10px 10px 0;
	line-height			:40px;
	text-align			:center;
	cursor				:pointer;
	background			:#ffe0f0;
	color				:#f17766;
	font-size			:24px;
	font-weight			:600;
}

.b_zoom_rg{
	display				:inline-block;
	height				:40px;
	line-height			:40px;
	flex				:1;
	border				:1px solid #f17766;
	background			:#ffe0f0
}

.b_zoom_box{
	border				:1px solid #f17766;
	color				:#f17766;
	display				:inline-block;
	height				:40px;
	line-height			:40px;
	flex-basis			:50px;
	text-align			:center;
	margin-left			:5px;
	background			:#fafafa;
	font-weight			:600;
	font-size			:20px;
	border				:1px solid #f17766;
}

.upload_btn{
	width			:140px;
	height			:35px;
	line-height		:35px;
	flex-basis		:120px;
	margin			:10px 10px 10px 5px;
	border-radius	:5px;
	background		:linear-gradient(#f0f0f0,#d0d0d0);
	border			:1px solid #cccccc;
	font-size		:18px;
	text-align		:center;
}

.upload_icon{
	display			:inline-block;
	position		:relative;
	width			:40px;
	flex-basis		:40px;
	height			:35px;
	line-height		:35px;
	margin			:10px 5px;
	border-radius	:5px;
	border			:1px solid #cccccc;
	background		:linear-gradient(#f0f0f0,#d0d0d0);
	text-align		:center;
	cursor			:pointer;
	vertical-align	:top;
	font-size		:20px;
	font-family		:at_icon;
}

.upload_icon_p{
	display			:inline-block;
	width			:40px;
	height			:35px;
	line-height		:35px;
	margin			:0;
	text-align		:center;
	font-size		:20px;
	font-family		:at_icon;
}

.btn{
	display			:inline-block;
	position		:relative;
	text-decoration	:none;
	border-radius	:10px;
	text-align		:center;
	overflow		:hidden;
	font-size		:17px;
	font-weight		:700;
	height			:40px;
	line-height		:45px;
	border			:5px solid #ffffff;
	cursor			:pointer;
	padding			:0;
	margin			:0;
	width			:80px;
	flex-basis		:80px;
}

.btn:active {
	-webkit-transform: translateY(2px);
	transform: translateY(2px);
	box-shadow: 0 0 1px rgba(0, 0, 0, 0.15);
	background-image: linear-gradient(#eeeeee 0%, #dddddd 100%);
}

.btn_c4{
	background		: linear-gradient(#ff90a0 0%, #ffa0a0 100%);
	text-shadow		: 1px 1px 1px rgba(255,255,255, 0.66);
	box-shadow		: 2px 2px 2px rgba(0, 0, 0, 0.28);
	color			: #900000;
}

.btn_c5{
	background		: linear-gradient(#ddddff 0%, #ccccff 100%);
	text-shadow		: 1px 1px 1px rgba(255,255,255, 0.66);
	box-shadow		: 2px 2px 2px rgba(0, 0, 0, 0.28);
	color			: #3030ff;
}


.btn_c6{
	background		: linear-gradient(#ffd090 0%, #ffc060 100%);
	text-shadow		: 1px 1px 1px rgba(255,255,255, 0.66);
	box-shadow		: 2px 2px 2px rgba(0, 0, 0, 0.28);
	color			: #909000;
}




.b_img_box_out1{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:0;
	left		:0;
	width		:30px;
	height		:30px;
	z-index		:27;
}

.b_img_box_out2{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:0;
	left		:30px;
	width		:240px;
	height		:30px;
	border-bottom:1px solid #ff0000;
	z-index		:27;
}

.b_img_box_out3{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:0;
	right		:0;
	width		:30px;
	height		:30px;
	z-index		:27;
}

.b_img_box_out4{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:30px;
	left		:0;
	width		:30px;
	height		:240px;
	border-right:1px solid #ff0000;
	z-index		:27;
}

.b_img_box_out5{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:30px;
	right		:0;
	width		:30px;
	height		:240px;
	border-left	:1px solid #ff0000;
	z-index		:27;
}

.b_img_box_out6{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	bottom		:0;
	left		:0;
	width		:30px;
	height		:30px;
	z-index		:27;
}

.b_img_box_out7{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	bottom		:0vw;
	left		:30px;
	width		:240px;
	height		:30px;
	border-top	:1px solid #ff0000;
	z-index		:27;
}

.b_img_box_out8{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	bottom		:0;
	right		:0;
	width		:30px;
	height		:30px;
	z-index		:27;
}

.b_stamp_box {
    right			:-395px;
	display			:none;
	position		:absolute;
	width			:390px;
	height			:45px;
	bottom			:0;
    border			:1px solid #303030;
	table-layout	:auto;
	background		:linear-gradient(135deg,#e0e0e0,#d0d0d0);
	padding			:0;
	text-align		:center;
	border			:1px solid #303030;
	border-collapse	:collapse;
	font-size		:0;
}

.b_stamp_box_in {
	width			:45px;
	height			:45px;
	border			:1px solid #303030;
}

.b_stamp_box_img{
	width			:45px;
	height			:45px;
}


.b_img_stamp{
	display			:none;
	position		:absolute;
	top				:45px;
	left			:45px;
	height			:100px;
	width			:100px;
	border			:1px solid #ff3030;
	cursor			:pointer;
	overflow		:hidden;
	box-sizing		:border-box;
}

.b_img_stamp_in{
	position		:absolute;
	top				:-20.5%;
	left			:-20.5%;
	width			:141%;
	height			:141%;
}


.b_img_ctrl{
	width			:20px;
	height			:20px;
	line-height		:20px;
	font-size		:12px;
	position		:absolute;
	margin			:auto;
	border			:1px solid #ff3030;
	background		:#f0f0f0;
	color			:#ff3030;
	text-align		:center;
	font-family		:at_icon;
}	

.ui-resizable-handle{
	width			:20px;
	height			:20px;
	line-height		:20px;
	font-size		:10px;
}


.b_stamp_d{
	top				:auto !important;
	left			:auto !important;
	right			:0 !important;
	bottom			:0 !important;
}

.b_stamp_r{
	top				:0 !important;
	right			:0 !important;
	left			:auto !important;
	bottom			:auto !important;
}

.b_stamp_config{
	background		:#a08030;
	width			:390px;
	height			:80px;
	border			:1px solid #603000;
	bottom			:50px;
	right			:-395px;
	left			:auto;
	display			:none;
	position		:absolute;
	background		:#a08030;
	margin			:auto;
}

.b_stamp_config_0{
	position		:absolute;
	text-align		:center;
	background		:#f0f8ff;
	text-align		:center;
	color			:#909090;
	width			:100px;
	height			:32px;
	line-height		:32px;
	top				:43px;
	left			:80px;
	font-size		:14px;
	cursor			:pointer;
}

.b_stamp_config_1,.b_stamp_config_2,.b_stamp_config_3{
	position		:absolute;
	text-align		:left;
	font-weight		:700;
	color			:#fafafa;
	height			:32px;
	line-height		:32px;
	font-size		:12px;
	border-radius	:5px;
	padding-left	:30px
	cursor			:pointer;
}

.b_stamp_config_1{
	background	:linear-gradient(135deg,#e00000,#c00000);
	width		:60px;
}

.b_stamp_config_2{
	background	:linear-gradient(135deg,#ff6060,#ff0000);
	width		:60px;
}

.b_stamp_config_3{
	background	:linear-gradient(135deg,#808080,#606060);
	width		:40px;
}

.b_stamp_config_4{
	height			:70px;
	width			:70px;
	position		:absolute;
	background		:#ff90a0;
	cursor			:pointer;
}

#st_0{ top:5px;left:5px;}
#st_1{ top:5px;left:80px;}
#st_2{ top:5px;left:158px;}
#st_3{ top:5px;left:236px;}
#st_4{ top:5px;left:314px;}
#st_5{ top:43px;left:192px;}
#st_6{ top:43px;left:294px;}

.b_stamp_config_icon{
	width			:30px;
	height			:30px;
	line-height		:30px;
	font-size		:18px;
	left			:0px;
	position		:absolute;
	top				:0;
	bottom			:0;
	margin			:auto;
	display			:block;
	color			:#fafafa;
	text-align		:center;
	font-family		:at_icon;
}
/*
.ctrl_bar_in{
	background		:#0000d0;
	width			:7vw;
}

.ctrl_bar_tag{
	display			:inline-block;
	height			:100%;
	width			:100%;
	background		:#fafafa;
}
*/
</style>
<header class="head">
</header>
<div class="top_page">　</div>
<div class="wrap">
<div class="main_1">
<form id="blog_send" method="post">
<input type="hidden"name="menu_post" value="blog_write">
	<table id="tbl" class="blog_table" style="border:1px solid #303030;margin:5px;background:#fafafa">
		<tr>
			<td style="width:70px;text-align:right;" rowspan="2">
				<img id="blog_face" src="../img/staff_image.png" style="width:60px;height:80px;margin:5px;border:1px solid #000000;">
			</td>

			<td style="height:40px;">
				<select id="blog_cast" name="writer" class="w160 news_box">
				<option value="1">STAFF</option>
				<?foreach($cast as $d1 => $d2){?>
				<option value="<?=$d1?>"><?=$d2?></option>
				<?}?>
				</select>

				<span class="event_tag" style="vertical-align:top">公開日</span>
				<input id="blog_date" type="datetime-local" name="view_date" class="w200" value="<?=date("Y-m-d",time()+32400)?>T<?=date("H:i",time()+32400)?>" style="vertical-align:top">

				<select id="blog_status" name="status" class="w150 news_box" style="vertical-align:top">
					<option value="0">通常</option>
					<option value="2">非公開</option>
					<option value="3">非表示</option>
				</select>
				<button type="submit" class="event_set_btn w100" style="vertical-align:top;margin-left:15px;background:#ffe0e0">投稿</button>
			</td>
			<td class="blog_td_img" rowspan="3">
				<img id="blog_img" src="../img/blog_no_image.png" style="width:300px">
				<input id="img_code" type="hidden" name="img_code">

			</td>
		</tr>

		<tr>
			<td style="height:40px;">
				<span class="event_tag" style="vertical-align:top">TITLE</span><input id="blog_title" type="text" name="title" style="width:310px;padding-left:5px; vertical-align:top" value="">
				<span class="event_tag" style="vertical-align:top">タグ</span>
				<select id="blog_tag" name="tag" class="w150 news_box">
				<?foreach($tag as $b1 => $b2){?>
				<option value="<?=$b1?>"><?=$b2?></option>
				<?}?>
				</select>
				<label for="news_check" class="ribbon_use" style="margin:0 0 0 10px;display:inline-block;vertical-align:top">
					<span class="check2">
						<input id="news_check" type="checkbox" name="news_check" class="ck0" value="1" checked="checked">
						<span class="check1"></span>
					</span>
					<span>NEWS登録</span>
				</label>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<textarea id="blog_log" name="log" class="news_title" style="width:760px;height:400px;margin:5px;"></textarea>
			</td>
		</tr>
	</table>
</form>
</div>
</div>
