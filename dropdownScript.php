<?php

    require "db.php";
    
    // Receive the RAW post data.
    $json = trim(file_get_contents("php://input"));
    //$json = json_decode($_POST["x"], false);
    
    // Attempt to decode the incoming RAW post data from JSON.
    $request = json_decode($json, true); 
    
    // which menu do we want?
    if ($request["menu"] == "village") {
        $sql = "SELECT Village FROM tbl_village";
    } else if ($request["menu"] == "newpatients") {
        $sql = "SELECT * FROM tbl_patient";
    } else if ($request["menu"] == "patients") {
        $sql = "SELECT DISTINCT A.* FROM tbl_patient A INNER JOIN tbl_visit B on A.PatientID = B.PatientID";
    } else if ($request["menu"] == "visits") {
        $sql = "SELECT VisitID FROM tbl_visit WHERE PatientID = '" . $request["id"] . "'";
    } else if ($request["menu"] == "dispensaries") {
        $sql = "SELECT * FROM tbl_dispensary";
    } else {
        $response->reason = "Invalid menu request";
        echo json_encode($response);
        die;
    }

    try {
        
        // grab the data
        $result = $connect->query($sql);
        
        // check for responses
        if (@$result->num_rows > 0) {
            // build response object
            // which menu?
            if ($request["menu"] == "village") {
                // add the entries to the response object
                while ($row = $result->fetch_assoc()) {
                    array_push($response->entries, $row["Village"]);
                }
            } else if (($request["menu"] == "newpatients") || ($request["menu"] == "patients")) {
                // construct new object to add to the array
                class Patient {
                    public $id = 0;
                    public $name = "";
                }
                
                // add the entries to the response object
                while ($row = $result->fetch_assoc()) {
                    
                    // new patient
                    $pat = new Patient();
                    $pat->id = $row["PatientID"];
                    $pat->name = $row["FirstName"] . " " . $row["LastName"];
                    
                    array_push($response->entries, $pat);
                }

            } else if ($request["menu"] == "visits") {
                // add the entries to the response object
                while ($row = $result->fetch_assoc()) {
                    array_push($response->entries, $row["VisitID"]);
                }
            } else if ($request["menu"] == "dispensaries") {
                // add the entries to the response object
                while ($row = $result->fetch_assoc()) {
                    array_push($response->entries, $row["Dispensary"]);
                }
            }
        } else {
            // no entries
        }
        
        // set success to true
        $response->success = true;
        
    } catch(Error $e) {
        // place error reason
        $response->reason = "Database entry error";
    } finally {
        
        // close everything up
        //mysqli_stmt_close();
        mysqli_close($connect);
    }

    // send data back
    echo json_encode($response);
?>