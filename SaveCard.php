<?php
/**
 * Created by PhpStorm.
 * User: mohmm
 * Date: 10/16/2018
 * Time: 4:42 PM
 */

namespace param;

use param\paramBasics\KK_Saklama;

class SaveCard extends Config
{
    public $guid;//Key Belonging to Member Workplace
    public $clientCode;//Terminal ID, It will be forwarded by param.
    public $clientUsername;//User Name, It will be forwarded by param.
    public $clientPassword;//Password, It will be forwarded by param.
    public $receiverCardNumber;//Card Number Belonging to Member Workplace
    public $cardHolder;//Credit Card Holder
    public $cardNumber;//Credit Card Number
    public $cardExpMonth;//Last 2 digit Expiration month
    public $cardExpYear;//4 digit Expiration Year
    public $cvc;//CVC Code

    public function __construct($mode)
    {
        parent::__construct($mode);
    }

    public function send($clientCode, $clientUsername, $clientPassword, $guid, $receiverCardNumber, $cardHolder, $cardNumber,
                         $cardExpMonth, $cardExpYear, $cvc, $Data1='', $Data2='', $Data3='')
    {
        $client = new SoapClient($this->serviceUrl);

        $saveCardObj = new KK_Saklama($clientCode, $clientUsername, $clientPassword, $guid, $receiverCardNumber, $cardHolder, $cardNumber,
            $cardExpMonth, $cardExpYear, $cvc, $Data1, $Data2, $Data3);
        $response = $client->KK_Saklama($saveCardObj);
        if(isset($response->KK_SaklamaResult) == False){
            return False;
        }else{
            $results = $response->KK_SaklamaResult;
            return (array)$results;
        }
    }

}