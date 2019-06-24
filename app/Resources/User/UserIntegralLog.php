<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/23
 * Time: 21:39
 */

namespace App\Resources\User;


use App\Resources\Base;

class UserIntegralLog extends Base
{
    public function toArray($request){
        return [
            'type_name' => $this->type > 10 ? '获取积分' : '消费积分',
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => (string)$this->created_at,
        ];
    }
}