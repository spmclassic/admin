@extends('admin.layout.main')
@section('title')
    -Index
@stop
@section('content')

    <div class="content_ch">
        <!--warp bengin-->
        <!--内容区 bengin-->
        <div class="admin_info clearfix">
            <!--right bengin-->
            <ul class="nav_pills mb10 clearfix">
                <a href="{{url('member/manage/callback')}}"><li>用户反馈</li></a>
                <a><li class="selected">反馈详情</li></a>
            </ul>
            <div class="mainbox">
                <!--tab 切换1 bengin-->
                <div class="mainbox">
                    <div class="content">
                        <div class="order-option-father tab1_1" data-name="reason1">
                            <div class="order-set-content clearfix">
                                <div class="form-group mb10">
                                    <label class="col-xs-2 t_r">姓名：</label>
                                    <div class="col-xs-8">{{$model['name'] ?? ''}}</div>
                                </div>
                                <div class="form-group mb10">
                                    <label class="col-xs-2 t_r">手机号：</label>
                                    <div class="col-xs-8">{{$model['mobile'] ?? ''}}</div>
                                </div>
                                <div class="form-group mb10">
                                    <label class="col-xs-2 t_r">反馈时间：</label>
                                    <div class="col-xs-8">{{$model['created_at'] ?? ''}}</div>
                                </div>
                                <div class="form-group mb10">
                                    <label class="col-xs-2 t_r">反馈内容：</label>
                                    <div class="col-xs-8">{{$model['content'] ?? ''}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--tab 切换1 end-->
            </div>
            <!--right end-->
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