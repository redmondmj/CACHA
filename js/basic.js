(function () {
    "use strict";

    // retrieve data
    var visitScript = "dropdownScript.php";
    var dispensaryScript = "dropdownScript.php";
    var registerScript = "registerScript.php";

    // XMLHttpRequest object
    var xmlhttp = null;

    // page variables
    var divMain = null;

    //var lblFeedback = null;

    
    var drpPatient = null;
    var drpVisit = null;

    var lblName = null;
    var lblAge = null;
    var lblAge = null;
    
    var inpDOB = null;
    
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
        
        txtFName = document.getElementById("txtFName");
        txtLName = document.getElementById("txtLName");

        drpVillage = document.getElementById("drpVillage");
        inpDOB = document.getElementById("inpDOB");
        
        rdoM = document.getElementById("rdoM");
        rdoF = document.getElementById("rdoF");

        btnSubmit = document.getElementById("btnSubmit");

        // event listener for the button
        btnSubmit.addEventListener("click", onSubmit);

        // feedback from uploading?
        if (lblFeedback.innerHTML !== "") {
            // get the feedback
            feedback(lblFeedback.innerHTML);
        }

        // populate dropdown
        getDropdown();

    }

    // ------------------------------------------------------------ private methods

    //http://stackoverflow.com/questions/5898656/test-if-an-element-contains-a-class
    function hasClass(element, cls) {
        return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
    }

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

    // ------------------------------------------------------------ event handlers

    // ---------------------------------------------------------------- data transfers

    function getDropdown() {

        // construct the JSON object to send to the handler
        var sendJSON = {
            "menu": "village"
        };

        // turn object into a string
        var sendString = JSON.stringify(sendJSON);

        // send string to the server handler
        xmlhttp = new XMLHttpRequest();
        xmlhttp.addEventListener("readystatechange", menuResponse);
        xmlhttp.open("POST", villageScript, true);
        // tell the server what you're doing
        xmlhttp.setRequestHeader("Content-type", "application/json");
        // send it
        xmlhttp.send(sendString);

    }
    
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
        xmlhttp.addEventListener("readystatechange", registerResponse);
        xmlhttp.open("POST", registerScript, true);
        // tell the server what you're doing
        xmlhttp.setRequestHeader("Content-type", "application/json");
        // send it
        xmlhttp.send(sendString);
    }
    
    // ---------------------------------------------------------------- data response

    function menuResponse(e) {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", menuResponse);

            // get the json data received
            var response = JSON.parse(xmlhttp.responseText);

            // clear the dropdown
            drpVillage.innerHTML = "";

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

                    // add element to sampleList as a new option
                    drpVillage.append(option);
                }

                // set sponsor data for first entry
                drpVillage.selectedIndex = 0;

            } else {
                // no data to display

                // build an empty option element and add properties
                var option = new Option();
                option.id = 0;
                option.text = "Empty";
                option.value = 0;

                // add element to sampleList as a new option
                drpVillage.append(option);

                // set sponsor data for first entry
                drpVillage.selectedIndex = 0;

                // failure or no entries?
                if (response.success) {
                    // feedback
                    feedback("No entries in the database");
                } else {
                    feedback(response.reason);
                }
            }
            
            // remove loading screen
            notLoading();
        }
    }

    function registerResponse(e) {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", registerResponse);

            // get the json data received
            var response = JSON.parse(xmlhttp.responseText);
            
            if (response.success) {
                // good feedback
                feedback("Patient was successfully registered");
            } else {
                // bad feedback
                feedback(response.reason);
            }

            // not loading
            notLoading();
        }
    }

})();