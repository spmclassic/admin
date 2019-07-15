<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/7
 * Time: 21:36
 */

namespace App\Http\Controllers\Api;


use App\Models\Gds\GdsComment;
use App\Models\Gds\GdsGood;
use App\Models\Gds\GdsSku;
use App\Models\Gds\GdsZan;
use App\Models\Ord\OrdOrder;
use App\Models\Ord\OrdOrderItem;
use App\Models\User\UserCallback;
use App\Models\User\UserMessage;
use App\Models\User\UserShare;
use App\Services\PayService;
use Illuminate\Http\Request;
use App\Models\System\SysCategory;
use App\Models\System\SysCate;
use App\Models\User\UserIntegralLog;
use App\Resources\Gds\GdsGood as GdsGoodRescource;
use App\Resources\Gds\GdsSku as GdsSkuRescource;
use App\Resources\System\SysCategory as SysCategoryRescource;
use App\Resources\System\SysCate as SysCateRescource;
use App\Resources\User as UserResource;
use Illuminate\Support\Facades\Validator;
use App\Resources\User\UserMessage as UserMessageRescource;
use Illuminate\Support\Facades\DB;

class IndexController extends InitController
{
    public function __construct(
        PayService $payService
    )
    {
        $this->payService = $payService;
    }

    public function basket(Request $request){
        $data = $request->all();
        $goods = [];
        foreach ($data as $key => $val){
            if($val > 0 && $good = GdsGood::find($key)){
                $good->number = $val;
                $goods[] = $good;
            }
        }
        return $this->success('提交成功','null',$goods);

    }

    public function comment(Request $request){
        $data = [
            'content' => $request->content,
            'goodsid' => $request->goodsid,
            'backid' => $request->backid,
        ];

        $rules = [
            'content' => 'required',
            'goodsid' => 'required',
        ];
        $messages = [
            'content.required' => '请输入评论',
            'goodsid.required' => '缺少ID',
        ];
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), null, true);
        }
        $user = \Auth::user();

        GdsComment::saveBy([
            'user_id' => $user->id ?? 0,
            'order_id' => $data['backid'] ?? 0,
            'spu_id' => $data['goodsid'],
            'content' => $data['content'],
        ]);


        return $this->success('提交成功');
    }

    public function index(){

        $data = ['email'=>'89340545@qq.com', 'name'=>'duanzhiwei', 'uid'=>1, 'activationcode'=>1234];
        $res = \Mail::send('activemail', $data, function($message) use($data)
        {
            $message->to($data['email'], $data['name'])->subject('欢迎注册我们的网站，请激活您的账号！');
        });
dd($res);
        $conf = @file_get_contents('banner.txt');
        $banner = $conf ? json_decode($conf,true):[];

        return $this->success('success',null,[
            'banner' => $banner,
            'hot' => GdsGoodRescource::collection(GdsGood::whereHas('skus')->orderBy('is_hot','DESC')->take(2)->get()),
            'new' => GdsGoodRescource::collection(GdsGood::whereHas('skus')->orderBy('id','DESC')->take(4)->get()),
            'version' => 1,
            'join' => [
                [
                    'id' => 1,
                    'name' => '5.15公司台球比赛',
                    'date' => '5.15 - 5.18',
                    'teacher' => '组织人:彭勇',
                    'number' => '成功申报:12',
                    'type_name' => '已结束',
                    'cover' => 'https://zhongtuizaixian.oss-cn-beijing.aliyuncs.com/201906/16/ZXBnPYNEAc.jpg',
                ],
                [
                    'id' => 2,
                    'name' => '6.23公司礼仪培训',
                    'date' => '6.23 - 6.23',
                    'teacher' => '组织人:彭勇',
                    'number' => '成功申报:1',
                    'type_name' => '进行中',
                    'cover' => 'https://zhongtuizaixian.oss-cn-beijing.aliyuncs.com/201906/16/TkyMCT6HPB.jpg',
                ],
                [
                    'id' => 3,
                    'name' => '7.10公司篮球比赛',
                    'date' => '7.10 - 7.10',
                    'teacher' => '组织人:彭勇',
                    'number' => '成功申报:6',
                    'type_name' => '未开始',
                    'cover' => 'https://zhongtuizaixian.oss-cn-beijing.aliyuncs.com/201906/16/bWsExMGWKJ.jpg',
                ],
            ]
        ]);
    }

    public function category(){
        $category = SysCategory::where('status',1)->where('parent_id',0)->orderBy('sorts','DESC')->get();

        return SysCategoryRescource::collection($category);
    }

    public function savedata(Request $request){
        $data = [
            'data' => $request->data,
            'mail' => $request->mail,
        ];

        $rules = [
            'data' => 'required',
            'mail' => 'required',
        ];
        $messages = [
            'data.required' => '无商品',
            'mail.required' => '请输入邮箱',
        ];
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), null, true);
        }
        $user = \Auth::user();

        //写入用户
        UserCallback::saveBy([
            'name' => $request->mail,
            'content' => $request->mark,
        ]);

        //写入订单
        $this->mkOrder($user,$request->data,$request->mail);
        //写入邮件

        return $this->success('提交成功');
    }

    protected function mkOrder($user,$goods,$mail = null){
        $serial = time().$user['id'];
        $order = OrdOrder::saveBy([
            'serial' => $serial,
            'user_id' => $user['id'],
            'mobile' => $mail,
            'status' => 1,
            'name' => $user['nickname'],
        ]);
        $goods_name = '';
        foreach ($goods as $ksy=>$val){
            if($val > 0){
                OrdOrderItem::saveBy([
                    'order_id' => $order->id,
                    'spu_id' => $ksy,
                    'sku_id' => $val,
                ]);
                $good = GdsGood::find($ksy)->name . " * ".$val .' | ';
                $goods_name .= $good;
            }
        }

        $order->goods_name = $goods_name;
        $order->save();

        return $order;
    }

    public function question2(Request $request){

        $data = [
            'area' => $request->area,
            'mobile' => $request->mobile,
            'name' => $request->name,
        ];

        $rules = [
            'area' => 'required',
            'mobile' => 'required',
            'name' => 'required',
        ];
        $messages = [
            'name.required' => '请输入姓名',
            'area.required' => '请输入部门',
            'mobile.required' => '请输入联系方式',
        ];
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), null, true);
        }

        return $this->success('提交成功，请等待组织人与你联系核实');
    }

    public function mlists(){
        $user = \Auth::user();
        return UserMessageRescource::collection(UserMessage::where('created_at','>',$user->created_at)->get());
    }

    public function dmessage(Request $request,UserMessage $model = null){
        return new UserMessageRescource($model);
    }

    /**
     * 商品列表
     */
    public function goods(Request $request){
        $cid = $request->cid ?? 0;
        $tid = $request->tid ?? 0;
        $key = $request->key ?? 0;
        $data = GdsGood::where('id','>',0);
        $cid && $data = $data->where('category_id',$cid);
        $tid && $data = $data->where('teacher_id',$tid);
        $key && $data = $data->where(function ($query)use($key){
            $query->where('name','like',"%{$key}%")->orWhere('teacher','like',"%{$key}%");
        });
        return $this->success('success',null,GdsGoodRescource::collection($data->get()));
    }

    public function detail(GdsGood $model = null){

        return $this->success('success',null,new GdsGoodRescource($model));

    }

    public function detailsku(GdsSku $model = null){
        $model->number++;
        $model->save();
        return $this->success('success',null,new GdsSkuRescource($model));
    }

    /**
     * 是否购买/分享
     */
    public function isbuyed(GdsGood $model = null){
        $user = \Auth::user();
        //分享海报
        $conf = @file_get_contents('poster.txt');
        $poster = $conf ? json_decode($conf,true):[];
        //是否支付
        $buys = OrdOrder::where('user_id',$user['id'])->where('status','>',1)->whereHas('items',function ($query)use($model){
            $query->where('spu_id',$model['id']);
        })->get();

        $ispay = ($model->pay == 1 || !$buys->isEmpty())?1:0;

        //是否分享
        $isshare = UserShare::where([
            'user_id' => $user->id ?? 0,
            'spu_id' => $model->id ?? 0,
        ])->first()? 1 :0;
        //逻辑处理

        return $this->success('success',null,[
            'cover' => $poster,
            'ispay' => $ispay,
            'isshare' => $isshare,
        ]);
    }

    public function share(GdsGood $model = null){
        $user = \Auth::user();
        UserShare::firstOrCreate([
            'user_id' => $user->id ?? 0,
            'spu_id' => $model->id ?? 0,
        ]);

        return $this->success('success',null,$user);
    }

    public function pay(GdsGood $model = null){

        if($model->pay == 2){//weixin
            return $this->weixin($model);
        }else if($model->pay == 3){//jifen
            return $this->jifen($model);
        }else{
            return $this->error('免费视频不用支付');
        }
    }

    protected function weixin(GdsGood $model){
        $user = \Auth::user();
        try{
            DB::beginTransaction();

            $order = $this->mkOrder($user,$model,1);
            $res = $this->payService->pay([
                'openid' => $user->openid,
                'serial' => $order->serial,
                'total_fee' => $order->price,
            ]);
            DB::commit();
            return $res;
        }catch (\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage());
        }

    }

    protected function jifen(GdsGood $model){
        $user = \Auth::user();
        $buyIntegral = $model->price;
        $hasIntegral = $user->integral ?? 0;
        if($buyIntegral > $hasIntegral){
            return $this->error('积分不足');
        }

        try{
            DB::beginTransaction();

            $order = $this->mkOrder($user,$model,2);
            $user->integral -= $model->price;
            $user->save();

            $this->orderOk($order);
            DB::commit();
            return $this->success('success',null,[
                'type' => 'jifen',
            ]);
        }catch (\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage());
        }
    }

    protected function orderOk(OrdOrder $order = null){
        $order->status = 5;
        $order->payed_at = date('Y-m-d H:i:s');
        $order->save();
    }

    public function callback(Request $request){
        $options = file_get_contents('php://input');
        $options = (array)simplexml_load_string($options, 'SimpleXMLElement', LIBXML_NOCDATA);
        info($options);
        if($options['result_code'] == 'SUCCESS'){
            $order = OrdOrder::where('serial',$options['out_trade_no'])->first();
            $this->orderOk($order);
        }
        echo 'success';
    }

    public function saveuserinfo(Request $request){
        $user = \Auth::user();
        $user->mobile = ($request->province ?? '') . ($request->city ?? '');
        $user->nickname = $request->nickName;
        $user->avatar = $request->avatarUrl;
        $user->save();
    }
}