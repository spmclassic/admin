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
                <a href="{{ url('product/manage/category') }}"><li class="selected">类目管理</li></a>
                <a class="btn btn_r" href="{{ url('product/manage/category/create') }}">+ 创建类目</a>
            </ul>
            <div class="mainbox">
                <div class="form-horizontal goods_nav_search clearfix">
                    <form method="get" name="search">
                        <div class="fl ml10 mr20 pos_rel">
                            <input type="text" name="name" placeholder="名称" class="form-control w260" value="{{request('name')}}">
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
                                <th  style="width: 40%">名称</th>
                                <th  style="width: 5%">排序</th>
                                <th  style="width: 5%">状态</th>
                                <th  style="width: 10%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($lists as $lv)
                                <tr>
                                    <td>{{'|' . str_repeat(' -- ',$lv['level'])}}{{$lv['name'] ?? ''}}</td>
                                    <td>{{$lv['sorts'] ?? ''}}</td>
                                    <td>{{$lv['status'] != 1? '停止':'正常'}}</td>
                                    <td>
                                        <a href="{!! url('product/manage/category/create',['category'=>$lv['id']]) !!}">编辑</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6">暂时没有任何数据</td> </tr>
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