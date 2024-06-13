<script type="text/javascript">

    let currConvId = '';
    let adminId = `{{ $adminId }}`;
    let currNum = 0;

    const date = new Date();
    const mainUrl = `<?= $_ENV['URL_WA'] ?>`;

    const $selectTag = $('.tags').select2();
    const $selectEks = $('.eks-select').select2();

    function setConversation (id) {

        currConvId = id;
        $('#room-detail').html('');
        
        $('.do-complete').prop('disabled', true);
        $('.input-tag').val(currConvId);
        $('.input-eks').val(currConvId);
    	
        $.ajax({
    		method: "GET",
    		url: `{{ route('media.whatsapp.riwayat') }}?id=${id}`,
    		success: function(dt) {

    			let res = JSON.parse(dt);
                let pos = '';

                currNum = res.customer.no_telp.split('@')[0];
                $selectTag.val(res.tag).trigger('change');
                $selectEks.val(res.eks.id).trigger('change');

                if (res.eks != null) {
                    $('[name=text-eks]').val(res.eks.name);
                }

                if (res.chat.length > 0) {
                    $('.do-complete').prop('disabled', false);
                }

                $.each(res.chat, function(k,v){

                    if (v.to == adminId) {
                        pos = 'start';
                    } else {
                        pos = 'end';
                    }

                    let subPart = `
                        <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7; white-space: pre-line;">
                            ${v.content}
                        </p>
                    `;

                    if (v.file_support != null) {

                        let url = `${mainUrl}storage?file=${v.file_support}&folder=conversation`;

                        subPart = `
                            <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7; white-space: pre-line;">
                                <a download href="${url}"> <i class="bi bi-download"> </i> ${v.file_support} </a> <br />
                                ${v.caption ?? ''}
                            </p>
                        `;
                    }


                    $('#room-detail').append(
                        `<div class="d-flex flex-row justify-content-${pos}">
                            <div>
                                ${subPart}
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

    }

    $(document).ready(function(){

        if ($('.list-customer').length > 0) {
            $('.list-customer')[0].click();
        } else {
            $('button').prop('disabled', true);
        }

        Echo.channel('message-channel').listen('MessageEvent', (e) => {
            
            let userId = `{{ auth()->user()->id }}`;
            let isAdmin = `{{ auth()->user()->detailRole->name == "Super Admin" ? true : false }}`;        
            let show = (e.conversation.user_id == userId) || (isAdmin == 1);
            
            if (show) {
                drawChat(e);
            }
            
        });

        Echo.channel('qr-channel').listen('QrEvent', (e) => {            
            Swal.fire({
                title: "Scan untuk masuk",
                html: `<canvas id="qrCanvas"> </canvas>`,
                icon: "warning",
                didOpen : () => {
                    let currCanvas = document.getElementById("qrCanvas");
                    qrcode.toCanvas(currCanvas, e.token);
                },
                allowOutsideClick: false
            });
        });

        Echo.channel('ready-channel').listen('ReadyEvent', (e) => {
            let res = e.data.client;
            
            $('.field-nomor').val(res.me.user);
            $('.field-nama').val(res.pushname);
        });

    });

    function drawChat (e) {

        let pos = '';
        let res = e.content;
        let body = e.body;
        let subPart = body.content;
        let conversationId = e.conversation.id;

        if (!res.admin) {
            pos = 'start';

        } else {
            pos = 'end';
        }

        if (conversationId == currConvId) {

            if (body.file_support != null) {
                let url = `${mainUrl}storage?file=${body.file_support}&folder=conversation`;
                subPart = `<a download href="${url}"> <i class="bi bi-download"> </i> ${body.file_support} </a> <br />
                        ${body.caption ?? ''}`;
            }
                    
            $('#room-detail').append(
                `<div class="d-flex flex-row justify-content-${pos}">
                    <div>
                        <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7; white-space: pre-line;">
                            ${subPart}
                        </p>
                        <p class="small ms-3 mb-3 rounded-3 text-muted float-end">
                            ${date.getHours()}:${date.getMinutes()}
                        </p>
                    </div>
                </div>`
            );

            $(`[attr-convid=${conversationId}]`).html(subPart);

            let childPr = $(`[attr-convid=${conversationId}]`).parents('a');
            $('.chat-queue').prepend(childPr);

        } else {

            let currListCustomer = arrCustomer();

            if (!currListCustomer.includes(conversationId)) {

                let fieldQueue = `
                    <a href="#" class="list-group-item list-group-item-action border-bottom p-2 list-customer" onclick="setConversation('${conversationId}')">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row">
                                <img src="/assets/img/user.png" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2" width="40">
                                <div class="pt-1">
                                    <p class="fw-bold mb-0 font-weight-bold">
                                        ${e.customer.nama ?? e.customer.no_telp}
                                    </p>
                                    <p class="small text-muted text-msg" attr-convid="${conversationId}">
                                        ${subPart}
                                    </p>
                                </div>
                            </div>
                        </div>
                     </a>
                `;
                        
                $('.chat-queue').prepend(fieldQueue);

            } else {

                $(`[attr-convid=${conversationId}]`).html(subPart);
            }
        }
    };

    $('.do-send').on('click', function(){

        let content = $('.content-msg').val();
        let name = `{{ Auth::user()->name }}`;

        $.ajax({
            method: "POST",
            url: `${mainUrl}api`,
            data: {
                num: currNum,
                msg: `${content}\n\n-${name}-`
            },
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

    $(".do-attachment").on('click', function(){

        Swal.fire({
            title: "Input File",
            showCancelButton: true,
            icon: 'question',
            html: `
                <div class="form-group mt-3 mb-2">
                    <label> File </label>
                    <input type="file" class="form-control mt-3" name="file" />
                </div>
                <div class="form-group mt-3 mb-2">
                    <label> Caption </label>
                    <input type="text" class="form-control" name="caption" />
                </div>
            `,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            allowOutsideClick: false,
        }).
        then((result) => {

            if (result.value) {
                
                let formData = new FormData();
                let doc = $('[name=file]').prop('files')[0];

                formData.append('file', doc);
                formData.append('number', currNum);
                formData.append('caption', $('[name=caption]').val());
                formData.append('_csrf', `{{ csrf_token() }}`);
                
                $.ajax({
                    type: 'POST',
                    url: `{{ route('media.whatsapp.store-attachment') }}`,
                    data: formData,
                    contentType: false, 
                    processData: false, 
                    beforeSend: () => {
                       $('.field-btn').hide();
                    },
                    complete: () => {
                        Swal.fire({
                            title: "Berhasil",
                            text: "File Berhasil Dikirim",
                            icon: "success"
                        });
                        $('.field-btn').show();
                    }
                });

            }

        })


    });

    function arrCustomer () {

        let length = $('.text-msg').length;
        let list = [];

        $.each($('.text-msg'), (x, y) => {
            list.push(parseInt($(y).attr('attr-convid')));
        });

        return list;
    }


</script>