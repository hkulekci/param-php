<?php
/**
 * Created by Payfull.
 * Time: 12:03 PM
 */

namespace param\paramBasics;


class SHA2B64
{
    public $securityString;
    public $CLIENT_CODE;//Terminal ID, It will be forwarded by param.
    public $CLIENT_USERNAME;//User Name, It will be forwarded by param.
    public $CLIENT_PASSWORD;//Password, It will be forwarded by param.
    public $G;//control and security object

    public function __construct($securityString, $CLIENT_CODE, $CLIENT_USERNAME, $CLIENT_PASSWORD)
    {
        $this->Data = $securityString;
        $this->G = new G($CLIENT_CODE, $CLIENT_USERNAME , $CLIENT_PASSWORD);
    }
}