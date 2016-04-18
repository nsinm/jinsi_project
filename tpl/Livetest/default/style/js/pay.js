/**
 * Created by Nsinm on 16/4/18.
 */

payAction = {
    //跳到付款流程页面
    payFlowPage : function(){
        var payName = $('pay-desc').text();
        $('.weui_btn').click(function(){
            location.href = params.payFlowUrl + '&fid=' + params.followUserId + '&payName=' + payName;
        })
    },

    //初始化
    init : function(){
        if(params.tplName == 'pay_index'){
            this.payFlowPage();
        }
    }
}

$(function(){
    payAction.init();
})