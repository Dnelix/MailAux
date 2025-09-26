
	<div class="card card-flush"> 

		<!--begin::Card header-->
		<div class="card-header mt-5">
			<div class="card-title flex-column">
				<h3 class="fw-bolder mb-1">My Contacts (<?= $c_count; ?>)</h3>
				<div class="fs-6 text-gray-400">See your contact list below </div>
			</div>
			<div class="card-toolbar my-1">
				<div class="d-flex align-items-center position-relative my-1">
					<span class="svg-icon svg-icon-3 position-absolute ms-3"><i class="fa fa-search"></i></span>
					<input type="text" id="data_table_search" class="form-control form-control-solid form-select-sm w-300px ps-9" placeholder="Search Contacts" />
				</div>
			</div>
		</div>

		<div class="card-body pt-0">

			<?php include_once("list/table.php"); ?>

		</div>
	</div>