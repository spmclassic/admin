define(function(require, exports, module) {
    require('layui.css');
    require('layui');
    require('jquery.qrcode');
    layui.use(['form', 'layedit','layer'], function () {
        var form = layui.form;
        form.render();
    });

    $('.qrcodeeee').each(function(){
        $(this).qrcode({
            width: 300, //宽度
            height:300, //高度
            text: $(this).attr('href')
        })
    })

    $('.dddddd').click(function(){
        layer.open({
            type: 1,
            closeBtn: 0, //不显示关闭按钮
            anim: 2,
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