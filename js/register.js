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

    var lblFeedback = null;

    var drpPatient = null;
    var drpVisit = null;

    var lblName = null;
    var lblAge = null;
    var lblVillage = null;
    var lblCase = null;

    var drpDispensary = null;

    var txtWeight = null;
    var txtTemp = null;
    var txtBPTop = null;
    var txtBPBottom = null;
    var txtHR = null;
    var txtGlucose = null;

    var rdoPregYes = null;
    var rdoPregNo = null;
    var rdoBreastYes = null;
    var rdoBreastNo = null;

    var txtLive = null;
    var txtGrav = null;
    var txtPara = null;
    var txtAbort = null;
    var txtLNMP = null;

    var txtComplaint = null;

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

        lblFeedback = document.getElementById("lblFeedback");

        drpPatient = document.getElementById("drpPatient");
        drpVisit = document.getElementById("drpVisit");

        lblName = document.getElementById("lblName");
        lblAge = document.getElementById("lblAge");
        lblVillage = document.getElementById("lblVillage");
        lblCase = document.getElementById("lblCase");

        drpDispensary = document.getElementById("drpDispensary");

        txtWeight = document.getElementById("txtWeight");
        txtTemp = document.getElementById("txtTemp");
        txtBPTop = document.getElementById("txtBPTop");
        txtBPBottom = document.getElementById("txtBPBottom");
        txtHR = document.getElementById("txtHR");
        txtGlucose = document.getElementById("txtGlucose");

        rdoPregYes = document.getElementById("rdoPregYes");
        rdoPregNo = document.getElementById("rdoPregNo");
        rdoBreastYes = document.getElementById("rdoBreastYes");
        rdoBreastNo = document.getElementById("rdoBreastNo");

        txtLive = document.getElementById("txtLive");
        txtGrav = document.getElementById("txtGrav");
        txtPara = document.getElementById("txtPara");
        txtAbort = document.getElementById("txtAbort");
        txtLNMP = document.getElementById("txtLNMP");

        txtComplaint = document.getElementById("txtComplaint");

        drpTriageTest = document.getElementById("drpTriageTest");
        drpTriageMED = document.getElementById("drpTriageMED");
        drpTriageGYN = document.getElementById("drpTriageGYN");
        drpTriageOPHT = document.getElementById("drpTriageOPHT");
        drpTriageDENT = document.getElementById("drpTriageDENT");
        drpTriageV = document.getElementById("drpTriageV");


        btnSubmit = document.getElementById("btnSubmit");

        // clear all
        clearAll();

        // event listener for changing patients
        drpPatient.addEventListener("change", getPatientStats);

        // event listener for visit information
        drpVisit.addEventListener("change", getThisVisit);

        // event listener for the button
        btnPrintReg.addEventListener("click", toPrintReg);
        btnSubmit.addEventListener("click", onSubmit);

        /*
        // feedback from uploading?
        if (lblFeedback.innerHTML !== "") {
            // get the feedback
            feedback(lblFeedback.innerHTML);
        }
        */

        // populate dropdowns
        getDispensaries();
        // dropdowns are done one at a time

        // screen will only be populated if an existing visit is selected

    }

    // ------------------------------------------------------------ private methods

    
    function feedback(words) {
        // feedback
        lblFeedback.innerHTML = "<h5>" + words + "</h5>";
        // display for a short time
        $('#lblFeedback').css('display', 'block');
        $('#lblFeedback').delay(4000).fadeOut(1000);
    }

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
        if (response === "dispensaries") {
            xmlhttp.addEventListener("readystatechange", dispensariesResponse);
        } else if (response === "patients") {
            xmlhttp.addEventListener("readystatechange", patientsResponse);
        } else if (response === "visits") {
            xmlhttp.addEventListener("readystatechange", visitsResponse);
        } else if (response === "stats") {
            xmlhttp.addEventListener("readystatechange", statsResponse);
        } else if (response === "basic") {
            xmlhttp.addEventListener("readystatechange", basicResponse);
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

        drpDispensary.selectedIndex = 0;
        txtWeight.value = "";
        txtTemp.value = "";
        txtBPTop.value = "";
        txtBPBottom.value = "";
        txtHR.value = "";
        txtGlucose.value = "";

        rdoPregYes.checked = false;
        rdoPregNo.checked = false;
        rdoBreastYes.checked = false;
        rdoBreastNo.checked = false;

        txtLive.value = "";
        txtGrav.value = "";
        txtPara.value = "";
        txtAbort.value = "";
        txtLNMP.value = "";

        txtComplaint.innerHTML = "";

        // stations
        drpTriageTest.selectedIndex = 0;
        drpTriageMED.selectedIndex = 0;
        drpTriageGYN.selectedIndex = 0;
        drpTriageOPHT.selectedIndex = 0;
        drpTriageDENT.selectedIndex = 0;
        drpTriageV.selectedIndex = 0;

    }

    // ------------------------------------------------------------ event handlers

    // ---------------------------------------------------------------- data requests

    function getDispensaries() {
        // construct the JSON object to send to the handler
        var sendJSON = {
            "menu": "dispensaries"
        };

        // send the json off
        sendJson(sendJSON, dropdownScript, "dispensaries");
    }

    function getPatients() {
        // construct the JSON object to send to the handler
        var sendJSON = {
            "menu": "newpatients"
        };

        // send the json off
        sendJson(sendJSON, dropdownScript, "patients");
    }

    function getPatientStats() {
        // loading
        loading();

        // clear the board
        clearAll();

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
        clearAll();

        // check for new entry
        if (drpVisit.selectedIndex !== 0) {

            // construct the JSON object to send to the handler
            var sendJSON = {
                "request": "basic",
                "id": drpVisit[drpVisit.selectedIndex].value
            };

            // send the json off
            sendJson(sendJSON, dataScript, "basic");

        }
    }

    function toPrintReg() {
        var win = window.open("printRegistration.php?id=" + drpVisit[drpVisit.selectedIndex].value, '_blank');
        win.focus();
    }

    // ---------------------------------------------------------------- data transfers

    function onSubmit(e) {

        // loading
        loading();

        // checkboxes
        var preg = "no";
        var breast = "no";
        if (rdoPregYes.checked) {
            preg = "yes";
        }
        if (rdoBreastYes.checked) {
            breast = "yes";
        }

        // construct json object to send to the handler script
        var sendJSON = {
            "upload": "basic",
            "patientid": drpPatient[drpPatient.selectedIndex].value,
            "dispensary": drpDispensary[drpDispensary.selectedIndex].value,
            "weight": txtWeight.value.replace(/[^0-9\.-]+/g, ""),
            "temp": txtTemp.value.replace(/[^0-9\.-]+/g, ""),
            "BPTop": txtBPTop.value,
            "BPBottom": txtBPBottom.value,
            "heart": txtHR.value,
            "glucose": txtGlucose.value,
            "pregnant": preg,
            "breast": breast,
            "living": txtLive.value,
            "grav": txtGrav.value,
            "para": txtPara.value,
            "abortus": txtAbort.value,
            "period": txtLNMP.value,
            "complaint": txtComplaint.value,
            "test": drpTriageTest[drpTriageTest.selectedIndex].value,
            "med": drpTriageMED[drpTriageMED.selectedIndex].value,
            "gyn": drpTriageGYN[drpTriageGYN.selectedIndex].value,
            "opht": drpTriageOPHT[drpTriageOPHT.selectedIndex].value,
            "dent": drpTriageDENT[drpTriageDENT.selectedIndex].value,
            "triagev": drpTriageV[drpTriageV.selectedIndex].value
        };

        console.log(sendJSON);

        // send the json off
        sendJson(sendJSON, uploadScript, "submit");
    }

    // ---------------------------------------------------------------- data response

    function dispensariesResponse(e) {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", dispensariesResponse);

            // get the json data received
            var response = JSON.parse(xmlhttp.responseText);

            // clear the dropdown
            drpDispensary.innerHTML = "";

            // how many entries are in the JSON?
            var entryCount = response.entries.length;

            // do we have entries to display?
            if (entryCount > 0) {

                // populate the dropdown menu
                for (var i = 0; i < entryCount; i++) {

                    // build the option element and add properties
                    var option = new Option();
                    option.id = i;
                    option.text = response.entries[i];
                    option.value = response.entries[i];

                    // add element to dropdown
                    $(drpDispensary).append(option);
                }

                // set sponsor data for first entry
                drpDispensary.selectedIndex = 0;

            } else {
                // no data to display
                // build an empty option element and add properties
                var option = new Option();
                option.id = 0;
                // failure or no entries?
                if (response.success) {option.text = "No Dispensaries";} else {option.text = "Failed";}
                option.value = 0;

                // add element to dropdown
                $(drpDispensary).append(option);

                // set sponsor data for first entry
                drpDispensary.selectedIndex = 0;
            }

            // move onto patients
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
                // build an empty option element and add properties
                var option = new Option();
                option.id = 0;
                // failure or no entries?
                if (response.success) {option.text = "No Patients";} else {option.text = "Failed";}
                option.value = 0;

                // add element to dropdown
                $(drpPatient).append(option);

                // set sponsor data for first entry
                drpPatient.selectedIndex = 0;

                // not loading 
                notLoading();
            }

        }
    }

    function visitsResponse(e) {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", visitsResponse);

            // get the json data received
            var response = JSON.parse(xmlhttp.responseText);

            // clear the dropdown
            drpVisit.innerHTML = "";

            // how many entries are in the JSON?
            var entryCount = response.entries.length;

            // first entry into the list is for a new entry option
            var first = new Option();
            first.id = 0;
            first.text = "New Case";
            first.value = 0;

            // add element to as a new option
            $(drpVisit).append(first);

            // do we have entries to display?
            if (entryCount > 0) {

                // populate the dropdown menu
                for (var i = 0; i < entryCount; i++) {

                    // build the option element and add properties
                    var option = new Option();
                    option.id = i + 1;
                    option.text = "Case #" + response.entries[i];
                    option.value = response.entries[i];

                    // add element to dropdown
                    $(drpVisit).append(option);
                }

            } else {
                // no data to display
                // build an empty option element and add properties
                var option = new Option();
                option.id = 0;
                // failure or no entries?
                if (response.success) {option.text = "No Cases";} else {option.text = "Failed";}
                option.value = 0;

                // add element to dropdown
                $(drpVisit).append(option);
            }

            // set sponsor data for first entry
            drpVisit.selectedIndex = 0;

            // loading check
            notLoading();

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

                // move onto visits
                getVisits();
            } else {
                // it'll just be blank 
            }

        }
    }

    function basicResponse() {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", statsResponse);

            // get the json data received
            var response = JSON.parse(xmlhttp.responseText);

            if (response.success) {
                // populate the data

                lblCase.innerHTML = "Case #" + drpVisit[drpVisit.selectedIndex].value;

                // run through the dispensary list until we find a match
                for (var n = 0; n < drpDispensary.length; n++) {
                    if (drpDispensary[n].value === response.entries[0].dispensary) {
                        drpDispensary.selectedIndex = n;
                        break;
                    }
                }

                txtWeight.value = response.entries[0].weight;
                txtTemp.value = response.entries[0].temp;
                txtBPTop.value = response.entries[0].BPTop;
                txtBPBottom.value = response.entries[0].BPBottom;
                txtHR.value = response.entries[0].heart;
                txtGlucose.value = response.entries[0].glucose;

                // checkboxes
                if (response.entries[0].pregnant === "yes") {
                    rdoPregYes.checked = true;
                    rdoPregNo.checked = false;
                } else {
                    rdoPregYes.checked = false;
                    rdoPregNo.checked = false;
                }
                if (response.entries[0].breast === "yes") {
                    rdoBreastYes.checked = true;
                    rdoBreastNo.checked = false;
                } else {
                    rdoBreastYes.checked = false;
                    rdoBreastNo.checked = false;
                }

                txtLive.value = response.entries[0].living;
                txtGrav.value = response.entries[0].grav;
                txtPara.value = response.entries[0].para;
                txtAbort.value = response.entries[0].abortus;
                txtLNMP.value = response.entries[0].period;

                txtComplaint.innerHTML = response.entries[0].complaint;

                // stations
                for (n = 0; n < drpTriageTest.length; n++) {
                    if (drpTriageTest[n].value === response.entries[0].test) {
                        drpTriageTest.selectedIndex = n;
                        break;
                    }
                }
                for (n = 0; n < drpTriageMED.length; n++) {
                    if (drpTriageMED[n].value === response.entries[0].med) {
                        drpTriageMED.selectedIndex = n;
                        break;
                    }
                }
                for (n = 0; n < drpTriageGYN.length; n++) {
                    if (drpTriageGYN[n].value === response.entries[0].gyn) {
                        drpTriageGYN.selectedIndex = n;
                        break;
                    }
                }
                for (n = 0; n < drpTriageOPHT.length; n++) {
                    if (drpTriageOPHT[n].value === response.entries[0].opht) {
                        drpTriageOPHT.selectedIndex = n;
                        break;
                    }
                }
                for (n = 0; n < drpTriageDENT.length; n++) {
                    if (drpTriageDENT[n].value === response.entries[0].dent) {
                        drpTriageDENT.selectedIndex = n;
                        break;
                    }
                }
                for (n = 0; n < drpTriageV.length; n++) {
                    if (drpTriageV[n].value === response.entries[0].stationv) {
                        drpTriageV.selectedIndex = n;
                        break;
                    }
                }

            } else {
                // bad feedback
                feedback("The basic information did not load properly <br/>" + response.reason);
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

                // feedback
                feedback("Submit Successful <br/>");
            } else {
                // bad feedback
                feedback("Submit Failed <br/>" + response.reason);
            }

            // not loading
            notLoading();

        }
    }

})();