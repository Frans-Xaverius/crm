<script type="text/javascript">
	
	const mainData = JSON.parse(`{!! json_encode($data) !!}`);
	let listChildren = assignChild(mainData.children, []);

    function assignChild (data, list) {

		$.each(data, function(k, v){

			console.log(v);
			let	object = {
				'name': v.content != null ? 'Pertanyaan' : 'Jawaban',
				'title': v.content ?? v.jawaban,
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
		'id': 'rootNode',
		'collapsed': false,
		'nodeTitle': 'titleNode',
		'nodeContent': 'contentNode',
		'name': mainData.content,
		'title': mainData.content,
		'children': listChildren,
    };

    $('.chart-container').orgchart({
      'data' : datascource,
      'nodeContent': 'title'
    });

</script>