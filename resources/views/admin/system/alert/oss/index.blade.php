@extends('admin.layout.alert')
@section('title')
    -Index
@stop
@section('content')
    <link rel="stylesheet" href="/admin/css/upload.css">
    <div class="content">
        <div class="content-bd">
            <div class="content-bd-warp">
                <div class="img-con">
                    <div class="img-container">
                        <div class="img-container-toolbar">
                            <div class="toolbar-left">
                                <button id="toupload" class="el-blue">
                                    <i class="iconfont icon-wenjian"></i>
                                    <span>点击上传</span>
                                </button>
                                <button type="button" class="btn-default" id="mkdir">
                                    <span>新建文件夹</span>
                                </button>
                                <label><i class="iconfont img-add-all icon-fuxuankuang1"></i>
                                    <span class="img-num-text">请选择图片</span>
                                </label>
                            </div>
                            <div class="toolbar-search">
                                <a href="{{url('system/alert/oss')}}?parent={{$parent['parent_id'] ?? 0}}">返回上级目录</a>
                            </div>
                        </div>
                        <div class="img-row-layout" id="autobrowse" flex="dir:top">
                            <div class="img-row" id="parent_dir" data-parent="{{$parent['id'] ?? 0}}">

                            </div>

                            <div class="doing_1" style="display: none;">
                                <div class="preloader">下拉加载更多！</div>
                            </div>
                            <div class="doing_2" style="display: none;">
                                <div class="preloader">加载中！
                                </div>
                            </div>
                            <div class="doing_3" style="display: none;">
                                <div class="preloader">没有了！</div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="upload-img-con">
                    <div class="img_up_load">
                        <div class="local-img-con">
                            <label>本地资源:</label>
                            <div id="ossfile" class="local-img-box">
                                你的浏览器不支持flash,Silverlight或者HTML5！
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-ft">
                    <button class="el-blue btn-primary">保存</button>
                    <button class="el-cancel btn-default">取消</button>
                </div>

                <div id="container" class="content-fl">
                    <button id="selectfiles" class="el-blue btn-primary" hidden>选择文件</button>
                    <button id="postfiles" class="el-blue btn-primary">开始上传</button>
                    <button class="btn-default" id="backtoface">返回</button>
                </div>
            </div>
        </div>

        <!--新增-->
        <div id="add-new-file" style="display: none;">
            <lable class="set-new-name">文件夹名称：<input type="text" class="" placeholder="请输入文件夹名称"></lable>
        </div>
    </div>

@stop
@section('script')
    <script>
        var __seajs_debug = 1;
        seajs.use("/admin/js/app.js", function (app) {
            app.bootstrap();
            app.load('system/alert/oss/index');
            app.load('core/oss');
        });

    </script>
@stop