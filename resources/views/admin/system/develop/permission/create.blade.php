@extends('admin.layout.main')
@section('title')-创建/编辑{{$guard == config('app.guard.tenant') ? '租客':'系统'}}权限@stop
@section('content')
    <div class="content_ch">
        <div class="admin_info clearfix">
            <ul class="nav_pills clearfix">
                <a href="{!! url('system/develop/permission') !!}"><li>系统权限</li></a>
                <a href="{!! url('system/develop/permission') !!}?guard={{config('app.guard.tenant')}}"><li>租客权限</li></a>
                <li class="selected">
                    创建/编辑{{request('guard') == config('app.guard.tenant') ? '租客':'系统'}}权限
                </li>
            </ul>
            <div>
                <form method="post" class="mtb20 base_form layui-form">
                    {!! csrf_field() !!}
                    @if(!empty($permission))
                        <input type="hidden" name="data[id]" value="{!! $permission['id'] ?? '' !!}">
                    @endif
                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>显示名称：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="模块名称" name="data[display_name]" required="" value="{!! $permission['display_name'] ?? '' !!}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>权限名称：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="权限名称" name="data[name]" value="{!! $permission['name'] ?? '' !!}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r">上级模块：</label>
                        <div class="col-xs-4">
                            <select name="data[parent_id]" class="form-control w260">
                                <option level="0" value="0">--请选择--</option>
                                @foreach($modules as $lv)
                                    <option value="{!! $lv['id'] ?? '' !!}"
                                    @if((!empty($permission) && $permission->parent_id == $lv['id']))
                                        selected
                                    @endif
                                    >|{{str_repeat(' -- ',$lv['level'])}}{!! $lv['display_name'] ?? '' !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r">菜单：</label>
                        <div class="col-xs-4">
                            <label class="mr20"><input type="radio" name="data[is_menu]"  @if(!isset($permission['is_menu']) || $permission['is_menu'] == 1) checked @endif value="1">菜单</label>
                            <label class="mr20"><input type="radio" name="data[is_menu]" @if(isset($permission['is_menu']) && $permission['is_menu'] == 0) checked @endif value="0">非菜单</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r">状态：</label>
                        <div class="col-xs-4">
                            <label class="mr20"><input type="radio" name="data[status]"  @if(!isset($permission['status']) || $permission['status'] == 1) checked @endif value="1">正常</label>
                            <label class="mr20"><input type="radio" name="data[status]" @if(isset($permission['status']) && $permission['status'] == 0) checked @endif value="0">停止</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r">图标：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="图标" name="data[icon_class]" value="{{ $permission['icon_class'] ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r">排序：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="0" name="data[sorts]" value="{!! $permission['sorts'] ?? 0 !!}">
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
            app.load('system/develop/permission/create');
        });

    </script>
@stop

