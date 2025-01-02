"use strict";

// Class definition
var ModalNewProject = function () {
	var submitButton;
	var cancelButton;
	var validator;
	var form;
	var modal;
	var modalEl;

	var formID = '#modal_new_project_form';

	// Init form inputs
	var initForm = function() {
		// Tags. For more info, please visit the official plugin site: https://yaireo.github.io/tagify/
		var tags = new Tagify(form.querySelector('[name="customer"]'), {
			whitelist: ["Felix", "Urgent", "High", "Medium", "Low"],
			maxTags: 1,
			dropdown: {
				maxItems: 10,           // <- mixumum allowed rendered suggestions
				enabled: 0,             // <- show suggestions on focus
				closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
			}
		});
		tags.on("change", function(){
			// Revalidate the field when an option is chosen
            validator.revalidateField('tags');
		});

	}

	// Handle form validation and submittion
	var handleForm = function() {
		validator = FormValidation.formValidation(
			form,
			{
				fields: {
					customer: {
						validators: {
							notEmpty: {
								message: 'Please select a customer'
							}
						}
					},
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
		);

		// Action buttons
		submitButton.addEventListener('click', function (e) {
			e.preventDefault();

			if (validator) {
				validator.validate().then(function (status) {
					//console.log('validated!');

					if (status == 'Valid') {
						var responseMessage;
						submitButton.setAttribute('data-kt-indicator', 'on');
						submitButton.disabled = true;

						$.ajax({
							url: 'controllers/customers.php',
							type: 'POST',
							dataType: 'JSON',
							headers: {'Content-Type': 'application/json'},
							data: JSON.stringify(serializeToJSON(form)),
							success: function(response){
								if(response['success'] !== true){
									responseMessage = "ERROR: "+JSON.stringify(response);
									swal_Popup('error', responseMessage, 'Okay. Got it!');
									submitButton.disabled = false;
									submitButton.setAttribute('data-kt-indicator', 'off');
								} else {
									responseMessage = "SUCCESS: "+JSON.stringify(response);
									submitButton.disabled = false;
									submitButton.setAttribute('data-kt-indicator', 'off');
									form.reset();
									$(formID).toggleClass('d-none');
									$(successWinID).toggleClass('d-none');
								}
							}
						}); 						
					} else {
						//swal_Popup('error', 'Some required items are missing');
					}
				});
			}
		});

		cancelButton.addEventListener('click', function (e) {
			e.preventDefault();

			swal_confirm("Are you sure you would like to cancel?", "Yes, cancel and exit", "No, return")
			.then(function (result) {
				if (result.value) {
					form.reset(); // Reset form	
					modal.hide(); // Hide modal				
				} else if (result.dismiss === 'cancel') {
					swal_Popup('success', 'Not cancelled. Continue creating project');
				}
			});
		});
	}

	return {
		// Public functions
		init: function () {
			modalEl = document.querySelector('#modal_new_project');

			if (!modalEl) {
				return;
			}

			modal = new bootstrap.Modal(modalEl);

			form = document.querySelector(formID);
			submitButton = document.getElementById('modal_new_project_submit');
			cancelButton = document.getElementById('modal_new_project_cancel');

			initForm();
			handleForm();
		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	ModalNewProject.init();
});