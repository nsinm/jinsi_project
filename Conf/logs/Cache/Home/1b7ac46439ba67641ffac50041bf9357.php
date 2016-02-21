<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>功能介绍－<?php echo C('site_title');?></title>
    </head>
    <body>
        <!--startof header-->
        <link href="<?php echo RES;?>/css/public.css" rel="stylesheet" type="text/css" />
<link href="<?php echo RES;?>/css/index2.css" rel="stylesheet" type="text/css" />
<!--<script src="<?php echo RES;?>/js/jquery-1.9.1.min.js" type="text/javascript"></script>-->
<script src="<?php echo RES;?>/js/jquery1.js" type="text/javascript"></script>
<script src="<?php echo RES;?>/js/daohang.js" type="text/javascript"></script>

<script src="<?php echo RES;?>/js/jquery-1.7.2.min.js"></script>
<script src="<?php echo RES;?>/js/ss.js"></script>
<link href="<?php echo RES;?>/css/gongneng.css" rel="stylesheet" type="text/css" />
<script src="<?php echo RES;?>/js/gongnneg.js" type="text/javascript"></script>
<link href="<?php echo RES;?>/css/gongneng.css" rel="stylesheet" type="text/css" />
<link href="<?php echo RES;?>/css/help.css" rel="stylesheet" type="text/css" />
<link href="<?php echo RES;?>/css/zifei.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo RES;?>/css/case.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo RES;?>/css/about us.css" rel="stylesheet" type="text/css" />
<!--startof header-->
<div class="header clr">
	<div class="biaotilan clr">
        <div class="shang clr">
            <div class="zhongJian clr">
                <div class="zLeft clr">欢迎使用<?php echo ($f_siteName); ?>多用户微信营销系统多用户微信营销服务平台!</div>
                <div class="zRight clr">
                    <?php if($_SESSION[uid]==false): ?><span class="ones clr"><a href="<?php echo U('Index/login');?>">注册</a></span>
                        <span class="twos clr"><a href="<?php echo U('Index/login');?>">登录</a></span>
                    <?php else: ?>
                        你好,<a href="/#" hidefocus="true"  ><span style="color:red"><?php echo (session('uname')); ?></span></a>（uid:<?php echo (session('uid')); ?>）
                        <a href="/#" onclick="Javascript:window.open('<?php echo U('System/Admin/logout');?>','_blank')" >退出</a><?php endif; ?>   
                </div>
            </div>
        </div>
    
        <div class="xia clr">
            <div class="logo clr" style="height:60px"><a href="/"><img src="<?php echo ($f_logo); ?>" /></a></div>
            <div class="daohang1 clr">
                <ul>
                    <li <?php if((ACTION_NAME == 'index') and (GROUP_NAME == 'Home')): ?>class="special"<?php endif; ?>><a href="/" >首页</a></li>
                    <li <?php if((ACTION_NAME) == "fc"): ?>class="special"<?php endif; ?>><a href="<?php echo U('Home/Index/fc');?>">功能介绍</a></li>
                    <li <?php if((ACTION_NAME) == "about"): ?>class="special"<?php endif; ?>><a href="<?php echo U('Home/Index/about');?>">关于我们</a></li>
                    <li <?php if((ACTION_NAME) == "price"): ?>class="special"<?php endif; ?>><a href="<?php echo U('Home/Index/price');?>">资费说明</a></li>
                    <li <?php if((ACTION_NAME) == "common"): ?>class="special"<?php endif; ?>><a href="<?php echo U('Home/Index/common');?>">产品案例</a></li>
                    <li <?php if((GROUP_NAME) == "User"): ?>class="special"<?php endif; ?>><a href="<?php echo U('User/Index/index');?>">管理中心</a></li>
                    <li <?php if((ACTION_NAME) == "help"): ?>class="special"<?php endif; ?>><a href="<?php echo U('Home/Index/help');?>">帮助中心</a></li>
                </ul>
            </div>
        </div>
    </div>
            <!--banner-->
            <div class="banner clr" >
                <p  style="background:url(<?php echo RES;?>/images/images/onebg_02.png) repeat-x;" class="zhutu clr">
                    <?php if($images['fc'] == null): ?><img src="<?php echo RES;?>/images/images/1.png" />
                    <?php else: ?>
                        <img src="<?php echo ($images['fc']); ?>" style="width:100%;height:300px;"><?php endif; ?>
                </p>
            </div>
            <!--end banner-->
        </div>
        <!--ENDOF header-->
        
        
        <!--start content-->
        <div class="content clr">
            <!--contLt-->
            <div class="contLt clr" id="ttl">
            	<?php if($pre == ''): ?><div class="vtitle clr"><em class="v v02 clr"></em>微信电商</div>
	                <div class="vcon clr">
	                    <ul class="vconlist clearfix clr" id="menu">
							<li class="select" id="1"><div class="">微商城</div></a></li>
							<li class="" id="2"><div class="">微购物</div></a></li>
	                    </ul>
	                </div>
	                <div class="vtitle clr"><em class="v v01 clr"></em>活动游戏</div>
	                <div class="vtitle clr"><em class="v v01 clr"></em>互动功能</div>
	                <div class="vtitle clr"><em class="v v01 clr"></em>其他</div>
            	<?php else: ?>
	                <?php if(is_array($pre)): $i = 0; $__LIST__ = $pre;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="vtitle clr" id="vtb"><em class="v v01 clr"></em><?php echo ($vo["name"]); ?></div>
		                <div class="vcon" id="<?php echo ($vo["id"]); ?>" style="display:<?php if($fun['classid'] == $vo['id']): ?>block<?php else: ?>none<?php endif; ?>;">
		                    <ul class="vconlist clearfix clr"  id="menu">
		                    	<?php if(is_array($funs)): $i = 0; $__LIST__ = $funs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vf): $mod = ($i % 2 );++$i; if($vf['classid'] == $vo['id']): ?><li class="<?php if($vf["id"] == $id): ?>select <?php elseif($vf["id"] == $fun['id']): ?>select<?php else: endif; ?>"><a href="<?php echo U('Home/Index/fc',array('id'=>$vf['id']));?>"><div class="" style="	height: 40px;line-height: 40px;font-size: 11px;"><?php echo ($vf["title"]); ?></div></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		                    </ul>
		                </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
	        </div>
	    <div class="contRt clr" id="">
	    	<?php if($pre == ''): ?><div class="contNei clr">
                    <p class="chaxun clr">微商城</p>
                    <img src="<?php echo RES;?>/images/mrtp.jpg" style="margin-bottom:10px;" />
                    <p class="ziduan clr">微信中输入“商城”会自动回复，可以设置商品分类，支持商品搜索，多种属性排序，多商品购物车结算，瀑布流展示。</p>
                </div>
	    	<?php else: ?>
            	<div class="contNei clr">
                    <p class="chaxun clr"><?php echo ($fun["title"]); ?></p>
                    <div style="line-height:180%">
                    <p class="ziduan clr" style="text-align:left;text-indent: 30px;"><?php echo ($fun["content"]); ?></p></div>
                </div><?php endif; ?>
                <!---->
                
            </div>
        </div>
        <!--endof content-->
       
        <!--startof footer-->
        <!--悬浮框-->
            <div id="leftsead">
                <ul>
                    <li>
                        <a href="javascript:void(0)" class="youhui">
                            <img src="<?php echo RES;?>/images/xufu/l02.png" width="47" height="49" class="shows" />
                            <img src="<?php echo RES;?>/images/xufu/a.png" width="57" height="49" class="hides"/>
                            <img src="<?php echo C('site_twm');?>" width="145" class="2wm" style="display:none;margin:-100px 57px 0 0"/>
                            <map name="taklhtml"><area shape="rect" coords="26,273,115,300 " href="#" /></map>
                        </a>
                    </li>
                    <li>
                        <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo C('site_qq');?>&site=qq&menu=yes" target="_blank">
                            <div class="hides" style="width:161px;display:none;" id="qq">
                                <div class="hides" id="p1">
                                    <img src="<?php echo RES;?>/images/xufu/ll04.png">
                                </div>
                                <?php if(C('site_qq') == ''): ?><div class="hides" id="p2">
                                        <span style="color:#FFF;font-size:13px">xxxxxxxxxxx</span>
                                    </div>
                                <?php else: ?>
                                    <?php if(is_array($siteqq)): $i = 0; $__LIST__ = $siteqq;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="hides" id="p2">
    	                                    <span style="color:#FFF;font-size:13px"><?php echo ($vo); ?></span>
    	                                </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                            </div>
                            <img src="<?php echo RES;?>/images/xufu/l04.png" width="47" height="49" class="shows" />
                        </a>
                    </li>
                    <li id="tel">
                        <a href="javascript:void(0)">
                            <div class="hides" style="width:161px;display:none" id="tels"/>
                                <div class="hides" id="p1">
                                    <img src="<?php echo RES;?>/images/xufu/ll05.png">
                                </div>
                                <?php if(C('site_mp') == ''): ?><div class="hides" id="p3">
                                        <span style="color:#FFF;font-size:12px">xxxxxxxxxxx</span>
                                    </div>
                                <?php else: ?>
                                    <?php if(is_array($sitemp)): $i = 0; $__LIST__ = $sitemp;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="hides" id="p3">
    	                                    <span style="color:#FFF;font-size:12px"><?php echo ($vo); ?></span>
    	                                </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                            </div>
                            <img src="<?php echo RES;?>/images/xufu/l05.png" width="47" height="49" class="shows" />
                        </a>
                    </li>
                    <li id="btn">
                        <a id="top_btn">
                        <div class="hides" style="width:161px;display:none"><img src="<?php echo RES;?>/images/xufu/ll06.png" width="161" height="49" /></div>
                        <img src="<?php echo RES;?>/images/xufu/l06.png" width="47" height="49" class="shows" />
                        </a>
                    </li>
                </ul>
            </div>
        	<!--leftsead end-->
        </div>
        <!--startof footer-->
        <div class="footer clr" style="padding-bottom:20px;">
        	<div class="last clr">
            	<P style="padding-bottom: 0px;">© <?php echo ($time); ?> <?php echo C('server_topdomain');?>   <?php echo C('ipc');?></P>
            </div>
        </div>
    <script type="text/javascript">
        //功能更新
        $(".tuPian").mouseover(function(){
          $(this).children().children(".tubiao").hide();
          $(this).children().children(".tubiao1").show();
        });
        $(".tuPian").mouseout(function(){
          $(this).children().children(".tubiao").show();
          $(this).children().children(".tubiao1").hide();
        });
        //右侧导航 - 二维码
        $(".youhui").mouseover(function(){
            $(this).children(".2wm").show();
        })
        $(".youhui").mouseout(function(){
            $(this).children(".2wm").hide();
        });
        //右侧导航 - QQ
        var ndiv = $("#qq").children().length;;
        var npx = ((ndiv-2)*49)+"px";
        $("#qq").mouseover(function(){
            $("#tel").css("margin-top",npx);
        })
        $("#qq").mouseout(function(){
            $("#tel").css("margin-top","0px");
        })
        //右侧导航 - 电话
        var ndiv = $("#tels").children().length;
        var npx1 = ((ndiv-2)*49)+"px";
        $("#tels").mouseover(function(){
            $("#btn").css("margin-top",npx1);
        })
        $("#tels").mouseout(function(){
            $("#btn").css("margin-top","0px");
        })
    </script>
        <script type="text/javascript">
        $(function(){
            //菜单隐藏展开
            var tabs_i=0
            $('.vtitle').click(function(){
                var _self = $(this);
                var j = $('.vtitle').index(_self);
                if( tabs_i == j ) ; tabs_i = j;
                $('.vtitle em').each(function(e){
                    if(e==tabs_i){
                        $('em',_self).removeClass('v01').addClass('v02');
                    }else{
                        $(this).removeClass('v02').addClass('v01');
                    }
                });
                $('.vcon').slideUp().eq(tabs_i).slideDown();
            });
        })
        </script>
    </body>
</html>