<script>
    //? function saat button block pada datatable di klik. nonaktive dengan ajax
function nonacitiveKavling(id) {
    Swal.fire({
        icon: "question",
        title: "Nonaktifkan kavling yang dipilih?",
        showCancelButton: true,
        cancelButtonText: "Batal",
        confirmButtonText: "Ya",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            showLoading();
            $.ajax({
                type: "post",
                dataType: "json",
                url: "{{route('nonactive-kavling')}}",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: {
                    id: id,
                },
                beforeSend: function () {
                    showLoading();
                },
                complete: function () {
                    hideLoading();
                },
                success: function (response) {
                    Swal.fire({
                        confirmButtonColor: "#3ab50d",
                        icon: "success",
                        title: `${response.message}`,
                    }).then((result) => {
                        $("#data-kavling").DataTable().ajax.reload();
                    });
                },
                error: function (request, status, error) {
                    Swal.fire({
                        confirmButtonColor: "#3ab50d",
                        icon: "error",
                        title: `${status}`,
                        text: `${error}`,
                    });
                },
            });
        }
    });
}
$(document).ready(function (e) {
    let filterValue = [];
    let startDate = null;
    let endDate = null;

    const defaultStartDate = moment().subtract(29, 'days');
    const defaultEndDate = moment();

    var table = $("#data-orders").DataTable({
        pageLength: 30,
        scrollX: true,
        processing: true,
        serverSide: true,
        order: [[1, "desc"]],
        ajax: {
            url: `{{route('show-orders')}}`,
            type: "POST",
            data: function (d) {
                d.filterValue = JSON.stringify(filterValue);
                d.search = $("#search").val();
                d.startDate = startDate;
                d.endDate = endDate;
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        },
        columns: [
            { data: "action", name: "action", orderable: false },
            { data: "tanggalPesanan", name: "created_at" },
            {
                data: "statusOrderBadge",
                name: "statusOrderBadge",
                orderable: false,
                className: "text-center",
            },
            {
                data: "nomor_invoice",
                name: "nomor_invoice",
                orderable: false,
                className: "text-center",
            },
            { data: "nama_pemesan", name: "nama_pemesan" },
            { data: "kontak", name: "kontak", orderable: false },
            { data: "totalIDR", name: "total" },
            {
                data: "metodePembayaran",
                name: "metodePembayaran",
                orderable: false,
            },
            {
                data: "statusPembayaranBadge",
                name: "statusPembayaranBadge",
                orderable: false,
            },
        ],
        dom: "rtip",
    });

    $("#data-orders").on("page.dt", function () {
        $("html, body").animate(
            {
                scrollTop: 0,
            },
            1000
        );
    });

    table.on("processing.dt", function (e, settings, processing) {
        if (processing) {
            showLoading();
        } else {
            hideLoading();
        }
    });

    $("#search").keyup(
        debounce(function () {
            table.ajax.reload();
        }, 1200)
    );

    function resetFilterStatus() {
        filterValue = [];
        toggleFilterStatus(".btn-filter", false);
        toggleFilterStatus(".btn-filter[data-status='ALL']", true);
        // table.column(10).search(JSON.stringify(filterValue))
    }

    function toggleFilterStatus(selector, status) {
        if (status) {
            $(selector).addClass("active");
        } else {
            $(selector).removeClass("active");
        }
    }

    $(".btn-filter").click(function (e) {
        e.preventDefault();
        let value = $(this).data("status");
        if (value == "ALL") {
            resetFilterStatus();
        } else {
            toggleFilterStatus(".btn-filter[data-status='ALL']", false);
            let filterExist = filterValue.includes(value);
            if (!filterExist) {
                toggleFilterStatus(this, true);
                filterValue.push(value);
            } else {
                toggleFilterStatus(this, false);
                let index = filterValue.indexOf(value);
                if (index !== -1) {
                    filterValue.splice(index, 1);
                }
            }
        }

        if (filterValue.length == 0) {
            toggleFilterStatus(".btn-filter[data-status='all']", true);
        }
        table.ajax.reload();

        console.log(filterValue);
    });

    function getDefaultStartDate() {
        return defaultStartDate.clone();
    }

    function getDefaultEndDate() {
        return defaultEndDate.clone();
    }

    $("#daterange").daterangepicker({
        autoUpdateInput: false,
        startDate: getDefaultStartDate(),
        endDate: getDefaultEndDate(),
        locale: {
            cancelLabel: "Clear",
            format: 'DD/MM/YYYY'
        },
    });

    function filterDateRange(start, end, label) {
        startDate = start.format('YYYY-MM-DD');
        endDate = end.format('YYYY-MM-DD');

        table.ajax.reload();
    }

    $("#daterange").on("apply.daterangepicker", function (ev, picker) {
        $(this).val(
            picker.startDate.format("DD-MM-YYYY") +
                " - " +
                picker.endDate.format("DD-MM-YYYY")
        );

        filterDateRange(picker.startDate,picker.endDate);
    });

    $("#daterange").on("cancel.daterangepicker", function (ev, picker) {
        $(this).val("");
    });
});
</script>