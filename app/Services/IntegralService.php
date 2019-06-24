<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/22
 * Time: 15:14
 */

namespace App\Services;


use App\Models\User;

class IntegralService
{
    public function __construct()
    {
        $conf = @file_get_contents('score.txt');
        $this->config = $conf ? json_decode($conf,true):[];
        if(!$this->config){
            throw new \Exception('暂未配置积分规则');
        }
    }

    /**
     * 签到积分
     */
    public function sign(User $user = null){
        if(!$user){
            throw new \Exception('用户信息错误');
        }

        if(User\UserIntegralLog::where([
            ['type','=',User\UserIntegralLog::TYPE_SIGN_IN],
            ['user_id','=',$user->id],
            ['created_at','>',date('Y-m-d 00:00:00')],
        ])->first()){
            throw new \Exception('已经签到');
        }

        //进行签到
        $this->setIntegralIn($user,$this->config['qiandao'] ?? 0,User\UserIntegralLog::TYPE_SIGN_IN,'签到 获得'.($this->config['qiandao'] ?? 0).'积分');

    }

    /**
     * @param int $number
     * 写入积分与备注 收入
     */
    public function setIntegralIn(User $user,$number = 0,$type = 0,$remark = ''){

        $today = User\UserIntegralLog::where([
            ['type','>',10],
            ['user_id','=',$user->id],
            ['created_at','>',date('Y-m-d 00:00:00')],
        ])->sum('integral');

        $limit = $this->config['shangxian'] ?? 0;

        if($today+$number > $limit){
            $number = $limit - $today;
        }

        if($number <= 0){

            $number = 0;
            $remark .= ' 超过每日积分上限 只增加'.$number.'积分';
        }
        $user->integral += $number;
        User\UserIntegralLog::saveBy([
            'user_id' => $user->id,
            'type' => $type,
            'integral' => $number,
            'integral_new' => $user->integral,
            'content' => $remark,
        ]);

        $user->save();
    }
}