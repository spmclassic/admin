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
                <a href="{{ url('product/manage/category') }}"><li class="selected">评论列表</li></a>
            </ul>
            <div class="mainbox">

                <!--tab 切换1 bengin-->
                <div class="form-horizontal goods_nav_search clearfix">
                    <!--table 列表 bengin-->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th  style="width: 30%">名称</th>
                                <th  style="width: 40%">内容</th>
                                <th  style="width: 20%">用户</th>
                                <th  style="width: 10%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($lists as $lv)
                                <tr>
                                    <td>{{$lv->goods->name ?? ''}}</td>
                                    <td>{{$lv->content ?? ''}}</td>
                                    <td>{{$lv->user->nickname ?? ''}}</td>
                                    <td>
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