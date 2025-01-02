"use strict";
//#######################//
//####### GENERIC #######//
//#######################//
function _(x){
	return document.getElementById(x);
}

function goTo(here){
    window.location.href=here;
}

function reloadPage(){
    window.location.reload();
}

//Show an element and hide others
function toggleView(elem1, elem2=null, elem3=null, elem4=null){
    $(elem1).toggleClass('d-none');
    $(elem2).toggleClass('d-none');
    $(elem3).toggleClass('d-none');
    $(elem4).toggleClass('d-none');
}

//Format DateTime in the format yyyy-mm-ddThh:mm
function formatDateTime(datetimeValue, targetFormat) {
    const [datePart, timePart] = datetimeValue.split('T');

    // Split the date and time components
    const [year, month, day] = datePart.split('-');
    const [hours, minutes] = timePart.split(':');

    // Build the formatted datetime string
    let formattedDatetime = targetFormat
      .replace('Y', year)
      .replace('m', month)
      .replace('d', day)
      .replace('H', hours)
      .replace('i', minutes);

    return formattedDatetime;
}

//Security
function escapeHTML(input) {
    return input
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#x27;')
        .replace(/\//g, '&#x2F;');
}

//Sweetalert pop-ups
function swal_Popup(status, responseMessage, btn_text='Ok, got it!'){
    // status = error/success
    if (!responseMessage || responseMessage == '') {
        responseMessage = 'NO RESPONSE MESSAGE!';
    }
    if (status === 'error'){ var btn_type = "btn font-weight-bold btn-danger";} 
    else if (status === 'success') { var btn_type = "btn btn-primary";}
    else if (status === 'info') { var btn_type = "btn btn-info";}
    else { var btn_type = "btn btn-warning";}

    Swal.fire({
        html: responseMessage,
        icon: status,
        buttonsStyling: false,
        confirmButtonText: btn_text,
        customClass: {
            confirmButton: btn_type
        }
    });
}

//sweetalert confirm
function swal_confirm(msg, btn_yes = 'YES', btn_no = 'NO', deny=true, icon='question') {
    return new Promise((resolve, reject) => {
        swal.fire({
            text: msg,
            icon: icon,
            buttonsStyling: false,
            showDenyButton: deny,
            confirmButtonText: btn_yes,
            denyButtonText: btn_no,
            customClass: {
                confirmButton: "btn btn-primary",
                denyButton: "btn btn-light"
            }
        }).then((result) => {
            //The result object will contain { isConfirmed: true } for "YES" and { isDenied: true } for "NO"
            resolve(result);
        }).catch((error) => {
            reject(error);
        });
    });
}

// Serialize any form and convert output to JSON. The name of each field will become the JSON attribute
function serializeToJSON(formID){
    var formData = {};
    $.each($(formID).serializeArray(), function(_, field) {
        formData[field.name] = field.value;
    });
    return formData;
}

// Extract all elements from any form as JSON data
function formdataJSON(form){
    var formElements = form.elements;
    var formData = {};
    for (var i = 0; i < formElements.length; i++) {
        var element = formElements[i];
        if (element.tagName === 'INPUT' || element.tagName === 'SELECT' || element.tagName === 'TEXTAREA') {
            if (element.type === 'date' || element.type === 'datetime-local') {
                // Parse value through the formatDateTime() fxn
                formData[element.name] = formatDateTime(element.value, 'd/m/Y H:i');
            } else {
                formData[element.name] = escapeHTML(element.value);
            }
        }
    }
    return formData;
}

// Handle response from ajax call
function handleResponse(response){
    var responseStatus;
    if(response['statusCode'] !== 200 || response['success'] !== true){
        responseStatus = 'error';
    } else {
        responseStatus = 'success';
    }
    var responseDetails = responseStatus.toUpperCase()+" - "+JSON.stringify(response);
    var responseMessage = response.messages[0];

    return {
        'status': responseStatus,
        'message' : responseMessage,
        'details': responseDetails,
        'data': response.data
    };
}

function handleResponseMsg(responseMsg, action=null, url=null){
    if (responseMsg.status === 'success'){
        if(action == 'reload'){ reloadPage(); }
        else if(action == 'redirect'){ goTo(url); }
        else if(action == 'goback'){ window.history.back(); }
        else if(action == 'confirmexit'){
            swal_confirm("DONE! What do you want to do next?", "Save & Exit", "Stay on this page")
            .then((result) => {
                if (result.isConfirmed) {
                    history.back();
                } else if (result.isDenied) {
                    console.log("Canceled");
                }
            })
            .catch((error) => {
                console.error(error);
            });
        }
        else if(action == 'confirmredirect'){
            swal_confirm(responseMsg.message, "Proceed", null, false, 'success')
            .then((result) => {
                if (result.isConfirmed) {
                    goTo(url);
                } else if (result.isDenied) {
                    console.log("Canceled");
                }
            })
            .catch((error) => {
                console.error(error);
            });
        }
        else if(action == 'confirmreload'){
            swal_confirm("Saved!", "OK", null, false, 'success')
            .then((result) => {
                if (result.isConfirmed) {
                    reloadPage();
                } else if (result.isDenied) {
                    console.log("Canceled");
                }
            })
            .catch((error) => {
                console.error(error);
            });
        }
        else if(action == 'logdata'){ console.log(responseMsg); }
        //if any other action is set, alert the message and do nothing
        else {swal_Popup(responseMsg.status, responseMsg.message, 'Okay. Got it!');}
    } else {
        swal_Popup(responseMsg.status, responseMsg.message, 'Okay. Got it!');
        console.log(responseMsg.details); // remove for production
    }
}

// AJAX Calls
function AJAXcall(formID, submitButton=null, type, url, formData=null, callback){
    var responseMsg; // error or success
    if(submitButton !== null){
        submitButton.setAttribute('data-kt-indicator', 'on'); //loading
        submitButton.disabled = true;
    }

    // Handle form serialization
    if (formData === null){ 
        formData = serializeToJSON(formID);
    } else {
        //ensure you parse an already converted JSON data (eg by using the formdataJSON() fxn)
        formData = formData; 
    }

    $.ajax({
        url: url,
        type: type,
        dataType: 'JSON',
        headers: {
            'Content-Type': 'application/json',
            "Authorization": `${auth_token}` //auth_token is provided from auth.php
        },
        //data: formData,
        data: JSON.stringify(formData),
        success: function(response){
            
            responseMsg = handleResponse(response);

            if(callback) {
                callback(responseMsg); //send to the handleResponse() fxn
            } else {
                handleResponseMsg(responseMsg);
            }

            if(submitButton !== null){
                submitButton.disabled = false;
                submitButton.setAttribute('data-kt-indicator', 'off');
            }

        }
    });
}

function AJAXUploadImg(url, type, imageData, submitButton=null, callback){
    var responseMsg; // error or success
    if(submitButton !== null){
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
    }

    $.ajax({
        url: url,
        type: type,
        processData: false,
        contentType: false,
        data: imageData,
        success: function(response){
            responseMsg = handleResponse(response);

            if(callback) {
                callback(responseMsg);
            } else {
                handleResponseMsg(responseMsg);
            }

            if(submitButton !== null){
                submitButton.disabled = false;
                submitButton.setAttribute('data-kt-indicator', 'off');
            }
        }
    });
}

// Process file uploads
function getUploadData(fieldname, attributes=null){
    var field = $('input[name="' + fieldname + '"]')[0];
    var file = field.files[0];

    var formData = new FormData();

    if (field.files.length > 0) {
        formData.append(fieldname, file);
        formData.append("attributes", JSON.stringify(attributes));

        return formData;
    } else {
        return "No file selected.";
    }
}

//--clipboard
function copyToClipboard() {
    var button = document.querySelector('#copy_clipboard_btn');
    var input = document.querySelector('#copy_clipboard_input');

    var buttonCaption = button.innerHTML;
    var clipboard = new ClipboardJS(button);
    button.innerHTML = 'Double click to copy';

    clipboard.on('success', function(e) {
        input.classList.add('bg-success');
        input.classList.add('text-inverse-success');

        button.innerHTML = 'Copied!';

        setTimeout(function() {
            button.innerHTML = buttonCaption;

            // Remove bgcolor
            input.classList.remove('bg-success'); 
            input.classList.remove('text-inverse-success'); 
        }, 3000);

        e.clearSelection();
    });
}

// Randomize a set of displays
function randomizeSpans() {
    var spans = document.querySelectorAll('#showRandom span');
    var currentSpan = null;

    function showRandomSpan() {
        //alert('hey');
        if (currentSpan) {
        currentSpan.style.display = 'none';
        }
        
        // Randomly select a new span
        var randomIndex = Math.floor(Math.random() * spans.length);
        var newSpan = spans[randomIndex];
        
        // Display the new span
        newSpan.style.display = 'inline';
        currentSpan = newSpan;
    }

    showRandomSpan();
    // Switch the displayed span every 10 seconds
    setInterval(showRandomSpan, 5000);
}

// Show Toast Message
function showToastMsg(msg){
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toastr-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": 0,
        "extendedTimeOut": 0,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "tapToDismiss": false
    };

    if (msg == "incomplete"){
        toastr.error('Please complete your profile to get the most out of our services<br /><br /><button type="button" class="btn btn-bg-light btn-sm" onClick="goTo(\'profile?page=business\')">Go to Profile</button>', "Complete your profile");
    }
}

//#######################//
//###### SPECIFIC #######//
//#######################//

//share links
function shareLink(media, message){
    var url = '';
    if(media === 'whatsapp'){
        url = "https://api.whatsapp.com/send?text=" + encodeURIComponent(message);
        //window.open(url, "_blank");
    } else if(media === 'facebook'){
        url = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(location.href) + "&quote=" + encodeURIComponent(message);
    } else if(media === 'twitter'){
        url = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(message);
    } else {
        alert('Invalid media');
    }
    window.open(url, "_blank");
} 

//sendMail
function sendMail(type, subject, to_mail, to_name='', message='', sender=''){
    var params = {
        type: type,
        subject: subject,
        to_name: to_name,
        to_mail: to_mail,
        message: message,
        sender: sender
    };

    AJAXcall(null, null, 'POST', 'controllers/_email.php', params);

}

//logout
function logout(sessionid, role){
    var formActionURL = "controllers/sessions.php?sessionid="+sessionid;
    var logoutLink = document.querySelector('#logout_link');
    logoutLink.setAttribute('data-kt-indicator', 'on');

    $.ajax({
        url: formActionURL,
        type: 'DELETE',
        dataType: 'JSON',
        headers: {
            'Content-Type': 'application/json',
            //"Authorization": `Bearer ${auth_token}`
            "Authorization": `${auth_token}` //auth_token is provided from auth.php
        },
        
        success: function(response){
            if(response['statusCode'] !== 200 || response['success'] !== true){
                var responseMessage = "ERROR: "+response.messages[0];
                //var responseMessage = "ERROR: "+JSON.stringify(response);

                swal_Popup('error', responseMessage, 'Try Again!');
            } else {
                Swal.fire({
                    text: "You have successfully logged out",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Exit",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    },
                    timer: "1000"
                }).then(function () {
                    if(role == 'business'){
                        location.href = "home";
                    } else {
                        location.href = "new?login";
                    }
                });
            }
        }
    });
}

//Populate States and cities based on selected country
function populateStates() {
    var countrySelect = document.getElementById("country");
    var stateSelect = document.getElementById("state");
    var citySelect = document.getElementById("city");
    // Get selected country value
    var selectedCountry = countrySelect.value;
    // Clear previous state and city options
    stateSelect.innerHTML = ""; //"<option value=''>States in "+selectedCountry+"</option>";
    citySelect.innerHTML = ""; //"<option value=''>Select a city</option>";

    // Fetch the data from JSON DB
    fetch('models/databases/city-state-country.json')
    .then(response => response.json())
    .then(data => {
        var states = [];
        data.Countries.forEach(country => {
            if (country.CountryName === selectedCountry) {
                states = country.States.map(state => state.StateName);
            }
        });
        for (var i = 0; i < states.length; i++) {
            var state = states[i];
            var option = document.createElement("option");
            option.value = state;
            option.text = state;
            stateSelect.appendChild(option);
        }
    })
    .catch(error => {
        console.log('Error:', error);
    });
}

function populateCities() {
    var stateSelect = document.getElementById("state");
    var citySelect = document.getElementById("city");
    // Get selected state values
    var selectedState = stateSelect.value;
    // Clear previous city options
    citySelect.innerHTML = ""; //"<option value=''>Cities in "+selectedState+"</option>";

    fetch('models/databases/city-state-country.json')
    .then(response => response.json())
    .then(data => {
        var cities = [];
        data.Countries.forEach(country => {
            country.States.forEach(state => {
                if (state.StateName === selectedState) {
                    cities = state.Cities;
                }
            });
        });
        for (var i = 0; i < cities.length; i++) {
            var city = cities[i];
            var option = document.createElement("option");
            option.value = city;
            option.text = city;
            citySelect.appendChild(option);
        }
    })
    .catch(error => {
        console.log('Error:', error);
    });

}
