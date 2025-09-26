<div class="card card-flush mt-6 mt-xl-9">
    <div class="card-header mt-5">
        <div class="card-title flex-column">
            <h3 class="fw-bolder mb-1">Add/Import Contacts</h3>
            <div class="fs-6 text-gray-400">Choose one of the options below to add or import your mailing contacts </div>
        </div>
    </div>
    
    <div class="card-body pt-0">
        <div class="py-5">
            <div class="row">
                <div class="col-md-4 p-2">
                    <a href="javascript:;" <?= openModal('add-contact'); ?> class="card hover-elevate-up shadow-sm parent-hover">
                        <div class="card-body">
                            <div class="d-flex align-items mb-2">
                                <i class="fa fa-plus me-3"></i>
                                <span class="text-gray-700 parent-hover-primary fs-6 fw-bold">Add Manually</span>
                            </div>
                            <p>Quickly add a contact by filling out a simple form</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 p-2">
                    <a href="javascript:;" <?= openModal('paste-contacts'); ?> class="card hover-elevate-up shadow-sm parent-hover">
                        <div class="card-body">
                            <div class="d-flex align-items mb-2">
                                <i class="fa fa-copy me-3"></i>
                                <span class="text-gray-700 parent-hover-primary fs-6 fw-bold">Copy & Paste</span>
                            </div>
                            <p>Paste a list of contacts to create all at once</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 p-2">
                    <a href="javascript:;" <?= openModal('upload-contacts'); ?> class="card hover-elevate-up shadow-sm parent-hover">
                        <div class="card-body">
                            <div class="d-flex align-items mb-2">
                                <i class="fa fa-file me-3"></i>
                                <span class="text-gray-700 parent-hover-primary fs-6 fw-bold">Import From File</span>
                            </div>
                            <p>Upload a CSV file with the list of contacts</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>