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
        })->paginate(self::PAGESIZE);
        return view( $this->template. __FUNCTION__,compact('lists'));
    }
}