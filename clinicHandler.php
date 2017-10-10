<?php
    require_once "db.php";    
    
    //Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));
    
    //Attempt to decode the incoming RAW post data from JSON.
    $decoded = json_decode($content, true); 

    $visitID = $decoded[0]->visitID;
    $visitDate = date("Y-m-d");
    $visitTime = date("h:i:s");

    $notes = $decoded[0]->notes;
    
    $healthy = $decoded[0]->healthy;
    $ntr = $decoded[0]->ntr;
    $worms = $decoded[0]->worms;
    $asthma = $decoded[0]->asthma;
    $bronchitis = $decoded[0]->bronchitis;
    $msk = $decoded[0]->msk;
    $pneumonia = $decoded[0]->pneumonia;
    $cough = $decoded[0]->cough;
    $malaria = $decoded[0]->malaria;
    $schisto = $decoded[0]->schisto;
    $typhoid = $decoded[0]->typhoid;
    $gerd = $decoded[0]->gerd;
    $pud = $decoded[0]->pud;
    $diarreha = $decoded[0]->diarrhea;
    $bloody = $decoded[0]->bloody;
    $watery = $decoded[0]->watery;
    $hypertension = $decoded[0]->hypertension;
    $diabetes = $decoded[0]->diabetes;
    $constipation = $decoded[0]->constipation;
    $pid = $decoded[0]->pid;
    $sti = $decoded[0]->sti;
    $syphilis = $decoded[0]->syphilis;
    $topical = $decoded[0]->topical;

    $lastHIV = $decoded[0]->lastHIV;
    $lastPZQ = $decoded[0]->lastPZQ;
    $lastWORM = $decoded[0]->lastWORM;
    $lastVitA = $decoded[0]->lastVitA;
    $prevMeds = $decoded[0]->meds;

    $practicioner = $decoded[0]->practicioner;
    
    // build the giant sql string
    $sql = "UPDATE patient (";
    if (!empty($visitTime)) {
        $sql .= "VisitTime = '$visitTime',";
    }
    if (!empty($healthy)){
        $sql .= "DX_Healthy = '$healthy',";
    }
    if (!empty($ntr)){
        $sql .= "DX_NoTreatment = '$ntr',";
    }
    if (!empty($worms)){
        $sql .= "DX_Worms = '$worms',";
    }
    if (!empty($asthma)){
        $sql .= "DX_Asthma = '$asthma',";
    }
    if (!empty($bronchitis)){
        $sql .= "DX_Bronchitis = '$bronchitis',";
    }
    if (!empty($msk)){
        $sql .= "DX_MSK = '$msk',";
    }
    if (!empty($pneumonia)){
        $sql .= "DX_Pneumonia = '$pneumonia',";
    }
    if (!empty($cough)){
        $sql .= "DX_Cough = '$cough',";
    }
    if (!empty($malaria)){
        $sql .= "DX_Malaria = '$malaria',";
    }
    if (!empty($schisto)){
        $sql .= "DX_Schisto = '$schisto,";
    }
    if (!empty($typhoid)){
        $sql .= "DX_Typhoid = '$typhoid',";
    }
    if (!empty($gerd)){
        $sql .= "DX_Gerd = '$gerd',";
    }
    if (!empty($pud)){
        $sql .= "DX_PUD = '$pud',";
    }
    if (!empty($diarrhea)){
        $sql .= "DX_Diarrhea = '$diarreha',";
    }
    if (!empty($bloody)){
        $sql .= "DX_DiarrehaBloody = '$bloody',";
    }
    if (!empty($watery)){
        $sql .= "DX_DiarrehaWatery = '$watery',";
    }
    if (!empty($hypertension)){
        $sql .= "DX_Hypertension = '$hypertension',";
    }
    if (!empty($diabetes)){
        $sql .= "DX_Diabetes = '$diabetes',";
    }
    if (!empty($constipation)){
        $sql .= "DX_Constipation = '$constipation',";
    }
    if (!empty($pid)){
        $sql .= "DX_PID = '$pid',";
    }
    if (!empty($sti)){
        $sql .= "DX_STI = '$sti',";
    }
    if (!empty($syphilis)){
        $sql .= "DX_Syphilis = '$syphilis',";
    }
    if (!empty($topical)){
        $sql .= "DX_Topical = '$topical',";
    }
    if (!empty($lastHIV)){
        $sql .= "LastHIVTest = '$lastHIV',";
    }
    if (!empty($lastPZQ)){
        $sql .= "LastPZQTx = '$lastPZQ',";
    }
    if (!empty($lastWorm)){
        $sql .= "LastWormTx = '$lastWorm',";
    }
    if (!empty($lastVitA)){
        $sql .= "LastVitA = '$lastVitA',";
    }
    if (!empty($prevMeds)){
        $sql .= "PrevMeds = '$prevMeds',";
    }
    if (!empty($practicioner)){
        $sql .= "Practicioners = '$practicioner',";
    }

    // remove last comma and add bracket
    $sql = substr_replace($sql ,")",-1);
    
    // add conditon
    $sql .= "WHERE VisitID = $visitID";

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