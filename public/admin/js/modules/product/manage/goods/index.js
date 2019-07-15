define(function(require, exports, module) {
    require('layui.css');
    require('layui');
    require('jquery.qrcode');
    require('utf');
    layui.use(['form', 'layedit','layer'], function () {
        var form = layui.form;
        form.render();
    });

    $('.qrcodeeee').each(function(){
        $(this).qrcode({
            width: 160, //宽度
            height:160, //高度
            text: $(this).attr('href'),
            background : "#ffffff",
            foreground : "#000000",
            src:'http://manage.spmclassic.com/images/logo2.png'
        })
    })

    $('.dddddd').click(function(){
        layer.open({
            type: 1,
            closeBtn: 0, //不显示关闭按钮
            area:['800px','550px'],
            shadeClose: true, //开启遮罩关闭
            content: $(this).next()
        });
    });
    var t = function(e,i) {

    };

    exports.bootstrap = function(e, i) {
        $(t(e, i))
    }

});