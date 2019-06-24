@extends('admin.layout.main')
@section('title')
    -Premission
@stop
@section('content')

    <div class="content_ch">

        <!--内容区 bengin-->
        <div class="admin_info clearfix">
            <!--right bengin-->
            <ul class="nav_pills mb10 clearfix">
                <li class="selected">轮播图设置</li>
            </ul>
            <div class="mainbox">
                <form name="profile-form" class="base_form layui-form" method="post" class="mtb20" >

                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>电话：</label>
                        <div class="col-xs-3">
                            <input autocomplete="off" type="text" class="form-control" name="data[kefudianhua]"  value="{!! $model['kefudianhua'] ?? '' !!}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>IOS提示语：</label>
                        <div class="col-xs-3">
                            <input autocomplete="off" type="text" class="form-control" name="data[ios]"  value="{!! $model['ios'] ?? '' !!}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 t_r">&nbsp;</label>
                        <div class="col-xs-8">
                            <input type="submit" class="btn w80" value="确定">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--内容区 end-->

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