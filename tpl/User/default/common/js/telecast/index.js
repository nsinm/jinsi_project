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

    'getUserList' : function(){
        var tag = $("#user_info");
        var pageIndex = 0;
        var pageSize = params.pageSize;

        function getList (index) {
            $.getJSON(params.getUserListUrl, {'page': index, 'pageSize': pageSize}, function (data) {
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
                        html += '<td class="norightborder">';
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
                    tag.html(html);

                    if ($('.M-box').html().length == '') {
                        $('.M-box').pagination(data.total, {
                            callback: 'pageCallback',
                            prev_text: '<',
                            next_text: '>',
                            items_per_page: pageSize,
                            num_edge_entries: 2,
                            num_display_entries: 6,
                            current_page: pageIndex
                        });
                    }
                }
            }, 'JSON');
        }

        function pageCallback (pageIndex, jq){
            getList(pageIndex);
        }

        getList(pageIndex);
    },

    'page' : function(count){

        $('.M-box').pagination(count, {
            callback: pageCallback,
            prev_text: '<',
            next_text: '>',
            items_per_page: pageSize,
            num_edge_entries: 2,
            num_display_entries: 6,
            current_page: pageIndex
        });

        function pageCallback (index, jq){
            this.getUserList(index);
        }
    },

    'init' : function(){
        //导航条点击事件
        this.navEvent();
        if(params.tplName == 'user_list'){
            this.getUserList();
        }
    }
};

$(function(){
    indexAction.init();
});