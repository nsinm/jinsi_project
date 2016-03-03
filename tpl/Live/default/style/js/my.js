/**
 * Created by Nsinm on 16/3/3.
 */

var myAction = {
    'toMyModel' : function(){
        $("a[class='weui_cell']").each(function(){
            var text = $(this).text();
            if(text.indexOf('我的关注') > 0){
                toUrl(this, params.followUrl);
            }else if(text.indexOf('我的粉丝') > 0){
                toUrl(this, params.fansUrl);
            }else{
                toUrl(this, params.liveUrl);
            }
        });

        function toUrl (tag, url){
            $(tag).click(function(){
                location.href = url;
            });
        }
    },

    'init' : function(){
        if(params.tplName == 'my_index') {
            this.toMyModel();
        }
    }
};

$(function(){
    myAction.init();
})