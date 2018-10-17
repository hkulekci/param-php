<?php
/**
 * Created by Payfull.
 * Time: 12:03 PM
 */

namespace param\paramBasics;


class SHA2B64
{
    public $G;//control and security object
    public $Data;

    /**
     * SHA2B64 constructor.
     * @param $securityString
     * @param $CLIENT_CODE: Terminal ID, It will be forwarded by param.
     * @param $CLIENT_USERNAME: User Name, It will be forwarded by param.
     * @param $CLIENT_PASSWORD: Password, It will be forwarded by param.
     */
    public function __construct($securityString, $CLIENT_CODE, $CLIENT_USERNAME, $CLIENT_PASSWORD)
    {
        $this->Data = $securityString;
        $this->G = new G($CLIENT_CODE, $CLIENT_USERNAME , $CLIENT_PASSWORD);
    }
}