<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\AppBaseController;
use App\JsonStructures\Base\JsonResponse;
use App\Services\SMS\Base\SmsPanelRepository;
use Illuminate\Support\Facades\Lang;

class SmsController extends AppBaseController
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function send()
    {
        //we should get data from database but this section we set data as static
        $receptor = ["09331116877"];
        $message = Lang::get('texts.kavenegar.sms_service');

        $smsInfo = SmsPanelRepository::getInstance($this->smsEntityManager)
            ->sendSms($receptor, $message);

        return JsonResponse::response($smsInfo, Lang::get('response.general.success'));
    }
}
