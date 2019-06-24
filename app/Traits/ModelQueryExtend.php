<?php

namespace App\Http\Traits;


use Illuminate\Database\Eloquent\Model;

trait ModelQueryExtend
{
    /**
     * @param $data
     * @return int
     * 自动创建模型
     * 成功返回模型 失败返回false
     */
    protected function saveBy($data)
    {
        $model = $this;

        if (!empty($data[$this->primaryKey])) {
            $model =  $this->findOrNew($data[$this->primaryKey]);
        }
        self::setModelData($model, $data);
        return $model->save() ? $model : false;
    }




    /**
     * @param $model
     * @param $data
     * @return mixed
     */
    private function setModelData($model, $data)
    {
        foreach ($data as $key => $value) {
            $model->{$key} = $value;
        }
        return $model;
    }
}