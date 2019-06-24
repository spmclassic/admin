<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/7
 * Time: 18:57
 */

namespace App\Models\Ord;


use App\Models\Gds\GdsGood;
use App\Models\Model;

class OrdOrderItem extends Model
{
    public function good(){
        return $this->belongsTo(GdsGood::class,'spu_id');
    }
}