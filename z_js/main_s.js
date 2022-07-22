$(function(){ 
var SC=0;
var Tmp=0;
var Tmp_d=0;

var TmpCnt=0;
var DBall=0;

var BoxView=0;
var Lock=0;
var Flag_1=0;
var Flag_2=0;
var Flag_3=0;
var Flag_4=0;
var Flag_5=0;
var Flag_6=0;

var BgColor=["","#d0e0c0","#cdf5e6","#c8d8ff","#ffe0f0","#e0a0e0","#e8d8a0"];
var Height=$(window).height()*0.8;


if (window.matchMedia('(max-width: 960px)').matches) {
	$(window).on('scroll',function () {

		if( $(this).scrollTop() > $('#block_1').offset().top - Height && Flag_1==0){
			Flag_1=1;
			$('#block_1_box_0').delay(200).animate({"opacity":"1","margin-top":"1vw"},900);
			$('#block_1_box_1').delay(400).animate({"opacity":"1","margin-top":"1vw"},800);
			$('#block_1_box_2').delay(600).animate({"opacity":"1","margin-top":"1vw"},700);

		}else if( $(this).scrollTop() > $('#block_2').offset().top - Height && Flag_2==0){
			Flag_2=1;
			$('#block_2_box_0').delay(200).animate({"opacity":"1","margin-top":"1vw"},900);
			$('#block_2_box_1').delay(400).animate({"opacity":"1","margin-top":"1vw"},800);
			$('#block_2_box_2').delay(600).animate({"opacity":"1","margin-top":"1vw"},700);



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


			$({Deg:-10, Opc:0, Top:66, Lef:21}).delay(200).animate({Deg:0, Opc:1, Top:43, Lef:2}, {
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

			$({Deg:-10, Opc:0, Top:66, Lef:70}).delay(400).animate({Deg:0, Opc:1, Top:43, Lef:49}, {
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

			$({Deg:-10, Opc:0, Top:110, Lef:21}).delay(400).animate({Deg:0, Opc:1, Top:84, Lef:2}, {
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


			$({Deg:-10, Opc:0, Top:110, Lef:70}).delay(600).animate({Deg:0, Opc:1, Top:84, Lef:49}, {
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


			$({Deg:-10, Opc:0, Top:66, Lef:21}).delay(200).animate({Deg:0, Opc:1, Top:43, Lef:2}, {
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

			$({Deg:-10, Opc:0, Top:66, Lef:70}).delay(400).animate({Deg:0, Opc:1, Top:43, Lef:49}, {
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

			$({Deg:-10, Opc:0, Top:110, Lef:21}).delay(400).animate({Deg:0, Opc:1, Top:84, Lef:2}, {
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


			$({Deg:-10, Opc:0, Top:110, Lef:70}).delay(600).animate({Deg:0, Opc:1, Top:84, Lef:49}, {
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
			$('#block_5_box_0').delay(200).animate({"opacity":"1","margin-top":"1vw"},800);
			$('#block_5_box_1').delay(400).animate({"opacity":"1","margin-top":"1vw"},800);
			$('#block_5_box_3').delay(600).animate({"opacity":"1","margin-top":"1vw"},800);
			$('#block_5_box_4').delay(800).animate({"opacity":"1","margin-top":"1vw"},800);
			$('#block_5_box_5').delay(1000).animate({"opacity":"1","margin-top":"1vw"},800);
			$('#block_5_box_6, p').delay(1200).animate({"opacity":"1","margin-top":"1vw"},800);


		}else if( $(this).scrollTop() > $('#block_6').offset().top - Height && Flag_6==0){
			Flag_6=1;
			$('#block_6_box_0').delay(400).animate({"opacity":"1","margin-top":"5vw"},900);



		}else if($(this).scrollTop()> ($('#block_1').offset().top - Height)){
			$('#block_1_box_1').animate({"opacity":"1","margin-top":"4vw"},1200);
			$('#block_1_box_2').delay(500).animate({"opacity":"1","margin-top":"2vw"},1000);

		}else if($(this).scrollTop()> ($('#block_2').offset().top - Height)){


		}

	});

	$("#block_4 .box_item").on('click',function () {
		Tmp=$(this).attr('id').substr(9,1);
		Tmp2=$(this).attr('id').substr(10,1);


		$("#h_" + Tmp).val(Tmp2);
		$("#form_" + Tmp).submit();
	});
}
});
