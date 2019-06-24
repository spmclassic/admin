define(function (require, exports, module) {
    var t = {};
    (function (t) {
        t.fn.extend({
            returntop: function () {
                if (this[0]) {
                    var a = this.click(function () {
                        t("html, body").animate({scrollTop: 0}, 120)
                    }), s = null;
                    t(window).bind("scroll", function () {
                        var e = t(document).scrollTop(), i = t(window).height();
                        0 < e ? a.css("bottom", "154px") : a.css("bottom", "-154px");
                        if (t.isIE6) {
                            a.hide(), clearTimeout(s), s = setTimeout(function () {
                                a.show();
                                clearTimeout(s)
                            }, 1e3), a.css("top", e + i - 125)
                        }
                    })
                }
            }
        })
    })(jQuery);
    (function (t) {
        t("body")
    });
    $("#returnTop").returntop();
    if ($(".nav_first_ch").length && !$(".nav_second_ch").length) {
        $(".content_ch")[0].style.width = "calc(100% - 111px)"
        $(".content_ch")[0].style.marginLeft = ($('.nav_wrap_ch').width() + 10) + "px"
    }
    $(".check_num").on("keyup", function () {
        val = $(this).val();
        if (!(Number(val) >= 0 && Number(val) <= 999999.99)) {
            $(this).val("");
            return false
        }
        if (val.indexOf(".") != -1) {
            $(this).val(val.replace(/^(\d*?\.)(\d{2})\d*/, "$1$2"))
        }
    });
    module.exports = t
});