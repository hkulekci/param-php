<?php
/**
 * Created by Payfull.
 * Date: 10/16/2018
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

    /**
     * SaveCard constructor.
     * @param $clientCode: Terminal ID, It will be forwarded by param.
     * @param $clientUsername: User Name, It will be forwarded by param.
     * @param $clientPassword: Password, It will be forwarded by param.
     * @param $guid: Key Belonging to Member Workplace
     * @param $mode: string value TEST/PROD
     */
    public function __construct($clientCode, $clientUsername, $clientPassword, $guid, $mode)
    {
        parent::__construct($clientCode, $clientUsername, $clientPassword, $guid, $mode);
    }

    /**
     * @param $receiverCardNumber: Card Number Belonging to Member Workplace
     * @param $cardHolder: Credit Card Holder
     * @param $cardNumber: Credit Card Number
     * @param $cardExpMonth: Last 2 digit Expiration month
     * @param $cardExpYear: 4 digit Expiration Year
     * @param $cvc: CVC Code
     * @param string $Data1
     * @param string $Data2
     * @param string $Data3
     * @return array|bool
     */
    public function send($receiverCardNumber, $cardHolder, $cardNumber,
                         $cardExpMonth, $cardExpYear, $cvc, $Data1='', $Data2='', $Data3='')
    {
        $client = new \SoapClient($this->serviceUrl);

        $saveCardObj = new KK_Saklama($this->clientCode,$this->clientUsername,$this->clientPassword, $this->guid, $receiverCardNumber, $cardHolder, $cardNumber,
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