define(function(require, exports, module) {
    require('layui.css');
    require('layui');
    layui.use(['form', 'layedit','layer'], function () {
        var form = layui.form;
        form.render();
    });
    var t = function(e,i) {

    };

    exports.bootstrap = function(e, i) {
        $(t(e, i))
    }

});