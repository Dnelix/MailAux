<?php
	$bs = 's6';
	$UB = retrieveDataFrom('models/databases/measurement_UB.json');
	$LB = retrieveDataFrom('models/databases/measurement_LB.json');

?>
	<div class="modal fade" id="modal_add_measurements" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered mw-1000px">
			<div class="modal-content">
				<div class="modal-header py-7 d-flex justify-content-between">
					<h2>Add Measurements</h2>
					<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<?= $svg_exiticon; ?>
					</div>
				</div>
				
				<div class="modal-body scroll-y m-5">
					<div class="stepper stepper-links d-flex flex-column" id="add_measures_stepper">
						<div class="stepper-nav justify-content-center py-2">
							<div class="stepper-item me-5 me-md-15 current" data-kt-stepper-element="nav">
								<h3 class="stepper-title">Upper Body</h3>
							</div>
							<div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
								<h3 class="stepper-title">Lower Body</h3>
							</div>
							<!--div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
								<h3 class="stepper-title">Finalize</h3>
							</div-->
							<div class="stepper-item" data-kt-stepper-element="nav">
								<h3 class="stepper-title">Completed</h3>
							</div>
						</div>
						
						<!--begin::Form-->
						<form class="mx-auto mw-500px w-100 pt-15 pb-10" novalidate="novalidate" id="add_new_measures_form">
							
							<input type="hidden" name="customer" id="modal_cid" value="" /> <!-- FIX THIS! -->

							<div class="current" data-kt-stepper-element="content">
								<div class="w-100">
									<div class="mb-13">
										<h2 class="mb-3">Upper Body Measurements 
											<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Your upper body measurements include measurements for shirts, tops, gowns, jackets etc. You should get someone else to measure you."></i>
										</h2>
										<div class="text-muted fs-7">
											Check the tips for each field if you're unsure how to measure correctly.
											<br/>All measurements MUST be done in <?= strtoupper($measureunit_text)." (".$measureunit.")"; ?>
										</div>
									</div>
									<div class="fv-row mb-15">
										<div class="row g-9">

										<?php
											foreach ($UB as $data){
										?>
												<div class="col-6 mb-2">
													<label class="fs-6 fw-bold form-label">
														<?= $data->label . '(' . $measureunit . ')';  ?> 
														<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="<?= $data->tooltip; ?>"></i>
													</label>
													<input type="number" name="<?= $data->name;  ?>" class="form-control form-control-lg form-control-solid" placeholder="0.0" />
													<!--div class="form-text fs-8">Range:  <span class="text-primary"><?//= $data->sizes->$bs . $measureunit; ?></span> </div-->
												</div>

										<?php
											}
										?>

										</div>
									</div>
									<div class="d-flex justify-content-end">
										<button type="button" class="btn btn-lg btn-primary" data-kt-element="type-next">
											<?= displayLoadingIcon('Lower Body Measurements'); ?>
										</button>
									</div>
								</div>
							</div>
							
							<div data-kt-stepper-element="content">
								<div class="w-100">
									<div class="mb-13">
										<h2 class="mb-3">Lower Body Measurements
											<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Your lower body measurements include measurements for trousers, skirts, shorts, etc. You can get someone else to measure you."></i>
										</h2>
										<div class="text-muted fs-7">
											Check the tips for each field if you're unsure how to measure correctly.
											<br/>All measurements MUST be done in <?= strtoupper($measureunit_text)." (".$measureunit.")"; ?>
										</div>
									</div>

									<div class="fv-row mb-15">
										<div class="row g-9">

										<?php
											foreach ($LB as $data){
										?>
												<div class="col-6 mb-2">
													<label class="fs-6 fw-bold form-label">
														<?= $data->label . '(' . $measureunit . ')';  ?> 
														<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="<?= $data->tooltip; ?>"></i>
													</label>
													<input type="number" name="<?= $data->name;  ?>" class="form-control form-control-lg form-control-solid" placeholder="0.0" />
													<!--div class="form-text fs-8">Range:  <span class="text-primary"><?//= $data->sizes->$bs . $measureunit; ?></span> </div-->
												</div>

										<?php
											}
										?>

										</div>
									</div>
									
									<div class="d-flex flex-stack">
										<button type="button" class="btn btn-lg btn-dark me-3" data-kt-element="details-previous">Upper Body Measurements </button>
										<button type="button" class="btn btn-lg btn-primary" data-kt-element="details-next">
											<?= displayLoadingIcon('Finish Up'); ?>
										</button>
									</div>
								</div>
							</div>

							<!---div data-kt-stepper-element="content">
								<div class="w-100">
									<div class="mb-13">
										<h2 class="mb-3">Finance</h2>
									</div>

									<div class="fv-row mb-8">
										
									</div>

									<div class="d-flex flex-stack">
										<button type="button" class="btn btn-lg btn-light me-3" data-kt-element="finance-previous">Project Settings</button>
										<button type="button" class="btn btn-lg btn-primary" data-kt-element="finance-next">
											<?= displayLoadingIcon('Finish'); ?>
										</button>
									</div>
								</div>
							</div-->

							<div data-kt-stepper-element="content">
								<div class="w-100">
									<div class="mb-13">
										<h2 class="mb-3">Measurements Created!</h2>
										<div class="text-muted fw-bold fs-5">If you need more info, please check out 
										<a href="#" class="link-primary fw-bolder">FAQ Page</a>.</div>
									</div>
									<div class="d-flex flex-center pb-20">
										<button type="button" class="btn btn-lg btn-dark me-3" data-kt-element="complete-start">Add New Measurments</button>
										<a href="#" class="btn btn-lg btn-primary" data-bs-toggle="tooltip" title="Coming Soon">View Deal</a>
									</div>
									<div class="text-center px-4">
										<img src="./assets/media/illustrations/sigma-1/20.png" alt="" class="mw-100 mh-300px" />
									</div>
								</div>
							</div>
							
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>