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
            }) ;
        });
    },

    'getUserList' : function(index){
        var tag = $("#user_info");
        var index = index;
        $.getJSON(params.getUserListUrl, {'page': index, 'pageSize': params.pageSize}, function (data) {
            console.log(data);
            var html = '';
            if (data.errcode == '0') {
                var infos = data.data;
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
            }
            tag.html(html).find('.norightborder a').each(function(){
                $(this).click(function(){
                    var userId = $('.norightborder').attr('data-uid');
                    var text = $(this).text();
                    var type = '';
                    switch (text){
                        case '删除':
                            var type = 1;
                            edit(type, userId);
                            break;
                        case '取消导师':
                            var type = 2;
                            edit(type, userId);
                            break;
                        case '取消推荐':
                            var type = 3;
                            edit(type, userId);
                            break;
                        case '推荐':
                            var type = 4;
                            edit(type, userId);
                            break;
                        case '设为导师':
                            var type = 5;
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
                    alert(data.msg);
                    indexAction.getUserList(index);
                }else{
                    alert(data.msg);
                }
            }, 'JSON');
        }
    },

    'pagination' : function(){
        $('.M-box').pagination({
            totalData : params.userCount,
            showData : params.pageSize,
            prevContent : '<',
            nextContent : '>',
            callback : function(index){
                indexAction.getUserList(index);
            }
        },function(api){
            indexAction.getUserList(api.getCurrent());
        })
    },

    'init' : function(){
        //导航条点击事件
        this.navEvent();
        if(params.tplName == 'user_list'){
            this.pagination();
        }
    }
};

$(function(){
    indexAction.init();
});