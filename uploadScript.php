<?php
    require "db.php";
    
    // Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));
    
    // Attempt to decode the incoming RAW post data from JSON.
    $data = json_decode($content, true); 
    
    // which request is it?
    if ($data["upload"] == "basic") {

        // visitid to update if needed
        $visitid = $data["visitid"];

        // date and time
        $visitDate = date("Y-m-d");
        $visitTime = date("h:i:s");
        
        // json information
        $id = $data["patientid"];
        $dispensary = $data["dispensary"];
        $test = $data["test"];
        $med = $data["med"];
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
        
        // new visit or updating?
        if ($visitid == 0) {
            // new visit
            // build the enourmous sql statement
            $sql = "INSERT INTO tbl_visit (PatientID,VisitDate,VisitTime,";
            $values = ") VALUES ('$id','$visitDate','$visitTime',";

            $sql .= "VisitedDispensary,";
            $values .=  "'$dispensary',";

            // stations
            $sql .= "TriageTesting,";
            $values .= "'$test',";
            $sql .= "TriageMedical,";
            $values .= "'$med',";
            $sql .= "TriageGYN,";
            $values .= "'$gyn',";
            $sql .= "TriageOPHT,";
            $values .= "'$opht',";
            $sql .= "TriageDENT,";
            $values .= "'$dent',";
            $sql .= "TriageVenDis,";
            $values .= "'$triagev',";

            // standard
            $sql .= "Weight,";
            $values .= "'$weight',";
            $sql .= "Temperature,";
            $values .= "'$temp',";

            if ($bptop != "") {
                $sql .= "Systolic,";
                $values .= "$bptop,";
            }
            if ($bpbottom != "") {
                $sql .= "Diastolic,";
                $values .= "$bpbottom,";
            }
            if ($glucose != "") {
                $sql .= "Glucose,";
                $values .= "$glucose,";
            }
            if ($heart != "") {
                $sql .= "HeartRate,";
                $values .= "$heart,";
            }
            
            // child info
            $sql .= "LastPeriod,";
            $values .= "'$period',";
            $sql .= "Pregnant,";
            $values .= "'$preg',";
            $sql .= "Breastfeed,";
            $values .= "'$breast',";
            if ($data["grav"] != "") {
                $sql .= "Gravida,";
                $values .= "$grav,";
            }
            if ($data["para"] != "") {
                $sql .= "Para,";
                $values .= "$para,";
            }
            if ($data["abortus"] != "") {
                $sql .= "Abortus,";
                $values .= "$abortus,";
            }
            if ($data["living"] != "") {
                $sql .= "NumLivingChildren,";
                $values .= "$living,";
            }
            
            // complaint
            $sql .= "ChiefComplaint";
            $values .= "'$complaint')";

            // clean up the sql
            //$sql = substr_replace($sql ,'',-1);
            //$values = substr_replace($values ,")",-1);

            // stick it all together
            $sql .= $values;

        } else {
            // updating a visit
            // build the enourmous sql statement
            $sql = "UPDATE tbl_visit SET ";
            
            // can't change these
            //$sql .= "PatientID = $id,";
            //$sql .= "VisitDate = '$visitDate',";
            //$sql .= "VisitTime = '$visitTime',";

            $sql .= "VisitedDispensary = '$dispensary',";

            // stations
            $sql .= "TriageTesting = '$test',";
            $sql .= "TriageMedical = '$med',";
            $sql .= "TriageGYN = '$gyn',";
            $sql .= "TriageOPHT = '$opht',";
            $sql .= "TriageDENT = '$dent',";
            $sql .= "TriageVenDis = '$triagev',";

            // standard
            $sql .= "Weight = '$weight',";
            $sql .= "Temperature = '$temp',";
            if ($bptop != "") {$sql .= "Systolic = $bptop,";} else {$sql .= "Systolic = NULL,";}
            if ($bpbottom != "") {$sql .= "Diastolic = $bpbottom,";} else {$sql .= "Diastolic = NULL,";}
            if ($glucose != "") {$sql .= "Glucose = $glucose,";} else {$sql .= "Glucose = NULL,";}
            if ($heart != "") {$sql .= "HeartRate = $heart,";} else {$sql .= "HeartRate = NULL,";}
            
            // child info
            $sql .= "LastPeriod = '$period',";
            $sql .= "Pregnant = '$preg',";
            $sql .= "Breastfeed = '$breast',";
            if ($data["grav"] != "") {$sql .= "Gravida = $grav,";} else {$sql .= "Gravida = NULL,";}
            if ($data["para"] != "") {$sql .= "Para = $para,";} else {$sql .= "Para = NULL,";}
            if ($data["abortus"] != "") {$sql .= "Abortus = $abortus,";} else {$sql .= "Abortus = NULL,";}
            if ($data["living"] != "") {$sql .= "NumLivingChildren = $living,";} else {$sql .= "NumLivingChildren = NULL,";}
            
            // complaint
            $sql .= "ChiefComplaint = '$complaint'";

            // remove last comma and add bracket
            //$sql = substr_replace($sql ,"",-1);
            
            // add conditon
            $sql .= " WHERE VisitID = $visitid;";

        }

    } else if ($data["upload"] == "clinic") {

        $visitID = $data["visitid"];
    
        // tests
        $lastHIV = $data["lastv"];
        $lastPZQ = $data["lastpzq"];
        $lastWorm = $data["lastworm"];
        $lastVitA = $data["lastvita"];

        // administrated
        $parac = $data["parac"];
        $benz = $data["benz"];
        $ceft = $data["ceft"];

        $meds = $data["meds"];

        // diagnosis
        $healthy = $data["healthy"];
        $ntr = $data["ntr"];
        $msk = $data["msk"];
        $eye = $data["eye"];
        $vit = $data["vit"];
        $dds = $data["dds"];
        $worms = $data["worms"];
        $malaria = $data["mal"];
        $schisto = $data["schisto"];
        $typhoid = $data["typhoid"];
        $asthma = $data["asthma"];
        $bronchitis = $data["bronc"];
        $pneumonia = $data["pneu"];
        $cough = $data["cough"];
        $gerd = $data["gerd"];
        $pud = $data["pud"];
        $hypertension = $data["hyper"];
        $constipation = $data["con"];
        $diarrhea = $data["diarrhea"];
        $bloody = $data["diarrheatype"];
        $diabetes = $data["diabetes"];
        $pid = $data["pid"];
        $sti = $data["sti"];
        $syphilis = $data["syph"];
        $topical = $data["topical"];
        $topicaldesc = $data["topicaldesc"];
        $other = $data["other"];
        $otherdesc = $data["otherdesc"];

        $assess = $data["assess"];

        // pregnancy
        $weeks = $data["weeks"];
        $anc = $data["anc"];
        $anemia = $data["anemia"];
        $iptp = $data["iptp"];
        $sulfadar = $data["sulfadar"];

        // follow-up, education and referral
        $follow = $data["follow"];
        $edu = $data["edu"];

        $tb = $data["tb"];
        $hospital = $data["hospital"];
        $surgery = $data["surgery"];
    
        // chart
        $chart = $data["chart"];

        $ptinit = $data["PTInit"];
        $ptsex = $data["PTSex"];
        $ptpreg = $data["PTPreg"];
        $ptmonth = $data["PTMonth"];
        $ptbf = $data["PTBF"];
        $ptmtz = $data["PTMTZ"];
        $ptdoxy = $data["PTDoxy"];
        $ptamox = $data["PTAmox"];

        $p1init = $data["P1Init"];
        $p1sex = $data["P1Sex"];
        $p1preg = $data["P1Preg"];
        $p1month = $data["P1Month"];
        $p1bf = $data["P1BF"];
        $p1mtz = $data["P1MTZ"];
        $p1doxy = $data["P1Doxy"];
        $p1amox = $data["P1Amox"];

        $p2init = $data["P2Init"];
        $p2sex = $data["P2Sex"];
        $p2preg = $data["P2Preg"];
        $p2month = $data["P2Month"];
        $p2bf = $data["P2BF"];
        $p2mtz = $data["P2MTZ"];
        $p2doxy = $data["P2Doxy"];
        $p2amox = $data["P2Amox"];

        $p3init = $data["P3Init"];
        $p3sex = $data["P3Sex"];
        $p3preg = $data["P3Preg"];
        $p3month = $data["P3Month"];
        $p3bf = $data["P3BF"];
        $p3mtz = $data["P3MTZ"];
        $p3doxy = $data["P3Doxy"];
        $p3amox = $data["P3Amox"];

        // practitioner
        $pract1 = $data["pract1"];
        $pract2 = $data["pract2"];
        $pract3 = $data["pract3"];

        // stations
        $test = $data["test"];
        $med = $data["med"];
        $gyn = $data["gyn"];
        $opht = $data["opht"];
        $dent = $data["dent"];
        $triagev = $data["triagev"];
        
        // build the giant sql string
        $sql = "UPDATE tbl_visit SET ";
        
        $sql .= "TriageTesting = '$test',";
        $sql .= "TriageMedical = '$med',";
        $sql .= "TriageGYN = '$gyn',";
        $sql .= "TriageOPHT = '$opht',";
        $sql .= "TriageDENT = '$dent',";
        $sql .= "TriageVenDis = '$triagev',";

        if ($weeks != "") {$sql .= "Pregnant_Weeks = $weeks,";} else {$sql .= "Pregnant_Weeks = NULL,";}
        $sql .= "Assessment = '$assess',";

        $sql .= "LastHIVTest = '$lastHIV',";
        $sql .= "LastPZQTx = '$lastPZQ',";
        $sql .= "LastWormTx = '$lastWorm',";
        $sql .= "LastVitA = '$lastVitA',";

        $sql .= "PrevMeds = '$meds',";

        $sql .= "DX_Healthy = '$healthy',";
        $sql .= "DX_NoTreatment = '$ntr',";
        if ($msk != "") {$sql .= "DX_MSK = $msk,";} else {$sql .= "DX_MSK = NULL,";}
        if ($eye != "") {$sql .= "DX_Eye = $eye,";} else {$sql .= "DX_Eye = NULL,";}
        if ($vit != "") {$sql .= "DX_Vit = $vit,";} else {$sql .= "DX_Vit = NULL,";}
        if ($dds != "") {$sql .= "DX_DDS = $dds,";} else {$sql .= "DX_DDS = NULL,";}

        if ($worms != "") {$sql .= "DX_Worms = $worms,";} else {$sql .= "DX_Worms = NULL,";}
        if ($malaria != "") {$sql .= "DX_Malaria = $malaria,";} else {$sql .= "DX_Malaria = NULL,";}
        if ($schisto != "") {$sql .= "DX_Schisto = $schisto,";} else {$sql .= "DX_Schisto = NULL,";}
        if ($typhoid != "") {$sql .= "DX_Typhoid = $typhoid,";} else {$sql .= "DX_Typhoid = NULL,";}

        if ($asthma != "") {$sql .= "DX_Asthma = $asthma,";} else {$sql .= "DX_Asthma = NULL,";}
        if ($bronchitis != "") {$sql .= "DX_Bronchitis = $bronchitis,";} else {$sql .= "DX_Bronchitis = NULL,";}
        if ($pneumonia != "") {$sql .= "DX_Pneumonia = $pneumonia,";} else {$sql .= "DX_Pneumonia = NULL,";}
        if ($cough != "") {$sql .= "DX_Cough = $cough,";} else {$sql .= "DX_Cough = NULL,";}

        if ($gerd != "") {$sql .= "DX_Gerd = $gerd,";} else {$sql .= "DX_Gerd = NULL,";}
        if ($pud != "") {$sql .= "DX_PUD = $pud,";} else {$sql .= "DX_PUD = NULL,";}
        if ($hypertension != "") {$sql .= "DX_Hypertension = $hypertension,";} else {$sql .= "DX_Hypertension = NULL,";}
        
        if ($constipation != "") {$sql .= "DX_Constipation = $constipation,";} else {$sql .= "DX_Constipation = NULL,";}
        if ($diarrhea != "") {$sql .= "DX_Diarrhea = $diarrhea,";} else {$sql .= "DX_Diarrhea = NULL,";}
        $sql .= "DX_DiarrheaBloody = '$bloody',";

        if ($diabetes != "") {$sql .= "DX_Diabetes = $diabetes,";} else {$sql .= "DX_Diabetes = NULL,";}
        if ($pid != "") {$sql .= "DX_PID = $pid,";} else {$sql .= "DX_PID = NULL,";}
        if ($sti != "") {$sql .= "DX_STI = $sti,";} else {$sql .= "DX_STI = NULL,";}
        if ($syphilis != "") {$sql .= "DX_Syphilis = $syphilis,";} else {$sql .= "DX_Syphilis = NULL,";}

        if ($topical != "") {$sql .= "DX_Topical = $topical,";} else {$sql .= "DX_Topical = NULL,";}
        $sql .= "DX_TopicalDesc = '$topicaldesc',";
        if ($other != "") {$sql .= "DX_Other = $other,";} else {$sql .= "DX_Other = NULL,";}
        $sql .= "DX_OtherDesc = '$otherdesc',";

        // pregnancy stuff
        $sql .= "RegANC = '$anc',";
        $sql .= "ClinicalAnemia = '$anemia',";
        $sql .= "LastIPTpx = '$iptp',";
        if ($sulfadar != "") {$sql .= "Sulfadar = $sulfadar,";} else {$sql .= "Sulfadar = NULL,";}

        // administrated
        $sql .= "Rx_Paracetamol = '$parac',";
        $sql .= "Rx_BenzPen = '$benz',";
        $sql .= "Rx_Ceftriaxone = '$ceft',";

        // chart
        $sql .= "SP_Type = '$chart',";
        
        $sql .= "SP_PTInitials = '$ptinit',";
        $sql .= "SP_PTSex = '$ptsex',";
        $sql .= "SP_PTPreg = '$ptpreg',";
        if ($ptmonth != "") {$sql .= "SP_PTMonths = $ptmonth,";} else {$sql .= "SP_PTMonths = NULL,";}
        $sql .= "SP_PTBF = '$ptbf',";
        if ($ptmtz != "") {$sql .= "SP_PTMTZ = $ptmtz,";} else {$sql .= "SP_PTMTZ = NULL,";}
        if ($ptdoxy != "") {$sql .= "SP_PTDoxy = $ptdoxy,";} else {$sql .= "SP_PTDoxy = NULL,";}
        if ($ptamox != "") {$sql .= "SP_PTAmox = $ptamox,";} else {$sql .= "SP_PTAmox = NULL,";}
        
        $sql .= "SP_PT1Initials = '$p1init',";
        $sql .= "SP_PT1Sex = '$p1sex',";
        $sql .= "SP_PT1Preg = '$p1preg',";
        if ($p1month != "") {$sql .= "SP_PT1Months = $p1month,";} else {$sql .= "SP_PT1Months = NULL,";}
        $sql .= "SP_PT1BF = '$p1bf',";
        if ($p1mtz != "") {$sql .= "SP_PT1MTZ = $p1mtz,";} else {$sql .= "SP_PT1MTZ = NULL,";}
        if ($p1doxy != "") {$sql .= "SP_PT1Doxy = $p1doxy,";} else {$sql .= "SP_PT1Doxy = NULL,";}
        if ($p1amox != "") {$sql .= "SP_PT1Amox = $p1amox,";} else {$sql .= "SP_PT1Amox = NULL,";}
        
        $sql .= "SP_PT2Initials = '$p2init',";
        $sql .= "SP_PT2Sex = '$p2sex',";
        $sql .= "SP_PT2Preg = '$p2preg',";
        if ($p2month != "") {$sql .= "SP_PT2Months = $p2month,";} else {$sql .= "SP_PT2Months = NULL,";}
        $sql .= "SP_PT2BF = '$p2bf',";
        if ($p2mtz != "") {$sql .= "SP_PT2MTZ = $p2mtz,";} else {$sql .= "SP_PT2MTZ = NULL,";}
        if ($p2doxy != "") {$sql .= "SP_PT2Doxy = $p2doxy,";} else {$sql .= "SP_PT2Doxy = NULL,";}
        if ($p2amox != "") {$sql .= "SP_PT2Amox = $p2amox,";} else {$sql .= "SP_PT2Amox = NULL,";}

        $sql .= "SP_PT3Initials = '$p3init',";
        $sql .= "SP_PT3Sex = '$p3sex',";
        $sql .= "SP_PT3Preg = '$p3preg',";
        if ($p3month != "") {$sql .= "SP_PT3Months = $p3month,";} else {$sql .= "SP_PT3Months = NULL,";}
        $sql .= "SP_PT3BF = '$p3bf',";
        if ($p3mtz != "") {$sql .= "SP_PT3MTZ = $p3mtz,";} else {$sql .= "SP_PT3MTZ = NULL,";}
        if ($p3doxy != "") {$sql .= "SP_PT3Doxy = $p3doxy,";} else {$sql .= "SP_PT3Doxy = NULL,";}
        if ($p3amox != "") {$sql .= "SP_PT3Amox = $p3amox,";} else {$sql .= "SP_PT3Amox = NULL,";}

        // follow-up and education
        $sql .= "FollowUp = '$follow',";
        $sql .= "Education = '$edu',";

        // referral
        $sql .= "RefTB = '$tb',";
        $sql .= "RefHospital = '$hospital',";
        $sql .= "RefSurgery = '$surgery',";

        // clinic practitioner
        $sql .= "DR_Clinic = '$pract1',";
        $sql .= "DR_Clinic2 = '$pract2',";
        $sql .= "DR_Clinic3 = '$pract3',";
    
        // remove last comma
        $sql = substr_replace($sql ,"",-1);
        
        // add conditon
        $sql .= " WHERE VisitID = $visitID";

    } else if ($data["upload"] == "rx") {
        
        $visitID = $data["visitid"];

        // notes
        $assess = $data["assess"];
        $meds = $data["meds"];

        // drugs
        $parac = $data["parac"];
        $benz = $data["benz"];
        $ceft = $data["ceft"];
        $pcm = $data["pcm"];
        $kit = $data["kit"];
        $pud = $data["pud"];
        $pzq = $data["pzq"];
        $alu = $data["alu"];
        $sulfadar = $data["sulfadar"];

        $other = $data["other"];
        
        // chart
        $chart = $data["chart"];

        $ptinit = $data["PTInit"];
        $ptsex = $data["PTSex"];
        $ptpreg = $data["PTPreg"];
        $ptmonth = $data["PTMonth"];
        $ptbf = $data["PTBF"];
        $ptmtz = $data["PTMTZ"];
        $ptdoxy = $data["PTDoxy"];
        $ptamox = $data["PTAmox"];

        $p1init = $data["P1Init"];
        $p1sex = $data["P1Sex"];
        $p1preg = $data["P1Preg"];
        $p1month = $data["P1Month"];
        $p1bf = $data["P1BF"];
        $p1mtz = $data["P1MTZ"];
        $p1doxy = $data["P1Doxy"];
        $p1amox = $data["P1Amox"];

        $p2init = $data["P2Init"];
        $p2sex = $data["P2Sex"];
        $p2preg = $data["P2Preg"];
        $p2month = $data["P2Month"];
        $p2bf = $data["P2BF"];
        $p2mtz = $data["P2MTZ"];
        $p2doxy = $data["P2Doxy"];
        $p2amox = $data["P2Amox"];

        $p3init = $data["P3Init"];
        $p3sex = $data["P3Sex"];
        $p3preg = $data["P3Preg"];
        $p3month = $data["P3Month"];
        $p3bf = $data["P3BF"];
        $p3mtz = $data["P3MTZ"];
        $p3doxy = $data["P3Doxy"];
        $p3amox = $data["P3Amox"];

        // practitioner and rxnum
        $pract = $data["pract"];
        $rxnum = $data["rxnum"];
        
        // build the giant sql string
        $sql = "UPDATE tbl_visit SET ";
        
        $sql .= "Assessment = '$assess',";
        $sql .= "PrevMeds = '$meds',";
        
        if ($sulfadar != "") {$sql .= "Sulfadar = $sulfadar,";} else {$sql .= "Sulfadar = NULL,";}

        $sql .= "Rx_Paracetamol = '$parac',";
        $sql .= "Rx_BenzPen = '$benz',";
        $sql .= "Rx_Ceftriaxone = '$ceft',";

        $sql .= "Rx_Kit_PCM = '$pcm',";
        $sql .= "Rx_Kit_Pregnancy = '$kit',";
        if ($alu != "") {$sql .= "Rx_ALU = $alu,";} else {$sql .= "Rx_ALU = NULL,";}
        $sql .= "Rx_PUD = '$pud',";
        if ($pzq != "") {$sql .= "Rx_PZQ_Tabs = $pzq,";} else {$sql .= "Rx_PZQ_Tabs = NULL,";}
        $sql .= "Rx_Other = '$other',";

        // chart
        $sql .= "SP_Type = '$chart',";
        
        $sql .= "SP_PTInitials = '$ptinit',";
        $sql .= "SP_PTSex = '$ptsex',";
        $sql .= "SP_PTPreg = '$ptpreg',";
        if ($ptmonth != "") {$sql .= "SP_PTMonths = $ptmonth,";} else {$sql .= "SP_PTMonths = NULL,";}
        $sql .= "SP_PTBF = '$ptbf',";
        if ($ptmtz != "") {$sql .= "SP_PTMTZ = $ptmtz,";} else {$sql .= "SP_PTMTZ = NULL,";}
        if ($ptdoxy != "") {$sql .= "SP_PTDoxy = $ptdoxy,";} else {$sql .= "SP_PTDoxy = NULL,";}
        if ($ptamox != "") {$sql .= "SP_PTAmox = $ptamox,";} else {$sql .= "SP_PTAmox = NULL,";}
        
        $sql .= "SP_PT1Initials = '$p1init',";
        $sql .= "SP_PT1Sex = '$p1sex',";
        $sql .= "SP_PT1Preg = '$p1preg',";
        if ($p1month != "") {$sql .= "SP_PT1Months = $p1month,";} else {$sql .= "SP_PT1Months = NULL,";}
        $sql .= "SP_PT1BF = '$p1bf',";
        if ($p1mtz != "") {$sql .= "SP_PT1MTZ = $p1mtz,";} else {$sql .= "SP_PT1MTZ = NULL,";}
        if ($p1doxy != "") {$sql .= "SP_PT1Doxy = $p1doxy,";} else {$sql .= "SP_PT1Doxy = NULL,";}
        if ($p1amox != "") {$sql .= "SP_PT1Amox = $p1amox,";} else {$sql .= "SP_PT1Amox = NULL,";}
        
        $sql .= "SP_PT2Initials = '$p2init',";
        $sql .= "SP_PT2Sex = '$p2sex',";
        $sql .= "SP_PT2Preg = '$p2preg',";
        if ($p2month != "") {$sql .= "SP_PT2Months = $p2month,";} else {$sql .= "SP_PT2Months = NULL,";}
        $sql .= "SP_PT2BF = '$p2bf',";
        if ($p2mtz != "") {$sql .= "SP_PT2MTZ = $p2mtz,";} else {$sql .= "SP_PT2MTZ = NULL,";}
        if ($p2doxy != "") {$sql .= "SP_PT2Doxy = $p2doxy,";} else {$sql .= "SP_PT2Doxy = NULL,";}
        if ($p2amox != "") {$sql .= "SP_PT2Amox = $p2amox,";} else {$sql .= "SP_PT2Amox = NULL,";}

        $sql .= "SP_PT3Initials = '$p3init',";
        $sql .= "SP_PT3Sex = '$p3sex',";
        $sql .= "SP_PT3Preg = '$p3preg',";
        if ($p3month != "") {$sql .= "SP_PT3Months = $p3month,";} else {$sql .= "SP_PT3Months = NULL,";}
        $sql .= "SP_PT3BF = '$p3bf',";
        if ($p3mtz != "") {$sql .= "SP_PT3MTZ = $p3mtz,";} else {$sql .= "SP_PT3MTZ = NULL,";}
        if ($p3doxy != "") {$sql .= "SP_PT3Doxy = $p3doxy,";} else {$sql .= "SP_PT3Doxy = NULL,";}
        if ($p3amox != "") {$sql .= "SP_PT3Amox = $p3amox,";} else {$sql .= "SP_PT3Amox = NULL,";}

        // rx practitioner
        $sql .= "DR_Rx = '$pract',";
        if ($rxnum != "") {$sql .= "RXNum = $rxnum,";} else {$sql .= "RXNum = NULL";}
    
        // remove last comma
        //$sql = substr_replace($sql ,"",-1);
        
        // add conditon
        $sql .= " WHERE VisitID = $visitID";

    } else if ($data["upload"] == "test") {
        
        $visitID = $data["visitid"];

        // test
        $v = $data["v"];
        $mal = $data["mal"];
        $syph = $data["syph"];
        $typh = $data["typh"];
        $preg = $data["preg"];

        $lastv = $data["lastv"];
        $lastpzq = $data["lastpzq"];
        $lastworm = $data["lastworm"];
        $lastvita = $data["lastvita"];

        $leuc = $data["leuc"];
        $rbc = $data["rbc"];
        $glucose = $data["glucose"];
        $nit = $data["nit"];

        // drugs
        $parac = $data["parac"];
        $benz = $data["benz"];
        $ceft = $data["ceft"];
        
        // practitioner and rxnum
        $pract = $data["pract"];

        // notes
        $assess = $data["assess"];
        $meds = $data["meds"];
        
        // build the giant sql string
        $sql = "UPDATE tbl_visit SET ";
        
        $sql .= "TriageTesting = 'complete',";

        $sql .= "VTest = '$v',";
        $sql .= "MalariaTest = '$mal',";
        $sql .= "SyphilisTest = '$syph',";
        $sql .= "TyphTest = '$typh',";
        $sql .= "UrineLeucTest = '$leuc',";
        $sql .= "UrineRBCTest = '$rbc',";
        $sql .= "UrineGlucoseTest = '$glucose',";
        $sql .= "UrineNitritesTest = '$nit',";
        $sql .= "PregnancyTest = '$preg',";

        $sql .= "Assessment = '$assess',";

        $sql .= "LastHIVTest = '$lastv',";
        $sql .= "LastPZQTx = '$lastpzq',";
        $sql .= "LastWormTx = '$lastworm',";
        $sql .= "LastVitA = '$lastvita',";

        $sql .= "PrevMeds = '$meds',";
        
        $sql .= "Rx_Paracetamol = '$parac',";
        $sql .= "Rx_BenzPen = '$benz',";
        $sql .= "Rx_Ceftriaxone = '$ceft',";
        
        // rx practitioner
        $sql .= "DR_Test = '$pract'";
    
        // remove last comma
        //$sql = substr_replace($sql ,"",-1);
        
        // add conditon
        $sql .= " WHERE VisitID = $visitID";

    } else if ($data["upload"] == "eye") {
        
        $visitID = $data["visitid"];

        // eye values
        $eye1 = $data["eyeval1"];
        $eye2 = $data["eyeval2"];
        $eye3 = $data["eyeval3"];
        
        // practitioner and rxnum
        $pract = $data["pract"];

        // notes
        $assess = $data["assess"];
        
        // build the giant sql string
        $sql = "UPDATE tbl_visit SET ";
        
        $sql .= "TriageOPHT = 'complete',";

        // notes
        $sql .= "Assessment = '$assess',";

        // eye values
        $sql .= "Eye_Val1 = '$eye1',";
        $sql .= "Eye_Val2 = '$eye2',";
        $sql .= "Eye_Val3 = '$eye3',";
        
        // rx practitioner
        $sql .= "DR_Eye = '$pract'";
    
        // remove last comma
        //$sql = substr_replace($sql ,"",-1);
        
        // add conditon
        $sql .= " WHERE VisitID = $visitID";

    } else if ($data["upload"] == "dent") {
        
        $visitID = $data["visitid"];

        // practitioner and rxnum
        $pract = $data["pract"];

        // notes
        $assess = $data["assess"];
        
        // build the giant sql string
        $sql = "UPDATE tbl_visit SET ";

        $sql .= "TriageDENT = 'complete',";
        
        // notes
        $sql .= "Assessment = '$assess',";

        // rx practitioner
        $sql .= "DR_Dental = '$pract'";
    
        // remove last comma and add bracket
        //$sql = substr_replace($sql ,"",-1);
        
        // add conditon
        $sql .= " WHERE VisitID = $visitID";

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