var HGT_base=2000
var Flg_1=0;
var Flg_2=0;
var Flg_3=0;

var Fls_1=0;
var Fls_2=0;
var Fls_3=0;

var SC=0;
var Tmp=0;
var Tmp_d=0;

var TmpCnt=0;
var DBall=0;
var VH	=window.innerHeight;

$(function(){ 
	$(window).on('scroll',function () {
		var VH	=window.innerHeight;
		if($(this).scrollTop() >VH * 0.1 && DBall == 0){
			DownBall();

		}else if($(this).scrollTop() < VH * 0.2 && DBall == 1){
			UpBall();
		}

		SC=$(this).scrollTop();
		HGT=(HGT_base-SC)*(-0.2);
		H1=$('.box_3_1').offset().top;
		H2=$('.box_4_1').offset().top;

		console.log(H1+"▲"+VH+"▲"+SC);

		if(SC > 850){
			$("#back1").show().css('top',HGT);
			$(".box_0 > div").hide();

		}else{
			$("#back1").hide();
			$(".box_0 > div").show();
		}

//------------------------------------------------------
		if(SC > H1 - VH + 50 && Fls_1==0){
			Fls_1=1;
			$({Deg:-10, Opc:0, Top:100, Lef:40}).animate({Deg:0, Opc:1, Top:0, Lef:10}, {
				duration:800,
				progress:function() {
					$('#box_3_a1').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"px",
						'left':this.Lef+"px",
					});
				},
			});


			$({Deg:-10, Opc:0, Top:100, Lef:430}).delay(400).animate({Deg:0, Opc:1, Top:0, Lef:400}, {
				duration:800,
				progress:function() {
					$('#box_3_a2').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"px",
						'left':this.Lef+"px",
					});
				},
			});
		}

		if(SC > H1 - VH + 250 && Fls_2==0){
			Fls_2=1;
			$({Deg:-10, Opc:0, Top:260, Lef:40}).animate({Deg:0, Opc:1, Top:160, Lef:10}, {
				duration:800,
				progress:function() {
					$('#box_3_a3').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"px",
						'left':this.Lef+"px",
					});
				},
			});

			$({Deg:-10, Opc:0, Top:260, Lef:430}).delay(400).animate({Deg:0, Opc:1, Top:160, Lef:400}, {
				duration:800,
				progress:function() {
					$('#box_3_a4').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"px",
						'left':this.Lef+"px",
					});
				},
			});
		}

		if(SC > H1 - VH + 500 && Fls_3==0){
			Fls_3=1;
			$({Deg:-10, Opc:0, Top:420, Lef:40}).animate({Deg:0, Opc:1, Top:320, Lef:10}, {
				duration:800,
				progress:function() {
					$('#box_3_a5').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"px",
						'left':this.Lef+"px",
					});
				},
			});


			$({Deg:-10, Opc:0, Top:420, Lef:430}).delay(400).animate({Deg:0, Opc:1, Top:320, Lef:400}, {
				duration:800,
				progress:function() {
					$('#box_3_a6').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"px",
						'left':this.Lef+"px",
					});
				},
			});
		}

//------------------------------------------------------

		if(SC > H2 - VH + 50 && Flg_1==0){
			Flg_1=1;
			$({Deg:-10, Opc:0, Top:100, Lef:40}).animate({Deg:0, Opc:1, Top:0, Lef:10}, {
				duration:800,
				progress:function() {
					$('#box_4_a1').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"px",
						'left':this.Lef+"px",
					});
				},
			});


			$({Deg:-10, Opc:0, Top:100, Lef:430}).delay(400).animate({Deg:0, Opc:1, Top:0, Lef:400}, {
				duration:800,
				progress:function() {
					$('#box_4_a2').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"px",
						'left':this.Lef+"px",
					});
				},
			});
		}

		if(SC > H2 - VH + 250 && Flg_2==0){
			Flg_2=1;
			$({Deg:-10, Opc:0, Top:260, Lef:40}).animate({Deg:0, Opc:1, Top:160, Lef:10}, {
				duration:800,
				progress:function() {
					$('#box_4_a3').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"px",
						'left':this.Lef+"px",
					});
				},
			});

			$({Deg:-10, Opc:0, Top:260, Lef:430}).delay(400).animate({Deg:0, Opc:1, Top:160, Lef:400}, {
				duration:800,
				progress:function() {
					$('#box_4_a4').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"px",
						'left':this.Lef+"px",
					});
				},
			});
		}

		if(SC > H2 - VH + 500 && Flg_3==0){
			Flg_3=1;
			$({Deg:-10, Opc:0, Top:420, Lef:40}).animate({Deg:0, Opc:1, Top:320, Lef:10}, {
				duration:800,
				progress:function() {
					$('#box_4_a5').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"px",
						'left':this.Lef+"px",
					});
				},
			});


			$({Deg:-10, Opc:0, Top:420, Lef:430}).delay(400).animate({Deg:0, Opc:1, Top:320, Lef:400}, {
				duration:800,
				progress:function() {
					$('#box_4_a6').css({
						'transform':'rotate(' + this.Deg + 'deg)',
						'opacity':this.Opc,
						'top':this.Top+"px",
						'left':this.Lef+"px",
					});
				},
			});
		}
	});

	$(".box_1_ball").on('click',function(){
		if(DBall == 0){
			DownBall();
		}
	});
});


function UpBall() {
	$({Tmp_d:1350}).animate({Tmp_d:0}, {
		duration:1350,
		progress:function() {
			DBall=3;
			if(this.Tmp_d ==0){ 
				$("#ball1").css({'top':"-130vh","left":"0"});
				$("#ball2").css({'top':"-118vh","left":"-400px"});
				$("#ball3").css({'top':"-106vh","left":"-800px"});
				$(".ball_txt").css({'width':"250px","padding-left":"70px"});
				DBall=0;

			}else if(this.Tmp_d < 251){ 
				TmpR=10+this.Tmp_d / 8;
				$(".ball_txt").css({'width':250 - this.Tmp_d*25 +"px","padding-left":"70px"});
				$(".ball_icon").css({'border-radius':TmpR+'px'});

			}else if(this.Tmp_d < 1100){ 
				Tmp=Math.floor(this.Tmp_d-300);

				TmpA = -130 +Math.floor( 130 * Tmp / 800);
				TmpB =80000-(Tmp-400)*(Tmp-400)/2;
				TmpB=Math.floor(TmpB / 100);

				if(TmpA < -130 ){
					TmpA = -130;
				}

				if(TmpB < 0 ){
					TmpB = 0;
				}

				$('#ball1').css({
					'top':TmpA +"vh",
					'left':TmpB +"px"
				});

				TmpC = -118 +Math.floor( 118 * Tmp / 800);
				TmpD =22500-(Tmp-500)*(Tmp-500)/4;
				TmpD=Math.floor(TmpD / 100);

				if(TmpC < -118 ){
					TmpC = -118;
				}

				if(TmpD < -400){
					TmpD = -400;
				}

				$('#ball2').css({
					'top':TmpC +"vh",
					'left':TmpD +"px"
				});

				TmpE = -106 +Math.floor( 106 * Tmp / 800);
				TmpF =10000-(Tmp-600)*(Tmp-600)/4;
				TmpF=Math.floor(TmpF / 100);

				if(TmpE < -106 ){
					TmpE = -106;
				}

				if(TmpF < -800 ){
					TmpF = -800;
				}



				$('#ball3').css({
					'top':TmpE +"vh",
					'left':TmpF +"px"
				});

				if(Tmp < $(window).scrollTop()){
					$('body, html').scrollTop(Tmp);
				}

			}else{ 

				TmpR2	=30-(this.Tmp_d -1100) / 10;
				TmpP	=(this.Tmp_d -1100) / 3.5;
				$(".ball_txt").css({'width':this.Tmp_d-1100+55 +"px","padding-left":TmpP+"px"});
				$(".ball_icon").css({'border-radius':TmpR2+'px','background-color':'#fafafa'});
			}
		},
	});
}

function DownBall() {
	$({Tmp_d:0}).animate({Tmp_d:1350}, {
		duration:1350,
		progress:function() {
			DBall=3;
			if(this.Tmp_d < 251){ 
				TmpR=10+this.Tmp_d / 8;
				$(".ball_txt").css({'width':250 - this.Tmp_d*25 +"px","padding":0});
				$(".ball_icon").css({'border-radius':TmpR+'px'});
			}else if(this.Tmp_d < 301){ 


			}else if(this.Tmp_d < 1101){ 
				Tmp=Math.floor(this.Tmp_d-300);

				TmpA = 0-VH +Math.floor( (VH*1.3 / 800)*Tmp);
				TmpB =80000-(Tmp-400)*(Tmp-400)/2;
				TmpB=Math.floor(TmpB / 100);

				$('#ball1').css({
					'top':TmpA +"px",
					'left':TmpB +"px"
				});

				TmpC = Math.floor( 0-VH*0.88 + (VH*1.18 / 800)*Tmp);

				TmpD =22500-(Tmp-500)*(Tmp-500)/4;
				TmpD=Math.floor(TmpD / 100);

				$('#ball2').css({
					'top':TmpC +"px",
					'left':TmpD +"px"
				});

				TmpE = Math.floor( 0-VH*0.76 + (VH*1.06 / 800)*Tmp);
				TmpF =10000-(Tmp-600)*(Tmp-600)/4;
				TmpF=Math.floor(TmpF / 100);

				$('#ball3').css({
					'top':TmpE +"px",
					'left':TmpF +"px"
				});

				if(Tmp-500 > $(window).scrollTop()){
					$('body, html').scrollTop(Tmp-500);
				}

			}else{ 
				TmpR2	=30-(this.Tmp_d -1100) / 10;
				TmpP	=(this.Tmp_d -1100) / 3.5;
				$(".ball_txt").css({'width':this.Tmp_d-1100+55 +"px","padding-left":TmpP+"px"});
				$(".ball_icon").css({'border-radius':TmpR2+'px','background-color':'#fafafa'});

				$(".box_1_ball").css({'top':"0px","left":"0px"});

				DBall=1;

			}
		},
	});
}

