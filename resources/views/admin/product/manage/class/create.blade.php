@extends('admin.layout.main')
@section('title')-创建/编辑类目@stop
@section('content')
    <div class="content_ch">
        <div class="admin_info clearfix">
            <ul class="nav_pills clearfix">
                <a href="{{ url('product/manage/category') }}"><li>专栏管理</li></a>
                <li class="selected">
                    创建/编辑专栏
                </li>
            </ul>
            <div class="mainbox">
                <form name="profile-form" id="profile-form" method="post" class="mtb20 base_form">
                    @if(!empty($category))
                        <input type="hidden" name="data[id]" value="{!! $category['id'] ?? '' !!}">
                        <input type="hidden" name="data[parent_id]" value="0">
                    @endif

                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r"><span class="red">*</span>专栏名称：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="1-32个字符" name="data[name]" maxlength="32" value="{{$category->name ?? ''}}">
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="col-xs-2 t_r">封面：</label>
                            <div class="col-xs-9">
                                <ul class="multimage-gallery clearfix" id="photo-list">
                                    <li id="image_box" class="my-upload-img">
                                        @if(!empty($category['image']))
                                            <span class="self-add-img">
                            <img src="{{$category['image']}}">
                            <input type="hidden" name="data[image]" value="{{$category['image']}}">
                            <span hidden="" class="img-delete">
                                <i class="icon-shanchu iconfont"></i>
                            </span>
                        </span>
                                        @endif
                                    </li>
                                    <li @if(isset($category['image'])) hidden @endif class="image-upload-add" data-num="1" data-box="image_box" data-item='<span class="self-add-img"><img src=""><input type="hidden" name="data[image]" value=""><span hidden="" class="img-delete"><i class="icon-shanchu iconfont"></i></span></span>'>
                                        <a class="tra_photofile">上传图片</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r">状态：</label>
                        <div class="col-xs-4">
                            <label class="mr20"><input type="radio" name="data[status]"  @if(!isset($category['status']) || $category['status'] == 1) checked @endif value="1">正常</label>
                            <label class="mr20"><input type="radio" name="data[status]" @if(isset($category['status']) && $category['status'] == 2) checked @endif value="2">停止</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 t_r">排序：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="0" name="data[sorts]" value="{!! $category['sorts'] ?? 0 !!}">
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
            app.load('core/upload');
        });

    </script>
@stop