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

function goBack(x=null){
    history.back(x);
}

function reloadPage(){
    window.location.reload();
}

//Show an element and hide others
function show(elem){
    $('#'+elem).removeClass('visually-hidden');
}
function hide(elem){
    $('#'+elem).addClass('visually-hidden');
}
function toggleView(elem1, elem2=null, elem3=null, elem4=null){
    $(elem1).toggleClass('visually-hidden');
    $(elem2).toggleClass('visually-hidden');
    $(elem3).toggleClass('visually-hidden');
    $(elem4).toggleClass('visually-hidden');
}

function restrict(elem, datatype){
	var tf = document.querySelector('[name="'+elem+'"]');;
	var rx = new RegExp;
	if(datatype == "nospace"){
		rx = /[' "]/gi;
	}else if(datatype == "phone"){
		rx = /[^+0-9]/gi;
	} else if(datatype == "email"){
		rx = /[^a-z0-9@_.\-]/gi;
	} else if(datatype == "alphanum"){
		rx = /[^a-zA-Z0-9]/gi;
	} else if(datatype == "numbers"){
		rx = /[^0-9]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}

//Format DateTime in the format yyyy-mm-ddThh:mm
function formatDateTime(datetimeValue, targetFormat) {
    // Check if the input value is empty or null
    if (!datetimeValue) return '';

    // Split the input into date and time parts, defaulting to empty strings if not available
    const [datePart = '', timePart = ''] = datetimeValue.split('T');

    // Extract year, month, and day from the date part (if available)
    const [year = '', month = '', day = ''] = datePart.split('-');

    // Extract hours and minutes from the time part (if available)
    const [hours = '', minutes = ''] = timePart.split(':');

    // Build the formatted datetime string
    let formattedDatetime = targetFormat
        .replace('Y', year || 'YYYY')
        .replace('m', month || 'MM')
        .replace('d', day || 'DD')
        .replace('H', hours || 'HH')
        .replace('i', minutes || 'MM');

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

//Mandatory fields
function requiredFields(fieldsArray, style = 'single') {
    const missingFields = [];
  
    for (const field of fieldsArray) {
      if (!field || field.trim() === '') {
        missingFields.push(field.toUpperCase());
      }
    }
  
    if (missingFields.length > 0) {
      const missingFieldsList = missingFields.join(', ');
  
      if (style === 'group') {
        return 'Some data missing! Complete all required fields.';
      } else {
        return `The following required fields are missing: ${missingFieldsList}.`;
      }
    }
  
    return ''; // No missing fields
}

//Replicate the php empty() function
function isEmpty(value) {
    return (
        value === undefined || 
        value === null || 
        value === '' || 
        value === false || 
        (Array.isArray(value) && value.length === 0) || 
        (typeof value === 'object' && Object.keys(value).length === 0)
    );
}

function decodedUrl(url){
    return url.replace(/&#x2F;/g, '/');
}

//#######################//
//#### PROCESS FORMS ####//
//#######################//
//Sweetalert pop-ups
function swal_popup(status, responseMessage, btn_text='OKAY!', callback){
    // status = error/success
    if (!responseMessage || responseMessage == '') {
        responseMessage = 'NO RESPONSE MESSAGE!';
    }
    if (status === 'error'){ var btn_type = "btn font-weight-bold btn-danger";} 
    else if (status === 'success') { var btn_type = "btn btn-primary";}
    else if (status === 'info') { var btn_type = "btn btn-info";}
    else { var btn_type = "btn btn-warning";}

    if(callback){
        Swal.fire({
            html: responseMessage,
            icon: status,
            buttonsStyling: false,
            confirmButtonText: btn_text,
            customClass: {
                confirmButton: btn_type
            },
            timer: "3000"
        }).then(callback(status));
    } else {
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
}

function swal_confirm(msg, btn_yes = 'YES', btn_no = 'NO', deny=true, icon='question') {
    return new Promise((resolve, reject) => {
        swal.fire({
            text: msg,
            icon: icon,
            buttonsStyling: false,
            showDenyButton: deny,
            denyButtonText: btn_no,
            confirmButtonText: btn_yes,
            customClass: {
                confirmButton: "btn btn-primary",
                denyButton: "btn btn-light"
            },
            reverseButtons: true
        }).then((result) => {
            //The result object will contain { isConfirmed: true } for "YES" and { isDenied: true } for "NO"
            resolve(result);
        }).catch((error) => {
            reject(error);
        });
    });
}

function submitButtonState(btnState, btnID){
    var submitButton = document.querySelector(btnID); // dont forget to add # before id name
    //var loader = document.querySelector(btnID+" .loader");
    //var btnTxt = submitButton.querySelector('#btnTxt');

    if(submitButton){
        if(btnState == 'loading'){
            submitButton.disabled = true;
            submitButton.setAttribute('data-kt-indicator', 'on');
            //btnTxt.classList.add("visually-hidden");
            //loader.classList.remove("visually-hidden");
        } else {
            submitButton.disabled = false;
            submitButton.setAttribute('data-kt-indicator', 'off');
            //btnTxt.classList.remove("visually-hidden");
            //loader.classList.add("visually-hidden");
        }
    }

}

// Extract all elements from any form (updated for file uploads)
function extractFormData(formID, method = null) {
    let form = document.querySelector(formID);
    let isFileUpload = false;
    let formData;

    // Detect if the form contains file inputs
    for (let element of form.elements) {
        if (element.type === 'file' && element.files.length > 0) {
            isFileUpload = true;
            break; // If any file input is detected, we use FormData
        }
    }

    if (isFileUpload) {
        // Use FormData for forms with file uploads
        formData = new FormData(form); // Collects all form data, including files
    } else {
        // Use JSON object for forms without file uploads
        formData = {};

        if (method === 'serialize') {
            // Serialize the form using jQuery's serializeArray (this used to be my default)
            $.each($(formID).serializeArray(), function (_, field) {
                formData[field.name] = escapeHTML(field.value);
            });
        } else {
            // Manually extract values for better control
            for (let element of form.elements) {
                if (element.tagName === 'INPUT' || element.tagName === 'SELECT' || element.tagName === 'TEXTAREA') {
                    if (element.type === 'date' || element.type === 'datetime-local') {
                        // Format date values through the formatDateTime() function
                        formData[element.name] = formatDateTime(element.value, 'd/m/Y H:i');
                    } else if (element.type === 'checkbox') {
                        // Handle checkboxes (true/false or checked value)
                        formData[element.name] = element.checked;
                    } else if (element.type === 'radio') {
                        // Handle radio buttons (only if selected)
                        if (element.checked) {
                            formData[element.name] = escapeHTML(element.value);
                        }
                    } else {
                        // Handle other input types
                        formData[element.name] = escapeHTML(element.value);
                    }
                }
            }
        }
    }

    return formData;
}

// Handle response from ajax call
function handleResponse(response){
    var responseStatus;
    if(response['success'] !== true){
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
        'data': JSON.stringify(response.data)
        //'data': response.data
    };
}

function handleResponseMsg(responseMsg, action=null, url=null){
    if (responseMsg.status === 'success'){
        if(action == 'reload'){ reloadPage(); }
        else if(action == 'redirect'){ goTo(url); }
        else if(action == 'goback'){ window.history.back(); }
        else if(action == 'confirmexit'){
            swal_confirm(responseMsg.message, "Save & Exit", "Stay on this page", true, "success")
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
            swal_confirm(responseMsg.message, "OKAY", null, false, 'success')
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
        else if(action == 'logdata'){ console.log(responseMsg.data); }
        
        else {swal_popup(responseMsg.status, responseMsg.message, 'Okay. Got it!');} //if any other action is set, alert the message and do nothing
    } else {
        swal_popup(responseMsg.status, responseMsg.message, 'Okay. Got it!');
        console.log(responseMsg.details); // remove for production
    }
}

function AJAXcall(type, url, btn, formData=null, callback){
    if(btn){submitButtonState('loading', btn);}

    let isFileUpload = formData instanceof FormData; // Detect if it's a file upload

    $.ajax({
        url: url,
        type: type,
        dataType: 'JSON',
        processData: !isFileUpload,  // Prevents jQuery from processing FormData
        contentType: isFileUpload ? false : 'application/json', // Handled automatically for FormData
        headers: isFileUpload ? {} : {
            "Authorization": `${auth_token}` // auth_token is provided from _auth.php
        },
        data: isFileUpload ? formData : JSON.stringify(formData),
        
        success: function(response){
            var responseMsg = handleResponse(response);

            if(callback) {
                callback(responseMsg); //use responseMsg in another function
            } else {
                handleResponseMsg(responseMsg); //send to the handleResponseMsg() fxn
            }

            if(btn){submitButtonState('enable', btn);}
        },
        
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            swal_popup('error', 'An error occurred during the request', 'Okay. Got it!');
            if (btn) { submitButtonState('enable', btn); }
        }
    });
}

function logout(sessionid){
    var url = "controllers/sessions.php?sessionid="+sessionid;
    AJAXcall('DELETE', url, null, null, (r)=>{
        if(r.status !== 'success'){
            swal_popup(r.status, r.message, 'Try Again!');
        } else {
            swal_popup(r.status, r.message, 'Got it!', (s)=>{
                location.href = auth_page; //from _auth file
            });
        }
    });
}

function deleteRecord(ajaxURL, btn=null){
    swal_confirm("Are you sure you want to delete this record? This cannot be undone!", "Yes, delete it.", "Mistake, cancel")
    .then((result) => {
        if (result.isConfirmed) {
            AJAXcall("DELETE", ajaxURL, btn, null, (r)=>{handleResponseMsg(r, 'confirmreload');});
        } else if (result.isDenied) {
            console.log("Cancelled");
        }
    })
    .catch((error) => {
        console.error("Error. Unable to delete:", error);
    });
}

//#######################//
//#### FRONT END FXN ####//
//#######################//
function statusState(status) {
    status = status.charAt(0).toUpperCase() + status.slice(1);
    switch (status) {
      case 'Not Started':
      case 'Pending':
        return 'warning';
      case 'In Progress':
      case 'Ongoing':
        return 'primary';
      case 'Failed':
      case 'Rejected':
        return 'danger';
      case 'Completed':
      case 'Active':
      case 'Approved':
        return 'success';
      case 'Inactive':
        return 'secondary';
      default:
        return 'info';
    }
}
  
function showStatus(status, display = 'block') {
    var state = statusState(status);
  
    if (display === 'text') {
      var html = '<span class="badge badge-dot bg-' + state + '">' + status + '</span>';
    } else {
      var html = '<span class="badge badge-sm badge-dim bg-outline-' + state + ' d-md-inline-flex">' + status + '</span>';
    }
  
    return html;
}

function copyToClipboard(copyContent='copyContent', copybtn='copyBtn') {
    // Select the text content
    const contentToCopy = document.querySelector('#'+copyContent);
    const copyBtn = document.querySelector('#'+copybtn);

    const range = document.createRange();
    range.selectNode(contentToCopy);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);

    // Copy to clipboard
    try {
        document.execCommand('copy');
        copyBtn.classList.remove('btn-primary');
        copyBtn.classList.add('btn-success');
        copyBtn.innerHTML = ' <em class="icon ni ni-check-circle"></em> copied';
    } catch (err) {
        console.error('Unable to copy text to clipboard', err);
    }

    // Deselect the text
    window.getSelection().removeAllRanges();
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
    fetch('models/data/city-state-country.json')
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

    fetch('models/data/city-state-country.json')
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