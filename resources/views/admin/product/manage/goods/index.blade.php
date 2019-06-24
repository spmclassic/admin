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
                <a href="{{ url('product/manage/goods') }}"><li class="selected">课程管理</li></a>
                <a class="btn btn_r" href="{{ url('product/manage/goods/create') }}">+ 创建课程</a>
            </ul>
            <div class="mainbox">
                <div class="form-horizontal goods_nav_search clearfix">
                    <form method="get" name="search">
                        <div class="fl ml10 mr20 pos_rel">
                            <input type="text" name="name" placeholder="名称/主讲人" class="form-control w260" value="{{request('name')}}">
                        </div>
                        <input type="submit" value="搜索" class="fl btn ml10 js_submit">
                    </form>
                </div>
                <!--tab 切换1 bengin-->
                <div class="form-horizontal goods_nav_search clearfix">
                    <!--table 列表 bengin-->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th  style="width: 8%">ID</th>
                                <th  style="width: 22%">名称</th>
                                <th  style="width: 10%">主讲人</th>
                                <th  style="width: 10%">时长</th>
                                <th  style="width: 10%">价格</th>
                                <th  style="width: 10%">支付方式</th>
                                <th  style="width: 15%">所属分类</th>
                                <th  style="width: 15%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($lists as $lv)
                                <tr>
                                    <td>{{$lv['id'] ?? ''}}</td>
                                    <td>{{$lv['name'] ?? ''}}</td>
                                    <td>{{$lv['teacher'] ?? ''}}</td>
                                    <td>{{$lv['timer_long'] ?? ''}}</td>
                                    <td>{{$lv['price'] ?? ''}}</td>
                                    <td>{{$lv['pay_name'] ?? ''}}</td>
                                    <td>{{$lv['category']['name'] ?? ''}}</td>
                                    <td>
                                        <a class="red" href="{!! url('product/manage/goods/skus',['id'=>$lv['id']]) !!}">视频管理</a>
                                        <a href="{!! url('product/manage/goods/create',['id'=>$lv['id']]) !!}">编辑</a>
                                        <a class="do_action" data-confirm="确定要删除吗？" data-url="{!! url('product/manage/goods/delete',['id'=>$lv['id']]) !!}">删除</a>
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