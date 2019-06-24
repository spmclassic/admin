<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/3/31
 * Time: 10:19
 */

namespace App\Http\Controllers\Admin\System\Alert;

use App\Http\Controllers\Admin\InitController;
use App\Models\System\SysMedia;
use Illuminate\Http\Request;

class OssController extends InitController
{

    public function __construct(Request $request)
    {
        $this->template = 'admin.system.alert.oss.';
    }

    public function index(Request $request){
        $parent = SysMedia::find($request->parent ?? 0);
        return view( $this->template. __FUNCTION__,compact('parent'));
    }

    public function file(Request $request,$parent = 0){
        return SysMedia::where([
            'parent_id' => $parent
        ])->orderBy('type','ASC')->orderBy('id','DESC')->paginate(self::PAGESIZE);
    }

    public function mkdir(Request $request){
        $user = \Auth::user();
        SysMedia::saveBy([
            'tenant_id' => $user->tenant_id ?? 0,
            'user_id' => $user->id ?? 0,
            'title' => $request->viewname ?? '',
            'type' => SysMedia::MEDIA_TYPE_DIR,
            'parent_id' => $request->parent ?? '',
        ]);

        return $this->success('添加成功');
    }

    public function auth(Request $request){
        $id= 'LTAIJi8dX86LKtBG';
        $key= 'OMGo8jURX98RhLayhv2BxkN2xPuY5b';
        $host = 'https://zhongtuizaixian.oss-cn-beijing.aliyuncs.com/';
        $callbackurl = 'http://admin.zhongyi108.com/callback/oss/'.\Auth::user()->id ?? 0;

        $now = time();
        $expire = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = $this->gmt_iso8601($end);

        $dir = date('Ym/d').'/';

        //最大文件大小.用户可以自己设置
        $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
        $conditions[] = $condition;

        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
        $conditions[] = $start;

        $arr = array('expiration'=>$expiration,'conditions'=>$conditions);

        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

        $response = array();
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['callbackurl'] = $callbackurl;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;
        echo json_encode($response);
    }
    public function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }
}