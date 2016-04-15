/**
 * Created by Nsinm on 16/3/3.
 */

var commemtAction = {
    'addComment' : function(){
        $('.weui_btn.weui_btn_primary').click(function(){
            var url = $(this).attr('data-url');
            if(url == '')
                return;
            //获取内容
            var content = $("textarea[name='content']").val();
            //获取上传图片
            var picUrl = $("#picurl").val();
            //类型 1文字 2图文
            var type = !picUrl ? 1 : 2;
            if(type == 1 && content == ''){
                alert('评论内容不能为空');
                return;
            }
            //获取评论帖子id
            var cid = $("input[name='cid']").val();
            //是否为评论
            var isComment = !cid ? 0 : 1;
            //评论人id
            var userId = params.userId;
            var json = {'content':content, 'picUrl':picUrl, 'type':type, 'cid':cid, 'isComment':isComment, 'userId':userId}
            if(!isComment){
                commemtAction.showDialog(url, cid, json);
            }else{
                json.push = 0;
                $.post(url, json, function(data){
                    if(data.errcode == '0'){
                        $('.weui_btn.weui_btn_primary').removeAttr('data-url');
                        if(cid){
                            location.href = params.toicUrl + '&cid=' + cid;
                        }else{
                            location.href = params.toindexUrl;
                        }
                    }else{
                        alert(data.msg);
                    }
                }, 'JSON');
            }
        });
    },

    'showDialog' : function(url, cid, json){
        var dialog = $('#dialog');
        var json = json;
        var url = url;
        dialog.show();
        dialog.find('.weui_dialog_ft a').on('click', function(e){
            dialog.hide();
            showLoading();
            var push = 0;
            if($(this).text() == '发布并推送'){
                push = 1;
            }
            json.push = push;
            $.post(url, json, function(data){
                if(data.errcode == '0'){
                    hideLoading();
                    $('.weui_btn.weui_btn_primary').removeAttr('data-url');
                    if(cid){
                        location.href = params.toicUrl + '&cid=' + cid;
                    }else{
                        location.href = params.toindexUrl;
                    }
                }else{
                    alert(data.msg);
                }
            }, 'JSON');
        })

        function showLoading(){
            $('#loadingToast').show();
        }

        function hideLoading(){
            $('#loadingToast').hide();
        }
    },

    'upload' : function(){
        var tag = $("input[type='file']");
        var ul = $('.weui_uploader_files');
        tag.bind('change', function(){
            $.ajaxFileUpload({
                url : params.upUrl,
                secureuri : false,
                fileElementId : 'file',
                dataType : 'json',
                success : function(data){
                    console.log(data);
                    if(data.errcode == '0'){
                        //$('.weui_uploader_input_wrp').remove();
                        var infos = data.data;
                        var picUrl = infos[0].savepath + infos[0].savename;
                        var html = '<li class="weui_uploader_file" style="background-image:url(' + picUrl + ')"></li>';
                        var imgPath = $('#picurl').val();
                        imgPath += picUrl + ',';
                        $('#picurl').val(imgPath);
                        var imgs = imgPath.substring(0, imgPath.lastIndexOf(',')).split(',');
                        if(imgs.length >= 4){
                            $('.weui_uploader_input_wrp').remove();
                        }
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

    'wordCount' : function(){
        var content = $('.weui_textarea');
        var countNum = $('#word_count');
        content.keyup(function(){
            var len = $(this).val().length;
            if(len > 199){
                $(this).val($(this).val().substring(0, 200));
                len = 200;
            }
            var num = len;
            countNum.text(num);
        })
    },

    'init' : function(){
        this.addComment();
        this.upload();
        this.wordCount();
    }
};

$(function(){
    commemtAction.init();
})