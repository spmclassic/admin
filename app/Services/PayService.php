<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/5/16
 * Time: 11:20
 */

namespace App\Services;

use function EasyWeChat\Kernel\Support\generate_sign;

class PayService
{

    /**
     * 发起微信支付
     *
     * @return Array
     */
    public function pay($config = null)
    {
        $this->wxpay = app('easywechat.payment');

        $unify = $this->wxpay->order->unify([
            'body'         => '中推在线订单',
            'out_trade_no' => $config['serial'],
            'total_fee'    => $config['total_fee']*100, // 总价
            'trade_type' => 'JSAPI',
            'openid' => $config['openid'], // 用户的openid
        ]);

        if ($unify['return_code'] === 'SUCCESS' && !isset($unify['err_code'])) {
            $pay = [
                'appId' => config('wechat.payment.default.app_id'),
                'timeStamp' => (string) time(),
                'nonceStr' => $unify['nonce_str'],
                'package' => 'prepay_id=' . $unify['prepay_id'],
                'signType' => 'MD5',
            ];

            $pay['paySign'] = generate_sign($pay, config('wechat.payment.default.key'));

            return $pay;
        } else {
            $unify['return_code'] = 'FAIL';
            return $unify;
        }


    }

}