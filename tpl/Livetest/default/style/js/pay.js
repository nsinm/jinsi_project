/**
 * Created by Nsinm on 16/4/18.
 */

payAction = {
    //跳到付款流程页面
    payFlowPage : function(){
        var payName = $('.pay-desc').text();
        $('.weui_btn').click(function(){
            location.href = params.payFlowUrl + '&fid=' + params.followUserId + '&payName=' + payName;
        })
    },

    //导师详情页
    toTeacherPage : function (){
        var tid = $('.weui_cell_bd').attr('data-uid');
        var url = params.toTeacherUrl + '&userId=' + tid;
        location.href = url;
    },

    //初始化
    init : function(){
        if(params.tplName == 'pay_index'){
            this.payFlowPage();
            this.toTeacherPage();
        }
    }
}

$(function(){
    payAction.init();
})