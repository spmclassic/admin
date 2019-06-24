<?php
namespace App\Presenters\Common;

use App\Models\System\SysPermission;

class MenuPresenter{

    public function init($guard){
        return SysPermission::getModules($guard,\Auth::user(),true,true);
    }

    /**
     * @param $item
     * @param int $type
     * @return mixed
     */
    public function currentMenu(&$item,$type=1)
    {
        $routes = explode('.',\Route::currentRouteName());
        if(count($routes) < $type) return $item;
        $slice = array_slice($routes,0,$type);
        $route = implode('.',$slice);
        if(starts_with($item->name,$route)) {
            $item['current'] = 'on';
        } else {
            $item['current'] = "";
        }
        return $item;
    }

    /**
     * @param $model
     * @return string
     *
     * 获取模块url链接
     */
    public function getNodeLink($menu)
    {
        if(!empty($second = $menu->node)) {
            $second = $second->first();
            if(empty($second))
                return '#';
            if(!empty($third = $second->node)) {
                $node = $third->first();
                return $this->link($node['name']);
            } else {
                return '#';
            }
        }
        return '#';
    }

    /**
     * @param $absolute
     * @param $route
     * @param $parameters
     * @param $url
     * @return \Illuminate\Contracts\Routing\UrlGenerator|Route|string
     */
    public function link($route)
    {
        if (!is_null($route)) {
            if (!\Route::has($route)) {
                return '#';
            }

            return route($route, [], false);
        }

        return '#';
    }
}