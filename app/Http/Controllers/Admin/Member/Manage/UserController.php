<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/6
 * Time: 7:52
 */

namespace App\Http\Controllers\Admin\Member\Manage;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\InitController;

class UserController extends InitController
{
    public function __construct()
    {
        $this->template = 'admin.member.manage.user.';
    }

    public function index(Request $request){

        $name = $request->name ?? '';
        $lists = User::where('type',User::USER_TYPE_MEMBER)->where(function ($query)use($name){
            $name && $query->where('mobile',$name)->orWhere('nickname','like',"%{$name}%");
        })->whereIn('status',[User::USER_STATUS_OPEN,User::USER_STATUS_STOP])->paginate(self::PAGESIZE);
        return view( $this->template. __FUNCTION__,compact('lists'));
    }

    public function operate(Request $request,$operate = null,User $model = null){

        if($operate == 'close'){
            $model->status = User::USER_STATUS_STOP;
            $model->save();
        }else if($operate == 'open'){
            $model->status = User::USER_STATUS_OPEN;
            $model->save();
        }else if($operate == 'remove'){
            $model->status = User::USER_STATUS_DELETE;
            $model->save();
        }else{
            return $this->error('无效请求');
        }
        return $this->success('操作成功');
    }
}