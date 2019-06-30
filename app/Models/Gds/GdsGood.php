<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/7
 * Time: 10:59
 */

namespace App\Models\Gds;

use App\Models\Model;
use App\Models\Ord\OrdOrder;
use App\Models\System\SysCategory;

class GdsGood extends Model
{
    protected $appends = ['pay_name','timer_long','timer_longs','pay_view'];
    protected $casts = ['intro' => 'json'];
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value*100;
    }

    public function getPriceAttribute($value)
    {
        return $value/100;
    }

    public function getPayNameAttribute()
    {
        return $this->pay == 1 ? '免费' : ($this->pay == 2 ? '微信支付' :'积分支付');
    }
    public function getPayViewAttribute()
    {
        return $this->pay == 1 ? '￥0.00' : ($this->pay == 2 ? '￥'.$this->price :'积分:'.$this->price);
    }

    public function getTimerLongAttribute(){
        return $this->timer;
    }
    public function getTimerLongsAttribute(){
        return $this->timer;
    }

    public function category(){
        return $this->belongsTo(SysCategory::class,'category_id');
    }

    public function skus(){
        return $this->hasMany(GdsSku::class,'goods_id');
    }

    public function order(){
        return $this->belongsToMany(OrdOrder::class,'ord_order_items','spu_id','order_id');
    }

    public function comment(){
        return $this->hasMany(GdsComment::class,'spu_id');
    }

    public function zan(){
        return $this->hasMany(GdsZan::class,'spu_id');
    }
}