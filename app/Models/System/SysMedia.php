<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/3/30
 * Time: 11:28
 */

namespace App\Models\System;

use App\Models\Model;

class SysMedia extends Model
{
    const MEDIA_TYPE_DIR = 1;
    const MEDIA_TYPE_FILE = 2;

    protected $appends = ['file_tail'];

    public function getFileTailAttribute()
    {
        $file = explode('.',$this->path);
        return end($file);
    }

}