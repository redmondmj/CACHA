<?php
    require "db.php";
    
    // Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));
    
    // Attempt to decode the incoming RAW post data from JSON.
    $data = json_decode($content, true); 
    
    // which request is it?
    if ($data["request"] == "stats") {
        // grab the data we want
        $sql = "SELECT * FROM tbl_patient WHERE PatientID = " . $data["id"];
    } else if ($data["request"] == "basic") {
        $sql = "SELECT * FROM tbl_visit WHERE VisitID = " . $data["id"];
    } else if ($data["request"] == "clinic") {
        $sql = "SELECT * FROM tbl_visit WHERE VisitID = " . $data["id"];
    } else if ($data["request"] == "rx") {
        $sql = "SELECT * FROM tbl_visit WHERE VisitID = " . $data["id"];
    } else if ($data["request"] == "test") {
        $sql = "SELECT * FROM tbl_visit WHERE VisitID = " . $data["id"];
    } else if ($data["request"] == "eye") {
        $sql = "SELECT * FROM tbl_visit WHERE VisitID = " . $data["id"];
    } else if ($data["request"] == "dent") {
        $sql = "SELECT * FROM tbl_visit WHERE VisitID = " . $data["id"];
    }

    try {
        
        // run the query
        $result = $connect->query($sql);
        
        // check for responses
        if (@$result->num_rows > 0) {
            // build response object
            // which menu?
            if ($data["request"] == "stats") {
                // construct a new object to send out with json
                class Stats {
                    public $name = "";
                    public $village = "";
                    public $age = 0;
                }

                // add the entries to the response object
                while ($row = $result->fetch_assoc()) {
                    // new data object
                    $stats = new Stats();
                    if (!empty($row["FirstName"])) {
                        $stats->name = $row["FirstName"];
                        if (!empty($row["LastName"])) {$stats->name .= " " . $row["LastName"];}
                    } else if (!empty($row["LastName"])) {$stats->name = $row["LastName"];
                    } else {$stats->name = "No Name";}

                    if (!empty($row["Village"])) {$stats->village = $row["Village"];}
                    
                    // time to calculate age
                    $year = $row["BirthYear"];
                    $month = $row["BirthMonth"];
                    $day = $row["BirthDay"];
                    if ($year != null) { // year check
                        if (($month != null) && ($month != "")) { // month check
                            if (($day == null) || ($day == "")) { // day check
                                // assume close to the end of the month
                                $day = 28;
                            }
                        } else {
                            // assume the end of the year
                            $month = 12;
                            $day = 31;
                        }

                        // check age - https://stackoverflow.com/questions/3776682/php-calculate-age
                        $age = (date("md", date("U", mktime(0, 0, 0, $month, $day, $year))) > date("md")
                        ? ((date("Y") - $year) - 1)
                        : (date("Y") - $year));

                        $stats->age = $age;
                        
                    } else {
                        $stats->age = 0;
                    }
                    
                    // add the data to the json
                    array_push($response->entries, $stats);
                }
            } else if ($data["request"] == "basic") {
                // construct new object to add to the array
                class BasicInfo {
                    public $dispensary = "";
                    public $weight = 0;
                    public $temp = 0;
                    public $BPTop = 0;
                    public $BPBottom = 0;
                    public $heart = 0;
                    public $glucose = 0;
                    public $pregnant = false;
                    public $breast = false;
                    
                    public $living = 0;
                    public $grav = 0;
                    public $para = 0;
                    public $abortus = 0;
                    public $period = "";
                    
                    public $complaint = "";
                    
                    public $test = false;
                    public $med = false;
                    public $gyn = false;
                    public $opht = false;
                    public $dent = false;
                    public $stationv = false;
                }
                
                // add the entries to the response object
                while ($row = $result->fetch_assoc()) {
                    
                    // put the object together
                    $basic = new BasicInfo();
                    $basic->dispensary = $row["VisitedDispensary"];

                    $basic->test = $row["TriageTesting"];
                    $basic->med = $row["TriageMedical"];
                    $basic->gyn = $row["TriageGYN"];
                    $basic->opht = $row["TriageOPHT"];
                    $basic->dent = $row["TriageDENT"];
                    $basic->stationv = $row["TriageVenDis"];

                    $basic->weight = $row["Weight"];
                    $basic->temp = $row["Temperature"];
                    $basic->BPtop = $row["Systolic"];
                    $basic->BPBottom = $row["Diastolic"];
                    $basic->glucose = $row["Glucose"];
                    $basic->heart = $row["HeartRate"];

                    $basic->period = $row["LastPeriod"];
                    $basic->pregnant = $row["Pregnant"];
                    $basic->breast = $row["Breastfeed"];
                    
                    $basic->grav = $row["Gravida"];
                    $basic->para = $row["Para"];
                    $basic->abortus = $row["Abortus"];
                    
                    $basic->living = $row["NumLivingChildren"];
                    $basic->complaint = $row["ChiefComplaint"];
                    
                    // add the data to the json
                    array_push($response->entries, $basic);
                }

            } else if ($data["request"] == "clinic") {
                // construct a new object to send the data
                class ClinicInfo {

                    // top data
                    public $weight = "";
                    public $bp = "";
                    public $temp = "";
                    public $complaint = "";

                    // tests
                    public $lastv = "";
                    public $lastpzq = "";
                    public $lastworm = "";
                    public $lastvita = "";

                    // administrated
                    public $parac = "";
                    public $benz = "";
                    public $ceft = "";
        
                    // diagnosis
                    public $healthy = "";
                    public $ntr = "";
                    public $msk = 0;
                    public $eye = 0;
                    public $vit = 0;
                    public $dds = 0;
                    public $worms = 0;
                    public $mal = 0;
                    public $schisto = 0;
                    public $typhoid = 0;
                    public $asthma = 0;
                    public $bronc = 0;
                    public $pneu = 0;
                    public $cough = 0;
                    public $gerd = 0;
                    public $pud = 0;
                    public $hyper = 0;
                    public $con = 0;
                    public $diarrhea = 0;
                    public $diarrheatype = "";
                    public $diabetes = 0;
                    public $pid = 0;
                    public $sti = 0;
                    public $syph = 0;
                    public $topical = 0;
                    public $topicaldesc = "";
                    public $other = 0;
                    public $otherdesc = "";
                    public $assess = "";
        
                    // pregnancy
                    public $weeks = 0;
                    public $anc = "";
                    public $anemia = "";
                    public $lastiptp = "";
                    public $sulfadar = 0;
        
                    // notes
                    public $follow = "";
                    public $edu = "";
        
                    // referral
                    public $referral = "";
        
                    // sti chart
                    public $chart = "";
                
                    public $ptinit = "";
                    public $ptsex = "";
                    public $ptpreg = "";
                    public $ptmonth = 0;
                    public $ptbf = "";
                    public $ptmtz = 0;
                    public $ptdoxy = 0;
                    public $ptamox = 0;

                    public $p1init = "";
                    public $p1sex = "";
                    public $p1preg = "";
                    public $p1month = 0;
                    public $p1bf = "";
                    public $p1mtz = 0;
                    public $p1doxy = 0;
                    public $p1amox = 0;
                
                    public $p2init = "";
                    public $p2sex = "";
                    public $p2preg = "";
                    public $p2month = 0;
                    public $p2bf = "";
                    public $p2mtz = 0;
                    public $p2doxy = 0;
                    public $p2amox = 0;
                
                    public $p3init = "";
                    public $p3sex = "";
                    public $p3preg = "";
                    public $p3month = 0;
                    public $p3bf = "";
                    public $p3mtz = 0;
                    public $p3doxy = 0;
                    public $p3amox = 0;

                    // practitioner
                    public $pract = 0;

                    // stations
                    public $test = "";
                    public $med = "";
                    public $gyn = "";
                    public $opht = "";
                    public $dent = "";
                    public $triagev = "";
                }

                while ($row = $result->fetch_assoc()) {

                    // response object to send
                    $clinic = new ClinicInfo();

                    // pulled and placed in the order they appear in the database

                    // stations
                    $clinic->test = $row["TriageTesting"];
                    $clinic->med = $row["TriageMedical"];
                    $clinic->gyn = $row["TriageGYN"];
                    $clinic->opht = $row["TriageOPHT"];
                    $clinic->dent = $row["TriageDENT"];
                    $clinic->stationv = $row["TriageVenDis"];

                    // top stuff
                    $clinic->weight = $row["Weight"];
                    $clinic->temp = $row["Temperature"];
                    if ((!empty($row["Systolic"])) || (!empty($row["Diastolic"]))) {$clinic->bp = $row["Systolic"] . "/" . $row["Diastolic"];} 
                    else {$clinic->bp = "";}
                    $clinic->weeks = $row["Pregnant_Weeks"];

                    // assessment and complaint
                    $clinic->complaint = $row["ChiefComplaint"];
                    $clinic->assess = $row["Assessment"];

                    // last test
                    $clinic->lastv = $row["LastHIVTest"];
                    $clinic->lastpzq = $row["LastPZQTx"];
                    $clinic->lastworm = $row["LastWormTx"];
                    $clinic->lastvita = $row["LastVitA"];

                    // diagnosis
                    $clinic->healthy = $row["DX_Healthy"];
                    $clinic->ntr = $row["DX_NoTreatment"];
                    $clinic->msk = $row["DX_MSK"];
                    $clinic->eye = $row["DX_Eye"];
                    $clinic->vit = $row["DX_Vit"];
                    $clinic->dds = $row["DX_DDS"];
                    $clinic->worms = $row["DX_Worms"];
                    $clinic->mal = $row["DX_Malaria"];
                    $clinic->schisto = $row["DX_Schisto"];
                    $clinic->typhoid = $row["DX_Typhoid"];
                    $clinic->asthma = $row["DX_Asthma"];
                    $clinic->bronc = $row["DX_Bronchitis"];
                    $clinic->pneu = $row["DX_Pneumonia"];
                    $clinic->cough = $row["DX_Cough"];
                    $clinic->gerd = $row["DX_Gerd"];
                    $clinic->pud = $row["DX_PUD"];
                    $clinic->hyper = $row["DX_Hypertension"];
                    $clinic->con = $row["DX_Constipation"];
                    $clinic->diarrhea = $row["DX_Diarrhea"];
                    $clinic->diarrheatype = $row["DX_DiarrheaBloody"];
                    $clinic->diabetes = $row["DX_Diabetes"];
                    $clinic->pid = $row["DX_PID"];
                    $clinic->sti = $row["DX_STI"];
                    $clinic->syph = $row["DX_Syphilis"];
                    $clinic->topical = $row["DX_Topical"];
                    $clinic->topicaldesc = $row["DX_TopicalDesc"];
                    $clinic->other = $row["DX_Other"];
                    $clinic->otherdesc = $row["DX_OtherDesc"];

                    // pregnancy stuff
                    $clinic->anc = $row["RegANC"];
                    $clinic->anemia = $row["ClinicalAnemia"];
                    $clinic->iptp = $row["LastIPTpx"];
                    $clinic->sulfadar = $row["Sulfadar"];

                    // administrated
                    $clinic->parac = $row["Rx_Paracetamol"];
                    $clinic->benz = $row["Rx_BenzPen"];
                    $clinic->ceft = $row["Rx_Ceftriaxone"];

                    // chart
                    $clinic->chart = $row["SP_Type"];
                
                    $clinic->ptinit = $row["SP_PTInitials"];
                    $clinic->ptsex = $row["SP_PTSex"];
                    $clinic->ptpreg = $row["SP_PTPreg"];
                    $clinic->ptmonth = $row["SP_PTMonths"];
                    $clinic->ptbf = $row["SP_PTBF"];
                    $clinic->ptmtz = $row["SP_PTMTZ"];
                    $clinic->ptdoxy = $row["SP_PTDoxy"];
                    $clinic->ptamox = $row["SP_PTAmox"];

                    $clinic->p1init = $row["SP_PT1Initials"];
                    $clinic->p1sex = $row["SP_PT1Sex"];
                    $clinic->p1preg = $row["SP_PT1Preg"];
                    $clinic->p1month = $row["SP_PT1Months"];
                    $clinic->p1bf = $row["SP_PT1BF"];
                    $clinic->p1mtz = $row["SP_PT1MTZ"];
                    $clinic->p1doxy = $row["SP_PT1Doxy"];
                    $clinic->p1amox = $row["SP_PT1Amox"];
                
                    $clinic->p2init = $row["SP_PT2Initials"];
                    $clinic->p2sex = $row["SP_PT2Sex"];
                    $clinic->p2preg = $row["SP_PT2Preg"];
                    $clinic->p2month = $row["SP_PT2Months"];
                    $clinic->p2bf = $row["SP_PT2BF"];
                    $clinic->p2mtz = $row["SP_PT2MTZ"];
                    $clinic->p2doxy = $row["SP_PT2Doxy"];
                    $clinic->p2amox = $row["SP_PT2Amox"];
                
                    $clinic->p3init = $row["SP_PT3Initials"];
                    $clinic->p3sex = $row["SP_PT3Sex"];
                    $clinic->p3preg = $row["SP_PT3Preg"];
                    $clinic->p3month = $row["SP_PT3Months"];
                    $clinic->p3bf = $row["SP_PT3BF"];
                    $clinic->p3mtz = $row["SP_PT3MTZ"];
                    $clinic->p3doxy = $row["SP_PT3Doxy"];
                    $clinic->p3amox = $row["SP_PT3Amox"];

                    // follow-up and education
                    $clinic->follow = $row["FollowUp"];
                    $clinic->edu = $row["Education"];

                    // clinic practitioner
                    $clinic->pract = $row["DR_Clinic"];

                    // put the object into the response
                    array_push($response->entries, $clinic);
                }
            } else if ($data["request"] == "rx") {
                // construct a new object to send the data
                class RxInfo {

                    // top data
                    public $weight = "";
                    public $bp = "";
                    public $temp = "";
                    public $complaint = "";

                    public $assess = "";
                    public $meds = "";

                    // drugs
                    public $parac = "";
                    public $benz = "";
                    public $ceft = "";
        
                    public $pcm = "";
                    public $kit = "";
                    public $pud = "";

                    public $lastpzq = "";
                    public $alu = "";
                    public $sulfadar = 0;
        
                    public $drugs = "";

                    public $other = "";

                    // sti chart
                    public $chart = "";
                
                    public $ptinit = "";
                    public $ptsex = "";
                    public $ptpreg = "";
                    public $ptmonth = 0;
                    public $ptbf = "";
                    public $ptmtz = 0;
                    public $ptdoxy = 0;
                    public $ptamox = 0;

                    public $p1init = "";
                    public $p1sex = "";
                    public $p1preg = "";
                    public $p1month = 0;
                    public $p1bf = "";
                    public $p1mtz = 0;
                    public $p1doxy = 0;
                    public $p1amox = 0;
                
                    public $p2init = "";
                    public $p2sex = "";
                    public $p2preg = "";
                    public $p2month = 0;
                    public $p2bf = "";
                    public $p2mtz = 0;
                    public $p2doxy = 0;
                    public $p2amox = 0;
                
                    public $p3init = "";
                    public $p3sex = "";
                    public $p3preg = "";
                    public $p3month = 0;
                    public $p3bf = "";
                    public $p3mtz = 0;
                    public $p3doxy = 0;
                    public $p3amox = 0;

                    // practitioner
                    public $pract = 0;

                    // rxNum
                    public $rxnum = "";

                    // stations
                    public $test = "";
                    public $med = "";
                    public $gyn = "";
                    public $opht = "";
                    public $dent = "";
                    public $triagev = "";

                }

                while ($row = $result->fetch_assoc()) {

                    // response object to send
                    $rx = new RxInfo();

                    // pulled and placed in the order they appear in the database

                    // stations
                    $rx->test = $row["TriageTesting"];
                    $rx->med = $row["TriageMedical"];
                    $rx->gyn = $row["TriageGYN"];
                    $rx->opht = $row["TriageOPHT"];
                    $rx->dent = $row["TriageDENT"];
                    $rx->stationv = $row["TriageVenDis"];

                    // top stuff
                    $rx->weight = $row["Weight"];
                    $rx->temp = $row["Temperature"];
                    if ((!empty($row["Systolic"])) || (!empty($row["Diastolic"]))) {$rx->bp = $row["Systolic"] . "/" . $row["Diastolic"];} 
                    else {$rx->bp = "";}

                    // assessment, complaint and previous meds
                    $rx->complaint = $row["ChiefComplaint"];
                    $rx->assess = $row["Assessment"];
                    $rx->meds = $row["PrevMeds"];

                    // drugs
                    $rx->sulfadar = $row["Sulfadar"];
                    $rx->parac = $row["Rx_Paracetamol"];
                    $rx->benz = $row["Rx_BenzPen"];
                    $rx->ceft = $row["Rx_Ceftriaxone"];
                    $rx->pcm = $row["Rx_Kit_PCM"];
                    $rx->kit = $row["Rx_Kit_Pregnancy"];
                    $rx->alu = $row["Rx_ALU"];
                    $rx->pud = $row["Rx_PUD"];
                    $rx->pzq = $row["Rx_PZQ_Tabs"];

                    $rx->other = $row["Rx_Other"];

                    // chart
                    $rx->chart = $row["SP_Type"];
                
                    $rx->ptinit = $row["SP_PTInitials"];
                    $rx->ptsex = $row["SP_PTSex"];
                    $rx->ptpreg = $row["SP_PTPreg"];
                    $rx->ptmonth = $row["SP_PTMonths"];
                    $rx->ptbf = $row["SP_PTBF"];
                    $rx->ptmtz = $row["SP_PTMTZ"];
                    $rx->ptdoxy = $row["SP_PTDoxy"];
                    $rx->ptamox = $row["SP_PTAmox"];

                    $rx->p1init = $row["SP_PT1Initials"];
                    $rx->p1sex = $row["SP_PT1Sex"];
                    $rx->p1preg = $row["SP_PT1Preg"];
                    $rx->p1month = $row["SP_PT1Months"];
                    $rx->p1bf = $row["SP_PT1BF"];
                    $rx->p1mtz = $row["SP_PT1MTZ"];
                    $rx->p1doxy = $row["SP_PT1Doxy"];
                    $rx->p1amox = $row["SP_PT1Amox"];
                
                    $rx->p2init = $row["SP_PT2Initials"];
                    $rx->p2sex = $row["SP_PT2Sex"];
                    $rx->p2preg = $row["SP_PT2Preg"];
                    $rx->p2month = $row["SP_PT2Months"];
                    $rx->p2bf = $row["SP_PT2BF"];
                    $rx->p2mtz = $row["SP_PT2MTZ"];
                    $rx->p2doxy = $row["SP_PT2Doxy"];
                    $rx->p2amox = $row["SP_PT2Amox"];
                
                    $rx->p3init = $row["SP_PT3Initials"];
                    $rx->p3sex = $row["SP_PT3Sex"];
                    $rx->p3preg = $row["SP_PT3Preg"];
                    $rx->p3month = $row["SP_PT3Months"];
                    $rx->p3bf = $row["SP_PT3BF"];
                    $rx->p3mtz = $row["SP_PT3MTZ"];
                    $rx->p3doxy = $row["SP_PT3Doxy"];
                    $rx->p3amox = $row["SP_PT3Amox"];

                    // clinic practitioner and # of Rx
                    $rx->pract = $row["DR_Rx"];
                    $rx->rxnum = $row["RXNum"];

                    // put the object into the response
                    array_push($response->entries, $rx);
                    
                }
            } else if ($data["request"] == "test") {

                // construct a new object to send the data
                class TestInfo {

                    // top data
                    public $weight = "";
                    public $bp = "";
                    public $temp = "";
                    public $complaint = "";

                    // tests
                    public $v = "";
                    public $mal = "";
                    public $syph = "";
                    public $typh = "";
                    public $preg = "";

                    public $lastv = "";
                    public $lastpzq = "";
                    public $lastworm = "";
                    public $lastvita = "";

                    public $leuc = "";
                    public $rbc = "";
                    public $glucose = "";
                    public $nit = "";

                    // drugs
                    public $parac = "";
                    public $benz = "";
                    public $ceft = "";

                    // notes
                    public $assess = "";
                    public $meds = "";

                    // practitioner
                    public $pract = 0;

                    // stations
                    public $test = "";
                    public $med = "";
                    public $gyn = "";
                    public $opht = "";
                    public $dent = "";
                    public $triagev = "";

                }

                while ($row = $result->fetch_assoc()) {

                    // response object to send
                    $test = new TestInfo();

                    // pulled and placed in the order they appear in the database

                    // stations
                    $test->test = $row["TriageTesting"];
                    $test->med = $row["TriageMedical"];
                    $test->gyn = $row["TriageGYN"];
                    $test->opht = $row["TriageOPHT"];
                    $test->dent = $row["TriageDENT"];
                    $test->stationv = $row["TriageVenDis"];

                    // top stuff
                    $test->weight = $row["Weight"];
                    $test->temp = $row["Temperature"];
                    if ((!empty($row["Systolic"])) || (!empty($row["Diastolic"]))) {$test->bp = $row["Systolic"] . "/" . $row["Diastolic"];} 
                    else {$test->bp = "";}

                    // tests
                    $test->v = $row["VTest"];
                    $test->mal = $row["MalariaTest"];
                    $test->syph = $row["SyphilisTest"];
                    $test->typh = $row["TyphTest"];

                    $test->leuc = $row["UrineLeucTest"];
                    $test->rbc = $row["UrineRBCTest"];
                    $test->glucose = $row["UrineGlucoseTest"];
                    $test->nit = $row["UrineNitritesTest"];

                    $test->preg = $row["PregnancyTest"];

                    $test->complaint = $row["ChiefComplaint"];
                    $test->assess = $row["Assessment"];

                    $test->lastv = $row["LastHIVTest"];
                    $test->lastpzq = $row["LastPZQTx"];
                    $test->lastworm = $row["LastWormTx"];
                    $test->lastvita = $row["LastVitA"];

                    // previous meds
                    $test->meds = $row["PrevMeds"];

                    // drugs
                    $test->parac = $row["Rx_Paracetamol"];
                    $test->benz = $row["Rx_BenzPen"];
                    $test->ceft = $row["Rx_Ceftriaxone"];

                    // clinic practitioner and # of Rx
                    $test->pract = $row["DR_Test"];

                    // put the object into the response
                    array_push($response->entries, $test);
                }

            } else if ($data["request"] == "eye") {

                // construct a new object to send the data
                class EyeInfo {

                    // top data
                    public $weight = "";
                    public $bp = "";
                    public $temp = "";
                    public $complaint = "";

                    // eye values
                    public $eyeval1 = "";
                    public $eyeval2 = "";
                    public $eyeval3 = "";

                    // notes
                    public $assess = "";

                    // practitioner
                    public $pract = 0;

                    // stations
                    public $test = "";
                    public $med = "";
                    public $gyn = "";
                    public $opht = "";
                    public $dent = "";
                    public $triagev = "";

                }

                while ($row = $result->fetch_assoc()) {

                    // response object to send
                    $eye = new EyeInfo();

                    // pulled and placed in the order they appear in the database

                    // stations
                    $eye->test = $row["TriageTesting"];
                    $eye->med = $row["TriageMedical"];
                    $eye->gyn = $row["TriageGYN"];
                    $eye->opht = $row["TriageOPHT"];
                    $eye->dent = $row["TriageDENT"];
                    $eye->stationv = $row["TriageVenDis"];

                    // top stuff
                    $eye->weight = $row["Weight"];
                    $eye->temp = $row["Temperature"];
                    if ((!empty($row["Systolic"])) || (!empty($row["Diastolic"]))) {$eye->bp = $row["Systolic"] . "/" . $row["Diastolic"];} 
                    else {$eye->bp = "";}

                    $eye->assess = $row["Assessment"];

                    $eye->eyeval1 = $row["Eye_Val1"];
                    $eye->eyeval2 = $row["Eye_Val2"];
                    $eye->eyeval3 = $row["Eye_Val3"];

                    // eye practitioner
                    $eye->pract = $row["DR_Eye"];

                    // put the object into the response
                    array_push($response->entries, $eye);
                }

            } else if ($data["request"] == "dent") {

                // construct a new object to send the data
                class DentInfo {

                    // top data
                    public $weight = "";
                    public $bp = "";
                    public $temp = "";
                    public $complaint = "";

                    // notes
                    public $assess = "";

                    // practitioner
                    public $pract = 0;

                    // stations
                    public $test = "";
                    public $med = "";
                    public $gyn = "";
                    public $opht = "";
                    public $dent = "";
                    public $triagev = "";

                }

                while ($row = $result->fetch_assoc()) {

                    // response object to send
                    $dent = new DentInfo();

                    // pulled and placed in the order they appear in the database

                    // stations
                    $dent->test = $row["TriageTesting"];
                    $dent->med = $row["TriageMedical"];
                    $dent->gyn = $row["TriageGYN"];
                    $dent->opht = $row["TriageOPHT"];
                    $dent->dent = $row["TriageDENT"];
                    $dent->stationv = $row["TriageVenDis"];

                    // top stuff
                    $dent->weight = $row["Weight"];
                    $dent->temp = $row["Temperature"];
                    if ((!empty($row["Systolic"])) || (!empty($row["Diastolic"]))) {$dent->bp = $row["Systolic"] . "/" . $row["Diastolic"];} 
                    else {$dent->bp = "";}

                    $dent->assess = $row["Assessment"];

                    // eye practitioner
                    $dent->pract = $row["DR_Dental"];

                    // put the object into the response
                    array_push($response->entries, $dent);
                }

            }

        } else {
            // no entries
        }
        
        // set success to true
        $response->success = true;
        
    } catch (Error $e) {
        $response->reason = "Possible Query Error";
        echo json_encode($response);
    } finally {
        mysqli_close($connect);
    }

    // send data back
    echo json_encode($response);
?>