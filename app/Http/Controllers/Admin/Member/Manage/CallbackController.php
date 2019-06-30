<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/6
 * Time: 21:53
 */

namespace App\Http\Controllers\Admin\Member\Manage;

use App\Models\User\UserCallback;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\InitController;

class CallbackController extends InitController
{
    public function __construct()
    {
        $this->template = 'admin.member.manage.callback.';
    }

    public function index(Request $request){

        $lists = UserCallback::orderBy('id','DESC')->paginate(self::PAGESIZE);
        return view( $this->template. __FUNCTION__,compact('lists'));
    }

    public function info(Request $request,UserCallback $model = null){
        return view( $this->template. __FUNCTION__,compact('model'));
    }

}