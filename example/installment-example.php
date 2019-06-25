<?php
include_once __DIR__ . '/../vendor/autoload.php';

$installment = new \param\GetInstallmentPlanForMerchant(
    '10738',
    'Test',
    'Test',
    '0c13d406-873b-403b-9c09-a5766840d98c',
    'TEST'
);

$installment->send();
$installmentResponse = $installment->parse();

echo 'Installment List' . PHP_EOL;
echo sprintf(
    "%20s\t%10s\t%10s\t%20s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\n",
    'Id', 'Installment Id', 'VPos Id', 'Bank Name', 'MO_01', 'MO_02', 'MO_03', 'MO_04', 'MO_05', 'MO_06', 'MO_07', 'MO_08', 'MO_09', 'MO_10', 'MO_11', 'MO_12');
foreach ($installmentResponse as $key => $installment) {
    $installment = $installment[0];
    echo sprintf("%20s\t%10s\t%10s\t%20s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\t%8s\n",
        $installment['@attributes']['id'], $installment['Ozel_Oran_ID'], $installment['SanalPOS_ID'], $installment['Kredi_Karti_Banka'],
        $installment['MO_01'], $installment['MO_02'], $installment['MO_03'], $installment['MO_04'],
        $installment['MO_05'], $installment['MO_06'], $installment['MO_07'], $installment['MO_08'],
        $installment['MO_09'], $installment['MO_10'], $installment['MO_11'], $installment['MO_12']);
}
