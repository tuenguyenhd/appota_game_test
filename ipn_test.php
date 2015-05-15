<!-- 
Test function for IPN card payment run in localhost
In browser use: http://localhost/ipn_test.php
 -->

<?php
include 'common.php';

function test_card_ipn() {
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
    
    print call_curl_post("http://localhost/appota_game_test/ipn.php", $fields);
}

test_card_ipn();
?>
