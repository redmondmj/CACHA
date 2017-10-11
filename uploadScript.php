<?php
    require "db.php";
    
    // Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));
    
    // Attempt to decode the incoming RAW post data from JSON.
    $data = json_decode($content, true); 
    
    // which request is it?
    if ($data["upload"] == "basic") {

        // date and time
        $visitDate = date("Y-m-d");
        $visitTime = date("h:i:s");
        
        // json information
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
        $sql = "INSERT INTO tbl_visit (PatientID,VisitDate,VisitTime,";
        $values = ") VALUES ('$id','$visitDate','$visitTime',";

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

    } else if ($data["upload"] == "clinic") {

        $visitID = $data["id"];
    
        // diagnosis
        $healthy = $data["healthy"];
        $ntr = $data["ntr"];
        $worms = $data["worms"];
        $asthma = $data["asthma"];
        $bronchitis = $data["bronch"];
        $msk = $data["msk"];
        $pneumonia = $data["pneumonia"];
        $cough = $data["cough"];
        $malaria = $data["malaria"];
        $schisto = $data["schisto"];
        $typhoid = $data["typhoid"];
        $gerd = $data["gerd"];
        $pud = $data["pud"];
        $diarreha = $data["diarreha"];
        $bloody = $data["bloody"];
        $hypertension = $data["hyper"];
        $diabetes = $data["diabetes"];
        $constipation = $data["con"];
        $pid = $data["pid"];
        $sti = $data["sti"];
        $syphilis = $data["syphilis"];
        $topical = $data["topical"];
        
        // tests
        $lastHIV = $data["lastv"];
        $lastPZQ = $data["lastpzq"];
        $lastWORM = $data["lastworm"];
        $lastVitA = $data["lastvita"];

        $notes = $data["notes"];

        $prevMeds = $data["prevmed"];
    
        $practicioner = $data["prac"];
        
        // build the giant sql string
        $sql = "UPDATE patient (";
        if (!empty($healthy)) {
            $sql .= "DX_Healthy = '$healthy',";
        }
        if (!empty($ntr)) {
            $sql .= "DX_NoTreatment = '$ntr',";
        }
        if (!empty($worms)) {
            $sql .= "DX_Worms = '$worms',";
        }
        if (!empty($asthma)) {
            $sql .= "DX_Asthma = '$asthma',";
        }
        if (!empty($bronchitis)) {
            $sql .= "DX_Bronchitis = '$bronchitis',";
        }
        if (!empty($msk)) {
            $sql .= "DX_MSK = '$msk',";
        }
        if (!empty($pneumonia)) {
            $sql .= "DX_Pneumonia = '$pneumonia',";
        }
        if (!empty($cough)) {
            $sql .= "DX_Cough = '$cough',";
        }
        if (!empty($malaria)) {
            $sql .= "DX_Malaria = '$malaria',";
        }
        if (!empty($schisto)) {
            $sql .= "DX_Schisto = '$schisto,";
        }
        if (!empty($typhoid)) {
            $sql .= "DX_Typhoid = '$typhoid',";
        }
        if (!empty($gerd)) {
            $sql .= "DX_Gerd = '$gerd',";
        }
        if (!empty($pud)) {
            $sql .= "DX_PUD = '$pud',";
        }
        if (!empty($diarrhea)) {
            $sql .= "DX_Diarrhea = '$diarreha',";
        }
        if (!empty($bloody)) {
            $sql .= "DX_DiarrehaBloody = '$bloody',";
        }
        if (!empty($hypertension)) {
            $sql .= "DX_Hypertension = '$hypertension',";
        }
        if (!empty($diabetes)) {
            $sql .= "DX_Diabetes = '$diabetes',";
        }
        if (!empty($constipation)) {
            $sql .= "DX_Constipation = '$constipation',";
        }
        if (!empty($pid)) {
            $sql .= "DX_PID = '$pid',";
        }
        if (!empty($sti)) {
            $sql .= "DX_STI = '$sti',";
        }
        if (!empty($syphilis)) {
            $sql .= "DX_Syphilis = '$syphilis',";
        }
        if (!empty($topical)) {
            $sql .= "DX_Topical = '$topical',";
        }
        if (!empty($lastHIV)) {
            $sql .= "LastHIVTest = '$lastHIV',";
        }
        if (!empty($lastPZQ)) {
            $sql .= "LastPZQTx = '$lastPZQ',";
        }
        if (!empty($lastWorm)) {
            $sql .= "LastWormTx = '$lastWorm',";
        }
        if (!empty($lastVitA)) {
            $sql .= "LastVitA = '$lastVitA',";
        }
        if (!empty($prevMeds)) {
            $sql .= "PrevMeds = '$prevMeds',";
        }
        if (!empty($practicioner)) {
            $sql .= "Practicioners = '$practicioner',";
        }
    
        // remove last comma and add bracket
        $sql = substr_replace($sql ,")",-1);
        
        // add conditon
        $sql .= "WHERE VisitID = $visitID";

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
