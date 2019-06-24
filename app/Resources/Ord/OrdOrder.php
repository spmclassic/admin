<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/5/2
 * Time: 15:03
 */

namespace App\Resources\Ord;

use App\Resources\Base;
use App\Resources\Gds\GdsGood;

class OrdOrder extends Base
{
    public function toArray($request){
        return [
            'pay_type' => $this->pay_type == 1 ? '微信支付' : '积分支付',
            'id' => $this->id,
            'serial' => $this->serial,
            'created_at' => (string)$this->created_at,
            'goods' => new GdsGood($this->item->good)
        ];
    }
}