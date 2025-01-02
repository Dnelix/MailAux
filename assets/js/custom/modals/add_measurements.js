"use strict";

var AddMeasures = function () {
    // Private variables
	var stepper;
	var stepperObj;
	var form;	

	// Private functions
	var initStepper = function () {
		stepperObj = new KTStepper(stepper);
	}

	return {
		// Public functions
		init: function () {
			stepper = document.querySelector('#add_measures_stepper');
			form = document.querySelector('#add_new_measures_form');

			initStepper();
		},

		getStepper: function () {
			return stepper;
		},

		getStepperObj: function () {
			return stepperObj;
		},
		
		getForm: function () {
			return form;
		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	if (!document.querySelector('#modal_add_measurements')) {
		return;
	}

    AddMeasures.init();
    ModalAddUB.init();
    ModalAddLB.init();
    ModalComplete.init();
});

// Webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
	window.AddMeasures = module.exports = AddMeasures;
}