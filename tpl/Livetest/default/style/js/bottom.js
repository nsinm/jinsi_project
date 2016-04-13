/**
 * Created by Nsinm on 16/2/29.
 */

$(function(){
    $('.bottom-bar').find('div').each(function(){
        $(this).click(function(){
            $('.bottom-bar div').removeClass('selected');
            $(this).attr('class', 'selected');
            if($(this).text() == '直播间'){
                location.href = params.liveRoomUrl + '&random =' + Math.random();
            }else if($(this).text() == '导师'){
                location.href = params.instructorUrl + '&random =' + Math.random();
            }else{
                location.href = params.myUrl + '&random =' + Math.random();
            }
        })

    });
})