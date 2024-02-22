@vite('resources/js/app.js')
<script type="text/javascript">

    let currNum = '';

    $('.list-customer').on('click', function(){

    	let id = $(this).attr('attr-id');
        currNum = $(this).attr('attr-num').split('@')[0];
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
    	});

        $('#room-detail').animate({scrollTop: $('#room-detail').height()}, 1000);

    });

    $(document).ready(function(){

        $('.list-customer')[0].click();

        Echo.channel('message-channel')
            .listen('MessageEvent', (e) => {
                console.log(e);
            });

    });

    $('.do-send').on('click', function(){

        let content = $('.content-msg').val();
        let mainUrl = `<?= $_ENV['URL_WA'] ?>`;

        $.ajax({
            method: "GET",
            url: `${mainUrl}api?num=${currNum}&msg=${content}`,
            success: function(res) {
                console.log(res);
            }
        });

    });


</script>