define(function(require, exports, module) {
    require('chosen');
    require('layer');

    var t = function(e,i) {
        var index = parent.layer.getFrameIndex(window.name); //获取当前窗体索引
        var upNum = localStorage.upNum;
        var hasNum = localStorage.hasNum;
        var upBox = localStorage.upBox;
        var upHtml = localStorage.upHtml;

        $('#toupload').click(function () {
            $('.content-bd-warp').animate({
                left:'-100%'
            },300);
        });
        $('#backtoface').click(function () {
            $('.content-bd-warp').animate({
                left:'0'
            },300);
            list_loading = false,page = 1,$('#parent_dir').html(''),is_over = false;
            load_more_msg();
        });
        $('.content-ft .el-cancel').click('click', function() {
            parent.layer.close(index); //执行关闭
        });

        $(document).on('click','.folder-item-box',function () {
            window.location.href = '/system/alert/oss?parent='+$(this).data('id')
        })

        //保存图片
        $('.content-ft .btn-primary').click(function(){
            var allImg = $('.img-row .img-item-box .img-mark.icon-fuxuankuang');
            var allImgAddress = allImg.prevAll('img');
            allImgAddress.each(function(k, v) {
                if(k >= (upNum-hasNum)){
                    return false;
                }
                if((k+1) >= (upNum-hasNum)){
                    parent.$('#'+upBox).next().hide();
                }
                var img = $(v).attr('src');
                var node = $(upHtml);
                node.find('img').attr('src',img);
                node.find('input').val(img);
                parent.$('#'+upBox).append(node);
            });
            parent.layer.close(index); //执行关闭
        });

        //图片的全选
        $('.toolbar-left .img-add-all').on('click', function() {
            var th = $(this);
            //下方所有图片
            var allImg = $('.img-row .img-item-box .img-mark');
            if (th.hasClass('icon-fuxuankuang1')) {
                allImg.removeClass('icon-fuxuankuang1').addClass('icon-fuxuankuang');
                th.removeClass('icon-fuxuankuang1').addClass('icon-fuxuankuang');
            } else {
                allImg.removeClass('icon-fuxuankuang').addClass('icon-fuxuankuang1');
                th.removeClass('icon-fuxuankuang').addClass('icon-fuxuankuang1');
            }
            changeNum();
        });

        //图片单选
        $('.img-row').on('click','.img-item-box',function () {
            var th = $(this).find('.img-mark');
            if (th.hasClass('icon-fuxuankuang1')) {
                th.removeClass('icon-fuxuankuang1').addClass('icon-fuxuankuang');
            } else {
                th.removeClass('icon-fuxuankuang').addClass('icon-fuxuankuang1');
            }
            if($('.img-row .img-mark.icon-fuxuankuang').length > 0){
                $('.toolbar-left .img-add-all').removeClass('icon-fuxuankuang1').addClass('icon-fuxuankuang');
            }else{
                $('.toolbar-left .img-add-all').removeClass('icon-fuxuankuang').addClass('icon-fuxuankuang1');
            }
            changeNum();
        });

        //字数变化
        function changeNum() {
            var num = $('.img-row .img-mark.icon-fuxuankuang').length;
            var text = $('.img-num-text');

            if (num == 0) {
                text.text('请选择图片');
            } else if (num > 0 && num < (upNum-hasNum)) {
                var alsoText = '您已选择' + num + '张，还能上传' + (upNum-hasNum - num) + '张';
                text.text(alsoText);
            } else if (num == (upNum-hasNum)) {
                text.text('已选择图片数量达到上限，请保存');
            } else {
                text.text('已选择图片数量超出上限，只为您保留前' + (upNum-hasNum) + '张！');
            }

        }

        //添加文件夹
        $('#mkdir').on('click', function() {
            $('.add-new-file input').val('');
            layer.open({
                id: 'new-fil',
                skin: 'img-space-layer',
                title: '设置文件夹名称',
                type: 1,
                area: ['400px', '200px'], //宽高
                content: $('#add-new-file'),
                btn: ['确定', '取消'],
                btn1: function() {
                    fileName = $('#add-new-file input').val();
                    if (fileName.length == 0) {
                        message.error('文件夹名称不能为空！');
                        return false
                    } else if (fileName.length > 20) {
                        message.error('文件夹名称超出限制！');
                        return false
                    } else {
                        $.ajax({
                            url: '/system/alert/oss/mkdir',
                            type: 'POST',
                            data: {
                                viewname:fileName,
                                parent:$('#parent_dir').data('parent')
                            },
                            async: false,
                            dataType:'json',
                            success: function(data){
                                if(data.status){
                                    message.success('添加成功');
                                    window.location.href = '/system/alert/oss?parent='+$('#parent_dir').data('parent')
                                }else{
                                    message.success('添加失败');
                                }
                            }
                        });
                    };
                }
            })
        });

        function showdoing(index) {
            $('.doing_1,.doing_2,.doing_3').hide();
            $('.doing_'+index).show();
        }

        var list_loading = false,page = 1,is_over = false;

        $('#autobrowse').scroll(function () {
            if (!list_loading){
                load_more_msg();
            }
        });
        load_more_msg();
        function load_more_msg() {
            if(is_over){
                return false;
            }
            if(($('#parent_dir').height() - $('#autobrowse').height()) <= $('#autobrowse').scrollTop()){
                list_loading = true,showdoing(2);
                $.ajax({
                    url: '/system/alert/oss/file/'+$('#parent_dir').data('parent')+'?page='+page,
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        showdoing(1)
                        if(data.status == 0){
                            return message.error(data.message);
                        }
                        if(data.data.length <= 0){
                            showdoing(3)
                            return is_over = true;
                        }

                        var str = '';
                        for(var i in data.data){
                            if(data.data[i].type == 1){
                                str += '<div class="folder-item-box" data-id="'+data.data[i].id+'">\
                                    <div>\
                                    <i class="icon-wenjianjia1 iconfont"></i>\
                                    <p>'+data.data[i].title+'</p>\
                                    </div>\
                                    </div>';
                            }else if(data.data[i].type == 2){
                                if (/image\//.test(data.data[i].mime_type)){
                                    str += '<div class="img-item-box">\
                                    <img src="'+data.data[i].host+data.data[i].path+'">\
                                    <p>'+data.data[i].title+'</p>\
                                    <i class="iconfont img-mark icon-fuxuankuang1"></i>\
                                    </div>';
                                }else if(/video\//.test(data.data[i].mime_type) || data.data[i].file_tail == 'mkv'){
                                    str += '<div class="img-item-box">\
                                    <img src="'+data.data[i].host+data.data[i].path+'?x-oss-process=video/snapshot,t_6000">\
                                    <p>'+data.data[i].title+'</p>\
                                    <i class="iconfont img-mark icon-fuxuankuang1"></i>\
                                    </div>';
                                }else{
                                    str += '<div class="img-item-box">\
                                    <img src="/admin/images/default.png">\
                                    <p>'+data.data[i].title+'</p>\
                                    <i class="iconfont img-mark icon-fuxuankuang1"></i>\
                                    </div>';
                                }
                            }
                        }

                        $('#parent_dir').append(str);


                        list_loading = false;
                        page++;
                        if(($('#parent_dir').height() - $('#autobrowse').height()) <= $('#autobrowse').scrollTop()){
                            load_more_msg();
                        }
                    }
                });
            }
        }

    };

    exports.bootstrap = function(e, i) {
        $(t(e, i))
    }

});