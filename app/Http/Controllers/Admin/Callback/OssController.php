<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/3/31
 * Time: 12:39
 */

namespace App\Http\Controllers\Admin\Callback;

use App\Http\Controllers\Admin\InitController;
use App\Models\System\SysMedia;
use App\Models\User;
use Illuminate\Http\Request;

class OssController extends InitController
{
    public function index(Request $request,User $user = null){
        // 1.获取OSS的签名header和公钥url header
        $authorizationBase64 = "";
        $pubKeyUrlBase64 = "";
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authorizationBase64 = $_SERVER['HTTP_AUTHORIZATION'];
        }
        if (isset($_SERVER['HTTP_X_OSS_PUB_KEY_URL'])) {
            $pubKeyUrlBase64 = $_SERVER['HTTP_X_OSS_PUB_KEY_URL'];
        }
        if ($authorizationBase64 == '' || $pubKeyUrlBase64 == '') {
            header("http/1.1 403 Forbidden");
            exit();
        }

        // 2.获取OSS的签名
        $authorization = base64_decode($authorizationBase64);  //OSS签名

        // 3.获取公钥
        $pubKeyUrl = base64_decode($pubKeyUrlBase64);  //公钥的URL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $pubKeyUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $pubKey = curl_exec($ch);
        if ($pubKey == "") {
            header("http/1.1 403 Forbidden");
            exit();   //header("http/1.1 403 Forbidden");
        }

        // 4.获取回调body,上传的图片的相关信息都在这里
        $body = file_get_contents('php://input');

        // 5.拼接待签名字符串
        $authStr = '';
        $path = $_SERVER['REQUEST_URI'];
        $pos = strpos($path, '?');
        if ($pos === false) {
            $authStr = urldecode($path) . "\n" . $body;
        } else {
            $authStr = urldecode(substr($path, 0, $pos)) . substr($path, $pos, strlen($path) - $pos) . "\n" . $body;
        }

        // 6.验证签名
        $ok = openssl_verify($authStr, $authorization, $pubKey, OPENSSL_ALGO_MD5);
        if ($ok == 1) {
            info($request->all());
            //数据进行保存
            SysMedia::saveBy([
                'tenant_id' => $user->tenant_id ?? 0,
                'user_id' => $user->id ?? 0,
                'title' => $request->viewname ?? '',
                'host' => $request->host ?? '',
                'path' => $request->filename ?? '',
                'size' => $request->size ?? '',
                'type' => SysMedia::MEDIA_TYPE_FILE,
                'parent_id' => $request->parent ?? '',
                'mime_type' => $request->mimeType ?? '',
            ]);
            header("Content-Type: application/json");
            $data = array("Status" => "Ok");
            return response()->json($data);
        } else {
            header("http/1.1 403 Forbidden");
            exit(); //header("http/1.1 403 Forbidden");
        }
    }
}