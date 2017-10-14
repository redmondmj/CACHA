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
    
    // tests
    var drpLastV = null;
    var drpLastPZQ = null;
    var drpLastWorm = null;
    var drpLastVitA = null;

    // administrated
    var chkParac = null;
    var chkBenz = null;
    var chkCeft = null;

    // diagnosis
    var chkHealthy = null;
    var chkNTR = null;
    var drpMSK = null;
    var drpWorms = null;
    var drpAsthma = null;
    var drpBron = null;
    var drpPneu = null;
    var drpCough = null;
    var drpMal = null;
    var drpSchisto = null;
    var drpTyphoid = null;
    var drpGERD = null;
    var drpPUD = null;
    var drpHyper = null;
    var drpDiabetes = null;
    var drpCon = null;
    var drpDiarrhea = null;
    var drpDiarrheaType = null;
    var drpPID = null;
    var drpSTI = null;
    var drpSyph = null;
    var drpEye = null;
    var drpVit = null;
    var drpDDS = null;
    var drpTopical = null;
    var txtTopical = null;
    var drpOther = null;
    var txtOther = null;
    var txtAssess = null;

    // pregnancy
    var txtWeeks = null;
    var rdoANCYes = null;
    var rdoANCNo = null;
    var rdoAnemiaYes = null;
    var rdoAnemiaNo = null;
    var drpIPTp = null;
    var drpSulfadar = null;

    // notes
    var txtFollow = null;
    var txtEdu = null;

    // referral
    var chkTB = null;
    var chkSurgery = null;
    var chkHospital = null;

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

    var txtPT1Init = null;
    var drpPT1Sex = null;
    var drpPT1Preg = null;
    var txtPT1Month = null;
    var drpPT1BF = null;
    var txtPT1MTZ = null;
    var txtPT1Doxy = null;
    var txtPT1Amox = null;

    var txtPT2Init = null;
    var drpPT2Sex = null;
    var drpPT2Preg = null;
    var txtPT2Month = null;
    var drpPT2BF = null;
    var txtPT2MTZ = null;
    var txtPT2Doxy = null;
    var txtPT2Amox = null;

    var txtPT3Init = null;
    var drpPT3Sex = null;
    var drpPT3Preg = null;
    var txtPT3Month = null;
    var drpPT3BF = null;
    var txtPT3MTZ = null;
    var txtPT3Doxy = null;
    var txtPT3Amox = null;

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

        // tests
        drpLastV = document.getElementById("drpLastV");
        drpLastPZQ = document.getElementById("drpLastPZQ");
        drpLastWorm = document.getElementById("drpLastWorm");
        drpLastVitA = document.getElementById("drpLastVitA");

        // administrated
        chkParac = document.getElementById("chkParac");
        chkBenz = document.getElementById("chkBenz");
        chkCeft = document.getElementById("chkCeft");
        
        // diagnosis
        chkHealthy = document.getElementById("chkHealthy");
        chkNTR = document.getElementById("chkNTR");
    
        drpMSK = document.getElementById("drpMSK");
        drpWorms = document.getElementById("drpWorms");
        drpAsthma = document.getElementById("drpAsthma");
        drpBron = document.getElementById("drpBron");
        drpPneu = document.getElementById("drpPneu");
        drpCough = document.getElementById("drpCough");
        drpMal = document.getElementById("drpMal");
        drpSchisto = document.getElementById("drpSchisto");
        drpTyphoid = document.getElementById("drpTyphoid");
        drpGERD = document.getElementById("drpGERD");
        drpPUD = document.getElementById("drpPUD");
        drpHyper = document.getElementById("drpHyper");
        drpDiabetes = document.getElementById("drpDiabetes");
        drpCon = document.getElementById("drpCon");
        drpDiarrhea = document.getElementById("drpDiarrhea");
        drpDiarrheaType = document.getElementById("drpDiarrheaType");
        drpPID = document.getElementById("drpPID");
        drpSTI = document.getElementById("drpSTI");
        drpSyph = document.getElementById("drpSyph");
        drpEye = document.getElementById("drpEye");
        drpVit = document.getElementById("drpVit");
        drpDDS = document.getElementById("drpDDS");
        drpTopical = document.getElementById("drpTopical");
        txtTopical = document.getElementById("txtTopical");
        drpOther = document.getElementById("drpOther");
        txtOther = document.getElementById("txtOther");
        txtAssess = document.getElementById("txtAssess");
    
        // pregnancy
        txtWeeks = document.getElementById("txtWeeks");
        rdoANCYes = document.getElementById("rdoANCYes");
        rdoANCNo = document.getElementById("rdoANCNo");
        rdoAnemiaYes = document.getElementById("rdoAnemiaYes");
        rdoAnemiaNo = document.getElementById("rdoAnemiaNo");
        drpIPTp = document.getElementById("drpIPTp");
        drpSulfadar = document.getElementById("drpSulfadar");

        // notes
        txtFollow = document.getElementById("txtFollow");
        txtEdu = document.getElementById("txtEdu");

        // referral
        chkTB = document.getElementById("chkTB");
        chkSurgery = document.getElementById("chkSurgery");
        chkHospital = document.getElementById("chkHospital");
    
        // STI/PID chart
        chkSTI = document.getElementById("chkHospital");
        chkPID = document.getElementById("chkHospital");

        txtPTInit = document.getElementById("txtPTInit");
        drpPTSex = document.getElementById("drpPTSex");
        drpPTPreg = document.getElementById("drpPTPreg");
        txtPTMonth = document.getElementById("txtPTMonth");
        drpPTBF = document.getElementById("drpPTBF");
        txtPTMTZ = document.getElementById("txtPTMTZ");
        txtPTDoxy = document.getElementById("txtPTDoxy");
        txtPTAmox = document.getElementById("txtPTAmox");

        txtPTInit = document.getElementById("txtPT1Init");
        drpPTSex = document.getElementById("drpPT1Sex");
        drpPTPreg = document.getElementById("drpPT1Preg");
        txtPTMonth = document.getElementById("txtPT1Month");
        drpPTBF = document.getElementById("drpPT1BF");
        txtPTMTZ = document.getElementById("txtPT1MTZ");
        txtPTDoxy = document.getElementById("txtPT1Doxy");
        txtPTAmox = document.getElementById("txtPT1Amox");

        txtPTInit = document.getElementById("txtPT2Init");
        drpPTSex = document.getElementById("drpPT2Sex");
        drpPTPreg = document.getElementById("drpPT2Preg");
        txtPTMonth = document.getElementById("txtPT2Month");
        drpPTBF = document.getElementById("drpPT2BF");
        txtPTMTZ = document.getElementById("txtPT2MTZ");
        txtPTDoxy = document.getElementById("txtPT2Doxy");
        txtPTAmox = document.getElementById("txtPT2Amox");

        txtPTInit = document.getElementById("txtPT3Init");
        drpPTSex = document.getElementById("drpPT3Sex");
        drpPTPreg = document.getElementById("drpPT3Preg");
        txtPTMonth = document.getElementById("txtPT3Month");
        drpPTBF = document.getElementById("drpPT3BF");
        txtPTMTZ = document.getElementById("txtPT3MTZ");
        txtPTDoxy = document.getElementById("txtPT3Doxy");
        txtPTAmox = document.getElementById("txtPT3Amox");

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

        // event listener for the buttons
        //btnChart.addEventListener("click", toChart);
        //btnSubmit.addEventListener("click", onSubmit);

        /*
        // feedback from uploading?
        if (lblFeedback.innerHTML !== "") {
            // get the feedback
            feedback(lblFeedback.innerHTML);
        }
        */
        
        // populate dropdowns
        getPatients();
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
        if (response === "patients") {
            xmlhttp.addEventListener("readystatechange", patientsResponse);
        } else if (response === "visits") {
            xmlhttp.addEventListener("readystatechange", visitsResponse);
        } else if (response === "stats") {
            xmlhttp.addEventListener("readystatechange", statsResponse);
        } else if (response === "clinic") {
            xmlhttp.addEventListener("readystatechange", clinicResponse);
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
        
        // tests
        drpLastV.selectedIndex = 0;
        drpLastPZQ.selectedIndex = 0;
        drpLastWorm.selectedIndex = 0;
        drpLastVitA.selectedIndex = 0;

        // drug administration
        chkParac.checked = false;
        chkBenz.checked = false;
        chkCeft.checked = false;

        // diagnosis
        chkHealthy.checked = false;
        chkNTR.checked = false;

        drpMSK.selectedIndex = 0;
        drpWorms.selectedIndex = 0;
        drpAsthma.selectedIndex = 0;
        drpBron.selectedIndex = 0;
        drpPneu.selectedIndex = 0;
        drpCough.selectedIndex = 0;
        drpMal.selectedIndex = 0;
        drpSchisto.selectedIndex = 0;
        drpTyphoid.selectedIndex = 0;
        drpGERD.selectedIndex = 0;
        drpPUD.selectedIndex = 0;
        drpHyper.selectedIndex = 0;
        drpDiabetes.selectedIndex = 0;
        drpCon.selectedIndex = 0;
        drpDiarrhea.selectedIndex = 0;
        drpPID.selectedIndex = 0;
        drpSTI.selectedIndex = 0;
        drpSyph.selectedIndex = 0;
        drpEye.selectedIndex = 0;
        drpVit.selectedIndex = 0;
        txtTopical.value = "";
        txtOther.value = "";
        txtAssess.innerHTML = "";

        // pregnancy
        txtWeeks.value = "";
        rdoANCYes.checked = false;
        rdoANCNo.checked = false;
        rdoAnemiaYes.checked = false;
        rdoAnemiaNo.checked = false;
        drpIPTP.selectedIndex = 0;
        drpSulfadar.selectedIndex = 0;

        // other
        txtFollow.innerHTML = "";
        txtEdu.innerHTML = "";

        // referral
        chkTB.checked = false;
        chkSurgery.checked = false;
        chkHospital.checked = false;

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

        // construct the JSON object to send to the handler
        var sendJSON = {
            "request": "clinic",
            "id": drpVisit[drpVisit.selectedIndex].value
        };

        // send the json off
        sendJson(sendJSON, dataScript, "clinic");
    }

    // ---------------------------------------------------------------- data transfers

    function onSubmit(e) {

        // loading
        loading();
        
        // checkboxes
        var parac = "no";
        var benz = "no";
        var ceft = "no";
        if (chkParac.checked) {parac = "yes";}
        if (chkBenz.checked) {benz = "yes";}
        if (chkCeft.checked) {ceft = "yes";}

        var healthy = "no";
        var ntr = "no";
        if (chkHealthy.checked) {healthy = "yes";}
        if (chkNTR.checked) {ntr = "yes";}

        var tb = "no";
        var surgery = "no";
        var hospital = "no";
        if (chkTB.checked) {tb = "yes";}
        if (chkSurgery.checked) {surgery = "yes";}
        if (chkHospital.checked) {hospital = "yes";}

        // radio buttons
        var anc = "no";
        var anemia = "no";
        if (rdoANCYes.checked) {anc = "yes";}
        if (rdoAnemiaYes.checked) {anemia = "yes";}

        // construct json object to send to the handler script
        var sendJSON = {
            "upload": "clinic",
            "patientid": drpPatient[drpPatient.selectedIndex].value,
            "visit": drpVisit[drpVisit.selectedIndex].value,
            "lastv": drpLastV[drpLastV.selectedIndex].value,
            "lastpzq": drpLastPZQ[drpLastPZQ.selectedIndex].value,
            "lastworm": drpLastWorm[drpLastWorm.selectedIndex].value,
            "lastvita": drpLastVitA[drpLastVitA.selectedIndex].value,
            "parac": parac,
            "benz": benz,
            "ceft": ceft,

            "healthy": healthy,
            "ntr": ntr,
            "msk": drpMSK[drpMSK.selectedIndex].value,
            "eye": drpEye[drpEye.selectedIndex].value,
            "vit": drpVit[drpVit.selectedIndex].value,
            "dds": drpDDS[drpDDS.selectedIndex].value,
            "worms": drpWorms[drpWorms.selectedIndex].value,
            "mal": drpMal[drpMal.selectedIndex].value,
            "schisto": drpSchisto[drpSchisto.selectedIndex].value,
            "typhoid": drpTyphoid[drpTyphoid.selectedIndex].value,
            "asthma": drpAsthma[drpAsthma.selectedIndex].value,
            "bronc": drpBron[drpBron.selectedIndex].value,
            "pneu": drpPneu[drpPneu.selectedIndex].value,
            "cough": drpCough[drpCough.selectedIndex].value,
            "gerd": drpGERD[drpGERD.selectedIndex].value,
            "pud": drpPUD[drpPUD.selectedIndex].value,
            "hyper": drpHyper[drpHyper.selectedIndex].value,
            "con": drpCon[drpCon.selectedIndex].value,
            "diarrhea": drpDiarrhea[drpDiarrhea.selectedIndex].value,
            "diarrheatype": drpDiarrheaType[drpDiarrheaType.selectedIndex].value,
            "diabetes": drpDiabetes[drpDiabetes.selectedIndex].value,
            "pid": drpPID[drpPID.selectedIndex].value,
            "sti": drpSTI[drpSTI.selectedIndex].value,
            "syph": drpSyph[drpSyph.selectedIndex].value,
            "topical": txtTopical.value,
            "other": txtOther.value,
            "assess": txtAssess.innerHTML,

            "weeks": txtWeeks.value,
            "anc": anc,
            "anemia": anemia,
            "lastiptp": drpIPTp[drpIPTp.selectedIndex].value,
            "sulfadar": drpSulfadar[drpSulfadar.selectedIndex].value,

            "follow": txtFollow.value,
            "edu": txtEdu.value,

            "tb": tb,
            "surgery": surgery,
            "hospital": hospital,

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

    function clinicResponse() {
        if ((xmlhttp.readyState === 4) && (xmlhttp.status === 200)) {
            // remove event listener
            xmlhttp.removeEventListener("readystatechange", clinicResponse);

            // get the json data received
            var response = JSON.parse(xmlhttp.responseText);
            
            if (response.success) {
                // populate the data

                console.log(response);

                lblCase.innerHTML = "Case #" + drpVisit[drpVisit.selectedIndex].value;

                // run through the test lists until we find a match
                for (var n=0;n < drpLastV.length;n++) {
                    if (drpLastV[n].value === response.entries[0].lastv) {
                        drpLastV.selectedIndex = n;
                        break;
                    }
                }
                for (n=0;n < drpLastPZQ.length;n++) {
                    if (drpLastPZQ[n].value === response.entries[0].lastpzq) {
                        drpLastPZQ.selectedIndex = n;
                        break;
                    }
                }
                for (n=0;n < drpLastWorm.length;n++) {
                    if (drpLastWorm[n].value === response.entries[0].lastworm) {
                        drpLastWorm.selectedIndex = n;
                        break;
                    }
                }
                for (n=0;n < drpLastVitA.length;n++) {
                    if (drpLastVitA[n].value === response.entries[0].lastvita) {
                        drpLastVitA.selectedIndex = n;
                        break;
                    }
                }

                // admin section
                if (response.entries[0].parac) {chkParac.checked = true;} else {chkParac.checked = false;}
                if (response.entries[0].benz) {chkBenz.checked = true;} else {chkBenz.checked = false;}
                if (response.entries[0].ceft) {chkCeft.checked = true;} else {chkCeft.checked = false;}

                // diagnosis
                if (response.entries[0].healthy) {chkHealthy.checked = true;} else {chkHealthy.checked = false;}
                if (response.entries[0].ntr) {chkNTR.checked = true;} else {chkNTR.checked = false;}

                drpMSK.selectedIndex = response.entries[0].msk;
                drpEye.selectedIndex = response.entries[0].eye;
                drpVit.selectedIndex = response.entries[0].vit;
                drpDDS.selectedIndex = response.entries[0].dds;

                drpWorms.selectedIndex = response.entries[0].worms;
                drpMal.selectedIndex = response.entries[0].mal;
                drpSchisto.selectedIndex = response.entries[0].schisto;
                drpTyphoid.selectedIndex = response.entries[0].typhoid;

                drpAsthma.selectedIndex = response.entries[0].asthma;
                drpBron.selectedIndex = response.entries[0].bron;
                drpPneu.selectedIndex = response.entries[0].pneu;
                drpCough.selectedIndex = response.entries[0].cough;

                drpGERD.selectedIndex = response.entries[0].gerd;
                drpPUD.selectedIndex = response.entries[0].pud;
                drpHyper.selectedIndex = response.entries[0].hyper;

                drpCon.selectedIndex = response.entries[0].con;
                drpDiarrhea.selectedIndex = response.entries[0].diarrhea;
                if (response.entries[0].diarrheatype === "watery") {
                    drpDiarrheaType.selectedIndex = 1;
                } else if (response.entries[0].diarrheatype === "bloody") {
                    drpDiarrheaType.selectedIndex = 2;
                } else {
                    drpDiarrheaType.selectedIndex = 0;
                }

                drpDiabetes.selectedIndex = response.entries[0].diabetes;
                drpPID.selectedIndex = response.entries[0].pid;
                drpSTI.selectedIndex = response.entries[0].sti;
                drpSyph.selectedIndex = response.entries[0].syph;

                for (n=0;n < drpTopical.length;n++) {
                    if (drpTopical[n].value === response.entries[0].topical) {
                        drpTopical.selectedIndex = n;
                        break;
                    }
                }
                txtTopical.value = response.entries[0].topicaldesc;
                for (n=0;n < drpOther.length;n++) {
                    if (drpOther[n].value === response.entries[0].other) {
                        drpOther.selectedIndex = n;
                        break;
                    }
                }
                txtOther.value = response.entries[0].otherdesc;

                txtAssess.innerHTML = response.entries[0].assess;

                // pregnancy
                txtWeeks.value = response.entries[0].weeks;
                if (response.entries[0].anc === "yes") {
                    rdoANCYes.checked = true;
                    rdoANCNo.checked = false;
                } else {
                    rdoANCYes.checked = false;
                    rdoANCNo.checked = false;
                }
                if (response.entries[0].anemia === "yes") {
                    rdoAnemiaYes.checked = true;
                    rdoAnemiaNo.checked = false;
                } else {
                    rdoAnemiaYes.checked = false;
                    rdoAnemiaNo.checked = false;
                }

                for (n=0;n < drpIPTp.length;n++) {
                    if (drpIPTp[n].value === response.entries[0].iptp) {
                        drpIPTp.selectedIndex = n;
                        break;
                    }
                }
                for (n=0;n < drpSulfadar.length;n++) {
                    if (drpSulfadar[n].value === response.entries[0].sulfadar) {
                        drpSulfadar.selectedIndex = n;
                        break;
                    }
                }

                // text
                txtFollow.value = response.entries[0].follow;
                txtEdu.value = response.entries[0].edu;

                // referrals
                if (response.entries[0].tb) {chkTB.checked = true;} else {chkTB.checked = false;}
                if (response.entries[0].surgery) {chkSurgery.checked = true;} else {chkSurgery.checked = false;}
                if (response.entries[0].hospital) {chkHospital.checked = true;} else {chkHospital.checked = false;}

                // STI/PID info
                txtPTInit.value = response.entries[0].ptinit;
                for (n=0;n < drpPTSex.length;n++) {
                    if (drpPTSex[n].value === response.entries[0].ptsex) {
                        drpPTSex.selectedIndex = n;
                        break;
                    }
                }
                for (n=0;n < drpPTPreg.length;n++) {
                    if (drpPTPreg[n].value === response.entries[0].ptpreg) {
                        drpPTPreg.selectedIndex = n;
                        break;
                    }
                }
                txtPTMonth.value = response.entries[0].ptmonth;
                for (n=0;n < drpPTBF.length;n++) {
                    if (drpPTBF[n].value === response.entries[0].ptbf) {
                        drpPTBF.selectedIndex = n;
                        break;
                    }
                }
                txtPTMTZ.value = response.entries[0].ptmtz;
                txtPTDoxy.value = response.entries[0].ptdoxy;
                txtPTAmox.value = response.entries[0].ptamox;

                txtPT1Init.value = response.entries[0].pt1init;
                for (n=0;n < drpPT1Sex.length;n++) {
                    if (drpPT1Sex[n].value === response.entries[0].pt1sex) {
                        drpPT1Sex.selectedIndex = n;
                        break;
                    }
                }
                for (n=0;n < drpPT1Preg.length;n++) {
                    if (drpPT1Preg[n].value === response.entries[0].pt1preg) {
                        drpPT1Preg.selectedIndex = n;
                        break;
                    }
                }
                txtPT1Month.value = response.entries[0].pt1month;
                for (n=0;n < drpPT1BF.length;n++) {
                    if (drpPT1BF[n].value === response.entries[0].pt1bf) {
                        drpPT1BF.selectedIndex = n;
                        break;
                    }
                }
                txtPT1MTZ.value = response.entries[0].pt1mtz;
                txtPT1Doxy.value = response.entries[0].pt1doxy;
                txtPT1Amox.value = response.entries[0].pt1amox;

                txtPT2Init.value = response.entries[0].pt2init;
                for (n=0;n < drpPT2Sex.length;n++) {
                    if (drpPT2Sex[n].value === response.entries[0].pt2sex) {
                        drpPT2Sex.selectedIndex = n;
                        break;
                    }
                }
                for (n=0;n < drpPT2Preg.length;n++) {
                    if (drpPT2Preg[n].value === response.entries[0].pt2preg) {
                        drpPT2Preg.selectedIndex = n;
                        break;
                    }
                }
                txtPT2Month.value = response.entries[0].pt2month;
                for (n=0;n < drpPT2BF.length;n++) {
                    if (drpPT2BF[n].value === response.entries[0].pt2bf) {
                        drpPT2BF.selectedIndex = n;
                        break;
                    }
                }
                txtPT2MTZ.value = response.entries[0].pt2mtz;
                txtPT2Doxy.value = response.entries[0].pt2doxy;
                txtPT2Amox.value = response.entries[0].pt2amox;

                txtPT3Init.value = response.entries[0].pt3init;
                for (n=0;n < drpPT3Sex.length;n++) {
                    if (drpPT3Sex[n].value === response.entries[0].pt3sex) {
                        drpPT3Sex.selectedIndex = n;
                        break;
                    }
                }
                for (n=0;n < drpPT3Preg.length;n++) {
                    if (drpPT3Preg[n].value === response.entries[0].pt3preg) {
                        drpPT3Preg.selectedIndex = n;
                        break;
                    }
                }
                txtPT3Month.value = response.entries[0].pt3month;
                for (n=0;n < drpPT3BF.length;n++) {
                    if (drpPT3BF[n].value === response.entries[0].pt3bf) {
                        drpPT3BF.selectedIndex = n;
                        break;
                    }
                }
                txtPT3MTZ.value = response.entries[0].pt3mtz;
                txtPT3Doxy.value = response.entries[0].pt3doxy;
                txtPT3Amox.value = response.entries[0].pt3amox;

                // stations
                lblTriageTest.value = response.entries[0].test;
                for (n=0;n < drpTriageTest.length;n++) {
                    if (drpTriageTest[n].value === response.entries[0].test) {
                        drpTriageTest.selectedIndex = n;
                        break;
                    }
                }
                lblTriageMED.value = response.entries[0].med;
                for (n=0;n < drpTriageMED.length;n++) {
                    if (drpTriageMED[n].value === response.entries[0].med) {
                        drpTriageMED.selectedIndex = n;
                        break;
                    }
                }
                lblTriageGYN.value = response.entries[0].gyn;
                for (n=0;n < drpTriageGYN.length;n++) {
                    if (drpTriageGYN[n].value === response.entries[0].gyn) {
                        drpTriageGYN.selectedIndex = n;
                        break;
                    }
                }
                lblTriageOPHT.value = response.entries[0].opht;
                for (n=0;n < drpTriageOPHT.length;n++) {
                    if (drpTriageOPHT[n].value === response.entries[0].opht) {
                        drpTriageOPHT.selectedIndex = n;
                        break;
                    }
                }
                lblTriageDENT.value = response.entries[0].dent;
                for (n=0;n < drpTriageDENT.length;n++) {
                    if (drpTriageDENT[n].value === response.entries[0].dent) {
                        drpTriageDENT.selectedIndex = n;
                        break;
                    }
                }
                lblTriageV.value = response.entries[0].stationv;
                for (n=0;n < drpTriageV.length;n++) {
                    if (drpTriageV[n].value === response.entries[0].stationv) {
                        drpTriageV.selectedIndex = n;
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