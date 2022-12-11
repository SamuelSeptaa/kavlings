<script>
    $(document).ready(function (e) {


        var ctx = document.getElementById("barChart").getContext("2d");
        var ctx2 = document.getElementById("salesChart").getContext("2d");
        $.ajax({
            type: "post",
            url: `{{route('chart-penjualan-per-block')}}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            processData: true,
            beforeSend: function () {
                showLoading();
            },
            success: function (response) {
                hideLoading();
                console.log(response.data.dataset);
                var myChart = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "Mei",
                            "Jun",
                            "Jul",
                            "Agt",
                            "Sept",
                            "Okt",
                            "Nov",
                            "Des",
                        ],
                        datasets: response.data.dataset,
                    },
                    options: {
                       
                        scales: {
                            yAxes: [
                                {
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Jumlah Pemesanan'
                                    },
                                    ticks: {
                                        beginAtZero: true,
                                        max: 20
                                    },
                                    
                                },
                            ],
                        },
                    },
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                hideLoading();
                Swal.fire({
                    icon: "error",
                    title: errorThrown,
                    text: textStatus,
                    confirmButtonColor: "#7a7b5a",
                });
            },
        });

        $.ajax({
            type: "post",
            url: `{{route('chart-penjualan')}}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            processData: true,
            beforeSend: function () {
                showLoading();
            },
            success: function (response) {
                hideLoading();
                console.log(response.data.dataset);
                var myChart = new Chart(ctx2, {
                    type: "bar",
                    data: {
                        labels: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "Mei",
                            "Jun",
                            "Jul",
                            "Agt",
                            "Sept",
                            "Okt",
                            "Nov",
                            "Des",
                        ],
                        datasets: response.data.dataset,
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var label = data.labels[tooltipItem.datasetIndex] || '';

                                    if (label) {
                                        label += ': ';
                                    }
                                    label += rupiah(tooltipItem.yLabel)
                                    return label;
                                }
                            }
                        },
                        scales: {
                            yAxes: [
                                {
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Rp'
                                    },
                                    ticks: {
                                        beginAtZero: false,
                                        callback: function(value, index, values) {
                                            return rupiah(value)
                                        }
                                    },
                                    
                                },
                            ],
                        },
                    },
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                hideLoading();
                Swal.fire({
                    icon: "error",
                    title: errorThrown,
                    text: textStatus,
                    confirmButtonColor: "#7a7b5a",
                });
            },
        });
    });
</script>