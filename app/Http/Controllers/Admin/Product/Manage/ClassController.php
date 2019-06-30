<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/3/24
 * Time: 22:21
 */

namespace App\Http\Controllers\Admin\Product\Manage;

use App\Http\Controllers\Admin\InitController;
use Illuminate\Support\Facades\Validator;
use App\Models\System\SysCate;
use Illuminate\Http\Request;

class ClassController extends InitController
{
    public function __construct()
    {
        $this->template = 'admin.product.manage.class.';
    }

    public function index(Request $request){

        $lists = SysCate::getCategorys(SysCate::TYPE_PRODUCT)->mergeTree('node');
        return view( $this->template. __FUNCTION__,compact('lists'));
    }

    public function create(Request $request,SysCate $category = null){

        if($request->isMethod('get')) {
            $categories = SysCate::getCategorys(SysCate::TYPE_PRODUCT,SysCate::STATUS_OK)->mergeTree('node');
            return view($this->template . __FUNCTION__, compact('category','categories'));
        }

        $data = $request->data;

        $rules = [
            'name' => 'required|unique:sys_cates,name,'.($category['id'] ?? 'NULL').',id',
        ];
        $messages = [
            'name.required' => '请输入分类名称',
            'name.unique' => '分类已存在',
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), null, true);
        }

        try {
            $category || $data = array_merge([
                'type' => SysCate::TYPE_PRODUCT,
            ],$data);
            SysCate::saveBy($data);
            return $this->success('操作成功',url('product/manage/class'));
        }catch (\Exception $e) {
            return $this->error('操作异常，请联系开发人员'.$e->getMessage());
        }
    }
}