<?php

include 'common.php';
/*  
*   Sample of a card transaction IPN
*   Other type of transaction (Ebank, SMS, ...) can be verified with the same steps 
*   Format and detail about the POST request
*   https://github.com/appota/ios-game-sdk/wiki/card-payment-method
*   In this example we use samples CLIENT_KEY, API_KEY, CLIENT_SECRET
*   Replace it with yours in implementation
*/

define('CLIENT_KEY', '');
define('API_KEY', 'K-A164834-U00000-SMB02Y-809329F27CB81310');
define('CLIENT_SECRET', 'f986eda4b0107fd3ab3b9f9242dc9b57054914725');

function check_appota_card_payment($fields) {
        // check params
        $trans_id           = $fields['transaction_id'];
        $trans_type         = $fields['transaction_type'];
        $status             = $fields['status'];
        $sandbox            = $fields['sandbox'];
        $amount             = $fields['amount'];
        $state              = $fields['state'];
        $target             = $fields['target'];
        $currency           = $fields['currency'];
        $country_code       = $fields['country_code'];
        $card_code          = $fields['card_code'];
        $card_serial        = $fields['card_serial'];
        $card_vendor        = $fields['card_vendor'];
        $hash               = $fields['hash'];
            
        // check transaction status
        if ( $status != 1) {
            die('Transaction fail');
        }
        
        // check hash
        $check_hash = md5( $amount . $card_code . $card_serial . $card_vendor . $country_code .
                            $currency . $sandbox . $state . $status . $target . $trans_id.
                            $trans_type . CLIENT_SECRET );
                            
        if ( $check_hash != $hash )
            die('Check hash fail');
                        
        // If hash is ok, verify transaciton
        if (!verify_appota_transaction($trans_id, $amount, $state, $target))
            die('Verify transaction fail');            
        
        // If function is verified proceed gold increment based on "amount", "state"        
        die('Success');
}

// Verify transaction_id, amount, state, target with Appota Confirm API
function verify_appota_transaction($transaction_id, $amount, $state, $target) {
    $url = sprintf('https://pay.appota.com/payment/confirm?api_key=%s&lang=en', API_KEY);
    $fields = array('transaction_id' => $transaction_id);
    $result = call_curl_post($url, $fields);
    
    if ($result['status'] == 1 and $result['data']['amount'] == $amount and $result['data']['state'] == $state and $result['data']['target']) {
        return true;
    }
    return false;
}

$fields = array('transaction_id' => 'C7454F92BC2B269A', 
                'transaction_type' => 'CARD',
                'status' => '1',
                'sandbox' => '0',
                'amount' => '10000',
                'state'  => '',
                'target' => "username:XuanXuXu|userid:2618078",
                'currency' => "VND",
                'country_code' => "VN", 
                'card_code' => "ABCDEF",
                'card_serial' => "123456",
                'card_vendor' => "mobifone", 
                'hash'       => "55be7cfd9517ad9217f8968e7ee268b8",);
check_appota_card_payment($fields);

if (isset($fields['transaction_type'])) {
    $transaction_type = $fields['transaction_type'];
    switch($transaction_type){
        case 'CARD':
            die(check_appota_card_payment());
            break;
    }
}
?>