<?php
function connect_db() {
    $servername = "localhost";
    $username = "root";
    $password = "abc123";
    $dbname = "appota_game_test";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;    
}

function query_db($query) {
    $conn = connect_db();
    $result = $conn->query($query);
    $list_server = array();
    if (!$result) {
       throw new My_Db_Exception('Database error: ' . mysql_error());
    }         
    $conn->close();    
    return $result;    
}

function select_db($query) {
    $result = query_db($query);
    while($row = $result->fetch_row()){
        $list_server[] = $row;
    }
    $result->close();   
    return $list_server;
    
}

function get_list_server() {
    $conn = connect_db();
    $sql = "SELECT * FROM `server`";
    $result = $conn->query($sql);
    $list_server = array();
    if (!$result) {
       throw new My_Db_Exception('Database error: ' . mysql_error());
    }
    
    while($row = $result->fetch_row()){
        $list_server[] = array(
            'server_name'=>$row[0],
            'server_id'=>$row[1]
        );
    }
    $result->close();
    $conn->close();   
    return $list_server;
}

// function get_game_user($appota_user_id) {
//     $conn = connect_db();
//     $sql = "SELECT * FROM `game_user` LIMIT 1";
//     $result = $conn->query($sql);        
// }


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

function call_curl_get($url,$data_array){
    $data = '';
    if ($data_array != null) {
        foreach($data_array as $key=>$value) { $data .= $key.'='.$value.'&'; }
        rtrim($data,'&');        
    }    

    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    $info = curl_exec($ch);    
    curl_close($ch);    
    return json_decode($info, true);
}
?>