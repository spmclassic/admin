<?php
/*********************************************************************************
 *  PhpStorm - saas
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By cw100.com
 * 文件内容简单说明
 *-------------------------------------------------------------------------------
 * $FILE:Collection.php
 * $Author:zxs
 * $Dtime:2017/4/6
 ***********************************************************************************/

namespace App\Models;

use Illuminate\Database\Eloquent\Collection as BaseCollection;

class Collection extends BaseCollection
{


    /**
     * 过滤每个item数据
     *
     * @param callable|null $callback
     *
     * @return static
     */
    public function filter(callable $callback = null)
    {
        if ($callback) {
            return new static(array_values(array_filter($this->items, $callback)));
        }

        return new static(array_values(array_filter($this->items)));
    }


    /**
     * @param $old
     * @return array
     *
     * 生成以ID为key的数组
     */
    private function createIdArray($old)
    {
        if (!is_array($old) || !count($old)) {
            return $old;
        }
        $new = [];
        foreach ($old as $value) {
            $id = $value['id'];
            unset($value['id']);
            $new[$id] = $value;
        }

        return $new;
    }

    /**
     * @return array
     * 把Collection数据集转化为已id为key的数组
     */
    public function toIdArray()
    {
        $arr = $this->toArray();

        return $this->createIdArray($arr);
    }

    /**
     * Extending toArray.
     * 从collection数据集模型中获取某个属性的数组列表
     *
     * @param string $attribute
     *
     * @return array
     */
    public function toArray($attribute = null)
    {
        $elements = parent::toArray();
        if (!$attribute) {
            return $elements;
        }
        $filtered = [];
        foreach ($elements as $element) {
            $filtered[] = $element[$attribute];
        }

        return $filtered;
    }

    /**
     * 某collection列表生成collection树
     *
     * @param string $parent_id [name of the parent id]
     * @param string $children  [name of the children list]
     *
     * @return Collection [Collection Tree]
     */
    public function buildTree($parent_id = 'parent_id', $children = 'children', $list = null)
    {
        if (!$list) {
            $list = $this;
        }
        $tree = $this->filter(function ($item) use (&$parent_id) {
            return !$item->$parent_id;
        });
        $list = $list->filter(function ($item) use (&$parent_id) {
            return $item->$parent_id;
        });
        $builder = function (&$childs) use (&$builder, &$list, &$children, &$parent_id) {
            if (!$childs) {
                return;
            }
            for ($i = 0; $i < $childs->count(); $i++) {
                $id = $childs[$i]->id;
                $childs[$i]->$children = $list->filter(function ($item) use ($id, $parent_id) {
                    return $item->$parent_id == $id;
                });
                $list = $list->filter(function ($item) use ($id, $parent_id) {
                    return $item->$parent_id != $id;
                });
                $builder($childs[$i]->$children);
            }
        };
        $builder($tree);

        return $tree;
    }

    /**
     * Take a collection and build a tree.
     *
     * @param string $parent_id [name of the parent id]
     * @param string $children  [name of the children list]
     *
     * @return Collection [Collection Tree]
     */
    public function mergeTree($children = 'children', $level=0)
    {
        $tree = $this;
        $list = [];
        $level = 0;
        $builder = function (&$childs, $level) use (&$builder, &$list, &$children) {
            if (!$childs || !$childs->count()) {
                return;
            }
            for ($i = 0; $i < $childs->count(); $i++) {
                $childs[$i]->level = $level;
                $list[] = $childs[$i];
                if (isset($childs[$i]->$children) && count($childs[$i]->$children)) {
                    $builder($childs[$i]->$children, $level + 1);
                }
            }
        };
        $builder($tree, $level+1);
        for ($i = 0; $i < count($list); $i++) {
            if (isset($list[$i]->$children)) {
                unset($list[$i]->$children);
            }
        }

        return new static($list);
    }
}
