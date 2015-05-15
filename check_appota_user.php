<?php
include 'common.php';
function check_appota_user($appota_access_token, $appota_userid, $appota_username) {
    echo (time()."<br>");
    $verify_result =  verify_appota_user($appota_access_token, $appota_userid, $appota_username);
    echo (time()."<br>");    
    if ($verify_result) {
        // Valid Appota User -> check valid user -> return list server and re
        // Get game user respect to appota user
        $list_server = get_list_server();
        $response = array(
            "error_code" => "0",
            "list_server"=>$list_server
        );
        die(json_encode($response));
    }
    else {
        $response = array(
            "error_code" => "1",
            "message" => "Invalid Appota User"
        );
        die(json_encode($response));
    }
}

// Verify user with Appota User API
function verify_appota_user($appota_access_token, $appota_userid, $appota_username) {
    $url = sprintf('https://api.appota.com/game/get_user_info?access_token=%s', $appota_access_token);
    $result = call_curl_get($url, null);
    return ($result["error_code"] == 0 and $result["data"]["username"] == $appota_username and $result["data"]["user_id"]);
}

if (isset($_POST["appota_access_token"]) and isset($_POST["appota_user_id"])  and isset($_POST["appota_user_name"]) ) {
    die(check_appota_user($_POST["appota_access_token"], $_POST["appota_user_id"], $_POST["appota_user_name"]));    
}
?>