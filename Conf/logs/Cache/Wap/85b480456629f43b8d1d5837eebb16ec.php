<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="ui-mobile">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="user-scalable=no, initial-scale=1">
    <title><?php echo ($lottery["title"]); ?></title>
    <link rel="stylesheet" href="tpl/static/luckyFruit/wap/jquery.css">
    <link rel="stylesheet" href="tpl/static/luckyFruit/wap/tigerslot.css">
    
    
    <style type="text/css">
.window {
	width:290px;
	position:fixed;
	display:none;
	bottom:120px;
	left:50%;
	 z-index:9999;
	margin:-50px auto 0 -145px;
	padding:2px;
	border-radius:0.6em;
	-webkit-border-radius:0.6em;
	-moz-border-radius:0.6em;
	background-color: #ffffff;
	-webkit-box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
	-moz-box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
	-o-box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
	font:14px/1.5 Microsoft YaHei,Helvitica,Verdana,Arial,san-serif;
}
.window .title {
	
	background-color: #A3A2A1;
	line-height: 26px;
    padding: 5px 5px 5px 10px;
	color:#ffffff;
	font-size:16px;
	border-radius:0.5em 0.5em 0 0;
	-webkit-border-radius:0.5em 0.5em 0 0;
	-moz-border-radius:0.5em 0.5em 0 0;
	background-image: -webkit-gradient(linear, left top, left bottom, from( #585858 ), to( #565656 )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient(#585858, #565656); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient(#585858, #565656); /* FF3.6 */
	background-image:     -ms-linear-gradient(#585858, #565656); /* IE10 */
	background-image:      -o-linear-gradient(#585858, #565656); /* Opera 11.10+ */
	background-image:         linear-gradient(#585858, #565656);
	
}
.window .content {
	/*min-height:100px;*/
	overflow:auto;
	padding:10px;
	background: linear-gradient(#FBFBFB, #EEEEEE) repeat scroll 0 0 #FFF9DF;
    color: #222222;
    text-shadow: 0 1px 0 #FFFFFF;
	border-radius: 0 0 0.6em 0.6em;
	-webkit-border-radius: 0 0 0.6em 0.6em;
	-moz-border-radius: 0 0 0.6em 0.6em;
}
.window #txt {
	min-height:30px;font-size:16px; line-height:22px;
}
.window .txtbtn {
	
	background: #f1f1f1;
	background-image: -webkit-gradient(linear, left top, left bottom, from( #DCDCDC ), to( #f1f1f1 )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient( #ffffff , #DCDCDC ); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient( #ffffff , #DCDCDC ); /* FF3.6 */
	background-image:     -ms-linear-gradient( #ffffff , #DCDCDC ); /* IE10 */
	background-image:      -o-linear-gradient( #ffffff , #DCDCDC ); /* Opera 11.10+ */
	background-image:         linear-gradient( #ffffff , #DCDCDC );
	border: 1px solid #CCCCCC;
	border-bottom: 1px solid #B4B4B4;
	color: #555555;
	font-weight: bold;
	text-shadow: 0 1px 0 #FFFFFF;
	border-radius: 0.6em 0.6em 0.6em 0.6em;
	display: block;
	width: 100%;
	box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
	text-overflow: ellipsis;
	white-space: nowrap;
	cursor: pointer;
	text-align: windowcenter;
	font-weight: bold;
	font-size: 18px;
	padding:6px;
	margin:10px 0 0 0;
}
.window .txtbtn:visited {
	background-image: -webkit-gradient(linear, left top, left bottom, from( #ffffff ), to( #cccccc )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient( #ffffff , #cccccc ); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient( #ffffff , #cccccc ); /* FF3.6 */
	background-image:     -ms-linear-gradient( #ffffff , #cccccc ); /* IE10 */
	background-image:      -o-linear-gradient( #ffffff , #cccccc ); /* Opera 11.10+ */
	background-image:         linear-gradient( #ffffff , #cccccc );
}
.window .txtbtn:hover {
	background-image: -webkit-gradient(linear, left top, left bottom, from( #ffffff ), to( #cccccc )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient( #ffffff , #cccccc ); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient( #ffffff , #cccccc ); /* FF3.6 */
	background-image:     -ms-linear-gradient( #ffffff , #cccccc ); /* IE10 */
	background-image:      -o-linear-gradient( #ffffff , #cccccc ); /* Opera 11.10+ */
	background-image:         linear-gradient( #ffffff , #cccccc );
}
.window .txtbtn:active {
	background-image: -webkit-gradient(linear, left top, left bottom, from( #cccccc ), to( #ffffff )); /* Saf4+, Chrome */
	background-image: -webkit-linear-gradient( #cccccc , #ffffff ); /* Chrome 10+, Saf5.1+ */
	background-image:    -moz-linear-gradient( #cccccc , #ffffff ); /* FF3.6 */
	background-image:     -ms-linear-gradient( #cccccc , #ffffff ); /* IE10 */
	background-image:      -o-linear-gradient( #cccccc , #ffffff ); /* Opera 11.10+ */
	background-image:         linear-gradient( #cccccc , #ffffff );
	border: 1px solid #C9C9C9;
	border-top: 1px solid #B4B4B4;
	box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3) inset;
}

.window .title .close {
	float:right;
	
	width:26px;
	height:26px;
	display:block;	
}
.ui-body-c{
background:rgba(0,0,0,0);
}
</style>
</head>
<?php if($lottery['bg'] == ''){?>
<body style="background:url('<?php echo ($staticPath); ?>/tpl/static/luckyFruit/wap/bg.png')">
<?php }else{?>
	<?php if($lottery['bgtype'] == 0){?>
	<body style="background:url('<?php echo $lottery['bg']?>')">
	<?php }else{?>
	<body>
	<img src="<?php echo $lottery['bg']?>" style="position: fixed;top:0;left:0;width:100%;height:100%;z-index:-99">
	<?php }?>
<?php }?>
<script src="tpl/static/luckyFruit/wap/jquery-1.js"></script>
<script src="tpl/static/luckyFruit/wap/jquery.js"></script>
<script src="tpl/static/luckyFruit/wap/alert.js"></script>
<?php if($memberNotice != NULL): ?><!-- 判断条件请开发者自行判断，这里只是举例 -->
	<?php echo ($memberNotice); ?> <!-- 这里是提醒插件，固定格式，不能改名 --><?php endif; ?>
<?php if($memberNotice != ''): else: ?>
<script src="tpl/static/luckyFruit/wap/tigerslot.js"></script>
<script>
$(function () {
    var url_rndprize = '/index.php?g=Wap&m=LuckyFruit&a=getajax&token=<?php echo ($token); ?>';
    var url_getprize = '兑奖地址';
    var itemPositions = [
        0, //苹果
        100,//芒果
        200,//布林
        300,//香蕉
        400,//草莓
        500,//梨
        600,//桔子
        700,//青苹果
        800//樱桃
    ];

    //游戏开始
    var gameStart = function () {
        lightFlicker.stop();
        lightRandom.stop();
        lightCycle.start();

        //
        var marketing_id = $('.tigerslot').attr('activity_id');
        var token = $('.tigerslot').attr('data-token');
        var wechat_id = $('.tigerslot').attr('wechat_id');
        var rid = $('.tigerslot').attr('rid');
        $.post(url_rndprize, {
            id: marketing_id,
            token: token,
            wechat_id:wechat_id,
            rid:rid
        }, function (result) {
        	if(result.error){
        		alert(result.msg);
        		return;
        	}
        	if(result.success){
				$('.tigerslot').attr('rid',result.rid);
        		boxCycle.start(result.data);
        	}
        },'json');

    };

    //游戏结束
    var gameOver = function (resultData) {
        lightFlicker.start();
        lightRandom.stop();
        lightCycle.stop();

        //
        if(resultData.type == 0){
        	alert(resultData.prize_type);
        	$('.machine .gamebutton').removeClass('disabled');
        }else{
        	$('.machine .gamebutton').addClass('disabled');
			$('.machine .gamebutton').removeClass('disabled');
        	$(".sncode").text(resultData.sn);
            $("#prize").text(resultData.prize);
            $("#result").slideDown(500);            
        }
		var rest_chance = parseInt($('#rest_chance').text()) - 1;
		rest_chance = rest_chance<0 ? 0 : rest_chance;
		$('#rest_chance').text(rest_chance);		
    };

    //准备兑奖
    var getprize = function (listid, prizeid, code) {
        var tel=prompt('获奖纪录id:' + listid + ' ,奖品ID:' + prizeid + ' ,兑奖编码：' + code +'n请输入手机号码兑奖：');
        if ($.trim(tel)) {
            /*
            $.post(url_getprize, {
                listid: listid, prizeid: prizeid, code: code
            }, function (result) {
                //操作成功,
                //setPrizeList(listid);
            });
            */
          
        }
        else {
            return false;
        }
    };
    
    //
    var setPrizeList = function (listid) {
        console.log($prizelist);
        var p = $prizelist.find('li[prizelist_id="' + listid + '"]');
        p.addClass('hasGetPrize');
    };

    var $machine = $('.machine');
    var $slotBox = $('.tigerslot .box');
    var light_html = '';
    for (var i = 0; i < 21; i++) {
        light_html += '<div class="light l'+ i +'"></div>';
    }
    var $lights = $(light_html).appendTo($machine);
    var $result = $('#result').on('click', '.close-btn', function(){
    	$result.slideUp();
    	
        var submitData = {
                marketing_id: $('.tigerslot').attr('activity_id'),
                sn: $.trim($(".sncode").text()),
                wxid: $('.tigerslot').attr('data-token')
            };
        $.post('###', 
        		submitData,
        		function(data) {
					if (data.error == 1) {
						alert(data.msg);
						return;
					}        	
		            if (data.success == 1) {
		    			//window.location.reload();
		            	$('#result #prize').empty();
		            	$('#result .sncode').empty();
		            	$('.machine .gamebutton').removeClass('disabled');
		                return;
		            } else {
		
		            }
        		});   	
    });
    var $request_reward = $('#request-reward').on('click', '.close-btn', function(){
    	$request_reward.slideUp();
    })
    
    var $gameButton = $('.machine .gamebutton').tap(function () {
        var $this = $(this);
        if (!$this.hasClass('disabled')) {
            $this.addClass('disabled');
            $this.toggleClass(function (index, classname) {
                if (classname.indexOf('stop') > -1) {
                    boxCycle.stop(function (resultData) {
                        gameOver(resultData);
                        //$this.removeClass('disabled');
                    });
                } else {
                    gameStart();
                    window.setTimeout(function () {
                        $this.removeClass('disabled');
                    },1500);
                }
                return 'stop';
            });
        }
    });

    var $prizelist = $('.part.prizelist').on('tap', '.getprize', function () {
        var $this = $(this), $parent = $this.parent();
        var code = $parent.find('.code').html();
        $('#sn').val(code);
        $("#request-reward").slideToggle(500);

        return false;
    });
    
    //提交手机号码
    $('.part').on('tap', '#submit-btn', function () {
        var tel = $("#tel").val();
    	//var telreg = '/^1[3|4|5|8][0-9]d{4,8}$/';
        if (tel == '') {
            alert("请认真输入有效资料");
            return
        }
        var submitData = {
        	lid: $('.tigerslot').attr('activity_id'),
        	sncode: $(".sncode").text(),
        	tel: tel,
        	wxname: '',
        	wechaid:$('.tigerslot').attr('wechat_id'),
        	rid:$('.tigerslot').attr('rid'),
        	action: "add"
        };
        $.post('/index.php?g=Wap&m=Lottery&a=add&token=<?php echo ($token); ?>', submitData,
        		function(data) {
        			if (data.error == 1) {
        				alert(data.msg);
        				return;
        			}
            		if (data.success == true) {
            			alert('恭喜您，提交成功!');
		                setTimeout(function(){
		    				window.location.reload();
		    			},2000);
		                return;
            		}
        },'json')
        return false;
    });
    
    //提交验证码    
    $('.part').on('tap', '#ver-btn', function () {
        var ver_code = $("#password").val();
        var sn = $('#sn').val();
        if (ver_code == '') {
            alert("请输入密码");
            return;
        }
        	
        var submitData = {
            id: $('.tigerslot').attr('activity_id'),
            parssword: ver_code,
            rid: $('.tigerslot').attr('rid')
        };
        $.post('/index.php?g=Wap&m=Lottery&a=exchange&token=<?php echo ($token); ?>', submitData,
        		function(data) {		            
	        		if (data.success == true) {
		                alert('恭喜，验证成功!');
		                setTimeout(function(){
		    				window.location.reload();
		    			},2000);
		            } else {
		            	alert(data.msg);
		            }
	        	}
        ,'json')    	
    });
    
    var lightCycle = new function () {
        var currIndex = 0, maxIndex = $lights.length - 1;
        $('.l0').addClass('on');
        var tmr = new GameTimer(function () {
            $lights.each(function(){
                var $this = $(this);
                if($this.hasClass('on')){
                    currIndex++;
                    if (currIndex > maxIndex) {
                        currIndex = 0;
                    }
                    $this.removeClass('on');
                    $('.l' + currIndex).addClass('on');
                    return false;
                }
            });
        }, 100);
        this.start = function () {
            tmr.start();
        };
        this.stop = function () {
            tmr.stop();
        };
    };
    var lightRandom = new function () {
        var tmr = new GameTimer(function () {
            $lights.each(function () {
                var r = Math.random() * 1000;
                if (r < 400) {
                    $(this).addClass('on');
                } else {
                    $(this).removeClass('on');
                }
            });
        }, 100);
        this.start = function () {
            tmr.start();
        };
        this.stop = function () {
            tmr.stop();
        };
    };

    var lightFlicker = new function () {
        $lights.each(function (index) {
            if ((index >> 1) == index / 2) {
                $(this).addClass('on');
            } else {
                $(this).removeClass('on');
            }
        });
        var tmr = new GameTimer(function () {
            $lights.toggleClass('on');
        }, 100);
        this.start = function () {
            tmr.start();
        };
        this.stop = function () {
            tmr.stop();
        };
    };


    var boxCycle = new function () {

        var speed_left = 0, speed_middle = 0, speed_right = 0, maxSpeed = 25;
        var running = false, toStop = false, toStopCount = 0;
        var boxPos_left = 0, boxPos_middle = 0, boxPos_right = 0;
        var toLeftIndex = 0, toMiddleIndex = 0, toRightIndex = 0;
        var resultData;
        
        var $box = $('.tigerslot .box'), $box_left = $('.tigerslot .strip.left .box'), $box_middle = $('.tigerslot .strip.middle .box'), $box_right = $('.tigerslot .strip.right .box');

        var fn_stop_callback = null;

        var tmr = new GameTimer(function () {
            if (toStop) {
                toStopCount--;
                speed_left = 0;
                boxPos_left = -itemPositions[toLeftIndex];
                if (toStopCount < 25) {
                    speed_middle = 0;
                    boxPos_middle = -itemPositions[toMiddleIndex];
                }
                if (toStopCount < 0) {
                    speed_right = 0;
                    boxPos_right = -itemPositions[toRightIndex];
                }


            } else {
                speed_left += 1;
                speed_middle += 1;
                speed_right += 1;
                if (speed_left > maxSpeed) {
                    speed_left = maxSpeed;
                }
                if (speed_middle > maxSpeed) {
                    speed_middle = maxSpeed;
                }
                if (speed_right > maxSpeed) {
                    speed_right = maxSpeed;
                }
            }

            boxPos_left += speed_left;
            boxPos_middle += speed_middle;
            boxPos_right += speed_right;

            $box_left.css('background-position', '0 ' + boxPos_left + 'px')
            $box_middle.css('background-position', '0 ' + boxPos_middle + 'px')
            $box_right.css('background-position', '0 ' + boxPos_right + 'px')

            if (speed_left == 0 && speed_middle == 0 && speed_right == 0) {
                tmr.stop(fn_stop_callback.bind(this, resultData));
            }
            
        }, 33);

        this.start = function (data) {
            toLeftIndex = data.left; toMiddleIndex = data.middle; toRightIndex = data.right;
            running = true; toStop = false;
            resultData = data;
            tmr.start();
        };

        this.stop = function (fn) {
            fn_stop_callback = fn;
            toStop = true;
            toStopCount = 50;
        };


        this.reset = function () {
            $box_left.css('background-position', '0 ' + itemPositions[0] + 'px');
            $box_middle.css('background-position', '0 ' + itemPositions[0] + 'px');
            $box_right.css('background-position', '0 ' + itemPositions[0] + 'px');
        };
        this.reset();
    };

    //顶部滚动中奖信息
	AutoScrollHeader = (function(obj){
		$(obj).find("ul:first").animate({
			marginTop:"-15px"
		},500,function(){
			$(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
		});
	});
	if($('.scroll-reward-info li').length >1){
	   setInterval('AutoScroll(".scroll-reward-info")',4000);
	}
	
	//手机号码格式判断
	function istel(value) {
	    var regxEny = /^[0-9]*$/;
	    return regxEny.test(value);
	}
	

    lightFlicker.start();
    window.setTimeout(function () {
        lightFlicker.stop();
    }, 2000)

});
function lq(prizetype,sncode,rid){
	$('.result').hide();
	$('#result').show();
	$('#prize').text(prizetype+'等奖');
	$('.sncode').text(sncode);
	$('.tigerslot').attr('rid',rid);
}
function dh(prizetype,sncode,rid){
	$('.result').hide();
	$('#request-reward').show();
	$('#prize').text(prizetype+'等奖');
	$('.sncode').text(sncode);
	$('.tigerslot').attr('rid',rid);
}
</script><?php endif; ?>

<?PHP if($lottery['bgtype'] == 1 && $lottery['bg'] != ''){?>
<img src="<?php echo $lottery['bg']?>" style="position: fixed;top:0;left:0;width:100%;height:100%;z-index:0">
<?PHP }?>

<div class="window" id="windowcenter">
	<div id="title" class="title">消息提醒<span class="close" id="alertclose"></span></div>
	<div class="content">
	 <div id="txt"></div>
	 <input value="确定" id="windowclosebutton" name="确定" class="txtbtn" type="button">	
	</div>
</div>

        <div role="main" style="padding-top:10px;position:absolute;z-index:99;width:90%;left:5%" class="tigerslot ui-content" style="position: absolute;z-index:99" data-role="content" activity_id="<?php echo ($lottery["id"]); ?>" wechat_id="<?php echo ($lottery["wecha_id"]); ?>" data-token="<?php echo ($lottery["token"]); ?>" rid="<?php echo ($lottery["rid"]); ?>">
          <div style="height:20px;"></div>
            <div class="machine">
                <div class="strip left">
                    <div style="background-position: 0px 0px;" class="box"></div>
                    <div class="cover"></div>
                </div>
                <div class="strip middle">
                    <div style="background-position: 0px 0px;" class="box"></div>
                    <div class="cover"></div>
                </div>
                <div class="strip right">
                    <div style="background-position: 0px 0px;" class="box"></div>
                    <div class="cover"></div>
                </div>
				<?php if($memberNotice == ''): ?><a class="gamebutton" ></a>
				<?php else: ?>
				<a class="gamebutton" href="#memberNoticeBox" id="modaltrigger_notice"></a><?php endif; ?>
            <div class="light l0"></div><div class="light l1 on"></div><div class="light l2"></div><div class="light l3 on"></div><div class="light l4"></div><div class="light l5 on"></div><div class="light l6"></div><div class="light l7 on"></div><div class="light l8"></div><div class="light l9 on"></div><div class="light l10"></div><div class="light l11 on"></div><div class="light l12"></div><div class="light l13 on"></div><div class="light l14"></div><div class="light l15 on"></div><div class="light l16"></div><div class="light l17 on"></div><div class="light l18"></div><div class="light l19 on"></div><div class="light l20"></div></div>
            
            
            <div id="result" class="part result" style="display:none">
            	<a title="取消" data-wrapperels="span" data-iconshadow="true" data-shadow="true" data-corners="true" class="close-btn ui-btn ui-btn-up-c ui-shadow ui-btn-corner-all ui-btn-inline ui-btn-icon-notext" style="position:absolute;top:0;right:0;" data-role="button" data-icon="delete" data-iconpos="notext" data-theme="c" data-inline="true"><span class="ui-btn-inner"><span class="ui-btn-text">取消</span><span class="ui-icon ui-icon-delete ui-icon-shadow">&nbsp;</span></span></a>
                <div class="title">填写中奖信息</div>
                <div class="content">
					<p>您中了：<span id="prize"><?php echo ($record["prize"]); ?>等奖</span></p>
					<p><?php echo ($lottery["renamesn"]); ?>：<span class="sncode"><?php echo ($record["sn"]); ?></span></p>
					<p class="red" id="red">请仔细填写<?php echo ($lottery["renametel"]); ?>，提交后无法修改! </p>
					<p><input class="ui-input-text ui-body-c" id="tel" value="<?php echo ($fans["tel"]); ?>" placeholder="请输入您的<?php echo ($lottery["renametel"]); ?>" type="text"/>
					</p>
				
					<p>
					<input data-disabled="false" class="ui-btn-hidden" id="submit-btn" value="提交" type="button">
					</p>                  
                </div>
            </div>
			<div id="request-reward" class="part result" style="display:none">
				<a title="取消" data-wrapperels="span" data-iconshadow="true" data-shadow="true" data-corners="true" class="close-btn ui-btn ui-btn-up-c ui-shadow ui-btn-corner-all ui-btn-inline ui-btn-icon-notext" style="position:absolute;top:0;right:0;" data-role="button" data-icon="delete" data-iconpos="notext" data-theme="c" data-inline="true"><span class="ui-btn-inner"><span class="ui-btn-text">取消</span><span class="ui-icon ui-icon-delete ui-icon-shadow">&nbsp;</span></span></a>
				<div class="title">领取奖品</div>
				<div class="content">
					<p><?php echo ($lottery["renamesn"]); ?>：<span class="sncode"><?php echo ($record["sn"]); ?></span></p>
					<input id="sn" type="hidden">
					<p><input class="ui-input-text ui-body-c" id="password" placeholder="领奖时商家输入兑奖密码" type="password">
					</p>				
					<p><input data-disabled="false" class="ui-btn-hidden" id="ver-btn" value="提交" type="button">
					</p>				
				</div>
			</div>
			<?php if($record != ''): ?><div class="part">
					<div class="title">您中过的奖</div>
					<?php foreach($record as $k=>$v){?>
					<div class="content" <?php if($k != 0){?>style="border-top :1px dashed rgba(0, 0, 0, 0.3);"<?php }?> 
					<?php if($v['phone'] == ''){?>
					onclick="lq('<?php echo $v['prize'];?>','<?php echo $v['sn'];?>','<?php echo $v['id'];?>')"
					<?php }elseif($v['sendstutas'] == 0){?>
					onclick="dh('<?php echo $v['prize'];?>','<?php echo $v['sn'];?>','<?php echo $v['id'];?>')"
					<?php }?>
					>
						<p>你中了：<span class="red" ><?php echo ($v["prize"]); ?>等奖</span></p>
						<p>兑奖<?php echo ($lottery["renamesn"]); ?>：<span class="red"><?php echo ($v["sn"]); ?></span></p>
						<p>中奖时间：<span class="red"><?php echo (date("Y-m-d H:i:s",$v["time"])); ?></span></p>
						<p>状态：<span class="red">
						<?php if($v['phone'] == ''){?>
						个人信息未填写，点击填写
						<?php }elseif($v['sendstutas'] == 0){?>
						未兑奖，点击兑奖
						<?php }else{?>
						已于<?php echo (date("Y-m-d H:i:s",$v["sendtime"])); ?>兑奖
						<?php }?>
						</span></p>
					</div>
					<?php }?>
				</div><?php endif; ?>
			<?php if($lottery['end'] == 1): ?><div class="part">
                <div class="title">结束说明:</div>
                <div class="content">
				<p><?php echo ($lottery["endinfo"]); ?></p>            
                </div>
            </div><?php endif; ?>	        
            <div class="part">
                <div class="title">奖项设置:</div>
                <div class="content">              
                   <?php if ($lottery['statdate']>time()){echo '<p style="color:red">活动还没有开始 :(</p>';}?>
		 <p>每人最多允许抽奖次数:<?php echo ($lottery["canrqnums"]); ?> <?php if($lottery["daynums"] != 0): ?>，每天只能抽<?php echo ($lottery["daynums"]); ?>次<?php endif; ?> <?php if($lottery["usenums"] > 0): ?>- 已抽取 <span class="red" id="usenums"><?php echo ($lottery["usenums"]); ?></span> 次<?php endif; ?></p>
            <p>一等奖: <?php echo ($lottery["fist"]); ?>  <?php if($lottery['displayjpnums']){ ?>奖品数量: <?php echo ($lottery["fistnums"]); } ?></p>
              <?php if($lottery['second'] != ''): ?><p>二等奖: <?php echo ($lottery["second"]); ?> <?php if($lottery['displayjpnums']){ ?>奖品数量: <?php echo ($lottery["secondnums"]); } ?></p><?php endif; ?>             
            <?php if($lottery['third'] != ''): ?><p>三等奖: <?php echo ($lottery["third"]); ?> <?php if($lottery['displayjpnums']){ ?>奖品数量: <?php echo ($lottery["thirdnums"]); } ?></p><?php endif; ?>
            <?php if($lottery['four'] != ''): ?><p>四等奖: <?php echo ($lottery["four"]); ?>  <?php if($lottery['displayjpnums']){ ?>奖品数量: <?php echo ($lottery["fournums"]); } ?></p><?php endif; ?>
            <?php if($lottery['five'] != ''): ?><p>五等奖: <?php echo ($lottery["five"]); ?>  <?php if($lottery['displayjpnums']){ ?>奖品数量: <?php echo ($lottery["fivenums"]); } ?></p><?php endif; ?>
            <?php if($lottery['six'] != ''): ?><p>六等奖: <?php echo ($lottery["six"]); ?>   <?php if($lottery['displayjpnums']){ ?>奖品数量: <?php echo ($lottery["sixnums"]); } ?></p><?php endif; ?>                                  
                </div>
            </div>

            <div class="part">
                <div class="title">活动说明:</div>
                <div class="content">
				<p><?php echo ($lottery["info"]); ?></p>
        <p>活动时间:<?php echo (date("Y/m/d H:i",$lottery["statdate"])); ?>至<?php echo (date("Y/m/d H:i",$lottery["enddate"])); ?></p>		
        <p><strong><?php echo ($lottery["txt"]); ?></strong></p>            
                </div>
            </div>
			
			        	
        </div>

           


<div class="ui-loader ui-corner-all ui-body-a ui-loader-default"><span class="ui-icon ui-icon-loading"></span></div>

<script type="text/javascript">
window.shareData = {  
            "moduleName":"LuckyFruit",
            "moduleID":"<?php echo ($lottery["id"]); ?>",
            "imgUrl": "<?php echo ($lottery["starpicurl"]); ?>", 
            "sendFriendLink": "<?php echo ($f_siteUrl); echo U('LuckyFruit/index',array('token'=>$token,'id'=>$lottery['id'],'type'=>5));?>",
            "tTitle": "<?php echo ($lottery["title"]); ?>",
            "tContent": ""
};
</script>
<?php echo ($shareScript); ?>
</body></html>