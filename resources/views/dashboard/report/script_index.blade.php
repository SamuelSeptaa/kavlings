<script>
    $(document).ready(function (e) {
    var table = $("#data-report").DataTable({
        pageLength: 30,
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: `{{route('show-report')}}`,
            type: "POST",
            data: function (d) {
                d.year = $("#year").val();
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        },
        columns: [
            { data: "january", name: "jan", orderable: false },
            { data: "february", name: "feb", orderable: false },
            { data: "maret", name: "mar", orderable: false },
            { data: "april", name: "apr", orderable: false },
            { data: "mei_", name: "mei", orderable: false },
            { data: "juni", name: "jun", orderable: false },
            { data: "juli", name: "jul", orderable: false },
            { data: "agustus", name: "agt", orderable: false },
            { data: "sept", name: "sep", orderable: false },
            { data: "oktober", name: "okt", orderable: false },
            { data: "november", name: "nov", orderable: false },
            { data: "desember", name: "des", orderable: false }
        ],
        dom: "rtip",
    });

    $("#data-report").on("page.dt", function () {
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

    var table2 = $("#data-report-block").DataTable({
        pageLength: 30,
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: `{{route('show-report-block')}}`,
            type: "POST",
            data: function (d) {
                d.year = $("#year").val();
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        },
        columns: [
            { data: "block_name", name: "block_name", orderable: false },
            { data: "januari", name: "jan", orderable: false, },
            { data: "februari", name: "feb", orderable: false },
            { data: "maret", name: "mar", orderable: false },
            { data: "april", name: "apr", orderable: false },
            { data: "mei", name: "mei", orderable: false },
            { data: "juni", name: "jun", orderable: false },
            { data: "juli", name: "jul", orderable: false },
            { data: "agustus", name: "agt", orderable: false },
            { data: "september", name: "sep", orderable: false },
            { data: "oktober", name: "okt", orderable: false },
            { data: "november", name: "nov", orderable: false },
            { data: "desember", name: "des", orderable: false }
        ],
        columnDefs: [ {
                "targets": [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ],
                "orderable": false,
                className: 'text-center'
        } ],
        dom: "rtip",
    });

    $("#data-report-block").on("page.dt", function () {
        $("html, body").animate(
            {
                scrollTop: 0,
            },
            1000
        );
    });

    table2.on("processing.dt", function (e, settings, processing) {
        if (processing) {
            showLoading();
        } else {
            hideLoading();
        }
    });
    $("#year").change(
        debounce(function () {
            table.ajax.reload();
            table2.ajax.reload();
        }, 100)
    );
});
</script>