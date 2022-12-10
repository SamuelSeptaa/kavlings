<script>
    $(document).ready(function (e) {
        var ctx = document.getElementById("barChart").getContext("2d");
        let year = 2022;
        $.ajax({
            type: "post",
            url: `{{route('chart-penjualan')}}`,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                year: year,
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
    });
</script>