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
    
    // notes
    var txtAssess = null;

    // practitioner
    var drpPract = null;

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

        // notes
        txtAssess = document.getElementById("txtAssess");

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
        clearAll();

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
        if (response === "practitioners") {
            xmlhttp.addEventListener("readystatechange", practitionersResponse);
        } else if (response === "msk") {
            xmlhttp.addEventListener("readystatechange", mskResponse);
        } else if (response === "asthma") {
            xmlhttp.addEventListener("readystatechange", asthmaResponse);
        } else if (response === "patients") {
            xmlhttp.addEventListener("readystatechange", patientsResponse);
        } else if (response === "visits") {
            xmlhttp.addEventListener("readystatechange", visitsResponse);
        } else if (response === "stats") {
            xmlhttp.addEventListener("readystatechange", statsResponse);
        } else if (response === "dent") {
            xmlhttp.addEventListener("readystatechange", dentResponse);
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

        // top stuff
        lblCase.innerHTML = "Case #:";
        lblWeight.innerHTML = "Weight (Kg):";
        lblBP.innerHTML = "";
        lblTemp.innerHTML = "Temp (&#8451;):";

        // notes
        txtAssess.innerHTML = "";

        // practitioner
        drpPract.selectedIndex = 0;

        // stations
        //drpTriageTest.selectedIndex = 0;
        //drpTriageMED.selectedIndex = 0;
        //drpTriageGYN.selectedIndex = 0;
        //drpTriageOPHT.selectedIndex = 0;
        //drpTriageDENT.selectedIndex = 0;
        //drpTriageV.selectedIndex = 0;
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
        clearAll();

        // construct the JSON object to send to the handler
        var sendJSON = {
            "request": "dent",
            "id": drpVisit[drpVisit.selectedIndex].value
        };

        // send the json off
        sendJson(sendJSON, dataScript, "dent");
    }

    // ---------------------------------------------------------------- data transfers

    function onSubmit(e) {

        // loading
        loading();

        // construct json object to send to the handler script
        var sendJSON = {
            "upload": "dent",
            //"patientid": drpPatient[drpPatient.selectedIndex].value,
            "visitid": drpVisit[drpVisit.selectedIndex].value,
            
            // notes
            "assess": txtAssess.value,

            // practitioner
            "pract": drpPract[drpPract.selectedIndex].value,

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
                if (response.success) {option.text = "No Practitioners";} else {option.text = "Failed";}
                option.value = 0;

                // add element to dropdown
                $(drpPract).append(option1);

                /*
                // disable if failed
                if (!response.success) {drpPract.disabled = true;}
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
                // blank
            }

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
                    option.text = "Case #" + response.entries[i];
                    option.value = response.entries[i];

                    // add element to dropdown
                    $(drpVisit).append(option);
                }

                // set sponsor data for first entry
                drpVisit.selectedIndex = 0;

                // load the first visit selected
                getThisVisit();

            } else {
                // failure or no entries?
                if (!response.success) {
                    // feedback
                    feedback("Cases failed to load <br/>" + response.reason);
                }

                // not loading
                notLoading();
            }

        }
    }

    function dentResponse() {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", dentResponse);

            // get the json data received
            var response = JSON.parse(xmlhttp.responseText);

            if (response.success) {
                // populate the data

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

                // notes
                txtAssess.innerHTML = response.entries[0].assess;

                // practitioner
                for (var n = 0; n < drpPract.length; n++) {
                    if (drpPract[n].value === response.entries[0].pract) {
                        drpPract.selectedIndex = n;
                        break;
                    }
                }

            } else {
                // bad feedback
                feedback("Dental data did not load properly <br/>" + response.reason);
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
                // refresh all
                getThisVisit();
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