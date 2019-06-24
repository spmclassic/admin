define(function (require, exports, module) {
    var e = function (e) {
        var s = e.data();
        $.ajax({
            type: s.method ? s.method : "get",
            url: s.url,
            data: s.params,
            dataType: "json",
            contentType: "application/x-json",
            success: function (r) {
                if (r.status === 0) {
                    message.error(r.message);
                    return
                }
                if (r.status == 1) {
                    message.success(r.message);
                    if (s.jump) {
                        setTimeout(function () {
                            window.location.href = s.jump
                        }, 1500)
                    } else {
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500)
                    }
                }
                if (s.successState) {
                    e.hide();
                    $(s.successState).show()
                }
            },
            error: function (e) {
                if (!e) {
                    message.error("服务器出错啦，请赶快告诉管理员吧！")
                }
                switch (e.status) {
                    case 401:
                        message.confirm("当前用户未登陆，请先登录", function (e) {
                            if (e == true) {
                                message.error("当前用户未登录！")
                            }
                        });
                        break;
                    case 404:
                        message.error("服务器访问地址页面不存在");
                        break;
                    case 500:
                        message.error("服务器出错啦，请赶快告诉管理员吧！");
                        break;
                    default:
                        break
                }
                setTimeout(function () {
                    window.location.reload();
                }, 1500)
            }
        })
    };
    module.exports = {
        on: function (s, r) {
            $(s).on("click", r, function () {
                var s = $(this);
                if (s.data("confirm")) {
                    message.confirm(s.data("confirm"), function () {
                            e(s)
                    })
                } else {
                    e(s)
                }
            })
        }
    }
});
