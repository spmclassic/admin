define(function (require, exports, module) {
    var ex = {};
    ex.init = function () {
        require('layer.css');
        var layer = require('layer');
    }
    ex.error = function (msg) {
        this.init();
        var time = (arguments.length < 2) ? 2000 : arguments[1];
        layer.msg(msg, {
            icon: 2,
            time: time
        });
    }

    ex.success = function (msg) {
        this.init();
        var time = (arguments.length < 2) ? 2000 : arguments[1];
        layer.msg(msg, {
            icon: 1,
            time: time
        });
    }

    ex.close = function () {
        this.init();
        layer.close(layer.index);
    }
    ex.closeAll = function () {
        this.init();
        layer.closeAll();
    }
    $('.textareaPop').on('click', function () {
        var th = $(this);
        ex.init();
        var msgPop = th.attr('data-text')
        var url = th.attr('data-url');
        layer.prompt({
            title: msgPop,
            formType: 2,
            yes: function (index, layero) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        reason: $(".layui-layer-input").val()
                    },
                    async: true,
                    success: function (data) {
                        layer.close(index);
                        if (data.status == 1) {
                            ex.success(data.message);
                            if (data.url) {
                                window.location.href = data.url;
                            }
                        } else {
                            ex.error(data.message);
                        }
                    }
                });
            }
        }, function (text, index) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data: {
                    reason: text
                },
                async: true,
                success: function (data) {
                    layer.close(index);
                    if (data.status == 1) {
                        ex.success(data.message);
                        if (data.url) {
                            window.location.href = data.url;
                        }
                    } else {
                        ex.error(data.message);
                    }
                },
                error: function () {

                }
            });
            layer.close(index);
        });
    })
    //弹出框
    ex.popup = function ($title, $msg, $width, $height) {
        this.init();
        layer.open({
            type: 1,
            title: $title,
            shadeClose: false,
            maxmin: true, //开启最大化最小化按钮
            area: [$width + 'px', $height + 'px'],
            content: $msg,
            cancel: function (index) {
                layer.close(index)
            },
            yes: function (index) {
                layer.close(index)
            }
        });
    };

    ex.confirm = function (msg) {
        this.init();
        var ok = arguments[1] ? arguments[1] : function (index) {
            // this.success(msg);
        };
        var cancel = arguments[2] ? arguments[2] : function (index) {
            layer.close(index);
        };
        //询问框
        layer.confirm(msg, {
            btn: ['确定', '取消'], //按钮,
            area: ['420px', '200px'],
        }, ok, cancel);
    }
    //只读信息弹窗
    ex.default = function (title, msg) {
        this.init();
        var ok = function (index) {
            layer.close(index);
        };
        layer.confirm(msg, {
            title: title,
            btn: ['关闭'],
            area: ['420px', '200px'],
        }, ok);
    }
    ex.confirmReload = function (msg) {
        this.init();
        var ok = arguments[1] ? arguments[1] : function (index) {
            layer.close(index);
            window.location.reload()
        };
        //询问框
        layer.confirm(msg, {
            btn: ['确定'], //按钮,
            area: ['420px', '200px'],
        }, ok);
    }

    // 商城删除功能弹窗
    ex.devares = function (msg, url, msgs, newClass, prompt) {
        this.init();
        var yes = function (index) {
            $.ajax({
                type: 'get',
                async: false,
                url: url,
                success: function (msg) {
                    if (msg.status) {
                        message.success(prompt)
                    } else {
                        message.success(msg.message)
                    }
                    location.reload();
                },
                error: function (msg) {}
            });
            layer.close(index);
        }

        var cancel = function (index) {

            layer.close(index);
        };
        //询问框
        layer.confirm(msg, {
            skin: newClass,
            title: msgs,
            btn: ['确定', '取消'], //按钮,
            area: ['600px', '300px'],
        }, yes, cancel);
    };
    //图片上传
    ex.img = function () {
        this.init();
        layer.open({
            skin: 'img-up-load',
            id: 'insert-form',
            type: 2,
            title: '选择图片',
            shadeClose: true,
            shade: 0.8,
            area: ['817px', '540px'],
            content: '/system/alert/oss'
        });
    };

    //可视化首页专供弹框
    ex.firms = function (title, msg, width, height) {
        this.init();
        layer.open({
            type: 1,
            title: title,
            // btn: '确定',
            // shadeClose: true,
            area: [width + 'px', height + 'px'],
            content: msg,
            cancel: function (index) {
                layer.close(index)
            },
            yes: function (index) {
                layer.close(index)
            }
        });
    };
    module.exports = ex;
});