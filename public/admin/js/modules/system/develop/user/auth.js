define(function(require, exports, module) {
    require('layui.css');
    require('layui');
    layui.use(['form', 'layedit','layer'], function () {
        var form = layui.form;
        form.render();
    });
    var t = function(e,i) {
        $('.crole-header input').change(function () {
            var module = $(this).parents('.crole-header').data('sign');
            $('.'+module).find('input').prop('checked', this.checked);
        });
        $('.crole-parent input').change(function() {
            $(this).parents('.crole-parent').next('.crole-children').find('input').prop('checked', this.checked);
            var module = $(this).parents('.crole-parent').data('sign');
            controllerheader(module);
        })
        $('.crole-children input').change(function() {
            if($(this).is(':checked')){//向上
                upselect($(this),$(this).data('key'));
            }else{//向下
                downtake($(this),$(this).data('key'));
            }

            if ($(this).parents('.crole-children').find('input:checked').length > 0) {
                $(this).parents('.crole-children').prev('.crole-parent').find('input').prop('checked', true);
            } else {
                $(this).parents('.crole-children').prev('.crole-parent').find('input').prop('checked', false);
            }
            var module = $(this).parents('.crole-children').data('sign');
            controllerheader(module);
        });

        function controllerheader(module) {
            if($('.'+module+'.crole-parent').find('input:checked').length > 0){
                $('.'+module+'.crole-header').find('input').prop('checked', true);
            }else{
                $('.'+module+'.crole-header').find('input').prop('checked', false);
            }
        }

        function upselect(_this,name) {
            var str = decodeURI(name.substring(0, name.lastIndexOf("\.")));
            var nodes = _this.parents('.crole-children').find('input[data-key="'+str+'"]');
            if(nodes.length > 0){
                nodes.prop('checked', true);
                upselect(_this,str);
            }
            return false;
        }

        function downtake(_this,name) {
            _this.parents('.crole-children').find('input[data-key^="'+name+'"]').prop('checked', false);
        }

        $('.js_role').click(function() {
            if ($(this).is(':checked')) {
                var data = { role: $(this).val(), type: 'add' }
            } else {
                var data = { role: $(this).val(), type: 'del' }
            }
            $.post($(this).attr('href'), data, function(data) {
                if (data.status) {
                    message.success(data.message);
                    window.location.reload();
                } else
                    message.error(data.message);
            }, 'json');
        });
    };

    exports.bootstrap = function(e, i) {
        $(t(e, i))
    }

});