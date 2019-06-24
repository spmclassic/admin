define(function(require, exports, module) {
    require("wdatepicker");
    require('layui.css');
    require('layui');
    layui.use(['form', 'layedit','layer'], function () {
        var form = layui.form;

        form.render();
    });
    var t = function(e,i) {
        $(".Wdate").on("click", function() {
            WdatePicker({ dateFmt: "yyyy-MM-dd 00:00:00" })
        });
    };

    exports.bootstrap = function(e, i) {
        $(t(e, i))
    }

});