<?php
include 'vendor/autoload.php';

/**
 * @param $CLIENT_CODE: Terminal ID, It will be forwarded by param.
 * @param $CLIENT_USERNAME: User Name, It will be forwarded by param.
 * @param $CLIENT_PASSWORD: Password, It will be forwarded by param.
 * @param $GUID: Key Belonging to Member Workplace
 * @param $MODE: PROD/TEST
 **/
$saleObj = new param\Sale(
    '10738',
    'Test',
    'Test',
    '0c13d406-873b-403b-9c09-a5766840d98c',
    'TEST'
);

$saleObj->send(
    '1029',
    'name surname',
    '4242424242424242',
    '12',
    '2019',
    '100',
    '+905554443322',
    'http://127.0.0.1/test.php',
    'http://127.0.0.1/test.php',
    '2222455',
    'description',
    '1',
    '100,00',
    '100,00',
    '1234567',
    '127.0.0.1',
    '',
    '123',
    '',
    '',
    '',
    ''
);

$paramResponse = $saleObj->parse();

var_dump($paramResponse);
