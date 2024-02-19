@extends('layouts.app')

@section('add-style')
@include('media.whatsapp.css')
@endsection

@section('content')

<div class="container-fluid pb-1 pt-3 pt-md-7">
    <div class="card mt-3 mb-5 p-2">
        <div class="card-body">
            <div class="row">

                <div class="col-md-6 col-lg-5 col-xl-4 mb-1 mb-md-0">
                    <div class="d-flex flex-row justify-content-start mb-3">
                        <input type="text" class="form-control form-control-alternative" placeholder="Search chat" aria-label="Recipient's username" aria-describedby="basic-addon2" id="search-chat">
                    </div>
                    <div data-mdb-perfect-scrollbar="true" style="position: relative; height: calc(100vh - 287px);overflow-y: scroll;">
                        <div class="list-group" style="width: 100%" id="room">
                            @foreach ($customer as $c)
                                <a href="#" class="list-group-item list-group-item-action border-bottom p-2 list-customer" attr-id="{{ $c->id }}" attr-num="{{ $c->no_telp }}">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-8.webp" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2" width="40">
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0 font-weight-bold">
                                                    {{ $c->no_telp }}
                                                </p>
                                                <p class="small text-muted">
                                                    {{ $c->from->content }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-1"><?php echo date('d/m/Y'); ?></p>
                                            <span class="badge float-end mt-5 text-danger" style="border: red solid; border-width: thin;">
                                                Belum Selesai
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach 
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 col-xl-5">
                    <div class="d-flex mt-2 mb-2">
                        <div style="display: none;" id="isSolved">
                            <div class="d-flex flex-row justify-content-start mb-4 pt-2 pl-2 round pr-2 mr-3" style="background-color: green; height: 45px;">
                                <span class="text-white"> This conversation has been solved </span>
                            </div>
                        </div>
                        <div class="text-center mt-2" id="btnIsSolved">
                            <button class="btn btn-sm btn-success" id="btnSolved">Selesai</button>
                            <button class="btn btn-sm btn-danger">Belum Selesai</button>
                        </div>
                    </div>
                    <div class="pt-3 pe-3 pr-3 mt-3" style="height: calc(100vh - 287px);overflow-y: scroll;" id="room-detail">
                        
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 col-xl-3">
                    <div data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">
                        <div class="card card-profile">
                            <div class="row justify-content-center mt-4 mb-2">
                                <img src="/assets/img/user.png" alt="avatar 1" style="width: 70px; height: 100%;"
                                id="user-avatar">
                            </div>
                            <div class="card-body pt-2 pt-md-2 mt-2">
                                <div class="text-center">
                                    <h4 id="user-name"></h4>
                                    <div class="h5 font-weight-300" id="user-uid"></div>
                                </div>
                                <hr class="my-1 mb-2" />
                                <h4>Contact Handle</h4>
                                <p class="small text-muted">Channel</p>
                                <p class="small font-weight-bold">Whatsapp</p>
                                <p class="small text-muted">Number</p>
                                <p class="small font-weight-bold">+62 812-3456-7890</p>
                                <p class="small text-muted">Email</p>
                                <p class="small font-weight-bold">sherin@example.com</p>
                                <hr class="my-1" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="text-muted d-flex justify-content-end align-items-center mt-5">
                <textarea class="form-control form-control-lg content-msg" placeholder="Tulis pesan..." rows="3"></textarea>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-1 mb-2">
                <div class="pt-1 d-flex">
                    <button class="ms-4 btn btn-active do-send">
                        Kirim &nbsp; <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
@include('media.whatsapp.script')
@endpush
