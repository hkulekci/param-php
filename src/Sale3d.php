<?php
/**
 * Created by Payfull.
 * Date: 10/29/2018
 */

namespace param;

use param\paramBasics\TP_Islem_Odeme;
use param\paramBasics\SHA2B64;

class Sale3d extends Config
{
    protected $response;//request response
    const ERR_TRX = 'ERR_TRX';
    const NONE_3D_FLAG = 'NONSECURE';
    protected $transactionId;
    public $need3DRedirection = False;
    protected $urlTo3DRedirection;

    /**
     * Sale constructor.
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
     * send sale transaction
     * @param $vPosId: is the VirtualPOS_ID value of the Card Brand selected from the customer method.
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
    public function send($vPosId,$cardHolder,$cardNumber,
                         $cardExpMonth,$cardExpYear,$cvc,$cardHolderPhone,$failUrl,$successURL,$orderId,
                         $orderDescription,$installments,$total,$generalTotal,$transactionId,$ipAddress,
                         $referenceUrl,$extraData1,$extraData2,$extraData3,$extraData4,$extraData5)
    {
        $this->transactionId = $transactionId;
        $client = new \SoapClient($this->serviceUrl);

        $saleObj = new TP_Islem_Odeme($this->clientCode,$this->clientUsername,$this->clientPassword,$vPosId,$this->guid,
            $cardHolder,$cardNumber,$cardExpMonth,$cardExpYear,$cvc,$cardHolderPhone,$failUrl,$successURL,$orderId,
            $orderDescription,$installments,$total,$generalTotal,$transactionId,$ipAddress,
            $referenceUrl,$extraData1,$extraData2,$extraData3,$extraData4,$extraData5);

        $securityString = $this->clientCode.$this->guid.$vPosId.$installments.$total.$generalTotal.$orderId.$failUrl.$successURL;
        $shaString = new SHA2B64($securityString, $this->clientCode, $this->clientUsername, $this->clientPassword);
        $saleObj->Islem_Hash = $client->SHA2B64($shaString)->SHA2B64Result;
        $this->response = $client->TP_Islem_Odeme($saleObj);
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
        $results["Response"]['Bank']['responseMsg']  = '';
        $results["rawData"] = $this->response;

        //response has wrong format
        if(is_object($this->response) == False)
        {
            return $result;
        }
        //request has problem in parameter values
        elseif($this->response->TP_Islem_OdemeResult->Sonuc == '0')
        {
            $results['Error']['errMsg'] = $this->response->TP_Islem_OdemeResult->Sonuc_Str;
            $results['Error']['errCode'] = $this->response->TP_Islem_OdemeResult->Sonuc;
        }
        //success transaction and no need for 3D secure
        elseif($this->response->TP_Islem_OdemeResult->Sonuc == '1' AND $this->response->TP_Islem_OdemeResult->Islem_ID > 0 AND $this->response->TP_Islem_OdemeResult->Islem_ID == self::NONE_3D_FLAG)
        {
            $results["Success"] = True;
            $results["Response"]['AuthCode'] = '';
            $results['Error']['errMsg'] = $this->response->TP_Islem_OdemeResult->Sonuc_Str;
            $results['Error']['errCode'] = '00';
            $results["Response"]['remoteTransactionId'] = $this->response->TP_Islem_OdemeResult->Islem_ID;
        }
        //success transaction but need 3D secure redirection
        elseif($this->response->TP_Islem_OdemeResult->Sonuc == '1' AND $this->response->TP_Islem_OdemeResult->Islem_ID > 0 AND $this->response->TP_Islem_OdemeResult->UCD_URL != self::NONE_3D_FLAG)
        {
            $results["Success"] = True;
            $results["Response"]['AuthCode'] = '';
            $results['Error']['errMsg'] = $this->response->TP_Islem_OdemeResult->Sonuc_Str;
            $results['Error']['errCode'] = '00';
            $results["Response"]['remoteTransactionId'] = $this->response->TP_Islem_OdemeResult->Islem_ID;
            $this->need3DRedirection = True;
            $this->urlTo3DRedirection = $this->response->TP_Islem_OdemeResult->UCD_URL;
        }elseif($this->response->TP_Islem_OdemeResult->Sonuc <= 0){
            $results['Error']['errMsg'] = $this->response->TP_Islem_OdemeResult->Sonuc_Str;
            $results['Error']['errCode'] = $this->response->TP_Islem_OdemeResult->Sonuc;
        }

        //unexpected behavior should not happen
        return $results;
    }

    public function redirectTo3dSecure()
    {
        $output = '<form action="'.(string)$this->urlTo3DRedirection.'" method="post" name="frm"></form>';
        $output .= '<script language="JavaScript">document.frm.submit();</script>';
        echo $output;
        exit();
    }
}