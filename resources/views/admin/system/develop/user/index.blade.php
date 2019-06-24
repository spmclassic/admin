@extends('admin.layout.main')
@section('title')
    -User
@stop
@section('content')
    <div class="content_ch">
        <div class="admin_info clearfix">
            <ul class="nav_pills mb10 clearfix">
                <li @if(!request('type') || request('type') == \App\Models\User::USER_TYPE_ADMIN) class="selected" @endif><a href="{{url('system/develop/user')}}?type={{\App\Models\User::USER_TYPE_ADMIN}}">管理员</a></li>
                <li @if(request('type') == \App\Models\User::USER_TYPE_TENANT) class="selected" @endif><a href="{{url('system/develop/user')}}?type={{\App\Models\User::USER_TYPE_TENANT}}">租客管理</a></li>
                <li @if(request('type') == \App\Models\User::USER_TYPE_STAFF) class="selected" @endif><a href="{{url('system/develop/user')}}?type={{\App\Models\User::USER_TYPE_STAFF}}">员工管理</a></li>
                <a class="btn btn_r" href="{{url('system/develop/user/create')}}?type={{$type}}">+ 创建{{$type == \App\Models\User::USER_TYPE_ADMIN ? '管理员':($type == \App\Models\User::USER_TYPE_TENANT ? '租客':'员工')}}</a>
            </ul>
            <div class="mainbox">
                <!--tab 切换1 bengin-->
                <div class="form-horizontal">
                    <!--table 列表 bengin-->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="8%">用户名</th>
                                <th width="5%">
                                    状态
                                </th>
                                <th width=5%">类型</th>
                                <th width=5%">登录</th>
                                <th width="15%">权限组</th>
                                <th width="10%">移动电话</th>
                                <th width="20%">邮箱</th>
                                <th width="10%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($lists))
                                @foreach($lists as $lv)
                                    <tr>
                                        <td>{{$lv['name'] ??  ''}}</td>
                                        <td>
                                            @if($lv['status'] === 1) 正常 @else 停止 @endif
                                        </td>
                                        <td>{{$lv['type'] & 2 ? '租客':'员工'}}</td>
                                        <td> {{!empty($lv['password']) ? '是':'否'}}</td>
                                        <td>
                                        </td>
                                        <td>{{$lv['mobile'] ??  ''}}</td>
                                        <td>{{$lv['email'] ??  ''}}</td>
                                        <td>
                                            <a href="{!! url('system/develop/user/create',['user'=>$lv['id']]) !!}">编辑</a>
                                            <a href="{{url('system/develop/user/passwd',['user'=>$lv['id']])}}">密码</a>
                                            <a href="{!! url('system/develop/user/auth',['user'=>$lv['id']]) !!}">权限</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if($lists->isEmpty())
                                <tr>
                                    <td colspan="9">暂时没有任何数据！</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <!--table 列表 end-->
                    <!--分页 bengin-->
                    @if(!$lists->isEmpty())
                        {!! $lists->appends(request()->all())->render('admin.layout.page') !!}
                    @endif
                    <!--分页 end-->
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