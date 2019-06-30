<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/6
 * Time: 21:53
 */

namespace App\Http\Controllers\Admin\Member\Manage;

use App\Models\User\UserCallback;
use App\Models\User\UserMessage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\InitController;

class MessageController extends InitController
{
    public function __construct()
    {
        $this->template = 'admin.member.manage.message.';
    }

    public function index(Request $request){

        $lists = UserMessage::orderBy('id','DESC')->paginate(self::PAGESIZE);
        return view( $this->template. __FUNCTION__,compact('lists'));
    }

    public function create(Request $request,UserCallback $model = null){

        UserMessage::saveBy([
            'type' => 3,
            'content' => $request->message,
        ]);

        return $this->success('操作成功',url('member/manage/message'));

    }

}