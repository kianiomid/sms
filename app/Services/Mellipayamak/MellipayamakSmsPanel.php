<?php


namespace App\Services\Mellipayamak;


use App\Services\SmsInterface;
use Illuminate\Support\Facades\Config;

class MellipayamakSmsPanel implements SmsInterface
{

    public $apiKey;
    public $sender;
    protected static $instance;

//    use Melipayamak;

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

    public function sendSms()
    {
        try{

            $sms = Melipayamak::sms();
            $to = '09123456789';
            $from = '5000...';
            $text = 'تست وب سرویس ملی پیامک';
            $response = $sms->send($to,$from,$text);
            $json = json_decode($response);
            echo $json->Value; //RecId or Error Number
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

}
