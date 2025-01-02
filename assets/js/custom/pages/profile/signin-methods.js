"use strict";

// Class definition
var SigninMethods = function () {
    // Private functions
    var initSettings = function () {

        // UI elements
        var usernameMainEl = document.getElementById('kt_signin_username');
        var usernameEditEl = document.getElementById('kt_signin_username_edit');
        var signInMainEl = document.getElementById('kt_signin_email');
        var signInEditEl = document.getElementById('kt_signin_email_edit');
        var passwordMainEl = document.getElementById('kt_signin_password');
        var passwordEditEl = document.getElementById('kt_signin_password_edit');

        // button elements
        var usernameChange = document.getElementById('kt_signin_user_button');
        var usernameCancel = document.getElementById('kt_uname_cancel');
        var signInChangeEmail = document.getElementById('kt_signin_email_button');
        var signInCancelEmail = document.getElementById('kt_signin_cancel');
        var passwordChange = document.getElementById('kt_signin_password_button');
        var passwordCancel = document.getElementById('kt_password_cancel');

        // toggle UI
        usernameChange.querySelector('button').addEventListener('click', function () {
            toggleChangeUsername();
        });
        usernameCancel.addEventListener('click', function () {
            toggleChangeUsername();
        });

        signInChangeEmail.querySelector('button').addEventListener('click', function () {
            toggleChangeEmail();
        });
        signInCancelEmail.addEventListener('click', function () {
            toggleChangeEmail();
        });

        passwordChange.querySelector('button').addEventListener('click', function () {
            toggleChangePassword();
        });
        passwordCancel.addEventListener('click', function () {
            toggleChangePassword();
        });

        var toggleChangeUsername = function () {
            usernameMainEl.classList.toggle('d-none');
            usernameChange.classList.toggle('d-none');
            usernameEditEl.classList.toggle('d-none');
        }

        var toggleChangeEmail = function () {
            signInMainEl.classList.toggle('d-none');
            signInChangeEmail.classList.toggle('d-none');
            signInEditEl.classList.toggle('d-none');
        }

        var toggleChangePassword = function () {
            passwordMainEl.classList.toggle('d-none');
            passwordChange.classList.toggle('d-none');
            passwordEditEl.classList.toggle('d-none');
        }
    }

    var handleChangeUsername = function (e) {
        var validation;

        // form elements
        var formID = '#kt_signin_change_username';
        var signInForm = document.querySelector(formID);
        var submitButton = signInForm.querySelector('#kt_uname_submit');
        var userid = signInForm.querySelector('[name="userid"]').value;

        validation = FormValidation.formValidation(
            signInForm,
            {
                fields: {
                    username: {
                        validators: {
                            notEmpty: {
                                message: 'Username is required'
                            }
                        }
                    },

                    confirmuserpassword: {
                        validators: {
                            notEmpty: {
                                message: 'Password is required'
                            }
                        }
                    }
                },

                plugins: { //Learn more: https://formvalidation.io/guide/plugins
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
                }
            }
        );

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            //console.log('click');

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    
                    async function executeSequence() {
                        await AJAXcall(formID, submitButton, 'PATCH', 'controllers/users.php?userid='+parseInt(userid));
                        await signInForm.reset();
                        await validation.resetForm(); // Reset formvalidation
                    }
                    executeSequence();
                    
                } else {
                    //swal_Popup('error', 'Sorry, some errors were detected, please try again.', 'Ok. Got it!');
                }
            });
        });
    }

    var handleChangeEmail = function (e) {
        var validation;

        // form elements
        var formID = '#kt_signin_change_email';
        var signInForm = document.querySelector(formID);
        var submitButton = signInForm.querySelector('#kt_signin_submit');
        var userid = signInForm.querySelector('[name="userid"]').value;

        validation = FormValidation.formValidation(
            signInForm,
            {
                fields: {
                    emailaddress: {
                        validators: {
                            notEmpty: {
                                message: 'Email is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            }
                        }
                    },

                    confirmemailpassword: {
                        validators: {
                            notEmpty: {
                                message: 'Password is required'
                            }
                        }
                    }
                },

                plugins: { //Learn more: https://formvalidation.io/guide/plugins
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
                }
            }
        );

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            //console.log('click');

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    
                    async function executeSequence() {
                        await AJAXcall(formID, submitButton, 'PATCH', 'controllers/users.php?userid='+parseInt(userid));
                        await signInForm.reset();
                        await validation.resetForm(); // Reset formvalidation
                    }
                    executeSequence();
                    
                } else {
                    //swal_Popup('error', 'Sorry, some errors were detected, please try again.', 'Ok. Got it!');
                }
            });
        });
    }

    var handleChangePassword = function (e) {
        var validation;

        // form elements
        var formID = '#kt_signin_change_password';
        var passwordForm = document.querySelector(formID);
        var submitButton = passwordForm.querySelector('#kt_password_submit');
        var userid = passwordForm.querySelector('[name="userid"]').value;

        validation = FormValidation.formValidation(
            passwordForm,
            {
                fields: {
                    currentpassword: {
                        validators: {
                            notEmpty: {
                                message: 'Current Password is required'
                            }
                        }
                    },

                    newpassword: {
                        validators: {
                            notEmpty: {
                                message: 'New Password is required'
                            }
                        }
                    },

                    confirmpassword: {
                        validators: {
                            notEmpty: {
                                message: 'Confirm Password is required'
                            },
                            identical: {
                                compare: function() {
                                    return passwordForm.querySelector('[name="newpassword"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    },
                },

                plugins: { //Learn more: https://formvalidation.io/guide/plugins
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
                }
            }
        );

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            //console.log('click');

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    AJAXcall(formID, submitButton, 'PATCH', 'controllers/users.php?userid='+parseInt(userid))
                    .then(function(){
                        passwordForm.reset();
                        validation.resetForm(); // Reset formvalidation 
                    });
                } else {
                    //swal_Popup('error', 'Sorry, some errors were detected, please try again.', 'Ok. Got it!');
                }
            });
        });
    }

    // Public methods
    return {
        init: function () {
            initSettings();
            handleChangeUsername();
            handleChangeEmail();
            handleChangePassword();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    SigninMethods.init();
});
