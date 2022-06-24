$(function(){ 
var SC=0;
var Tmp=0;
var Tmp_d=0;

var TmpCnt=0;
var DBall=0;

var BoxView=0;
var Lock=0;
var Flag_2=0;
var Flag_3=0;
var Flag_4=0;
var Flag_5=0;
var Flag_6=0;

var BgColor=["","#d0e0c0","#cdf5e6","#c8d8ff","#ffe0f0","#e0a0e0","#e8d8a0"];
var Height=$(window).height()*0.8;


if (window.matchMedia('(max-width: 960px)').matches) {
	$(window).on('scroll',function () {

		if( $(this).scrollTop() > $('#block_2').offset().top - Height && Flag_2==0){
			Flag_2=1;
			$('#block_2_box_0').delay(400).animate({"opacity":"1","margin-top":"1vw"},900);
			$('#block_2_box_1').delay(800).animate({"opacity":"1","margin-top":"1vw"},600);
			$('#block_2_box_2').delay(1000).animate({"opacity":"1","margin-top":"1vw"},600);



		}else if( $(this).scrollTop() > $('#block_3').offset().top - Height && Flag_3==0){
			Flag_3=1;
			$({Deg:-10, Opc:0, Top:22, Lef:21}).animate({Deg:0, Opc:1, Top:2, Lef:2}, {
				duration:800,
				progress:function() {
					$('#box_item_a1').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"vw",
						'left':this.Lef+"vw",
					});
				},
			});


			$({Deg:-10, Opc:0, Top:22, Lef:70}).delay(200).animate({Deg:0, Opc:1, Top:2, Lef:49}, {
				duration:800,
				progress:function() {
					$('#box_item_a2').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"vw",
						'left':this.Lef+"vw",
					});
				},
			});


			$({Deg:-10, Opc:0, Top:66, Lef:21}).delay(200).animate({Deg:0, Opc:1, Top:44, Lef:2}, {
				duration:800,
				progress:function() {
					$('#box_item_a3').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"vw",
						'left':this.Lef+"vw",
					});
				},
			});

			$({Deg:-10, Opc:0, Top:66, Lef:70}).delay(400).animate({Deg:0, Opc:1, Top:44, Lef:49}, {
				duration:800,
				progress:function() {
					$('#box_item_a4').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"vw",
						'left':this.Lef+"vw",
					});
				},
			});

			$({Deg:-10, Opc:0, Top:110, Lef:21}).delay(400).animate({Deg:0, Opc:1, Top:86, Lef:2}, {
				duration:800,
				progress:function() {
					$('#box_item_a5').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"vw",
						'left':this.Lef+"vw",
					});
				},
			});


			$({Deg:-10, Opc:0, Top:110, Lef:70}).delay(600).animate({Deg:0, Opc:1, Top:86, Lef:49}, {
				duration:800,
				progress:function() {
					$('#box_item_a6').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"vw",
						'left':this.Lef+"vw",
					});
				},
			});

			$('#box_right_a').animate({"right":"1vw","opacity":"1"},1200);


		}else if( $(this).scrollTop() > $('#block_4').offset().top - Height && Flag_4==0){
			Flag_4=1;
			$({Deg:-10, Opc:0, Top:22, Lef:21}).animate({Deg:0, Opc:1, Top:2, Lef:2}, {
				duration:800,
				progress:function() {
					$('#box_item_b1').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"vw",
						'left':this.Lef+"vw",
					});
				},
			});


			$({Deg:-10, Opc:0, Top:22, Lef:70}).delay(200).animate({Deg:0, Opc:1, Top:2, Lef:49}, {
				duration:800,
				progress:function() {
					$('#box_item_b2').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"vw",
						'left':this.Lef+"vw",
					});
				},
			});


			$({Deg:-10, Opc:0, Top:66, Lef:21}).delay(200).animate({Deg:0, Opc:1, Top:44, Lef:2}, {
				duration:800,
				progress:function() {
					$('#box_item_b3').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"vw",
						'left':this.Lef+"vw",
					});
				},
			});

			$({Deg:-10, Opc:0, Top:66, Lef:70}).delay(400).animate({Deg:0, Opc:1, Top:44, Lef:49}, {
				duration:800,
				progress:function() {
					$('#box_item_b4').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"vw",
						'left':this.Lef+"vw",
					});
				},
			});

			$({Deg:-10, Opc:0, Top:110, Lef:21}).delay(400).animate({Deg:0, Opc:1, Top:86, Lef:2}, {
				duration:800,
				progress:function() {
					$('#box_item_b5').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"vw",
						'left':this.Lef+"vw",
					});
				},
			});


			$({Deg:-10, Opc:0, Top:110, Lef:70}).delay(600).animate({Deg:0, Opc:1, Top:86, Lef:49}, {
				duration:800,
				progress:function() {
					$('#box_item_b6').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"vw",
						'left':this.Lef+"vw",
					});
				},
			});

			$('#box_right_b').animate({"right":"1vw","opacity":"1"},1200);


		}else if( $(this).scrollTop() > $('#block_5').offset().top - Height && Flag_5==0){
			Flag_5=1;
			$('#block_5_box_0').delay(400).animate({"opacity":"1","margin-top":"1vw"},900);
			$('#block_5_box_1').delay(600).animate({"opacity":"1","margin-top":"1vw"},800);
			$('#block_5_box_2').delay(800).animate({"opacity":"1","margin-top":"1vw"},700);
			$('#block_5_box_3').delay(1000).animate({"opacity":"1","margin-top":"1vw"},600);
			$('#block_5_box_4').delay(1000).animate({"opacity":"1","margin-top":"1vw"},600);
			$('#block_5_box_5').delay(400).animate({"opacity":"1","margin-top":"1vw"},900);
			$('#block_5_box_6').delay(1000).animate({"opacity":"1","margin-top":"1vw"},600);


		}else if( $(this).scrollTop() > $('#block_6').offset().top - Height && Flag_6==0){
			Flag_6=1;
			$('#block_6_box_0').delay(200).animate({"opacity":"1","margin-top":"5vw"},900);



		}else if($(this).scrollTop()> ($('#block_1').offset().top - Height)){
			$('#block_1_box_1').animate({"opacity":"1","margin-top":"4vw"},1200);
			$('#block_1_box_2').delay(500).animate({"opacity":"1","margin-top":"2vw"},1000);

		}else if($(this).scrollTop()> ($('#block_2').offset().top - Height)){


		}




/*
		if(200 < $(this).scrollTop() && BoxView<6 && Lock == 0){//■■↓
			Lock=1;
			BoxView++;

			if(BoxView == 1){
				$('#block_'+BoxView).delay(150).animate({
					"top":"0",
					"background-color":BgColor[BoxView]
				},700,function(){
					Lock=0;
				});

				DownBall();

			}else{
				$('#block_'+BoxView).animate({
					"top":"0",
					"background-color":BgColor[BoxView]
				},600,function(){
					Lock=0;
				});

				 if(BoxView == 3){
					$({Deg:-10, Opc:0, Top:20, Lef:5}).animate({Deg:0, Opc:1, Top:1, Lef:1}, {
						duration:800,
						progress:function() {
							$('#box_item_a1').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});


					$({Deg:-10, Opc:0, Top:20, Lef:67}).delay(200).animate({Deg:0, Opc:1, Top:1, Lef:58}, {
						duration:800,
						progress:function() {
							$('#box_item_a2').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});


					$({Deg:-10, Opc:0, Top:45, Lef:5}).delay(200).animate({Deg:0, Opc:1, Top:26, Lef:1}, {
						duration:800,
						progress:function() {
							$('#box_item_a3').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});

					$({Deg:-10, Opc:0, Top:45, Lef:67}).delay(400).animate({Deg:0, Opc:1, Top:26, Lef:58}, {
						duration:800,
						progress:function() {
							$('#box_item_a4').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});

					$({Deg:-10, Opc:0, Top:70, Lef:5}).delay(400).animate({Deg:0, Opc:1, Top:51, Lef:1}, {
						duration:800,
						progress:function() {
							$('#box_item_a5').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});


					$({Deg:-10, Opc:0, Top:70, Lef:67}).delay(600).animate({Deg:0, Opc:1, Top:51, Lef:58}, {
						duration:800,
						progress:function() {
							$('#box_item_a6').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});
					$('#box_right_a').delay(600).animate({"right":"2vh","opacity":"1"},800);
				}

				if(BoxView == 4){
					$({Deg:-10, Opc:0, Top:20, Lef:5}).animate({Deg:0, Opc:1, Top:1, Lef:1}, {
						duration:800,
						progress:function() {
							$('#box_item_b1').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});


					$({Deg:-10, Opc:0, Top:20, Lef:67}).delay(200).animate({Deg:0, Opc:1, Top:1, Lef:58}, {
						duration:800,
						progress:function() {
							$('#box_item_b2').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});


					$({Deg:-10, Opc:0, Top:45, Lef:5}).delay(200).animate({Deg:0, Opc:1, Top:26, Lef:1}, {
						duration:800,
						progress:function() {
							$('#box_item_b3').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});

					$({Deg:-10, Opc:0, Top:45, Lef:67}).delay(400).animate({Deg:0, Opc:1, Top:26, Lef:58}, {
						duration:800,
						progress:function() {
							$('#box_item_b4').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});

					$({Deg:-10, Opc:0, Top:70, Lef:5}).delay(400).animate({Deg:0, Opc:1, Top:51, Lef:1}, {
						duration:800,
						progress:function() {
							$('#box_item_b5').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});

					$({Deg:-10, Opc:0, Top:70, Lef:67}).delay(600).animate({Deg:0, Opc:1, Top:51, Lef:58}, {
						duration:800,
						progress:function() {
							$('#box_item_b6').css({
								'transform':'rotate(' + this.Deg + 'deg)',
								'opacity':this.Opc,
								'top':this.Top+"vh",
								'left':this.Lef+"vh",
							});
						},
					});
					$('#box_right_b').delay(600).animate({"right":"2vh","opacity":"1"},800);
				}
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

	$(".box_item_in").hover(function () {
        $(this).animate({'width':'54vh','height':'22vh','top':'0.5vh','left':'0.5vh'},50);
    },
    function() {
        $(this).animate({'width':'53vh','height':'21vh','top':'1vh','left':'1vh'},100);
	});


	$(".box_item_icon").on('click',function () {
		Tmp=$(this).attr('id').substr(0,5);
		Tmp2=$(this).attr('id').substr(-1,1);

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

		$('#ball1').delay(200).animate({'left':'170vh','top':'-40vh'},400).animate({'left':'1vh','top': "-102vh"},300);
		$('#ball2').delay(200).animate({'left':'170vh','top':'-45vh'},450).animate({'left':'-54.5vh','top':"-91vh"},250);
		$('#ball3').delay(200).animate({'left':'170vh','top':'-50vh'},500).animate({'left':'-110vh','top':"-80vh"},200);
	}

	function DownBall() {
		$(".ball_icon").animate({"border-radius":'5vh'},150).delay(700).animate({"border-radius":'1vh'},150);

		$('#ball1').delay(200).animate({'left':'170vh','top':'-40vh'},400).animate({'left':'0px','top':'0'},250);
		$('#ball2').delay(250).animate({'left':'170vh','top':'-40vh'},500).animate({'left':'0px','top':'0'},250);
		$('#ball3').delay(300).animate({'left':'170vh','top':'-40vh'},600).animate({'left':'0px','top':'0'},250);

		$("#ball1 > .ball_txt").animate({'width':0,'padding':0},150).delay(800).animate({'width':'42.5vh',"padding-left":'10vh'},150);
		$("#ball2 > .ball_txt").animate({'width':0,'padding':0},200).delay(900).animate({'width':'42.5vh',"padding-left":'10vh'},150);
		$("#ball3 > .ball_txt").animate({'width':0,'padding':0},250).delay(1000).animate({'width':'42.5vh',"padding-left":'10vh'},150);
	}

*/
	});

	$(".box_item_icon").on('click',function () {
		Tmp=$(this).attr('id').substr(4,1);
		Tmp2=$(this).attr('id').substr(11,1);
		$("#h_" + Tmp).val(Tmp2);
		$("#form_" + Tmp).submit();
	});

}
});
