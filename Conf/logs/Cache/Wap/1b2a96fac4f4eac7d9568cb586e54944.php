<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0067)http://sale.suning.com/images/advertise/001/hbgz30/active-rule.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta content="telephone=no" name="format-detection">
	<title><?php echo ($packet_info["title"]); ?></title>
    <link rel="stylesheet" href="<?php echo ($staticPath); ?>/tpl/static/packet/css/base.css">
    <link rel="stylesheet" href="<?php echo ($staticPath); ?>/tpl/static/packet/css/redbg.css">
    <style>
.activeRule-content{min-height:350px;}
.activeRule-top:before {content:'我的红包';}
.activeRule-content .table{width: 100%; text-align: center; color: #ff6741;}
.activeRule-content .table th{margin:10px 0;color:#ff6741;}
.activeRule-content .table td a{color:#31a8e7;}
    </style>
</head>
<body >
    <section class="pdlayout" >
            <div class="activeRule-top pr ">
                <img src="<?php echo ($staticPath); ?>/tpl/static/packet/images/active_bg.png" width="100%" height="59">
            </div>
            <!--
            <div class="activeRule-content  pdlayout pr">
       			<?php echo (htmlspecialchars_decode($packet_info["info"])); ?>
            </div>
            -->
            <div class="activeRule-content  pdlayout pr">
            	<table class="table" cellspacing="0" cellpadding="0" border="0">
					<thead>
						<th>红包名称</th>
						<th>中奖时间</th>
						<th>红包状态</th>
						<th>操作</th>
					</thead>
					<tbody>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr style="height:35px;">
							<td style="height:35px;width:30%"><?php echo ($list["prize_name"]); ?></td>
							<td style="height:35px;width:20%"><?php echo (date("m-d",$list["add_time"])); ?></td>
							<td style="height:35px;width:20%"> 

								<?php if($list["is_reward"] == '2'): ?>已兑换
								<?php elseif($list["is_reward"] == '1'): ?>
									等待处理
								<?php else: ?>	
									未领取<?php endif; ?>
							 </td>
							<td style="height:35px;width:30%">
								<?php if($list["is_reward"] == '2'): ?>兑奖已完成
								<?php elseif($list["is_reward"] == '1'): ?>
									审核中....
								<?php else: ?>	
									<a href="<?php echo U('Red_packet/reward_forms',array('token'=>$token,'wecha_id'=>$wecha_id,'rid'=>$list['id'],'id'=>$packet_info['id']));?>">兑换红包</a><?php endif; ?>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						<!-- <tr><td colspan="4"><?php echo ($page); ?></td></tr> -->
					</tbody>
				</table>
             </div>
    </section>
<script type="text/javascript">
window.shareData = {  
            "moduleName":"Red_packet",
            "moduleID":"0",
            "imgUrl": "<?php echo ($packet_info["msg_pic"]); ?>", 
            "timeLineLink": "<?php echo C('site_url') . U('Red_packet/index',array('token' => $token,'id'=>$packet_info['id']));?>",
            "sendFriendLink": "<?php echo C('site_url') . U('Red_packet/index',array('token' => $token,'id'=>$packet_info['id']));?>",
            "weiboLink": "<?php echo C('site_url') . U('Red_packet/index',array('token' => $token,'id'=>$packet_info['id']));?>",
            "tTitle": "<?php echo ($packet_info["title"]); ?>",
            "tContent": "<?php echo ($packet_info["title"]); ?>"
        };
</script>
<?php echo ($shareScript); ?>	   
</body>
</html>