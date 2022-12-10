<script>
	//? function saat button acvive pada datatable di klik. aktive dengan ajax
	function activingKavling(id) {
	Swal.fire({
		icon: "question",
		title: "Aktivkan Kembali kavling yang dipilih?",
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
				url: "{{route('activing-kavling')}}",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
$(document).ready(function(e){
    let filterValue = [];
        var table = $("#data-column").DataTable({
		pageLength: 30,
		scrollX: true,
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: `{{route('show-column')}}`,
			type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
		},
        columns: [
            {data: 'action', name: 'action',
                orderable: false, 
                searchable: false
            },
            {data: 'rowname', name: 'rowname'},
            {data: 'total_kavling', name: 'total_kavling', 
				orderable: false, 
                searchable: false
			},
            {data: 'total_kavling_sold', name: 'total_kavling_sold', 
				orderable: false, 
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

	$('#data-kavling').on( 'page.dt', function () {
		$('html, body').animate({
			scrollTop: 0
		}, 1000);        
	});

	$("#search").keyup(
		debounce(function () {
			table.ajax.reload();
		}, 1200)
	);

	function resetFilterStatus() {
		filterValue = []
		toggleFilterStatus(".btn-filter", false)
		toggleFilterStatus(".btn-filter[data-block_id='all']", true)
		// table.column(10).search(JSON.stringify(filterValue))
	}

	function toggleFilterStatus(selector, status) {
		if (status) {
			$(selector).addClass("active");
		} else {
			$(selector).removeClass("active");
		}
	}	

	$(".btn-filter").click(function(e) {
            e.preventDefault();
            let value = $(this).data('block_id');
            if (value == "all") {
                resetFilterStatus()
            } else {
                toggleFilterStatus(".btn-filter[data-block_id='all']", false)
                let filterExist = filterValue.includes(value)
                if (!filterExist) {
                    toggleFilterStatus(this, true)
                    filterValue.push(value);
                } else {
                    toggleFilterStatus(this, false)
                    let index = filterValue.indexOf(value);
                    if (index !== -1) {
                        filterValue.splice(index, 1);
                    }
                }
            }

            if (filterValue.length == 0) {
                toggleFilterStatus(".btn-filter[data-block_id='all']", true)
            }
            table.ajax.reload();

			console.log(filterValue)
			
        });

});
</script>