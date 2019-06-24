<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/6
 * Time: 22:42
 */

namespace App\Http\Controllers\Admin\System\Base;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\InitController;

class BannerController extends InitController
{
    public function __construct()
    {
        $this->template = 'admin.system.base.banner.';
    }

    public function index(Request $request){

        if($request->isMethod('get')) {
            $conf = @file_get_contents('banner.txt');
            $model = $conf ? json_decode($conf,true):[];
            return view( $this->template. __FUNCTION__,compact('model'));
        }
        $data = $request->data;
        file_put_contents('banner.txt',json_encode($data));

        return $this->success('设置成功');
    }

    public function poster(Request $request){
        if($request->isMethod('get')) {
            $conf = @file_get_contents('poster.txt');
            $model = $conf ? json_decode($conf,true):[];
            return view( $this->template. __FUNCTION__,compact('model'));
        }
        $data = $request->data;
        file_put_contents('poster.txt',json_encode($data));

        return $this->success('设置成功');
    }
}