<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/7
 * Time: 16:51
 */

namespace App\Http\Controllers\Admin\Order\Manage;

use App\Http\Controllers\Admin\InitController;
use App\Models\Ord\OrdOrder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Excel;

class IndexController extends InitController
{
    public function __construct()
    {
        $this->template = 'admin.order.manage.index.';
    }

    public function index(Request $request){

        $name = $request->name ?? '';
        $lists = OrdOrder::where(function ($query)use($name){
            $name && $query->where('mobile',$name)->orWhere('serial',$name)->orWhere('goods_name','like',"%{$name}%");
        })->orderBy('id','DESC')->paginate(self::PAGESIZE);

        if($request->excel){
            $lists = OrdOrder::select('serial','goods_name','created_at','price','name')->where(function ($query)use($name){
                $name && $query->where('mobile',$name)->orWhere('serial',$name)->orWhere('goods_name','like',"%{$name}%");
            })->orderBy('id','DESC')->get();

            self::export($lists->toArray());
        }else{
            return view( $this->template. __FUNCTION__,compact('lists'));
        }

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