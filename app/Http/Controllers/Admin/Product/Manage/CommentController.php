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
}