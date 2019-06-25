<?php
include_once __DIR__ . '/../vendor/autoload.php';

$bin = new \param\Bin(
    '10738',
    'Test',
    'Test',
    '0c13d406-873b-403b-9c09-a5766840d98c',
    'TEST'
);

$bin->send();
$binResponse = $bin->parse();

echo 'Bin List' . PHP_EOL;
echo sprintf("%10s\t%10s\t%s\n", 'Bin', 'Pos Id', 'Pos Name');
foreach ($binResponse as $bin) {
    echo sprintf("%10s\t%10s\t%s\n", $bin['bin'], $bin['posId'], $bin['posName']);
}

echo PHP_EOL. PHP_EOL;
$bin = new \param\Bin(
    '10738',
    'Test',
    'Test',
    '0c13d406-873b-403b-9c09-a5766840d98c',
    'TEST'
);
$bin->send('424242');
$binResponse = $bin->parse();

echo 'Bin List' . PHP_EOL;
echo sprintf("%10s\t%10s\t%s\n", 'Bin', 'Pos Id', 'Pos Name');
foreach ($binResponse as $bin) {
    echo sprintf("%10s\t%10s\t%s\n", $bin['bin'], $bin['posId'], $bin['posName']);
}
