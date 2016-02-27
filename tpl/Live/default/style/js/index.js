/**
 * Created by Nsinm on 16/2/27.
 */

var indexAction = {
    'getRecomendInstructor' : function(){
        $.getJSON(params.griUrl, {}, function(data){
            var tag = $('.bd .user_grids');
            tag.remove();
            var html = '';
            for(var instructor in data){
                html += '<a href="javascript:;" class="weui_grid js_grid col-3-md" data-id="button">';
                html += '<div class="user_thumb mb10">';
                html += '<img src="/tpl/Live/default/style/uinfo/1.jpg" alt="">';
                html += '</div>';
                html += '<p class="weui_grid_label">' + instructor.jinsi_user_name + '</p>';
                html += '</a>';
            }
            tag.html(html);
        }, 'JSON');
    },
};

$(function(){
    //获取推荐导师列表
    indexAction.getRecomendInstructor();
});