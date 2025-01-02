<td class="text-end">
    <div class="d-flex justify-content-end flex-shrink-0">
        <!-- <a href="customers?cid=<?= $cid; ?>" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="View details">
            <span class="svg-icon svg-icon-3"><i class="fa fa-eye"></i></span>
        </a> -->
        <a href="javascript:;" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="Edit Contact" <?= openModal('edit-contact'); ?> onclick="showEditContact(<?= $c->id;?>)">
            <span class="svg-icon svg-icon-3"><i class="fa fa-pen"></i></span>
        </a>
        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Delete record">
            <span class="svg-icon svg-icon-3"><i class="fa fa-trash"></i></span>
        </a>
    </div>
</td>