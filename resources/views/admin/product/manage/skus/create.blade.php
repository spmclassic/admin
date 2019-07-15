@extends('admin.layout.main')
@section('title')-创建/编辑视频@stop
@section('content')
    <div class="content_ch">
        <div class="admin_info clearfix">
            <ul class="nav_pills clearfix">
                <a href="{{ url('product/manage/goods') }}"><li>课程管理</li></a>
                <a href="{{ url('product/manage/goods/skus/'.$model['id']) }}"><li>视频管理</li></a>
                <li class="selected">
                    创建/编辑视频
                </li>
            </ul>
            <div class="mainbox">
                <form name="profile-form" id="profile-form" method="post" class="mtb20 base_form">
                    @if(!empty($sku))
                        <input type="hidden" name="data[id]" value="{!! $sku['id'] ?? '' !!}">
                    @endif

                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r"><span class="red">*</span>视频名称：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="1-32个字符" name="data[name]" maxlength="32" value="{{$sku->name ?? $model->name ?? ''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 t_r">封面：</label>
                        <div class="col-xs-9">
                            <ul class="multimage-gallery clearfix" id="photo-list">
                                <li id="image_box" class="my-upload-img">
                                    @if(!empty($sku['image']))
                                        <span class="self-add-img">
                        <img src="{{$sku['image']}}">
                        <input type="hidden" name="data[image]" value="{{$sku['image']}}">
                        <span hidden="" class="img-delete">
                            <i class="icon-shanchu iconfont"></i>
                        </span>
                    </span>
                                    @endif
                                </li>
                                <li @if(isset($sku['image'])) hidden @endif class="image-upload-add" data-num="1" data-box="image_box" data-item='<span class="self-add-img"><img src=""><input type="hidden" name="data[image]" value=""><span hidden="" class="img-delete"><i class="icon-shanchu iconfont"></i></span></span>'>
                                    <a class="tra_photofile">上传图片</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r"><span class="red">*</span>主讲人：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="1-32个字符" name="data[teacher]" maxlength="32" value="{{$sku->teacher ?? $model->teacher ?? ''}}">
                        </div>
                    </div>

                    {{--<div class="form-group category-msg-l1">--}}
                        {{--<label class="col-xs-2 t_r"><span class="red">*</span>价格：</label>--}}
                        {{--<div class="col-xs-4">--}}
                            {{--<input type="number" min="0" max="100000000" step="0.01" class="form-control" placeholder="单位元" name="data[price]" value="{{$sku->price ?? ''}}">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r">视频时长：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="单位秒" name="data[timer]" maxlength="32" value="{{$sku->timer ?? ''}}">
                        </div>
                    </div>

                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r">视频介绍：</label>
                        <div class="col-xs-4">
                            <textarea class="form-control" name="data[intro]">{{$sku->intro ?? ''}}</textarea>
                        </div>
                    </div>

                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r">排序：</label>
                        <div class="col-xs-4">
                            <input type="number" class="form-control" placeholder="越大越排前" name="data[sorts]" value="{{$sku->sorts ?? ''}}">
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="col-xs-2 t_r"></label>
                    <div class="form-group">
                    <label class="col-xs-2 t_r">视频：</label>
                    <div class="col-xs-9">
                    <ul class="multimage-gallery clearfix" id="photo-list">
                    <li id="image_box" class="my-upload-img">
                        @if(isset($sku->url))
                            <span class="self-add-img">
                                <img src="{{$sku->url}}">
                                <input type="hidden" name="data[url]" value="{{$sku->url}}">
                                <span hidden="" class="img-delete"><i class="icon-shanchu iconfont"></i></span>
                            </span>
                        @endif
                    </li>
                    <li @if(isset($sku->url)) hidden @endif class="image-upload-add" data-num="1" data-box="image_box" data-item='<span class="self-add-img"><img src=""><input type="hidden" name="data[url]" value=""><span hidden="" class="img-delete"><i class="icon-shanchu iconfont"></i></span></span>'>
                    <a class="tra_photofile">上传视频</a>
                    </li>
                    </ul>
                    </div>
                    </div>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label class="col-xs-2 t_r">支付方式：</label>--}}
                        {{--<div class="col-xs-4">--}}
                            {{--<label class="mr20"><input type="checkbox" name="data[pay]"  @if($sku['pay'] == 1) checked @endif value="1">免费</label>--}}
                         {{--</div>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label class="col-xs-2 t_r">&nbsp;</label>
                        <div class="col-xs-8">
                            <input type="submit" class="btn" value="保存">
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
            app.load('core/upload');
        });

    </script>
@stop