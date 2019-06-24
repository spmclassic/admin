<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/22
 * Time: 15:31
 */

namespace App\Models\User;


use App\Models\Model;

class UserIntegralLog extends Model
{
    const TYPE_ORDER_OUT = 1;
    const TYPE_SIGN_IN = 11;
    const TYPE_ORDER_IN = 12;
}