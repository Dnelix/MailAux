<div class="row g-7">
    <div class="col-lg-8 col-xl-8">
        <?php 
            include_once("templates/wysiwyg.php");
        ?>
    </div>
    <div class="col-lg-4 col-xl-4">
        <div class="card card-flush mt-6 mt-xl-9">
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Summary</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Review reciepients and email details</span>
                </h3>
            </div>

            <div class="card-body pt-5">
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-bold fs-6 me-2 text-center">Christmas Greeting Email to Our Clients</div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">No. of reciepients</div>
                    <div class="d-flex align-items-center">
                        <span class="text-gray-900 fw-bolder fs-6">730k</span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Average delivery time</div>
                    <div class="d-flex align-items-center">
                        <span class="text-gray-900 fw-bolder fs-6">3.09 secs</span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Send date</div>
                    <div class="d-flex align-items-center">
                        <span class="text-gray-900 fw-bolder fs-6">27th July, 6:45pm </span>
                    </div>
                </div>
                
                <div class="mt-8 row">
                    <button type="button" onclick="goTo('send_mail')" class="btn btn-secondary col-5 me-2">Save</button>
                    <button type="button" onclick="goTo('send_mail')" class="btn btn-primary col-6">Send Now</button>
                </div>
            </div>
        </div>
    </div>
</div>
