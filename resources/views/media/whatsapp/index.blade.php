@extends('layouts.app')

@section('add-style')
@include('media.whatsapp.css')
@endsection

@section('content')

<div class="container-fluid pb-1 pt-3 pt-md-7">
    <div class="card mt-3 mb-5">
        <div class="card-body">
            <div class="row">

                <div class="col-md-6 col-lg-5 col-xl-4 mb-1 mb-md-0">
                    <div class="d-flex flex-row justify-content-start mb-3">
                        <input type="text" class="form-control form-control-alternative" placeholder="Search chat" aria-label="Recipient's username" aria-describedby="basic-addon2" id="search-chat">
                    </div>
                    <div data-mdb-perfect-scrollbar="true" style="position: relative; height: calc(100vh - 287px);overflow-y: scroll;">
                        <ul class="list-unstyled myChat" style="width: 100%" id="room">
                            @for($i=0; $i<10; $i++)
                            <li class="p-2 border-bottom">
                                <a class="d-flex justify-content-between">
                                    <div class="d-flex flex-row">
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-8.webp" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2" width="40">
                                        <div class="pt-1">
                                            <p class="fw-bold mb-0 font-weight-bold">
                                                John Doe
                                                <span class="badge badge-pill badge-danger">1</span>
                                            </p>
                                            <p class="small text-muted">Hello, Are you there? Lorem dolor sit...</p>
                                        </div>
                                    </div>
                                    <div class="pt-1">
                                        <p class="small text-muted mb-1"><?php echo date('d/m/Y'); ?></p>
                                        <span class="badge float-end mt-5 text-danger" style="border: red solid; border-width: thin;">
                                            Unsolved
                                        </span>
                                    </div>
                                </a>
                            </li>
                            <li class="p-2 border-bottom" style="background-color: #eee;">
                                <a class="d-flex justify-content-between">
                                    <div class="d-flex flex-row">
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-1.webp" alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2" width="40">
                                        <div class="pt-1">
                                            <p class="fw-bold mb-0">Danny Smith</p>
                                            <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                        </div>
                                    </div>
                                    <div class="pt-1">
                                        <p class="small text-muted mb-1">5 mins ago</p>
                                        <span class="badge float-end mt-5 text-success" style="border: green solid; border-width: thin;">
                                            Solved
                                        </span>
                                    </div>
                                </a>
                            </li>
                            @endfor
                        </ul>
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
                            <button class="btn btn-sm btn-success" id="btnSolved">Solved</button>
                            <button class="btn btn-sm btn-danger">Unsolved</button>
                        </div>
                    </div>
                    <div class="pt-3 pe-3 pr-3 mt-3" style="height: calc(100vh - 287px);overflow-y: scroll;" id="room-detail">
                        @for($i=0; $i<10; $i++)
                        <div class="d-flex flex-row justify-content-start">
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-1.webp" alt="avatar 1" style="width: 45px; height: 100%;">
                            <div>
                                <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua
                                </p>
                                <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13</p>
                            </div>
                        </div>
                        <div class="d-flex flex-row justify-content-end">
                            <div>
                                <p class="small p-2 me-3 mb-1 rounded-3 bg-primary">
                                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </p>
                                <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                            </div>
                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar 1" style="width: 45px; height: 100%;">
                        </div>
                        @endfor
                    </div>
                    <div class="text-muted d-flex justify-content-end align-items-center mt-3">
                        <textarea class="form-control form-control-lg" placeholder="Type a message..." id="input-message"> </textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-1 mb-2">
                        <div class="pt-1 d-flex">
                            <button class="ms-4 btn btn-active" id="btn-sent" disabled>
                                Sent &nbsp; <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
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
        </div>
    </div>
</div>

@endsection

@push('js')
@include('media.whatsapp.script')
@endpush
