<?php
    
    //header("Content-Type: application/json; charset=UTF-8");

    // the user, password, host, and name for the database
    $mysql_user = "cacha_web";
    $mysql_pass = "p2DaavTC03Vr";
    $mysql_host = "localhost:3306";
    $db_name = "cacha_medrec";
    
    // build the response object
    class ResponseObject {
        public $success = false;
        public $reason = "";
        public $entries = array();
    }

    $response = new ResponseObject();
    
    //http://php.net/manual/en/language.operators.errorcontrol.php
    @$connect = new mysqli($mysql_host, $mysql_user, $mysql_pass, $db_name);
    if ($connect->connect_error) {
        $response->reason = $connect->connect_error;
        echo json_encode($response);
        die;
    }

?>
