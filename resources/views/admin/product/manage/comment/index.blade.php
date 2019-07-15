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
                <a href="{{ url('product/manage/comment') }}"><li class="selected">属性列表</li></a>
                <a class="btn btn_r" href="{{ url('product/manage/comment/create') }}">+ 创建属性</a>
            </ul>
            <div class="mainbox">

                <!--tab 切换1 bengin-->
                <div class="form-horizontal goods_nav_search clearfix">
                    <!--table 列表 bengin-->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th  style="width: 60%">名称</th>
                                <th  style="width: 20%">排序</th>
                                <th  style="width: 20%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($lists as $lv)
                                <tr>
                                    <td>{{$lv->name ?? ''}}</td>
                                    <td>{{$lv->sorts ?? 0}}</td>
                                    <td>
                                        <a href="{!! url('product/manage/comment/create',['id'=>$lv['id']]) !!}">编辑</a>
                                        <a class="do_action" data-confirm="确定要删除吗？" data-url="{!! url('product/manage/comment/delete',['id'=>$lv['id']]) !!}">删除</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3">暂时没有任何数据</td> </tr>
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
    });

</script>
@stop