
    <div class="d-flex flex-stack flex-wrap gap-4">
        <div class="d-flex align-items-center flex-wrap gap-3 gap-xl-9">
            <div class="d-flex align-items-center fw-bold">
                <div class="text-muted fs-7">Type</div>
                <select class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto" data-hide-search="true" data-control="select2" data-dropdown-css-class="w-150px" data-placeholder="Select an option">
                    <option></option>
                    <option value="Show All" selected>Show All</option>
                    <option value="Newest">Newest</option>
                    <option value="oldest">Oldest</option>
                </select>
            </div>
            <div class="d-flex align-items-center fw-bold">
                <div class="text-muted fs-7 me-2">Status</div>
                <select class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto" data-hide-search="true" data-control="select2" data-dropdown-css-class="w-150px" data-placeholder="Select an option" data-kt-table-widget-3="filter_status">
                    <option></option>
                    <option value="Show All" selected>Show All</option>
                    <option value="Draft">Draft</option>
                    <option value="Reviewing">Reviewing</option>
                    <option value="Completed">Paused</option>
                </select>
            </div>
            <!--div class="d-flex align-items-center fw-bold">
                <div class="text-muted me-2">Budget</div>
                <select class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto" data-hide-search="true" data-dropdown-css-class="w-150px" data-control="select2" data-placeholder="Select an option" data-kt-table-widget-3="filter_status">
                    <option></option>
                    <option value="Show All" selected>Show All</option>
                    <option value="<5000">Less than $5,000</option>
                    <option value="5000-10000">$5,001 - $10,000</option>
                    <option value=">10000">More than $10,001</option>
                </select>
            </div-->
        </div>
        
        <div class="d-flex align-items-center gap-4">
            <a href="#" class="text-hover-primary ps-4" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <i class="ki-outline ki-filter fs-2 text-gray-500"></i>
            </a>
            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_672e0467d803a">
                <div class="px-7 py-5">
                    <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                </div>
                <div class="separator border-gray-200"></div>
                <div class="px-7 py-5">
                    <div class="mb-10">
                        <label class="form-label fw-semibold">Status:</label>
                        <div>
                            <select class="form-select form-select-solid" multiple data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_672e0467d803a" data-allow-clear="true">
                                <option></option>
                                <option value="1">Approved</option>
                                <option value="2">Pending</option>
                                <option value="2">In Process</option>
                                <option value="2">Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-10">
                        <label class="form-label fw-semibold">Member Type:</label>
                        <div class="d-flex">
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                <input class="form-check-input" type="checkbox" value="1" />
                                <span class="form-check-label">Author</span>
                            </label>
                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="2" checked="checked" />
                                <span class="form-check-label">Customer</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-10">
                        <label class="form-label fw-semibold">Notifications:</label>
                        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="" name="notifications" checked />
                            <label class="form-check-label">Enabled</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                        <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                    </div>
                </div>
            </div>
        </div>

    </div>