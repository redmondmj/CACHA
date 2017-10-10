<?php
    require "db.php";
    
    // Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));
    
    // Attempt to decode the incoming RAW post data from JSON.
    $data = json_decode($content, true); 
    
    // which request is it?
    if ($data["upload"] == "basic") {
        
        $id = $data["patientid"];
        $dispensary = $data["dispensary"];
        $test = $data["test"];
        $med1 = $data["med1"];
        $med2 = $data["med2"];
        $gyn = $data["gyn"];
        $opht = $data["opht"];
        $dent = $data["dent"];
        $triagev = $data["triagev"];

        $weight = $data["weight"];
        $temp = $data["temp"];
        $bptop = $data["BPTop"];
        $bpbottom = $data["BPBottom"];
        $glucose = $data["glucose"];
        $heart = $data["heart"];

        $period = $data["period"];
        $preg = $data["pregnant"];
        $breast = $data["breast"];
        $grav = $data["grav"];
        $para = $data["para"];
        $abortus = $data["abortus"];
        $living = $data["living"];
        
        $complaint = $data["complaint"];
        
        // build the enourmous sql statement
        $sql = "INSERT INTO tbl_visit (PatientID,";
        $values = ") VALUES ('$id',";

        if (!empty($dispensary)) {
            $sql .= "VisitedDispensary,";
            $values .=  "'$dispensary',";
        }

        // stations
        if (!empty($test)) {
            $sql .= "TriageTesting,";
            $values .= "'$test',";
        }

        if (!empty($med1)) {
            $sql .= "TriageMedical,";
            $values .= "'$med1',";
        }

        if (!empty($med2)) {
            $sql .= "TriageMedical2,";
            $values .= "'$med2',";
        }

        if (!empty($gyn)) {
            $sql .= "TriageGYN,";
            $values .= "'$gyn',";
        }

        if (!empty($opht)) {
            $sql .= "TriageOPHT,";
            $values .= "'$opht',";
        }

        if (!empty($dent)) {
            $sql .= "TriageDENT,";
            $values .= "'$dent',";
        }

        if (!empty($triagev)) {
            $sql .= "TriageVenDis,";
            $values .= "'$triagev',";
        }

        // standard
        if (!empty($weight)) {
            $sql .= "Weight,";
            $values .= "'$weight',";
        }
        if (!empty($temp)) {
            $sql .= "Temperature,";
            $values .= "'$temp',";
        }
        if (!empty($BPTop)) {
            $sql .= "Systolic,";
            $values .= "'$BPTop',";
        }
        if (!empty($BPBottom)) {
            $sql .= "Diastolic,";
            $values .= "'$BPBottom',";
        }
        if (!empty($glucose)) {
            $sql .= "Glucose,";
            $values .= "'$glucose',";
        }
        if (!empty($heart)) {
            $sql .= "HeartRate,";
            $values .= "'$heart',";
        }

        // child info
        if (!empty($period)) {
            $sql .= "LastPeriod,";
            $values .= "'$period',";
        }
        if (!empty($preg)) {
            $sql .= "Pregnant,";
            $values .= "'$preg',";
        }
        if (!empty($breast)) {
            $sql .= "Breastfeed,";
            $values .= "'$breast',";
        }
        if (!empty($grav)) {
            $sql .= "Gravida,";
            $values .= "'$grav',";
        }
        if (!empty($para)) {
            $sql .= "Para,";
            $values .= "'$para',";
        }
        if (!empty($abortus)) {
            $sql .= "Abortus,";
            $values .= "'$abortus',";
        }
        if (!empty($living)) {
            $sql .= "NumLivingChildren,";
            $values .= "'$living',";
        }

        // complaint
        if (!empty($complaint)) {
            $sql .= "ChiefComplaint,";
            $values .= "'$complaint',";
        }

        // clean up the sql
        $sql = substr_replace($sql ,'',-1);
        $values = substr_replace($values ,")",-1);

        // stick it all together
        $sql .= $values;

        //INSERT INTO tbl_visit (PatientID,VisitedDispensary,TriageTesting,TriageMedical,TriageMedical2,TriageGYN,TriageOPHT,TriageDENT,TriageVenDis,Weight,Temperature,HeartRate,Pregnant,Breastfeed,ChiefComplaint) 
        //VALUES                 (10,       'Bugola',       'yes',          'yes',          'yes',      'no',       'no',       'no',       'no',   '50.5', '37',       '60,        'no',   'no',       'nothing')

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
