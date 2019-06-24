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
                <li class="selected">积分设置</li>
            </ul>
            <div class="mainbox">
                <form name="profile-form" class="base_form layui-form" method="post" class="mtb20" >
                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>转发获取积分：</label>
                        <div class="col-xs-3">
                            <input autocomplete="off" type="number" class="form-control" name="data[zhuanfa]"  value="{!! $model['zhuanfa'] ?? 0 !!}">
                        </div>
                        <label class="col-xs-2 t_r"><span class="red">*</span>分享获取积分：</label>
                        <div class="col-xs-3">
                            <input autocomplete="off" type="number" class="form-control" name="data[fenxiang]"  value="{!! $model['fenxiang'] ?? 0 !!}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>评论获取积分：</label>
                        <div class="col-xs-3">
                            <input autocomplete="off" type="number" class="form-control" name="data[pinglun]"  value="{!! $model['pinglun'] ?? 0 !!}">
                        </div>
                        <label class="col-xs-2 t_r"><span class="red">*</span>支付获取积分：</label>
                        <div class="col-xs-3">
                            <input autocomplete="off" type="number" class="form-control" name="data[zhifu]"  value="{!! $model['zhifu'] ?? 0 !!}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>签到获取积分：</label>
                        <div class="col-xs-3">
                            <input autocomplete="off" type="number" class="form-control" name="data[qiandao]"  value="{!! $model['qiandao'] ?? 0 !!}">
                        </div>
                        <label class="col-xs-2 t_r"><span class="red">*</span>关注公众号获取积分：</label>
                        <div class="col-xs-3">
                            <input autocomplete="off" type="number" class="form-control" name="data[guanzhu]"  value="{!! $model['guanzhu'] ?? 0 !!}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>每日积分上限：</label>
                        <div class="col-xs-3">
                            <input autocomplete="off" type="number" class="form-control" name="data[shangxian]"  value="{!! $model['shangxian'] ?? 0 !!}">
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