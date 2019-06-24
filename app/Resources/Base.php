<?php
/**
 * Created by PhpStorm.
 * User: 89340
 * Date: 2019/4/19
 * Time: 14:20
 */

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Base extends JsonResource
{

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'status' => 1,
            'info' => 'success',
            'code' => 200,
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }
}