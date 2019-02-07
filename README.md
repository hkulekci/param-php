### API Documentation 
https://dev.param.com.tr/en

### For Param Sign-up 
https://param.com.tr/


### Installation
So far there is no composer, you can download the [latest release](https://github.com/T4U/param-php/releases). Then, 
to use the bindings, include the `loader.php` file.
```php
require_once('/path/to/param-php/src/loader.php');
```

### Usage

```php
    /**
     * @param $CLIENT_CODE: Terminal ID, It will be forwarded by param.
     * @param $CLIENT_USERNAME: User Name, It will be forwarded by param.
     * @param $CLIENT_PASSWORD: Password, It will be forwarded by param.
     * @param $GUID: Key Belonging to Member Workplace
     * @param $MODE: PROD/TEST
     **/
 
    $saleObj = new param\Sale($CLIENT_CODE, $CLIENT_USERNAME, $CLIENT_PASSWORD, $GUID, $MODE);
```
```php
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
         
    $saleObj->send(
        $vPosId,
        $cardHolder,
        $cardNumber,
        $cardExpMonth,
        $cardExpYear,
        $cvc,
        $cardHolderPhone,
        $failUrl,
        $successURL,
        $orderId,
        $orderDescription,
        $installments,
        $total,
        $generalTotal,
        $transactionId,
        $ipAddress,
        $referenceUrl,
        $extraData1,
        $extraData2,
        $extraData3,
        $extraData4,
        $extraData5
    );
    
``` 

```php
    //parsing the results
    $paramResponse = $saleObj->parse();                    
```
For saving card you can use this function note saving card and pay by saved card  using different end points  

for saving card 
```php
     $savCardOpj=new SaveCard(
        $config->CLIENT_CODE,
        $config->CLIENT_USERNAME,
        $config->CLIENT_PASSWORD,
        $config->guid,
        $testMode?"PROD":"TEST"
    );
    $savCardOpj->send(
        $cardHolder,
        $cardNumber,
        $cardMonth,
        $cardYear,
        $cardCVC
    );
    $result=$savCardOpj->parse();
```
it give u as a response the card guid and you can use it to pay with it
for paying with saved credit card 
```php
    $saleWTOpj = new SaleWithToken(
        $config->CLIENT_CODE,
        $config->CLIENT_USERNAME,
        $config->CLIENT_PASSWORD,
        $config->guid,
        $testMode?"PROD":"TEST"
    );
    $saleWTOpj->sendWithToken(
        $SanalPOS_ID,
        $kkSahibi,
        $KK_GUID,
        $kkCvc,
        $kkSahibiGsm,
        $hataUrl,
        $basariliUrl,
        $siparisId,
        $siparisAciklama,
        $taksit,
        $islemtutar,
        $toplamTutar,
        $islemid,
        $ipAdr,
        $odemeUrl,
        $use3d,
    );
    $result = $saleWTOpj->parse();
    //$result ['UCD_URL'] 
```
this property you will redirect the browser to it for 3d page 
