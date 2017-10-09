<?php
    require_once "db.php";
    
    // Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));
    
    // Attempt to decode the incoming RAW post data from JSON.
    $data = json_decode($content, true); 
    
    $firstName = $data["first"];
    $lastName = $data["last"];
    $village = $data["village"];
    $birth = $data["age"];
    $sex = $data["sex"];

    $sql = "INSERT INTO tbl_patient (";
    $values = ") VALUES (";

    if (!empty($firstName)){
        $sql .= "FirstName,";
        $values .= "'$firstName',";
    }
    if (!empty($lastName)) {
        $sql .= "LastName,";
        $values .= "'$lastName',";
    }
    if (!empty($village)) {
        $sql .= "Village,";
        $values .= "'$village',";
    }
    if (!empty($birth)){
        $sql .= "Birthday,";
        $values .= "'$birth',";
    }
    if (!empty($sex)){
        $sql .= "Sex,";
        $values .= "'$sex',";
    }

    $sql = substr_replace($sql ,'',-1);
    $values = substr_replace($values ,")",-1);

    $sql .= $values;
    
    try {
        
        // run the query
        $result = $connect->query($sql);
        
        // check response
        if ($result) {
            $response->success = true;
        } else {
            $response->reason = $sql;
        }
        
    } catch(Error $e){
        $response->reason = "Possible Query Error";
        echo json_encode($response);
    } finally {
        mysqli_close($connect);
    }

    // send data back
    echo json_encode($response);
?>
