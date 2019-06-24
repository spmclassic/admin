<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/5/2
 * Time: 14:27
 */

namespace App\Models\User;

use App\Models\Model;
use App\Models\Ord\OrdOrder;

class UserMessage extends Model
{
    public function order(){
        return $this->belongsTo(OrdOrder::class,'item_id');
    }
}