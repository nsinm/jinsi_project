/**
 * Created by Nsinm on 16/2/29.
 */

$(function(){
    $('.bottom-bar').find('div').each(function(i){
        if($('.bottom-bar').find('div').get(i).getAttribute('class') == 'selected'){
            $('.bottom-bar').find('div').get(i).setAttribute('class', null);
        }
        $(this).click(function(){
            if($(this).attr('class') == 'selected')
                return;
            $(this).attr('class', 'selected');
        })
    });
})