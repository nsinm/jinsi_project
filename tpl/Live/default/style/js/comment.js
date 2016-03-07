/**
 * Created by Nsinm on 16/3/3.
 */

var commemtAction = {
    'addComment' : function(){
        $('.weui_btn.weui_btn_primary').click(function(){
            //获取内容
            var content = $("textarea[name='content']").val();
            if(content == ''){
                alert('评论内容不能为空')
            }
            //获取上传图片
            var picUrl = $("#picurl").val();
            //类型 1文字 2图文
            var type = !picUrl ? 1 : 2;
            //获取评论帖子id
            var cid = $("input[name='cid']").val();
            //是否为评论
            var isComment = !cid ? 0 : 1;
            //评论人id
            var userId = params.userId;
            var json = {'content':content, 'picUrl':picUrl, 'type':type, 'cid':cid, 'isComment':isComment, 'userId':userId};
            $.post(params.addUrl, json, function(data){
                if(data.errcode == '0'){
                    $(this).disable();
                    if(cid){
                        location.href = params.toicUrl + '&cid=' + cid;
                    }else{
                        location.href = params.toindexUrl;
                    }
                }else{
                    alert(data.msg);
                }
            }, 'JSON');
        });
    },

    'upload' : function(){
        var tag = $("#file");
        var ul = $('.weui_uploader_files');
        tag.change(function(){
            $.ajaxFileUpload({
                url : params.upUrl,
                secureuri : false,
                fileElementId : 'file',
                dataType : 'json',
                success : function(data){
                    console.log(data);
                    if(data.errcode == '0'){
                        $('.weui_uploader_input_wrp').remove();
                        var infos = data.data;
                        var picUrl = infos[0].savepath + infos[0].savename;
                        $('#picurl').val(picUrl);
                        var html = '<li class="weui_uploader_file" style="background-image:url(' + picUrl + ')"></li>';
                        ul.append(html);
                    }
                },
                error : function(data, status, e){
                    console.log(data);
                    alert('上传失败');
                }
            });
        });
    },

    'init' : function(){
        this.addComment();
        this.upload();
    }
};

$(function(){
    commemtAction.init();
})