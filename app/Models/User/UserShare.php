<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/5/9
 * Time: 6:59
 */

namespace App\Models\User;

use App\Models\Model;

class UserShare extends Model
{
    protected $fillable = ['user_id', 'spu_id'];
}