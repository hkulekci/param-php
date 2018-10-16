<?php
/**
 * Created by PhpStorm.
 * User: mohmm
 * Date: 10/16/2018
 * Time: 5:15 PM
 */

namespace param;

use param\paramBasics\TP_Ozel_Oran_Liste;

class GetInstallmentPlanForMerchant extends Config
{
    public $guid;//Key Belonging to Member Workplace

    public function __construct($mode)
    {
        parent::__construct($mode);
    }

    /**
     * send request to get the installments plan list for Merchant
     * @param $guid: Key Belonging to Member Workplace
     * @return array|bool
     */
    public function send($guid)
    {
        $client = new SoapClient($this->serviceUrl);
        $installmentsListObj = new TP_Ozel_Oran_Liste($guid);
        $response = $client->TP_Ozel_Oran_Liste($installmentsListObj);
        if(isset($response->TP_Ozel_Oran_ListeResult) == False) return False;

        //parsing
        $xml = $response->TP_Ozel_Oran_ListeResult;
        $xmlStr = "<?xml version='1.0' standalone='yes'?><root>$xml</root>";
        $xmlStr    = str_replace(["diffgr:","msdata:"],'', $xmlStr);
        $data = @simplexml_load_string($xmlStr);
        if($data == False) return False;

        //continue parsing
        $results = $data->diffgram->NewDataSet;
        return (array)$results;
    }

}