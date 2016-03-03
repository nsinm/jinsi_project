/**
 * Created by Nsinm on 16/3/3.
 */

var myAction = {
    'toEditUserModel' : function(){
        $('.bd .weui_cells.weui_cells_access').click(function(){

        });
    },

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

    'getMyFollowList' : function(){
        var tag = $('.weui_cells.weui_cells_checkbox');
        $.getJSON(params.gfUrl, {}, function(data){
            console.log(data);
            var html = '';
            if(data.errcode == '0'){
                var infos = data.data;
                for(var index in infos){
                    html += '<label class="weui_cell weui_check_label" for="s11">';
                    html +=     '<div class="weui_cell_hd">';
                    html +=         '<div class="user_thumb mr10">';
                    html +=             '<img src="' + infos[index].jinsi_user_header_pic + '" alt="">';
                    html +=         '</div>';
                    html +=     '</div>';
                    html +=     '<div class="weui_cell_bd weui_cell_primary">';
                    html +=         '<p>' + infos[index].jinsi_user_name + '</p>';
                    html +=         '<p class="user_signature">' + infos[index].jinsi_user_sign + '</p>';
                    html +=     '</div>';
                    html +=     '<input type="checkbox" name="checkbox1" class="weui_check" id="s11">';
                    html +=     '<a href="javascript:;" class="weui_btn weui_btn_mini  weui_btn_default follow"  data-value="' + infos[index].id + '">取消关注</a>';
                    html += '</label>';
                }
            }else{
                html += '您还没有关注任何导师哦,赶快关注吧!';
            }
            tag.html(html).find('a').each(function(){
                $(this).click(function(){
                    var instructorId = $(this).attr('data-value');
                    var userId = params.userId;
                    $.getJSON(params.cfUrl, {'userId': userId, 'instructorId' : instructorId}, function(data){
                        console.log(data);
                        if(data.errcode == '0'){
                            myAction.getMyFollowList();
                        }else{
                            alert(data.msg);
                        }
                    }, 'JSON');
                });
            });
        }, 'JSON');
    },

    'getMyFansList' : function(){
        var tag = $('.weui_cells.weui_cells_access');
        $.getJSON(params.fansUrl, {}, function(data){
            console.log(data);
            var html = '';
            if(data.errcode == '0'){
                var infos = data.data;
                for(var index in infos){
                    html += '<div class="weui_cell">';
                    html +=     '<div class="weui_cell_hd">';
                    html +=         '<div class="user_thumb mr10">';
                    html +=             '<img src="' + infos[index].jinsi_user_header_pic + '" alt="">';
                    html +=         '</div>';
                    html +=     '</div>';
                    html +=     '<div class="weui_cell_bd weui_cell_primary">';
                    html +=         '<p>' + infos[index].jinsi_user_name + '</p>';
                    html +=         '<p class="user_signature">' + infos[index].jinsi_user_sign + '</p>';
                    html +=     '</div>';
                    html += '</div>';
                }
            }else{
                html += '您还没有粉丝,加油哦!';
            }
            tag.html(html);
        }, 'JSON');
    },

    'getMyLiveList' : function(){
        var tag = $('#live_list');
        $.getJSON(params.llUrl, {}, function(data){
            var html = '';
            if(data.errcode == '0'){
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
                html += '您还有没发布直播哦!';
            }
            tag.html(html).find("div[class='weui_cell live_block']").each(function(){
                var cid = $(this).attr('data-cid');
                $(this).click(function(){
                    location.href = params.commentUrl + '&cid=' + cid;
                });
            });
        }, 'JSON');
    },

    'init' : function(){
        if(params.tplName == 'my_index') {
            this.toMyModel();
        }else if(params.tplName == 'my_follow'){
            this.getMyFollowList();
        }else if(params.tplName == 'my_fans'){
            this.getMyFansList();
        }else if(params.tplName == 'my_live'){
            this.getMyLiveList();
        }
    }
};

$(function(){
    myAction.init();
})