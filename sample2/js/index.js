var TopCnt=0;
var Vw	=$(window).width();
var Vh	=$(window).height();
var TmpLink="";

var TmpScroll=0;
if(Vw <1200){
	TopW=Vw;

}else{
	TopW=1200;
}

const TMR=6000;

$(function(){ 
	timerId = setInterval(Fnc_s,TMR);

	$('.slide_img_cv').on('click',function () {
		if($('#slide_img'+TopCnt).attr('s_link')){
			$('#s_code').val($('#slide_img'+TopCnt).attr('s_code'));
			$('#form_1').attr('action',$('#slide_img'+TopCnt).attr('s_link')).submit();
		}
	});

	$('.slide_img_cv').draggable({
		axis: 'x',
		start: function( event, ui ) {
			startPosition = ui.position.left;

			clearInterval(timerId);
			TmpWidth=$('#slide_img0').width();

			Lim_l=$('#slide_img0').width()/(-5);
			Lim_r=$('#slide_img0').width()/5;

			if(TopCnt == Cnt-1){
				NewCnt=0;
			}else{
				NewCnt=TopCnt+1;
			}

			if(TopCnt == 0){
				OldCnt=Cnt-1;

			}else{
				OldCnt=TopCnt-1;
			}
		},

		drag: function( event, ui ){
			if(ui.position.left>0){//□みぎ
				if(Cnt == 2){
					$('#slide_img'+TopCnt).css({'left':ui.position.left,"z-index":1});
					$('#slide_img'+NewCnt).css({'left':0,"z-index":0});

				}else{
					$('#slide_img'+TopCnt).css({'left':ui.position.left});
					$('#slide_img'+NewCnt).css({'left':TmpWidth});
				}

			}else{
				if(Cnt == 2){
					$('#slide_img'+TopCnt).css({'left':0,"z-index":0});
					$('#slide_img'+NewCnt).css({'left':ui.position.left+TmpWidth,"z-index":1});

				}else{
					$('#slide_img'+NewCnt).css({'left':ui.position.left+TmpWidth});
					$('#slide_img'+TopCnt).css({'left':0});
				}

			}

			if($('#slide_img'+TopCnt).attr('s_link')){
				TmpLink=$('#slide_img'+TopCnt).attr('s_link');
				$('#slide_img'+TopCnt).attr('s_link','');
			}
		},

		stop: function( event, ui ) {
			if(ui.position.left< Lim_l){//■左へ
				$.when(
					$('#slide_img'+NewCnt).stop(true,true).animate({'left':0},200)

				).done(function() {
					$('#slide_img'+TopCnt).attr('s_link',TmpLink);
					TmpLink="";
					$('.slide_dot').removeClass('dot_on');
					$('#dot'+NewCnt).addClass('dot_on');

					TopCnt=NewCnt;
					if(TopCnt == 0){
						OldCnt=Cnt-1;
					}else{
						OldCnt=TopCnt-1;
					}

					for(var i=0;i<Cnt;i++){
						if(i == OldCnt){
							$('#slide_img'+i).css({'left':'0','zIndex':'0'});

						}else if(i == TopCnt){
							$('#slide_img'+i).css({'zIndex':'1'});

						}else{
							$('#slide_img'+i).css({'left':TopW,'zIndex':'2'});
						}
					}
					$('.slide_img_cv').css({'left':0});
					timerId = setInterval(Fnc_s,TMR);

				});


			}else if(ui.position.left>Lim_r){//■右へ
				$.when(
					$('#slide_img'+TopCnt).stop(true,true).animate({'left':TmpWidth},200)
				).done(function() {
					$('#slide_img'+TopCnt).attr('s_link',TmpLink);
					TmpLink="";
					$('.slide_dot').removeClass('dot_on');
					$('#dot'+OldCnt).addClass('dot_on');

					TopCnt=OldCnt;
					if(TopCnt == 0){
						OldCnt=Cnt-1;
					}else{
						OldCnt=TopCnt-1;
					}

					for(var i=0;i<Cnt;i++){
						if(i == OldCnt){
							$('#slide_img'+i).css({'left':'0','zIndex':'0'});

						}else if(i == TopCnt){
							$('#slide_img'+i).css({'zIndex':'1'});

						}else{
							$('#slide_img'+i).css({'left':TopW,'zIndex':'2'});
						}
					}
					$('.slide_img_cv').css({'left':0});
					timerId = setInterval(Fnc_s,TMR);
				});

			}else{

				$.when(
					$('#slide_img'+TopCnt).animate({'left':0},200),
					$('#slide_img'+NewCnt).animate({'left':TmpWidth},200)
				).done(function() {
					$('#slide_img'+TopCnt).attr('s_link',TmpLink);
					TmpLink="";
					$('.slide_img_cv').css({'left':0});
					timerId = setInterval(Fnc_s,TMR);
				});
			}
		}
	});


	$('.slide_dot').on('click',function () {
		var TMP=$(this).attr('id').replace('dot','');

		$('.slide_dot').removeClass('dot_on');
		$(this).addClass('dot_on');

		if(TopCnt != TMP){
			var TmpWidth=$('#slide_img'+TMP).width();

			$.when(
				$('#slide_img'+TMP).css({'left':TmpWidth,'z-index':'2'}).stop(true,true).delay(0).animate({'left':'0'},500)
			).done(function() {

				if(TMP == 0){
					OldCnt=Cnt-1;
				}else{
					OldCnt=TMP-1;
				}

				for(var i=0;i<Cnt;i++){

					if(i == OldCnt){
						$('#slide_img'+i).css({'left':'0','zIndex':'0'});

					}else if(i == TMP){
						$('#slide_img'+i).css({'zIndex':'1'});

					}else{
						$('#slide_img'+i).css({'left':TopW,'zIndex':'2'});
					}

				}
				TopCnt=TMP-0;

				clearInterval(timerId);
				timerId = setInterval(Fnc_s,TMR);
			});
		}
	});

	
	$(window).on('scroll',function () {
		if($(this).scrollTop() < TmpScroll){
			$('.menu').stop(true,true).animate({"top":"200px"},1000);
			TmpScroll=$(this).scrollTop();

		}else{
			$('.menu').stop(true,true).animate({"top":"100px"},1000);
			TmpScroll=$(this).scrollTop();
		}
		$('.menu').stop(true,true).animate({"top":"150px"},500);
	});

	$('.menu_item').on('click',function () {
		Tmp=$(this).attr("id").replace("menu","box_");
		Top=$("#"+Tmp).offset().top-100;
		$('body, html').animate({ scrollTop:Top}, 1000);
	});
});

var zIndex=0;
function Fnc_s(){
	NowCnt=TopCnt;
	TopCnt++;
	if(TopCnt>Cnt-1){
		TopCnt=0;
	}

	for(var i=0;i<Cnt;i++){
		if(i == NowCnt){
			$('#slide_img'+i).css({'left':'0','zIndex':'0'});

		}else if(i == TopCnt){
			$('#slide_img'+i).css({'left':TopW,'zIndex':'2'}).stop(true,true).animate({'left':'0','zIndex':'1'},500);

		}else{
			$('#slide_img'+i).css({'left':TopW,'zIndex':'2'});
		}
	}
	$('.slide_dot').removeClass('dot_on');
	$('#dot'+TopCnt).addClass('dot_on');
}

