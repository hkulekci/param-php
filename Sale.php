<?php
/**
 * Created by Payfull.
 * Date: 10/15/2018
 */

namespace param;


use param\paramBasics\TP_Islem_Odeme;
use param\paramBasics\SHA2B64;

class Sale extends Config
{
    /**
     * Sale constructor.
     * @param $mode: string value TEST/PROD
     */
    public function __construct($mode)
    {
        parent::__construct($mode);
    }

    /**
     * send sale transaction
     * @param $clientCode: Terminal ID, It will be forwarded by param.
     * @param $clientUsername: User Name, It will be forwarded by param.
     * @param $clientPassword: Password, It will be forwarded by param.
     * @param $vPosId: is the VirtualPOS_ID value of the Card Brand selected from the customer method.
     * @param $guid: Key Belonging to Member Workplace
     * @param $cardHolder: Credit Card Holder
     * @param $cardNumber: Credit Card Number
     * @param $cardExpMonth: Last 2 digit Expiration month
     * @param $cardExpYear: 4 digit Expiration Year
     * @param $cvc: CVC Code
     * @param $cardHolderPhone: Credit Card holder GSM No, Without zero at the beginning (5xxxxxxxxx)
     * @param $failUrl: If the payment fails, page address to be redirected to
     * @param $successURL: If the payment is successful, page address to be redirected to
     * @param $orderId: Singular ID for Order-specific. If you have sent before this value the system is new Assign order_ID. As a result of this The order_ID is returned.
     * @param $orderDescription: Order Description
     * @param $installments: Selected number of installments. Send 1 for one installment.
     * @param $total: Order Amount, (only a comma with Kuruş format 1000,50)
     * @param $generalTotal: Commission Including Order Amount, (only a comma with Kuruş format 1000,50)
     * @param $transactionId: Single ID except the Sipariş Id that belongs to transaction, optional.
     * @param $ipAddress: IP Address
     * @param $referenceUrl: Url of page where payment is made
     * @param $extraData1: Extra Space 1
     * @param $extraData2: Extra Space 2
     * @param $extraData3: Extra Space 3
     * @param $extraData4: Extra Space 4
     * @param $extraData5: Extra Space 5
     */
    public function send($clientCode,$clientUsername,$clientPassword,$vPosId,$guid,$cardHolder,$cardNumber,
                         $cardExpMonth,$cardExpYear,$cvc,$cardHolderPhone,$failUrl,$successURL,$orderId,
                         $orderDescription,$installments,$total,$generalTotal,$transactionId,$ipAddress,
                         $referenceUrl,$extraData1,$extraData2,$extraData3,$extraData4,$extraData5)
    {
        $client = new SoapClient($this->serviceUrl);

        $saleObj = new TP_Islem_Odeme($clientCode,$clientUsername,$clientPassword,$vPosId,$guid,$cardHolder,$cardNumber,
            $cardExpMonth,$cardExpYear,$cvc,$cardHolderPhone,$failUrl,$successURL,$orderId,
            $orderDescription,$installments,$total,$generalTotal,$transactionId,$ipAddress,
            $referenceUrl,$extraData1,$extraData2,$extraData3,$extraData4,$extraData5);

        $securityString = $clientCode.$guid.$vPosId.$installments.$total.$generalTotal.$orderId.$failUrl.$successURL;
        $shaString = new SHA2B64($securityString, $clientCode, $clientUsername, $clientPassword);
        $saleObj->Islem_Hash = $client->SHA2B64($shaString)->SHA2B64Result;
        $response = $client->TP_Islem_Odeme($saleObj);
    }
}