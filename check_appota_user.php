<?php
include 'common.php';
function check_appota_user($appota_access_token, $appota_userid, $appota_username) {
    $verify_result =  verify_appota_user($appota_access_token, $appota_userid, $appota_username);
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

$data = urldecode(file_get_contents("php://input"));
$object = array();
parse_str($data, $object);

if (isset($object["appota_access_token"]) and isset($object["appota_user_id"])  and isset($object["appota_user_name"]) ) {
   die(check_appota_user($object["appota_access_token"], $object["appota_user_id"], $object["appota_user_name"]));    
}
?>