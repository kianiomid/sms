<?php


namespace App\Services\Mellipayamak;


use App\Services\SmsInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

class MellipayamakSmsPanel implements SmsInterface
{

    public $apiKey;
    public $sender;
    protected static $instance;

    use Melipayamak;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->sender = Config::get('app.KAVEKNEGAR_SENDER');
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new MellipayamakSmsPanel(
                Config::get('app.API_KEY')
            );
        }

        return self::$instance;
    }

    public function sendSms($to, $from, $text)
    {
        try{

            $sms = Melipayamak::sms();

            //bayad az biroun pass bedim
//            $to = '09331116877';
//            $from = '5000...';
//            $text = Lang::get('texts.mellipayamak.sms_service');

            $response = $sms->send($to,$from,$text);

            $json = json_decode($response);
            return $json->Value; //RecId or Error Number

        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }

}
