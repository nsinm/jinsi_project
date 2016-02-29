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
                    html += '<a href="javascript:;" class="weui_grid js_grid col-3-md" data-id="button" data-uid="' + data.data[index].id + '">';
                    html +=     '<div class="user_thumb mb10">';
                    html +=         '<img src="' + data.data[index].jinsi_user_header_pic + '" alt="">';
                    html +=     '</div>';
                    html +=     '<p class="weui_grid_label">' + data.data[index].jinsi_user_name + '</p>';
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
            console.log(data);
            var tag = $('#user_comments');
            var html = '';
            if(data.errcode == 0){
                var infos = data.data;
                for(var index in infos){
                    html += '<div class="weui_cell live_block">';
                    html +=     '<div class="weui_cell_hd">';
                    html +=         '<div class="user_thumb mr10">';
                    html +=             '<img src="' + infos[index].jinsi_user_header_pic + '" alt="">';
                    html +=         '</div>';
                    html +=     '</div>';
                    html +=     '<div class="weui_cell_bd weui_cell_primary">';
                    html +=         '<p class="user_livename">' + infos[index].jinsi_user_name + '</p>';
                    if(infos[index].jinsi_content_type == '1') {
                        html +=     '<p class="user_liveword">' + infos[index].jinsi_content_info + '</p>';
                    }else if(infos[index].jinsi_content_type == '2'){
                        html +=     '<p class="user_liveword">' + infos[index].jinsi_content_info + '</p>';
                        html +=     '<img src="' + infos[index].jinsi_content_url + '" alt="">';
                    }else{
                        html +=     '<p class="user_wordbubble" >';
                        html +=         '<img src="' + infos[index].jinsi_content_url + '" alt="">';
                        html +=         '<span>32&quot;</span>';
                        html +=     '</p>';
                    }
                    html +=         '<p class="user_livetime">' + infos[index].content_create_time + '</p>';
                    html +=         '<p class="user_liveinteract">';
                    html +=             '<span>';
                    html +=                 '<img src="/tpl/Live/default/style/images/like@2x.png" alt="">赞&nbsp;' + infos[index].jinsi_content_praise_no;
                    html +=             '</span>';
                    html +=             '<span>';
                    html +=                 '<img src="/tpl/Live/default/style/images/comment@2x.png" alt="">评论&nbsp;' + infos[index].jinsi_content_comment_no;
                    html +=             '</span>';
                    html +=             '<span>';
                    html +=                 '<img src="/tpl/Live/default/style/images/share@2x.png" alt="">分享&nbsp;' + infos[index].jinsi_content_share_no;
                    html +=             '</span>';
                    html +=         '</p>';
                    html +=     '</div>';
                    html += '</div>';
                }
            }else{
                html += '还没有导师直播内容哦!';
            }
            tag.append(html);
        }, 'JSON');
    }
};

$(function(){
    //获取推荐导师列表
    indexAction.getRecomendInstructor();
    //获取关注导师评论列表
    indexAction.getReInComment();
});