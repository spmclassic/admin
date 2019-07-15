<?php

namespace App\Http\Controllers\Admin\Product\Manage;


use App\Http\Controllers\Admin\InitController;
use App\Models\Gds\GdsGood;
use App\Models\Gds\GdsComment;
use App\Models\System\SysCategory;
use App\Models\System\SysCate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GoodsController extends InitController
{
    public function __construct()
    {
        $this->template = 'admin.product.manage.goods.';
    }

    public function delete(GdsGood $model = null){

        $model->skus()->delete();
        $model->delete();
        return $this->success('操作成功');
    }

    public function index(Request $request){

        $name = $request->name ?? '';
        $lists = GdsGood::where(function ($query) use ($name){
            $name && $query->where('name','like',"%$name%")->orWhere('teacher',$name);
        })->orderBy('sorts','DESC')->paginate(self::PAGESIZE);
        return view( $this->template. __FUNCTION__,compact('lists'));
    }

    public function create(Request $request,GdsGood $model = null){
        if($request->isMethod('get')) {
            $categories = SysCategory::getCategorys(SysCategory::TYPE_PRODUCT,SysCategory::STATUS_OK)->mergeTree('node');
            $shuxing = GdsComment::all();
            return view($this->template . __FUNCTION__, compact('model','categories','shuxing'));
        }

        $data = $request->data;

        $rules = [
            'name' => 'required|unique:gds_goods,name,'.($model['id'] ?? 'NULL').',id',
            'category_id' => 'required',
        ];
        $messages = [
            'name.required' => '请输入名称',
            'name.unique' => '名称已存在',
            'category_id.required' => '请选择分类',
        ];

        if($model){
            unset($rules['category_id']);
        }

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), null, true);
        }

        try {

            GdsGood::saveBy($data);
            return $this->success('操作成功',url('product/manage/goods'));
        }catch (\Exception $e) {
            return $this->error('操作异常，请联系开发人员'.$e->getMessage());
        }
    }
}