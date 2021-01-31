<?php


namespace App\Services\SMS\Kavenegar;


use App\JsonStructures\Base\JsonDictionary;
use App\JsonStructures\Base\JsonResponse;
use App\JsonStructures\KavenegarJson;
use App\Services\SMS\Base\SmsPanelRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Kavenegar\KavenegarApi;

class KavenegarSmsPanel extends SmsPanelRepository
{

    public $apiKey;
    public $sender;
    protected static $instance;

    /**
     * KavenegarSmsPanel constructor.
     */
    public function __construct()
    {
        $this->apiKey = Config::get('app.API_KEY');
        $this->sender = Config::get('app.KAVEKNEGAR_SENDER');
    }

    /**
     * @param $to
     * @param $message
     * @return \Illuminate\Http\Response|mixed
     */
    public function sendSms($to, $message)
    {
        try {
            $api = new KavenegarApi($this->apiKey);

            $result = $api->Send($this->sender, $to, $message);

            if ($result) {
                foreach ($result as $r) {
                    $options = [
                        JsonDictionary::MESSAGEID => $r->messageid,
                        JsonDictionary::MESSAGE => $r->message,
                        JsonDictionary::STATUS => $r->status,
                        JsonDictionary::STATUSTEXT => $r->statustext,
                        JsonDictionary::SENDER => $r->sender,
                        JsonDictionary::RECEPTOR => $r->receptor,
                        JsonDictionary::DATE => $r->date,
                        JsonDictionary::COST => $r->cost
                    ];

                    $jsonObject = (new KavenegarJson($options))->toArray();

                    return JsonResponse::response($jsonObject, Lang::get('response.general.success'));
                }
            }

        } catch (\Kavenegar\Exceptions\ApiException $e) {
            //This error occurs if the output of the web service is not 200
            echo $e->errorMessage();
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // This error occurs when there is a problem communicating with the web service
            echo $e->errorMessage();
        }
    }

}
