<?php
/**
 * Created by PhpStorm.
 * User: caojianhui
 * Date: 2018/12/15
 * Time: 4:28 PM
 */

namespace App\Http\Composer;

use Illuminate\View\View;

class UserComposer
{
    /**
     * 将用户信息绑定数据到视图.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = \Auth::user();
        $view->with('user', $user);
    }
}