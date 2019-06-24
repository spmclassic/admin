/**
 * Created by zxs on 2017/1/24.
 */
define(function (require, exports, module) {
    var init = function (obj) {
        $(obj).parent().parent().next("div").children("div").hide();
        $(obj).parent().parent().find("a").removeClass("current");
    }
    module.exports = {
        tabs: function () {
            $(".content > div").hide();
            $(".tabs").each(function () {
                $(this).find("li:first a").addClass("current");
            });
            $(".content").each(function () {
                $(this).find("div:first").fadeIn();
            });
            $(".tabs a").on("click", function (e) {
                $(this).parent().parent().children("li").removeClass("basic-setup").addClass("order-option");
                $(this).parent().removeClass("order-option").addClass("basic-setup");
                e.preventDefault();
                if ($(this).attr("class") == "current") {
                    return;
                } else {
                    init(this);
                    $(this).addClass("current");
                    $($(this).attr("name")).fadeIn();
                }
            });
        }
    }
});
