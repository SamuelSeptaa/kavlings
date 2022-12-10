<script>
    $(document).ready(function (e) {
        $("#testimonialsss").submit(function (e) {
            e.preventDefault();

            const formdata = new FormData(this);
            $.ajax({
                type: "post",
                url: `{{route('create-ulasan')}}`,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: formdata,
                processData: false,
                contentType: false,
                // dataType: 'JSON',
                beforeSend: function () {
                    showLoading();
                },
                success: function (response) {
                    hideLoading();
                    Swal.fire({
                        title: `${response.message.title}`,
                        text: `${response.message.body}`,
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Ok",
                    }).then((result) => {
                        location.reload();
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    hideLoading();
                    const response = jqXHR.responseJSON;
                    if (jqXHR.status == 422) {
                        let result = Object.entries(response.errors);
                        result.forEach(function ([field, message], index) {
                            $(`.invalid-feedback[for="${field}"]`).html(message);
                            $(`#${field}`).addClass("is-invalid");
                        });
                    }
                },
            });
        });
        $("#testimonialsss")
        .find("input")
        .on("input change", function (event) {
            $(this).removeClass("is-invalid");
        });
    });
</script>