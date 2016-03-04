/**
 * Created by Nsinm on 16/3/4.
 */

var indexAction = {
    'navEvent' : function(){
        var tag = $('.tab ul li');
        tag.each(function(){
            $(this).click(function(){
                if($(this).attr('class') == 'tabli current')
                    return;
                tag.removeClass('currnet');
                $(this).addClass('current');
            }) ;
        });
    },

    'init' : function(){
        //导航条点击事件
        this.navEvent();
    }
};

$(function(){
    indexAction.init();
});