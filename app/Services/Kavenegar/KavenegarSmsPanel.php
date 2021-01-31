<?php


namespace App\Services\Kavenegar;


use App\JsonStructures\Base\BaseJsonStructure;
use App\JsonStructures\Base\JsonResponse;
use App\JsonStructures\KavenegarJson;
use App\Services\SmsInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Kavenegar\KavenegarApi;

class KavenegarSmsPanel implements SmsInterface
{

    public $apiKey;
    public $sender;
    protected static $instance;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->sender = Config::get('app.KAVEKNEGAR_SENDER');
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new KavenegarSmsPanel(
                Config::get('app.API_KEY')
            );
        }

        return self::$instance;
    }

    public function sendSms($to, $from, $message)
    {
        try {
//            $api = new \Kavenegar\KavenegarApi( "API Key" );
            $api = new KavenegarApi($this->apiKey);
//            $sender = $this->sender;
            $from = $this->sender;

//            $message = Lang::get('texts.kavenegar.sms_service');
            $receptor = ["09331116877", "09367891011"];

//            $result = $api->Send($sender, $receptor, $message);
            $result = $api->Send($from, $to, $message);

            if ($result) {
                foreach ($result as $r) {
                    /*echo "messageid = $r->messageid";
                    echo "message = $r->message";
                    echo "status = $r->status";
                    echo "statustext = $r->statustext";
                    echo "sender = $r->sender";
                    echo "receptor = $r->receptor";
                    echo "date = $r->date";
                    echo "cost = $r->cost";*/

                    $options = [
                        $messageId = $r->messageid,
                        $texts = $r->message,
                        $status = $r->status,
                        $statusText = $r->statustext,
                        $sender = $r->sender,
                        $receptor = $r->receptor,
                        $date = $r->date,
                        $cost = $r->cost
                    ];

                    $jsonObject = (new KavenegarJson($options))->toArray();

                    return JsonResponse::response($jsonObject, Lang::get('response.general.success'));
                }
            }
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
    }

}
