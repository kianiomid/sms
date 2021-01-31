<?php


namespace App\JsonStructures\Base;


use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class JsonResponse
{
    /**
     * @param array $data
     * @param string $message
     * @param int $code
     * @param int $httpStatus
     * @return Response
     */

    public static function response($data = [], $message = null, $code = 0, $httpStatus = 200) {

        if (!$message) {
            $message = trans('response.general.success');
        }

        $response = [
            'returnCode' => $code,
            'message' => $message,
            'data' => $data
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $httpStatus);
    }
}
