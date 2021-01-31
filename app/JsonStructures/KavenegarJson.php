<?php
/**
 * Created by PhpStorm.
 * User: omid
 * Date: 6/15/19
 * Time: 2:17 PM
 */

namespace App\JsonStructures;

use App\JsonStructures\Base\BaseJsonStructure;
use App\JsonStructures\Base\JsonDictionary;

class KavenegarJson extends BaseJsonStructure
{

    protected $options;

    /**
     * Objective Store constructor.
     * @param $options
     */
    public function __construct( array $options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $res = [
            $this->options[JsonDictionary::MESSAGEID] => JsonDictionary::MESSAGEID . ' = ' . $this->options['messageId'],
            $this->options[JsonDictionary::MESSAGE] => JsonDictionary::MESSAGE . ' = ' . $this->options['message'],
            $this->options[JsonDictionary::STATUS] => JsonDictionary::STATUS . ' = ' . $this->options['status'],
            $this->options[JsonDictionary::STATUSTEXT] => JsonDictionary::STATUSTEXT . ' = ' . $this->options['statusText'],
            $this->options[JsonDictionary::SENDER] => JsonDictionary::SENDER . ' = ' . $this->options['sender'],
            $this->options[JsonDictionary::RECEPTOR] => JsonDictionary::RECEPTOR . ' = ' . $this->options['receptor'],
            $this->options[JsonDictionary::DATE] => JsonDictionary::DATE . ' = ' . $this->options['date'],
            $this->options[JsonDictionary::COST] => JsonDictionary::COST . ' = ' . $this->options['cost'],
        ];

        return $res;
    }
}
