(function () {
    "use strict";

    // retrieve data
    var dropdownScript = "dropdownScript.php";
    var dataScript = "dataScript.php";

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
    
        var btnSubmit = null;

        btnSubmit = document.getElementById("btnSubmit");

        // event listener for changing patients
        drpPatient.addEventListener("change", getVisits);

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

    // ------------------------------------------------------------ event handlers

    // ---------------------------------------------------------------- data requests

    function getDispensaries() {
        // construct the JSON object to send to the handler
        var sendJSON = {
            "menu": "dispensaries"
        };

        // turn object into a string
        var sendString = JSON.stringify(sendJSON);

        // send string to the server handler
        xmlhttp = new XMLHttpRequest();
        xmlhttp.addEventListener("readystatechange", dispensariesResponse);
        xmlhttp.open("POST", dropdownScript, true);
        // tell the server what you're doing
        xmlhttp.setRequestHeader("Content-type", "application/json");
        // send it
        xmlhttp.send(sendString);
    }

    function getPatients() {
        // construct the JSON object to send to the handler
        var sendJSON = {
            "menu": "patients"
        };

        // turn object into a string
        var sendString = JSON.stringify(sendJSON);

        // send string to the server handler
        xmlhttp = new XMLHttpRequest();
        xmlhttp.addEventListener("readystatechange", patientResponse);
        xmlhttp.open("POST", dropdownScript, true);
        // tell the server what you're doing
        xmlhttp.setRequestHeader("Content-type", "application/json");
        // send it
        xmlhttp.send(sendString);
    }
    
    function getVisits() {

        // loading
        loading();

        // construct the JSON object to send to the handler
        var sendJSON = {
            "menu": "visits",
            "id": drpPatient[drpPatient.selectedIndex].value
        };

        // turn object into a string
        var sendString = JSON.stringify(sendJSON);

        // send string to the server handler
        xmlhttp = new XMLHttpRequest();
        xmlhttp.addEventListener("readystatechange", visitsResponse);
        xmlhttp.open("POST", dropdownScript, true);
        // tell the server what you're doing
        xmlhttp.setRequestHeader("Content-type", "application/json");
        // send it
        xmlhttp.send(sendString);
    }

    function getStats() {
        // loading
        loading();
        
        // construct the JSON object to send to the handler
        var sendJSON = {
            "request": "stats",
            "id": drpPatient[drpPatient.selectedIndex].value
        };

        // turn object into a string
        var sendString = JSON.stringify(sendJSON);

        // send string to the server handler
        xmlhttp = new XMLHttpRequest();
        xmlhttp.addEventListener("readystatechange", statsResponse);
        xmlhttp.open("POST", dataScript, true);
        // tell the server what you're doing
        xmlhttp.setRequestHeader("Content-type", "application/json");
        // send it
        xmlhttp.send(sendString);
    }

    function getThisVisit() {
        // check for new entry
        if (drpVisit.selectedIndex === 0) {
            // clear the board

        } else {

        }
    }

    // ---------------------------------------------------------------- data transfers

    function onSubmit(e) {

        // loading
        loading();
        
        // which radio button is selected?
        var sex = "male";
        if (rdoF.checked) {
            sex = "female";
        }
        
        // construct json object to send to the handler script
        var sendJSON = {
            "first": txtFName.value,
            "last": txtLName.value,
            "village": drpVillage[drpVillage.selectedIndex].value,
            "age": inpDOB.value,
            "sex": sex
        };
        
        console.log(sendJSON);
        
        // turn object into a string
        var sendString = JSON.stringify(sendJSON);

        // send string to the server handler
        xmlhttp = new XMLHttpRequest();
        xmlhttp.addEventListener("readystatechange", basicResponse);
        xmlhttp.open("POST", registerScript, true);
        // tell the server what you're doing
        xmlhttp.setRequestHeader("Content-type", "application/json");
        // send it
        xmlhttp.send(sendString);
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

    function patientResponse(e) {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", patientResponse);

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

                // load visits
                getVisits();

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
                    option.text = "Visit #" + response.entries[i];
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
                response.entries[0];

            } else {






                // bad feedback
                //feedback(response.reason);
            }
            

            // not loading
            notLoading();
        }
    }

})();