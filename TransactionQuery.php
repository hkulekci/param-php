<?php
/**
 * Created by Payfull.
 * Date: 10/15/2018
 */

namespace param;

use param\paramBasics\TP_Islem_Sorgulama;

class TransactionQuery extends Config
{
    /**
     * TransactionQuery constructor.
     * @param $mode: string value TEST/PROD
     */
    public function __construct($mode)
    {
        parent::__construct($mode);
    }

    /**
     * send transaction query to get the transaction latest status update
     * @param $CLIENT_CODE: Terminal ID, It will be forwarded by param.
     * @param $CLIENT_USERNAME: User Name, It will be forwarded by param.
     * @param $CLIENT_PASSWORD: Password, It will be forwarded by param.
     * @param $guid: Key Belonging to Member Workplace
     * @param $invoiceId: Dekont_ID which is POSTed after successful transaction, optional.
     * @param $orderId: Posted Order ID after successful transaction.
     * @param $transactionId: Transaction ID sent to TP_Islem_Odeme method, optional.
     * @return array|bool
     */
    public function send($CLIENT_CODE, $CLIENT_USERNAME , $CLIENT_PASSWORD, $guid, $invoiceId, $orderId, $transactionId)
    {
        $client = new SoapClient($this->serviceUrl);
        $queryObj = new TP_Islem_Sorgulama($CLIENT_CODE, $CLIENT_USERNAME , $CLIENT_PASSWORD, $guid, $invoiceId, $orderId, $transactionId);
        $response = $client->TP_Islem_Sorgulama($queryObj);
        if(isset($response->TP_Islem_SorgulamaResult->DT_Bilgi->any) == False) return False;

        //parsing
        $xml = $response->TP_Islem_SorgulamaResult->DT_Bilgi->any;
        $xmlStr = "<?xml version='1.0' standalone='yes'?><root>$xml</root>";
        $xmlStr    = str_replace(["diffgr:","msdata:"],'', $xmlStr);
        $data = @simplexml_load_string($xmlStr);
        if($data == False) return False;

        //continue parsing
        $results = $data->diffgram->NewDataSet;
        return (array)$results;
    }
}