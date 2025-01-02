"use strict";

// Class definition
var addProject = function () {
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
                    title: {
                        validators: {
                            notEmpty: {
                                message: 'Project title is required'
                            }
                        }
                    },
                    start_date: {
                        validators: {
                            notEmpty: {
                                message: 'A start date is required'
                            }
                        }
                    },
                    end_date: {
                        validators: {
                            notEmpty: {
                                message: 'Please specify when this task is due'
                            }
                        }
                    },
                    style_catg: {
                        validators: {
                            notEmpty: {
                                message: 'Please select a category for the project'
                            }
                        }
                    },
                    income: {
                        validators: {
                            notEmpty: {
                                message: 'Enter your fees for this project. You can update this later'
                            },
                            numeric: {
                                message: 'Only numbers are accepted'
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

                    //extract all form elements
                    var formData = formdataJSON(form);
                    //console.log(formData);
                    
                    //var tailorid = formData['tailorid'];
                    AJAXcall(null, submitButton, 'POST', 'controllers/projects.php', formData, (responseMsg)=>{handleResponseMsg(responseMsg, 'goback');});
                    
                } else {
                    swal_Popup('error', 'Sorry, some important information missing. Please complete', 'Try Again!');
                }
            });
        });
    }

    // Public methods
    return {
        init: function () {
            formID = '#project_details_form';
            form = document.querySelector(formID);
            submitButton = form.querySelector('#project_details_submit');

            initValidation();
            handleForm();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    addProject.init();
});
