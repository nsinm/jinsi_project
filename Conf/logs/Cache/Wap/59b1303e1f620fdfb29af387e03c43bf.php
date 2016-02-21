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
		<?php echo ($memberNotice); ?>
	<section data-role="body" class="body">
		<div class="body_wrap">
		<div class="progress_status load_prog1">
			<ul>
				<li>抢红包<em></em></li>
				<li>找人合体金额变大<em></em></li>
				<li>领取<em></em></li>
			</ul>
			<span></span>
			<span class="load_line"></span>
		</div>
		<!--注册信息填写  start-->
		<div id="register">
			<div id="combine_btn" style="bottom: 23%;" onclick="packets_grab()">抢红包</div>
			<div class="total_count"><div>已有<span><?php echo ($total); ?></span>人抢红包</div><a href="javascript:void(0)" class="active_rule" onclick="show_rules()">活动规则</a></div>
		</div>
		<div class="info" style="display:none">
			<div id="combine_btn" style="bottom: 23%;" onclick="packets_grab_1()">抢红包</div>
			<div class="total_count"><div>已有<span><?php echo ($total); ?></span>人抢红包</div><a href="javascript:void(0)" class="active_rule" onclick="show_rules()">活动规则</a></div>
		</div>
		<div id="common_packets"></div>
		<!--活动规则 start-->
		<div class="rules" style="display:none">
			<div class="active_rule_con">
				<div class="rule_list">
					<div>活动规则</div>
					<div>活动有效期:<span><?php echo (date("m-d H:i",$start_time)); ?>至<?php echo (date("m-d H:i",$end_time)); ?></span></div>
					<div>规则说明:</div>
					<ul><?php echo ($action_desc); ?></ul>
				</div>
				<div id="rule_ok_btn" onclick="disappear_rules()">知道啦</div>
			</div>
		</div>
		<!--活动规则 end-->
	</section>
		<footer data-role="footer"><div id="copyright"></div></footer>
	</div>
</div>
<script>
//抢红包
function packets_grab(){
	window.location.href='<?php echo U("grab_packet", array("id" => $action_id ,"token" => $token));?>';
}
function packets_grab_1(){
	window.location.href='<?php echo U("grab_packet", array("id" => $action_id ,"token" => $token));?>';
}
$(function(){
	$.get('<?php echo U("common_packets", array("id" => $action_id ,"token" => $token));?>',function(data){
		$("#common_packets").html(data);
	});
	var isgrabbed = "<?php echo ($isgrabbed); ?>";
	$(".progress_status").find('li').eq(1).click(function(){
		if(isgrabbed == 0){
			alert('你还没抢到红包');
			return false;
		}
		window.location.href='<?php echo U("packets", array("id" => $action_id ,"token" => $token));?>';
	});
	$(".progress_status").find('li').eq(2).click(function(){
		if(isgrabbed == 0){
			alert('你还没抢到红包');
			return false;
		}
		window.location.href='<?php echo U("my_wallet", array("id" => $action_id ,"token" => $token));?>';
	});
	//抢红包
/*	$("#combine_btn").click(function(){
		window.location.href='<?php echo U("grab_packet", array("id" => $action_id ,"token" => $token));?>';
	});*/
});
function show_rules(){
	$("#register").html($('.rules').html());
}
function disappear_rules(){
	$("#register").html($('.info').html());
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