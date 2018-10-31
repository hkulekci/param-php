<?php
/**
 * Created by Payfull.
 * Date: 11/16/2018
 */

namespace param;

use param\paramBasics\TP_Islem_Iptal_Iade_Kismi;


class CancelRefund extends Config
{
    const REFUND_TYPE = 'IADE';
    const CANCEL_TYPE = 'IPTAL';
    const ERR_TRX = 'ERR_TRX';
    protected $response;//request response
    protected $transactionId;

    /**
     * CancelRefund constructor.
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
     * @param $type: For cancellation IPTAL For return IADE
     * @param $invoiceId: Transaction’s receipt ID.
     * @param $totalAmount: Cancellation / Return Amount, All amount must be written for CANCELLATION. All amount or smaller amount (partial) must be written for RETURN.
     * @param $transactionId: Single ID for current new transaction.
     */
    public function send($type, $invoiceId, $totalAmount, $transactionId)
    {
        $this->transactionId = $transactionId;
        $client = new \SoapClient($this->serviceUrl);
        $cancelRefundObj = new TP_Islem_Iptal_Iade_Kismi($this->clientCode,$this->clientUsername,$this->clientPassword,$this->guid,$type,$invoiceId,$totalAmount);
        $this->response = $client->TP_Islem_Iptal_Iade_Kismi($cancelRefundObj);
    }

    public function parse()
    {
        $result = [];
        $results = [];
        $results["Success"] = False;
        $results["Response"] = [];
        $results["Response"]['AuthCode'] = self::ERR_TRX;
        $results["Response"]['OrderId'] = $this->transactionId;
        $results["Response"]['remoteTransactionId'] = '';
        $results['Error'] = [];
        $results['Error']['errMsg'] = self::ERR_TRX;
        $results['Error']['errCode'] = self::ERR_TRX;
        $results["Response"]['Bank'] = [];
        $results["Response"]['Bank']['responseCode'] = '';
        $results["Response"]['Bank']['responseMsg'] = '';
        $results["rawData"] = $this->response;

        //response has wrong format
        if(is_object($this->response) == False)
        {
            return $result;
        }
        //request has problem in parameter values
        elseif($this->response->TP_Islem_Iptal_Iade_KismiResult->Sonuc == '0')
        {
            $results['Error']['errMsg'] = $this->response->TP_Islem_Iptal_Iade_KismiResult->Sonuc_Str;
            $results['Error']['errCode'] = $this->response->TP_Islem_Iptal_Iade_KismiResult->Sonuc;
        }
        //success transaction and no need for 3D secure
        elseif($this->response->TP_Islem_Iptal_Iade_KismiResult->Sonuc == '1')
        {
            $results["Success"] = True;
            $results["Response"]['AuthCode'] = '';
            $results['Error']['errMsg'] = $this->response->TP_Islem_Iptal_Iade_KismiResult->Sonuc_Str;
            $results['Error']['errCode'] = '00';
            $results["Response"]['remoteTransactionId'] = '';
        }elseif($this->response->TP_Islem_Iptal_Iade_KismiResult->Sonuc <= 0){
            $results['Error']['errMsg'] = $this->response->TP_Islem_Iptal_Iade_KismiResult->Sonuc_Str;
            $results['Error']['errCode'] = $this->response->TP_Islem_Iptal_Iade_KismiResult->Sonuc;
        }

        //unexpected behavior should not happen
        return $results;
    }
}