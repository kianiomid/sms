<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\JsonStructures\Base\JsonResponse;
use App\Services\SMS\SmsInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

class SmsController extends Controller
{

    protected $smsEntityManager;

    const KAVENEGAR = "kavenegar";
    const MELLIPAYAMAK = "mellipayamak";

    /**
     * AppBaseController constructor.
     */
    public function __construct()
    {
        $this->smsEntityManager = Config::get('app.SMS_PROVIDER', self::KAVENEGAR);
    }

    /**
     * @param SmsInterface $smsInterface
     * @return \Illuminate\Http\Response
     */
    public function send(SmsInterface $smsInterface)
    {
        //we should get data from database but this section we set data as static
        $receptor = ["09331116877"];
        $message = Lang::get('texts.kavenegar.sms_service');

        $smsInfo = $smsInterface->sendSms($receptor, $message, $this->smsEntityManager);

        return JsonResponse::response($smsInfo, Lang::get('response.general.success'));
    }
}
