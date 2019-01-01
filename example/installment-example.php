<?php
include_once __DIR__ . '/../vendor/autoload.php';

$bin = new \param\GetInstallmentPlanForMerchant(
    '10738',
    'Test',
    'Test',
    '0c13d406-873b-403b-9c09-a5766840d98c',
    'TEST'
);

$installmentResponse = $bin->send();

echo 'Installment List' . PHP_EOL;
echo sprintf("%20s\t%10s\t%10s\t%10s\t%10s\t%20s\t%10s\n", 'Id', 'Installment Id', 'Start Date', 'End Date', 'VPos Id', 'Bank Name', 'MO_01');
foreach ($installmentResponse as $installment) {
    echo sprintf("%20s\t%10s\t%10s\t%10s\t%10s\t%20s\t%10s\n",
        $installment['id'], $installment['installmentId'], $installment['startDate'], $installment['endDate'],
        $installment['vPosId'], $installment['bankName'], $installment['MO_01']);
}
