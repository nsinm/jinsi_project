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
                    var userName = data.data[index].jinsi_user_name;
                    if(userName.length > 5){
                        userName = userName.substring(0, 4) + '...';
                    }
                    html += '<a href="javascript:;" class="weui_grid js_grid col-3-md" data-id="button" data-value="' + data.data[index].id + '">';
                    html +=     '<div class="user_thumb mb10">';
                    html +=         '<img src="' + data.data[index].jinsi_user_header_pic + '" alt="">';
                    html +=     '</div>';
                    html +=     '<p class="weui_grid_label">' + userName + '</p>';
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

    'getReInComment' : function(type){
        var type = type;
        if(type == null){
            alert('参数错误');
            return;
        }
        $.getJSON(params.gricUrl, {'type' : type}, function(data){
            console.log(data);
            var tag = $('#content');
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
                    html +=         '<p class="user_liveinteract">';;
                        html +=         '<span class="like-btn">';
                        html +=              '<span class="icon-like on" alt="">';
                        html +=                 '</span>赞&nbsp;' + infos[index].jinsi_content_praise_no;
                        html +=         '</span>';
                        html +=         '<span>';
                        html +=             '<span class="icon-comment" alt="">';
                        html +=             '</span>评论&nbsp;' + infos[index].jinsi_content_comment_no;
                        html +=         '</span>';
                        html +=         '<span>';
                        html +=             '<span class="icon-like on" alt="">';
                        html +=             '</span>赞&nbsp;' + infos[index].jinsi_content_praise_no;
                        html +=         '</span>';
                    //html +=             '<span>';
                    //html +=                 '<img src="/tpl/Live/default/style/images/like@2x.png" alt="">赞&nbsp;' + infos[index].jinsi_content_praise_no;
                    //html +=             '</span>';
                    //html +=             '<span>';
                    //html +=                 '<img src="/tpl/Live/default/style/images/comment@2x.png" alt="">评论&nbsp;' + infos[index].jinsi_content_comment_no;
                    //html +=             '</span>';
                    //html +=             '<span>';
                    //html +=                 '<img src="/tpl/Live/default/style/images/share@2x.png" alt="">分享&nbsp;' + infos[index].jinsi_content_share_no;
                    //html +=             '</span>';
                    html +=         '</p>';
                    html +=     '</div>';
                    html += '</div>';
                }
            }else{
                html += '还没有导师直播内容哦!';
            }
            tag.html(html).find("div[class='weui_cell live_block']").each(function(){
                var cid = $(this).attr('data-cid');
                $(this).click(function(){
                    location.href = params.cUrl + '&cid=' + cid;
                });
            });
        }, 'JSON');
    },

    'getComments' : function(){
        var tag = $('.weui_cells.weui_cells_access.mt0');
        var html = '';
        $.getJSON(params.gcUrl, {}, function(data){
            console.log(data);
            if(data.errcode == '0'){
                var infos = data.data;
                for(var index in infos){
                    html += '<div class="weui_cell live_block user_comment">';
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
                    html +=             '<span class="sm-comment">'
                    html +=                 '<span class="icon-comment reply" alt=""></span>回复'
                    html +=             '</span>'
                    html +=         '</p>';
                    html +=     '</div>';
                    html += '</div>';
                }
            }else{
                html += '当前还没有评论内容哦!';
            }
            tag.append(html).find('.user_liveinteract span').each(function(){
                if($(this).attr('class') == 'icon-like on'){
                    $(this).click(function(){
                        var that = $(this);
                        var cid = $(this).attr('data-cid');
                        var url = params.pUrl + '&cid=' + cid;
                        $.getJSON(url, {}, function(data){
                            console.log(data);
                            if(data.errcode == '0'){
                                var parent = that.parent();
                                var parentText = parent.text();
                                parent.empty();
                                var count = 0;
                                var html = '<span class="icon-like" alt=""></span>';
                                if(parentText.indexOf('赞') > 0){
                                    count = parentText.trim().substring(1).trim();
                                    html = '<span class="icon-like" alt=""></span>赞&nbsp;'
                                }else{
                                    count = parentText.trim();
                                }
                                console.log(count);
                                html += parseInt(count) + 1;
                                parent.html(html);
                            }else{
                                alert($(this).attr('class'));
                            }
                        }, 'JSON');
                    });
                }else if($(this).attr('class') == 'icon-comment reply'){
                    $(this).click(function(){
                        $('.weui_actionsheet_menu').find("div[data-value='2']").text('图文回复');
                        $('.weui_actionsheet_menu').find("div[data-value='1']").text('文字回复');
                        showDailog();
                    });
                }else if($(this).attr('class') == 'icon-comment'){
                    $(this).click(function() {
                        showDailog();
                    })
                }
            });
        }, 'JSON');

        function showDailog(){
            var mask = $('#mask');
            var weuiActionsheet = $('#weui_actionsheet1');
            weuiActionsheet.addClass('weui_actionsheet_toggle');
            mask.show().addClass('weui_fade_toggle').click(function () {
                hideActionSheet(weuiActionsheet, mask);
            });
            $('#actionsheet_cancel').click(function () {
                hideActionSheet(weuiActionsheet, mask);
            });
            weuiActionsheet.unbind('transitionend').unbind('webkitTransitionEnd');
        }

        function hideActionSheet(weuiActionsheet, mask) {
            weuiActionsheet.removeClass('weui_actionsheet_toggle');
            mask.removeClass('weui_fade_toggle');
            weuiActionsheet.on('transitionend', function () {
                mask.hide();
            }).on('webkitTransitionEnd', function () {
                mask.hide();
            })
        }
    },

    'toComment' : function(){
        var tag = $('.weui_actionsheet_menu');
        tag.find('div').each(function(){
            var cid = tag.attr('data-value');
            var type = $(this).attr('data-value');
            $(this).click(function(){
                if(cid){
                    location.href = params.tocUrl + '&type=' + type + '&cid=' + cid;
                    return;
                }
                location.href = params.tocUrl + '&type=' + type;
            });
        });
    },

    'moreTeacher' : function(){
        var tag = $('.more-teacher');
        var url = params.instructorUrl + '&type=3';
        tag.click(function(){
            location.href = url;
        });
    },

    'liveFilter' : function(){
        $('#filter').click(function(){
            var $tooltips = $('.js_tooltips'),
                $filter = $('#filter')
            $filter.toggleClass('off')
            $tooltips.html()=='当前切换到已关注导师'?$tooltips.html('当前切换到所有导师'):$tooltips.html('当前切换到已关注导师')
            if ($tooltips.css('display') != 'none') {
                return;
            }

            var type = null;
            if($tooltips.html() == '' || $tooltips.html() == '当前切换到所有导师'){
                type = 1;
            }else{
                type = 2;
            }

            // 如果有`animation`, `position: fixed`不生效
            $('.page.cell').removeClass('slideIn');
            $tooltips.show();
            setTimeout(function () {
                $tooltips.hide();
            }, 2000);

            indexAction.getReInComment(type);
            return;
        });
        this.getReInComment(1);
    },

    'init' : function(){
        if(params.tplName == 'index_index') {
            //获取推荐导师列表
            this.getRecomendInstructor();
            //获取关注导师直播列表
            this.liveFilter();
            this.moreTeacher();
        }else if(params.tplName == 'index_comment'){
            //获取直播评论列表
            this.getComments();
        }
        //十字呼出框点击事件
        this.toComment();
    }
};

$(function(){
    indexAction.init();
});