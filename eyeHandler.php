<?php
    require_once "db.php";    
        
    //Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));

    //Attempt to decode the incoming RAW post data from JSON.
    $decoded = json_decode($content, true); 

    $visitID = $decoded[0]->visitID;
    $visitDate = date("Y-m-d");
    $visitTime = date("h:i:s");

    $diagnosis = $decoded[0]->diagnosis;
    $val1 = $decoded[0]->val1;
    $val2 = $decoded[0]->val2;
    $val3 = $decoded[0]->val3;

    $practicioner = $decoded[0]->practicioner;

    $sql = "UPDATE visit (";
    if (!empty($visitDate)){
        $sql .= "VisitDate = '$visitDate',";
    }
    if (!empty($visitTime)){
        $sql .= "VisitTime = '$visitTime',";
    }
    if (!empty($patientID)){
        $sql .= "PatientID = '$patientID',";
    }
    if (!empty($diagnosis)) {
        $sql .= "############### = '$diagnosis',";
    }
    if (!empty($val1)) {
        $sql .= "############### = '$val1',";
    }
    if (!empty($val2)) {
        $sql .= "############### = '$val2',";
    }
    if (!empty($val3)) {
        $sql .= "############### = '$val3',";
    }
    if (!empty($practicioner)){
        $sql .= "Practicioners = '$practicioner',";
    }
    if(substr_compare($sql, ",", -1, 1)){
        substr_replace($sql ,")",-1);
        substr_replace($values ,")",-1);
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