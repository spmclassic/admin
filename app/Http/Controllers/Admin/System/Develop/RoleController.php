<?php

namespace App\Http\Controllers\Admin\System\Develop;

use App\Http\Controllers\Admin\InitController;
use App\Models\System\SysPermission;
use App\Models\System\SysRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RoleController extends InitController
{
    public function __construct()
    {
        $this->template = 'admin.system.develop.role.';
    }

    /**
     * @param Request $request
     * @return mixed
     * 列表
     */
    public function index(Request $request){

        $guard = $request->guard ?? config('app.guard.admin');
        if(!in_array($guard,config('app.guard'))){
            return back();
        }

        $lists = SysRole::where('guard_name',$guard)->paginate(self::PAGESIZE);
        return view( $this->template. __FUNCTION__,compact('lists','guard'));
    }

    /**
     * @param Request $request
     * @param Role|null $role
     *
     * 创建/编辑权限
     */
    public function create(Request $request,SysRole $model = null)
    {
        $guard = $model['guard_name'] ?? $request->guard ?? config('app.guard.admin');
        if(!in_array($guard,config('app.guard'))){
            return $request->isMethod('get') ? back():$this->error('guard error');
        }

        if($request->isMethod('get')) {
            $modules = SysPermission::getModules($guard);
            return view($this->template.__FUNCTION__ ,compact('model','modules','guard'));
        }

        $permissions = $request->permissions;
        $data = $request->data;
        $data['guard_name'] = $guard;
        try {
            $except =  $model->id ?? 'NULL';
            $rules = [
                'name' => 'required|alpha_dash|unique:' . config('permission.table_names.roles').  ',name,' . $except . ',id'
            ];
            $messages = [
                'name.required' => '权限名称不能为空',
                'name.alpha_dash' => '权限名称仅以字母开头,破折号和下划线组合',
                'name.unique' => '权限名称已存在',
            ];
            $validator = Validator::make($data, $rules,$messages);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first());
            }
            DB::beginTransaction();
            if(!empty($model->id)) {
                $model->name = $data['name'];
                $model->save();
            } else {
                $model = SysRole::create($data);
            }

            if(!empty($permissions)){
                $model->syncPermissions($permissions);
            }
            DB::commit();
            return $this->success('创建角色权限完成',url('/system/develop/role').'?guard='.$guard);
        }catch (\Exception $e) {
            DB::rollback();
            return $this->error('创建角色权限异常'.$e->getMessage());
        }
    }
}