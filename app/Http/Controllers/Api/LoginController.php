<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Resources\User as UserResource;
use App\Services\IntegralService;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends InitController{

    public function __construct(IntegralService $integralService = null)
    {
        $this->integralService = $integralService;
    }

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function login(Request $request)
    {

//        $appid = 'wxf8d08695c2d862f4'; //填写微信小程序appid
//        $secret = 'ea09ddae2a1b1bf743766455181f89ae'; //填写微信小程序secret


        $appid = 'wx1c7c48b523714138'; //填写微信小程序appid  正式服
        $secret = '3ae529b648adbe027bda06cec84d061a'; //填写微信小程序secret

        $code = $request->code ?? '';

        $wJson = json_decode(file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$code&grant_type=authorization_code"),true);

        if(!isset($wJson['openid'])){
            return $this->error('openid error', 404);
        }

        $user = User::firstOrCreate(['openid' => $wJson['openid']], [
            'type' => User::USER_TYPE_MEMBER
        ]);
        $token = \JWTAuth::fromUser($user);

        return $this->respondWithToken($token,$wJson['openid']);
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    public function sign(){
        $user = $this->guard()->user();
        try{
            DB::beginTransaction();

            $this->integralService->sign($user);

            DB::commit();
            return $this->success('success',null,[
                'issign' => 1
            ]);
        }catch (\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage());
        }

    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userinfo()
    {
        $user = $this->guard()->user();

        return $this->success('success',null,[
            'user' => new UserResource($user),
            'issign' => User\UserIntegralLog::where([
                ['type','=',User\UserIntegralLog::TYPE_SIGN_IN],
                ['user_id','=',$user->id],
                ['created_at','>',date('Y-m-d 00:00:00')],
            ])->first() ? 1 : 0,
        ]);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return $this->success('Successfully logged out');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$openid = null)
    {
        return $this->success('success',null,[
            'access_token' => $token,
            'openid' => $openid,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard(config('app.guard.api'));
    }
}