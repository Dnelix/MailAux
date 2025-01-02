"use strict";

// Class definition
var bizDetails = function () {
    // Private variables
    var formID;
    var form;
    var submitButton;
    var validation;

    // Private functions
    var initValidation = function () {
        validation = FormValidation.formValidation(
            form,
            {
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Business name is required'
                            }
                        }
                    },
                    description: {
                        validators: {
                            notEmpty: {
                                message: 'Please provide a brief description for your business'
                            }
                        }
                    },
                    phone: {
                        validators: {
                            notEmpty: {
                                message: 'A contact phone number is required'
                            },
                            numeric: {
                                message: 'The value is not a number'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'An email address is required for communication'
                            }
                        }
                    },
                    address: {
                        validators: {
                            notEmpty: {
                                message: 'A business address is required'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

    }

    var handleForm = function () {
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    
                    var userid = form.querySelector('[name="userid"]').value;
                    
                    //photo
                    var imgid = form.querySelector('[name="imgid"]').value;
                    var imgidQuery = (imgid == "") ? "" : "&imageid="+parseInt(imgid);
                    var imageFieldName = 'photo';
                    var imgurl = 'controllers/images.php?userid='+parseInt(userid)+'&refid='+parseInt(userid)+imgidQuery;
                    var attributes = {filename:imageFieldName, title:'Business profile', type:'photo'};

                    if (form.querySelector('[name="'+imageFieldName+'"]').value !== ''){
                        var imageData = getUploadData(imageFieldName, attributes);
                        AJAXUploadImg(imgurl, "POST", imageData, submitButton, (responseMsg)=>{handleResponseMsg(responseMsg);});
                    }

                    //form
                    var url = 'controllers/business.php?userid='+parseInt(userid);
                    var formData = formdataJSON(form);
                    AJAXcall(null, submitButton, 'PATCH', url, formData, (responseMsg)=>{handleResponseMsg(responseMsg, 'reload');} );
                    
                } else {
                    swal_Popup('error', 'Sorry, some important information missing. Please complete', 'Try Again!');
                }
            });
        });
    }

    // Public methods
    return {
        init: function () {
            formID = '#business_details_form';
            form = document.querySelector(formID);
            submitButton = form.querySelector('#business_details_submit');

            initValidation();
            handleForm();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    bizDetails.init();
});
