$(function(){ 
var SC=0;
var Tmp=0;
var Tmp_d=0;

var TmpCnt=0;
var DBall=0;

var BoxView=0;
var Lock=0;
var BgColor=["","#d0e0c0","#cdf5e6","#c8d8ff","#ffe0f0","#e0a0e0","#e8d8a0"];

var Height=$(window).height()*0.8;

if (window.matchMedia('(max-width: 960px)').matches) {
	$(window).on('scroll',function () {
		
console.log($(this).scrollTop()+"▼"+$("#block_1").offset().top+"▼"+$("#block_3").offset().top+"▼"+Height);

		if( $(this).scrollTop()> ( $('#block_3').offset().top - Height )){
			$({Deg:-10, Opc:0, Top:20, Lef:5}).animate({Deg:0, Opc:1, Top:1, Lef:1}, {
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


			$({Deg:-10, Opc:0, Top:20, Lef:67}).delay(200).animate({Deg:0, Opc:1, Top:1, Lef:50}, {
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


			$({Deg:-10, Opc:0, Top:45, Lef:5}).delay(200).animate({Deg:0, Opc:1, Top:26, Lef:1}, {
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

			$({Deg:-10, Opc:0, Top:45, Lef:67}).delay(400).animate({Deg:0, Opc:1, Top:26, Lef:50}, {
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

			$({Deg:-10, Opc:0, Top:70, Lef:5}).delay(400).animate({Deg:0, Opc:1, Top:51, Lef:1}, {
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


			$({Deg:-10, Opc:0, Top:70, Lef:67}).delay(600).animate({Deg:0, Opc:1, Top:51, Lef:50}, {
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

			$('#box_right_a').delay(600).animate({"right":"1vw","opacity":"1"},800);

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
}
});
