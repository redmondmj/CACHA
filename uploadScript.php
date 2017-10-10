<?php
    require "db.php";
    
    // Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));
    
    // Attempt to decode the incoming RAW post data from JSON.
    $data = json_decode($content, true); 
    
    // which request is it?
    if ($data["upload"] == "basic") {
        

        // build the enourmous sql statement
        $sql = "INSERT INTO tbl_visit (";
        $values = ") VALUES (";

        if (!empty($data["dispensary"])) {
            $sql .= "VisitedDispensary,";
            $values .= $data["dispensary"] . ",";
        }

        // stations
        if (!empty($data["test"])) {
            $sql .= "TriageTesting,";
            $values .= $data["test"] . ",";
        }

        if (!empty($data["med1"])) {
            $sql .= "TriageMedical,";
            $values .= $data["med1"] . ",";
        }

        if (!empty($data["med2"])) {
            $sql .= "TriageMedical2,";
            $values .= $data["med2"] . ",";
        }

        if (!empty($data["gyn"])) {
            $sql .= "TriageGYN,";
            $values .= $data["gyn"] . ",";
        }

        if (!empty($data["opht"])) {
            $sql .= "TriageOPHT,";
            $values .= $data["opht"] . ",";
        }

        if (!empty($data["dent"])) {
            $sql .= "TriageDENT,";
            $values .= $data["dent"] . ",";
        }

        if (!empty($data["triagev"])) {
            $sql .= "TriageVenDis,";
            $values .= $data["triagev"] . ",";
        }

        // standard
        if (!empty($data["weight"])) {
            $sql .= "Weight,";
            $values .= $data["weight"] . ",";
        }
        if (!empty($data["temp"])) {
            $sql .= "Temperature,";
            $values .= $data["temp"] . ",";
        }
        if (!empty($data["BPTop"])) {
            $sql .= "Systolic,";
            $values .= $data["BPTop"] . ",";
        }
        if (!empty($data["BPBottom"])) {
            $sql .= "Diastolic,";
            $values .= $data["BPBottom"] . ",";
        }
        if (!empty($data["glucose"])) {
            $sql .= "Glucose,";
            $values .= $data["glucose"] . ",";
        }
        if (!empty($data["heart"])) {
            $sql .= "HeartRate,";
            $values .= $data["heart"] . ",";
        }

        // child info
        if (!empty($data["period"])) {
            $sql .= "LastPeriod,";
            $values .= $data["period"] . ",";
        }
        if (!empty($data["pregnant"])) {
            $sql .= "Pregnant,";
            $values .= $data["pregnant"] . ",";
        }
        if (!empty($data["breast"])) {
            $sql .= "Breastfeed,";
            $values .= $data["breast"] . ",";
        }
        if (!empty($data["grav"])) {
            $sql .= "Gravida,";
            $values .= $data["grav"] . ",";
        }
        if (!empty($data["para"])) {
            $sql .= "Para,";
            $values .= $data["para"] . ",";
        }
        if (!empty($data["abortus"])) {
            $sql .= "Abortus,";
            $values .= $data["abortus"] . ",";
        }
        if (!empty($data["living"])) {
            $sql .= "NumLivingChildren,";
            $values .= $data["living"] . ",";
        }

        // complaint
        if (!empty($data["complaint"])) {
            $sql .= "ChiefComplaint,";
            $values .= $data["complaint"] . ",";
        }

        // clean up the sql
        $sql = substr_replace($sql ,'',-1);
        $values = substr_replace($values ,")",-1);

        // stick it all together
        $sql .= $values;

    } else if ($data["upload"] == "basic") {
        $sql = "SELECT * FROM tbl_visit WHERE VisitID = " . $data["id"];
    }
    

    
    try {
        
        // run the query
        $result = $connect->query($sql);
        
        // check response
        if ($result) {
            $response->success = true;
        } else {
            $response->reason = $sql;
        }
        
    } catch (Error $e) {
        $response->reason = "Possible Query Error";
        echo json_encode($response);
    } finally {
        mysqli_close($connect);
    }

    // send data back
    echo json_encode($response);
?>
