/**
 * Created by Nsinm on 16/3/3.
 */

var myAction = {
    'toAnyModel' : function(){
        $('.weui_cells.weui_cells_access').find('a').each(function(){
            console.log($(this).html());
        });
    },

    'init' : function(){
        this.toAnyModel();
    }
};

$(function(){
    myAction.init();
})