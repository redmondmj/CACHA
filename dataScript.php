<?php
    require "db.php";
    
    // Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));
    
    // Attempt to decode the incoming RAW post data from JSON.
    $data = json_decode($content, true); 
    
    // which request is it?
    if ($data["request"] == "stats") {
        // grab the data we want
        $sql = "SELECT FirstName,LastName,BirthYear,BirthMonth,BirthDay,Village FROM tbl_patient WHERE PatientID = '" . $data["id"] . "'";
    } else if ($data["request"] == "basic") {
        $sql = "SELECT * FROM tbl_visit WHERE VisitID = " . $data["id"];
    } else if ($data["request"] == "clinic") {
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
                    $stats->name = $row["FirstName"] . " " . $row["LastName"];
                    $stats->village = $row["Village"];
                    
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
                class clinicInfo {

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
                    public $topical = "";
                    public $other = "";
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
                    public $tb = "";
                    public $surgery = "";
                    public $hospital = "";
        
                    // practitioner
                    public $doc = "";

                    // sti chart


                    // stations
                    public $test = "";
                    public $med = "";
                    public $gyn = "";
                    public $opht = "";
                    public $dent = "";
                    public $triagev = "";

                }

                while ($row = $result->fetch_assoc()) {

                    $clinic->lastv = $row["LastHIVTest"];
                    $clinic->lastpzq = $row["LastPZQTx"];
                    $clinic->lastworm = $row["LastWormTx"];
                    $clinic->lastvita = $row["LastVitA"];

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
                    $clinic->diarrheatype = $row["DX_DiarrheaType"];
                    $clinic->diabetes = $row["DX_Diabetes"];
                    $clinic->pid = $row["DX_PID"];
                    $clinic->sti = $row["DX_STI"];
                    $clinic->syph = $row["DX_Syphilis"];
                    $clinic->topical = $row["DX_Topical"];
                    $clinic->topicaldesc = $row["DX_TopicalDesc"];
                    $clinic->other = $row["DX_Other"];
                    $clinic->otherdesc = $row["DX_OtherDesc"];
                    $clinic->assess = $row["DX_Assess"];

                    $clinic->parac = $row["parac"];
                    $clinic->benz = $row["benz"];
                    $clinic->ceft = $row["ceft"];
                }
            } else if ($data["request"] == "somethingelse") {
                // add the entries to the response object
                /*while ($row = $result->fetch_assoc()) {
                    array_push($response->entries, $row["Dispensary"]);
                }*/
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