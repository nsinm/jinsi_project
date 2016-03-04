/**
 * Created by Nsinm on 16/3/4.
 */

var indexAction = {
    'navEvent' : function(){
        var lis = $('.tab ul li');
        $.each(lis, function(){
            $(this).click(function(){
                lis.removeClass('current');
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