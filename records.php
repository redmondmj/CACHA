<?php
    require_once "db.php";
    $display_block = "";
    //SQL statement * for full name trim(concat(tbl_patient.FirstName,' ',tbl_patient.LastName)) AS fullname
	$sql = "SELECT tbl_patient.FirstName, tbl_patient.LastName, tbl_visit.VisitID, tbl_patient.Village FROM tbl_patient LEFT JOIN tbl_visit ON tbl_patient.PatientID=tbl_visit.PatientID ORDER BY tbl_patient.LastName;";
	$result = @mysqli_query($connect, $sql) or die(mysqli_error($connect));
	while ($row = mysqli_fetch_array($result)) {
        $id = $row['VisitID'];
        //$fullname = stripslashes($row['fullname']);
        $fname = $row['FirstName'];
        $lname = $row['LastName']; 
        $village = $row['Village'];
        
        $display_block .= "
        <tr><td><a href=\"print.php?id=$id\">$fname</a></td><td><a href=\"print.php?id=$id\">$lname</a></td><td><a href=\"print.php?id=$id\">$village</a></td><td><a href=\"print.php?id=$id\">$id</a></td></tr>
        ";
    }
    mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="bin/bootstrap/favicon.ico">

    <title>CACHA - View</title>
    <script src="bin/jquery-3.2.1.min.js"></script>
    <!-- Data Tables css-->
    <link rel="stylesheet" type="text/css" href="/bin/DataTables/datatables.min.css"/>
    <!-- Data Tables js-->
    <script type="text/javascript" src="bin/DataTables/datatables.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="bin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/cover.css" rel="stylesheet">
       <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster 
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery.min.js"><\/script>')
    </script>-->
    <script src="bin/bootstrap/assets/js/vendor/popper.min.js"></script>
    <script src="bin/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bin/bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#visitTable').DataTable({
                "pageLength": 25
            });
        } );
    </script>
</head>

<body>

    <div class="site-wrapper">

        <div class="site-wrapper-inner">

            <div class="cover-container">

                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand">CACHA</h3>
                        <nav class="nav nav-masthead">
                            <a class="nav-link" href="index.html">Home</a>
                            <a class="nav-link" href="register.html">Register</a>
                            <a class="nav-link" href="clinic.html">Clinic</a>
                            <a class="nav-link" href="test.html">Test</a>
                            <a class="nav-link" href="eye.html">Eye</a>
                            <a class="nav-link" href="dental.html">Dental</a>
                            <a class="nav-link" href="pharma.html">Rx</a>
                            <a class="nav-link active" href="records.php">Records</a>
                        </nav>
                    </div>
                </div>

                <div class="inner cover">
                    <h1 class="cover-heading"></h1>

                    <table id="visitTable" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Village</th>
                                <th>Chart ID</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Village</th>
                            <th>Chart ID</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php echo $display_block; ?>
                        </tbody>
                    </table>

                    

                </div>

                

            </div>

        </div>

    </div>

 
</body>

</html>