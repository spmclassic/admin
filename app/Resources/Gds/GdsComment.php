<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/26
 * Time: 6:54
 */

namespace App\Resources\Gds;


use App\Resources\Base;

class GdsComment extends Base
{
    public function toArray($request)
    {
        $user = \Auth::user();
        return [
            'id' => $this->id ?? 0,
            'name' => $this->user->nickname ?? ' -- ',
            'header' => $this->user->avatar ?? ' -- ',
            'time' => (string)$this->created_at ?? ' -- ',
            'pname' => $this->parent->user->nickname ?? '',
            'content' => $this->content ?? ' -- ',
            'zan' => $this->zan->count(),
            'selfzan' => $this->zan->where('user_id',$user->id ?? 0)->count(),
        ];
    }
}