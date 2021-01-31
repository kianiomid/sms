<?php namespace App\JsonStructures\Base;

use App\Facades\DateUtil;
use App\Helpers\Util;
use App\Models\Common\Message;

abstract class BaseJsonStructure
{

    const NS_ID = 'id';
    const NS_NAME = 'name';
    const NS_TITLE = 'title';
    const NS_DESCRIPTOR = 'descriptor';
    const NS_DESCRIPTION  = 'description';
    const NS_DATE = 'date';
    const NS_DATE_RAW = 'date_raw';
    const NS_SCORE_RAW = 'score_raw';
    const NS_TIME = 'time';
    const NS_TIME_RAW = 'time_raw';
    const NS_ITEMS = 'items';
    const NS_USER_INFO = 'user_info';
    const NS_DATA = 'data';
    const NS_STATUS = 'status';
    const NS_PLAN_VALUE = 'plan_value';
    const NS_QUARTER_AGREEMENT = 'quarter_agreement';
    const NS_OBJECTIVE_ASSIGNMENT = 'objective_assignment';

    const NS_INCREMENTAL_KEY = 'incrementalKey';
    const NS_HAS_ERROR = 'has_error';

    const NS_CODE = 'code';
    const NS_MESSAGE_TEXT = 'message_text';
    const NS_MESSAGES = 'messages';
    const NS_FINALIZED = 'finalized';
    const NS_SHOW_SCORES = 'show_scores';


    const NS_ENABLE = 'enable';
    const NS_CREATED_AT = 'created_at';
    const NS_SCORES = 'scores';
    const NS_SCORE = 'score';
    const NS_COUNT = 'count';
    const NS_PAGE = 'page';
    const NS_LIMIT = 'limit';


    protected $messages = [];
    protected $hasError = false;

    protected abstract function toArray();

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function getResult(array $messages = [], $has_error = false, $fromValidation = null)
    {

        $this->messages = $messages;
        $this->hasError = $has_error;

        $msg_result = [];

        if ($this->messages) {

            if ($fromValidation) {
                $msg_result = $this->getValidationResult($messages);

            } else {
                foreach ($this->messages as $msg) {
                    $msg_result[] = [
                        self::NS_CODE => $msg->getCode(),
                        self::NS_MESSAGE_TEXT => $msg->getMessageText()
                    ];
                }
            }
        }

        $rs = $this->toArray();
        $rs[self::NS_STATUS] = [
                    self::NS_INCREMENTAL_KEY => $this->incrementalKey,
                    self::NS_HAS_ERROR => $this->hasError,
                    self::NS_MESSAGES => $msg_result
            ];
        return $rs;

    }
}
