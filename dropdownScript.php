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
        $sql = "SELECT DISTINCT tbl_patient.FirstName, tbl_patient.LastName, tbl_patient.PatientID FROM tbl_patient LEFT JOIN tbl_visit ON tbl_patient.PatientID=tbl_visit.PatientID WHERE VisitID IS NOT NULL ORDER BY tbl_patient.LastName";
    } else if ($request["menu"] == "visits") {
        $sql = "SELECT VisitID FROM tbl_visit WHERE PatientID = '" . $request["id"] . "' ORDER BY VisitID DESC";
    } else if ($request["menu"] == "dispensaries") {
        $sql = "SELECT * FROM tbl_dispensary";
    } else if ($request["menu"] == "practitioners") {
        $sql = "SELECT * FROM tbl_practitioner";
    } else if ($request["menu"] == "drugs") {
        $sql = "SELECT * FROM tbl_drugs";
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

                    if (!empty($row["LastName"])) {
                        $pat->name = $row["LastName"];
                        if (!empty($row["FirstName"])) {$pat->name .= ", " . $row["FirstName"];}
                    } else if (!empty($row["FirstName"])) {$pat->name = $row["FirstName"];
                    } else {$pat->name = "No Name";}

                    /*
                    if (!empty($row["FirstName"])) {
                        $pat->name = $row["FirstName"];
                        if (!empty($row["LastName"])) {$pat->name .= " " . $row["LastName"];}
                    } else if (!empty($row["LastName"])) {$pat->name = $row["LastName"];
                    } else {$pat->name = "No Name";}
                    */
                    
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
            } else if ($request["menu"] == "practitioners") {

                // build new object to pass
                class Practitioner {
                    public $id = 0;
                    public $title = "";
                    public $fname = "";
                    public $lname = "";
                }

                // add the entries to the response object
                while ($row = $result->fetch_assoc()) {

                    // new practitioner
                    $medic = new Practitioner();
                    $medic->id = $row["PractitionerID"];
                    if (!empty($row["Title"])) {$medic->title = $row["Title"];}
                    if (!empty($row["FirstName"])) {$medic->fname = $row["FirstName"];}
                    if (!empty($row["LastName"])) {$medic->lname = $row["LastName"];}

                    // add the practitioner object to the response
                    array_push($response->entries, $medic);
                }
            } else if ($request["menu"] == "drugs") {

                // construct new object to add to the response
                class Drugs {
                    public $id = 0;
                    //public $value = "";
                    public $display = "";
                }

                while ($row = $result->fetch_assoc()) {

                    // build the list object
                    $drugs = new Drugs();
                    $drugs->id = $row["drugID"];
                    $quantity = $row["drugQuantity"];
                    $name = $row["drugName"];
                    $direct = $row["drugDirections"];
                    //$drugs->value = ;
                    $drugs->display = $quantity . " " . $name . " (" . $direct . ")";

                    array_push($response->entries, $drugs);
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