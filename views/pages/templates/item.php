<?php
$templateImg = file_exists("assets/media/email/templates/$t->image") ? "assets/media/email/templates/$t->image" : "assets/media/email/templates/default.png";
?>
    <div class="col-md-4">    
        <div class="card card-bordered">
            <div class="card-header">
                <h3 class="card-title"><?= $t->name; ?></h3>
                <!-- <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-primary">Choose Template</button>
                </div> -->
            </div>
            <div class="card-body p-0">
                <div class="card-p mb-10">
                    <?= $t->description; ?>
                </div>

                <div class="text-center px-4">
                    <img class="mw-100 mh-300px card-rounded-bottom" alt="" src="<?= $templateImg; ?>">
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-sm btn-light-primary" onclick="goToEdit('<?= $t->id; ?>')">Choose Template</button>
                </div>
            </div>
        </div>
    </div>
