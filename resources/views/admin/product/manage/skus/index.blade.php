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
                <a href="{{ url('product/manage/goods') }}"><li>课程管理</li></a>
                <a><li class="selected">视频管理</li></a>
                @if(!($model['type'] == 1 && $model->skus->count() > 0))
                <a class="btn btn_r" href="{{ url('product/manage/goods/skus/'.$model['id'].'/create/') }}">+ 添加视频</a>
                @endif
            </ul>
            <div class="mainbox">
                <!--tab 切换1 bengin-->
                <div class="form-horizontal goods_nav_search clearfix">
                    <!--table 列表 bengin-->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th  style="width: 20%">名称</th>
                                <th  style="width: 10%">主讲人</th>
                                <th  style="width: 15%">时长</th>
                                <th  style="width: 10%">支付方式</th>
                                <th  style="width: 20%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($lists as $lv)
                                <tr>
                                    <td>{{$lv['name'] ?? ''}}</td>
                                    <td>{{$lv['teacher'] ?? ''}}</td>
                                    <td>{{$lv['timer_long'] ?? ''}}</td>
                                    <td>{{$lv['pay_name'] ?? ''}}</td>
                                    <td>
                                        <a href="{!! url('product/manage/goods/skus/'.$model['id'].'/create',['id'=>$lv['id']]) !!}">编辑</a>
                                        <a class="do_action" data-confirm="确定要删除吗？" data-url="{!! url('product/manage/goods/skus/delete',['id'=>$lv['id']]) !!}">删除</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7">暂时没有任何数据</td> </tr>
                            @endforelse
                            </tbody>
                        </table>
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
        app.load('product/manage/goods/index');
    });

</script>
@stop