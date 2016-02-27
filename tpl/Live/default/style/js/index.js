/**
 * Created by Nsinm on 16/2/27.
 */

var indexAction = {
    'getRecomendInstructor' : function(){
        $.getJSON(params.griUrl, {}, function(data){
            alert(data);
        }, 'JSON');
    },
};

$(function(){
    //获取推荐导师列表
    indexAction.getRecomendInstructor();
});