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
                var text = $('a', $(this)).text();
                $(".ListProduct").empty();
                var navType = 2;
                var count = 0;
                switch (text){
                    case '用户管理':
                        navType = 2;
                        count = params.userCount;
                        break;
                    case '直播管理':
                        navType = 0;
                        count = params.liveCount;
                        break;
                    case '评论管理':
                        navType = 1;
                        count = params.commentCount;
                        break;
                }
                indexAction.pagination(navType, count);
            }) ;
        });
    },

    'getUserList' : function(index){
        var tag = $(".ListProduct");
        var index = index;
        $.getJSON(params.getUserListUrl, {'page': index, 'pageSize': params.pageSize}, function (data) {
            console.log(data);
            var html = '';
            if (data.errcode == '0') {
                var infos = data.data;
                html += '<thead>';
                html +=     '<tr>';
                html +=         '<th class="select"><input type="checkbox" value="" id="check_box" onclick="selectall(\'id[]\');"></th>';
                html +=         '<th width="50">编号</th>';
                html +=         '<th width="50">openid</th>';
                html +=         '<th width="80">用户名</th>';
                html +=         '<th width="100">类型</th>';
                html +=         '<th class="210">风格</th>';
                html +=         '<th width="50">签名</th>';
                html +=         '<th class="50">信息</th>';
                html +=         '<th class="50">推荐</th>';
                html +=         '<th class="40">所在城市</th>';
                html +=         '<th width="100" class="norightborder">操作</th>';
                html +=     '</tr>';
                html += '</thead>';
                html += '<tbody id="user_info">';

                for (var index in infos) {
                    html += '<tr>';
                    html += '<td><input type="checkbox" value="" class="cbitem" name="id[]"></td>';
                    html += '<td>' + infos[index].id + '</td>';
                    html += '<td>' + infos[index].open_id + '</td>';
                    html += '<td>' + infos[index].jinsi_user_name + '</td>';
                    if (infos[index].jinsi_user_type == '1') {
                        html += '<td>普通用户</td>';
                    } else {
                        html += '<td>导师</td>';
                    }
                    html += '<td>' + infos[index].jinsi_user_style + '</td>';
                    html += '<td>' + infos[index].jinsi_user_sign + '</td>';
                    html += '<td>' + infos[index].jinsi_user_info + '</td>';
                    if (infos[index].jinsi_user_type == '2') {
                        if (infos[index].jinsi_user_recommend == '1') {
                            html += '<td>推荐导师</td>';
                        } else {
                            html += '<td>普通导师</td>';
                        }
                    } else {
                        html += '<td></td>';
                    }
                    html += '<td>' + infos[index].jinsi_user_city + '</td>';
                    html += '<td class="norightborder" data-uid="' + infos[index].id + '">';
                    html += '&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)">删除</a><br/>';
                    if (infos[index].jinsi_user_type == '2') {
                        html += '&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)">取消导师</a><br/>';
                        if (infos[index].jinsi_user_recommend == '1') {
                            html += '&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)">取消推荐</a>';
                        } else {
                            html += '&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)">推荐</a>';
                        }
                    } else {
                        html += '&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)">设为导师</a>';
                    }
                    html += '</td>';
                    html += '</tr>';
                }
                html += '</tbody>'
            }
            tag.html(html).find('.norightborder a').each(function(){
                $(this).click(function(){
                    var userId = $(this).parent().attr('data-uid');
                    var text = $(this).text();
                    var type = '';
                    switch (text){
                        case '删除':
                            type = 1;
                            edit(type, userId);
                            break;
                        case '取消导师':
                            type = 2;
                            edit(type, userId);
                            break;
                        case '取消推荐':
                            type = 3;
                            edit(type, userId);
                            break;
                        case '推荐':
                            type = 4;
                            edit(type, userId);
                            break;
                        case '设为导师':
                            type = 5;
                            edit(type, userId);
                            break;
                    }
                });
            });
        }, 'JSON');

        function edit (type, userId){
            var data = {'type' : type, 'userId' : userId};
            $.getJSON(params.editUserUrl, data, function(msg){
                if(msg.errcode == '0'){
                    indexAction.getUserList(index);
                }else{
                    alert(data.msg);
                }
            }, 'JSON');
        }
    },

    'getLiveList' : function(type, index){
        var tag = $(".ListProduct");
        var index = index;
        var type = type;
        $.getJSON(params.getLiveList, {'type': type, 'page': index, 'pageSize': params.pageSize}, function (data) {
            console.log(data);
            var html = '';
            if (data.errcode == '0') {
                var infos = data.data;
                html += '<thead>';
                html +=     '<tr>';
                html +=         '<th class="select"><input type="checkbox" value="" id="check_box" onclick="selectall(\'id[]\');"></th>';
                html +=         '<th width="50">编号</th>';
                if(type == 0){
                    html +=         '<th width="50">直播导师</th>';
                    html +=         '<th width="80">直播类型</th>';
                    html +=         '<th width="100">直播内容</th>';
                }else{
                    html +=         '<th width="50">评论人</th>';
                    html +=         '<th width="80">评论类型</th>';
                    html +=         '<th width="100">评论内容</th>';
                }
                html +=         '<th class="210">图片</th>';
                html +=         '<th width="50">赞</th>';
                if(type == 0) {
                    html += '<th class="50">评论</th>';
                    html += '<th class="50">分享</th>';
                }
                html +=         '<th class="40">创建时间</th>';
                html +=         '<th width="100" class="norightborder">操作</th>';
                html +=     '</tr>';
                html += '</thead>';
                html += '<tbody id="user_info">';

                for (var index in infos) {
                    html += '<tr>';
                    html += '<td><input type="checkbox" value="" class="cbitem" name="id[]"></td>';
                    html += '<td>' + infos[index].id + '</td>';
                    html += '<td>' + infos[index].jinsi_user_name + '</td>';
                    if(infos[index].jinsi_content_type == '1'){
                        html += '<td>文字直播</td>';
                        html += '<td></td>';
                    }else if(infos[index].jinsi_content_type == '2'){
                        html += '<td>图文直播</td>';
                        html += '<td><img src="' + infos[index].jinsi_content_url + '" width="100" alt=""></td>';
                    }
                    html += '<td>' + infos[index].jinsi_content_praise_no + '</td>';
                    if(type == 0){
                        html += '<td>' + infos[index].jinsi_content_comment_no + '</td>';
                        html += '<td>' + infos[index].jinsi_content_share_no + '</td>';
                    }
                    html += '<td>' + infos[index].content_create_time + '</td>';
                    html += '<td class="norightborder" data-cid="' + infos[index].id + '">';
                    html += '&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)">删除</a><br/>';
                    html += '</td>';
                    html += '</tr>';
                }
                html += '<tbody>';
            }
            tag.html(html).find('.norightborder a').click(function(){
                var cid = $(this).parent().attr('data-cid');
                var data = {'cid' : cid};
                $.getJSON(params.delContent, data, function(msg){
                    if(msg.errcode == '0'){
                        indexAction.getLiveList(type, index);
                    }else{
                        alert(data.msg);
                    }
                }, 'JSON');
            });
        }, 'JSON');
    },

    'pagination' : function(navType, count){
        $('.M-box').pagination({
            totalData : count,
            showData : params.pageSize,
            prevContent : '<',
            nextContent : '>',
            callback : function(index){
                if(navType == 2){
                    indexAction.getUserList(index);
                }else{
                    indexAction.getLiveList(navType, index);
                }
            }
        },function(api){
            if(navType == 2){
                indexAction.getUserList(api.getCurrent());
            }else{
                indexAction.getLiveList(navType, api.getCurrent());
            }

        })
    },

    'init' : function(){
        //导航条点击事件
        this.navEvent();
        this.pagination(2);
    }
};

$(function(){
    indexAction.init();
});