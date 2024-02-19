<script type="text/javascript">

    $('.list-customer').on('click', function(){

    	let id = $(this).attr('attr-id');
        $('#room-detail').html('');

    	$.ajax({
    		method: "GET",
    		url: `{{ route('media.whatsapp.riwayat') }}?id=${id}`,
    		success: function(dt) {
                
    			let res = JSON.parse(dt);
                let pos = '';

                $.each(res, function(k,v){

                    if (v.from == id) {
                        pos = 'start';
                    } else {
                        pos = 'end';
                    }

                    $('#room-detail').append(
                        `<div class="d-flex flex-row justify-content-${pos}">
                            <div>
                                <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">
                                    ${v.content}
                                </p>
                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">
                                    ${moment.utc(v.created_at).format("HH::mm")}
                                </p>
                            </div>
                        </div>`
                    );

                });
    			
    		}
    	})
    });

    $('.list-customer')[0].click();


</script>