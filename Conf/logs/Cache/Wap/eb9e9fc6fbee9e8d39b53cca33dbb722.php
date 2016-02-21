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
</head>
<body>	
<div>
<div class="body">
<?php if($memberNotice != ''): echo ($memberNotice); ?>
<?php else: ?>
<!--有关注商家的-->
<div class="wx_public">
	<div><img src='<?php if($logo != ''): echo ($logo); else: echo ($staticPath); ?>/tpl/static/hongbao/images/weixinheti.png<?php endif; ?>' alt=""></div>
	<div><p style="width:200px;overflow:hidden;"><a href="<?php echo ($link); ?>" style="border:0px;"><?php echo ($remind_word); ?></a></p></div>
</div>
<!--有关注商家的 end--><?php endif; ?>
	<section data-role="body" class="body">
		<div class="body_wrap">
		<div class="progress_status load_prog2">
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
			<div class="total_money" style="display: block;"><span>恭喜你，抢到红包啦！</span>赶紧找好友合体，抢红包啦~</div>
			<!--按钮样式 start-->
			<div id="find_helper" class="invite_btn" style="display: block;"><?php if(($sharetimes - $my_share_times) > 0): ?>还需<?php echo ($sharetimes-$my_share_times); ?>人合体 <?php else: ?>找人合体<?php endif; ?></div> 
			<div class="total_count"><div>已有<span><?php echo ($total); ?></span>人抢红包</div><!--a href="javascript:void(0)" class="active_rule">活动规则</a--></div>
		</div>
		<div id="common_packets"></div>
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
<div class="share">
	<img src="<?php echo ($staticPath); ?>/tpl/static/hongbao/images/fx1.png" style="width: 100%;">
</div>
<script type="text/javascript">
$(function(){
	$.get('<?php echo U("common_packets", array("id" => $action_id ,"token" => $token));?>',function(data){
		$("#common_packets").html(data);
	});
	$("#find_helper").click(function(){
		$(".share").show() ;
		
		$(".share").click(function() {
			$(this).hide() ;
		}) ;
	});
	$(".progress_status").find('li').eq(0).click(function(){
		window.location.href='<?php echo U("index", array("id" => $action_id ,"token" => $token));?>';
	});
	$(".progress_status").find('li').eq(2).click(function(){
		window.location.href='<?php echo U("my_wallet", array("id" => $action_id ,"token" => $token));?>';
	});
});

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