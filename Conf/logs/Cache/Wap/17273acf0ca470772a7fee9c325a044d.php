<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title><?php echo ($title); ?></title>
			<meta charset="utf-8"/>
<!-- <meta name="viewport" content="initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0, width=device-width,target-densitydpi=device-dpi"/> -->
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
			<script type="text/javascript" src="./tpl/static/jquery.min.js"></script>
			<script type="text/javascript">
				var i = new Date().getTime() % 5;
					document.write('<script type="text/javascript" src="./tpl/static/applegame/createjs.js"><\/script>');

					var isDesktop = navigator['userAgent'].match(/(ipad|iphone|ipod|android|windows phone)/i) ? false : true;
					var fontunit        = isDesktop ? 20 : ((window.innerWidth>window.innerHeight?window.innerHeight:window.innerWidth)/320)*10;
					document.write('<style type="text/css">'+
						'html,body {font-size:'+(fontunit<30?fontunit:'30')+'px;}'+
						(isDesktop?'#welcome,#GameTimeLayer,#GameLayerBG,#GameScoreLayer.SHADE{position: absolute;}':
						'#welcome,#GameTimeLayer,#GameLayerBG,#GameScoreLayer.SHADE{position:absolute;}@media screen and (orientation:landscape) {#landscape {display: box; display: -webkit-box; display: -moz-box; display: -ms-flexbox;}}')+
						'</style>');
					
			</script>	
			<link rel="styleSheet" type="text/css" href="./tpl/static/applegame/applegame.css" />
			<style>
			
				#GameLayerBG {background:url('./tpl/static/applegame/game_bg.jpg')}
				.t1,.t2,.t3,.t4,.t5 { background-size:auto 100%;background-image:url(./tpl/static/applegame/loversicon.png);}
				
			</style>
	</head>
	
<body onload="init()">
	
	<script type="text/javascript">

	if (isDesktop)
		document.write('<div id="gameBody">');

	var body, blockSize, GameLayer = [], GameLayerBG, touchArea = [], GameTimeLayer;
	var transform, transitionDuration;

	function init (argument) {
	closeWelcomeLayer();
		//showWelcomeLayer();
		body = document.getElementById('gameBody') || document.body;
		body.style.height = window.innerHeight+'px';
		transform = typeof(body.style.webkitTransform) != 'undefined' ? 'webkitTransform' : (typeof(body.style.msTransform) != 'undefined'?'msTransform':'transform');
		transitionDuration = transform.replace(/ransform/g, 'ransitionDuration');

		GameTimeLayer = document.getElementById('GameTimeLayer');
		GameLayer.push( document.getElementById('GameLayer1') );
		GameLayer[0].children = GameLayer[0].querySelectorAll('div');
		GameLayer.push( document.getElementById( 'GameLayer2' ) );
		GameLayer[1].children = GameLayer[1].querySelectorAll('div');
		GameLayerBG = document.getElementById( 'GameLayerBG' );
		if( GameLayerBG.ontouchstart === null ){
			GameLayerBG.ontouchstart = gameTapEvent;
		}else{
			GameLayerBG.onmousedown = gameTapEvent;
			document.getElementById('landscape-text').innerHTML = '点我开始玩耍';
			document.getElementById('landscape').onclick = winOpen;
		}
		gameInit();
		window.addEventListener('resize', refreshSize, false);

		var rtnMsg = "true";	
				
		setTimeout(function(){
				var btn = document.getElementById('ready-btn');
				btn.className = 'btn';
				btn.innerHTML = ' 预备，上！'
				btn.style.backgroundColor = '#F00';
				btn.onclick = function(){
					closeWelcomeLayer();
				} 					
			
		}, 500);
	}
	
	function winOpen() {
		window.open(location.href+'?r='+Math.random(), 'nWin', 'height=500,width=320,toolbar=no,menubar=no,scrollbars=no');
		var opened=window.open('about:blank','_self'); opened.opener=null; opened.close();
	}
	
	var refreshSizeTime;
	
	function refreshSize(){
		clearTimeout(refreshSizeTime);
		refreshSizeTime = setTimeout(_refreshSize, 200);
	}
	function _refreshSize(){
		countBlockSize();
		for( var i=0; i<GameLayer.length; i++ ){
			var box = GameLayer[i];
			for( var j=0; j<box.children.length; j++){
				var r = box.children[j],
					rstyle = r.style;
				rstyle.left = (j%4)*blockSize+'px';
				rstyle.bottom = Math.floor(j/4)*blockSize+'px';
				rstyle.width = blockSize+'px';
				rstyle.height = blockSize+'px';
			}
		}
		var f, a;
		if( GameLayer[0].y > GameLayer[1].y ){
			f = GameLayer[0];
			a = GameLayer[1];
		}else{
			f = GameLayer[1];
			a = GameLayer[0];
		}
		var y = ((_gameBBListIndex)%10)*blockSize;
		f.y = y;
		f.style[transform] = 'translate3D(0,'+f.y+'px,0)';

		a.y = -blockSize*Math.floor(f.children.length/4)+y;
		a.style[transform] = 'translate3D(0,'+a.y+'px,0)';

	}
	function countBlockSize(){
		blockSize = body.offsetWidth/4;
		body.style.height = window.innerHeight+'px';
		GameLayerBG.style.height = window.innerHeight+'px';
		touchArea[0] = window.innerHeight-blockSize*0;
		touchArea[1] = window.innerHeight-blockSize*3;
	}
	var _gameBBList = [], _gameBBListIndex = 0, _gameOver = false, _gameStart = false, _gameTime, _gameTimeNum, _gameScore;
	function gameInit(){
        createjs.Sound.registerSound( {src:"./tpl/static/applegame/err.mp3", id:"err"} );
        createjs.Sound.registerSound( {src:"./tpl/static/applegame/end.mp3", id:"end"} );
        createjs.Sound.registerSound( {src:"./tpl/static/applegame/tap.mp3", id:"tap"} );
		gameRestart();
	}
	function gameRestart(){
		console.log('gameRestart');
		_gameBBList = [];
		_gameBBListIndex = 0;
		_gameScore = 0;
		_gameOver = false;
		_gameStart = false;
		_gameTimeNum = 2000;
		GameTimeLayer.innerHTML = creatTimeText(_gameTimeNum);
		countBlockSize();
		refreshGameLayer(GameLayer[0]);
		refreshGameLayer(GameLayer[1], 1);
	}
	function gameStart(){
		_gameStart = true;
		_gameTime = setInterval(gameTime, 10);
	}
	function gameOver(){
		_gameOver = true;
		clearInterval(_gameTime);
		setTimeout(function(){
			GameLayerBG.className = '';
			showGameScoreLayer();
		}, 1500);
	}
	function gameTime(){
		_gameTimeNum --;
		if( _gameTimeNum <= 0){
			GameTimeLayer.innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;时间到！';
			gameOver();
			GameLayerBG.className += ' flash';
			createjs.Sound.play("end");
		}else{
			GameTimeLayer.innerHTML = creatTimeText(_gameTimeNum);
		}
	}
	function creatTimeText( n ){
		var text = (100000+n+'').substr(-4,4);
		text = '&nbsp;&nbsp;'+text.substr(0,2)+"'"+text.substr(2)+"''"
		return text;
	}
	
	var _ttreg = / t{1,2}(\d+)/, _clearttClsReg = / t{1,2}\d+| bad/;
	
	function refreshGameLayer( box, loop, offset ){
		var i = Math.floor(Math.random()*1000)%4+(loop?0:4);
		for( var j=0; j<box.children.length; j++){
			var r = box.children[j],
				rstyle = r.style;
			rstyle.left = (j%4)*blockSize+'px';
			rstyle.bottom = Math.floor(j/4)*blockSize+'px';
			rstyle.width = blockSize+'px';
			rstyle.height = blockSize+'px';
			r.className = r.className.replace(_clearttClsReg, '');
			if( i == j ){
				_gameBBList.push( {cell:i%4, id:r.id} );
				r.className += ' t'+(Math.floor(Math.random()*1000)%5+1);
				r.notEmpty = true;
				i = ( Math.floor(j/4)+1)*4+Math.floor(Math.random()*1000 )%4;
			}else{
				r.notEmpty = false;
			}
		}
		if( loop ){
			box.style.webkitTransitionDuration = '0ms';
			box.style.display          = 'none';
			box.y                      = -blockSize*(Math.floor(box.children.length/4)+(offset||0))*loop;
			setTimeout(function(){
				box.style[transform] = 'translate3D(0,'+box.y+'px,0)';
				setTimeout( function(){
					box.style.display     = 'block';
				}, 100 );
			}, 200 );
		} else {
			box.y = 0;
			box.style[transform] = 'translate3D(0,'+box.y+'px,0)';
		}
		box.style[transitionDuration] = '150ms';
	}
	
	function gameLayerMoveNextRow(){
		for(var i=0; i<GameLayer.length; i++){
			var g = GameLayer[i];
			g.y += blockSize;
			if( g.y > blockSize*(Math.floor(g.children.length/4)) ){
				refreshGameLayer(g, 1, -1);
			}else{
				g.style[transform] = 'translate3D(0,'+g.y+'px,0)';
			}
		}
	}
	
	function gameTapEvent(e){
		if (_gameOver) {
			return false;
		}
		var tar = e.target;
		var y = e.clientY || e.targetTouches[0].clientY,
			x = (e.clientX || e.targetTouches[0].clientX)-body.offsetLeft,
			p = _gameBBList[_gameBBListIndex];
		if ( y > touchArea[0] || y < touchArea[1] ) {
			return false;
		}
		if( (p.id==tar.id&&tar.notEmpty) || (p.cell==0&&x<blockSize) || (p.cell==1&&x>blockSize&&x<2*blockSize) || (p.cell==2&&x>2*blockSize&&x<3*blockSize) || (p.cell==3&&x>3*blockSize) ){
			if( !_gameStart ){
				gameStart();
			}
        	createjs.Sound.play("tap");
			tar = document.getElementById(p.id);
			tar.className = tar.className.replace(_ttreg, ' tt$1');
			_gameBBListIndex++;
			_gameScore ++; 
			gameLayerMoveNextRow();
		}else if( _gameStart && !tar.notEmpty ){
			createjs.Sound.play("err");
			gameOver();
			tar.className += ' bad';
		}
		return false;
	}
	
	function createGameLayer(){
		var html = '<div id="GameLayerBG">';
		for(var i=1; i<=2; i++){
			var id = 'GameLayer'+i;
			html += '<div id="'+id+'" class="GameLayer">';
			for(var j=0; j<10; j++ ){
				for(var k=0; k<4; k++){
					html += '<div id="'+id+'-'+(k+j*4)+'" num="'+(k+j*4)+'" class="block'+(k?' bl':'')+'"></div>';
				}
			}
			html += '</div>';
		}
		html += '</div>';

		html += '<div id="GameTimeLayer"></div>';

		return html;
	}
	
	function closeWelcomeLayer(){
		var l = document.getElementById('welcome');
		l.style.display = 'none';
	}
	
	function showWelcomeLayer(){
	//	var l = document.getElementById('welcome');
		//l.style.display = 'block';
	}
	
	function showGameScoreLayer(){
	//结束后调用 _gameScore 点中的数量
		
		$.ajax({
			url: "<?php echo U('Lovers/gameOver',array('token'=>$_GET['token'],'wecha_id'=>$_GET['wecha_id'],'id'=>intval($_GET['id'])));?>",
			type: "post",
			data: {"num":_gameScore},
			success: function(data){
				var data = eval('(' + data + ')'); 
				if(data.usenums >= <?php echo ($canrqnums); ?>){
					document.getElementById('GameScoreLayer-btn').style.display = 'none';
					document.getElementById('GameScoreLayer-msg').style.display = 'block';
					
				}
				document.getElementById('GameScoreLayer-bast').innerHTML = '最佳成绩&nbsp;&nbsp;'+data.best;
			}
		});
		
		
		var l = document.getElementById('GameScoreLayer');
		var c = document.getElementById(_gameBBList[_gameBBListIndex-1].id).className.match(_ttreg)[1];
		l.className = l.className.replace(/bgc\d/, 'bgc'+c);
		document.getElementById('GameScoreLayer-text').innerHTML = shareText(_gameScore);

		
		l.style.display = 'block';
		window.shareData.tTitle = '哈哈，七夕佳节。我居然摁死了'+_gameScore+'对情侣!不服来挑战！！！'
		
	}
	
	
	function hideGameScoreLayer(){
		var l = document.getElementById('GameScoreLayer');
		l.style.display = 'none';
	}
	function replayBtn(){
		location.href="<?php echo U('Lovers/index',array('token'=>$_GET['token'],'id'=>intval($_GET['id']),'wecha_id'=>$_GET['wecha_id']));?>";
		//gameRestart();
		//hideGameScoreLayer();
	}

	function backBtn(){
		gameRestart();
		hideGameScoreLayer();

	}
	var mebtnopenurl = 'http://mp.weixin.qq.com/s?__biz=MzA5OTg3MTcyOA==&mid=200360286&idx=1&sn=d744e54a4cfe69fc749707c5ea00f4a7#rd';
	
	function shareText( score ){


		return '哈哈，七夕佳节。我居然摁死了'+score+'对情侣！<br/>';
	}
	
	function toStr(obj) {
		if ( typeof obj == 'object' ) {
			return JSON.stringify(obj);
		} else {
			return obj;
		}
		return '';
	}
	
	function cookie(name, value, time) {
		if (name) {
			if (value) {
				if (time) {
					var date = new Date();
					date.setTime(date.getTime() + 864e5 * time), time = date.toGMTString();
				}
				return document.cookie = name + "=" + escape(toStr(value)) + (time ? "; expires=" + time + (arguments[3] ? "; domain=" + arguments[3] + (arguments[4] ? "; path=" + arguments[4] + (arguments[5] ? "; secure" : "") : "") : "") : ""), !0;
			}
			return value = document.cookie.match("(?:^|;)\\s*" + name.replace(/([-.*+?^${}()|[\]\/\\])/g, "\\$1") + "=([^;]*)"), value = value && "string" == typeof value[1] ? unescape(value[1]) : !1, (/^(\{|\[).+\}|\]$/.test(value) || /^[0-9]+$/g.test(value)) && eval("value=" + value), value;
		}
		var data = {};
		value = document.cookie.replace(/\s/g, "").split(";");
		for (var i = 0; value.length > i; i++) name = value[i].split("="), name[1] && (data[name[0]] = unescape(name[1]));
		return data;
	}
	
	document.write(createGameLayer());
	
	function share(){
	//点击分享时触发
		document.getElementById('share-wx').style.display = 'block';
		document.getElementById('share-wx').onclick = function(){
			this.style.display = 'none';
		};
	}


</script>
<!--	游戏结束	-->
	<div style="display:none;background:url(./tpl/static/applegame/gameoverbg2.jpg) no-repeat center 0 #031448;background-size:100%;" id="GameScoreLayer" class="BBOX SHADE">
		<div style="padding:40% 5%;">
			<div id="GameScoreLayer-text"></div>
			<br/>
			<div id="GameScoreLayer-bast">最佳</div>
			<br/>
			<div id="GameScoreLayer-btn" class="BOX">
				<div style="width:142px;height:48px;" class="btn BOX-S" onclick="replayBtn()"><img src="./tpl/static/applegame/btn_again2.png" width="100%" /></div>&nbsp;
				<div style="width:142px;height:48px;" class="btn BOX-S" onclick="share()"><img src="./tpl/static/applegame/btn_share2.png" width="100%" /></div>&nbsp;
				
			</div>

			
			<div id="GameScoreLayer-msg" class="BOX" style="display:none"><?php echo ($aginfo); ?> &nbsp; <a href="<?php echo U('Lovers/index',array('token'=>$_GET['token'],'id'=>intval($_GET['id']),'wecha_id'=>$_GET['wecha_id']));?>" style="color:blue;text-decoration:none;">查看排名</a></div>
			<br/>
		</div>
	</div>
	
	
	
<!--	游戏开始前界面	-->
	<div id="welcome" class="SHADE BOX-M">
		<div class="welcome-bg FILL"></div>
	<div class="FILL BOX-M" style="position:absolute;top:0;left:0;right:0;bottom:0;z-index:5;">
			<div style="margin:0 8% 0 9%;">
				<br/><br/>
				<div style="font-size:2.6em; color:#FEF002;"></div><br/>
				<div style="font-size:2.2em; color:#fff; line-height:1.5em;"><br/></div><br/><br/>
				<div id="ready-btn" class="btn loading" style="display:inline-block; margin:0 auto; width:8em; height:1.7em; line-height:1.7em; font-size:2.2em; color:#fff;"></div>
			<br/><br/><br/>
			
			<div style="font-size:1.6em;"></div>
				<br/>
	
			<div style="font-size:1.4em;"></div></br>
			
			</div>
		</div>
	</div>

	
	<!--	横屏提示	-->
	<div id="landscape" class="SHADE BOX-M" style="background:rgba(0,0,0,.9);">
		<div class="welcome-bg FILL"></div>
		<div id="landscape-text" style="color:#fff;font-size:3em;">请竖屏玩耍</div>
	</div>

	<!--	分享提示	-->
	<div id="share-wx"><p style="text-align: right; padding-left: 10px;"><img src="./tpl/static/applegame/2000.png" id="share-wx-img" style="max-width: 280px; padding-right: 25px;"></p></div>
	
	
	
<script type="text/javascript">
	if (isDesktop)
		document.write('</div>');	

window.shareData = {  
            "moduleName":"Lovers",
            "moduleID":"<?php echo (intval($_GET['id'])); ?>",
            "imgUrl": "<?php echo ($linfo["starpicurl"]); ?>", 
            "timeLineLink": "<?php echo ($f_siteUrl); echo U('Lovers/index',array('token'=>$_GET['token'],'id'=>intval($_GET['id'])));?>",
            "sendFriendLink": "<?php echo ($f_siteUrl); echo U('Lovers/index',array('token'=>$_GET['token'],'id'=>intval($_GET['id'])));?>",
            "weiboLink": "<?php echo ($f_siteUrl); echo U('Lovers/index',array('token'=>$_GET['token'],'id'=>intval($_GET['id'])));?>",
            "tTitle": "<?php echo ($linfo["title"]); ?>",
            "tContent": "<?php echo ($linfo["info"]); ?>"
        };
</script>
<?php echo ($shareScript); ?>
</body>
</html>