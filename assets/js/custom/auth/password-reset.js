"use strict";

// Class definition
var PasswordResetGeneral = function() {
    // Elements
    var form;
    var submitButton;
    var validator;

    // Handle form
    var handleForm = function(e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
			form,
			{
				fields: {					
					'email': {
                        validators: {
							notEmpty: {
								message: 'Please provide your email or username'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
				}
			}
		);

        // Identify form fields
        var emailField = form.querySelector('[name="email"]');

        // Handle form submit
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            // Validate form
            validator.validate().then(function (status) {
                if (status == 'Valid') {

                    var url = 'controllers/users.php?reset&data='+ emailField.value;

                    AJAXcall(null, submitButton, 'GET', url, null, (responseMsg)=>{
                        if(responseMsg.status !== 'success'){
                          swal_Popup(responseMsg.status, responseMsg.message);
                          return false; 
                        } else {
                            var msg = "We have sent a mail to <b>"+ emailField.value +"</b>. <br/>Kindly click the link in the email to reset your password. Remember to check your spam box if you cannot find the mail";
                            swal_Popup('success', msg);
                        }
                    });
					
                } else {
                    swal_Popup('error', 'Sorry, some errors were detected, please try again.', 'Try Again!');
                }
            });
		});
    }

    // Public functions
    return {
        // Initialization
        init: function() {
            form = document.querySelector('#password_reset_form');
            submitButton = document.querySelector('#password_reset_submit');
            
            handleForm();
        }
    };

}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    PasswordResetGeneral.init();
});
