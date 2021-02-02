<?php

namespace App\Services\SMS;


interface SmsInterface
{
    public function sendSms($to, $text);
}
