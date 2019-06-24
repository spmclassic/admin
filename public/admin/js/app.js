seajs.config({
    alias: {
        $: "jq/jquery/2.1.1/jquery",
        "jquery": "jq/jquery/2.1.1/jquery",
        "jquery.form": "jq/jquery.form/3.23/jquery.form",
        "jquery.masonry": "jq/jquery.masonry/4.1.1/jquery.masonry.min",
        "jquery.raty": "jq/jquery.raty/2.4.5/jquery.raty",
        "jquery.laydate": "jq/jquery.laydate/1.1/jquery.laydate",
        "jquery.lazyload": "jq/jquery.lazyload/1.9.7.jquery.lazyload",
        "jquery.uploadify": "uploadify/jquery.uploadify.min",
        "jquery.fullcalendar": "jq/jquery.fullcalendar/1.6.4/jquery.fullcalendar.min",
        "jquery.swiper": "jq/jquery.swiper/3.4.1/jquery.swiper.min",
        'jquery.jsonp': "jq/jquery.jsonp/jquery.jsonp",
        "swiper.css": "jq/jquery.swiper/css/swiper.min.css",
        "bootstrap-min": "bootstrap/3.0.0/bootstrap.min",
        "bootstrap.select": "bootstrap/3.0.0/bootstrap-select",
        "bootstrap-slider": "bootstrap/3.0.0/bootstrap-slider.min",
        "pjax": "jq/jquery.pjax/jquery.pjax",
        "jstree": "jq/jquery.jstree/jquery.jstree",
        "ztree": "jq/jquery.ztree/jquery.ztree.all.min",
        "echarts3.min": "echarts3/echarts.min",
        "echarts3.common.min": "echarts3/echarts.common.min",
        "chosen": "jq/jquery.chosen/chosen.jquery",
        "jquery.birthday": "jq/jquery.birthday/birthday",
        "clipboard": "clipboard/clipboard.min",
        "wdatepicker.css": "res/date/skin/WdatePicker.css",
        "wdatepicker": "res/date/WdatePicker",
        "highcharts": "res/highcharts/4.2.5/highcharts",
        "exporting": "res/highcharts/4.2.5/modules/exporting",
        "webjs.webuploader": "res/webupload/webjs/webuploader",
        "webjs.upload": "res/webupload/webjs/upload",
        "layer.css": "layer/3.0.1/skin/default/layer.css",
        "layer": "layer/3.0.1/layer.js",
        "ajaxactionjs": "utils/0.0.1/ajaxaction",
        "region": "utils/0.0.1/region",
        "message": "utils/0.0.1/message",
        "tab": "utils/0.0.1/tab",
        "modal": "utils/0.0.1/modal",
        "commonjs": "common/pc/js/common",
        "layui.css": "layui/css/layui.css",
        "layui": "layui/layui",
        "plupload": "plupload/3.1.2/js/plupload.full.min.js",
        "datepicker.css": "jq/jquery.datepicker/datepicker.css",
        "datepicker.date": "jq/jquery.datepicker/datepicker.all"
    },
    vars: { locale: "zh-cn" },
    preload: ["jquery"],
    debug: __seajs_debug,
    charset: "utf-8"
});
var $, message, common, ajaxaction;
define(function(require, exports, module) {

    $ = require("jquery");
    require('jquery.form')($);
    window.$ = window.jQuery = $;
    message = require('message');
    ajaxaction = require("ajaxactionjs");

    exports.context = {};
    exports.load = function(e, a) {
        require.async("./modules/" + e + ".js", function(e) {
            if (e.bootstrap) {
                e.bootstrap(exports.context, a)
            }
        })
    };
    window.app_load = exports.load;
    exports.bootstrap = function() {

        var isload = false;

        //子菜单切换
        $(".sidenav .nav_tit").off().click(function() {
            $(this).parent().toggleClass('on').siblings().removeClass('on');
        });

        //表单提交
        var options = {
            beforeSerialize: function() {
                if(isload){
                    return false;
                }
                return isload = true;
            },
            success: function(data) {
                if (data.status)
                {
                    message.success(data.message);
                    if (data.url)
                    {
                        window.location.href = data.url;
                    }
                    else{
                        window.location.reload();
                    }
                }
                else
                {
                    message.error(data.message);
                }
            },
            complete: function () {
                isload = false;
            }
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });
        $('.base_form').ajaxForm(options);

        ajaxaction.on($("a.do_action"))
    }
});