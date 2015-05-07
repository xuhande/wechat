/*
** å˜é‡å€¼
*/
	/* 
	** é¡µé¢åˆ‡æ¢çš„æ•ˆæžœæŽ§åˆ¶ 
	*/
var Msize = $(".m-page").size(), 	//é¡µé¢çš„æ•°ç›®
	page_n			= 1,			//åˆå§‹é¡µé¢ä½ç½®
	initP			= null,			//åˆå€¼æŽ§åˆ¶å€¼
	moveP			= null,			//æ¯æ¬¡èŽ·å–åˆ°çš„å€¼
	firstP			= null,			//ç¬¬ä¸€æ¬¡èŽ·å–çš„å€¼
	newM			= null,			//é‡æ–°åŠ è½½çš„æµ®å±‚
	p_b				= null,			//æ–¹å‘æŽ§åˆ¶å€¼
	indexP			= null, 		//æŽ§åˆ¶é¦–é¡µä¸èƒ½ç›´æŽ¥æ‰¾è½¬åˆ°æœ€åŽä¸€é¡µ
	move			= null,			//è§¦æ‘¸èƒ½æ»‘åŠ¨é¡µé¢
	start			= true, 		//æŽ§åˆ¶åŠ¨ç”»å¼€å§‹
	startM			= null,			//å¼€å§‹ç§»åŠ¨
	position		= null,			//æ–¹å‘å€¼
	DNmove			= false,		//å…¶ä»–æ“ä½œä¸è®©é¡µé¢åˆ‡æ¢
	mapS			= null,			//åœ°å›¾å˜é‡å€¼
	canmove			= false,		//é¦–é¡µè¿”å›žæœ€åŽä¸€é¡µ
	
	textNode		= [],			//æ–‡æœ¬å¯¹è±¡
	textInt			= 1;			//æ–‡æœ¬å¯¹è±¡é¡ºåº
	
	/*
	** å£°éŸ³åŠŸèƒ½çš„æŽ§åˆ¶
	*/
	audio_switch_btn= true,			//å£°éŸ³å¼€å…³æŽ§åˆ¶å€¼
	audio_btn		= true,			//å£°éŸ³æ’­æ”¾å®Œæ¯•
	audio_loop		= false,		//å£°éŸ³å¾ªçŽ¯
	audioTime		= null,         //å£°éŸ³æ’­æ”¾å»¶æ—¶
	audioTimeT		= null,			//è®°å½•ä¸Šæ¬¡æ’­æ”¾æ—¶é—´
	audio_interval	= null,			//å£°éŸ³å¾ªçŽ¯æŽ§åˆ¶å™¨
	audio_start		= null,			//å£°éŸ³åŠ è½½å®Œæ¯•
	audio_stop		= null,			//å£°éŸ³æ˜¯å¦åœ¨åœæ­¢
	mousedown		= null,			//PCé¼ æ ‡æŽ§åˆ¶é¼ æ ‡æŒ‰ä¸‹èŽ·å–å€¼
	
	/*
	** ç»Ÿè®¡æŽ§åˆ¶
	*/
	plugin_type		= {				//è®°å½•é¡µé¢åˆ‡æ¢çš„æ•°é‡
		'info_pic2':{num:0,id:0},
		'info_nomore':{num:0,id:0},
		'info_more':{num:0,id:0},
		'multi_contact':{num:0,id:0},
		'video':{num:0,id:0},
		'input':{num:0,id:0},
		'dpic':{num:0,id:0}
	};   

/*wit*/
	/*	$(".next-page").live("touchstart",function(){
			alert(1);
			$(".m-page").eq(12).animate({'top':0},300,"easeOutSine",function(){
					success();
				})
		});
		*/
/* 
** å•é¡µåˆ‡æ¢ å„ä¸ªå…ƒç´ fixed æŽ§åˆ¶bodyé«˜åº¦ 
*/
	var v_h	= null;		//è®°å½•è®¾å¤‡çš„é«˜åº¦
	
	function init_pageH(){
		var fn_h = function() {
			if(document.compatMode == "BackCompat")
				var Node = document.body;
			else
				var Node = document.documentElement;
			 return Math.max(Node.scrollHeight,Node.clientHeight);
		}
		var page_h = fn_h();
		var m_h = $(".m-page").height();
		page_h >= m_h ? v_h = page_h : v_h = m_h ;
		
		//è®¾ç½®å„ç§æ¨¡å—é¡µé¢çš„é«˜åº¦ï¼Œæ‰©å±•åˆ°æ•´ä¸ªå±å¹•é«˜åº¦
		$(".m-page").height(v_h); 	
		$(".p-index").height(v_h);
		
	};
	init_pageH();

	/* å¤§å›¾æ–‡å›¾ç‰‡å»¶è¿ŸåŠ è½½ */
	var lazyNode = $('.lazy-bk');
	lazyNode.each(function(){
		var self = $(this);
		if(self.is('img')){
			self.attr('src','data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC');
		}else{
			self.css({
				'background-image'	: 'url(/template/10/img/loading_large.gif)',
				'background-size'	: '120px 120px'

			})
		}
	})

	// å‰ä¸‰ä¸ªé¡µé¢çš„å›¾ç‰‡å»¶è¿ŸåŠ è½½
	setTimeout(function(){
		for(var i=0;i<3;i++){
			var node = $(".m-page").eq(i);
			if(node.length==0) break;
			if(node.find('.lazy-bk').length!=0){
				lazy_change(node);
			}else continue;
		}
	},200)
	
	// åŠ è½½å½“å‰åŽé¢ç¬¬ä¸‰ä¸ª
	function lazy_bigP(){
		for(var i=3;i<=5;i++){
			var node = $(".m-page").eq(page_n+i-1);
			if(node.length==0) break;
			if(node.find('.lazy-bk').length!=0){
				lazy_change(node);
			}else continue;
		}
	}

	// å›¾ç‰‡å»¶è¿Ÿæ›¿æ¢å‡½æ•°
	function lazy_change(node){
			if(node.attr('data-yuyue')=='true'){
				$('.weixin-share').find('.lazy-bk').attr('src',$('.weixin-share').find('.lazy-bk').attr('data-bk'));
			}
			var lazy = node.find('.lazy-bk');
			lazy.each(function(){
				var self = $(this),
					srcImg = self.attr('data-bk');

				$('<img />')
					.on('load',function(){
						if(self.is('img')){
							self.attr('src',srcImg)
						}else{
							self.css({
								'background-image'	: 'url('+srcImg+')',
								'background-size'	: 'cover'
							})
						}

						// åˆ¤æ–­ä¸‹é¢é¡µé¢è¿›è¡ŒåŠ è½½
						for(var i =0;i<$(".m-page").size();i++){
							var page = $(".m-page").eq(i);
							if($(".m-page").find('.lazy-bk').length==0) continue
							else{
								lazy_change(page);
							}
						}
					})
					.attr("src",srcImg);

				self.removeClass('lazy-bk');
			})	
	}

/*
**æ¨¡ç‰ˆåˆ‡æ¢é¡µé¢çš„æ•ˆæžœ
*/
	//ç»‘å®šäº‹ä»¶
	function changeOpen(e){
		$(".m-page").on('mousedown touchstart',page_touchstart);
		$(".m-page").on('mousemove touchmove',page_touchmove);
		$(".m-page").on('mouseup touchend mouseout',page_touchend);
		
		$('.wct .tableWrap').on('mousedown touchstart',page_touchstart);
		$('.wct .tableWrap').on('mousemove touchmove',page_touchmove);
		$('.wct .tableWrap').on('mouseup touchend mouseout',page_touchend);
	};
	
	//å–æ¶ˆç»‘å®šäº‹ä»¶
	function changeClose(e){
		$(".m-page").off('mousedown touchstart');
		$(".m-page").off('mousemove touchmove');
		$(".m-page").off('mouseup touchend mouseout');
		
		$('.wct .tableWrap').off('mousedown touchstart');
		$('.wct .tableWrap').off('mousemove touchmove');
		$('.wct .tableWrap').off('mouseup touchend mouseout');
	};
	
	//å¼€å¯äº‹ä»¶ç»‘å®šæ»‘åŠ¨
	changeOpen();
	
	//è§¦æ‘¸ï¼ˆé¼ æ ‡æŒ‰ä¸‹ï¼‰å¼€å§‹å‡½æ•°
	function page_touchstart(e){
		if (e.type == "touchstart") {
			initP = window.event.touches[0].pageY;
		} else {
			initP = e.y || e.pageY;
			mousedown = true;
		}
		firstP = initP;	
	};
	
	//æ’ä»¶èŽ·å–è§¦æ‘¸çš„å€¼
	function V_start(val){
		initP = val;
		mousedown = true;
		firstP = initP;		
	};
	
	
	//è§¦æ‘¸ç§»åŠ¨ï¼ˆé¼ æ ‡ç§»åŠ¨ï¼‰å¼€å§‹å‡½æ•°
	function page_touchmove(e){
		e.preventDefault();
		e.stopPropagation();	
		$(".player-tip").hide();
		//åˆ¤æ–­æ˜¯å¦å¼€å§‹æˆ–è€…åœ¨ç§»åŠ¨ä¸­èŽ·å–å€¼
		if(start||startM){
			startM = true;
			if (e.type == "touchmove") {
				moveP = window.event.touches[0].pageY;
			} else { 
				if(mousedown) moveP = e.y || e.pageY;
			}
			page_n == 1 ? indexP = false : indexP = true ;	//true ä¸ºä¸æ˜¯ç¬¬ä¸€é¡µ falseä¸ºç¬¬ä¸€é¡µ
		}

		//è®¾ç½®ä¸€ä¸ªé¡µé¢å¼€å§‹ç§»åŠ¨
		if(moveP&&startM){
			
			//åˆ¤æ–­æ–¹å‘å¹¶è®©ä¸€ä¸ªé¡µé¢å‡ºçŽ°å¼€å§‹ç§»åŠ¨
			if(!p_b){
				p_b = true;
				position = moveP - initP > 0 ? true : false;	//true ä¸ºå‘ä¸‹æ»‘åŠ¨ false ä¸ºå‘ä¸Šæ»‘åŠ¨
				if(position){

				//å‘ä¸‹ç§»åŠ¨
					if(indexP){								
						newM = page_n - 1 ;
						$(".m-page").eq(newM-1).addClass("active").css("top",-v_h);
						move = true ;
					}else{
						if(canmove){
							move = true;
							newM = Msize;
							$(".m-page").eq(newM-1).addClass("active").css("top",-v_h);
						}
						else move = false;
					}
							
				}else{
				//å‘ä¸Šç§»åŠ¨
					if(page_n != Msize){
						if(!indexP) $('.audio_txt').addClass('close');
						newM = page_n + 1 ;
					}else{
						newM = 1 ;
					}
					$(".m-page").eq(newM-1).addClass("active").css("top",v_h);
					move = true ;
				} 
			}
			
			//æ ¹æ®ç§»åŠ¨è®¾ç½®é¡µé¢çš„å€¼
			if(!DNmove){
				//æ»‘åŠ¨å¸¦åŠ¨é¡µé¢æ»‘åŠ¨
				if(move){	
					//å¼€å¯å£°éŸ³
					if($("#car_audio").length>0&&audio_switch_btn&&Math.abs(moveP - firstP)>100){
						$("#car_audio")[0].play();
						audio_loop = true;
					}
				
					//ç§»åŠ¨ä¸­è®¾ç½®é¡µé¢çš„å€¼ï¼ˆtopï¼‰
					start = false;
					var topV = parseInt($(".m-page").eq(newM-1).css("top"));
					$(".m-page").eq(newM-1).css({'top':topV+moveP-initP});	
					initP = moveP;
				}else{
					moveP = null;	
				}
			}else{
				moveP = null;	
			}
		}
	};

	//è§¦æ‘¸ç»“æŸï¼ˆé¼ æ ‡èµ·æ¥æˆ–è€…ç¦»å¼€å…ƒç´ ï¼‰å¼€å§‹å‡½æ•°
	function page_touchend(e){	
			
		//ç»“æŸæŽ§åˆ¶é¡µé¢
		startM =null;
		p_b = false;
		
		//å…³é—­å£°éŸ³
		 audio_close();
		
		//åˆ¤æ–­ç§»åŠ¨çš„æ–¹å‘
		var move_p;	
		position ? move_p = moveP - firstP > 100 : move_p = firstP - moveP > 100 ;
		if(move){
			//åˆ‡ç”»é¡µé¢(ç§»åŠ¨æˆåŠŸ)
			if( move_p && Math.abs(moveP) >5 ){	
				$(".m-page").eq(newM-1).animate({'top':0},300,"easeOutSine",function(){
					/*
					** åˆ‡æ¢æˆåŠŸå›žè°ƒçš„å‡½æ•°
					*/
					success();
				})
			//è¿”å›žé¡µé¢(ç§»åŠ¨å¤±è´¥)
			}else if (Math.abs(moveP) >=5){	//é¡µé¢é€€å›žåŽ»
				position ? $(".m-page").eq(newM-1).animate({'top':-v_h},100,"easeOutSine") : $(".m-page").eq(newM-1).animate({'top':v_h},100,"easeOutSine");
				$(".m-page").eq(newM-1).removeClass("active");
				start = true;
			}
		}
		/* åˆå§‹åŒ–å€¼ */
		initP		= null,			//åˆå€¼æŽ§åˆ¶å€¼
		moveP		= null,			//æ¯æ¬¡èŽ·å–åˆ°çš„å€¼
		firstP		= null,			//ç¬¬ä¸€æ¬¡èŽ·å–çš„å€¼
		mousedown	= null;			//å–æ¶ˆé¼ æ ‡æŒ‰ä¸‹çš„æŽ§åˆ¶å€¼
	};
/*
** åˆ‡æ¢æˆåŠŸçš„å‡½æ•°
*/
var J_fTxt = $('.J_fTxt');
setTimeout(function(){
J_fTxt.eq(0).show();
},500);
	function success(){
		/*
		** åˆ‡æ¢æˆåŠŸå›žè°ƒçš„å‡½æ•°
		*/							
		//è®¾ç½®é¡µé¢çš„å‡ºçŽ°
		$(".m-page").eq(page_n-1).removeClass("show active").addClass("hide");
		$(".m-page").eq(newM-1).removeClass("active hide").addClass("show");
		
		// æ»‘åŠ¨æˆåŠŸåŠ è½½å¤šé¢çš„å›¾ç‰‡
		lazy_bigP();
		
		//é‡æ–°è®¾ç½®é¡µé¢ç§»åŠ¨çš„æŽ§åˆ¶å€¼
		page_n = newM;
		start = true;
		J_fTxt.eq(page_n-1).show();
		J_fTxt.each(function(k,v){
			if(k!==page_n-1){
				$(this).hide();
			}
		});
		
		//åˆ¤æ–­æ˜¯ä¸æ˜¯æœ€åŽä¸€é¡µï¼Œå‡ºçŽ°æç¤ºæ–‡å­—
		if(page_n == Msize) {
			if($('.popup-txt').attr('data-show')!='show'){
				$('.popup-txt').attr('data-show','show');
				$('.popup-txt').addClass('txtHide');
			}
			canmove = true;
		}else{
			$('.popup-txt').removeClass('txtHide');	
		}
		
		//åœ°å›¾é‡ç½®
		if($(".m-page").eq(page_n-1).find(".ylMap").length>0&&!mapS){
			if(!mapS) mapS = new ylmap.init;
		}
		
		//txtå¯Œæ–‡æœ¬è‡ªé€‚åº”ä¼¸ç¼©
		if($(".m-page").eq(page_n-1).find('.m-txt').length>0) txtExtand();
	
		//é¡µé¢åˆ‡æ¢è§†é¢‘æ’­æ”¾åœæ­¢
		if($('.m-video').find("video")[0]!=undefined){
			$('.m-video').find("video")[0].pause();
			$('.video-warp').show();
		};
		
		//æ–‡æœ¬ç¼©å›ž
		$(".m-txt").removeClass("open");	
		$('.m-txt').each(function(){
			if($(this).attr('data-self')!=''){
				$(this).css('height',$(this).attr('data-self'));
			}
		})
	}

/*
** å£°éŸ³åŠŸèƒ½
*/
	//å…³é—­å£°éŸ³
	function audio_close(){
		if(audio_btn&&audio_loop){
			audio_btn =false;
			audioTime = Number($("#car_audio")[0].duration-$("#car_audio")[0].currentTime)*1000;	
			if(audioTime<0){ audioTime=0; }
			if(audio_start){
				if(isNaN(audioTime)){
					audioTime = audioTimeT;
				}else{
					audioTime > audioTimeT ? audioTime = audioTime: audioTime = audioTimeT;
				}
			};
			if(!isNaN(audioTime)&&audioTime!=0){
				audio_btn =false;		
				setTimeout(
					function(){	
						$("#car_audio")[0].pause();
						$("#car_audio")[0].currentTime = 0;
						audio_btn = true;
						audio_start = true;	
						if(!isNaN(audioTime)&&audioTime>audioTimeT) audioTimeT = audioTime;
					},audioTime);
			}else{
				audio_interval = setInterval(function(){
					if(!isNaN($("#car_audio")[0].duration)){
						if($("#car_audio")[0].currentTime !=0 && $("#car_audio")[0].duration!=0 && $("#car_audio")[0].duration==$("#car_audio")[0].currentTime){
							$("#car_audio")[0].currentTime = 0;	
							$("#car_audio")[0].pause();
							clearInterval(audio_interval);
							audio_btn = true;
							audio_start = true;
							if(!isNaN(audioTime)&&audioTime>audioTimeT) audioTimeT = audioTime;
						}
					}
				},20)	
			}
		}
	}
	
	//é¡µé¢å£°éŸ³æ’­æ”¾
	$(function(){
		//èŽ·å–å£°éŸ³å…ƒä»¶
		var btn_au = $(".fn-audio").find(".btn");
		
		//ç»‘å®šç‚¹å‡»äº‹ä»¶
		btn_au.on('click',audio_switch);
		function audio_switch(){
			if($("#car_audio")==undefined){
				return;
			}
			if(audio_switch_btn){
				//å…³é—­å£°éŸ³
				$("#car_audio")[0].pause();
				audio_switch_btn = false;
				$("#car_audio")[0].currentTime = 0;
				btn_au.find("span").eq(0).css("display","none");
				btn_au.find("span").eq(1).css("display","inline-block");
			}
			//å¼€å¯å£°éŸ³
			else{
				audio_switch_btn = true;
				btn_au.find("span").eq(1).css("display","none");
				btn_au.find("span").eq(0).css("display","inline-block");
			}
		}
		
	});

/*
**æ–‡æœ¬å±•å¼€æ•ˆæžœ
*/
	//åˆ¤æ–­å¯Œæ–‡æœ¬æ˜¯å¦å±•å¼€
	function txtExtand(){
		// å¯å¦å±•å¼€
		$(".m-page").eq(page_n-1).find('.m-txt').not('.txt-noclick').each(function(){
			var txt = $(this).attr('data-txt'),
				txtnum;
			if(!txt){
				$(this).attr('data-txt',textInt);
				txtnum = textInt;
				textInt++;
			}else{
				txtnum = txt;
			}
			if(txtnum in textNode){
			}else{
				var maxHeight = '500';
				if($(".m-page").eq(page_n-1).find('.m-txt02').size()>0){
					maxHeight = '300';
				}
				textNode[txtnum] = 	new txtInit(this,{maxHeight:maxHeight,maxWidth:'500',node:'p,h2'});
			}
		});
	};
	//txtå¯Œæ–‡æœ¬è‡ªé€‚åº”ä¼¸ç¼©
	if($(".m-page").eq(page_n-1).find('.m-txt').length>0) txtExtand();

/*
**è®¾å¤‡æ—‹è½¬æç¤º
*/
	$(function(){
		var bd = $(document.body);
		window.addEventListener('onorientationchange' in window ? 'orientationchange' : 'resize', _orientationchange, false);
		function _orientationchange() {
			scrollTo(0, 1);
			switch(window.orientation){
				case 0:		//æ¨ªå±
					bd.addClass("landscape").removeClass("portrait");
					init_pageH();					
					break;
				case 180:	//æ¨ªå±
					bd.addClass("landscape").removeClass("portrait");	
					init_pageH();
					break;

				case -90: 	//ç«–å±

					init_pageH();
					//bd.addClass("portrait").removeClass("landscape");
					if($(".m-video video")[0]!=undefined && $(".m-video video")[0].paused){
							 alert("è¯·ç«–å±æŸ¥çœ‹é¡µé¢ï¼Œæ•ˆæžœæ›´ä½³");
					}else{
							alert("è¯·ç«–å±æŸ¥çœ‹é¡µé¢ï¼Œæ•ˆæžœæ›´ä½³");
					}

					break;
				case 90: 	//ç«–å±
					init_pageH();
					bd.addClass("portrait").removeClass("landscape");
					if($(".m-video video")[0].paused)
					alert("è¯·ç«–å±æŸ¥çœ‹é¡µé¢ï¼Œæ•ˆæžœæ›´ä½³");
					break;
			}
		}
		$(window).on('load',_orientationchange);
	});

/*
**  æ’ä»¶çš„åŠ è½½
*/
	$(function(){
		/*
		**å±•ç¤ºå“æ—‹è½¬
		*/
		
		//è½®æ’­å›¾åˆå§‹åŒ–
		$('.imgSlider').each(function(){
			var urls = $(this).find('input').val();
			new slidepic(this,{urls:urls});
		});
	});

/*
** é¡µé¢å†…å®¹åŠ è½½loadingæ˜¾ç¤º
*/
	//æ˜¾ç¤º
	function loadingPageShow(){
		$('.pageLoading').show();	
	}
	//éšè—
	function loadingPageHide(){
		$('.pageLoading').hide();	
	}

/*
** é¡µé¢åŠ è½½åˆå§‹åŒ–
*/
	var input_focus = false;
	function initPage(){
		//åˆå§‹åŒ–ä¸€ä¸ªé¡µé¢
		$(".m-page").addClass("hide").eq(page_n-1).addClass("show").removeClass("hide");
		
		//åˆå§‹åŒ–åœ°å›¾
		if($(".m-page").eq(page_n-1).find(".ylMap").length>0&&!mapS){
			mapS = new ylmap.init;
		}
		
		//PCç«¯å›¾ç‰‡ç‚¹å‡»ä¸äº§ç”Ÿæ‹–æ‹½
		$(document.body).find("img").on("mousedown",function(e){
			e.preventDefault();
		})	
		
		//æŒ‰é’®ç‚¹å‡»çš„å˜åŒ–
		$('.btn-boder-color').click(function(){
			if(!$(this).hasClass("open"))	$(this).addClass('open');
			setTimeout(function(){
				$('.btn-boder-color').removeClass('open');	
			},600)
			
		})
		
		// //è¡¨å•èšç„¦æ—¶ï¼Œå–æ¶ˆåˆ‡æ¢æ•ˆæžœ
		// $('.wct_form').find('input').on('focus',function(){
		// 	changeClose();	
		// })
		
		// //è¡¨å•å¤±åŽ»èšç„¦æ—¶ï¼Œå¼€å¯åˆ‡æ¢æ•ˆæžœ
		// $('.wct_form').find('input').on('blur',function(){
		// 	changeOpen();	
		// })

		/**
	 	 *  è¡¨å•çš„æ“ä½œ
	 	 */
		$('.wct_form input').on('focus',function(){
			if($(this).attr('type')!='submit'){
				changeClose();
			}
			setTimeout(function(){input_focus = true;},500)
		})
			
		$('.wct_form input').on('blur',inputBlur);
		function inputBlur(){
			changeOpen();	
			input_focus = false;
		}
		
		window.addEventListener("resize",input_focus_out,false);
		function input_focus_out(){
			if($('.wct_form input[type!="radio"]:focus').length>=1&&input_focus){
				changeOpen();
				input_focus = false;
				$('.wct_form input').off('blur');
				$('.wct_form input').blur();
				$('.wct_form input').on('blur',inputBlur);
			}else return
		};
		
		//è§†é¢‘ç‚¹å‡»æ’­æ”¾
		$('.video-warp').on('click',function(){
			$('.m-video').find("video")[0].play();	
			$(this).hide();
			$("#car_audio")[0].pause();
		})
		
		//è§†é¢‘æŽ§åˆ¶äº‹ä»¶
		var video = $('.m-video').find("video");
		video.on('play',function(){
			$('.video-warp').hide();
			$("#car_audio")[0].pause();
		})
		video.on('pause',function(){
			$('.video-warp').show();	
		})
		video.on('ended',function(){
			$('.video-warp').show();
		})

		//è°ƒè¯•å›¾ç‰‡çš„å°ºå¯¸
		if(RegExp("iPhone").test(navigator.userAgent)||RegExp("iPod").test(navigator.userAgent)||RegExp("iPad").test(navigator.userAgent)) $('.m-page').css('height','101%');
	}(initPage());


/*******************************************************************************************************************************************************/


/**
 * loadingå›¾æ ‡è®¾ç½®
 * string type loading:å‡ºçŽ°åŠ è½½å›¾ç‰‡ï¼›end ç»“æŸåŠ è½½å›¾ç‰‡
 */
function loading(type){
	if('loading'==type){
		$('.loading').css({display:'block'});
	}else if('end'==type){
		$('.loading').css({display:'none'});
	}
}

/**
 * ç»‘å®šæ€§åˆ«é€‰æ‹©
 */
$(function(){
	$('.sex').bind('click',function(){
		var sex = $(this).attr('data-sex');
		$(this.parentNode).find('input').val(sex);
		$(this.parentNode).find('strong').removeClass('on');
		$(this).find('strong').addClass('on');
	});
});


/*
** æ˜¾ç¤ºéªŒè¯ä¿¡æ¯
*/
function showMessage(msg, error) {
	if (error) {
		$('.popup_error').html(msg);
		$(".popup_error").addClass("on");
		$(".popup_sucess").removeClass("on");
		setTimeout(function(){
			$(".popup").removeClass("on");
		},2000);
	} else {
		$(".popup_sucess").addClass("on");
		$(".popup_error").removeClass("on");
		setTimeout(function(){
			$(".popup").removeClass("on");
		},2000);
	}
}

$("#takealook").click(function(){
	$(".run-dialog").addClass('run-dialog-show');
	return false;
});
$(".run-dialog a").click(function(){
	$(".run-dialog").removeClass('run-dialog-show');
	return false;
});
// 
