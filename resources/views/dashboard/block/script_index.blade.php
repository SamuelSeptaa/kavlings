<script>
	$(document).ready(function(e){
    let filterValue = [];
        var table = $("#data-block").DataTable({
		pageLength: 30,
		scrollX: true,
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: `{{route('show-block')}}`,
			type: "POST",
			data: function (d) {
				d.search	= $("#search").val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
		},
        columns: [
            {data: 'action', name: 'action',
                orderable: false, 
                searchable: false
            },
            {data: 'block_name', name: 'block_name'},
            {data: 'total_kavling', name: 'total_kavling', 
				orderable: true, 
                searchable: false
			},
            {data: 'total_kavling_sold', name: 'total_kavling_sold', 
				orderable: false, 
                searchable: false
			},
            {data: 'harga_per_kavling', name: 'harga', 
                searchable: false
			},
        ],
		dom: "rtip",
	});

	table.on("processing.dt", function (e, settings, processing) {
		if (processing) {
			showLoading();
		} else {
			hideLoading();
		}
	});

	$('#data-block').on( 'page.dt', function () {
		$('html, body').animate({
			scrollTop: 0
		}, 1000);        
	});

	$("#search").keyup(
		debounce(function () {
			table.ajax.reload();
		}, 1200)
	);
});
</script>