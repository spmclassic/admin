@extends('admin.layout.main')
@section('title')
    -Premission
@stop
@section('content')

    <div class="content_ch">

        <!--内容区 bengin-->
        <div class="admin_info clearfix">
            <!--right bengin-->
            <ul class="nav_pills mb10 clearfix">
                <li class="selected">积分设置</li>
            </ul>
            <div class="mainbox">
                <form name="profile-form" class="base_form layui-form" method="post" class="mtb20" >


                    <div class="form-group">
                    <label class="col-xs-2 t_r"></label>
                    <div class="form-group">
                    <label class="col-xs-2 t_r">图片：</label>
                    <div class="col-xs-9">
                    <ul class="multimage-gallery clearfix" id="photo-list" style="margin-bottom: 50px;">
                    <li id="image_box" class="my-upload-img">
                        @if(!empty($model['image']))
                        @foreach($model['image'] as $key => $item)
                            <span class="self-add-img">
                                <img src="{{$item}}">
                                <input type="hidden" name="data[image][]" value="{{$item}}">
                                <span hidden="" class="img-delete">
                                    <i class="icon-shanchu iconfont"></i>
                                </span>
                                <div style="position: absolute; width: 100%;height: 30px; line-height: 30px; bottom: -35px;"><input name="data[urlid][]" style="width: 80%; text-align: center; color: #999; display: block; margin: 0 auto;" placeholder="跳转课程ID" value="{{$model['urlid'][$key]}}" /></div>
                            </span>
                        @endforeach
                        @endif
                    </li>
                    <li @if(isset($model['image']) && count($model['image']) >= 4) hidden @endif class="image-upload-add" data-num="4" data-box="image_box" data-item='<span class="self-add-img"><img src=""><input type="hidden" name="data[image][]" value=""><span hidden="" class="img-delete"><i class="icon-shanchu iconfont"></i></span><div style="position: absolute; width: 100%;height: 30px; line-height: 30px; bottom: -35px;"><input name="data[urlid][]" style="width: 80%; center; color: #999; display: block; margin: 0 auto;" placeholder="跳转课程ID" /></div></span>'>
                    <a class="tra_photofile">上传图片</a>
                    </li>
                    </ul>
                        <p class="fgray">最多五张。<a style="color: red;" target="_blank" href="/product/manage/goods">查看课程ID</a></p>
                    </div>
                    </div>
                    </div>


                    <div class="form-group">
                        <label class="col-xs-2 t_r">&nbsp;</label>
                        <div class="col-xs-8">
                            <input type="submit" class="btn w80" value="确定">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--内容区 end-->

    </div>

@stop
@section('script')
    <script>
        var __seajs_debug = 1;
        seajs.use("/admin/js/app.js", function (app) {
            app.bootstrap();
            app.load('core/upload');
            app.load('system/base/banner/index');
        });

    </script>
@stop