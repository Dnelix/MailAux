"use strict";

// Class Definition
var PasswordResetNewPassword = function() {
    // Elements
    var form;
    var submitButton;
    var validator;
    var passwordMeter;

    var handleForm = function(e) {
        validator = FormValidation.formValidation(
			form,
			{
				fields: {					 
                    'password': {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            },
                            callback: {
                                message: 'Please choose a stronger password',
                                callback: function(input) {
                                    if (input.value.length > 0) {        
                                        return validatePassword();
                                    }
                                }
                            }
                        }
                    },
                    'confirmpassword': {
                        validators: {
                            notEmpty: {
                                message: 'The password confirmation is required'
                            },
                            identical: {
                                compare: function() {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    }
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: false
                        }  
                    }),
					bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
				}
			}
		);


        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validator.revalidateField('password');

            validator.validate().then(function(status) {
		        if (status == 'Valid') {

                    var formData = formdataJSON(form);

                    // Identify relevant fields and create url
                    var usr = form.querySelector('[name="usr"]').value;
                    var url = 'controllers/users.php?reset&data='+ usr;

                    AJAXcall(null, submitButton, 'PATCH', url, formData, (responseMsg)=>{
                        if(responseMsg.status !== 'success'){
                          swal_Popup(responseMsg.status, responseMsg.message);
                          return false; 
                        } else {
                            var redirectUrl = form.getAttribute('data-redirect-url');
                            var redirectURL = (!redirectUrl || redirectUrl == '') ? 'home/' : redirectUrl;
                            handleResponseMsg(responseMsg, 'confirmredirect', redirectURL);
                        }
                    });

                } else {
                    swal_Popup('error', 'Sorry, some errors were detected, please try again.', 'Try Again!');
                }
		    });
        });

        form.querySelector('input[name="password"]').addEventListener('input', function() {
            if (this.value.length > 0) {
                validator.updateFieldStatus('password', 'NotValidated');
            }
        });
    }

    var validatePassword = function() {
        return  (passwordMeter.getScore() >= 50);
    }

    // Public Functions
    return {
        init: function() {
            form = document.querySelector('#new_password_form');
            submitButton = document.querySelector('#new_password_submit');
            passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    PasswordResetNewPassword.init();
});
