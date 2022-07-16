$(function(){ 
var SC=0;
var Tmp=0;
var Tmp_d=0;

var TmpCnt=0;
var DBall=0;

var BoxView=0;
var Lock=0;
var BgColor=["","#e0f0d0","#f0d0d8","#c8d8ff","#ffe0f0","#e0e0ea","#e8d8a0"];

if (window.matchMedia('(min-width: 959px)').matches) {
	$(window).on('scroll',function () {
		if(200 < $(this).scrollTop() && BoxView<6 && Lock == 0){//■■↓
			Lock=1;
			BoxView++;

			$('#block_'+BoxView).delay(150).animate({
				"top":"0",
				"background-color":BgColor[BoxView]
			},700,function(){
				Lock=0;
			});

			if(BoxView == 1){
				$('#block_1_box_0').delay(400).animate({"opacity":"1","margin-top":"1vh"},1000);
				$('#block_1_box_1').delay(600).animate({"opacity":"1","margin-top":"1vh"},900);
				$('#block_1_box_2').delay(1000).animate({"opacity":"1","margin-top":"1vh"},800);
				DownBall();

			}else if(BoxView == 2){
				$('#block_2_box_0').delay(400).animate({"opacity":"1","margin-top":"1vh"},800);
				$('#block_2_box_1').delay(800).animate({"opacity":"1","margin-top":"1vh"},800);
				$('#block_2_box_2').delay(1000).animate({"opacity":"1","margin-top":"1vh"},600);

			}else if(BoxView == 3){
				$({Deg:-10, Opc:0, Top:20, Lef:5}).animate({Deg:0, Opc:1, Top:1, Lef:1}, {
					duration:800,
					progress:function() {
						$('#box_item_a1').css({
							'transform'	:'rotate(' + this.Deg + 'deg)',
							'opacity'	:this.Opc,
							'top'		:this.Top+"vh",
							'left'		:this.Lef+"vh",
						});
					},
				});


				$({Deg:-10, Opc:0, Top:20, Lef:67}).delay(200).animate({Deg:0, Opc:1, Top:1, Lef:58}, {
					duration:800,
					progress:function() {
						$('#box_item_a2').css({
							'transform'	:'rotate(' + this.Deg + 'deg)',
							'opacity'	:this.Opc,
							'top'		:this.Top+"vh",
							'left'		:this.Lef+"vh",
						});
					},
				});


				$({Deg:-10, Opc:0, Top:45, Lef:5}).delay(200).animate({Deg:0, Opc:1, Top:26, Lef:1}, {
					duration:800,
					progress:function() {
						$('#box_item_a3').css({
							'transform'	:'rotate(' + this.Deg + 'deg)',
							'opacity'	:this.Opc,
							'top'		:this.Top+"vh",
							'left'		:this.Lef+"vh",
						});
					},
				});

				$({Deg:-10, Opc:0, Top:45, Lef:67}).delay(400).animate({Deg:0, Opc:1, Top:26, Lef:58}, {
					duration:800,
					progress:function() {
						$('#box_item_a4').css({
							'transform'	:'rotate(' + this.Deg + 'deg)',
							'opacity'	:this.Opc,
							'top'		:this.Top+"vh",
							'left'		:this.Lef+"vh",
						});
					},
				});

				$({Deg:-10, Opc:0, Top:70, Lef:5}).delay(400).animate({Deg:0, Opc:1, Top:51, Lef:1}, {
					duration:800,
					progress:function() {
						$('#box_item_a5').css({
							'transform'	:'rotate(' + this.Deg + 'deg)',
							'opacity'	:this.Opc,
							'top'		:this.Top+"vh",
							'left'		:this.Lef+"vh",
						});
					},
				});


				$({Deg:-10, Opc:0, Top:70, Lef:67}).delay(600).animate({Deg:0, Opc:1, Top:51, Lef:58}, {
					duration:800,
					progress:function() {
						$('#box_item_a6').css({
							'transform'	:'rotate(' + this.Deg + 'deg)',
							'opacity'	:this.Opc,
							'top'		:this.Top+"vh",
							'left'		:this.Lef+"vh",
						});
					},
				});
				$('#box_right_a').delay(600).animate({"right":"2vh","opacity":"1"},800);

			}else if(BoxView == 4){
				$({Deg:-10, Opc:0, Top:20, Lef:5}).animate({Deg:0, Opc:1, Top:1, Lef:1}, {
					duration:800,
					progress:function() {
						$('#box_item_b1').css({
							'transform'	:'rotate(' + this.Deg + 'deg)',
							'opacity'	:this.Opc,
							'top'		:this.Top+"vh",
							'left'		:this.Lef+"vh",
						});
					},
				});


				$({Deg:-10, Opc:0, Top:20, Lef:67}).delay(200).animate({Deg:0, Opc:1, Top:1, Lef:58}, {
					duration:800,
					progress:function() {
						$('#box_item_b2').css({
							'transform'	:'rotate(' + this.Deg + 'deg)',
							'opacity'	:this.Opc,
							'top'		:this.Top+"vh",
							'left'		:this.Lef+"vh",
						});
					},
				});


				$({Deg:-10, Opc:0, Top:45, Lef:5}).delay(200).animate({Deg:0, Opc:1, Top:26, Lef:1}, {
					duration:800,
					progress:function() {
						$('#box_item_b3').css({
							'transform'	:'rotate(' + this.Deg + 'deg)',
							'opacity'	:this.Opc,
							'top'		:this.Top+"vh",
							'left'		:this.Lef+"vh",
						});
					},
				});

				$({Deg:-10, Opc:0, Top:45, Lef:67}).delay(400).animate({Deg:0, Opc:1, Top:26, Lef:58}, {
					duration:800,
					progress:function() {
						$('#box_item_b4').css({
							'transform'	:'rotate(' + this.Deg + 'deg)',
							'opacity'	:this.Opc,
							'top'		:this.Top+"vh",
							'left'		:this.Lef+"vh",
						});
					},
				});

				$({Deg:-10, Opc:0, Top:70, Lef:5}).delay(400).animate({Deg:0, Opc:1, Top:51, Lef:1}, {
					duration:800,
					progress:function() {
						$('#box_item_b5').css({
							'transform'	:'rotate(' + this.Deg + 'deg)',
							'opacity'	:this.Opc,
							'top'		:this.Top+"vh",
							'left'		:this.Lef+"vh",
						});
					},
				});

				$({Deg:-10, Opc:0, Top:70, Lef:67}).delay(600).animate({Deg:0, Opc:1, Top:51, Lef:58}, {
					duration:800,
					progress:function() {
						$('#box_item_b6').css({
							'transform'	:'rotate(' + this.Deg + 'deg)',
							'opacity'	:this.Opc,
							'top'		:this.Top+"vh",
							'left'		:this.Lef+"vh",
						});
					},
				});
				$('#box_right_b').delay(600).animate({"right":"2vh","opacity":"1"},800);

			}else if(BoxView == 5){
				$('#block_5_box_0').delay(400).animate({"opacity":"1","margin-top":"1vh"},600);
				$('#block_5_box_1').delay(700).animate({"opacity":"1","margin-top":"1vh"},600);
				$('#block_5_box_3').delay(1000).animate({"opacity":"1","margin-top":"1vh"},500);
				$('#block_5_box_4').delay(1200).animate({"opacity":"1","margin-top":"1vh"},500);
				$('#block_5_box_5').delay(700).animate({"opacity":"1","margin-top":"1vh"},500);

//				$('#block_5_box_6').delay(1400).animate({"opacity":"1","margin-top":"1vh"},600);
				var N=800;
				$('#block_5_box_6 p').each(function(index, element){
					$(element).delay(N).animate({"opacity":"1","margin-top":"0.5vh"},500);
					N+=50;
				})

			}else if(BoxView == 6){
				$('#block_6_box_0').delay(200).animate({"opacity":"1","margin-top":"5vh"},1200);
			}


		}

		if(200 > $(this).scrollTop() && BoxView>0 && Lock == 0){//■■↑
			Lock=1;

			if(BoxView == 1){
				$('#block_'+BoxView).delay(150).animate({
					"top":"100vh",
					"background-color":"#fafafa"
				},700,function(){
					Lock=0;
					BoxView--;
				});
				UpBall();

			}else{
				$('#block_'+ BoxView).animate({
					"top":"100vh",
					"background-color":"#fafafa"
				},600,function(){
					Lock=0;
					BoxView--;
				});
			}
		}
		$(window).scrollTop(200);
	});

/*
	$(".box_1_ball").on('click',function(){
		if(BoxView == 0){
			Lock=1;
			BoxView++;
			$('#block_'+BoxView).delay(300).animate({
				"top":"0",
				"background-color":BgColor[BoxView]
			},700,function(){
				Lock=0;
			});
			DownBall();

		}else{
			Lock=1;
			$('#block_'+ BoxView).animate({
				"top":"100vh",
				"background-color":"#fafafa"
			},700,function(){
				Lock=0;
				BoxView--;
			});
			UpBall();
		}
	});
*/

	$(".box_item_in").hover(function () {
        $(this).find('.box_item_icon_1, .box_item_icon_3').animate({'right':'-1vh'},100);
    },
    function() {
        $(this).find('.box_item_icon_1, .box_item_icon_3').animate({'right':'15vh'},100);
	});

	$(".box_item").on('click',function () {
		Tmp=$(this).attr('id').substr(9,1);
		Tmp2=$(this).attr('id').substr(10,1);

		$("#h_" + Tmp).val(Tmp2);
		$("#form_" + Tmp).submit();
	});

	$(window).on('scroll',function () {
		if($(this).scrollTop() < SC+200 && BoxView>0){
			N=BoxView--;
			$('#block_'+BoxView).animate({"top":"0"},{step:function(){BoxView=N}},2000);
			SC=$(this).scrollTop();

		}else if($(this).scrollTop() > SC+200 && BoxView<5){
			N=BoxView++;
			$('#block_'+BoxView).animate({"top":"100vh"},{step:function(){BoxView=N}},2000);
			SC=$(this).scrollTop();
		}
	});

	function UpBall() {
		$(".ball_txt").animate({'width':0,'padding':0},150).delay(700).animate({'width':'42.5vh',"padding-left":'10vh'},150);
		$(".ball_icon").animate({'border-radius':'30px'},150).delay(700).animate({"border-radius":'10px'},150);
		$('.box_1_out').animate({'width':'100vw'},500);

		$('#ball1').delay(200).animate({'left':'170vh','top':'3vh'},400).animate({'left':'15vh','top': "1vh"},300);
		$('#ball2').delay(200).animate({'left':'170vh','top':'-8vh'},450).animate({'left':'15vh','top':"12vh"},250);
		$('#ball3').delay(200).animate({'left':'170vh','top':'14vh'},500).animate({'left':'15vh','top':"23vh"},200);

	}

	function DownBall() {
		$(".ball_icon").animate({"border-radius":'5vh'},150).delay(700).animate({"border-radius":'1vh'},150);
		$('.box_1_out').animate({'width':'170vh'},500);

		$('#ball1').delay(200).animate({'left':'170vh','top':'3vh'},400).animate({'left':'3.5vh','top':'5vh'},250);
		$('#ball2').delay(250).animate({'left':'170vh','top':'8vh'},500).animate({'left':'59vh','top':'5vh'},250);
		$('#ball3').delay(300).animate({'left':'170vh','top':'14vh'},600).animate({'left':'114.5vh','top':'5vh'},250);

		$("#ball1 > .ball_txt").animate({'width':0,'padding':0},150).delay(800).animate({'width':'42.5vh',"padding-left":'10vh'},150);
		$("#ball2 > .ball_txt").animate({'width':0,'padding':0},200).delay(900).animate({'width':'42.5vh',"padding-left":'10vh'},150);
		$("#ball3 > .ball_txt").animate({'width':0,'padding':0},250).delay(1000).animate({'width':'42.5vh',"padding-left":'10vh'},150);
	}
}

});
