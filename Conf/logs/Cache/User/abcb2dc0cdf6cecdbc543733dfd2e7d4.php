<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> <?php echo ($f_siteTitle); ?> <?php echo ($f_siteName); ?></title>
<meta name="keywords" content="<?php echo ($f_metaKeyword); ?>" />
<meta name="description" content="<?php echo ($f_metaDes); ?>" />
<meta http-equiv="MSThemeCompatible" content="Yes" />
<script>var SITEURL='';</script>
<link rel="stylesheet" type="text/css" href="./tpl/User/default/common/css/style_2_common.css?BPm" />
<script src="<?php echo RES;?>/js/common.js" type="text/javascript"></script>
</head>
<body id="nv_member" class="pg_CURMODULE">
<div class="topbg">
<div class="top">
<div class="toplink">
<style>
<?php if($usertplid == 1): ?>.topbg{background:url(<?php echo ($staticPath); ?>/tpl/static/newskin/images/top.gif) repeat-x; height:101px; /*box-shadow:0 0 10px #000;-moz-box-shadow:0 0 10px #000;-webkit-box-shadow:0 0 10px #000;*/}
.top {
    margin: 0px auto; width: 988px; height: 101px;
}

.top .toplink{ height:30px; line-height:27px; color:#999; font-size:12px;}
.top .toplink .welcome{ float:left;}
.top .toplink .memberinfo{ float:right;}
.top .toplink .memberinfo a{ color:#999;}
.top .toplink .memberinfo a:hover{ color:#F90}
.top .toplink .memberinfo a.green{ background:none; color:#0C0}

.top .logo {width: 990px; color: #333; height:70px; font-size:16px;}
.top h1{ font-size:25px;float:left; width:230px; margin:0; padding:0; margin-top:6px; }
.top .navr {WIDTH:750px; float:right; overflow:hidden;}
.top .navr ul{ width:850px;}
.navr li {text-align:center; float: left; height:70px; font-size:1em; width:103px; margin-right:5px;}
.navr li a {width:103px; line-height:70px; float: left; height:100%; color: #333; font-size: 1em; text-decoration:none;}
.navr li a:hover { background:#ebf3e4;}
.navr li.menuon {background:#ebf3e4; display:block; width:103px;}
.navr li.menuon a{color:#333;}
.navr li.menuon a:hover{color:#333;}
.banner{height:200px; text-align:center; border-bottom:2px solid #ddd;}
.hbanner{ background: url(img/h2003070126.jpg) center no-repeat #B4B4B4;}
.gbanner{ background: url(img/h2003070127.jpg) center no-repeat #264C79;}
.jbanner{ background: url(img/h2003070128.jpg) center no-repeat #E2EAD5;}
.dbanner{ background: url(img/h2003070129.jpg) center no-repeat #009ADA;}
.nbanner{ background: url(img/h2003070130.jpg) center no-repeat #ffca22;}
<?php else: ?>

.topbg{BACKGROUND-IMAGE: url(<?php echo ($staticPath); echo ltrim(RES,'.');?>/images/top.png);BACKGROUND-REPEAT: repeat-x; height:124px; box-shadow:0 0 10px #000;-moz-box-shadow:0 0 10px #000;-webkit-box-shadow:0 0 10px #000;}
.top {
	MARGIN: 0px auto; WIDTH: 988px; HEIGHT: 124px;
}

.top .toplink{ height:27px; line-height:27px; color:#999; font-size:12px;}
.top .toplink .welcome{ float:left;}
.top .toplink .memberinfo{ float:right;}
.top .toplink .memberinfo a{ color:#999;}
.top .toplink .memberinfo a:hover{ color:#F90}
.top .toplink .memberinfo a.green{ background:none; color:#0C0}

.top .logo {WIDTH: 990px;COLOR: #333; height:70px;  FONT-SIZE:16px; PADDING-TOP:25px}
.top h1{ font-size:25px; margin-top:20px; float:left; width:230px; margin:0; padding:0;}
.top .navr {WIDTH:750px; float:right; overflow:hidden; margin-top:10px;}
.top .navr ul{ width:850px;}
.navr LI {TEXT-ALIGN:center;FLOAT: left;HEIGHT:32px;FONT-SIZE:1em;width:103px; margin-right:5px;}
.navr LI A {width:103px;TEXT-ALIGN:center; LINE-HEIGHT:30px; FLOAT: left;HEIGHT:32px;COLOR: #333; FONT-SIZE: 1em;TEXT-DECORATION: none
}
.navr LI A:hover {BACKGROUND: url(<?php echo ($staticPath); echo ltrim(RES,'.');?>/images/navhover.gif) center no-repeat;color:#009900;}
.navr LI.menuon {BACKGROUND: url(<?php echo ($staticPath); echo ltrim(RES,'.');?>/images/navon.gif) center no-repeat; display:block;width:103px;HEIGHT:32px;}
.navr LI.menuon a{color:#FFF;}
.navr LI.menuon a:hover{BACKGROUND: url(img/navon.gif) center no-repeat;}
.banner{height:200px; text-align:center; border-bottom:2px solid #ddd;}
.hbanner{ background: url(img/h2003070126.jpg) center no-repeat #B4B4B4;}
.gbanner{ background: url(img/h2003070127.jpg) center no-repeat #264C79;}
.jbanner{ background: url(img/h2003070128.jpg) center no-repeat #E2EAD5;}
.dbanner{ background: url(img/h2003070129.jpg) center no-repeat #009ADA;}
.nbanner{ background: url(img/h2003070130.jpg) center no-repeat #ffca22;}<?php endif; ?>
</style>
<div class="welcome">欢迎使用多用户微信营销服务平台!</div>
    <div class="memberinfo"  id="destoon_member">	
		<?php if($_SESSION[uid]==false): ?><a href="<?php echo U('Index/login');?>">登录</a>&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="<?php echo U('Index/login');?>">注册</a>
			<?php else: ?>
			你好,<a href="/#" hidefocus="true"  ><span style="color:red"><?php echo (session('uname')); ?></span></a>（uid:<?php echo (session('uid')); ?>）
			<a href="/#" onclick="Javascript:window.open('<?php echo U('System/Admin/logout');?>','_blank')" >退出</a><?php endif; ?>	
	</div>
</div>
    <div class="logo">
        <div style="float:left"></div>
            <h1><a href="/" title="多用户微信营销服务平台"><img src="<?php echo ($f_logo); ?>" height="55" /></a></h1>
            <div class="navr">
        <ul id="topMenu">           
            <li <?php if((ACTION_NAME == 'index') and (GROUP_NAME == 'Home')): ?>class="menuon"<?php endif; ?> ><a href="/">首页</a></li>
                <li <?php if((ACTION_NAME) == "fc"): ?>class="menuon"<?php endif; ?>><a href="<?php echo U('Home/Index/fc');?>">功能介绍</a></li>
                <li <?php if((ACTION_NAME) == "about"): ?>class="menuon"<?php endif; ?>><a href="<?php echo U('Home/Index/about');?>">关于我们</a></li>
                <li <?php if((ACTION_NAME) == "price"): ?>class="menuon"<?php endif; ?>><a href="<?php echo U('Home/Index/price');?>">资费说明</a></li>
                <li <?php if((ACTION_NAME) == "common"): ?>class="menuon"<?php endif; ?>><a href="<?php echo U('Home/Index/common');?>">微信导航</a></li>
                <li <?php if((GROUP_NAME) == "User"): ?>class="menuon"<?php endif; ?>><a href="<?php echo U('User/Index/index');?>">管理中心</a></li>
                <li <?php if((ACTION_NAME) == "help"): ?>class="menuon"<?php endif; ?>><a href="<?php echo U('Home/Index/help');?>">帮助中心</a></li>
            
            </ul>
        </div>
        </div>
    </div>
</div>
<div id="aaa"></div>


<div id="mu" class="cl"></div>
</div>
</div>
<div id="aaa"></div>

<div id="wp" class="wp">
    <?php if($usertplid == 0): ?><link href="./tpl/User/default/common/css/style.css?id=103" rel="stylesheet" type="text/css" />
  <?php else: ?>
    <link href="./tpl/User/default/common/css/style-<?php echo ($usertplid); ?>.css?id=103" rel="stylesheet" type="text/css" /><?php endif; ?>
 <div class="contentmanage">
    <div class="developer">
       <div class="appTitle normalTitle">
        <h2>管理平台</h2>
        <div class="accountInfo">
        
        </div>
        <div class="clr"></div>
      </div>
      <div class="tableContent">
        <!--左侧功能菜单-->
        <div class="sideBar">
          <div class="catalogList">
            <ul class="<?php if($usertplid != 0): ?>newskin<?php endif; ?>">
            	<li class="subCatalogList"> <a class="secnav_1" href="<?php echo U('Index/useredit');?>">修改密码</a> </li>
				<li class=" subCatalogList "> <a class="secnav_2" href="<?php echo U('Index/index');?>">我的公众号</a></li>
				<li class=" subCatalogList "> <a class="secnav_3" href="<?php if(($hasWeixin) == "0"): ?>javascript:alert('您不可以使用此功能，请联系您的网站管理员处理');<?php else: echo U('Index/add'); endif; ?>">添加公众号</a> </li>
				<li class=" subCatalogList "> <a class="secnav_4" href="<?php echo U('Alipay/index');?>">会员充值</a> </li>
				<li class=" subCatalogList "> <a class="secnav_6" href="<?php echo U('Sms/index');?>">短信管理</a> </li>
				<?php if($thisUser['invitecode']): ?><li class=" subCatalogList "> <a class="secnav_7" href="<?php echo U('Index/invite');?>">邀请朋友</a> </li><?php endif; ?>
        <li class=" subCatalogList "> <a class="secnav_8" href="<?php echo U('Index/switchTpl');?>">切换模板</a> </li>
        <li class=" subCatalogList "> <a class="secnav_9" href="<?php if(C('open_biz') == 0): ?>javascript:alert('请联系站长在后台开启企业号');<?php else: echo U('Index/add',array('biz'=>1)); endif; ?>">添加企业号</a> </li>
            </ul>
          </div>
        </div>

<script src="<?php echo STATICS;?>/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="<?php echo ($staticPath); ?>/tpl/static/artDialog/jquery.artDialog.js?skin=default"></script>
<script src="<?php echo ($staticPath); ?>/tpl/static/artDialog/plugins/iframeTools.js"></script>
<script src="<?php echo ($staticPath); ?>/tpl/static/upyun.js"></script>
<script>
$(function(){
	$("select").change(function(){
		var appid = $("input[name='appid']").val();
		var secret = $("input[name='appsecret']").val();
		var winxintype = $(this).val();
		/*if(winxintype == 4){
			$.ajax({
				type:"POST",
				url:"<?php echo U('User/Index/dyajax');?>",
				dataType:"json",
				data:{
					appid:appid,
					secret:secret
				},
				success:function(data){
					if(data.error == 2){
						alert('您填的appid和appsecret未认证！');
						$("input[name='appid']").val('');
						$("input[name='appsecret']").val('');
						$("select").val(1);
					}else if(data.error == 1){
						alert('您填的appid和appsecret不正确！');
						$("input[name='appid']").val('');
						$("input[name='appsecret']").val('');
						$("select").val(1);
					}
				}
			});
		}else */
		if(winxintype == 3){
			$.ajax({
				type:"POST",
				url:"<?php echo U('User/Index/fwajax');?>",
				dataType:"json",
				data:{
					appid:appid,
					secret:secret
				},
				success:function(data){
					if(data.error == 2){
						alert('您填的appid和appsecret不是认证后的服务号！');
						$("input[name='appid']").val('');
						$("input[name='appsecret']").val('');
						$("select").val(1);
					}else if(data.error == 1){
						alert('您填的appid和appsecret不正确！');
						$("input[name='appid']").val('');
						$("input[name='appsecret']").val('');
						$("select").val(1);
					}
				}
			});
		}
		/**/
	});
})
</script>
<div class="content">
          <div class="cLineB">
      <h4>
      <?php if($_GET['biz'] == 1): ?>添加企业号
      <?php elseif($_GET['goldbuy'] == 1): ?>
        添加支付宝服务窗
      <?php else: ?>
        添加微信公众号<?php endif; ?>
      </h4>
      </div>
          <form method="post" action="<?php echo U('User/Index/insert');?>" enctype="multipart/form-data">
          <div class="msgWrap">
            <table class="userinfoArea" border="0" cellspacing="0" cellpadding="0" width="100%">
              <thead>
        <?php if($_GET['biz'] == 1): ?><tr>
                  <th><span class="red">*</span>企业号名称：</th>
                  <td><input type="text" required="" class="px" name="wxname" value="" tabindex="1" size="25"><input type="hidden" name="ifbiz" value="<?php echo $_GET['biz'];?>">
                  </td>
                </tr>
        <?php elseif($_GET['goldbuy'] == 1): ?>
          <tr>
            <th>服务窗名称:</th>
            <td>
              <input type="text" required="" class="px" name="wxname" value="" tabindex="1" size="25">  
            </td>
          </tr>
          <tr>
            <th>AppID（服务窗）:</th>
            <td>
              <input type="text" name="fuwuappid" class="px" size="25" />　填写后可以在支付宝服务窗使用
              <input type="hidden" name="goldbuy" value="<?php echo $_GET['goldbuy'];?>">
            </td>
          </tr>
        <?php else: ?>
          <tr>
            <th><span class="red">*</span>公众号名称：</th>
            <td><input type="text" required="" class="px" name="wxname" value="" tabindex="1" size="25">
            </td>
          </tr><?php endif; ?>
              </thead>
              <tbody>
                <?php if($_GET['biz'] == 1): ?><input type="hidden" name="biz" value="1" />  
        <?php elseif($_GET['goldbuy'] == 1): ?> 
          <input type="hidden" name="goldbuy" value="1" /> 
        <?php else: ?>
                <tr>
                  <th><span class="red">*</span>公众号原始id：</th>
                  <td><input type="text" required="" name="wxid" value="" onmouseup="this.value=this.value.replace('_430','')" class="px" tabindex="1" size="25">　<span class="red">请认真填写，错了不能修改。</span>比如：gh_423dwjkeww3 <a href="/tpl/static/getoid.htm" target="_blank"><img src="<?php echo RES;?>/images/help.png" class="vm helpimg" title="帮助"></a></td>
                </tr>
                <tr>
                  <th><span class="red">*</span>微信号：</th>
                  <td><input type="text" required="" name="weixin" value="" class="px" tabindex="1" size="25">　比如：lentu123 </td>
                </tr>
                <tr>
                  <th><span class="red">*</span>AppID（公众号）：</th>
                  <td><input type="text" name="appid" value="" class="px" tabindex="1" size="25">　用于自定义菜单等高级功能，必填 </td>
                </tr>
                <tr>
                  <th><span class="red">*</span>AppSecret：</th>
                  <td><input type="text" name="appsecret" value="" class="px" tabindex="1" size="25">　用于自定义菜单等高级功能，必填 </td>
                </tr>
                <tr>
					<th><span class="red">*</span>二维码：</th>
					<td>
						<input type="text" id="qr" required="" class="px" name="qr" value="" tabindex="1" size="25">
						<a href="###" onclick="upyunPicUpload('qr',500,500,'admin')" class="a_upload">上传</a>
						<a href="###" onclick="viewImg('qr')">预览</a>
					</td>
				</tr>
                <tr>
                  <th><span class="red"></span>微信号类型：</th>
                  <td><select id="winxintype" name="winxintype">                  
                  <option value="1">订阅号</option>
                  <option value="2">服务号</option>
                  <option value="3">认证服务号</option>
                  <option value="4">认证订阅号</option>
                  </select>　认证服务号是指每年向微信官方交300元认证费的公众号 </td>
                </tr>
                <tr>
                    <td colspan="2"><br /></td>
                </tr><?php endif; ?>
                <tr style="display:none">
                  <th><span class="red">*</span>头像地址（url）:</th>
                  <td><input class="px" name="headerpic" value="<?php echo RES;?>/images/portrait.jpg" size="60">请填写图片外链地址 <a onclick="alert('请填写以jpg,png,gif,bmp等后缀的图文')" target="_blank"><img src="<?php echo RES;?>/images/help.png" class="vm helpimg" title="帮助"></a></td>
                </tr>
                 <tr style="display:none">
                  <th><span class="red">*</span>TOKEN</th>
                  <td><input type="text" name="token" value="<?php echo ($tokenvalue); ?>" class="px" tabindex="1" size="40">(填写你的公众号)例：pigcmsweixin,请勿填写文,或者其它特殊字符，此处token和腾讯平台必须一致!</td>
                </tr>
                
                <tr style="display:none">
                  <th><span class="red">*</span>地区</th>
                  <td>
                  <input type="text" class="px" id="province" value="p" name="province" tabindex="1" size="20"> 省  <input id="city" value="c" type="text" name="city" class="px" tabindex="1" value="c" size="20"> 市
               （此处关联公交等本地化查询）
                  </td>
                </tr>
                <tr style="display:none">
                  <th><span class="red">*</span>公众号邮箱：</th>
                  <td><input type="text" required="" class="px" tabindex="1" value="<?php echo ($email); ?>" name="qq" size="25"></td>
                </tr>
                 <tr style="display:none">
                  <th><span class="red">*</span>粉丝数：</th>
                  <td><input type="text" required="" name="wxfans" value="0" class="px" tabindex="1" size="25"></td>
                </tr>
             
                <tr style="display:none">
                  <th>类型：</th>
                  <td><select id="type" name="type_name">                  
                  <option value="1,情感">情感</option>
                  <option value="2,数码">数码</option>
                  <option value="3,娱乐">娱乐</option>
                  <option value="4,IT">IT</option>
                  <option value="5,数码">数码</option>
                  <option value="6,购物">购物</option>
                  <option value="7,生活">生活</option>
                  <option value="8,服务" selected>服务</option>
                  </select></td>
                </tr>
				
                <tr>
                  <th></th>
                  <td><button type="submit" class="btnGreen" id="saveSetting">保存</button></td>
                </tr>
              </tbody>
            </table>
            
          </div>
          </form>
        </div>
        
        <div class="clr"></div>
      </div>
    </div>
  </div>
  <!--底部-->
    </div>
</div>
</div>
</div>

<style>
.IndexFoot {
	BACKGROUND-COLOR: #333; WIDTH: 100%; HEIGHT: 39px
}
.foot{ width:988px; margin:0px auto; font-size:12px; line-height:39px;}
.foot .foot_page{ float:left; width:600px;color:white;}
.foot .foot_page a{ color:white; text-decoration:none;}
#copyright{ float:right; width:380px; text-align:right; font-size:12px; color:#FFF;}
</style>
<div class="IndexFoot" style="height:120px;clear:both">
<div class="foot" style="padding-top:20px;">
<div class="foot_page" >
<a href="<?php echo ($f_siteUrl); ?>"><?php echo ($f_siteName); ?>,微信公众平台营销</a><br/>
帮助您快速搭建属于自己的营销平台,构建自己的客户群体。
</div>
<div id="copyright" style="color:white;">
	<?php echo ($f_siteName); ?>(c)版权所有 <a href="http://www.miibeian.gov.cn" target="_blank" style="color:white"><?php echo C('ipc');?></a><br/>
	技术支持：<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($f_qq); ?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo ($f_qq); ?>:51" alt="联系我吧" title="联系我吧"/></a>

</div>
    </div>
</div>
<!-- 帮助悬浮开始 -->
<?php $data_g=GROUP_NAME; if(C('close_help')){ $data_g='notingh'; }else{ $textHelp=1; $users=M('Users')->where(array('id'=>$_SESSION['uid']))->find(); if (C('server_topdomain')=='pigcms.cn' || $users['sysuser']){ $textHelp=0; } } $data = array( 'key' => C('server_key'), 'domain' => C('server_topdomain'), 'is_text' => $textHelp, 'data_g' => $data_g, 'data_m' => MODULE_NAME, 'data_a' => ACTION_NAME ); if(function_exists('curl_init')){ $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, 'http://up.pigcms.cn/oa/admin.php?m=help&c=view&a=get_list&'.http_build_query($data)); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); curl_setopt($ch, CURLOPT_HEADER, 0); $content = curl_exec($ch);curl_close($ch); }else{ $content = file_get_contents('http://up.pigcms.cn/oa/admin.php?m=help&c=view&a=get_list&'.http_build_query($data)); } $content = json_decode($content,true); ?>
<?php if(!empty($content)): ?><link href="<?php echo ($staticPath); ?>/tpl/static/help_xuanfu/css/zuoce.css" type="text/css" rel="stylesheet"/>
	<div class="zuoce zuoce_clear">
		<div id="Layer1">
			<a href="javascript:"><img src="<?php echo ($staticPath); ?>/tpl/static/help_xuanfu/images/ou_03.png"/></a>
		</div>
		<div id="Layer2" style="display:none;">
			<p class="xiangGuan zuoce_clear">相关帮助</p>
			<?php if(is_array($content)): $i = 0; $__LIST__ = $content;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><p class="lianjie zuoce_clear"><a href="javascript:openwin('/index.php?g=User&m=Index&a=help&helpParm=/oa/admin_help_<?php echo ($list['id']); ?>.html',768,960)" <?php if($list['is_video'] == 1): ?>class="video"<?php else: ?>class="writing"<?php endif; ?>><?php echo ($list["title"]); ?></a></p><?php endforeach; endif; else: echo "" ;endif; ?>
			<!--p class="anNiuo clear"><a href="#">进入帮助中心</a></p-->
			<p class="anNiut zuoce_clear"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($f_qq); ?>&site=qq&menu=yes" target="_blank">在线客服</a></p>
		</div>
	</div>
	<script type="text/javascript">
		window.onload = function(){
			var oDiv1 = document.getElementById('Layer1');
			var oDiv2 = document.getElementById('Layer2');
			oDiv1.onclick = function(){
				oDiv2.style.display = oDiv2.style.display == 'block' ? 'none' : 'block';
			}
		}
		function openwin(url,iHeight,iWidth){
			var iTop = (window.screen.availHeight-30-iHeight)/2,iLeft = (window.screen.availWidth-10-iWidth)/2;
			window.open(url, "newwindow", "height="+iHeight+", width="+iWidth+", toolbar=no, menubar=no,top="+iTop+",left="+iLeft+",scrollbars=yes, resizable=no, location=no, status=no");
		}
	</script><?php endif; ?>
<!-- 帮助悬浮结束 -->
<div style="display:none">
<?php echo ($alert); ?> 
<?php echo base64_decode(C('countsz'));?>
</div>

</body>

<?php if(MODULE_NAME == 'Function' && ACTION_NAME == 'welcome'){ ?>
<script src="<?php echo ($staticPath); ?>/tpl/static/myChart/js/echarts-plain.js"></script>

<script type="text/javascript">


    var myChart = echarts.init(document.getElementById('main')); 
   

    var option = {
        title : {
            text: '<?php if($charts["ifnull"] == 1): ?>本月关注和文本请求数据统计示例图(您暂时没有数据)<?php else: ?>本月关注和文本请求数据统计<?php endif; ?>',
            x:'left'
        },
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            data:['文本请求数','关注数'],
            x: 'right'
        },
        toolbox: {
            show : false,
            feature : {
                mark : {show: false},
                dataView : {show: false, readOnly: false},
                magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                restore : {show: false} ,
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                boundaryGap : false,
                data : [<?php echo ($charts["xAxis"]); ?>]
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'文本请求数',
                type:'line',
                tiled: '总量',
                data: [<?php echo ($charts["text"]); ?>]
            },    
            {
                "name":'关注数',
                "type":'line',
                "tiled": '总量',
                data:[<?php echo ($charts["follow"]); ?>]
            }
       

        ]

    };                   

    myChart.setOption(option); 


    var myChart2 = echarts.init(document.getElementById('pieMain')); 
               
    var option2 = {
        title : {
            text: '<?php if($pie["ifnull"] == 1): ?>7日内粉丝行为分析示例图(您暂时没有数据)<?php else: ?>7日内粉丝行为分析<?php endif; ?>',
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        toolbox: {
            show : false,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        series : [
            {
                name:'粉丝行为统计',
                type:'pie',
                radius : ['50%', '70%'],
                itemStyle : {
                    normal : {
                        label : {
                            show : false
                        },
                        labelLine : {
                            show : false
                        }
                    },
                    emphasis : {
                        label : {
                            show : true,
                            position : 'center',
                            textStyle : {
                                fontSize : '18',
                                fontWeight : 'bold'
                            }
                        }
                    }
                },
                data:[ 
                    <?php echo ($pie["series"]); ?>
                
                ]
            }
        ]
    };
     myChart2.setOption(option2,true); 


    var myChart3 = echarts.init(document.getElementById('pieMain2')); 
    var option3 = {
        title : {
            text: '<?php if($sex_series["ifnull"] == 1): ?>会员性别统计示例图(您暂时没有数据)<?php else: ?>会员性别统计<?php endif; ?>',
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        toolbox: {
            show : false,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        series : [
            {
                name:'会员性别统计',
                type:'pie',
                radius : ['50%', '70%'],
                itemStyle : {
                    normal : {
                        label : {
                            show : false
                        },
                        labelLine : {
                            show : false
                        }
                    },
                    emphasis : {
                        label : {
                            show : true,
                            position : 'center',
                            textStyle : {
                                fontSize : '18',
                                fontWeight : 'bold'
                            }
                        }
                    }
                },
                data:[
                  <?php echo ($sex_series['series']); ?>
                ]
            }
        ]
    };                     

  myChart3.setOption(option3,true); 



    </script>
<?php } ?>
</html>