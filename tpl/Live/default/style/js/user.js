/**
 * Created by Nsinm on 16/2/29.
 */

var userAction = {
    'getUserInfo': function () {
        $.getJSON(params.guiUrl, {}, function (data) {
            if (data.errcode == '0') {
                var infos = data.data[0];
                $('.user_thumb img').attr('src', infos.jinsi_user_header_pic);
                $('#name').text(infos.jinsi_user_name);
                $('#style').text(infos.jinsi_user_style);
                $('#sign').text(infos.jinsi_user_sign);
                $('#info').text(infos.jinsi_user_info);
            } else {
                alert(data.msg);
            }
        }, 'JSON');
    },
    'instructorList': function () {
        $('.weui_select').change(function(){
            var filter = $(this).children('option:selected').val();
            getDefault(filter);
            return;
        });

        function getDefault(filter){
            var filter = filter;
            if(filter == '')
                filter = 1;
            var tag = $('.weui_cells.weui_cells_access');
            var html = '';
            $.getJSON(params.gilUrl, {'filter' : filter}, function(data){
                console.log(data);
                if(data.errcode == 0){
                    var infos = data.data;
                    for(var index in infos){
                        html += '<div class="weui_cell teacherlist_block">';
                        html +=     '<div class="weui_cell_hd">';
                        html +=         '<div class="user_thumb mr10">';
                        html +=             '<img src="' + infos[index].jinsi_user_header_pic + '" alt="">';
                        html +=         '</div>';
                        html +=     '</div>';
                        html +=     '<div class="weui_cell_bd weui_cell_primary ">';
                        html +=         '<p>' + infos[index].jinsi_user_name + '</p>';
                        if(infos[index].is_follow){
                            html +=     '<a href="javascript:;" class="weui_btn weui_btn_mini  weui_btn_default follow" data-value="' + infos[index].id + '">取消关注</a>';
                        }else{
                            html +=     '<a href="javascript:;" class="weui_btn weui_btn_mini weui_btn_primary follow " data-value="' + infos[index].id + '">关注</a>';
                        }
                        html +=         '<p class="user_fans">粉丝：' + infos[index].follow_num + '</p>';
                        html +=         '<p class="user_location">位置：' + infos[index].jinsi_user_city + '</p>';
                        html +=         '<p class="user_style">风格：' + infos[index].jinsi_user_style + '</p>';
                        html +=         '<p class="user_intro">简介：' + infos[index].jinsi_user_info + '</p>';
                        html +=     '</div>';
                        html += '</div>';
                    }
                }else{
                    html += '还没有导师信息哦!';
                }
                tag.html(html).find('a').each(function(){
                    var instructorId = $(this).attr('data-value');
                    var userId = params.userId;
                    var json = {'userId' : userId, 'instructorId' : instructorId};
                    if($(this).attr('class').indexOf('weui_btn_default') > 0){
                        $(this).click(function(){
                            $.getJSON(params.cfollowUrl, json, function(data){
                                console.log(data);
                                if(data.errcode == '0'){
                                    $(this).removeClass('weui_btn_primary').addClass('weui_btn_default');
                                }else{
                                    alert(data.msg);
                                }
                            }, 'JSON');
                        });
                    }else{
                        $(this).click(function(){
                            $.getJSON(params.followUrl, json, function(data){
                                console.log(data);
                                if(data.errcode == '0'){
                                    $(this).removeClass('weui_btn_default').addClass('weui_btn_primary');
                                }else{
                                    alert(data.msg);
                                }
                            }, 'JSON');
                        });
                    }
                });
            }, 'JSON');
        }
        getDefault(1);
    },

    'init': function () {
        if(params.tplName == 'instructor_index') {
            this.getUserInfo();
        }else if(params.tplName == 'instructor_instructor'){
            this.instructorList();
        }
    }
};

$(function(){
    userAction.init();
})