@vite('resources/js/app.js')
<script type="text/javascript">

    let currNum = '';
    let currId = '';

    const date = new Date();
    const mainUrl = `<?= $_ENV['URL_WA'] ?>`;

    function setCustomer (id, num) {

        currNum = num.split('@')[0];
        currId = id;
        $('#room-detail').html('');

    	$.ajax({
    		method: "GET",
    		url: `{{ route('media.whatsapp.riwayat') }}?id=${id}&num=${num}`,
    		success: function(dt) {

    			let res = JSON.parse(dt);
                let pos = '';

                if (res.eks != null) {
                    $('.text-eks').html(`Penanggung Jawab : ${res.eks.name}`);
                }

                $.each(res.chat, function(k,v){

                    if (v.from == id) {
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

        Echo.channel('message-channel')
            .listen('MessageEvent', (e) => {

                let pos = '';
                let sourceId = 0;
                let res = e.content;
                let body = e.body;
                let subPart = body.content;

                if (res.admin !== 'true') {
                    sourceId = body.from;
                    pos = 'start';

                } else {
                    sourceId = body.to;
                    pos = 'end';
                }

                if (sourceId == currId) {

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

                    $(`[numid=${sourceId}]`).html(subPart);

                    let childPr = $(`[numid=${sourceId}]`).parents('a');
                    $('.chat-queue').prepend(childPr);

                } else {

                    let person = e.person.from.is_admin == 1 ? e.person.to : e.person.from;
                    let currListCustomer = arrCustomer();

                    if (!currListCustomer.includes(person.id)) {

                        let fieldQueue = `
                            <a href="#" class="list-group-item list-group-item-action border-bottom p-2 list-customer" onclick="setCustomer('${person.id}', '${person.no_telp}')">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-row">
                                        <img src="/assets/img/user.png" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2" width="40">
                                        <div class="pt-1">
                                            <p class="fw-bold mb-0 font-weight-bold">
                                                ${person.no_telp}
                                            </p>
                                            <p class="small text-muted text-msg" numid="${person.id}">
                                                ${subPart}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        `;
                        
                        $('.chat-queue').prepend(fieldQueue);

                    } else {

                        $(`[numid=${person.id}]`).html(subPart);
                    }
                }

            });

    });

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

    $(".do-eksalasi").on('click', function(){

        Swal.fire({
            title: "Edit Eskalasi",
            showCancelButton: true,
            html: `
                <form method="POST" class="text-left pr-4 pl-4 eks-form" enctype="multipart/form-data" action="{{ route('media.whatsapp.eskalasi') }}">
                    @csrf
                    <input type="hidden" name="number" value="${currNum}" />
                    <div class="form-group mt-3">
                        <label> User </label>
                        <select class="form-control form-control-sm eks-select" name="user_id">
                            <option selected disabled> -- Pilih -- </option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            `,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
            didOpen: () => {
                $('.eks-select').select2({
                    dropdownParent: $('.swal2-container'),
                });
            },
            width: '50em',
        }).
        then((result) => {
            if (result.value) {
                $('.eks-form').submit();
            }
        });

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
            list.push(parseInt($(y).attr('numid')));
        });

        return list;
    }


</script>