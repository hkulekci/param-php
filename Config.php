<?php
/**
 * Created by Payfull.
 * Date: 10/15/2018
 */

namespace param;


class Config
{
    const TEST_SERVICE_URL = 'https://dmzws.ew.com.tr/turkpos.ws/service_turkpos_test.asmx?wsdl';
    const PROD_SERVICE_URL = 'https://dmzws.ew.com.tr/turkpos.ws/service_turkpos.asmx?wsdl';

    const TEST_MODE_FLAG = 'TEST';
    const PROD_MODE_FLAG = 'PROD';

    public $serviceUrl;
    public $mode;//TEST/PROD

    public function __construct($mode)
    {
        $this->mode = $mode;
        $this->serviceUrl = ($mode == self::TEST_MODE_FLAG)?self::TEST_SERVICE_URL:self::PROD_SERVICE_URL;
    }
}