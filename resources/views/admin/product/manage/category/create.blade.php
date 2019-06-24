@extends('admin.layout.main')
@section('title')-创建/编辑类目@stop
@section('content')
    <div class="content_ch">
        <div class="admin_info clearfix">
            <ul class="nav_pills clearfix">
                <a href="{{ url('product/manage/category') }}"><li>类目管理</li></a>
                <li class="selected">
                    创建/编辑类目
                </li>
            </ul>
            <div class="mainbox">
                <form name="profile-form" id="profile-form" method="post" class="mtb20 base_form">
                    @if(!empty($category))
                        <input type="hidden" name="data[id]" value="{!! $category['id'] ?? '' !!}">
                    @endif
                    <div class="form-group">
                        <label class="col-xs-2 t_r">上级类目：</label>
                        <div class="col-xs-8">
                            <select name="data[parent_id]" class="select-change-style w160" @if(!empty($category['id'])) disabled="disabled" @endif >
                            <option value="0">---请选择----</option>
                            @foreach($categories as $item)
                                <option value="{{$item['id']}}" @if($category['parent_id'] == $item['id']) selected @endif >{{'|' . str_repeat(' -- ',$item['level'])}}{{$item['name']}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r"><span class="red">*</span>类目名称：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="1-32个字符" name="data[name]" maxlength="32" value="{{$category->name ?? ''}}">
                        </div>
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label class="col-xs-2 t_r"></label>--}}
                        {{--<div class="form-group">--}}
                            {{--<label class="col-xs-2 t_r">类目图片：</label>--}}
                            {{--<div class="col-xs-9">--}}
                                {{--<ul class="multimage-gallery clearfix" id="photo-list">--}}
                                    {{--<li id="image_box" class="my-upload-img">--}}
                                    {{--</li>--}}
                                    {{--<li class="image-upload-add" data-num="1" data-box="image_box" data-item='<span class="self-add-img"><img src=""><input type="hidden" name="data[image]" value=""><span hidden="" class="img-delete"><i class="icon-shanchu iconfont"></i></span></span>'>--}}
                                        {{--<a class="tra_photofile">上传图片</a>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                                {{--<p class="fgray">最多五张，第一张为赠品主图，建议尺寸：800*800 像素</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
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