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
                <a><li class="selected">用户反馈</li></a>
            </ul>
            <div class="mainbox">
                <!--tab 切换1 bengin-->
                <div class="form-horizontal goods_nav_search clearfix">
                    <!--table 列表 bengin-->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th  style="width: 8%">ID</th>
                                <th  style="width: 15%">邮箱</th>
                                <th  style="width: 12%">备注历史</th>
                                <th  style="width: 15%">最近下单时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($lists as $lv)
                                <tr>
                                    <td>{{$lv['id'] ?? ' -- '}}</td>
                                    <td>{{$lv['name'] ?? ' -- '}}</td>
                                    <td>{{$lv['content'] ?? ' -- '}}</td>
                                    <td>{{$lv['created_at']}}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6">暂时没有任何数据</td> </tr>
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