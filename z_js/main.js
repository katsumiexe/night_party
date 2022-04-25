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

var BoxView=0;

$(function(){ 

console.log($('#block_0').offset().top);

	var BoxTop=[
	$('#block_0').offset().top,
	$('#block_1').offset().top,
	$('#block_2').offset().top,
	$('#block_3').offset().top,
	$('#block_4').offset().top
	];


	$(window).on('scroll',function () {
		if($(this).scrollTop() < SC+200 && BoxView>0){
			N=BoxView--;
			$('#block_'+BoxView).animate({"top":"0"},{step:function(){BoxView=N}},2000);
			SC=$(this).scrollTop();
			console.log(SC+"▲"+BoxView);

		}else if($(this).scrollTop() > SC+200 && BoxView<5){
			N=BoxView++;
			$('#block_'+BoxView).animate({"top":"100vh"},{step:function(){BoxView=N}},2000);
			SC=$(this).scrollTop();
			console.log(SC+"▼"+BoxView);

		}


//		$('body, html').scrollTop(Tmp);


/*


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
*/

	});

});



