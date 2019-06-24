@extends('admin.layout.main')
@section('title')
    -Index
@stop
@section('content')
    <div class="content_ch" style="width: calc(100% - 111px);margin-left: 101px;">
        <!--欢迎页 开始-->
        <div style="text-align: center; font-size: 30px; line-height: 200px;">

            中推系统管理后台

        </div>
    </div>
@stop
@section('script')
    <script>
        var __seajs_debug = 1;
        seajs.use("/admin/js/app.js", function (app) {
            app.bootstrap();
        });

    </script>
@stop