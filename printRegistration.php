<?php
    require 'db.php';
    //grab URL
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
    //parse string for id
    $parts = parse_url($url);
    parse_str($parts['query'], $query);
    
    //assign visitID
    $visitID = $query['id'];

    
    $sql = "SELECT * FROM tbl_patient INNER JOIN tbl_visit ON tbl_patient.PatientID = tbl_visit.PatientID WHERE tbl_visit.VisitID = $visitID";

  try{
      $result = mysqli_query($connect, $sql) or die(mysqli_error($connect));
      $row = mysqli_fetch_assoc($result);
      
      // $patientID = $row['PatientID'];
      $visitDate = $row['VisitDate'];
      $visitTime = $row['VisitTime'];
      $visitedDispensary = $row['VisitedDispensary'];
      $triageTesting = $row['TriageTesting'];
      $triageMedical = $row['TriageMedical'];
      $triageGYN = $row['TriageGYN'];
      $triageOPHT = $row['TriageOPHT'];
      $triageDENT = $row['TriageDENT'];
      $triageVenDis = $row['TriageVenDis'];
      $weight = $row['Weight'];
      $temperature = $row['Temperature'];
      $bloodPressure = $row['Systolic'] . "/" . $row['Diastolic'];
      $glucose = $row['Glucose'];
      $heartRate = $row['HeartRate'];
      $chiefComplaint = $row['ChiefComplaint'];

      $firstName = $row['FirstName'];
      $lastName = $row['LastName'];
      $village = $row['Village'];
      $birthYear = $row['BirthYear'];
      $sex = $row['Sex'];

      $age = date("Y") - $birthYear;

    } catch(Error $e){
        echo false;
    } finally {
       // mysqli_stmt_close($connect);
        mysqli_close($connect);
    }

    function dropCheckbox($test, $text){
      if(($test != "no") && ($test != null)){
        echo "<i class='fa fa-check-square-o fa-lg' style='color:#000000' aria-hidden='true'></i> <span style='padding-right:10px;font-size:10px'>$text</span>";                  
      } else {
        echo "<i class='fa fa-square-o fa-lg' style='color:#000000' aria-hidden='true'></i> <span style='padding-right:10px;font-size:10px'>$text</span>";
      }
    }

    function dropContent($text) {
      if ($text == "") {
        $text = "--";
      }
      echo "<span style='color:#000000;padding-right:10px'>$text</span>";
    }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Latest compiled and minified CSS -->
    <!-- Bootstrap core CSS -->
    <link href="bin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/reportStyles.css">
      <style>
        /* @media print{
          @page {size: landscape}
        } */
      </style>
    <title>CACHA : Patient Report</title>
  </head>
  <body>

    <div id="container" class="small">

        <div class="col-4">
          <h4>Canada-Africa Community Health Alliance</h4>
          <div>Alliance de Sante Communitaire Canada-Afrique</div>
          Triage: <!--<?php //dropContent("Sample Text"); ?> Not sure anything is supposed to be here -->

          <span style="font-weight:bold">Testing:</span> <?php dropContent($triageTesting); ?>
          <div>
            Triage:
            <span style="font-weight:bold">MED:</span> <?php dropContent($triageMedical); ?>
            <span style="font-weight:bold">GYN:</span> <?php dropContent($triageGYN); ?>
            <span style="font-weight:bold">OPT:</span> <?php dropContent($triageOPHT); ?>
            <span style="font-weight:bold">DENT:</span> <?php dropContent($triageDENT); ?>
            <span style="font-weight:bold">V:</span> <?php dropContent($triageVenDis); ?>
          </div>
        </div>
        <br>
        <div class="col-3" style="background:#EAFFDE">
        <span style="font-weight:bold">CHART#:</span> <?php dropContent($visitID); ?><br>
        <span style="font-weight:bold">DISPENSARY:</span> <?php dropContent($visitedDispensary); ?><br>
        <span style="font-weight:bold">TIME:</span> <?php dropContent($visitTime); ?><br>
        <span style="font-weight:bold">DATE:</span> <?php dropContent($visitDate); ?><br>
        </div>
        <br>
        <div class ="col-4" style="background:#FEDEDE">
        <span style="font-weight:bold">Name:</span> <?php dropContent($firstName . " " . $lastName); ?><br>
        <span style="font-weight:bold">Village:</span> <?php dropContent($village); ?><br>
        </div>  
        <br>
        <div class ="col-4" style="background:#E6A9A9">
          <div>
            <?php if ($sex == "male") : ?>
              <?php dropCheckbox("yes", "M"); ?>
              <?php dropCheckbox("no", "F"); ?>
            <?php else : ?>
              <?php dropCheckbox("no", "M"); ?>
              <?php dropCheckbox("yes", "F"); ?>
            <?php endif ?>          
            <span style="font-weight:bold">AGE:</span> <?php dropContent( $age); ?>
            <span style="font-weight:bold">WEIGHT:</span> <?php dropContent( $weight); ?>KG
          </div>
          <div>
          <span style="font-weight:bold">TEMP:</span> <?php dropContent($temperature); ?>
          <span style="font-weight:bold">BP:</span> <?php dropContent($bloodPressure); ?>
          </div>
          <div>
          <span style="font-weight:bold">GLUCOSE:</span> <?php dropContent($glucose); ?>
          <span style="font-weight:bold">HR:</span> <?php dropContent($heartRate); ?>
          </div>
        </div>
        <br>
        <div class="col-4" style="background:#F4BB38">
          <span style="font-weight:bold">Chief Complaint:</span><br>
          <?php dropContent($chiefComplaint); ?>
        </div>
        <br>
        <div class="col-4"style="background:#E6A9A9">
          <table>
            <tr>
              <td><span style="font-weight:bold">MED:</span></td><td style="padding-left:10px;">1</td>
            </tr>
              <tr>
              <td><span style="font-weight:bold">TEST - A:</span></td><td style="padding-left:10px;">2</td>
            </tr>
              <tr>
              <td><span style="font-weight:bold">TEST - B:</span></td><td style="padding-left:10px;">3</td>
            </tr>
              <tr>
              <td><span style="font-weight:bold">MED:</span></td><td style="padding-left:10px;">4</td>
            </tr>
              <tr>
              <td><span style="font-weight:bold"> GYNE:</span></td><td style="padding-left:10px;">5</td>
            </tr>
              <tr>
              <td><span style="font-weight:bold">TEST - A:</span></td><td style="padding-left:10px;">6</td>
            </tr>
              <tr>
              <td><span style="font-weight:bold">GYNE:</span></td><td style="padding-left:10px;">7</td>
            </tr>
              <tr>
              <td><span style="font-weight:bold">DENT:</span></td><td style="padding-left:10px;">8</td>
            </tr>
              <tr>
              <td><span style="font-weight:bold">EYE:</span></td><td style="padding-left:10px;">9</td>
            </tr>
              <tr>
              <td><span style="font-weight:bold">EDUC:</span></td><td style="padding-left:10px;">10</td>
            </tr>
              <tr>
              <td><span style="font-weight:bold">RXY:</span></td><td style="padding-left:10px;">11</td>
            </tr>

        </div>
        
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="bin/jquery-3.2.1.min.js"></script>
    <script src="bin/bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="bin/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bin/bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
