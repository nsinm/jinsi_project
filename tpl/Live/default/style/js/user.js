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
            }, 'JSON');
        }
        getDefault(1);
    },

    'init': function () {
        this.getUserInfo();
        this.instructorList();
    }
};

$(function(){
    userAction.init();
})