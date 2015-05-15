<?php

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

function check_appota_card_payment() {
        // check params
        $trans_id           = $_POST['transaction_id'];
        $trans_type         = $_POST['transaction_type'];
        $status             = $_POST['status'];
        $sandbox            = $_POST['sandbox'];
        $amount             = $_POST['amount'];
        $state              = $_POST['state'];
        $target             = $_POST['target'];
        $currency           = $_POST['currency'];
        $country_code       = $_POST['country_code'];
        $card_code          = $_POST['card_code'];
        $card_serial        = $_POST['card_serial'];
        $card_vendor        = $_POST['card_vendor'];
        $hash               = $_POST['hash'];

        // check transaction status
        if ( $status != 1)
            die('Transaction fail');
        
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

// cURL function 
function call_curl_post($url,$data_array){
    $data = '';
    foreach($data_array as $key=>$value) { $data .= $key.'='.$value.'&'; }
    rtrim($data,'&');

    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    $info = curl_exec($ch);    
    curl_close($ch);    
    return json_decode($info, true);
}

check_appota_card_payment();
?>