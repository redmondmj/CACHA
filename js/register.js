(function () {
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
    
    var chkPreg = null;
    var chkBreast = null;

    var txtLive = null;
    var txtGrav = null;
    var txtPara = null;
    var txtAbort = null;
    var txtLNMP = null;

    var txtComplaint = null;

    var chkTest = null;
    var chkMED1 = null;
    var chkMED2 = null;
    var chkGYN = null;
    var chkOPHT = null;
    var chkDENT = null;
    var chkTriageV = null;

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
        
        chkPreg = document.getElementById("chkPreg");
        chkBreast = document.getElementById("chkBreast");
    
        txtLive = document.getElementById("txtLive");
        txtGrav = document.getElementById("txtGrav");
        txtPara = document.getElementById("txtPara");
        txtAbort = document.getElementById("txtAbort");
        txtLNMP = document.getElementById("txtLNMP");
    
        txtComplaint = document.getElementById("txtComplaint");
    
        chkTest = document.getElementById("chkTest");
        chkMED1 = document.getElementById("chkMED1");
        chkMED2 = document.getElementById("chkMED2");
        chkGYN = document.getElementById("chkGYN");
        chkOPHT = document.getElementById("chkOPHT");
        chkDENT = document.getElementById("chkDENT");
        chkTriageV = document.getElementById("chkTriageV");
    
        btnSubmit = document.getElementById("btnSubmit");

        // clear all
        clearAll();

        // event listener for changing patients
        drpPatient.addEventListener("change", getPatientStats);

        // event listener for visit information
        drpVisit.addEventListener("change", getThisVisit);

        // event listener for the button
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

        chkPreg.checked = false;
        chkBreast.checked = false;

        txtLive.value = "";
        txtGrav.value = "";
        txtPara.value = "";
        txtAbort.value = "";
        txtLNMP.value = "";

        txtComplaint.innerHTML = "";

        // stations
        chkTest.checked = false;
        chkMED1.checked = false;
        chkMED2.checked = false;
        chkGYN.checked = false;
        chkOPHT.checked = false;
        chkDENT.checked = false;
        chkTriageV.checked = false;
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
        // check for new entry
        if (drpVisit.selectedIndex === 0) {
            // clear the board
            clearAll();

        } else {

            // construct the JSON object to send to the handler
            var sendJSON = {
                "request": "basic",
                "id": drpVisit[drpVisit.selectedIndex].value
            };

            // send the json off
            sendJson(sendJSON, dataScript, "basic");

        }
    }

    // ---------------------------------------------------------------- data transfers

    function onSubmit(e) {

        // loading
        loading();
        
        // checkboxes
        var preg = "no";
        var breast = "no";
        if (chkPreg.checked) {
            preg = "yes";
        }
        if (chkBreast.checked) {
            breast = "yes";
        }

        // stations
        var test = "no";
        var med1 = "no";
        var med2 = "no";
        var gyn = "no";
        var opht = "no";
        var dent = "no";
        var triagev = "no";
        if (chkTest.checked) {
            test = "yes";
        }
        if (chkMED1.checked) {
            med1 = "yes";
        }
        if (chkMED2.checked) {
            med2 = "yes";
        }
        if (chkGYN.checked) {
            gyn = "yes";
        }
        if (chkOPHT.checked) {
            opht = "yes";
        }
        if (chkDENT.checked) {
            dent = "yes";
        }
        if (chkTriageV.checked) {
            triagev = "yes";
        }
        // construct json object to send to the handler script
        var sendJSON = {
            "upload": "basic",
            "patientid": drpPatient[drpPatient.selectedIndex].value,
            "dispensary": drpDispensary[drpDispensary.selectedIndex].value,
            "weight": txtWeight.value.replace(/[^0-9\.-]+/g,""),
            "temp": txtTemp.value.replace(/[^0-9\.-]+/g,""),
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
            "test": test,
            "med1": med1,
            "med2": med2,
            "gyn": gyn,
            "opht": opht,
            "dent": dent,
            "triagev": triagev
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
                    drpDispensary.append(option);
                }

                // set sponsor data for first entry
                drpDispensary.selectedIndex = 0;

            } else {
                // no data to display

                // build an empty option element and add properties
                var option = new Option();
                option.id = 0;
                option.text = "Empty";
                option.value = 0;

                // add element to dropdown
                drpDispensary.append(option);

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
                    drpPatient.append(option);
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
                drpPatient.append(option);

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
            first.text = "New Visit";
            first.value = 0;

            // add element to as a new option
            drpVisit.append(first);

            // do we have entries to display?
            if (entryCount > 0) {

                // populate the dropdown menu
                for (var i = 0; i < entryCount; i++) {

                    // build the option element and add properties
                    var option = new Option();
                    option.id = i + 1;
                    option.text = "Visit #" + option.id;
                    option.value = response.entries[i];

                    // add element to dropdown
                    drpVisit.append(option);
                }

            } else {
                // no data to display
            }

            // set sponsor data for first entry
            drpVisit.selectedIndex = 0;

            // loading check
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
            
            // move onto visits
            getVisits();
            
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

                console.log(response);

                lblCase.innerHTML = "Case #" + drpVisit[drpVisit.selectedIndex].value;

                // run through the dispensary list until we find a match
                for (var n=0;n < drpDispensary.length;n++) {
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
                if (response.entries[0].pregnant === "yes") {chkPreg.checked = true} else {chkPreg.checked = false}
                if (response.entries[0].breast === "yes") {chkBreast.checked = true} else {chkBreast.checked = false}

                txtLive.value = response.entries[0].living;
                txtGrav.value = response.entries[0].grav;
                txtPara.value = response.entries[0].para;
                txtAbort.value = response.entries[0].abortus;
                txtLNMP.value = response.entries[0].period;

                txtComplaint.innerHTML = response.entries[0].complaint;

                // stations
                if (response.entries[0].test === "yes") {chkTest.checked = true} else {chkTest.checked = false}
                if (response.entries[0].med1 === "yes") {chkMED1.checked = true} else {chkMED1.checked = false}
                if (response.entries[0].med2 === "yes") {chkMED2.checked = true} else {chkMED2.checked = false}
                if (response.entries[0].gyn === "yes") {chkGYN.checked = true} else {chkGYN.checked = false}
                if (response.entries[0].opht === "yes") {chkOPHT.checked = true} else {chkOPHT.checked = false}
                if (response.entries[0].dent === "yes") {chkDENT.checked = true} else {chkDENT.checked = false}
                if (response.entries[0].stationv === "yes") {chkTriageV.checked = true} else {chkTriageV.checked = false}

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