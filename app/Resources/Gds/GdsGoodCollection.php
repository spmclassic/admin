<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/18
 * Time: 15:35
 */

namespace App\Resources\Gds;

use App\Resources\BaseCollection;

class GdsGoodCollection extends BaseCollection
{

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }

}