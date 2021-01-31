<?php


namespace App\Services\SMS\Mellipayamak;


use App\Services\SMS\Base\SmsPanelRepository;
use Illuminate\Support\Facades\Config;

class MellipayamakSmsPanel extends SmsPanelRepository
{

    protected static $instance;
    public $sender;

    use Melipayamak;

    /**
     * MellipayamakSmsPanel constructor.
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
