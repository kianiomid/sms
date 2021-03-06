<?php


namespace App\Services\SMS\Mellipayamak;


use App\Http\Controllers\Api\v1\SmsController;
use App\Services\SMS\Base\SmsPanelRepository;
use App\Services\SMS\SmsInterface;
use Illuminate\Support\Facades\Config;

class MellipayamakSmsPanel implements SmsInterface
{

    public $sender;
    public $app;

    use Melipayamak;

    /**
     * MellipayamakSmsPanel constructor.
     * @param $app
     */
    public function __construct()
    {
        //I don't access to mellipayamak panel, finally we set mellipayamak properties here,
        //like SMS_HOST or SMS_API_KEY and ...

        $this->sender = Config::get('app.MELLIPAYAMAK_SENDER');
    }

    /**
     * @param $to
     * @param $text
     * @return mixed
     */
    public function sendSms($to, $text)
    {

        try {
            $sms = Melipayamak::sms();

            $response = $sms->send($to, $this->sender, $text);

            $json = json_decode($response);
            return $json->Value; //RecId or Error Number

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}
