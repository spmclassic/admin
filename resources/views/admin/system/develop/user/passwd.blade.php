@extends('admin.layout.main')
@section('title')
    -User
@stop
@section('content')
    <div class="content_ch">
        <!--warp bengin-->
        <!--内容区 bengin-->
        <div class="admin_info clearfix">
            <!--right bengin-->
            <ul class="nav_pills mb10 clearfix">
                <li><a href="{{url('system/develop/user')}}?type={{\App\Models\User::USER_TYPE_ADMIN}}">管理员</a></li>
                <li><a href="{{url('system/develop/user')}}?type={{\App\Models\User::USER_TYPE_TENANT}}">租客管理</a></li>
                <li><a href="{{url('system/develop/user')}}?type={{\App\Models\User::USER_TYPE_STAFF}}">员工管理</a></li>
                <li class="selected"><a href="javascript:;">修改{{$type == \App\Models\User::USER_TYPE_ADMIN ? '管理员':($type == \App\Models\User::USER_TYPE_TENANT ? '租客':'员工')}}密码</a></li>
            </ul>
            <div class="mainbox">
                <form name="password-form" class="base_form" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>用户名：</label>
                        <div class="col-xs-6">
                           {{$model['name'] ?? ''}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>新密码：</label>
                        <div class="col-xs-6">
                            <input type="password" class="form-control" id="newpw" placeholder="新密码" name="data[password]" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>确认新密码：</label>
                        <div class="col-xs-6">
                            <input type="password" class="form-control" id="confpw" placeholder="确认新密码" name="data[password_confirmation]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 t_r">&nbsp;</label>
                        <div class="col-xs-8">
                            <input type="submit" class="btn" value="提交">
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!--right end-->
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