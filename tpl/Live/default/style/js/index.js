/**
 * Created by Nsinm on 16/2/27.
 */

var indexAction = {
    'getRecomendInstructor' : function(){
        $.getJSON(params.griUrl, {}, function(data){
            var tag = $('.bd .weui_grids');
            tag.empty();
            var html = '';
            if(data.errcode == 0) {
                for (var index in data.data) {
                    html += '<a href="javascript:;" class="weui_grid js_grid col-3-md" data-id="button">';
                    html += '<div class="user_thumb mb10">';
                    html += '<img src="' + data.data[index].jinsi_user_header_pic + '" alt="">';
                    html += '</div>';
                    html += '<p class="weui_grid_label">' + data.data[index].jinsi_user_name + '</p>';
                    html += '</a>';
                }
            }else{
                html += '还没有推荐导师哦';
            }
            tag.html(html);
        }, 'JSON');
    },
    'getReInComment' : function(){
        $.getJSON(params.gricUrl, {}, function(data){
            var element = $('#user_comments');
            var html = '';
            if(data.errcode == 0){
                for(var index in data.data){
                    html += '<div class="weui_cell live_block">';
                    html += '';
                }
            }
        }, 'JSON');
    }
};

$(function(){
    //获取推荐导师列表
    indexAction.getRecomendInstructor();
    //获取关注导师评论列表
    indexAction.getReInComment();
});