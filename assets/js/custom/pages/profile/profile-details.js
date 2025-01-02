"use strict";

// Class definition
var ProfileDetails = function () {
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
                    username: {
                        validators: {
                            notEmpty: {
                                message: 'Username is required'
                            }
                        }
                    },
                    fullname: {
                        validators: {
                            notEmpty: {
                                message: 'Full name is required'
                            }
                        }
                    },
                    phone: {
                        validators: {
                            notEmpty: {
                                message: 'Contact phone number is required'
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
                    AJAXcall(formID, submitButton, 'PATCH', 'controllers/users.php?userid='+parseInt(userid));
                    //setTimeout(reloadPage(), 3000);
                    
                } else {
                    swal_Popup('error', 'Sorry, some errors were detected, please try again.', 'Try Again!');
                }
            });
        });
    }

    // Public methods
    return {
        init: function () {
            formID = '#account_profile_details_form';
            form = document.querySelector(formID);
            submitButton = form.querySelector('#account_profile_details_submit');

            initValidation();
            handleForm();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    ProfileDetails.init();
});
