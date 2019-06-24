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
                <li><a href="{{url('system/develop/role')}}">系统角色</a></li>
                <li><a href="{{url('system/develop/role')}}?guard={{config('app.guard.tenant')}}">租客角色</a></li>
                <li class="selected"><a href="javascript:;">创建/编辑{{request('guard') == config('app.guard.tenant') ? '租客':'系统'}}角色</a></li>
            </ul>
            <div class="mainbox">
                <form name="profile-form" class="base_form" method="post" class="mtb20" >
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>权限名称：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" @if(!empty($model)) readonly @endif  placeholder="权限名称、创建后不能修改" name="data[name]" value="{{$model->name ?? ''}}">
                            <small>注：仅允许以字母开头、破折号(-)以及底线(_)组合 </small>
                            <i>{{$errors->first('name')}} </i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r">选择权限：</label>
                        <table>
                            <tbody>
                            @foreach($modules as $module)
                                <tr class="crole-header module_{{$module['id']}}" data-sign="module_{{$module['id']}}">
                                    <td class="w160 ml20 fl">
                                        <label>
                                            <div class="all-checked fl pr10" style="margin-top:16px;">
                                                <input type="checkbox" value="{!! $module['name'] !!}"
                                                       data-id="{!! $module['id'] !!}"
                                                       data-key="{!! $module['name'] !!}"
                                                       name="permissions[]" @if($model && $model->hasPermissionTo($module['name'],$guard)) checked @endif>
                                                <i class="layui-icon layui-icon-ok"></i>
                                            </div>
                                            <span>{{$module['display_name']}}</span>
                                        </label>
                                    </td>
                                </tr>
                                @foreach($module->node as $second)
                                    <tr class="crole-parent module_{{$module['id']}}" data-sign="module_{{$module['id']}}">
                                        <td class="w160 ml20 fl">
                                            <label>
                                                <div class="all-checked fl pr10" style="margin-top:11px;">
                                                    <input type="checkbox" value="{!! $second['name'] !!}"
                                                           data-id="{!! $second['id'] !!}"
                                                           data-key="{!! $second['name'] !!}"
                                                           name="permissions[]" @if($model && $model->hasPermissionTo($second['name'],$guard)) checked @endif>
                                                    <i class="layui-icon layui-icon-ok"></i>
                                                </div>
                                                <span>{{$module['display_name']}} - {!! $second['display_name'] ?? ''  !!}</span>
                                            </label>
                                        </td>
                                    </tr>
                                    @if(!$second->node->isEmpty())
                                        <tr class="crole-children module_{{$module['id']}}" data-sign="module_{{$module['id']}}">
                                            @foreach($second->node  as $child)
                                                <td class="w160 ml20 fl">
                                                    <label>
                                                        <div class="all-checked fl pr10" style="margin-top:3px;">
                                                            <input type="checkbox" value="{!! $child['name'] !!}"
                                                                   data-id="{!! $child['id'] !!}"
                                                                   data-key="{!! $child['name'] !!}"
                                                                   name="permissions[]" @if($model && $model->hasPermissionTo($child['name'],$guard)) checked @endif>
                                                            <i class="layui-icon layui-icon-ok"></i>
                                                        </div>
                                                        {!! $child['display_name'] !!}
                                                    </label>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r">&nbsp;</label>
                        <div class="col-xs-8">
                            <input type="submit" class="btn w80" value="确定">
                            <input type="input" class="btn btn_white w80" value="取消" onclick="javascript:window.location.href='{{ url('system/maintain/role') }}'">
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
            app.load('system/develop/role/create');
        });

    </script>
@stop