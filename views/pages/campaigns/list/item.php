<?php
$redirectUrl = empty($cm->content) ? 'templates&cmid='.$cm->id : 'send_mail&cmid='.$cm->id
?>

    <tr>
        <td class="min-w-125px">
            <div class="position-relative ps-6 pe-3 py-2">
                <div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-info"></div>
                <a href="<?= $redirectUrl; ?>" class="mb-1 text-gray-900 text-hover-primary fw-bold"><?= $cm->title; ?></a>
                <div class="fs-7 text-muted fw-bold">Updated on <?= readableDateTime($cm->updated, 'dateonly'); ?></div>
            </div>
        </td>

        <!-- <td>
            <div class="d-flex gap-2 mb-2">
                <a href="#">
                    <img src="../assets/media/svg/brand-logos/facebook-4.svg" class="w-20px" alt="" />
                </a>
                <a href="#">
                    <img src="../assets/media/svg/brand-logos/twitter-2.svg" class="w-20px" alt="" />
                </a>
                <a href="#">
                    <img src="../assets/media/svg/brand-logos/linkedin-2.svg" class="w-20px" alt="" />
                </a>
                <a href="#">
                    <img src="../assets/media/svg/brand-logos/youtube-3.svg" class="w-20px" alt="" />
                </a>
            </div>
            <div class="fs-7 text-muted fw-bold">Labor 24 - 35 years</div>
        </td> -->
        
        <td>
            <?= showStatus(ucwords($cm->status)); ?>
        </td>

        <td class="min-w-125px">
            <div class="symbol-group symbol-hover mb-1">
                <div class="symbol symbol-circle symbol-25px"><div class="symbol-label bg-info"><span class="fs-7 text-inverse-warning">A</span></div></div>
                <div class="symbol symbol-circle symbol-25px"><div class="symbol-label bg-danger"><span class="fs-7 text-inverse-info">E</span></div></div>
                <div class="symbol symbol-circle symbol-25px"><div class="symbol-label bg-warning"><span class="fs-7 text-inverse-danger">F</span></div></div>
                <div class="symbol symbol-circle symbol-25px">
                    <div class="symbol-label bg-dark">
                        <span class="fs-8 text-inverse-dark">+<?= formatNumber($cm->num_recipients-3); ?></span>
                    </div>
                </div>
            </div>
            <div class="fs-7 fw-bold text-muted">Recipients</div>
        </td>
        <td class="min-w-175px">
            <div class="mb-2 fw-bold"><?= limit_text($cm->content, 15); ?></div>
            <div class="fs-7 fw-bold text-muted">Content</div>
        </td>
        <td class="d-none"><?= ucwords($cm->status); ?></td>
        <td class="text-end">
            <button type="button" class="btn btn-icon btn-sm btn-light btn-active-primary w-25px h-25px" onclick="goTo('<?= $redirectUrl; ?>')">
                <i class="fa fa-arrow-right fs-2 text-muted"></i>
            </button>
        </td>
    </tr>