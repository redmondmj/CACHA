(function() {
    "use strict";

    // retrieve data
    var dropdownScript = "dropdownScript.php";
    var dataScript = "dataScript.php";
    var uploadScript = "uploadScript.php";

    // XMLHttpRequest object
    var xmlhttp = null;

    // page variables
    var divDisplay = null;

    //var lblFeedback = null;

    // dropdowns
    var drpPatient = null;
    var drpVisit = null;

    // top info
    var lblName = null;
    var lblAge = null;
    var lblVillage = null;

    var lblCase = null;
    var lblWeight = null;
    var lblBP = null;
    var lblTemp = null;

    var lblTriageTest = null;
    var lblTriageMED = null;
    var lblTriageV = null;
    var lblTriageGYN = null;
    var lblTriageOPHT = null;
    var lblTriageDENT = null;

    var lblComplaint = null;
    var btnChart = null;

    // administrated
    var chkParac = null;
    var chkBenz = null;
    var chkCeft = null;

    // Assessment Notes
    var txtAssess = null;

    // pregnancy
    var drpSulfadar = null;

    // STI/PID chart
    var chkSTI = null;
    var chkPID = null;

    var txtPTInit = null;
    var drpPTSex = null;
    var drpPTPreg = null;
    var txtPTMonth = null;
    var drpPTBF = null;
    var txtPTMTZ = null;
    var txtPTDoxy = null;
    var txtPTAmox = null;

    var txtP1Init = null;
    var drpP1Sex = null;
    var drpP1Preg = null;
    var txtP1Month = null;
    var drpP1BF = null;
    var txtP1MTZ = null;
    var txtP1Doxy = null;
    var txtP1Amox = null;

    var txtP2Init = null;
    var drpP2Sex = null;
    var drpP2Preg = null;
    var txtP2Month = null;
    var drpP2BF = null;
    var txtP2MTZ = null;
    var txtP2Doxy = null;
    var txtP2Amox = null;

    var txtP3Init = null;
    var drpP3Sex = null;
    var drpP3Preg = null;
    var txtP3Month = null;
    var drpP3BF = null;
    var txtP3MTZ = null;
    var txtP3Doxy = null;
    var txtP3Amox = null;

    // practitioner
    var drpPract = null;

    // stations
    var drpTriageTest = null;
    var drpTriageMED = null;
    var drpTriageGYN = null;
    var drpTriageOPHT = null;
    var drpTriageDENT = null;
    var drpTriageV = null;

    var btnSubmit = null;

    // construct Spinner object (spin.js) and add to loadingOverlay <div>
    var spinner = new Spinner({ color: '#FFFFFF', lines: 12 }).spin(document.getElementById("loadingOverlay"));

    // inital loading event
    window.addEventListener("load", onInit);

    // ------------------------------------------------------------ start

    function onInit() {
        console.log(">> initializing");

        // loading
        loading();

        // get references
        divDisplay = document.getElementById("divDisplay");

        //lblFeedback = document.getElementById("lblFeedback");

        // dropdowns
        drpPatient = document.getElementById("drpPatient");
        drpVisit = document.getElementById("drpVisit");

        // top info
        lblName = document.getElementById("lblName");
        lblAge = document.getElementById("lblAge");
        lblVillage = document.getElementById("lblVillage");

        lblCase = document.getElementById("lblCase");
        lblWeight = document.getElementById("lblWeight");
        lblBP = document.getElementById("lblBP");
        lblTemp = document.getElementById("lblTemp");

        lblTriageTest = document.getElementById("lblTriageTest");
        lblTriageMED = document.getElementById("lblTriageMED");
        lblTriageV = document.getElementById("lblTriageV");
        lblTriageGYN = document.getElementById("lblTriageGYN");
        lblTriageOPHT = document.getElementById("lblTriageOPHT");
        lblTriageDENT = document.getElementById("lblTriageDENT");

        lblComplaint = document.getElementById("lblComplaint");
        btnChart = document.getElementById("btnChart");

        // administrated
        chkParac = document.getElementById("chkParac");
        chkBenz = document.getElementById("chkBenz");
        chkCeft = document.getElementById("chkCeft");

        // Assessment notes
        txtAssess = document.getElementById("txtAssess");

        // pregnancy
        drpSulfadar = document.getElementById("drpSulfadar");

        // STI/PID chart
        chkSTI = document.getElementById("chkSTI");
        chkPID = document.getElementById("chkPID");

        txtPTInit = document.getElementById("txtPTInit");
        drpPTSex = document.getElementById("drpPTSex");
        drpPTPreg = document.getElementById("drpPTPreg");
        txtPTMonth = document.getElementById("txtPTMonth");
        drpPTBF = document.getElementById("drpPTBF");
        txtPTMTZ = document.getElementById("txtPTMTZ");
        txtPTDoxy = document.getElementById("txtPTDoxy");
        txtPTAmox = document.getElementById("txtPTAmox");

        txtP1Init = document.getElementById("txtP1Init");
        drpP1Sex = document.getElementById("drpP1Sex");
        drpP1Preg = document.getElementById("drpP1Preg");
        txtP1Month = document.getElementById("txtP1Month");
        drpP1BF = document.getElementById("drpP1BF");
        txtP1MTZ = document.getElementById("txtP1MTZ");
        txtP1Doxy = document.getElementById("txtP1Doxy");
        txtP1Amox = document.getElementById("txtP1Amox");

        txtP2Init = document.getElementById("txtP2Init");
        drpP2Sex = document.getElementById("drpP2Sex");
        drpP2Preg = document.getElementById("drpP2Preg");
        txtP2Month = document.getElementById("txtP2Month");
        drpP2BF = document.getElementById("drpP2BF");
        txtP2MTZ = document.getElementById("txtP2MTZ");
        txtP2Doxy = document.getElementById("txtP2Doxy");
        txtP2Amox = document.getElementById("txtP2Amox");

        txtP3Init = document.getElementById("txtP3Init");
        drpP3Sex = document.getElementById("drpP3Sex");
        drpP3Preg = document.getElementById("drpP3Preg");
        txtP3Month = document.getElementById("txtP3Month");
        drpP3BF = document.getElementById("drpP3BF");
        txtP3MTZ = document.getElementById("txtP3MTZ");
        txtP3Doxy = document.getElementById("txtP3Doxy");
        txtP3Amox = document.getElementById("txtP3Amox");

        // practitioner
        drpPract = document.getElementById("drpPract");

        // stations
        // drpTriageTest = document.getElementById("drpTriageTest");
        // drpTriageMED = document.getElementById("drpTriageMED");
        // drpTriageGYN = document.getElementById("drpTriageGYN");
        // drpTriageOPHT = document.getElementById("drpTriageOPHT");
        // drpTriageDENT = document.getElementById("drpTriageDENT");
        // drpTriageV = document.getElementById("drpTriageV");

        btnSubmit = document.getElementById("btnSubmit");

        // clear all
        //clearAll();

        // event listener for changing patients
        drpPatient.addEventListener("change", getPatientStats);

        // event listener for visit information
        drpVisit.addEventListener("change", getThisVisit);

        // event listener for the buttons
        btnChart.addEventListener("click", toChart);
        btnSubmit.addEventListener("click", onSubmit);

        /*
        // feedback from uploading?
        if (lblFeedback.innerHTML !== "") {
            // get the feedback
            feedback(lblFeedback.innerHTML);
        }
        */

        // populate dropdowns
        getPractitioners();
        // dropdowns are done one at a time

        // screen will only be populated if an existing visit is selected

    }

    // ------------------------------------------------------------ private methods

    /*
    function feedback(words) {
        // feedback
        lblFeedback.innerHTML = "<h5>" + words + "</h5>";
        // display for a short time
        $('#lblFeedback').css('display', 'block');
        $('#lblFeedback').delay(4000).fadeOut(1000);
    } */

    function loading() {
        // disable screen by placing the loading overlay on top
        document.getElementById("divDisplay").style.display = "none";
        //document.getElementById("divFooter").style.display = "none";
        document.getElementById("loadingOverlay").style.display = "block";
    }

    function notLoading() {
        // enable screen by removing the loading overlay
        document.getElementById("divDisplay").style.display = "";
        //document.getElementById("divFooter").style.display = "";
        document.getElementById("loadingOverlay").style.display = "none";
        // can not use the shortcut because it doesn't work - no idea why
    }

    function sendJson(json, script, response) {
        // turn object into a string
        var sendString = JSON.stringify(json);

        // send string to the server handler
        xmlhttp = new XMLHttpRequest();

        // which response do we want?
        if (response === "practitioners") {
            xmlhttp.addEventListener("readystatechange", practitionersResponse);
        } else if (response === "patients") {
            xmlhttp.addEventListener("readystatechange", patientsResponse);
        } else if (response === "visits") {
            xmlhttp.addEventListener("readystatechange", visitsResponse);
        } else if (response === "stats") {
            xmlhttp.addEventListener("readystatechange", statsResponse);
        } else if (response === "rx") {
            xmlhttp.addEventListener("readystatechange", rxResponse);
        } else if (response === "submit") {
            xmlhttp.addEventListener("readystatechange", submitResponse);
        }

        xmlhttp.open("POST", script, true);
        // tell the server what you're doing
        xmlhttp.setRequestHeader("Content-type", "application/json");
        // send it
        xmlhttp.send(sendString);
    }

    function clearAll() {
        lblCase.innerHTML = "Case #";

        // drug administration
        chkParac.checked = false;
        chkBenz.checked = false;
        chkCeft.checked = false;

        // assessment
        txtAssess.innerHTML = "";

        // pregnancy
        drpSulfadar.selectedIndex = 0;

        // STI/PID chart
        chkSTI.checked = false;
        chkPID.checked = false;

        txtPTInit.value = "";
        drpPTSex.selectedIndex = 0;
        drpPTPreg.selectedIndex = 0;
        txtPTMonth.value = "";
        drpPTBF.selectedIndex = 0;
        txtPTMTZ.value = "";
        txtPTDoxy.value = "";
        txtPTAmox.value = "";

        txtP1Init.value = "";
        drpP1Sex.selectedIndex = 0;
        drpP1Preg.selectedIndex = 0;
        txtP1Month.value = "";
        drpP1BF.selectedIndex = 0;
        txtP1MTZ.value = "";
        txtP1Doxy.value = "";
        txtP1Amox.value = "";

        txtP2Init.value = "";
        drpP2Sex.selectedIndex = 0;
        drpP2Preg.selectedIndex = 0;
        txtP2Month.value = "";
        drpP2BF.selectedIndex = 0;
        txtP2MTZ.value = "";
        txtP2Doxy.value = "";
        txtP2Amox.value = "";

        txtP3Init.value = "";
        drpP3Sex.selectedIndex = 0;
        drpP3Preg.selectedIndex = 0;
        txtP3Month.value = "";
        drpP3BF.selectedIndex = 0;
        txtP3MTZ.value = "";
        txtP3Doxy.value = "";
        txtP3Amox.value = "";

        // practitioner
        drpPract.selectedIndex = 0;

        // stations
        drpTriageTest.selectedIndex = 0;
        drpTriageMED.selectedIndex = 0;
        drpTriageGYN.selectedIndex = 0;
        drpTriageOPHT.selectedIndex = 0;
        drpTriageDENT.selectedIndex = 0;
        drpTriageV.selectedIndex = 0;
    }

    function toChart() {
        var win = window.open("print.php?id=" + drpVisit[drpVisit.selectedIndex].value, '_blank');
        win.focus();
    }

    // ------------------------------------------------------------ event handlers

    // ---------------------------------------------------------------- data requests

    function getPractitioners() {
        // construct the JSON object to send to the handler
        var sendJSON = {
            "menu": "practitioners"
        };

        // send the json off
        sendJson(sendJSON, dropdownScript, "practitioners");
    }

    function getPatients() {
        // construct the JSON object to send to the handler
        var sendJSON = {
            "menu": "patients"
        };

        // send the json off
        sendJson(sendJSON, dropdownScript, "patients");
    }

    function getPatientStats() {
        // loading
        loading();

        // clear the board
        //clearAll();

        // construct the JSON object to send to the handler
        var sendJSON = {
            "request": "stats",
            "id": drpPatient[drpPatient.selectedIndex].value
        };

        // send the json off
        sendJson(sendJSON, dataScript, "stats");
    }

    function getVisits() {

        // construct the JSON object to send to the handler
        var sendJSON = {
            "menu": "visits",
            "id": drpPatient[drpPatient.selectedIndex].value
        };

        // send the json off
        sendJson(sendJSON, dropdownScript, "visits");
    }

    function getThisVisit() {
        // clear the board
        //clearAll();

        // construct the JSON object to send to the handler
        var sendJSON = {
            "request": "rx",
            "id": drpVisit[drpVisit.selectedIndex].value
        };

        // send the json off
        sendJson(sendJSON, dataScript, "rx");
    }

    // ---------------------------------------------------------------- data transfers

    function onSubmit(e) {

        // loading
        loading();

        // checkboxes
        var parac = "no";
        var benz = "no";
        var ceft = "no";
        if (chkParac.checked) { parac = "yes"; }
        if (chkBenz.checked) { benz = "yes"; }
        if (chkCeft.checked) { ceft = "yes"; }


        var chart = "";
        if (chkSTI.checked) { chart = "sti"; }
        if (chkPID.checked) { chart = "pid"; }



        // construct json object to send to the handler script
        var sendJSON = {
            "upload": "rx",
            //"patientid": drpPatient[drpPatient.selectedIndex].value,
            "visitid": drpVisit[drpVisit.selectedIndex].value,
            // Admin
            "parac": parac,
            "benz": benz,
            "ceft": ceft,

            "assess": txtAssess.value,

            "sulfadar": drpSulfadar[drpSulfadar.selectedIndex].value,

            "chart": chart,
            //sti pid
            "PTInit": txtPTInit.value,
            "PTSex": drpPTSex[drpPTSex.selectedIndex].value,
            "PTPreg": drpPTPreg[drpPTPreg.selectedIndex].value,
            "PTMonth": txtPTMonth.value,
            "PTBF": drpPTBF[drpPTBF.selectedIndex].value,
            "PTMTZ": txtPTMTZ.value,
            "PTDoxy": txtPTDoxy.value,
            "PTAmox": txtPTAmox.value,

            "P1Init": txtP1Init.value,
            "P1Sex": drpP1Sex[drpP1Sex.selectedIndex].value,
            "P1Preg": drpP1Preg[drpP1Preg.selectedIndex].value,
            "P1Month": txtP1Month.value,
            "P1BF": drpP1BF[drpP1BF.selectedIndex].value,
            "P1MTZ": txtP1MTZ.value,
            "P1Doxy": txtP1Doxy.value,
            "P1Amox": txtP1Amox.value,

            "P2Init": txtP2Init.value,
            "P2Sex": drpP2Sex[drpP2Sex.selectedIndex].value,
            "P2Preg": drpP2Preg[drpP2Preg.selectedIndex].value,
            "P2Month": txtP2Month.value,
            "P2BF": drpP2BF[drpP2BF.selectedIndex].value,
            "P2MTZ": txtP2MTZ.value,
            "P2Doxy": txtP2Doxy.value,
            "P2Amox": txtP2Amox.value,

            "P3Init": txtP3Init.value,
            "P3Sex": drpP3Sex[drpP3Sex.selectedIndex].value,
            "P3Preg": drpP3Preg[drpP3Preg.selectedIndex].value,
            "P3Month": txtP3Month.value,
            "P3BF": drpP3BF[drpP3BF.selectedIndex].value,
            "P3MTZ": txtP3MTZ.value,
            "P3Doxy": txtP3Doxy.value,
            "P3Amox": txtP3Amox.value,

            "pract": drpPract[drpPract.selectedIndex].value,

            "RxQty": numRx.value,
        };

        console.log(sendJSON);

        // send the json off
        sendJson(sendJSON, uploadScript, "submit");
    }

    // ---------------------------------------------------------------- data response

    function practitionersResponse(e) {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", practitionersResponse);

            // get the json data received
            var response = JSON.parse(xmlhttp.responseText);

            // clear the dropdown
            drpPract.innerHTML = "";

            // how many entries are in the JSON?
            var entryCount = response.entries.length;

            // do we have entries to display?
            if (entryCount > 0) {

                // first entry into the list is for a blank entry option
                var first = new Option();
                first.id = 0;
                first.text = "None Selected";
                first.value = 0;

                // add element as an option
                $(drpPract).append(first);

                // populate the dropdown menu
                for (var i = 0; i < entryCount; i++) {

                    // build the option element and add properties
                    var option = new Option();
                    option.id = i + 1;
                    option.text = response.entries[i].title + " " + response.entries[i].fname + " " + response.entries[i].lname;
                    option.value = response.entries[i].id;

                    // add element to dropdown
                    $(drpPract).append(option);
                }

            } else {
                // no data to display

                // build an empty option element and add properties
                var option = new Option();
                option.id = 0;
                option.text = "No Practitioners";
                option.value = 0;

                // add element to dropdown
                $(drpPract).append(option);

                /*
                // failure or no entries?
                if (response.success) {
                    // feedback
                    feedback("No entries in the database");
                } else {
                    feedback(response.reason);
                }
                */
            }

            // set sponsor data for first entry
            drpPract.selectedIndex = 0;

            // move onto the next list
            getPatients();

        }
    }

    function patientsResponse(e) {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", patientsResponse);

            // get the json data received
            var response = JSON.parse(xmlhttp.responseText);

            // clear the dropdown
            drpPatient.innerHTML = "";

            // how many entries are in the JSON?
            var entryCount = response.entries.length;

            // do we have entries to display?
            if (entryCount > 0) {

                // populate the dropdown menu
                for (var i = 0; i < entryCount; i++) {

                    // build the option element and add properties
                    var option = new Option();
                    option.id = i;
                    option.text = response.entries[i].name;
                    option.value = response.entries[i].id;

                    // add element to dropdown
                    $(drpPatient).append(option);
                }

                // set sponsor data for first entry
                drpPatient.selectedIndex = 0;

                // load stats (then visits)
                getPatientStats();

            } else {
                // no data to display

                // build an empty option element and add properties
                var option = new Option();
                option.id = 0;
                option.text = "No Patients";
                option.value = 0;

                // add element to dropdown
                $(drpPatient).append(option);

                // set sponsor data for first entry
                drpPatient.selectedIndex = 0;

                // not loading 
                notLoading();

                /*
                // failure or no entries?
                if (response.success) {
                    // feedback
                    feedback("No entries in the database");
                } else {
                    feedback(response.reason);
                }
                */
            }

        }
    }

    function statsResponse(e) {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", statsResponse);

            // get the json data received
            var response = JSON.parse(xmlhttp.responseText);

            if (response.success) {
                // populate the data
                // dispensary
                lblName.innerHTML = "Full Name: " + response.entries[0].name;
                lblAge.innerHTML = "Age: " + response.entries[0].age;
                lblVillage.innerHTML = "Village: " + response.entries[0].village;

            } else {

                // bad feedback
                //feedback(response.reason);
            }
            console.log("stats response");
            // move onto visits
            getVisits();

        }
    }

    function visitsResponse(e) {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", visitsResponse);

            // get the json data received
            var response = JSON.parse(xmlhttp.responseText);

            console.log("visits response");

            // clear the dropdown
            drpVisit.innerHTML = "";

            // how many entries are in the JSON?
            var entryCount = response.entries.length;

            // do we have entries to display?
            if (entryCount > 0) {

                // populate the dropdown menu
                for (var i = 0; i < entryCount; i++) {

                    // build the option element and add properties
                    var option = new Option();
                    option.id = i;
                    var temp = i + 1
                    option.text = "Visit #" + temp;
                    option.value = response.entries[i];

                    // add element to dropdown
                    $(drpVisit).append(option);
                }

            } else {
                // no data to display
            }

            // set sponsor data for first entry
            drpVisit.selectedIndex = 0;

            // load the first visit selected
            //getThisVisit();
            notLoading();

            /*
            // failure or no entries?
            if (response.success) {
                // feedback
                //feedback("No entries in the database");
            } else {
                //feedback(response.reason);
            }
            */

        }
    }

    function rxResponse() {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", rxResponse);

            // get the json data received
            var response = JSON.parse(xmlhttp.responseText);

            if (response.success) {
                // populate the data

                //console.log(response);

                // top stuff
                lblCase.innerHTML = "Case #" + drpVisit[drpVisit.selectedIndex].value;
                lblWeight.innerHTML = "Weight (Kg): " + response.entries[0].weight;
                lblBP.innerHTML = "BP: " + response.entries[0].bp;
                lblTemp.innerHTML = "Temp (&#8451;): " + response.entries[0].temp;

                lblTriageTest.innerHTML = response.entries[0].test;
                lblTriageMED.innerHTML = response.entries[0].med;
                lblTriageV.innerHTML = response.entries[0].stationv;
                lblTriageGYN.innerHTML = response.entries[0].gyn;
                lblTriageOPHT.innerHTML = response.entries[0].opht;
                lblTriageDENT.innerHTML = response.entries[0].dent;

                lblComplaint.innerHTML = response.entries[0].complaint;


                // admin section
                if (response.entries[0].parac === "yes") { chkParac.checked = true; } else { chkParac.checked = false; }
                if (response.entries[0].benz === "yes") { chkBenz.checked = true; } else { chkBenz.checked = false; }
                if (response.entries[0].ceft === "yes") { chkCeft.checked = true; } else { chkCeft.checked = false; }

                // assessment notes
                txtAssess.innerHTML = response.entries[0].assess;

                // pregnancy
                for (n = 0; n < drpSulfadar.length; n++) {
                    if (drpSulfadar[n].value === response.entries[0].sulfadar) {
                        drpSulfadar.selectedIndex = n;
                        break;
                    }
                }

                // STI/PID info
                if (response.entries[0].chart === "sti") { chkSTI.checked = true; } else { chkSTI.checked = false; }
                if (response.entries[0].chart === "pid") { chkPID.checked = true; } else { chkPID.checked = false; }

                txtPTInit.value = response.entries[0].ptinit;
                for (n = 0; n < drpPTSex.length; n++) {
                    if (drpPTSex[n].value === response.entries[0].ptsex) {
                        drpPTSex.selectedIndex = n;
                        break;
                    }
                }
                for (n = 0; n < drpPTPreg.length; n++) {
                    if (drpPTPreg[n].value === response.entries[0].ptpreg) {
                        drpPTPreg.selectedIndex = n;
                        break;
                    }
                }
                txtPTMonth.value = response.entries[0].ptmonth;
                for (n = 0; n < drpPTBF.length; n++) {
                    if (drpPTBF[n].value === response.entries[0].ptbf) {
                        drpPTBF.selectedIndex = n;
                        break;
                    }
                }
                txtPTMTZ.value = response.entries[0].ptmtz;
                txtPTDoxy.value = response.entries[0].ptdoxy;
                txtPTAmox.value = response.entries[0].ptamox;

                txtP1Init.value = response.entries[0].p1init;
                for (n = 0; n < drpP1Sex.length; n++) {
                    if (drpP1Sex[n].value === response.entries[0].p1sex) {
                        drpP1Sex.selectedIndex = n;
                        break;
                    }
                }
                for (n = 0; n < drpP1Preg.length; n++) {
                    if (drpP1Preg[n].value === response.entries[0].p1preg) {
                        drpP1Preg.selectedIndex = n;
                        break;
                    }
                }
                txtP1Month.value = response.entries[0].p1month;
                for (n = 0; n < drpP1BF.length; n++) {
                    if (drpP1BF[n].value === response.entries[0].p1bf) {
                        drpP1BF.selectedIndex = n;
                        break;
                    }
                }
                txtP1MTZ.value = response.entries[0].p1mtz;
                txtP1Doxy.value = response.entries[0].p1doxy;
                txtP1Amox.value = response.entries[0].p1amox;

                txtP2Init.value = response.entries[0].p2init;
                for (n = 0; n < drpP2Sex.length; n++) {
                    if (drpP2Sex[n].value === response.entries[0].p2sex) {
                        drpP2Sex.selectedIndex = n;
                        break;
                    }
                }
                for (n = 0; n < drpP2Preg.length; n++) {
                    if (drpP2Preg[n].value === response.entries[0].p2preg) {
                        drpP2Preg.selectedIndex = n;
                        break;
                    }
                }
                txtP2Month.value = response.entries[0].p2month;
                for (n = 0; n < drpP2BF.length; n++) {
                    if (drpP2BF[n].value === response.entries[0].p2bf) {
                        drpP2BF.selectedIndex = n;
                        break;
                    }
                }
                txtP2MTZ.value = response.entries[0].p2mtz;
                txtP2Doxy.value = response.entries[0].p2doxy;
                txtP2Amox.value = response.entries[0].p2amox;

                txtP3Init.value = response.entries[0].p3init;
                for (n = 0; n < drpP3Sex.length; n++) {
                    if (drpP3Sex[n].value === response.entries[0].p3sex) {
                        drpP3Sex.selectedIndex = n;
                        break;
                    }
                }
                for (n = 0; n < drpP3Preg.length; n++) {
                    if (drpP3Preg[n].value === response.entries[0].p3preg) {
                        drpP3Preg.selectedIndex = n;
                        break;
                    }
                }
                txtP3Month.value = response.entries[0].p3month;
                for (n = 0; n < drpP3BF.length; n++) {
                    if (drpP3BF[n].value === response.entries[0].p3bf) {
                        drpP3BF.selectedIndex = n;
                        break;
                    }
                }
                txtP3MTZ.value = response.entries[0].p3mtz;
                txtP3Doxy.value = response.entries[0].p3doxy;
                txtP3Amox.value = response.entries[0].p3amox;

                // practitioner
                for (n = 0; n < drpPract.length; n++) {
                    if (drpPract[n].value === response.entries[0].pract) {
                        drpPract.selectedIndex = n;
                        break;
                    }
                }

            } else {


                // bad feedback
                //feedback(response.reason);
            }

            // not loading
            notLoading();

        }
    }

    function submitResponse() {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", statsResponse);

            // get the json data received
            var response = JSON.parse(xmlhttp.responseText);

            if (response.success) {
                // update the dropdown
                getVisits();

                // place the visit on the current visit
                drpVisit.selectedIndex[drpVisit.length];

            } else {

                // bad feedback
                //feedback(response.reason);
            }

            // not loading
            notLoading();

        }
    }

})();