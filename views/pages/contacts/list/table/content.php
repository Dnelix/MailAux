
    <tr>
        <td>
            <div class="d-flex align-items-center">
                <div class="me-5 position-relative">
                    <?= displayUserIcon( getInitials($c->email), $c->id); ?>
                </div>
                <div class="d-flex flex-column justify-content-center">
                    <div class="fw-light text-gray-800"><?= $c->email; ?></div>
                </div>
            </div>
        </td>
        <td><?= $c->first_name.' '.$c->last_name; ?></td>
        <td><?= readableDateTime($c->created, 'dateonly'); ?></td>
        
        <?php include "actions.php"; ?>
    </tr>
