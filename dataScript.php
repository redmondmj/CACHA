<?php
    require_once "db.php";
    
    // Receive the RAW post data.
    $content = trim(file_get_contents("php://input"));
    
    // Attempt to decode the incoming RAW post data from JSON.
    $data = json_decode($content, true); 
    
    // which request is it?
    if ($data["request"] == "stats") {
        // grab the data we want
        $sql = "SELECT FirstName,LastName,BirthYear,BirthMonth,BirthDay,Village FROM tbl_patient WHERE PatientID = '" . $data["id"] . "'";
    } else if ($data["request"] == "basic") {
        $sql = "SELECT VisitedDispensary,TriageTesting,TriageMedical,TriageMedical2,TriageGyn,TriageOPHT,TriageDENT,TriageVenDis,Weight,Temperature,Systolic,Diastolic,Glucose,LastPeriod,Pregnant,Breastfeed,Gravida,Para,Abortus,NumLivingChildren,ChiefComplaint FROM tbl_visit WHERE VisitID = '" . $data["id"] . "'";
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

                        /*
                        // check age - https://stackoverflow.com/questions/3776682/php-calculate-age
                        $age = (date("md", date("U", mktime(0, 0, 0, $year, $month, $day))) > date("md")
                        ? ((date("Y") - $day) - 1)
                        : (date("Y") - $day));

                        $stats->age = $age;
                        */
                    } else {
                        $stats->age = 0;
                    }
                    
                    // add the data to the json
                    array_push($response->entries, $stats);
                }
            } else if ($data["request"] == "basic") {
                // construct new object to add to the array
                class Basic {
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
                    public $med1 = false;
                    public $med2 = false;
                    public $gyn = false;
                    public $opht = false;
                    public $dent = false;
                    public $stationv = false;
                }
                
                // add the entries to the response object
                while ($row = $result->fetch_assoc()) {
                    
                    // put the object together
                    $basic = new Basic();
                    $basic->dispensary = $row["VisitedDispensary"];

                    $basic->$test = $row["TriageTesting"];
                    $basic->$med1 = $row["TriageMedical"];
                    $basic->$med2 = $row["TriageMedical2"];
                    $basic->$gyn = $row["TriageGYN"];
                    $basic->$opht = $row["TriageOPHT"];
                    $basic->$dent = $row["TriageDENT"];
                    $basic->$stationv = $row["TriageVenDis"];

                    $basic->$weight = $row["Weight"];
                    $basic->$temp = $row["Temp"];
                    $basic->$BPtop = $row["Systolic"];
                    $basic->$BPBottom = $row["Diastolic"];
                    $basic->$glucose = $row["Glucose"];
                    $basic->$heart = $row["HeartRate"];

                    $basic->$period = $row["LastPeriod"];
                    $basic->$pregnant = $row["Pregnant"];
                    $basic->$breast = $row["Breastfeed"];
                    
                    $basic->$grav = $row["Gravida"];
                    $basic->$para = $row["Para"];
                    $basic->$abortus = $row["Abortus"];
                    
                    $basic->$living = $row["NumLivingChilden"];
                    $basic->$complaint = $row["ChiefComplaint"];
                    
                    array_push($response->entries, $basic);
                }

            } else if ($data["request"] == "something") {
                // add the entries to the response object


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