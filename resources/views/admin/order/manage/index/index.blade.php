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
                <a href="{{ url('order/manage/index') }}"><li class="selected">订单列表</li></a>
            </ul>
            <div class="mainbox">
                <div class="form-horizontal goods_nav_search clearfix">
                    <form method="get" name="search">
                        <div class="fl ml10 mr20 pos_rel">
                            <input type="text" name="name" placeholder="订单号/商品名称" class="form-control w260" value="{{request('name')}}">
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
                                <th  style="width: 13%">订单号</th>
                                <th  style="width: 12%">邮箱</th>
                                <th  style="width: 12%">商品名称</th>
                                <th  style="width: 15%">下单时间</th>
                                <th  style="width: 10%">姓名</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($lists as $lv)
                                <tr>
                                    <td>{{$lv['serial'] ?? ' -- '}}</td>
                                    <td>{{$lv['mobile'] ?? ' -- '}}</td>
                                    <td>{{$lv['goods_name'] ?? ' -- '}}</td>
                                    <td>{{$lv['created_at'] ?? ' -- '}}</td>
                                    <td>{{$lv['name'] ?? ' -- '}}</td>
                                </tr>
                            @empty
                                <tr><td colspan="8">暂时没有任何数据</td> </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--tab 切换1 end-->
                @if(!$lists->isEmpty())
                    {!! $lists->appends(request()->all())->render() !!}
                @endif
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