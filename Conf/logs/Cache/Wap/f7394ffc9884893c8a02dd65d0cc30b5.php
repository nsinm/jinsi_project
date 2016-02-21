<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<title><?php echo ($action_name); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">	
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" />
<link href="<?php echo ($staticPath); ?>/tpl/static/hongbao/css/reset.css" rel="stylesheet" type="text/css">
<link href="<?php echo ($staticPath); ?>/tpl/static/hongbao/css/main.css" rel="stylesheet" type="text/css">
<link href="<?php echo ($staticPath); ?>/tpl/static/hongbao/css/AredEnvelope.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo ($staticPath); ?>/tpl/static/seckill/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo ($staticPath); ?>/tpl/static/alert.js"></script>
<style>
#note{
	margin-left: -15%;
	width:50%;
	text-align:center;
}
</style>
</head>
<body>	
<div data-role="container" class="container index">
<div class="body">
<?php if($memberNotice != ''): echo ($memberNotice); ?>
<?php else: ?>
<!--有关注商家的-->
<div class="wx_public1">
	<div class="wx_public">
		<div><img src='<?php if($logo != ''): echo ($logo); else: echo ($staticPath); ?>/tpl/static/hongbao/images/weixinheti.png<?php endif; ?>' alt=""></div>
		<div><p style="width:200px;overflow:hidden;"><a href="<?php echo ($link); ?>" style="border:0px;"><?php echo ($remind_word); ?></a></p></div>
	</div>
</div>
<!--有关注商家的 end--><?php endif; ?>
	<section data-role="body" class="body">
		<div class="body_wrap">
		<div class="progress_status load_prog3">
			<ul>
				<li>抢红包<em></em></li>
				<li>找人合体金额变大<em></em></li>
				<li>领取<em></em></li>
			</ul>
			<span></span>
			<span class="load_line"></span>
		</div>
		<div class="money_area">
			<img src="<?php echo ($staticPath); ?>/tpl/static/hongbao/images/envelopebg.png" alt="">
			<div class="rotate_img"><img src="<?php echo ($staticPath); ?>/tpl/static/hongbao/images/light.png" alt=""></div>
			<div class="money"><?php echo ($money); ?></div>
			<div class="total_money" style="display: block;"><span>恭喜你，抢到红包啦！</span>赶紧<?php if($getway == 1 || $getway == ''): ?>领取<?php else: ?>充值<?php endif; ?>吧~</div>
			<!--按钮样式 start-->
			<div id="get_way" class="invite_btn" style="display: block;top:70%" way='<?php if($getway == 1 || $getway == ''): ?>1<?php else: ?>2<?php endif; ?>'><?php if($getway == 1 || $getway == ''): ?>领取红包<?php else: ?>会员卡充值<?php endif; ?></div>  
			<div class="total_count"><div>已有<span><?php echo ($total); ?></span>人抢红包</div><!--a href="javascript:void(0)" class="active_rule">活动规则</a--></div>
		</div>
		<div id="common_packets"></div>
		<!--幸运大神  合体进度   end-->
		<!--活动规则 start-->
		<div class="modal fade" id="active_rule_pop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="active_rule_con">
				<div class="rule_list">
					<div>活动规则</div>
					<div>活动有效期:<span>03-06 18:00至03-19 11:57</span></div>
					<div>规则说明:</div>
					<ul>
						请输入真实姓名电话，每人只能领取一次。满20即可提现。
					</ul>
				</div>
				<div id="rule_ok_btn">知道啦</div>
			</div>
		</div>
		<!--活动规则 end-->
	</section>
		<footer data-role="footer"><div id="copyright"></div></footer>
	</div>
</div>
<!--提示信息-->
 <div id="note"></div> 
<script>
$(function(){
	//加载幸运大神和我的进度公共数据
	$.get('<?php echo U("common_packets", array("id" => $action_id ,"token" => $token));?>',function(data){
		$("#common_packets").html(data);
	});
	$("#get_way").click(function(){
		var way = $(this).attr('way') ? $(this).attr('way') : 1;
		var msg = (way == 1) ? '领取' : '充值';
		var money = $(".money").html();
		var isgrabbed = <?php echo ($isgrabbed); ?>;
		if(money < 1.00 && way == 1){
			$("#note").html('红包金额超过1.00元才可领取');
			note_popup();
			return false;
		}
		if(isgrabbed == 2){
			$("#note").html('你已经'+msg+'过,请勿重复'+msg);
			note_popup();
			return false;
		}
		//ajax请求领取红包
		var url = '/index.php?g=Wap&m=Hongbao&a=get_wallet&id=<?php echo ($action_id); ?>&token=<?php echo ($token); ?>&share_key=<?php echo ($share_key); ?>&way='+way;
		 $.get(url,function(data){
			if(data == 'success'){
				if(way == 1){
					data = '领取成功,请到微信红包中查看';
				}else{
					data = '充值成功,请到个人账户查看';
				}
			}
			$("#note").html();
			$("#note").html(data);
			//弹框提示
			note_popup();
		});
	});
	//点击抢红包选项卡
	$(".progress_status").find('li').eq(0).click(function(){
		window.location.href='<?php echo U("index", array("id" => $action_id ,"token" => $token));?>';
	});
	//点击合体选项卡
	$(".progress_status").find('li').eq(1).click(function(){
		window.location.href='<?php echo U("packets", array("id" => $action_id ,"token" => $token));?>';
	});
});
function note_popup(){
	if(!$('#note').is(':visible')){ 
		$('#note').css({display:'block', top:'-200px'}).animate({top: '+200'}, 500, function(){ 
			setTimeout(note_disappear, 1500); 
		}); 
	}
}
function note_disappear(){
	$('#note').animate({top:'0'}, 500, function(){ 
		$(this).css({display:'none', top:'-200px'}); 
	}); 
}

	window.shareData = {  
		"moduleName":"Hongbao",
		"moduleID":"0",
		"imgUrl": "<?php echo ($f_siteUrl); ?>/tpl/static/hongbao/images/registerbg.jpg", 
		"timeLineLink": "<?php echo ($f_siteUrl); echo U('Hongbao/find_helper',array('token'=>$token,'id'=>$action_id,'share_key'=>$grabber_shareid));?>",
		"sendFriendLink": "<?php echo ($f_siteUrl); echo U('Hongbao/find_helper',array('token'=>$token,'id'=>$action_id,'share_key'=>$grabber_shareid));?>",
		"weiboLink": "<?php echo ($f_siteUrl); echo U('Hongbao/find_helper',array('token'=>$token,'id'=>$action_id,'share_key'=>$grabber_shareid));?>",
		"tTitle": "<?php echo ($action_name); ?>",
		"tContent": "<?php echo ($action_name); ?>",
		"fTitle": "<?php echo ($action_name); ?>",
	};
</script>
<?php echo ($shareScript); ?>
</body></html>