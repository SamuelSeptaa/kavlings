<script>
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
            minimumFractionDigits: 0,
            style: "currency",
            currency: "IDR"
        }).format(number);
    }

    let total = {{$total}};
    let metode_pembayaran = "TRANSFER";
    $(document).ready(function(e){
        $('input[type="checkbox"][name="add_ons\\[\\]"]').change(function(e){
            const val = $(this).val();
            const name = $(this).data('name');
            let harga = $(this).data('harga');
            const total_kavling = {{$carts->count()}}
            harga = parseInt(harga);
            if($(this).is(':checked')){
                total = total+(harga*total_kavling);
                $("#total-harga").html(rupiah(total));
                $(".addons-details").append(
                    `
                        <tr data-id="${val}">
                            <td>${name}</td>
                            <td>${rupiah(harga*total_kavling)}</td>
                        </tr>
                    `
                );
            }else{
                total = total-(harga*total_kavling);
                $(`tr[data-id="${val}"]`).remove();
                $("#total-harga").html(rupiah(total));
            }

        });

        $(".btn-metode-pembayaran").click(function(e) {
            e.preventDefault();
            let metode = $(this).data('metode');
            metode_pembayaran = metode;
            $(".btn-metode-pembayaran").removeClass("active");
            $(`button[data-metode="${metode}"]`).addClass("active");
        });

        $("#place-order").click(function(e){
            Swal.fire({
                title: 'Apakah Anda Yakin ingin membuat pesanan ini?',
                icon: 'question',
                showCancelButton: true,
                reverseButtons:true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Buat Pesanan',
                cancelButtonText: 'Kembali',
                }).then((result) => {
                if (result.isConfirmed) {
                    $("#form-place-order").submit();
                }
                })
        });

        $("#form-place-order").submit(function(e){
            e.preventDefault();

            let formdata = new FormData(this);
            const addons = $('input[type="checkbox"][name="add_ons\\[\\]"]:checked').map(function() {
                return this.value;
            }).get();

            formdata.append('metode_pembayaran', metode_pembayaran);

            $.ajax({
                type: "post",
                url: `{{route('place-order')}}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formdata,
                processData: false,
                contentType: false,
                // dataType: 'JSON',
                beforeSend: function() {
                    showLoading();
                },
                success: function(response) {
                    hideLoading();
                        Swal.fire({
                        title: `${response.message.title}`,
                        text:`${response.message.body}`,
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                        }).then((result) => {
                            if(response.data.url_payment != null){
                                location.href = `${response.data.url_payment}`
                            }
                            else{
                                location.href = `{{route('index')}}`
                            }
                        })
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    hideLoading();
                    const response = jqXHR.responseJSON;
                    if(jqXHR.status == 422){
                        let result = Object.entries(response.errors);
                        result.forEach(function([field, message], index) {
                            $(`.invalid-feedback[for="${field}"]`).html(message);
                            $(`#${field}`).addClass('is-invalid');
                        });
                        $("button[data-target='#collapseOne']").trigger('click');
                    }
                }
            });
        });
        $("#form-place-order").find('input').on('input change', function(event) {
            $(this).removeClass('is-invalid');
        });
    })
</script>