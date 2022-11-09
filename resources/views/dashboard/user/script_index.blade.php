<script>
	//? function saat button hapus pada datatable di klik. delete dengan ajax
function deleteData(id) {
	Swal.fire({
		icon: "question",
		title: "Hapus user yang dipilih?",
		showCancelButton: true,
		cancelButtonText: "Batal",
		confirmButtonText: "Hapus",
		reverseButtons: true,
	}).then((result) => {
		if (result.isConfirmed) {
			showLoading();
			$.ajax({
				type: "post",
				dataType: "json",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{route('delete-'.$controller)}}',
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
						$("#data-user").DataTable().ajax.reload();
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
        var table = $("#data-user").DataTable({
		pageLength: 30,
		scrollX: true,
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: `{{route('show-user-list')}}`,
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
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
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

	$("#search").keyup(
		debounce(function () {
			table.search(this.value).draw();
			toggleHapusFilter(isFiltered());
		}, 200)
	);
    });
</script>