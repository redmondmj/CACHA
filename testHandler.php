<?php
    require_once "db.php";    
    
    //Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));
    
    //Attempt to decode the incoming RAW post data from JSON.
    $decoded = json_decode($content, true); 

    $visitID = $decoded[0]->visitID;
    $visitDate = date("Y-m-d");
    $visitTime = date("h:i:s");

    $malaria = $decoded[0]->malaria;
    $v = $decoded[0]->v;
    $typh = $decoded[0]->hr;
    $syph = $decoded[0]->syhilis;
    $pregnancy = $decoded[0]->pregnancy;
    $leuc = $decoded[0]->leuc;
    $rbc = $decoded[0]->rbc;
    $glucose = $decoded[0]->glucose;
    $nitrates = $decoded[0]->nitrates;

    $practicioner = $decoded[0]->practicioner;
    
    $sql = "UPDATE patient (";
    if (!empty($visitTime)) {
        $sql .= "VisitTime = '$visitTime',";
    }
    if (!empty($malaria)){
        $sql .= "MalariaTest = '$malaria',";
    }
    if (!empty($v)){
        $sql .= "VTest = '$v',";
    }
    if (!empty($syph)){
        $sql .= "SyphilisTest = '$syph',";
    }
    if (!empty($typh)){
        $sql .= "TyphTest = '$typh',";
    }
    if (!empty($pregnancy)){
        $sql .= "PregnancyTest = '$pregnancy',"
    }
    if (!empty($leuc)){
        $sql .= "UrineLeucTest = '$leuc',";
    }
    if (!empty($rbc)){
        $sql .= "UrineRBCTest = '$rbc',";
    }
    if (!empty($glucose)){
        $sql .= "UrineGlucoseTest = '$glucose',";
    }
    if (!empty($nitrates)){
        $sql .= "UrineNitritesTest = '$nitrates',";
    }
    if (!empty($practicioner)){
        $sql .= "Practicioners = '$practicioner',";
    }

    if(substr_compare($sql, ",", -1, 1)){
        substr_replace($sql ,")",-1);
    }

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