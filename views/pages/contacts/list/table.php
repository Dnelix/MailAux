<div class="table-responsive">
    <table id="contacts_data_table" class="table dataTable table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
        <thead class="fs-7 text-gray-400 text-uppercase">
            <tr>
                <th class="min-w-200px">Contact</th>
                <th class="min-w-150px">Name</th>
                <th class="min-w-100px">Date Added</th>
                <th class="min-w-100px text-end">Actions</th>
            </tr>
        </thead>

        <tbody class="fs-6">
            <?php
                
                if($c_count > 0){
                    foreach($c_data as $c){
                        include("table/content.php");
                    }
                } else {
                    echo '<tr><td> No contacts found </td></tr>';
                }
            ?>
        </tbody>
    </table>
</div>