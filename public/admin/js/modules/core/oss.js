define(function (require, exports, module) {
    require('plupload');
    var e = function (e, s) {

        accessid = ''
        accesskey = ''
        host = ''
        policyBase64 = ''
        signature = ''
        filename = ''
        callbackUrl = ''
        key = ''
        expire = 0
        g_object_name = ''
        g_object_name_type = 'random_name'
        now = timestamp = Date.parse(new Date()) / 1000;

        function send_request()
        {
            var getData = null;
            $.ajax({
                url: '/system/alert/oss/auth',
                data: {},
                async: false,
                dataType:'json',
                success: function(json){
                    if(!json.accessid){
                        return message.error(json.message);
                    }
                    getData = json;
                }
            });

            return getData;

        };

        function get_signature()
        {
            // 可以判断当前expire是否超过了当前时间， 如果超过了当前时间， 就重新取一下，3s 作为缓冲。
            now = timestamp = Date.parse(new Date()) / 1000;
            if (expire < now + 3)
            {
                var obj = send_request()
                host = obj['host']
                policyBase64 = obj['policy']
                callbackUrl = obj['callbackurl']
                accessid = obj['accessid']
                signature = obj['signature']
                expire = parseInt(obj['expire'])
                key = obj['dir']
                return true;
            }
            return false;
        };

        function random_string(len) {
            len = len || 32;
            var chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
            var maxPos = chars.length;
            var pwd = '';
            for (i = 0; i < len; i++) {
                pwd += chars.charAt(Math.floor(Math.random() * maxPos));
            }
            return pwd;
        }

        function get_suffix(filename) {
            pos = filename.lastIndexOf('.')
            suffix = ''
            if (pos != -1) {
                suffix = filename.substring(pos)
            }
            return suffix;
        }

        function calculate_object_name(filename)
        {
            suffix = get_suffix(filename)
            g_object_name = key + random_string(10) + suffix
            return ''
        }

        function get_uploaded_object_name(filename)
        {
            if (g_object_name_type == 'local_name')
            {
                tmp_name = g_object_name
                tmp_name = tmp_name.replace("${filename}", filename);
                return tmp_name
            }
            else if(g_object_name_type == 'random_name')
            {
                return g_object_name
            }
        }

        function callbackbody(filename) {
            if(!filename || !callbackUrl){
                return false;
            }
            var res = {
                'callbackUrl':callbackUrl,
                'callbackBody':'filename=${object}&size=${size}&mimeType=${mimeType}&viewname='+encodeURIComponent(filename)+'&parent='+$('#parent_dir').data('parent')+'&host='+host,
                'callbackBodyType':"application/x-www-form-urlencoded",
            };

            //回调
            return btoa(JSON.stringify(res));
        }


        function set_upload_param(up, filename, ret)
        {
            if (ret == false)
            {
                ret = get_signature()
            }
            g_object_name = key;
            if (filename != '') { suffix = get_suffix(filename)
                calculate_object_name(filename)
            }
            new_multipart_params = {
                'key' : g_object_name,
                'policy': policyBase64,
                'OSSAccessKeyId': accessid,
                'success_action_status' : '200', //让服务端返回200,不然，默认会返回204
                'callback' : callbackbody(filename),
                'signature': signature,
            };

            up.setOption({
                'url': host,
                'multipart_params': new_multipart_params
            });

            uploader.total.queued > 0 && up.start();
        }

        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : 'selectfiles',
            // multi_selection: false, //true:ctrl多文件上传, false 单文件上传
            container: document.getElementById('container'),
            flash_swf_url : 'lib/plupload-2.1.2/js/Moxie.swf',
            silverlight_xap_url : 'lib/plupload-2.1.2/js/Moxie.xap',

            filters: {
                mime_types : [ //只允许上传图片和zip文件
                    { title : "Image files", extensions : "jpg,gif,png,bmp" },
                    { title : "files", extensions: "mpg,m4v,mp4,flv,3gp,mov,avi,rmvb,mkv,wmv"}
                ],
                max_file_size : '1024mb', //最大只能上传1G的文件
                prevent_duplicates : true //不允许选取重复文件
            },
            // chunk_size: "10mb", //当该值为0时表示不使用分片上传功能
            init: {
                PostInit: function() {
                    document.getElementById('ossfile').innerHTML = '<div class="add-local-img" onclick="document.getElementById(\'selectfiles\').click()">\
                        <i class="iconfont icon-jiahao_1"></i>\
                        </div>';
                    document.getElementById('postfiles').onclick = function() {
                        set_upload_param(uploader, '', false);
                        return false;
                    };
                },

                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        var str = '<div id="' + file.id + '" class="add-local-img" title="' + file.name + '">\
                            <img src="/admin/images/default.png">\
                            <div class="box-delete" hidden>\
                                <i class="icon-shanchu iconfont"></i>\
                            </div>\
                            <p class="box-name">' + file.name + '</p>\
                            <div class="progress"><div class="progress-bar" style="width: 0%"></div></div>\
                        </div>';
                        $('#ossfile').prepend(str);

                        $('#'+file.id+' .box-delete').click(function () {
                            up.removeFile(file);
                            $(this).parents('.add-local-img').remove();
                        });
                    });
                },

                BeforeUpload: function(up, file) {
                    set_upload_param(up, file.name, true);
                },

                UploadProgress: function(up, file) {
                    var d = $('#'+file.id);
                    var prog = d.find('.progress:first');
                    var progBar = prog.find('.progress-bar:first');
                    progBar.css('width',file.percent+'%');
                },

                FileUploaded: function(up, file, info) {
                    if (info.status == 200) {
                        console.log('upload to oss success, object name:' + get_uploaded_object_name(file.name) + ' 回调服务器返回的内容是:' + info.response);
                        $('#'+file.id).find('.box-delete').remove();
                        if (/image\//.test(file.type)){
                            $('#'+file.id).find('img').attr('src',host+get_uploaded_object_name(file.name));
                        }else if(/video\//.test(file.type)){
                            $('#'+file.id).find('img').attr('src',host+get_uploaded_object_name(file.name)+'?x-oss-process=video/snapshot,t_6000');
                        }
                    } else if (info.status == 203) {
                        console.log('上传到OSS成功，但是oss访问用户设置的上传回调服务器失败，失败原因是:' + info.response);
                    } else {
                        console.log(info.response);
                    }
                },

                Error: function(up, err) {
                    if (err.code == -600) {
                        message.error("选择的文件太大了,可以根据应用情况，在upload.js 设置一下上传的最大大小");
                    }else if (err.code == -601) {
                        message.error("选择的文件后缀不对,可以根据应用情况，在upload.js进行设置可允许的上传文件类型");
                    }else if (err.code == -602) {
                        message.error("选这个文件已经上传过一遍了");
                    }else{
                        console.log("Error xml:" + err.response);
                    }
                }
            }
        });

        uploader.init();

    };
    exports.bootstrap = function (s, a) {
        $(e(s, a))
    }
});