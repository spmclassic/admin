<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/20
 * Time: 15:15
 */

namespace App\Resources\System;

use App\Resources\Base;

class SysCategory extends Base
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? 0,
            'name' => $this->name ?? ''
        ];
    }
}