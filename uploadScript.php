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
        if (!empty($med)) {
            $sql .= "TriageMedical,";
            $values .= "'$med',";
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
        
        if (!empty($test)) {$sql .= "TriageTesting = '$test',";}
        if (!empty($med)) {$sql .= "TriageMedical = '$med',";}
        if (!empty($gyn)) {$sql .= "TriageGYN = '$gyn',";}
        if (!empty($opht)) {$sql .= "TriageOPHT = '$opht',";}
        if (!empty($dent)) {$sql .= "TriageDENT = '$dent',";}
        if (!empty($triagev)) {$sql .= "TriageVenDis = '$triagev',";}

        if (!empty($weeks)) {$sql .= "Pregnant_Weeks = '$weeks',";}
        if (!empty($assess)) {$sql .= "Assessment = '$assess',";}

        if (!empty($lastHIV)) {$sql .= "LastHIVTest = '$lastHIV',";}
        if (!empty($lastPZQ)) {$sql .= "LastPZQTx = '$lastPZQ',";}
        if (!empty($lastWorm)) {$sql .= "LastWormTx = '$lastWorm',";}
        if (!empty($lastVitA)) {$sql .= "LastVitA = '$lastVitA',";}

        if (!empty($meds)) {$sql .= "PrevMeds = '$meds',";}

        if (!empty($healthy)) {$sql .= "DX_Healthy = '$healthy',";}
        if (!empty($ntr)) {$sql .= "DX_NoTreatment = '$ntr',";}
        if (!empty($msk)) {$sql .= "DX_MSK = '$msk',";}
        if (!empty($eye)) {$sql .= "DX_Eye = '$eye',";}
        if (!empty($vit)) {$sql .= "DX_Vit = '$vit',";}
        if (!empty($dds)) {$sql .= "DX_DDS = '$dds',";}
        if (!empty($worms)) {$sql .= "DX_Worms = '$worms',";}
        if (!empty($malaria)) {$sql .= "DX_Malaria = '$malaria',";}
        if (!empty($schisto)) {$sql .= "DX_Schisto = '$schisto',";}
        if (!empty($typhoid)) {$sql .= "DX_Typhoid = '$typhoid',";}
        if (!empty($asthma)) {$sql .= "DX_Asthma = '$asthma',";}
        if (!empty($bronchitis)) {$sql .= "DX_Bronchitis = '$bronchitis',";}
        if (!empty($pneumonia)) {$sql .= "DX_Pneumonia = '$pneumonia',";}
        if (!empty($cough)) {$sql .= "DX_Cough = '$cough',";}
        if (!empty($gerd)) {$sql .= "DX_Gerd = '$gerd',";}
        if (!empty($pud)) {$sql .= "DX_PUD = '$pud',";}
        if (!empty($hypertension)) {$sql .= "DX_Hypertension = '$hypertension',";}
        if (!empty($constipation)) {$sql .= "DX_Constipation = '$constipation',";}
        if (!empty($diarrhea)) {$sql .= "DX_Diarrhea = '$diarrhea',";}
        if (!empty($bloody)) {$sql .= "DX_DiarrheaBloody = '$bloody',";}
        if (!empty($diabetes)) {$sql .= "DX_Diabetes = '$diabetes',";}
        if (!empty($pid)) {$sql .= "DX_PID = '$pid',";}
        if (!empty($sti)) {$sql .= "DX_STI = '$sti',";}
        if (!empty($syphilis)) {$sql .= "DX_Syphilis = '$syphilis',";}
        if (!empty($topical)) {$sql .= "DX_Topical = '$topical',";}
        if (!empty($topicaldesc)) {$sql .= "DX_TopicalDesc = '$topicaldesc',";}
        if (!empty($other)) {$sql .= "DX_Other = '$other',";}
        if (!empty($otherdesc)) {$sql .= "DX_OtherDesc = '$otherdesc',";}

        // pregnancy stuff
        if (!empty($anc)) {$sql .= "RegANC = '$anc',";}
        if (!empty($anemia)) {$sql .= "ClinicalAnemia = '$anemia',";}
        if (!empty($iptp)) {$sql .= "LastIPTpx = '$iptp',";}
        if (!empty($sulfadar)) {$sql .= "Sulfadar = '$sulfadar',";}

        // administrated
        if (!empty($parac)) {$sql .= "Rx_Paracetamol = '$parac',";}
        if (!empty($benz)) {$sql .= "Rx_BenzPen = '$benz',";}
        if (!empty($ceft)) {$sql .= "Rx_Ceftriaxone = '$ceft',";}

        // chart
        if (!empty($chart)) {$sql .= "SP_Type = '$chart',";}
        
        if (!empty($ptinit)) {$sql .= "SP_PTInitials = '$ptinit',";}
        if (!empty($ptsex)) {$sql .= "SP_PTSex = '$ptsex',";}
        if (!empty($ptpreg)) {$sql .= "SP_PTPreg = '$ptpreg',";}
        if (!empty($ptmonth)) {$sql .= "SP_PTMonths = '$ptmonth',";}
        if (!empty($ptbf)) {$sql .= "SP_PTBF = '$ptbf',";}
        if (!empty($ptmtz)) {$sql .= "SP_PTMTZ = '$ptmtz',";}
        if (!empty($ptdoxy)) {$sql .= "SP_PTDoxy = '$ptdoxy',";}
        if (!empty($ptamox)) {$sql .= "SP_PTAmox = '$ptamox',";}
        
        if (!empty($p1init)) {$sql .= "SP_PT1Initials = '$p1init',";}
        if (!empty($p1sex)) {$sql .= "SP_PT1Sex = '$p1sex',";}
        if (!empty($p1preg)) {$sql .= "SP_PT1Preg = '$p1preg',";}
        if (!empty($p1month)) {$sql .= "SP_PT1Months = '$p1month',";}
        if (!empty($p1bf)) {$sql .= "SP_PT1BF = '$p1bf',";}
        if (!empty($p1mtz)) {$sql .= "SP_PT1MTZ = '$p1mtz',";}
        if (!empty($p1doxy)) {$sql .= "SP_PT1Doxy = '$p1doxy',";}
        if (!empty($p1amox)) {$sql .= "SP_PT1Amox = '$p1amox',";}
        
        if (!empty($p2init)) {$sql .= "SP_PT2Initials = '$p2init',";}
        if (!empty($p2sex)) {$sql .= "SP_PT2Sex = '$p2sex',";}
        if (!empty($p2preg)) {$sql .= "SP_PT2Preg = '$p2preg',";}
        if (!empty($p2month)) {$sql .= "SP_PT2Months = '$p2month',";}
        if (!empty($p2bf)) {$sql .= "SP_PT2BF = '$p2bf',";}
        if (!empty($p2mtz)) {$sql .= "SP_PT2MTZ = '$p2mtz',";}
        if (!empty($p2doxy)) {$sql .= "SP_PT2Doxy = '$p2doxy',";}
        if (!empty($p2amox)) {$sql .= "SP_PT2Amox = '$p2amox',";}

        if (!empty($p3init)) {$sql .= "SP_PT3Initials = '$p3init',";}
        if (!empty($p3sex)) {$sql .= "SP_PT3Sex = '$p3sex',";}
        if (!empty($p3preg)) {$sql .= "SP_PT3Preg = '$p3preg',";}
        if (!empty($p3month)) {$sql .= "SP_PT3Months = '$p3month',";}
        if (!empty($p3bf)) {$sql .= "SP_PT3BF = '$p3bf',";}
        if (!empty($p3mtz)) {$sql .= "SP_PT3MTZ = '$p3mtz',";}
        if (!empty($p3doxy)) {$sql .= "SP_PT3Doxy = '$p3doxy',";}
        if (!empty($p3amox)) {$sql .= "SP_PT3Amox = '$p3amox',";}

        // follow-up and education
        if (!empty($follow)) {$sql .= "FollowUp = '$follow',";}
        if (!empty($edu)) {$sql .= "Education = '$edu',";}

        // referral
        if (!empty($tb)) {$sql .= "RefTB = '$tb',";}
        if (!empty($hospital)) {$sql .= "RefHospital = '$hospital',";}
        if (!empty($surgery)) {$sql .= "RefSurgery = '$surgery',";}

        // clinic practitioner
        if (!empty($pract1)) {$sql .= "DR_Clinic = '$pract1',";}
        if (!empty($pract2)) {$sql .= "DR_Clinic2 = '$pract2',";}
        if (!empty($pract3)) {$sql .= "DR_Clinic3 = '$pract3',";}
    
        // remove last comma and add bracket
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
        
        if (!empty($assess)) {$sql .= "Assessment = '$assess',";}
        if (!empty($meds)) {$sql .= "PrevMeds = '$meds',";}
        
        if (!empty($sulfadar)) {$sql .= "Sulfadar = '$sulfadar',";}

        if (!empty($parac)) {$sql .= "Rx_Paracetamol = '$parac',";}
        if (!empty($benz)) {$sql .= "Rx_BenzPen = '$benz',";}
        if (!empty($ceft)) {$sql .= "Rx_Ceftriaxone = '$ceft',";}

        if (!empty($pcm)) {$sql .= "Rx_Kit_PCM = '$pcm',";}
        if (!empty($kit)) {$sql .= "Rx_Kit_Pregnancy = '$kit',";}
        if (!empty($alu)) {$sql .= "Rx_ALU = '$alu',";}
        if (!empty($pud)) {$sql .= "Rx_PUD = '$pud',";}
        if (!empty($pzq)) {$sql .= "Rx_PZQ_Tabs = '$pzq',";}
        if (!empty($other)) {$sql .= "Rx_Other = '$other',";}

        // chart
        if (!empty($chart)) {$sql .= "SP_Type = '$chart',";}
        
        if (!empty($ptinit)) {$sql .= "SP_PTInitials = '$ptinit',";}
        if (!empty($ptsex)) {$sql .= "SP_PTSex = '$ptsex',";}
        if (!empty($ptpreg)) {$sql .= "SP_PTPreg = '$ptpreg',";}
        if (!empty($ptmonth)) {$sql .= "SP_PTMonths = '$ptmonth',";}
        if (!empty($ptbf)) {$sql .= "SP_PTBF = '$ptbf',";}
        if (!empty($ptmtz)) {$sql .= "SP_PTMTZ = '$ptmtz',";}
        if (!empty($ptdoxy)) {$sql .= "SP_PTDoxy = '$ptdoxy',";}
        if (!empty($ptamox)) {$sql .= "SP_PTAmox = '$ptamox',";}
        
        if (!empty($p1init)) {$sql .= "SP_PT1Initials = '$p1init',";}
        if (!empty($p1sex)) {$sql .= "SP_PT1Sex = '$p1sex',";}
        if (!empty($p1preg)) {$sql .= "SP_PT1Preg = '$p1preg',";}
        if (!empty($p1month)) {$sql .= "SP_PT1Months = '$p1month',";}
        if (!empty($p1bf)) {$sql .= "SP_PT1BF = '$p1bf',";}
        if (!empty($p1mtz)) {$sql .= "SP_PT1MTZ = '$p1mtz',";}
        if (!empty($p1doxy)) {$sql .= "SP_PT1Doxy = '$p1doxy',";}
        if (!empty($p1amox)) {$sql .= "SP_PT1Amox = '$p1amox',";}
        
        if (!empty($p2init)) {$sql .= "SP_PT2Initials = '$p2init',";}
        if (!empty($p2sex)) {$sql .= "SP_PT2Sex = '$p2sex',";}
        if (!empty($p2preg)) {$sql .= "SP_PT2Preg = '$p2preg',";}
        if (!empty($p2month)) {$sql .= "SP_PT2Months = '$p2month',";}
        if (!empty($p2bf)) {$sql .= "SP_PT2BF = '$p2bf',";}
        if (!empty($p2mtz)) {$sql .= "SP_PT2MTZ = '$p2mtz',";}
        if (!empty($p2doxy)) {$sql .= "SP_PT2Doxy = '$p2doxy',";}
        if (!empty($p2amox)) {$sql .= "SP_PT2Amox = '$p2amox',";}

        if (!empty($p3init)) {$sql .= "SP_PT3Initials = '$p3init',";}
        if (!empty($p3sex)) {$sql .= "SP_PT3Sex = '$p3sex',";}
        if (!empty($p3preg)) {$sql .= "SP_PT3Preg = '$p3preg',";}
        if (!empty($p3month)) {$sql .= "SP_PT3Months = '$p3month',";}
        if (!empty($p3bf)) {$sql .= "SP_PT3BF = '$p3bf',";}
        if (!empty($p3mtz)) {$sql .= "SP_PT3MTZ = '$p3mtz',";}
        if (!empty($p3doxy)) {$sql .= "SP_PT3Doxy = '$p3doxy',";}
        if (!empty($p3amox)) {$sql .= "SP_PT3Amox = '$p3amox',";}

        // rx practitioner
        if (!empty($pract)) {$sql .= "DR_Rx = '$pract',";}
        if (!empty($rxnum)) {$sql .= "RXNum = '$rxnum',";}
    
        // remove last comma and add bracket
        $sql = substr_replace($sql ,"",-1);
        
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
        
        if (!empty($v)) {$sql .= "VTest = '$v',";}
        if (!empty($mal)) {$sql .= "MalariaTest = '$mal',";}
        if (!empty($syph)) {$sql .= "SyphilisTest = '$syph',";}
        if (!empty($typh)) {$sql .= "TyphTest = '$typh',";}
        if (!empty($leuc)) {$sql .= "UrineLeucTest = '$leuc',";}
        if (!empty($rbc)) {$sql .= "UrineRBCTest = '$rbc',";}
        if (!empty($glucose)) {$sql .= "UrineGlucoseTest = '$glucose',";}
        if (!empty($nit)) {$sql .= "UrineNitritesTest = '$nit',";}
        if (!empty($preg)) {$sql .= "PregnancyTest = '$preg',";}

        if (!empty($assess)) {$sql .= "Assessment = '$assess',";}

        if (!empty($lastv)) {$sql .= "LastHIVTest = '$lastv',";}
        if (!empty($lastpzq)) {$sql .= "LastPZQTx = '$lastpzq',";}
        if (!empty($lastworm)) {$sql .= "LastWormTx = '$lastworm',";}
        if (!empty($lastvita)) {$sql .= "LastVitA = '$lastvita',";}

        if (!empty($meds)) {$sql .= "PrevMeds = '$meds',";}
        
        if (!empty($parac)) {$sql .= "Rx_Paracetamol = '$parac',";}
        if (!empty($benz)) {$sql .= "Rx_BenzPen = '$benz',";}
        if (!empty($ceft)) {$sql .= "Rx_Ceftriaxone = '$ceft',";}
        
        // rx practitioner
        if (!empty($pract)) {$sql .= "DR_Test = '$pract',";}
    
        // remove last comma and add bracket
        $sql = substr_replace($sql ,"",-1);
        
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
        
        // notes
        if (!empty($assess)) {$sql .= "Assessment = '$assess',";}

        // eye values
        if (!empty($eye1)) {$sql .= "Eye_Val1 = '$eye1',";}
        if (!empty($eye2)) {$sql .= "Eye_Val2 = '$eye2',";}
        if (!empty($eye3)) {$sql .= "Eye_Val3 = '$eye3',";}
        
        // rx practitioner
        if (!empty($pract)) {$sql .= "DR_Eye = '$pract',";}
    
        // remove last comma and add bracket
        $sql = substr_replace($sql ,"",-1);
        
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
        
        // notes
        if (!empty($assess)) {$sql .= "Assessment = '$assess',";}

        // rx practitioner
        if (!empty($pract)) {$sql .= "DR_Dental = '$pract',";}
    
        // remove last comma and add bracket
        $sql = substr_replace($sql ,"",-1);
        
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