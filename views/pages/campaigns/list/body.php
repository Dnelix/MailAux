    <table id="kt_widget_table_3" class="table table-row-dashed align-middle fs-6 gy-4 my-0 pb-3" data-kt-table-widget-3="all">
        <thead class="d-none">
            <tr>
                <th>Campaign</th>
                <!-- <th>Platforms</th> -->
                <th>Status</th>
                <th>Recipients</th>
                <th>Date</th>
                <!-- <th>Progress</th>
                <th>Action</th> -->
            </tr>
        </thead>

        <tbody>
            <?php 
                foreach($cm_data as $cm){
                    include('item.php');
                }
                
            ?>
        </tbody>
    </table>