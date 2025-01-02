"use strict";

// Class definition
var ModalAddLB = function () {
	var nextButton;
	var previousButton;
	var validator;
	var form;
	var stepper;

	/* Private functions
	var initForm = function() {
		var dueDate = $(form.querySelector('[name="details_activation_date"]'));
		dueDate.flatpickr({
			enableTime: true,
			dateFormat: "d, M Y, H:i",
		});

        $(form.querySelector('[name="details_customer"]')).on('change', function() {
            validator.revalidateField('details_customer');
        });
	}*/

	var handleForm = function() {
		nextButton.addEventListener('click', function (e) {
			e.preventDefault();

			nextButton.disabled = true;
			nextButton.setAttribute('data-kt-indicator', 'on');

			// Simulate form submission
			setTimeout(function() {
				// Simulate form submission
				nextButton.removeAttribute('data-kt-indicator');

				// Enable button
				nextButton.disabled = false;
				
				// Go to next step
				stepper.goNext();
			}, 1500);

		});

		previousButton.addEventListener('click', function () {
			stepper.goPrevious();
		});
	}

	return {
		// Public functions
		init: function () {
			form = AddMeasures.getForm();
			stepper = AddMeasures.getStepperObj();
			nextButton = AddMeasures.getStepper().querySelector('[data-kt-element="details-next"]');
			previousButton = AddMeasures.getStepper().querySelector('[data-kt-element="details-previous"]');

			// initForm();
			// initValidation();
			handleForm();
		}
	};
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
	window.ModalAddLB = module.exports = ModalAddLB;
}