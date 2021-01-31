<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;

class AppBaseController extends Controller
{

    public $smsEntityManager;

    const KAVENEGAR= "kavenegar";
    const MELLIPAYAMAK= "mellipayamak";

    /**
     * AppBaseController constructor.
     */
    public function __construct()
    {
        $this->smsEntityManager = Config::get('app.SMS_PROVIDER', self::KAVENEGAR);
    }
}
