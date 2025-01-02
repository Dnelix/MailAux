"use strict";

// Class definition
var DeactivateAccount = function () {
    // Private variables
    var formID;
    var form;
    var validation;
    var submitButton;

    // Private functions
    var initValidation = function () {
        validation = FormValidation.formValidation(
            form,
            {
                fields: {
                    deactivate: {
                        validators: {
                            notEmpty: {
                                message: 'Please check the box to deactivate your account'
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

                    swal_confirm("Are you sure you would like to deactivate your account?")
                    .then((result) => {
                        if (result.isConfirmed) {
                            
                            var userid = form.querySelector('[name="userid"]').value;
                            AJAXcall(formID, submitButton, 'PATCH', 'controllers/users.php?userid='+parseInt(userid));
                            setTimeout(reloadPage(), 5000);
                        } else if (result.isDenied) {
                            swal_Popup('info', 'Account not deactivated.', 'OK');
                        }
                    });

                } else {
                    //swal_Popup('error', 'Sorry, some errors were detected, kindly fix and try again.', 'Try Again!');
                }
            });
        });
    }

    // Public methods
    return {
        init: function () {
            formID = '#account_deactivate_form';
            form = document.querySelector(formID);
            submitButton = document.querySelector('#account_deactivate_submit');

            initValidation();
            handleForm();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    DeactivateAccount.init();
});
