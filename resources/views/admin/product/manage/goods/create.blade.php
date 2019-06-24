@extends('admin.layout.main')
@section('title')-创建/编辑类目@stop
@section('content')
    <div class="content_ch">
        <div class="admin_info clearfix">
            <ul class="nav_pills clearfix">
                <a href="{{ url('product/manage/goods') }}"><li>课程管理</li></a>
                <li class="selected">
                    创建/编辑课程
                </li>
            </ul>
            <div class="mainbox">
                <form name="profile-form" id="profile-form" method="post" class="mtb20 base_form">
                    @if(!empty($model))
                        <input type="hidden" name="data[id]" value="{!! $model['id'] ?? '' !!}">
                    @endif
                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>课程类型：</label>
                        <div class="col-xs-4">
                            <label class="mr20"><input type="radio" @if(!empty($model['id'])) disabled="disabled" @endif name="data[type]"  @if(!isset($model['type']) || $model['type'] == 1) checked @endif value="1">单课程</label>
                            <label class="mr20"><input type="radio" @if(!empty($model['id'])) disabled="disabled" @endif name="data[type]" @if(isset($model['type']) && $model['type'] == 2) checked @endif value="2">系列课程</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 t_r"><span class="red">*</span>所属类目：</label>
                        <div class="col-xs-8">
                            <select name="data[category_id]" class="select-change-style w160" @if(!empty($model['id'])) disabled="disabled" @endif >
                                <option value="0">---请选择----</option>
                                @foreach($categories as $item)
                                    <option value="{{$item['id']}}" @if($model['category_id'] == $item['id']) selected @endif >{{'|' . str_repeat(' -- ',$item['level'])}}{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-2 t_r">封面：</label>
                        <div class="col-xs-9">
                            <ul class="multimage-gallery clearfix" id="photo-list">
                                <li id="image_box" class="my-upload-img">
                                    @if(!empty($model['image']))
                                            <span class="self-add-img">
                            <img src="{{$model['image']}}">
                            <input type="hidden" name="data[image]" value="{{$model['image']}}">
                            <span hidden="" class="img-delete">
                                <i class="icon-shanchu iconfont"></i>
                            </span>
                        </span>
                                    @endif
                                </li>
                                <li @if(isset($model['image'])) hidden @endif class="image-upload-add" data-num="1" data-box="image_box" data-item='<span class="self-add-img"><img src=""><input type="hidden" name="data[image]" value=""><span hidden="" class="img-delete"><i class="icon-shanchu iconfont"></i></span></span>'>
                                    <a class="tra_photofile">上传图片</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r"><span class="red">*</span>课程名称：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="1-32个字符" name="data[name]" maxlength="32" value="{{$model->name ?? ''}}">
                        </div>
                    </div>

                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r"><span class="red">*</span>主讲人：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="1-32个字符" name="data[teacher]" maxlength="32" value="{{$model->teacher ?? ''}}">
                        </div>
                    </div>

                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r"><span class="red">*</span>价格：</label>
                        <div class="col-xs-4">
                            <input type="number" min="0" max="100000000" step="0.01" class="form-control" placeholder="单位元" name="data[price]" value="{{$model->price ?? ''}}">
                        </div>
                    </div>

                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r">视频时长：</label>
                        <div class="col-xs-4">
                            <input type="number" class="form-control" placeholder="单位秒" name="data[timer]" maxlength="32" value="{{$model->timer ?? ''}}">
                        </div>
                    </div>

                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r">视频介绍：</label>
                        <div class="col-xs-4">
                            <textarea class="form-control" name="data[intro]">{{$model->intro ?? ''}}</textarea>
                        </div>
                    </div>

                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r">排序：</label>
                        <div class="col-xs-4">
                            <input type="number" class="form-control" placeholder="越大越排前" name="data[sorts]" value="{{$model->sorts ?? ''}}">
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
                        <label class="col-xs-2 t_r">支付方式：</label>
                        <div class="col-xs-4">
                            <label class="mr20"><input type="radio" name="data[pay]"  @if(!isset($model['pay']) || $model['pay'] == 1) checked @endif value="1">免费</label>
                            <label class="mr20"><input type="radio" name="data[pay]" @if(isset($model['pay']) && $model['pay'] == 2) checked @endif value="2">微信支付</label>
                            <label class="mr20"><input type="radio" name="data[pay]" @if(isset($model['pay']) && $model['pay'] == 3) checked @endif value="3">积分支付</label>
                        </div>
                    </div>
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