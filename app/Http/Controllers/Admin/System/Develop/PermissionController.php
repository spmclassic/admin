<?php

namespace App\Http\Controllers\Admin\System\Develop;

use App\Http\Controllers\Admin\InitController;
use App\Models\System\SysPermission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PermissionController extends InitController
{
    public function __construct(Request $request)
    {
        $this->template = 'admin.system.develop.permission.';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * 权限列表
     */
    public function index(Request $request){

        $page = $request->page ?? 1;

        $guard = $request->guard ?? config('app.guard.admin');
        if(!in_array($guard,config('app.guard'))){
            return back();
        }

        $permissions = SysPermission::getModules($guard)->mergeTree('node');
        $lists =  $permissions->forPage($page,self::PAGESIZE);
        $lists = new LengthAwarePaginator($lists,$permissions->count(),self::PAGESIZE,$page);

        $url  = url('system/develop/permission');
        $lists->withPath($url);

        return view( $this->template. __FUNCTION__,compact('lists','guard'));
    }

    /**
     * @param Request $request
     * @param Permission $permission
     *
     * 创建功能权限
     */
    public function create(Request $request,SysPermission $permission=null)
    {
        $guard = $permission['guard_name'] ?? $request->guard ?? config('app.guard.admin');
        if(!in_array($guard,config('app.guard'))){
            return $request->isMethod('get') ? back():$this->error('guard error');
        }

        if($request->isMethod('get')) {
            $modules = SysPermission::getModules($guard)->mergeTree('node')->where('level','<',3);
            return view($this->template.__FUNCTION__,compact('permission','modules','guard'));
        }

        $data = $request->data;

        $rules = [
            'name' => 'required|unique:sys_permissions,name,'.($permission['id'] ?? 'NULL').',id,guard_name,'.$guard,
            'display_name' => 'required',
        ];
        $messages = [
            'name.required' => '请输入权限名称',
            'name.unique' => '节点已存在',
            'display_name.required' => '请输入权限显示',
        ];

        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), null, true);
        }

        try {
            if(!empty($permission->id)) {
                $permission->name = $data['name'];
                $permission->display_name = $data['display_name'];
                $permission->parent_id = $data['parent_id'];
                $permission->icon_class = $data['icon_class'];
                $permission->status = $data['status'];
                $permission->is_menu =  $data['is_menu'];
                $permission->sorts = $data['sorts'];
                $permission->save();
            } else {
                $data['guard_name'] = $guard;
                SysPermission::create($data);
            }
            return $this->success('创建模块完成',url('system/develop/permission').'?guard=' . $guard);
        }catch (\Exception $e) {
            return $this->error('创建模块异常，请联系开发人员'.$e->getMessage());
        }

    }
}