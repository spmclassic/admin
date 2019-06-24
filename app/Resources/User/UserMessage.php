<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/5/2
 * Time: 14:32
 */

namespace App\Resources\User;

use App\Resources\Base;
use App\Resources\Ord\OrdOrder;

class UserMessage extends Base
{
    public function toArray($request){
        return [
            'type_name' => $this->type == 1 ? '支付消息' : ($this->type == 2 ? '积分消息' : '系统消息'),
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => (string)$this->created_at,
            'order'=> $this->item_id ? (new OrdOrder($this->order)):''
        ];
    }
}