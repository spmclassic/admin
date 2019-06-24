<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29/029
 * Time: 12:16
 */

namespace App\Models\System;

use App\Models\Collection;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class SysPermission extends Permission
{

    protected  $appends = ['link'];


    /**
     * @param int $gurad
     * @return Collection
     *
     * 获取所有模块
     */
    public static function getModules($guard,User $user = null,$menu = false,$status = false)
    {
        $where = ['guard_name'=>$guard];

        $menu && $where['is_menu'] = $menu;
        $status && $where['status'] = $status;

        $collection = (new Collection(app(PermissionRegistrar::class)->getPermissions($where)))->sortByDesc('sorts');

        return $collection->filter(function($item) use($user,$guard){
            if($user == null || $user->id == config('app.super_id') || $user->hasPermissionTo($item['name'],$guard)){
                return true;
            }else{
                return false;
            }
        })->buildTree('parent_id', 'node');
    }
}