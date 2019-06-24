/**
 * Created by Administrator on 2018/3/14/014.
 */
/**
 * Created by py on 2017/6/12.
 */
define(function (require, exports, module) {
    var e = function (e, s) {
        $('.image-upload-add').on('click',function () {
            //保证盒子的唯一性
            localStorage.upHtml = $(this).data('item');
            //上传图片name
            localStorage.upBox = $(this).data('box');
            //上传数量
            localStorage.upNum = $(this).data('num');
            //已有数量
            localStorage.hasNum = $('#'+localStorage.upBox).children().length;
            message.img();
        });

        $(document).on('click','.img-delete',function () {
            $(this).parents('.self-add-img').parent().next().show();
            $(this).parents('.self-add-img').remove();
        })
    };
    exports.bootstrap = function (s, a) {
        $(e(s, a))
    }
});
