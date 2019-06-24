<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/6
 * Time: 11:35
 */

namespace App\Http\Controllers\Admin\System\Base;

use App\Http\Controllers\Admin\InitController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ScoreController extends InitController
{
    public function __construct()
    {
        $this->template = 'admin.system.base.score.';
    }

    public function index(Request $request){

        if($request->isMethod('get')) {
            $conf = @file_get_contents('score.txt');
            $model = $conf ? json_decode($conf,true):[];
            return view( $this->template. __FUNCTION__,compact('model'));
        }
        $data = $request->data;
        file_put_contents('score.txt',json_encode($data));

        return $this->success('设置成功');
    }
}