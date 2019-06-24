<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/7
 * Time: 18:58
 */

namespace App\Models\Ord;


use App\Models\Model;

class OrdOrder extends Model
{

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value*100;
    }

    public function getPriceAttribute($value)
    {
        return $value/100;
    }

    public function items(){
        return $this->hasMany(OrdOrderItem::class,'order_id');
    }

    public function item(){
        return $this->hasOne(OrdOrderItem::class,'order_id');
    }

}