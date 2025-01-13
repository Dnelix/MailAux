<?php
$country_list = getCountries();
$photoFile = !empty($bizdata->logo) ? $bizdata->id."/".$bizdata->logo : "upload.png";
?>

<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" >
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">Business Details</h3>
        </div>
    </div>

    <div id="settings_business_details" class="collapse show">
        <form id="bizDataForm" class="form" onsubmit="return false;" enctype="multipart/form-data">

            <input type="hidden" name="userid" value="<?= $loguserid; ?>"/>

            <div class="card-body border-top p-9">
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Logo</label>
                    <div class="col-lg-8">
                        <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/brand-logos/vodafone.svg')">

                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url('assets/uploads/<?= $photoFile; ?>')"></div>

                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change Logo">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="logo_remove" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel logo">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove logo">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                        </div>
                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Company/Business</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="name" class="form-control form-control-lg form-control-solid" placeholder="Company/Business name" value="<?= $bizdata->name; ?>" required />
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Description</label>
                    <div class="col-lg-8 fv-row">
                        <textarea class="form-control form-control-solid" rows="4" name="description" placeholder="Tell us a little about what you do" required ><?= $bizdata->description; ?></textarea>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Contact Phone</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Contact phone number" value="<?= $bizdata->phone; ?>" required />
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span class="required">Business Email</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Please ensure you have access to this email"></i>
                    </label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="email" class="form-control form-control-lg form-control-solid" placeholder="Business email" value="<?= $bizdata->email; ?>" required />
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Company Website (optional)</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="website" class="form-control form-control-lg form-control-solid" placeholder="www.zzz.com" value="<?= $bizdata->website; ?>" />
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span class="required">Business Location</span>
                    </label>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-4 fv-row">
                                <select id="country" name="country" onchange="populateStates()" aria-label="Select a Country" data-control="select2" data-placeholder="Select a country..." class="form-select form-select-solid form-select-lg fw-bold" required >
                                    <option value="">Select a Country...</option>
                                    <?php 
                                        foreach ($country_list as $country){
                                            $selected = ($bizdata->country == $country) ? 'selected' : '';
                                            echo '<option value="'. $country .'" '. $selected .'>'. $country .'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-4 fv-row">
                                <select id="state" name="state" onchange="populateCities()" aria-label="Select a state/province" data-control="select2" data-placeholder="Select a state/province..." class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">Select a State/Province...</option>
                                    <?php
                                        $states = getStates($bizdata->country);
                                        foreach ($states as $state){
                                            $selected = ($bizdata->state == $state) ? 'selected' : '';
                                            echo '<option value="'. $state .'" '. $selected .'>'. $state .'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-4 fv-row">
                                <select id="city" name="city" aria-label="Select LGA" data-control="select2" data-placeholder="Select LGA..." class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">Select LGA...</option>
                                    <?php
                                        $cities = getCities($bizdata->state);
                                        foreach ($cities as $city){
                                            $selected = ($bizdata->city == $city) ? 'selected' : '';
                                            echo '<option value="'. $city .'" '. $selected .'>'. $city .'</option>';
                                        }
                                    ?>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Office/Business Address</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="address" class="form-control form-control-lg form-control-solid" placeholder="Block B, 121 Ikate" value="<?= $bizdata->address; ?>" required />
                    </div>
                </div>

            </div>
            
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                <button type="submit" class="btn btn-primary" id="bizDataBtn" onclick="updateBiz('<?= $bizdata->id; ?>')"><?= displayLoadingBtn('Save Changes'); ?></button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateBiz(bid){
        var web = '<?= $appURL; ?>';
        var userid = '<?= $loguserid; ?>';
        var url = web+"controllers/business.php?uid="+userid+"&bid="+bid;
        var formData = extractFormData('#bizDataForm');
        var btn = "#bizDataBtn";

        AJAXcall("POST", url, btn, formData, (r)=>{ handleResponseMsg(r, 'confirmreload'); });
    }
</script>