<?php 
    $sessiondata = retrieveDataFrom($c_website.'controllers/sessions.php?userid='.$loguserid); 
    $usersessions = $sessiondata->data;
?>

<div class="card mb-5 mb-lg-10">
    <div class="card-header">
        <div class="card-title">
            <h3>Login Sessions</h3>
        </div>
        <div class="card-toolbar">
            <span class="badge badge-light-info"><b>Last Login: &nbsp;</b> <?= readableDateTime($user->lastlogin); ?></span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9">
                <thead class="border-gray-200 fs-5 fw-bold bg-lighten">
                    <tr>
                        <th class="min-w-200px">Location</th>
                        <th class="min-w-150px">Status</th>
                        <th class="min-w-150px">Device</th>
                        <th class="min-w-150px">IP Address</th>
                        <th class="min-w-150px">Time</th>
                    </tr>
                </thead>
                <tbody class="fw-6 fw-bold text-gray-600">
                    <?php
                    $session = "";
                    $currenttime = new DateTime();
                    foreach ($usersessions as $session){ 
                        $login_time = $session->logintime;
                        $expiry = $session->loginexpiry;
                        $device = $session->device;
                        $ip = $session->ip;

                        $logintime = DateTime::createFromFormat('d/m/Y H:i', $login_time);
                        $timediff = $currenttime->diff($logintime);
                    ?>
                    <tr>
                        <td><a class="text-hover-primary text-gray-600">Nigeria</a></td>
                        <td>
                            <?php if($expiry  > 0){ ?><span class="badge badge-light-success fs-7 fw-bolder">ACTIVE</span>
                            <?php } else { ?><span class="badge badge-light-warning fs-7 fw-bolder">EXPIRED</span><?php } ?>
                        </td>
                        <td><?= $device; ?></td>
                        <td><?= $ip; ?></td>
                        <td>
                            <?php 
                                if ($timediff->d > 0) {
                                $formatted = $timediff->d . " days ago";// If diff > one day, display in days
                                } elseif ($timediff->h > 0) {
                                $formatted = $timediff->h . " hours ago";// If diff > one hour, display in hours
                                } elseif ($timediff->i > 0) {
                                $formatted = $timediff->i . " mins ago"; // If diff > one minute, display in minutes
                                } else {
                                $formatted = "Just now";// If diff is less than one minute, display as "just now"
                                }
                                echo $formatted;

                                //echo time_elapsed_string($expiry);
                            ?>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>