<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29/029
 * Time: 14:50
 */

namespace App\Http\Traits;


trait ResponseTrait
{
    /**
     * @param $message
     * @param string  $url
     * @return \Illuminate\Http\JsonResponse
     * return success info
     */
    protected function success($message, $url='',$data=[])
    {
        return $this->toResponseData($message, 1, $url,$data);
    }

    /**
     * @param $message
     * @param string  $url
     * @return \Illuminate\Http\JsonResponse
     * return error info
     */
    protected function error($message, $url='',$data=[])
    {
        return $this->toResponseData($message, 0, $url,$data);
    }

    /**
     * @param $message
     * @param $status
     * @param string  $url
     * @return \Illuminate\Http\JsonResponse
     */
    private function toResponseData($message, $status, $url='',$data=[])
    {
        $json['data'] = $data;
        $json['status'] = $status;
        $json['message'] = $message;
        $json['info'] = $message;
        $json['url'] = $url;
        return response()->json($json)->setCallback(request()->input('callback'));
    }

    /**
     * Ajax方式返回数据到客户端
     *
     * @access protected
     * @param  mixed  $data 要返回的数据
     * @param  String $type AJAX返回数据格式
     * @return void
     */
    protected function ajaxReturn($data, $type = '')
    {
        if (empty($type)) {
            $type = 'JSON';
        }
        switch (strtoupper($type)) {
            case 'JSON':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                return response()->json($data);
            case 'XML':
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler = request('callback') ? request('callback') : 'jsonp';
                return response()->jsonp($handler,$data);
            case 'EVAL':
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);
        }
    }
}