<?php
include 'common.php';

function get_game_user($server_id, $appota_userid, $appota_username) {
    $query = "SELECT * FROM game_user WHERE `server_id` like '".$server_id."' AND `appota_user_id` like '".$appota_userid."' AND `appota_user_name` like '".$appota_username."' LIMIT 1";        
    $list_user = select_db($query);
    $response = array();    
    // Already be user
    if (count($list_user) > 0) {
        $user_info = $list_user[0];        
        $response = array(
            "game_user_name" => $user_info[0],
            "level" => $user_info[3],            
            "server_id" => $user_info[4],            
            "gold" => $user_info[5],            
            "diamon" => $user_info[6],                                    
            "is_vip" => $user_info[7],                                                
            "error_code" => 0,
        );
    }
    else {  // New user   
        $response = array(
            "error_code" => 1,
            "message" => "Please create new user",            
        );             
    }
    return json_encode($response);
}

function create_game_user($server_id, $appota_userid, $appota_username) {
      // Generate game_user_name
      $game_user_name = "game_user_".$appota_userid;
      $query = sprintf("INSERT INTO `game_user`(`game_user_name`, `appota_user_name`, `appota_user_id`, `server_id` ) VALUES ('%s', '%s', '%s','%s')", $game_user_name, $appota_username, $appota_userid, $server_id);
      $result = query_db($query);
      $response = array();
      if(!$result) {
          $response = array(
              "error_code" => 1,
              "message" => "Error creating user",
          );
      }
      else {
          $response = get_game_user($server_id, $appota_userid, $appota_username);
      }
      return $response;
}

if (isset($_GET["action"]) and $_GET["action"] == "get_game_user") {
    die(get_game_user($_GET["server_id"], $_GET["appota_user_id"], $_GET["appota_user_name"]));
}

if (isset($_POST["action"]) and $_POST["action"] == "create_game_user") {
    die(create_game_user($_POST["server_id"], $_POST["appota_user_id"], $_POST["appota_user_name"]));    
}
?>