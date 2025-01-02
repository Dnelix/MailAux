"use strict";

//--Datatables
var initTable = function () {
    var table = document.querySelector('#data_table');

    if (!table) { return; }

    // Set date data order
    const tableRows = table.querySelectorAll('tbody tr');

    tableRows.forEach(row => {
        const dateRow = row.querySelectorAll('td');
        const realDate = moment(dateRow[1].innerHTML, "MMM D, YYYY").format();
        dateRow[1].setAttribute('data-order', realDate);
    });

    // Init datatable --- more info on datatables: https://datatables.net/manual/
    const datatable = $(table).DataTable({
        "info": false,
        'order': []
    });

    // Filter by date --- official docs reference: https://momentjs.com/docs/
    var minDate;
    var maxDate;

    // Date range filter --- offical docs reference: https://datatables.net/examples/plug-ins/range_filtering.html
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var min = minDate;
            var max = maxDate;
            var date = parseFloat(moment(data[1]).format()) || 0; // use data for the age column

            if ((isNaN(min) && isNaN(max)) ||
                (isNaN(min) && date <= max) ||
                (min <= date && isNaN(max)) ||
                (min <= date && date <= max)) {
                return true;
            }
            return false;
        }
    );

    // Search --- official docs reference: https://datatables.net/reference/api/search()
    var filterSearch = document.getElementById('data_table_search');
    filterSearch.addEventListener('keyup', function (e) {
        datatable.search(e.target.value).draw();
    });
}();

KTUtil.onDOMContentLoaded(function() {
    initTable.init();
});