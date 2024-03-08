@vite('resources/js/app.js')
<script type="text/javascript">

    let currNum = '';
    const date = new Date();

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

                let pos = '';
                let res = e.content;

                if (res.admin !== 'true') {
                    pos = 'start';
                } else {
                    pos = 'end';
                }

                $('#room-detail').append(
                        `<div class="d-flex flex-row justify-content-${pos}">
                            <div>
                                <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">
                                    ${res.message}
                                </p>
                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">
                                    ${date.getHours()}:${date.getMinutes()}
                                </p>
                            </div>
                        </div>`
                );
            });

    });

    $('.do-send').on('click', function(){

        let content = $('.content-msg').val();
        let mainUrl = `<?= $_ENV['URL_WA'] ?>`;

        $.ajax({
            method: "GET",
            url: `${mainUrl}api?num=${currNum}&msg=${content}`,
            success: function(res) {
                
            }
        });

        $('.content-msg').val('');

    });

    $(".do-complete").on('click', function(){

        Swal.fire({
            title: "Konfirmasi",
            showCancelButton: true,
            icon: 'warning',
            html: `
                Apakah anda akan mengakhiri sesi percakapan ini?
                <form method="POST" class="complete-form mt-3 text-left" action="{{ route('media.whatsapp.complete') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" name="number" value="${currNum}" />
                </form>
            `,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            allowOutsideClick: false,
        }).
        then((result) => {
            if (result.value) {
                $('.complete-form').submit();
            }
        })


    });


</script>