<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<title>会员系统入口</title>
<meta name="description" content="">
<meta name="keywords" content="">
<script type="text/javascript" src="/tpl/User/default/common/js/select/js/jquery.js"></script>
<script src="/tpl/static/artDialog/jquery.artDialog.js?skin=default"></script>
<script src="/tpl/static/artDialog/plugins/iframeTools.js"></script>
<script src="/tpl/static/upyun.js?2013"></script>

<style type="text/css">
#lean_overlay {
	position: fixed;
	z-index: 100;
	top: 0px;
	left: 0px;
	height: 100%;
	width: 100%;
	background: #000;
	display: none;
} 
#OpenWindow {
	background: none repeat scroll 0 0 #FFFFFF;
	border-radius: 5px 5px 5px 5px;
	box-shadow: 0 0 4px rgba(0, 0, 0, 0.7);
	display: block;
	padding-bottom: 2px;
	width: 90%;
	margin:auto;
	z-index: 11000;
	/*left: 30%;
	position: fixed;*/
	opacity: 1;
	top: 10px;
}
#OpenWindow-header {
	background: #E5E5E5;
	border-bottom: 1px solid #CCCCCC;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
	padding: 18px 18px 14px;
}
#OpenWindow-header p{
	color:#666;
}
/*.modal_close {
	background: url("/tpl/static/images/modal_close.png") repeat scroll 0 0 transparent;
	display: block;
	height: 14px;
	position: absolute;
	right: 12px;
	top: 12px;
	width: 14px;
	z-index: 2;
}*/
body {
	font-size: 13px;
}
#OpenWindow .txt-fld {
	border-bottom: 1px solid #EEEEEE;
	padding: 14px 0px;
	position: relative;
	text-align: center;
	width: 100%;
}
#OpenWindow .txt-fld input {
	background: none repeat scroll 0 0 #F7F7F7;
	border-color: #CCCCCC #E7E6E6 #E7E6E6 #CCCCCC;
	border-radius: 4px 4px 4px 4px;
	border-style: solid;
	border-width: 1px;
	color: #222222;
	font-family: "Helvetica Neue";
	font-size: 1.2em;
	outline: medium none;
	padding: 8px;
	width: 90%;
	
}

#OpenWindow .btn-fld,.btn-fld {
	overflow: hidden;
	padding: 12px 20px;
	text-align: center;
}

#OpenWindow .btn-fld a,.btn-fld a{
	color:#666;
	text-decoration: none;
}

button {
	background: none repeat scroll 0 0 #3F9D4A;
	border: medium none;
	border-radius: 4px 4px 4px 4px;
	color: #FFFFFF;
	font-family: Verdana;
	font-size: 18px;
	font-weight: bold;
	overflow: visible;
	padding: 7px 10px;
	width:80%;
	text-shadow: 0 1px 0 rgba(0, 0, 0, 0.4);
}

/* Start Dropdown Select */
.dropdown-select {-webkit-appearance: button; -webkit-user-select: none; font-size: 13px; overflow: visible; text-overflow: ellipsis; white-space: nowrap;color: #999999; display: inline; position: relative; margin: 0px 1px 0px 1px;font-size: 16px; width: 100%; height: auto;  padding:10px; outline: none; border:0;background-color: transparent;}
.dropdown-option {color: #999;background-color: transparent;}

.por{width:65px;float:left;height:65px;}
.por img{width:60px;height:60px;cursor:pointer}
.por img.selected{border:2px solid #f60}
</style>

</head>
<body>
<?php if(ACTION_NAME == 'memberLogin'): ?><div id="OpenWindow">
		<div id="signup-ct">
			    <div id="OpenWindow-header">
			        <h2>登陆</h2>
			        <p>您好，由于你来自分享链接，系统无法获取您的信息，请使用您的账户登录</p>
			        <a href="#" class="modal_close"></a>
			    </div>
			<form action="" method="post">

			    <div class="txt-fld">
			        <input type="text" name="username" placeholder="账号" />
			    </div>

			    <div class="txt-fld">
			        <input type="password" name="password" placeholder="密码" />
			    </div>

			    <div class="txt-fld">
			        <button type="submit">登 陆</button>
			    </div>

			</form>
			<div class="btn-fld"><a href="<?php echo U('Index/memberReg',array('token'=>$token));?>">还没有账号？立即注册</a></div>
		</div>
	</div>

<?php else: ?>

<style>
.por{width:65px;float:left;height:65px;}
.por img{width:60px;height:60px;cursor:pointer}
.por img.selected{border:2px solid #f60}
</style>
<script>
function selectpor(el){
	$("#portrait").val(el.src);
	$('#pors img').removeClass('selected');
	$('#portrait_src').attr('src',el.src);
	el.className='selected';
}
</script>

	<div id="OpenWindow">
		<div id="signup-ct">
			    <div id="OpenWindow-header">
			    <?php if($wecha_id == NULL): ?><h2>注册</h2>
			        <p>您好，感谢你的注册</p>
			    <?php else: ?>
			    	<h2>完善个人信息</h2>
			    	<p>您好，请您完善个人信息</p><?php endif; ?>
			        <a href="#" class="modal_close"></a>
			    </div>

			<form action="<?php if($wecha_id != NULL): echo U('Index/profile',array('token'=>$token)); endif; ?>" method="post">

	                    <?php if($wecha_id == NULL): ?><div class="txt-fld"><input type="text" value="<?php echo ($UserInfo["username"]); ?>" placeholder="账号" name="username" /></div><?php endif; ?>
	                    <div class="txt-fld"><input type="text" value="<?php echo ($UserInfo["tel"]); ?>" placeholder="请输入您的手机号" name="tel" /></div>
	                    <?php if($wecha_id == NULL): ?><div class="txt-fld"><input type="password" placeholder="请设置您的密码" name="password" /></div>
	                    <div class="txt-fld"><input type="password" placeholder="请输入您的确认密码" name="password2" /></div><?php endif; ?>
	                <?php if(is_array($custom)): $i = 0; $__LIST__ = $custom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$custom): $mod = ($i % 2 );++$i; if($custom['1'] != 0): if(($custom[0]) == "sex"): ?><div class="txt-fld">
	                   			<select name="sex" class="dropdown-select" id="sex">
		                   			<option class="dropdown-option">请选择你的性别</option>
		                   			<option <?php if(($UserInfo['sex']) == "1"): ?>selected<?php endif; ?> value="1">男</option>
		                   			<option <?php if(($UserInfo['sex']) == "2"): ?>selected<?php endif; ?> value="2"> 女</option>
		                   			<option <?php if(($UserInfo['sex']) == "3"): ?>selected<?php endif; ?> value="3">其他</option>
	                   			</select>
	                   			</div>
	                   		<?php elseif($custom[0] == 'portrait'): ?>
	                   		<div class="txt-fld" style="padding:10px;">
		                   		<input type="hidden" value="<?php echo (($UserInfo["portrait"])?($UserInfo["portrait"]):'/tpl/User/default/common/images/portrait.jpg'); ?>" id="portrait" name="portrait" size="80" />
		                   		 <a href="###" onclick="upyunWapPicUpload('portrait',200,200,'<?php echo ($_GET['token']); ?>')" class="a_upload" style="color:red">点击这里上传</a>
		                   		<div class="por"><img src="<?php echo (($UserInfo["portrait"])?($UserInfo["portrait"]):'/tpl/User/default/common/images/portrait.jpg'); ?>" id="portrait_src" /></div>
		                   		<div style="clear:both"></div>
		                   		或者选择下面头像
		                   		<div style="margin:10px 0 20px 0" id="pors">
		                   		<div class="por"><img onclick="selectpor(this)" src="/tpl/static/portrait/1.jpg" /></div>
		                   		<div class="por"><img onclick="selectpor(this)" src="/tpl/static/portrait/2.jpg" /></div>
		                   		<div class="por"><img onclick="selectpor(this)" src="/tpl/static/portrait/3.jpg" /></div>
		                   		<div class="por"><img onclick="selectpor(this)" src="/tpl/static/portrait/4.jpg" /></div>
		                   		<div class="por"><img onclick="selectpor(this)" src="/tpl/static/portrait/5.jpg" /></div>
		                   		<div class="por"><img onclick="selectpor(this)" src="/tpl/static/portrait/6.jpg" /></div>
		                   		<div class="por"><img onclick="selectpor(this)" src="/tpl/static/portrait/7.jpg" /></div>
		                   		<div class="por"><img onclick="selectpor(this)" src="/tpl/static/portrait/8.jpg" /></div>
		                   		<div class="por"><img onclick="selectpor(this)" src="/tpl/static/portrait/9.jpg" /></div>
		                   		<div class="por"><img onclick="selectpor(this)" src="/tpl/static/portrait/10.jpg" /></div>
		                   		<div style="clear:both"></div>
		                   		</div>
		                   	</div>
	                   		<?php else: ?>
		                   		<div class="txt-fld">
		                   			<input type="<?php echo ($custom["3"]); ?>" value="<?php echo ($custom["4"]); ?>" placeholder="<?php echo ($custom["2"]); ?>" name="<?php echo ($custom["0"]); ?>" />
		                   		</div><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
						 <div class="txt-fld"><button type="submit" class="btn-large btn-large mj-submit mj-submit"> <?php if($wecha_id == NULL): ?>注册<?php else: ?>保存<?php endif; ?></button></div>
			</form>
			 <?php if($wecha_id == NULL): ?><div class="btn-fld"><a href="<?php echo U('Index/memberLogin',array('token'=>$token));?>">我已有账号，立即登录</a></div><?php endif; ?>
		</div>
	</div><?php endif; ?>

		<div class="btn-fld" style="margin-top:30px">
			<a href="<?php echo ($R); ?>" style="color:#ccc">我不想成为会员了，让我返回原来的页面</a>
		</div>

</body>
</html>