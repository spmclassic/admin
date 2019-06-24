<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/7
 * Time: 11:00
 */

namespace App\Models\Gds;

use App\Models\Model;

class GdsSku extends Model
{
    protected $appends = ['pay_name','timer_long','timer_longs','pay_view'];

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value*100;
    }


    public function getPayViewAttribute()
    {
        return $this->pay == 1 ? '免费' : '购买后观看';
    }

    public function getTimerLongAttribute(){
        return (floor($this->timer/60)).'分'.($this->timer%60)."秒";
    }

    public function getTimerLongsAttribute(){
        return (floor($this->timer/60)).':'.($this->timer%60);
    }

    public function getPriceAttribute($value)
    {
        return $value/100;
    }

    public function getPayNameAttribute()
    {
        return $this->pay == 1 ? '免费' : ($this->pay == 2 ? '微信支付' :'积分支付');
    }
}