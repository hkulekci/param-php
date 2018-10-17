<?php
/**
 * Created by Payfull.
 * Date: 11/16/2018
 */

namespace param;

use param\paramBasics\TP_Islem_Iptal_Iade;


class CancelRefund extends Config
{
    /**
     * CancelRefund constructor.
     * @param $mode: string value TEST/PROD
     */
    public function __construct($mode)
    {
        parent::__construct($mode);
    }

    /**
     * @param $clientCode: Terminal ID, It will be forwarded by param.
     * @param $clientUsername: User Name, It will be forwarded by param.
     * @param $clientPassword: Password, It will be forwarded by param.
     * @param $guid: Key Belonging to Member Workplace
     * @param $type: For cancellation IPTAL For return IADE
     * @param $invoiceId: Transaction’s receipt ID.
     * @param $totalAmount: Cancellation / Return Amount, All amount must be written for CANCELLATION. All amount or smaller amount (partial) must be written for RETURN.
     */
    public function send($clientCode,$clientUsername,$clientPassword,$guid,$type, $invoiceId, $totalAmount)
    {
        $client = new SoapClient($this->serviceUrl);
        $cancelRefundObj = new TP_Islem_Iptal_Iade($clientCode,$clientUsername,$clientPassword,$guid,$type, $invoiceId, $totalAmount);
        $response = $client->TP_Islem_Iptal_Iade($cancelRefundObj);
    }
}