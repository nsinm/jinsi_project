/**
 * Created by Nsinm on 16/2/29.
 */

$(function(){
    $('.bottom-bar').find('div').each(function(i){
        alert(i);
        $(this).click(function(){
            if($(this).attr('class') == 'selected')
                return;

        })

    });
})