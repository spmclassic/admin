<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/7
 * Time: 12:47
 */

namespace App\Http\Controllers\Admin\Product\Manage;

use App\Http\Controllers\Admin\InitController;
use App\Models\Gds\GdsGood;
use App\Models\Gds\GdsSku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkusController extends InitController
{
    public function __construct()
    {
        $this->template = 'admin.product.manage.skus.';
    }
    public function index(Request $request,GdsGood $model = null){

        $lists = $model->skus;
        return view( $this->template. __FUNCTION__,compact('lists','model'));
    }

    public function delete(GdsSku $sku = null){
        $sku->delete();
        return $this->success('操作成功');
    }

    public function create(Request $request,GdsGood $model = null,GdsSku $sku = null){

        if($request->isMethod('get')) {
            return view( $this->template. __FUNCTION__,compact('model','sku'));
        }

        $data = $request->data;

        $rules = [
            'name' => 'required',
            'teacher' => 'required',
            'timer' => 'required',
            'url' => 'required',
        ];
        $messages = [
            'name.required' => '请输入名称',
            'name.unique' => '名称已存在',
            'timer.required' => '请填写视频时长',
            'url.required' => '请选择视频',
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), null, true);
        }
        $data['intro'] || $data['intro'] = '';
        $data['timer'] || $data['timer'] = 100;
        $data['sorts'] || $data['sorts'] = 0;
        try {
            $data['goods_id'] = $model['id'];
            $data['pay'] = $data['pay'] ?? $model['pay'];
            GdsSku::saveBy($data);
            return $this->success('操作成功',url('product/manage/goods/skus/'.$model['id']));
        }catch (\Exception $e) {
            return $this->error('操作异常，请联系开发人员'.$e->getMessage());
        }
    }
}