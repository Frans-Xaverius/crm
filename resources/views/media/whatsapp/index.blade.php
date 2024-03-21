@extends('layouts.app')

@section('add-style')
@include('media.whatsapp.css')
@endsection

@section('content')

<div class="container-fluid pb-1 pt-3 pt-md-7">
    <div class="card mt-3 mb-5 p-2">
        <div class="card-body">
            <div class="row">

                <div class="col-md-3">
                    <div class="d-flex flex-row justify-content-start mb-3">
                        <input type="text" class="form-control form-control-alternative" placeholder="Search chat" aria-label="Recipient's username" aria-describedby="basic-addon2" id="search-chat">
                    </div>
                    <div data-mdb-perfect-scrollbar="true" style="position: relative; height: calc(100vh - 287px); overflow-y: scroll;">
                        <div class="list-group chat-queue" style="width: 100%" id="room">
                            @foreach ($customer as $c)
                                <a href="#" class="list-group-item list-group-item-action border-bottom p-2 list-customer" onclick="setCustomer('{{ $c->id }}', '{{ $c->no_telp }}' )">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <img src="/assets/img/user.png" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2" width="40">
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0 font-weight-bold">
                                                    {{ $c->no_telp }}
                                                </p>
                                                <p class="small text-muted text-msg" numid="{{ $c->id }}">
                                                    @if (!empty($c->to) && !empty($c->from))
                                                        {{ ($c->to->created_at < $c->from->created_at) ? $c->from->content ?? $c->from->file_support : $c->to->content ?? $c->to->file_support }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach 
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="d-flex mt-2 mb-2">
                        <div style="display: none;" id="isSolved">
                            <div class="d-flex flex-row justify-content-start mb-4 pt-2 pl-2 round pr-2 mr-3" style="background-color: green; height: 45px;">
                                <span class="text-white"> Percakapan ini sudah selesai </span>
                            </div>
                        </div>
                        <div class="text-center mt-2" id="btnIsSolved">
                            <button class="btn btn-sm btn-success do-complete"> Akhiri Sesi </button>
                        </div>
                    </div>
                    <div class="pt-3 pe-3 pr-3 mt-3" style="height: calc(100vh - 287px);overflow-y: scroll;" id="room-detail">
                        
                    </div>
                </div>

                

            </div>
            <div class="text-muted d-flex justify-content-end align-items-center mt-5">
                <textarea class="form-control form-control-lg content-msg" placeholder="Tulis pesan..." rows="3"></textarea>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-1 mb-2 field-btn">
                <div class="pt-1 d-flex">
                    <div class="btn-group">
                        <button class="ms-4 btn btn-primary do-send">
                            Kirim &nbsp; <i class="fas fa-paper-plane"></i>
                        </button>
                        <button class="ms-4 btn btn-secondary do-attachment">
                            <i class="fa fa-file" aria-hidden="true"></i>
                        </button>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
@include('media.whatsapp.script')
@endpush
