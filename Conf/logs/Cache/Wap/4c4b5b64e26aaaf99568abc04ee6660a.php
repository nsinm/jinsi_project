<?php if (!defined('THINK_PATH')) exit();?><div class="radius_box"><img src="<?php echo ($staticPath); ?>/tpl/static/hongbao/images/radius_bg.jpg" alt=""></div>
<!--幸运大神  合体进度   start-->
<div class="getList">
	<div id="Tab">
		<ul>
			<li class="current">幸运大神</li>
			<li>我的进度</li>
		</ul>
	</div>
	<div class="swiper-container swiper1" style="height: auto;min-height:350px; cursor: -webkit-grab;">
		<div>
			<div class="luckguys swiper-slide swiper-slide-visible swiper-slide-active" style="width: 320px; height: auto;min-height:350px;">
				<div class="luck_con swipe_con">
				<?php if($lucky_guys != ''): if(is_array($lucky_guys)): $i = 0; $__LIST__ = $lucky_guys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="luck-manito"><ul><li><img src="<?php echo ($vo["grabber_headimgurl"]); ?>"></li><li><div><span class="nickname"><?php echo ($vo["grabber_nickname"]); ?></span><span class="date"><?php echo (date("m-d H:i",$vo["grabber_time"])); ?></span></div><!--div><p><?php echo ($vo["share_content"]); ?></p></div--></li><li><?php echo ($vo["money"]); ?>元</li></ul></div><?php endforeach; endif; else: echo "" ;endif; ?>	
					<?php else: ?>
					<div class="fit-plan_end">
					<img src="<?php echo ($staticPath); ?>/tpl/static/hongbao/images/cry.png" alt="">
					<div>幸运大神还没降临,赶紧抢红包吧~</div>
					</div><?php endif; ?>
				</div>
			</div>
			
			<div class="my_lucky swiper-slide swiper-slide-visible swiper-slide-active" style="width: 320px; height: auto;min-height:350px" style="display:none">
				<div class="luck_con swipe_con">
				<?php if($my_packets != '' and $my_packets["isgrabbed"] != 0): ?><div class="luck-manito"><ul><li><img src="<?php echo ($my_packets["grabber_headimgurl"]); ?>"></li><li><p>恭喜你，抢到了红包</p></li><li>+<?php echo ($my_money); ?>元</li></ul></div><?php endif; ?>
				<?php if($my_share != ''): if(is_array($my_share)): $i = 0; $__LIST__ = $my_share;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$share): $mod = ($i % 2 );++$i;?><div class="luck-manito"><ul><li><img src="<?php echo ($share["share_pic"]); ?>"></li><li><p>恭喜你，获得了“<?php echo ($share["share_nickname"]); ?>”送出的红包</p></li><li>+<?php echo ($share["add_money"]); ?>元</li></ul></div><?php endforeach; endif; else: echo "" ;endif; ?>
					<?php else: ?>	
					<div class="fit-plan_end">
					<img src="<?php echo ($staticpath); ?>/tpl/static/hongbao/images/cry.png" alt="">
					<div>您还没有合体过哦~</div>
					</div><?php endif; ?>	
				</div>
			</div>
	</div> 
	</div>
</div>
<script>
$(function(){
	$(".my_lucky").hide();
	$(".luckguys").show();
	$("#Tab").find("li").eq(1).click(function(){
		$(".luckguys").hide();
		$(".my_lucky").show();
		$(this).addClass('current');
		$(this).prev().removeClass('current');
	});
	
	$("#Tab").find("li").eq(0).click(function(){
		$(".my_lucky").hide();
		$(".luckguys").show();
		$(this).addClass('current');
		$(this).next().removeClass('current');
	});
});
</script>