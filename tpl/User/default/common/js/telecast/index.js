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
                switch (text){
                    case '用户管理':
                        location.href = params.index;
                        break;
                    case '直播管理':
                        location.href = params.live;
                        break;
                    case '评论管理':
                        location.href = params.comment;
                        break;
                    case '反馈管理':
                        location.href = params.feedback;
                        break;
                    case 'banner管理':
                        location.href = params.banner;
                }
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
                    html += '<td id="user_id">' + infos[index].id + '</td>';
                    html += '<td>' + infos[index].open_id + '</td>';
                    html += '<td id="user_name">' + infos[index].jinsi_user_name + '</td>';
                    if (infos[index].jinsi_user_type == '1') {
                        html += '<td>普通用户</td>';
                    } else {
                        html += '<td>导师</td>';
                    }
                    html += '<td id="user_style">' + infos[index].jinsi_user_style + '</td>';
                    html += '<td id="user_sign">' + infos[index].jinsi_user_sign + '</td>';
                    html += '<td id="user_content">' + infos[index].jinsi_user_info + '</td>';
                    if (infos[index].jinsi_user_type == '2') {
                        if (infos[index].jinsi_user_recommend == '1') {
                            html += '<td>推荐导师</td>';
                        } else {
                            html += '<td>普通导师</td>';
                        }
                    } else {
                        html += '<td></td>';
                    }
                    html += '<td id="user_city">' + infos[index].jinsi_user_city + '</td>';
                    html += '<td class="norightborder" data-uid="' + infos[index].id + '">';
                    html += '&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)">删除</a><br/>';
                    html += '&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)">编辑</a><br/>';
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

            var element = tag.html(html);
            element.find('.norightborder a').each(function(){
                $(this).click(function(){
                    var parent = $(this).parent();
                    var userId = parent.attr('data-uid');
                    var text = $(this).text();
                    var type = '';
                    switch (text){
                        case '删除':
                            type = 1;
                            edit(type, userId, '');
                            break;
                        case '取消导师':
                            type = 2;
                            edit(type, userId, '');
                            break;
                        case '取消推荐':
                            type = 3;
                            edit(type, userId, '');
                            break;
                        case '推荐':
                            type = 4;
                            edit(type, userId, '');
                            break;
                        case '设为导师':
                            type = 5;
                            edit(type, userId, '');
                            break;
                        case '编辑':
                            $(this).text('保存');
                            userInfoEdit(parent);
                            break;
                        case '保存':
                            type = 6;
                            var json = getJson(parent);
                            edit(type, userId, json);
                            $(this).text('编辑');
                            break;
                    }
                });
            });
        }, 'JSON');

        function edit (type, userId, json){
            var data = {'type' : type, 'userId' : userId};
            if(json){
                data = $.extend({}, data, json);
            }
            $.post(params.editUserUrl, data, function(msg){
                if(msg.errcode == '0'){
                    indexAction.getUserList(index);
                }else{
                    alert(data.msg);
                }
            }, 'JSON');
        }

        function userInfoEdit(parent){
            var siblings = parent.siblings();
            $.each(siblings, function(i, n){
                var idName = $(n).attr('id');
                switch(idName){
                    case 'user_name':
                        createHtml(n, 'name');
                        break;
                    case 'user_style':
                        createHtml(n, 'style');
                        break;
                    case 'user_sign':
                        createHtml(n, 'sign');
                        break;
                    case 'user_content':
                        createHtml(n, 'content');
                        break;
                    case 'user_city':
                        createHtml(n, 'city');
                        break;
                }
            })
        }

        function createHtml(ele, name){
            var text = $(ele).text();
            var html = '<input type="text" name="' + name + '" value="' + text +'" style="width:100px;" maxlength="200" />'
            $(ele).html(html);
        }

        function getJson(parent){
            var grand = parent.parent();
            var name = grand.find("input[name='name']").val();
            var style = grand.find("input[name='style']").val();
            var sign = grand.find("input[name='sign']").val();
            var content = grand.find("input[name='content']").val();
            var city = grand.find("input[name='city']").val();
            var json = {'name':name, 'style':style, 'sign':sign, 'content':content, 'city':city};
            return json;
        }
    },

    'getLiveList' : function(index){
        var tag = $(".ListProduct");
        var index = index;
        $.getJSON(params.getLiveList, {'type': 0, 'page': index, 'pageSize': params.pageSize}, function (data) {
            console.log(data);
            var html = '';
            if (data.errcode == '0') {
                var infos = data.data;
                html += '<thead>';
                html +=     '<tr>';
                html +=         '<th class="select"><input type="checkbox" value="" id="check_box" onclick="selectall(\'id[]\');"></th>';
                html +=         '<th width="50">编号</th>';
                html +=         '<th width="50">直播导师</th>';
                html +=         '<th width="80">直播类型</th>';
                html +=         '<th width="100">直播内容</th>';
                html +=         '<th class="210">图片</th>';
                html +=         '<th width="50">赞</th>';
                html +=         '<th class="50">评论</th>';
                html +=         '<th class="50">分享</th>';
                html +=         '<th class="40">创建时间</th>';
                html +=         '<th width="100" class="norightborder">操作</th>';
                html +=     '</tr>';
                html += '</thead>';
                html += '<tbody id="user_info">';

                for (var index in infos) {
                    html += '<tr>';
                    html +=     '<td><input type="checkbox" value="" class="cbitem" name="id[]"></td>';
                    html +=     '<td>' + infos[index].id + '</td>';
                    html +=     '<td>' + infos[index].jinsi_user_name + '</td>';
                    if(infos[index].jinsi_content_type == '1'){
                        html += '<td>文字直播</td>';
                        html += '<td>' + infos[index].jinsi_content_info + '</td>';
                        html += '<td></td>';
                    }else if(infos[index].jinsi_content_type == '2'){
                        html += '<td>图文直播</td>';
                        html += '<td>' + infos[index].jinsi_content_info + '</td>';
                        html += '<td><img src="' + infos[index].jinsi_content_url + '" width="100" alt=""></td>';
                    }
                    html +=     '<td>' + infos[index].jinsi_content_praise_no + '</td>';
                    html +=     '<td>' + infos[index].jinsi_content_comment_no + '</td>';
                    html +=     '<td>' + infos[index].jinsi_content_share_no + '</td>';
                    html +=     '<td>' + infos[index].content_create_time + '</td>';
                    html +=     '<td class="norightborder" data-cid="' + infos[index].id + '">';
                    html +=         '&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)">删除</a><br/>';
                    html +=     '</td>';
                    html += '</tr>';
                }
                html += '<tbody>';
            }
            tag.html(html).find('.norightborder a').click(function(){
                var cid = $(this).parent().attr('data-cid');
                var data = {'cid' : cid};
                $.getJSON(params.delContent, data, function(msg){
                    if(msg.errcode == '0'){
                        indexAction.getLiveList(1);
                    }else{
                        alert(data.msg);
                    }
                }, 'JSON');
            });
        }, 'JSON');
    },

    'getCommentList' : function(index){
        var tag = $(".ListProduct");
        var index = index;
        $.getJSON(params.getLiveList, {'type': 1, 'page': index, 'pageSize': params.pageSize}, function (data) {
            console.log(data);
            var html = '';
            if (data.errcode == '0') {
                var infos = data.data;
                html += '<thead>';
                html +=     '<tr>';
                html +=         '<th class="select"><input type="checkbox" value="" id="check_box" onclick="selectall(\'id[]\');"></th>';
                html +=         '<th width="50">编号</th>';
                html +=         '<th width="50">评论人</th>';
                html +=         '<th width="80">评论类型</th>';
                html +=         '<th width="100">评论内容</th>';
                html +=         '<th class="210">图片</th>';
                html +=         '<th width="50">赞</th>';
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
                        html += '<td>文字评论</td>';
                        html += '<td>' + infos[index].jinsi_content_info + '</td>';
                        html += '<td></td>';
                    }else if(infos[index].jinsi_content_type == '2'){
                        html += '<td>图文评论</td>';
                        html += '<td>' + infos[index].jinsi_content_info + '</td>';
                        html += '<td><img src="' + infos[index].jinsi_content_url + '" width="100" alt=""></td>';
                    }
                    html += '<td>' + infos[index].jinsi_content_praise_no + '</td>';
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
                        indexAction.getCommentList(1);
                    }else{
                        alert(data.msg);
                    }
                }, 'JSON');
            });
        }, 'JSON');
    },

    'getFeedbackList' : function(index){
        var tag = $(".ListProduct");
        var index = index;
        $.getJSON(params.getFeedbackList, {'page': index, 'pageSize': params.pageSize}, function (data) {
            console.log(data);
            var html = '';
            if (data.errcode == '0') {
                var infos = data.data;
                html += '<thead>';
                html +=     '<tr>';
                html +=         '<th width="50">编号</th>';
                html +=         '<th width="50">反馈人</th>';
                html +=         '<th width="300">反馈内容</th>';
                html +=         '<th class="40">反馈时间</th>';
                html +=     '</tr>';
                html += '</thead>';
                html += '<tbody id="user_info">';

                for (var index in infos) {
                    html += '<tr>';
                    html +=     '<td>' + infos[index].id + '</td>';
                    html +=     '<td>' + infos[index].jinsi_user_name + '</td>';
                    html +=     '<td>' + infos[index].jinsi_feedback_content + '</td>';
                    html +=     '<td>' + infos[index].feedback_create_time + '</td>';
                    html += '</tr>';
                }
                html += '<tbody>';
            }
            tag.html(html);
        }, 'JSON');
    },

    //获取banner列表
    'getBannerList' : function(index){
        var tag = $(".ListProduct");
        var index = index;
        $.getJSON(params.bannerList, {'page': index, 'pageSize': params.pageSize}, function(data){
            console.log(data);
            var html = '';
            if (data.errcode == '0') {
                var infos = data.data;
                html += '<thead>';
                html +=     '<tr>';
                html +=         '<th width="50">编号</th>';
                html +=         '<th width="50">图片地址</th>';
                html +=         '<th width="300">连接地址</th>';
                html +=         '<th width="100" class="norightborder">操作</th>';
                html +=     '</tr>';
                html += '</thead>';
                html += '<tbody id="user_info">';

                for (var index in infos) {
                    html += '<tr>';
                    html +=     '<td>' + infos[index].id + '</td>';
                    html +=     '<td>' + infos[index].jinsi_banner_pic + '</td>';
                    html +=     '<td>' + infos[index].jinsi_banner_url + '</td>';
                    html +=     '<td class="norightborder" data-bid="' + infos[index].id + '">';
                    html +=         '&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)">删除</a><br/>';
                    html +=     '</td>';
                    html += '</tr>';
                }
                html += '<tbody>';
            }
            tag.html(html).find('.norightborder a').click(function(){
                var bid = $(this).parent().attr('data-bid');
                var data = {'bid' : bid};
                $.getJSON(params.bannerDel, data, function(msg){
                    if(msg.errcode == '0'){
                        indexAction.getBannerList(index);
                    }else{
                        alert(data.msg);
                    }
                }, 'JSON');
            });
        }, 'JSON')
    },

    'userPagination' : function(){
        $('.M-box').pagination({
            totalData : params.userCount,
            showData : params.pageSize,
            prevContent : '<',
            nextContent : '>',
            callback : function(index){
                indexAction.getUserList(index);
                return;
            }
        },function(api){
            indexAction.getUserList(api.getCurrent());
            return;
        })
    },

    'livePagination' : function(){
        $('.M-box1').pagination({
            totalData : params.liveCount,
            showData : params.pageSize,
            prevContent : '<',
            nextContent : '>',
            callback : function(index){
                indexAction.getLiveList(index);
                return;
            }
        },function(api){
            indexAction.getLiveList(api.getCurrent());
            return;
        })
    },

    'commentPagination' : function(){
        $('.M-box2').pagination({
            totalData : params.commentCount,
            showData : params.pageSize,
            prevContent : '<',
            nextContent : '>',
            callback : function(index){
                indexAction.getCommentList(index);
                return;
            }
        },function(api){
            indexAction.getCommentList(api.getCurrent());
            return;
        })
    },

    'feedbackPagination' : function(){
        $('.M-box3').pagination({
            totalData : params.feedbackCount,
            showData : params.pageSize,
            prevContent : '<',
            nextContent : '>',
            callback : function(index){
                indexAction.getBannerList(index);
                return;
            }
        },function(api){
            indexAction.getBannerList(api.getCurrent());
            return;
        })
    },

    'bannerPagination' : function(){
        $('.M-box4').pagination({
            totalData : params.bannerCount,
            showData : params.pageSize,
            prevContent : '<',
            nextContent : '>',
            callback : function(index){
                indexAction.getCommentList(index);
                return;
            }
        },function(api){
            indexAction.getCommentList(api.getCurrent());
            return;
        })
    },

    'init' : function(){
        //导航条点击事件
        this.navEvent();
        if(params.tplName == 'user_list'){
            this.userPagination();
        }else if(params.tplName == 'user_live'){
            this.livePagination();
        }else if(params.tplName == 'user_comment'){
            this.commentPagination();
        }else if(params.tplName == 'user_feedback'){
            this.feedbackPagination();
        }else if(params.tplName == 'user_banner'){
            this.bannerPagination();
        }
    }
};

$(function(){
    indexAction.init();
});