
<div class="card card-flush mt-6 mt-xl-9 pb-8 bg-white">
    <div class="pt-5 px-10">
        <i class="fa fa-pen"></i> &nbsp;
        <a href="edit_template&cmid=<?= $cm_data->id; ?>" class="fw-bold"> Edit </a>
    </div>
    <div class="card-body">
        <div name="kt_docs_ckeditor_inline" id="ckeditor_inline">
            <?= $cm_data->content; ?>
        </div>
    </div>
</div>




