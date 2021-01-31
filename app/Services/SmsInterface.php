<?php


namespace App\Services;


interface SmsInterface
{
    public function sendSms($to, $from, $text);
}
