<?php
    require_once "db.php";    
        
    //Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));

    //Attempt to decode the incoming RAW post data from JSON.
    $decoded = json_decode($content, true); 

    $visitID = $decoded[0]->visitID;
    $visitDate = date("Y-m-d");
    $visitTime = date("h:i:s");

    $dentalInfo = $decoded[0]->dentalInfo;

    $practicioner = $decoded[0]->practicioner;

    $sql = "UPDATE visit (";
    $values = ") VALUES (";

    if (!empty($visitDate)){
        $sql .= "VisitDate = '$visitDate',";
    }
    if (!empty($visitTime)){
        $sql .= "VisitTime = '$visitTime',";
    }
    if (!empty($dentalInfo)) {
        $sql .= "Assesment = '$dentalInfo',";
    }
    
    $sql .= "WHERE VistID = '$visitID'";
    	
    try{
        $stmt = mysqli_prepare($connection, $sql);
        if(mysqli_stmt_execute($connection, $sql)){
            echo true;
        }
    } catch(Error $e){
        echo false;
    } finally {
        mysqli_stmt_close();
        mysqli_close();
    }
?>