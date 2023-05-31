<?php

namespace App\Services\Generals\Traits;

trait ResponseTrait
{
    public static function returnResponse($code, $event, $data = null)
    {
        $response = [
            'code' => $code,
            'event' => $event,
        ];

        if (hasData($data))
            $response['id'] = $event === 'insert' || $event === 'update' ? $data->id : NULL;

        $response['message'] = $code === 201 || $code === 200 ? 'Save successful' : 'Error message';
        $response['data'] = $data;

        return $response;
    }
}
