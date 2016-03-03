/**
 * Created by Nsinm on 16/3/3.
 */

var commemtAction = {
    'addComment' : function(){
        $('.weui_btn.weui_btn_primary').click(function(){
            //获取内容
            var content = $("textarea[name='content']").val();
            //获取上传图片
            var picUrl = $("input[name='uploadfile']").val();
            //类型 1文字 2图文
            var type = 2;
            if(!picUrl){
                var type = 1;
            }
            
        });
    },

    'init' : function(){
        this.addComment();
    }
};

$(function(){
    commemtAction.init();
})