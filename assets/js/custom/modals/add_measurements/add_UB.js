"use strict";

// Class definition
var ModalAddUB = function () {
	var nextButton;
	var form;
	var stepper;

	var handleForm = function() {
		nextButton.addEventListener('click', function (e) {
			e.preventDefault();

			nextButton.disabled = true;
			nextButton.setAttribute('data-kt-indicator', 'on');

			// Simulate form submission
			setTimeout(function() {
				nextButton.removeAttribute('data-kt-indicator');
				nextButton.disabled = false;
				
				// Go to next step
				stepper.goNext();
			}, 1000);
			
		});
	}

	return {
		// Public functions
		init: function () {
			form = AddMeasures.getForm();
			stepper = AddMeasures.getStepperObj();
			nextButton = AddMeasures.getStepper().querySelector('[data-kt-element="type-next"]');

			handleForm();
		}
	};
}();

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
	window.ModalAddUB = module.exports = ModalAddUB;
}