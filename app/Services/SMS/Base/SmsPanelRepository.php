<?php

namespace App\Services\SMS\Base;

use App\Http\Controllers\AppBaseController;
use App\Services\SMS\Kavenegar\KavenegarSmsPanel;
use App\Services\SMS\Mellipayamak\MellipayamakSmsPanel;

abstract class SmsPanelRepository
{
    /**
     * @param $to
     * @param $text
     * @return mixed
     */
    public abstract function sendSms($to, $text);

    /**
     * @param string $smsEntityManager
     * @return KavenegarSmsPanel|MellipayamakSmsPanel|null
     */
    public static function getInstance($smsEntityManager = AppBaseController::KAVENEGAR)
    {
        if ($smsEntityManager == AppBaseController::KAVENEGAR) {
            return new KavenegarSmsPanel();

        } else if ($smsEntityManager == AppBaseController::MELLIPAYAMAK) {
            return new MellipayamakSmsPanel();
        }

        return null;
    }

}
