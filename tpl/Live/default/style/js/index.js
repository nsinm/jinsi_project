/**
 * Created by Nsinm on 16/2/27.
 */

var indexAction = {
    'getRecomendInstructor' : function(){
        $.getJSON(params.griUrl, {}, function(data){
            var tag = $('.bd .weui_grids');
            var html = '';
            if(data.errcode == 0) {
                for (var index in data.data) {
                    html += '<a href="javascript:;" class="weui_grid js_grid col-3-md" data-id="button" data-value="' + data.data[index].id + '">';
                    html +=     '<div class="user_thumb mb10">';
                    html +=         '<img src="' + data.data[index].jinsi_user_header_pic + '" alt="">';
                    html +=     '</div>';
                    html +=     '<p class="weui_grid_label">' + data.data[index].jinsi_user_name + '</p>';
                    html += '</a>';
                }
            }else{
                html += '还没有推荐导师哦';
            }
            tag.append(html).find('.weui_grid').each(function(){
                $(this).click(function(){
                    var userId = $(this).attr('data-value');
                    location.href = params.guiUrl + '&userId=' + userId;
                });
            });
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
                    html += '<div class="weui_cell live_block" data-cid="' + infos[index].id + '">';
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
            tag.append(html).find("div[class='weui_cell live_block']").each(function(){
                var cid = $(this).attr('data-cid');
                $(this).click(function(){
                    location.href = params.cUrl + '&cid=' + cid;
                });
            });
        }, 'JSON');
    },

    'getComments' : function(){
        var tag = $('#other');
        var html = '';
        $.getJSON(params.gcUrl, {}, function(data){
            console.log(data);
            if(data.errcode == '0'){
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
                    html +=         '<p class="user_liveword">' + infos[index].jinsi_content_info + '</p>';
                    if(infos[index].jinsi_content_type != '1'){
                        html +=     '<img src="' + infos[index].jinsi_content_url + '" alt="">';
                    }
                    html +=         '<p class="user_livetime"></p>';
                    html +=         '<p class="user_liveinteract">';
                    html +=             '<span class="sm-time">' + infos[index].content_create_time + '</span>';
                    html +=             '<span class="sm-like like-btn">';
                    if(infos[index].current_user_praise == 1){
                        html +=             '<span class="icon-like" alt="">';
                    }else{
                        html +=             '<span class="icon-like on" alt=""  data-cid="' + infos[index].id + '">';
                    }
                    html +=                 '</span>' + infos[index].jinsi_content_praise_no;
                    html +=             '</span>';
                    html +=             '<span class="sm-comment">';
                    html +=                 '<span class="icon-comment" alt=""></span>' + infos[index].jinsi_content_comment_no;
                    html +=             '</span>';
                    html +=         '</p>';
                    html +=     '</div>';
                    html += '</div>';
                }
            }else{
                html += '当前还没有评论内容哦!';
            }
            tag.html(html).find('.user_liveinteract span').each(function(){
                if($(this).attr('class') == 'icon-like on'){
                    $(this).click(function(){
                        var cid = $(this).attr('data-cid');
                        var url = params.pUrl + '&cid=' + cid;
                        $.getJSON(url, {}, function(data){
                            console.log(data);
                            if(data.errcode == '0'){
                                tag.empty();
                                indexAction.getComments();
                            }else{
                                alert(data.msg);
                            }
                        }, 'JSON');
                    });
                }else if($(this).attr('class') == 'icon-comment'){
                    $(this).click(function(){
                        alert(2222);
                    });
                }
            });
        }, 'JSON')
    },

    'init' : function(){
        if(params.tplName == 'index_index') {
            //获取推荐导师列表
            this.getRecomendInstructor();
            //获取关注导师直播列表
            this.getReInComment();
        }else if(params.tplName == 'index_comment'){
            //获取直播评论列表
            this.getComments();
        }
    }
};

$(function(){
    indexAction.init();
});