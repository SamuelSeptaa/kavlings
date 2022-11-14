<script>
    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
            minimumFractionDigits: 0,
            style: "currency",
            currency: "IDR"
        }).format(number);
    }

    let total = {{$total}};
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
    })
</script>