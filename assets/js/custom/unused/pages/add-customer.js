"use strict";

// Class definition
var AddCustomer = function () {
	// Elements
	var modal;	
	var modalEl;

	var stepper;
	var form;
	var formSubmitButton;
	var formContinueButton;

	// Variables
	var stepperObj;
	var validations = [];

	// specify form action URL
    var formActionURL = 'models/scripts/addCustomer.php';

	// Private Functions
	/*var parseStep1Data = function () {
		var bodySize;
		var measureUnit;
		var bodySizeGroup = form.querySelectorAll('[name="body_size"]');
		var measureUnitGroup = form.querySelectorAll('[name="measurement_unit"]');

		var upperBodyForm = form.querySelector("#upperBodyForm");
		
		for (var i = 0; i < bodySizeGroup.length; i++) {
			bodySizeGroup[i].addEventListener('change', function (e) {
				bodySize = form.querySelector('[name="body_size"]:checked').value;
				measureUnit = form.querySelector('[name="measurement_unit"]:checked').value;

				fetch("scripts/databases/measurement_UB.json")
				.then(response => response.json())
				.then(data => {
					for (let i = 0; i < data.length; i++) {
						for (let j = 0; j < data[i].length; j++) {
							upperBodyForm.innerHTML = data[i][j];
						}
					}
				})
				.catch(error => {
					upperBodyForm.innerHTML = error;
				});
			});
		}

		for (var i = 0; i < measureUnitGroup.length; i++) {
			measureUnitGroup[i].addEventListener('change', function (e) {
				bodySize = form.querySelector('[name="body_size"]:checked').value;
				measureUnit = form.querySelector('[name="measurement_unit"]:checked').value;
				alert(bodySize + " : " + measureUnit);
			});
		}
	}*/

	var initStepper = function () {
		// Initialize Stepper
		stepperObj = new KTStepper(stepper);

		// Stepper change event
		stepperObj.on('kt.stepper.changed', function (stepper) {
			if (stepperObj.getCurrentStepIndex() === 3) {
				formSubmitButton.classList.remove('d-none');
				formSubmitButton.classList.add('d-inline-block');
				formContinueButton.classList.add('d-none');
			} else if (stepperObj.getCurrentStepIndex() === 4) {
				formSubmitButton.classList.add('d-none');
				formContinueButton.classList.add('d-none');
			} else {
				formSubmitButton.classList.remove('d-inline-block');
				formSubmitButton.classList.remove('d-none');
				formContinueButton.classList.remove('d-none');
			}
		});

		// Validation before going to next page
		stepperObj.on('kt.stepper.next', function (stepper) {
			console.log('stepper.next');

			// Validate form before change stepper step
			var validator = validations[stepper.getCurrentStepIndex() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {
						stepper.goNext();

						KTUtil.scrollTop();
					} else {
						Swal.fire({
							text: "Oops! You have some error in the form, please review and try again.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn btn-light"
							}
						}).then(function () {
							KTUtil.scrollTop();
						});
					}
				});
			} else {
				stepper.goNext();

				KTUtil.scrollTop();
			}
		});

		// Prev event
		stepperObj.on('kt.stepper.previous', function (stepper) {
			console.log('stepper.previous');

			stepper.goPrevious();
			KTUtil.scrollTop();
		});
	}

	var handleForm = function() {

		formSubmitButton.addEventListener('click', function (e) {
			// Validate form before change stepper step
			var validator = validations[0]; // get validator for last form (use 0 for first page, etc)

			validator.validate().then(function (status) {
				if (status == 'Valid') {
					e.preventDefault();
					formSubmitButton.disabled = true;
					// Show loading indication
					formSubmitButton.setAttribute('data-kt-indicator', 'on');

					// form submission
					setTimeout(function() {
						handleFormSubmit();
						formSubmitButton.removeAttribute('data-kt-indicator');
						formSubmitButton.disabled = false;
						stepperObj.goNext();
						//KTUtil.scrollTop();
					}, 2000);

				} else {
					Swal.fire({
						text: "Sorry, looks like there are some errors detected, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-light"
						}
					}).then(function () {
						KTUtil.scrollTop();
					});
				}
			});
		});

		/* Expiry month. For more info, plase visit the official plugin site: https://select2.org/
        $(form.querySelector('[name="card_expiry_month"]')).on('change', function() {
            // Revalidate the field when an option is chosen
            validations[3].revalidateField('card_expiry_month');
        });

		// Expiry year. For more info, plase visit the official plugin site: https://select2.org/
        $(form.querySelector('[name="card_expiry_year"]')).on('change', function() {
            // Revalidate the field when an option is chosen
            validations[3].revalidateField('card_expiry_year');
        });

		// Expiry year. For more info, plase visit the official plugin site: https://select2.org/
        $(form.querySelector('[name="business_type"]')).on('change', function() {
            // Revalidate the field when an option is chosen
            validations[2].revalidateField('business_type');
        });*/

		// custPhoneField.addEventListener('change', function() {
        //     if (this.value.length > 0) {
		// 		formContinueButton.disabled = true;
		// 		formContinueButton.innerHTML = 'Please wait...';

		// 		var data = {
		// 			phone : this.value
		// 		};
		// 		$.ajax({
		// 			url: formActionURL,
		// 			type: 'POST',
		// 			data: JSON.stringify(data),
		// 			contentType: 'application/json',
		// 			success: function(response) {
		// 			  console.log(response);
		// 			  return true;
		// 			},
		// 			error: function(xhr, status, error) {
		// 			  console.error('Request failed. Status: ' + status + ', Error: ' + error);
		// 			  return false;
		// 			}
		// 		});
        //     }
        // });
	}

	var initValidation = function () {
		// Step 1
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					'customer_name': {
						validators: {
							notEmpty: {
								message: 'Customer name is required'
							}
						}
					},
					'customer_phone': {
						validators: {
							notEmpty: {
								message: 'A phone number is required'
							},
                            numeric: {
                                message: 'The value is not a number'
                            },
							callback: {
								message: 'Please enter a valid phone number',
								callback: function(input) {
									if (input.value.length > 0) {
										return validateUserByPhone(input.value);
									}
								}
							}
						}
					},
					'customer_email' : {
						validators: {
							emailAddress: {
								message: 'Invalid email address'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
					})
				}
			}
		));

		/* Step 2
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					'account_team_size': {
						validators: {
							notEmpty: {
								message: 'Time size is required'
							}
						}
					},
					'account_name': {
						validators: {
							notEmpty: {
								message: 'Account name is required'
							}
						}
					},
					'account_plan': {
						validators: {
							notEmpty: {
								message: 'Account plan is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
					})
				}
			}
		));*/
	}

	var handleFormSubmit = function() {
		// Identify form fields
		var custNameField = form.querySelector('[name="customer_name"]');
		var custPhoneField = form.querySelector('[name="customer_phone"]');
		var custEmailField = form.querySelector('[name="customer_email"]');

		
		// Ajax Request
		FormValidation.utils.fetch(formActionURL, {
			method: 'POST',
			params: {
				name: custNameField.value,
				phone: custPhoneField.value,
				email: custEmailField.value
			}
		}).then(function(response) {
			//alert ('it worked --- '+JSON.stringify(response));
			
			// Hide loading indication
			submitButton.removeAttribute('data-kt-indicator');
			// Enable button
			submitButton.disabled = false;

			// handle response
			if(response !== "success"){
				var responseMessage = "ERROR: "+JSON.stringify(response);

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
					text: "You have successfully logged in. Click to proceed",
					icon: "success",
					buttonsStyling: false,
					confirmButtonText: "Proceed to dashboard",
					customClass: {
						confirmButton: "btn btn-primary"
					},
					timer: "1000"
				}).then(function () {
					 
						form.reset();  // reset form  
													  
						// form.submit(); // submit form
						var redirectUrl = form.getAttribute('data-kt-redirect-url');
						if (redirectUrl) {
							location.href = redirectUrl;
						}
				});
			}
			
		});
		
	}

	var validateUserByPhone = function (phone) {
		if(phone.length >= 10){
			return true;
		}
		else return false;
	}

	return {
		// Public Functions
		init: function () {
			// Elements
			modalEl = document.querySelector('#kt_modal_create_account');
			if (modalEl) {
				modal = new bootstrap.Modal(modalEl);	
			}					

			stepper = document.querySelector('#add_customer_stepper');
			form = stepper.querySelector('#add_customer_form');
			formSubmitButton = stepper.querySelector('[data-kt-stepper-action="submit"]');
			formContinueButton = stepper.querySelector('[data-kt-stepper-action="next"]');

			initStepper();
			initValidation();
			handleForm();
			//parseStep1Data();
		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    AddCustomer.init();
});