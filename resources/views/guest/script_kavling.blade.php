<script>
    $(document).ready(function(e){

        function toggleSelectedKavling(selector, status) {
		if (status) {
			$(selector).addClass("active");
		} else {
			$(selector).removeClass("active");
		}
	}	

        let kavlingSelected = [];
        let selected = 0;
        $(".kavling").click(function(e) {
            e.preventDefault();

            if($(this).hasClass("nonactive"))
                return false;

            let value = $(this).data('id');
            let kavlingExist = kavlingSelected.includes(value)
            if (!kavlingExist) {
                toggleSelectedKavling(this, true)
                kavlingSelected.push(value);
                selected++;
            } else {
                toggleSelectedKavling(this, false)
                let index = kavlingSelected.indexOf(value);
                if (index !== -1) {
                    kavlingSelected.splice(index, 1);
                }
                selected--;
            }
            $("#jumlah-dipilih").html(selected);
        });
    })
</script>