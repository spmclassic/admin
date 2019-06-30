<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/7
 * Time: 20:30
 */

namespace App\Http\Controllers\Admin\Product\Manage;

use App\Http\Controllers\Admin\InitController;
use App\Models\Gds\GdsComment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CommentController extends InitController
{
    public function __construct()
    {
        $this->template = 'admin.product.manage.comment.';
    }

    public function index(Request $request){
        $lists = GdsComment::paginate(self::PAGESIZE);
        return view( $this->template. __FUNCTION__,compact('lists'));
    }
    public function delete(GdsComment $model = null){
        $model->delete();
        return $this->success('操作成功');
    }

    public function create(Request $request,GdsComment $model = null){

        if($request->isMethod('get')) {
            return view($this->template . __FUNCTION__, compact('model'));
        }

        $data = $request->data;

        $rules = [
            'name' => 'required',
        ];
        $messages = [
            'name.required' => '请输入属性名称',
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), null, true);
        }

        try {
            GdsComment::saveBy($data);
            return $this->success('操作成功',url('product/manage/comment'));
        }catch (\Exception $e) {
            return $this->error('操作异常，请联系开发人员'.$e->getMessage());
        }
    }
}