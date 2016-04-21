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
            }else if(text.indexOf('我的会员') > 0){
                toUrl(this, params.memberUrl);
            }else if(text.indexOf('我的直播') > 0){
                toUrl(this, params.liveUrl);
            }else if(text.indexOf('用户反馈') > 0){
                toUrl(this, params.feedbackUrl)
            }else if(text.indexOf('申请当导师') > 0){
                toUrl(this, 'http://form.mikecrm.com/f.php?t=VVpXjv')
            }else{
                toUrl(this, params.exceptionUrl)
            }
        });

        $('#my_info').click(function(){
            location.href = params.userInfoUrl;
        })

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
                var text =  '我的关注&nbsp;&nbsp;(' + data.count + '人)';
                $('.bd .weui_cells_title').html(text);
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
                var text = '我的粉丝&nbsp;&nbsp;(' + data.count + '人)';
                $('.bd .weui_cells_title').html(text);
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
    
    'getMyMemberList' : function () {
        var tag = $('.weui_cells.weui_cells_access');
        $.getJSON(params.memberListUrl, {}, function(data){
            console.log(data);
            var html = '';
            if(data.errcode == '0'){
                var infos = data.data;
                var text = '我的会员&nbsp;&nbsp;(' + data.count + '人)';
                $('.bd .weui_cells_title').html(text);
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
                html += '您还没有会员,加油哦!';
            }
            tag.html(html);
        }, 'JSON');
    },

    'getMyLiveList' : function(){
        var tag = $('#live_list');
        var userId = params.cUserId;
        var data = {};
        if(userId){
            data = {'userId': userId};
        }
        $.getJSON(params.llUrl, data, function(data){
            var html = '';
            if(data.errcode == '0'){
                var infos = data.data;
                for(var index in infos){
                    var imgString = infos[index].jinsi_content_url;
                    var imgs = imgString.split(',');
                    html += '<div class="weui_cell live_block" data-cid="' + infos[index].id + '" data-value="' + infos[index].isMember + '" data-push-type="' + infos[index].jinsi_push_type + '">';
                    html +=     '<div class="weui_cell_hd">';
                    html +=         '<div class="user_thumb mr10">';
                    html +=             '<img src="' + infos[index].jinsi_user_header_pic + '" alt="">';
                    html +=         '</div>';
                    html +=     '</div>';
                    html +=     '<div class="weui_cell_bd weui_cell_primary">';
                    html +=         '<p class="user_livename">' + infos[index].jinsi_user_name + '</p>';
                    if(infos[index].isMember != 1 && infos[index].jinsi_push_type == '1'){
                        var payUrl = params.payUrl + '&userId=' + params.userId + '&fid=' + infos[index].user_id + '&insName=' + infos[index].jinsi_user_name;
                        html +=         '<p class="user_liveword user-comment-name"><span style="color:red;">该条直播为会员内容</span>&nbsp;&nbsp;<a href="' + payUrl + '" class="weui_btn weui_btn_plain_primary jumpBt member" style="top:9px;">成为会员</a></p>';
                    }else{
                        html +=     '<p class="user_liveword">' + infos[index].jinsi_content_info + '</p>';
                        if(infos[index].jinsi_content_type == '2'){
                            for(var urlIndex in imgs) {
                                html += '<img src="' + imgs[urlIndex] + '" class="pic" alt="">';
                            }
                        }
                    }
                    html +=         '<p class="user_livetime">' + infos[index].content_create_time + '</p>';
                    html +=         '<p class="user_liveinteract">';
                    html +=             '<span class="like-btn">';
                    html +=                 '<span alt="">'
                    html +=                     '</span>'
                    html +=             '</span>'
                    html +=             '<span>'
                    html +=                 '<span class="icon-comment" alt="">'
                    html +=                 '</span>评论&nbsp;' + infos[index].jinsi_content_comment_no;
                    html +=             '</span>'
                    html +=             '<span>'
                    html +=                 '<span class="icon-like on" alt="">'
                    html +=                     '</span>赞&nbsp;' + infos[index].jinsi_content_praise_no;
                    html +=             '</span>'
                    html +=         '</p>';
                    html +=     '</div>';
                    html += '</div>';
                }
            }else{
                html += '您还有没发布直播哦!';
            }
            tag.html(html).find("div[class='weui_cell live_block']").each(function(){
                var cid = $(this).attr('data-cid');
                var isMember = $(this).attr('data-value');
                var pushType = $(this).attr('data-push-type');
                $(this).click(function(){
                    if(isMember != 1 && pushType == '1'){
                        return;
                    }
                    location.href = params.commentUrl + '&cid=' + cid;
                });
            });
        }, 'JSON');
    },

    'getUserInfo': function () {
        $.getJSON(params.guiUrl, {userId:params.cUserId}, function (data) {
            console.log(data)
            if (data.errcode == '0') {
                var infos = data.data[0];
                $('.user_thumb img').attr('src', infos.jinsi_user_header_pic);
                $('#name').text(infos.jinsi_user_name);
                $('#style').text(infos.jinsi_user_style);
                $('#sign').text(infos.jinsi_user_sign);
                $('#info').text(infos.jinsi_user_info);
                myAction.attentionOrJoinMember();
            } else {
                alert(data.msg);
            }
        }, 'JSON');
    },

    //关注和加入会员
    'attentionOrJoinMember' : function(){
        var parent = $('.weui_btn_area.mg010');
        var teacherId = parent.attr('data-uid');
        parent.find('a').each(function(){
            if($(this).text == '关注'){
                alert(1111);
            }else{
                alert(2222);
            }
        })
    },

    'addFeedback' : function(){
        var tag = $('.weui_btn.weui_btn_primary');
        tag.click(function(){
            var content = $('.weui_cell textarea').val();
            if(content == ''){
                alert('请填写反馈内容');
                return;
            }
            $.post(params.addFeedUrl, {'content': content}, function(data){
                if(data.errcode == '0'){
                    history.go(-1);
                }else{
                    alert(data.msg);
                }
            }, 'JSON')
        })
    },

    'init' : function(){
        if(params.tplName == 'my_index') {
            this.toMyModel();
        }else if(params.tplName == 'my_follow'){
            this.getMyFollowList();
        }else if(params.tplName == 'my_fans'){
            this.getMyFansList();
        }else if(params.tplName == 'my_live'){
            this.getUserInfo();
            this.getMyLiveList();
        }else if(params.tplName == 'my_feedback'){
            this.addFeedback();
        }else if(params.tplName == 'my_member'){
            this.getMyMemberList();
        }
    }
};

$(function(){
    myAction.init();
})