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
                <li @if(!request('guard') || request('guard') == config('app.guard.admin')) class="selected" @endif><a href="{{url('system/develop/role')}}">系统角色</a></li>
                <li @if(request('guard') == config('app.guard.tenant')) class="selected"@endif><a href="{{url('system/develop/role')}}?guard={{config('app.guard.tenant')}}">租客角色</a></li>
                <a class="btn btn_r" href="{!! url('system/develop/role/create') !!}?guard={{$guard}}">新增角色</a>
            </ul>
            <div class="mainbox">
                <!--tab 切换1 bengin-->
                <div class="form-horizontal t_g_list mt10 clearfix">
                    <!--table 列表 bengin-->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>角色名称</th>
                                <th width="20%">创建时间</th>
                                <th width="20%">最后编辑</th>
                                <th width="20%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($lists as $lv)
                                <tr>
                                    <td>{{$lv->name ?? ''}}</td>
                                    <td>{{$lv->created_at}}</td>
                                    <td>{{$lv->updated_at ?? ' -- '}}</td>
                                    <td>
                                        <a href="{!! url('system/develop/role/create') !!}/{{$lv->id ?? ''}}">编辑</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">暂时没有任何数据！</td>
                                </tr>
                            @endforelse
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
            <div class="goods_aui_wrap hide">
                <div class="token-list">
                    <ul id="goods_aui_tree" class="ztree"></ul>
                </div>
                <div class="goods_aui_btn pos_abs">
                    <input type="button" value="确定" class="save">
                </div>
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