define(function (require, exports, module) {
    require("pjax")($);
    $(document).ready(function () {
        $("body").on("click", ".select-photo,select-photo-list", function () {
            var a = $(this);
            var e = a.data("name") ? a.data("name") : a.attr("id");

            if ($(i).length == 0) {
                var c = '';
                $("body").append(c)
            }
        })
    })
});