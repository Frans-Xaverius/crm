<script type="text/javascript">
	
	const mainData = JSON.parse(`{!! json_encode($data) !!}`);
	let listChildren = assignChild(mainData.children, []);
	let currData = null;

	function assignChild (data, list) {

		$.each(data, function(k, v){

			let	object = {
				'numId': v.id,
				'name': v.content != null ? 'Pertanyaan' : 'Jawaban',
				'title': v.content ?? v.jawaban,
				'level': v.level,
				'children': [],
			}

			list.push(object);			
			if (v.children) {
				object.children = assignChild(v.children, list.at(-1).children);
			}

		});

		return list;
	}

	let datascource = {
		'name': 'Pertanyaan',
		'title': mainData.content,
		'numId': mainData.id,
		'level': mainData.level,
		'children': listChildren,
	};

	$('.chart-container').orgchart({
		'data' : datascource,
		'depth': 2,
		'collapse': true,
		'nodeContent': 'title',
		'createNode': ($node, data) => {

			$node.on('mouseover', function(){
				$(this).css('cursor', 'pointer');
			});

			$node.on('click', () => {

				currData = data;
				$('.btn-group .btn').prop('disabled', true);
				$('.do-delete').prop('disabled', false);
				let status = checkChild();

				if (!status) {

					$('.do-edit').prop('disabled', false);	

				} else {

					$('.do-edit').prop('disabled', false);	
					$('.do-add').prop('disabled', false);	
				}

			});

		}
	});

	$('.do-add').on('click', function() {

		let check = fieldJawaban();
		let field = `
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="select-type" value="content">
			 	<label class="form-check-label"> Pertanyaan </label>
			</div>
			<div class="form-check form-check-inline">
			  	<input class="form-check-input" type="radio" name="select-type" value="jawaban" ${check ? '' : 'disabled'}>
			  	<label class="form-check-label"> Jawaban </label>
			</div>
		`;
		
		Swal.fire({
          	title: "Tambah Form",
          	showCancelButton: true,
          	html: `
          		<form method="POST" class="append-form mt-3 text-left" action="{{ route('pertanyaan.child.append') }}" enctype="multipart/form-data">
          			@csrf
          			<input type="hidden" class="form-control" name="id" value="${currData.numId}" />
          			<input type="hidden" name="level" value="${currData.level}" />
          			${field}
          			<div class="form-group mt-3">
          				<input type="text" class="form-control a-name" value="" />
          			</div>
				</form>
          	`,
          	confirmButtonColor: '#3085d6',
          	cancelButtonColor: '#d33',
          	confirmButtonText: 'Simpan',
          	cancelButtonText: 'Batal',
          	allowOutsideClick: false,
          	didOpen: () => {
          		$('[name=select-type]').on('click', function(){
          			let name = $(this).val();
          			$('.a-name').attr('name', name);
          		});
          	},
          	width: '60em',
        }).
        then((result) => {
        	if (result.value) {
        		$('.append-form').submit();
        	}
        })

	});

	$('.do-edit').on('click', function() {

		Swal.fire({
          	title: "Edit Form",
          	showCancelButton: true,
          	html: `
          		<form method="POST" class="update-form text-left" action="{{ route('pertanyaan.child.update') }}" enctype="multipart/form-data">
          			@csrf
          			<input type="hidden" class="form-control" name="id" value="${currData.numId}" />
          			<div class="form-group mt-4">
          				<label> ${currData.name} </label>
          				<input type="text" class="form-control" name="${currData.name.toLowerCase()}" value="${currData.title}" />
          			</div>
				</form>
          	`,
          	confirmButtonColor: '#3085d6',
          	cancelButtonColor: '#d33',
          	confirmButtonText: 'Simpan',
          	cancelButtonText: 'Batal',
          	allowOutsideClick: false,
          	width: '60em',
        }).
        then((result) => {
        	if (result.value) {
        		$('.update-form').submit();
        	}
        })
	});


	$('.do-delete').on('click', function(){

		Swal.fire({
			title: 'Konfirmasi',
			html: `
				Apakah anda akan menghapus item ini?
          		<form method="POST" class="delete-form text-left" action="{{ route('pertanyaan.child.delete') }}" enctype="multipart/form-data">
          			@csrf
          			<input type="hidden" class="form-control" name="id" value="${currData.numId}" />
				</form>
          	`,
			footer: `<i> Akan menghapus semua item yang berhubungan dengan item ini </i>`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak',
		}).
		then((result) => {
			if (result.value) {
				$('.delete-form').submit();
			}
		});

	});

	$(document).ready(function(){
		$('.btn-group .btn').prop('disabled', true);
	});


	function checkChild () {

		let available = true;
		
		if (currData.children.length == 1) {
			let dt = currData.children[0];
			if (dt.name == 'Jawaban'){
				available = !available;
			}
		} else if (currData.children.length == 0) {
			if (currData.name != 'Pertanyaan') {
				available = !available;
			}
		}

		return available;
	}

	function fieldJawaban () {
		
		let available = false;

		if (currData.children.length == 0) {
			available = !available;
		}

		return available;
	}

</script>