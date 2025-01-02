"use strict";

var SignupGeneral = function() {
    var form;
    var submitButton;
    var validator;
    var passwordMeter;
    // specify form action URL
    var formActionURL = 'controllers/users.php';

    // Handle form
    var handleForm  = function(e) {

        validator = FormValidation.formValidation(
			form,
			{
				fields: {
					'biz-name': {
						validators: {
							notEmpty: {
								message: 'Please provide your business name'
							}
						}
                    },
                    'phone-number': {
						validators: {
                            numeric: {
                                message: 'The value is not a number'
                            }
						}
					},
					'email': {
                        validators: {
							notEmpty: {
								message: 'Email address is required'
							},
                            emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					},
                    'password': {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            },
                            callback: {
                                message: 'Your password does not meet the complexity requirements',
                                callback: function(input) {
                                    if (input.value.length > 0) {
                                        return validatePassword();
                                    }
                                }
                            }
                        }
                    },
                    /*'confirm-password': {
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
                    },*/
                    'toc': {
                        validators: {
                            notEmpty: {
                                message: 'You must accept the terms and conditions'
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

        // Identify form fields
        var bizNameField = form.querySelector('[name="biz-name"]');
        var phoneNumberField = form.querySelector('[name="phone-number"]');
        var emailField = form.querySelector('[name="email"]');
        var passwordField = form.querySelector('[name="password"]');
        var acceptTermsField = form.querySelector('[name="toc"]');
        
        // Handle form submit
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validator.revalidateField('password');

            validator.validate().then(function(status) {
		        if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    var params = {
                        bizname: bizNameField.value,
                        phone: phoneNumberField.value,
                        email: emailField.value,
                        password: passwordField.value,
                        accept_terms: acceptTermsField.checked
                    };

                    //console.log(params); return false;

                    $.ajax({
                        url: formActionURL,
                        type: 'POST',
                        dataType: 'JSON',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        data: JSON.stringify(params),
                        success: function(response){
                            submitButton.removeAttribute('data-kt-indicator'); // Hide loading indication
                            submitButton.disabled = false; // Enable button

                            // handle response
                            if(response['statusCode'] !== 201 && response['success'] !== true){
                                var responseMessage = "ERROR: "+response.messages[0];
                                //var responseMessage = "ERROR: "+JSON.stringify(response);

                                Swal.fire({
                                    text: responseMessage,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Try Again",
                                    customClass: {
                                        confirmButton: "btn btn-danger"
                                    }
                                });
                            } else {
                                Swal.fire({
                                    text: "Account created successfully. Proceed to login",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Login Now!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    },
                                    timer: "1500"
                                }).then(function () {
                                        form.reset();  // reset form  
                                                                    
                                        // form.submit(); // submit form
                                        var redirectUrl = form.getAttribute('data-kt-redirect-url');
                                        if (redirectUrl) {
                                            location.href = redirectUrl+'&uid='+response.data['user_id'];
                                        }
                                });
                            }
                        }
                    });
  						
                } else {
                    Swal.fire({
                        text: "Oops! You have some error in the form, please review and try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
		    });
        });

        // Handle password input
        passwordField.addEventListener('input', function() {
            if (this.value.length > 0) {
                validator.updateFieldStatus('password', 'NotValidated');
            }
        });
    }

    // Password input validation
    var validatePassword = function() {
        return  (passwordMeter.getScore() >= 50);
    }

    // Public functions
    return {
        // Initialization
        init: function() {
            form = document.querySelector('#sign_up_form');
            submitButton = document.querySelector('#sign_up_submit');
            passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));

            handleForm ();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    SignupGeneral.init();
});
