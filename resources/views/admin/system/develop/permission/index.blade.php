@extends('admin.layout.main')
@section('title')
    -Premission
@stop
@section('content')

    <div class="content_ch">

        <!--warp bengin-->
        <!--内容区 bengin-->
        <div class="admin_info clearfix">
            <!--right bengin-->
            <ul class="nav_pills mb10 clearfix">
                <li @if(!request('guard') || request('guard') == config('app.guard.admin')) class="selected" @endif><a href="{{url('system/develop/permission')}}">系统权限</a></li>
                <li @if(request('guard') == config('app.guard.tenant')) class="selected"@endif><a href="{{url('system/develop/permission')}}?guard={{config('app.guard.tenant')}}">租客权限</a></li>
                <a class="btn btn_r" href="{!! url('system/develop/permission/create') !!}?guard={{$guard}}">新增权限</a>
            </ul>
            <div class="mainbox">
                <!--tab 切换1 bengin-->
                <div class="form-horizontal t_g_list mt10 clearfix">
                    <!--table 列表 bengin-->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="20%">显示名称</th>
                                <th width="20%">功能名称</th>
                                <th width="5%">组信息</th>
                                <th width="5%">菜单</th>
                                <th width="5%">状态</th>
                                <th width="5%">排序</th>
                                <th width="5%">图标</th>
                                <th width="10%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($lists as $lv)
                                <tr>
                                    <td>|{{str_repeat(' -- ',$lv['level']) }}{{$lv->display_name  ?? "--"}}</td>
                                    <td>{{$lv->name ?? ''}}</td>
                                    <td>{{$lv->guard_name ?? ' -- '}}</td>
                                    <td>{{$lv->is_menu == 1? '是':'否'}}</td>
                                    <td>{{$lv->status == 1 ? '正常':'停止'}}</td>
                                    <td>{{$lv->sorts ?? 0}}</td>
                                    <td>{!! $lv->icon_class !!}</td>
                                    <td>
                                        <a  href="{!! url('system/develop/permission/create',['id'=>$lv['id']]) !!}">编辑</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">暂时没有任何数据！</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if(!$lists->isEmpty())
                        {!! $lists->appends(request()->all())->render('admin.layout.page') !!}
                    @endif
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