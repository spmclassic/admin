<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/7
 * Time: 20:41
 */

namespace App\Models\Gds;

use App\Models\Model;
use App\Models\User;

class GdsComment extends Model
{
    public function goods(){
        return $this->belongsTo(GdsGood::class,'spu_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}