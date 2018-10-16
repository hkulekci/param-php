<?php
/**
 * Created by Payfull.
 * Date: 10/15/2018
 */

namespace param\paramBasics;


class TP_Ozel_Oran_Liste
{
    public $GUID;//Key Belonging to Member Workplace
    public $G;//control and security object

    public function __construct($CLIENT_CODE, $CLIENT_USERNAME , $CLIENT_PASSWORD, $guid)
    {
        $this->GUID = $guid;
        $this->G = new G($CLIENT_CODE, $CLIENT_USERNAME , $CLIENT_PASSWORD);
    }
}