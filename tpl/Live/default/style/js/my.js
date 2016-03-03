/**
 * Created by Nsinm on 16/3/3.
 */

var myAction = {
    'toAnyModel' : function(){
        $("a[class='weui_cell']").each(function(){
            var text = $(this + ' p').text();
            console.log(text);
            if(text.indexOf('我的关注') > 0){

            }
        });

        function toUrl (tag, url){
            $(tag).click(function(){
                location.href = url;
            });
        }
    },

    'init' : function(){
        this.toAnyModel();
    }
};

$(function(){
    myAction.init();
})