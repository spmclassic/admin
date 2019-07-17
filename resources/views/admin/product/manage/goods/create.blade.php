@extends('admin.layout.main')
@section('title')-创建/编辑@stop
@section('content')
    <div class="content_ch">
        <div class="admin_info clearfix">
            <ul class="nav_pills clearfix">
                <a href="{{ url('product/manage/goods') }}"><li>商品管理</li></a>
                <li class="selected">
                    创建/编辑商品
                </li>
            </ul>
            <div class="mainbox">
                <form name="profile-form" id="profile-form" method="post" class="mtb20 base_form">
                    @if(!empty($model))
                        <input type="hidden" name="data[id]" value="{!! $model['id'] ?? '' !!}">
                    @endif

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
                        <label class="col-xs-2 t_r"><span class="red">*</span>Description：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="1-32个字符" name="data[name]" maxlength="32" value="{{$model->name ?? ''}}">
                        </div>
                    </div>

                    @foreach($shuxing as $val)
                    <div class="form-group category-msg-l1">
                        <label class="col-xs-2 t_r"><span class="red">*</span>{{$val['name'] ?? ''}}：</label>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder="1-32个字符" name="data[intro]['{{$val['id']}}']" value="{{$model->intro["'".$val['id']."'"] ?? ''}}">
                        </div>
                    </div>
                    @endforeach

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