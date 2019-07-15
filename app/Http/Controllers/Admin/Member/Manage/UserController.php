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
use Excel;

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
        })->whereIn('status',[User::USER_STATUS_OPEN,User::USER_STATUS_STOP])->orderBy('id','DESC')->paginate(self::PAGESIZE);

        if($request->excel){
            $lists = User::select('nickname','created_at','integral','avatar','type')->where('type',User::USER_TYPE_MEMBER)->where(function ($query)use($name){
                $name && $query->where('mobile',$name)->orWhere('nickname','like',"%{$name}%");
            })->whereIn('status',[User::USER_STATUS_OPEN,User::USER_STATUS_STOP])->orderBy('id','DESC')->get()->toArray();

            self::export($lists);
        }else{
            return view( $this->template. __FUNCTION__,compact('lists'));
        }
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

    public static function export($cellData){
        ini_set('memory_limit','500M');
        set_time_limit(0);//设置超时限制为0分钟

        Excel::create('测试详情',function($excel) use ($cellData){
            $excel->sheet('detail', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
        die;
    }
}