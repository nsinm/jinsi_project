/**
 * Created by Nsinm on 16/3/3.
 */

var commemtAction = {
    'addComment' : function(){
        $('.weui_btn.weui_btn_primary').click(function(){
            //获取内容
            var content = $("textarea[name='content']").val();
            if(content == ''){
                alert('评论内容不能为空')
            }
            //获取上传图片
            var picUrl = $("input[name='uploadfile']").val();
            //类型 1文字 2图文
            var type = !picUrl ? 1 : 2;
            //获取评论帖子id
            var cid = $("input[name='cid']").val();
            //是否为评论
            var isComment = !cid ? 0 : 1;
            //评论人id
            var userId = params.userId;
            var json = {'content':content, 'picUrl':picUrl, 'type':type, 'cid':cid, 'isComment':isComment, 'userId':userId};
            $.post(params.addUrl, json, function(data){
                console.log(data);
            }, 'JSON');
        });
    },

    'init' : function(){
        this.addComment();
    }
};

$(function(){
    commemtAction.init();
})