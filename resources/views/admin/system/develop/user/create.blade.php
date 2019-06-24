@extends('admin.layout.main')
@section('title')
    -User
@stop
@section('content')
    <div class="content_ch">
        <div class="admin_info clearfix">
            <ul class="nav_pills mb10 clearfix">
                <li><a href="{{url('system/develop/user')}}?type={{\App\Models\User::USER_TYPE_ADMIN}}">管理员</a></li>
                <li><a href="{{url('system/develop/user')}}?type={{\App\Models\User::USER_TYPE_TENANT}}">租客管理</a></li>
                <li><a href="{{url('system/develop/user')}}?type={{\App\Models\User::USER_TYPE_STAFF}}">员工管理</a></li>
                <li class="selected"><a href="jvascript:void(0);">创建/编辑{{$type == \App\Models\User::USER_TYPE_ADMIN ? '管理员':($type == \App\Models\User::USER_TYPE_TENANT ? '租客':'员工')}}</a></li>
            </ul>
            <div class="mainbox">
                <form method="post" class="mtb20 base_form layui-form">
                    {!! csrf_field() !!}
                    @if(!empty($model))
                        <input type="hidden" name="data[id]" value="{!! $model['id'] ?? '' !!}">
                    @endif
                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>姓名：</label>
                        <div class="col-xs-3">
                            <input type="text" class="form-control" placeholder="员工姓名" name="data[name]"  value="{!! $model['name'] ?? '' !!}">
                        </div>
                        <label class="col-xs-2 t_r"><span class="red">*</span>手机号码：</label>
                        <div class="col-xs-3">
                            <input type="text" class="form-control" placeholder="员工手机" name="data[mobile]"  value="{!! $model['mobile'] ?? '' !!}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r">工号：</label>
                        <div class="col-xs-3">
                            <input type="text" class="form-control" placeholder="员工工号" name="data[job_number]"  value="{!! $model['job_number'] ?? '' !!}">
                        </div>

                        <label class="col-xs-2 t_r">公司邮箱：</label>
                        <div class="col-xs-3">
                            <input type="text" class="form-control" placeholder="员工邮箱" name="data[email]"  value="{!! $model['email'] ?? '' !!}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r">生日：</label>
                        <div class="col-xs-3">
                            <input type="text" class="form-control Wdate w260" autocomplete="off" placeholder="yyyy-MM-dd 00:00:00" name="data[birthday]" value="{!! $model['birthday'] ?? '' !!}">
                        </div>
                        @if($type == \App\Models\User::USER_TYPE_STAFF)
                        <label class="col-xs-2 t_r"><span class="red">*</span>所属租客：</label>
                        <div class="col-xs-3">
                            @if(!empty($model))
                                <input type="hidden" name="data[tenant_id]" value="{!! $model['tenant_id'] ?? '' !!}">
                            @endif
                            <select name="data[tenant_id]" class="form-control" @if(!empty($model)) disabled @endif>
                                <option  value="0">--请选择--</option>
                                @if(!empty($tenants))
                                    @foreach($tenants as $lv)
                                        <option value="{!! $lv['id'] ?? '' !!}" @if((!empty($model) && $model->tenant_id == $lv['id'])) selected @endif>{!! $lv['name'] ?? '' !!}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r">性别：</label>
                        <div class="col-xs-3 layui-form radio-pr0-mr0">
                            <label class="mr20"><input type="radio" name="data[gender]"  @if(!isset($model['gender']) || $model['gender'] == 0) checked @endif value="0">未知</label>
                            <label class="mr20"><input type="radio" name="data[gender]"  @if(isset($model['gender']) && $model['gender'] == 1) checked @endif value="1">男</label>
                            <label class="mr20"><input type="radio" name="data[gender]" @if(isset($model['gender']) && $model['gender'] == 2) checked @endif value="2">女</label>
                        </div>
                        <label class="col-xs-2 t_r">状态：</label>
                        <div class="col-xs-4 layui-form radio-pr0-mr0">
                            <label class="mr20"><input type="radio" name="data[status]"  @if(!isset($model['status']) || $model['status'] == 1) checked @endif value="1">正常</label>
                            <label class="mr20"><input type="radio" name="data[status]" @if(isset($model['status']) && $model['status'] == 0) checked @endif value="0">停止</label>
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
    </div>
@stop
@section('script')
    <script>
        var __seajs_debug = 1;
        seajs.use("/admin/js/app.js", function (app) {
            app.bootstrap();
            app.load('system/develop/user/create');
        });

    </script>
@stop

