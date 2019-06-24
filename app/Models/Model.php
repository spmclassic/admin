<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/27/027
 * Time: 10:07
 */

namespace App\Models;

use App\Http\Traits\ModelQueryExtend;
use Illuminate\Database\Eloquent\Model as AbstractModel;

class Model extends  AbstractModel {
    use ModelQueryExtend;
}