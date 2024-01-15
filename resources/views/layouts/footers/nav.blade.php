<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    style="padding-left: 17px!important;">
    <div class="modal-dialog" role="document" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header bg-gradient-blue">
                <h5 class="modal-title text-white" id="exampleModalLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-chat-square-text" viewBox="0 0 16 16">
                        <path
                            d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                        <path
                            d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                    </svg> &nbsp;
                    Chat
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&boxh;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0.5rem;">

                <div class="row">
                    <div class="col-md-6 col-lg-5 col-xl-4 mb-1 mb-md-0">
                        <div class="d-flex flex-row justify-content-start">
                            <input type="text" class="form-control form-control-alternative"
                                placeholder="Search chat" aria-label="Recipient's username"
                                aria-describedby="basic-addon2" id="search-chat">
                            {{-- <button type="button" class="btn btn-active">Search</button> --}}
                        </div>
                        <div class="d-flex">
                            {{-- <button class="btn btn-sm w-50 chat-filter" data-filter=".chat-ig">
                                <img src="/argon/img/icons/common/instagram.svg" width="20">
                                Instagram
                            </button>
                            <button class="btn btn-sm w-50 chat-filter" data-filter=".chat-fb">
                                <img src="/argon/img/icons/common/facebook2.svg" width="20">
                                Facebook
                            </button> --}}
                            @php
                                $app = [
                                    'all' => 'All',
                                    'fb' => 'Facebook',
                                    'ig' => 'Instagram',
                                    'wa_cloud' => 'WhatsApp Business',
                                    // 'cc' => 'Call Center',
                                    'web_chat' => 'Web Chat',
                                    'email' => 'Email',
                                ];
                            @endphp
                            <select class="form-control chat-select">
                                @foreach ($app as $k => $v)
                                    <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                            </select>
                            @foreach ($app as $k => $v)
                                <button class="chat-filter chat-filter-{{ $k }} d-none"
                                    data-filter=".chat-{{ $k }}">
                                    {{ $v }}
                                </button>
                            @endforeach
                        </div>
                        <div class="d-flex flex-row">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist" style="width: 100%">
                                <li class="nav-item" style="width: 33%">
                                    <a class="nav-link active text-center chat-filter" data-filter=".chat-all"
                                        id="home-tab2" data-toggle="tab" href="#home2" role="tab"
                                        aria-controls="home2" aria-selected="true">All</a>
                                </li>
                                <li class="nav-item" style="width: 33%">
                                    <a class="nav-link text-center chat-filter" data-filter=".chat-read"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile2" aria-selected="false">Read</a>
                                </li>
                                <li class="nav-item" style="width: 34%">
                                    <a class="nav-link text-center chat-filter" data-filter=".chat-unread"
                                        id="contact-tab2" data-toggle="tab" href="#contact2" role="tab"
                                        aria-controls="contact2" aria-selected="false">Unread</a>
                                </li>
                            </ul>
                        </div>

                        <div data-mdb-perfect-scrollbar="true"
                            style="position: relative; height: calc(100vh - 287px);overflow-y: scroll;">
                            <ul class="list-unstyled myChat" style="width: 100%" id="room">
                                {{-- <li class="p-2 border-bottom">
                                    <a class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-8.webp"
                                                alt="avatar"
                                                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2"
                                                width="40">
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0 font-weight-bold">
                                                    John Doe
                                                    <span class="badge badge-pill badge-danger">1</span>
                                                </p>
                                                <p class="small text-muted">Hello, Are you there? Lorem dolor sit...
                                                </p>
                                                <p class="small font-weight-bold">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="lightgreen" class="bi bi-whatsapp"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                                    </svg> &nbsp;
                                                    Testing
                                                </p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-1"><?php echo date('d/m/Y'); ?></p>
                                            <span class="badge float-end mt-5 text-danger"
                                                style="border: red solid; border-width: thin;">Unsolved</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="p-2 border-bottom" style="background-color: #eee;">
                                    <a class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-1.webp"
                                                alt="avatar"
                                                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2"
                                                width="40">
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0">Danny Smith</p>
                                                <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                <p class="small font-weight-bold">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="lightgreen" class="bi bi-whatsapp"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                                    </svg> &nbsp;
                                                    Danny Smith
                                                </p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-1">5 mins ago</p>
                                            <span class="badge float-end mt-5 text-success"
                                                style="border: green solid; border-width: thin;">Solved</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="p-2 border-bottom">
                                    <a class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-2.webp"
                                                alt="avatar"
                                                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2"
                                                width="40">
                                            <div class="pt-1 ">
                                                <p class="fw-bold mb-0">Alex Steward</p>
                                                <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                <p class="small font-weight-bold">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="blue" class="bi bi-facebook"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z">
                                                        </path>
                                                    </svg> &nbsp;
                                                    Testing
                                                </p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-1">Yesterday</p>
                                            <span class="badge float-end mt-5 text-danger"
                                                style="border: red solid; border-width: thin;">Unsolved</span>
                                        </div>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5 col-xl-5">
                        <div class="d-flex">
                            <div style="display: none;" id="isSolved">
                                <div class="d-flex flex-row justify-content-start mb-4 pt-2 pl-2 round pr-2 mr-3"
                                    style="background-color: green; height: 45px;">
                                    <span class="text-white">This conversation has been solved</span>
                                </div>
                            </div>
                            <div class="text-center mt-2" id="btnIsSolved">
                                <button class="btn btn-sm btn-success" id="btnSolved">Solved</button>
                                {{-- <button class="btn btn-sm btn-danger">Unsolved</button> --}}
                            </div>
                        </div>
                        <div class="pt-3 pe-3 pr-3" style="height: calc(100vh - 287px);overflow-y: scroll;"
                            id="room-detail">
                            {{-- <div class="d-flex flex-row justify-content-start">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-1.webp" alt="avatar 1"
                                    style="width: 45px; height: 100%;">
                                <div>
                                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">
                                        Lorem
                                        ipsum
                                        dolor
                                        sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                        labore et
                                        dolore
                                        magna aliqua.</p>
                                    <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13</p>
                                </div>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <div>
                                    <p class="small p-2 me-3 mb-1 rounded-3 bg-primary">Ut enim ad minim veniam,
                                        quis
                                        nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat.
                                    </p>
                                    <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                                </div>
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                    alt="avatar 1" style="width: 45px; height: 100%;">
                            </div> --}}
                        </div>

                        <div class="text-muted d-flex justify-content-end align-items-center">
                            {{-- <input type="text" class="form-control form-control-lg" placeholder="Type a message..."
                                id="input-message"> --}}
                            <textarea class="form-control form-control-lg" placeholder="Type a message..." id="input-message"></textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1 mb-2">
                            <div class="d-flex flex-row">
                                {{-- <a class="ms-1 mr-2 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                                <a class="ms-2 mr-2 text-muted" href="#!"><i class="fas fa-image"></i></a>
                                <a class="ms-3 mr-2 text-muted" href="#!"><i class="fas fa-file"></i></a> --}}
                                @if (auth()->user()->role == 'supervisor')
                                    <div class="w-50">
                                        <select id="eskalasi" style="width: 180px;"
                                            class="js-example-basic-multiple" name="eskalasi[]" multiple="multiple">
                                        </select>
                                    </div>
                                    {{-- <div class="w-50">
                                        <select id="tagging" style="width: 180px;"
                                            class="js-example-basic-multiple" name="tagging[]" multiple="multiple">
                                        </select>
                                    </div> --}}
                                @endif
                            </div>
                            <div class="pt-1 d-flex">
                                <button class="ms-4 btn btn-active" id="btn-sent" disabled>
                                    Sent &nbsp;
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-5 col-xl-3">

                        <div data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">
                            <div class="card card-profile">
                                <div class="row justify-content-center mt-2">
                                    <img src="/assets/img/user.png" alt="avatar 1" style="width: 70px; height: 100%;"
                                        id="user-avatar">
                                </div>
                                <div class="card-body pt-2 pt-md-2">
                                    <div class="text-center">
                                        <h4 id="user-name"></h4>
                                        <div class="h5 font-weight-300" id="user-uid"></div>
                                    </div>
                                    <div class="form-group">
                                        <label>Survey Rating</label>
                                        <select class="form-control" id="user-rating" name="user-rating">
                                            <option>Survey Rating</option>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tags</label>
                                        <br>
                                        <select id="tagging" style="width: 100%;" class="js-example-basic-multiple"
                                            name="tagging[]" multiple="multiple">
                                        </select>
                                    </div>
                                    {{-- <hr class="my-1" />
                                    <h4>Contact Handle</h4>
                                    <p class="small text-muted">Channel</p>
                                    <p class="small font-weight-bold">Whatsapp</p>
                                    <p class="small text-muted">Number</p>
                                    <p class="small font-weight-bold">+62 812-3456-7890</p>
                                    <p class="small text-muted">Email</p>
                                    <p class="small font-weight-bold">sherin@example.com</p>
                                    <hr class="my-1" />
                                    <div style="cursor: pointer">
                                        <h4>Contact Room History <span aria-hidden="true"
                                                style="float: right;">></span></h4>
                                    </div>
                                    <hr class="my-1" />
                                    <div style="cursor: pointer">
                                        <h4>Data Created <span aria-hidden="true" style="float: right;">></span></h4>
                                    </div>
                                    <hr class="my-1" /> --}}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row align-items-center justify-content-xl-between" style="position: fixed; bottom: 10px; right: -85px;">
    <div class="col-xl-10">
        <div class="copyright text-muted">
            <div class="container py-5">

                <div class="row" style="float: right">
                    <div class="col-md-8 col-lg-6 col-xl-12">
                        <!-- Buttons trigger collapse -->
                        <a class="btn btn-active btn-lg btn-block" {{-- data-toggle="collapse" href="#collapseExample" --}} data-toggle="modal"
                            data-target="#exampleModal" role="button" aria-expanded="false"
                            aria-controls="collapseExample" style="min-width: 366.16px;">
                            <div class="text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-chat-square-text" viewBox="0 0 16 16">
                                    <path
                                        d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                    <path
                                        d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                </svg>
                                <span class="font-weight-bold">Chat</span>
                            </div>
                        </a>
                        <!-- Collapsed content -->
                        <div class="collapse" id="collapseExample">
                            <div class="card" id="chat4" style="">
                                <div class="card-body" data-mdb-perfect-scrollbar="true" style="padding: 0.5rem;">
                                    <div class="d-flex flex-row justify-content-start mb-4">
                                        <input type="text" class="form-control form-control-alternative mr-2"
                                            placeholder="Search chat" aria-label="Recipient's username"
                                            aria-describedby="basic-addon2">
                                        <button type="button" class="btn btn-active">Search</button>
                                    </div>
                                    <div class="d-flex flex-row">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist" style="width: 100%">
                                            <li class="nav-item" style="width: 33%">
                                                <a class="nav-link active text-center" id="home-tab"
                                                    data-toggle="tab" href="#home" role="tab"
                                                    aria-controls="home" aria-selected="true">All</a>
                                            </li>
                                            <li class="nav-item" style="width: 33%">
                                                <a class="nav-link text-center" id="profile-tab" data-toggle="tab"
                                                    href="#profile" role="tab" aria-controls="profile"
                                                    aria-selected="false">Read</a>
                                            </li>
                                            <li class="nav-item" style="width: 34%">
                                                <a class="nav-link text-center" id="contact-tab" data-toggle="tab"
                                                    href="#contact" role="tab" aria-controls="contact"
                                                    aria-selected="false">Unread</a>
                                            </li>
                                        </ul>
                                        <?php /*
                                                                                                                                                                                                                                                                                  <div class="tab-content" id="myTabContent">
                                                                                                                                                                                                                                                                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"></div>
                                                                                                                                                                                                                                                                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"></div>
                                                                                                                                                                                                                                                                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab"></div>
                                                                                                                                                                                                                                                                                  </div>*/
                                        ?>
                                    </div>

                                    <div class="d-flex flex-row mb-4">
                                        <ul class="list-unstyled" style="width: 100%">
                                            <li class="p-2 border-bottom"
                                                style="background-color: #eee; cursor: pointer;" data-toggle="modal"
                                                data-target="#exampleModal">
                                                <a class="d-flex justify-content-between">
                                                    <div class="d-flex flex-row">
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-8.webp"
                                                            alt="avatar"
                                                            class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2"
                                                            width="40">
                                                        <div class="pt-1">
                                                            <p class="fw-bold mb-0 font-weight-bold">John Doe</p>
                                                            <p class="small text-muted">Hello, Are you there? Lorem
                                                                dolor sit...</p>
                                                            <p class="small font-weight-bold">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="lightgreen"
                                                                    class="bi bi-whatsapp" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                                                </svg> &nbsp;
                                                                Testing
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1"><?php echo date('d/m/Y'); ?></p>
                                                        <span class="badge float-end mt-5 text-danger"
                                                            style="border: red solid; border-width: thin;">Unsolved</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="p-2 border-bottom" data-toggle="modal"
                                                data-target="#exampleModal" style="cursor: pointer;">
                                                <a class="d-flex justify-content-between">
                                                    <div class="d-flex flex-row">
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-1.webp"
                                                            alt="avatar"
                                                            class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2"
                                                            width="40">
                                                        <div class="pt-1">
                                                            <p class="fw-bold mb-0">Danny Smith</p>
                                                            <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                            <p class="small font-weight-bold"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="lightgreen"
                                                                    class="bi bi-whatsapp" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                                                </svg> &nbsp;
                                                                Danny Smith
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1">5 mins ago</p>
                                                        <span class="badge float-end mt-5 text-success"
                                                            style="border: green solid; border-width: thin;">Solved</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="p-2 border-bottom" data-toggle="modal"
                                                data-target="#exampleModal" style="cursor: pointer;">
                                                <a class="d-flex justify-content-between">
                                                    <div class="d-flex flex-row">
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-2.webp"
                                                            alt="avatar"
                                                            class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2"
                                                            width="40">
                                                        <div class="pt-1 ">
                                                            <p class="fw-bold mb-0">Alex Steward</p>
                                                            <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                            <p class="small font-weight-bold">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="blue"
                                                                    class="bi bi-facebook" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z">
                                                                    </path>
                                                                </svg> &nbsp;
                                                                Testing
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1">Yesterday</p>
                                                        <span class="badge float-end mt-5 text-danger"
                                                            style="border: red solid; border-width: thin;">Unsolved</span>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // var eskalasi = {
        //     'ab8c8598-389a-4917-8cfb-5635b61d7f00': 'Humas',
        //     'd1463735-f2fe-433c-96bb-19901e9804a1': 'Keuangan'
        // };

        var channel = {
            'fb': '<i class="fab fa-facebook fa-lg" style="color: #0570E6;"></i>',
            'ig': '<i class="fab fa-instagram fa-lg" style="color: #ca87de;"></i>',
            'wa': '<i class="fab fa-whatsapp fa-lg" style="color: #16C149;"></i>',
            'wa_cloud': '<i class="fab fa-whatsapp fa-lg" style="color: #16C149;"></i>',
            'email': '<i class="fa fa-envelope fa-lg" style="color: #f03e3e;"></i>',
        };
        // webchat
        // instagram
        // fb_messenger
        // whatsapp
        // email
        // livechat_dot_com
        var channelSent = {
            'fb': 'fb_messenger',
            'ig': 'instagram',
            'wa': 'whatsapp',
            'email': 'email',
            'livechat_dot_com': 'livechat_dot_com',
            'web_chat': 'web_chat',
            'wa_cloud': 'wa_cloud',
            'telegram': 'telegram',
        };

        var allRoom = [];
        var room = null;
        var first = true;
        var eskaSelect = true;
        var tagSelect = true;
        var userRatingSelect = true;
        var curentChatFilter = '.chat-all';
        var is2kali = false;

        function loadChat() {
            $.ajax({
                type: "get",
                url: "{{ route('api.message.index') }}",
                // data: "data",
                dataType: "json",
                success: function(r) {
                    if (r.status == 'success') {
                        allRoom = r.data;
                        var html = ``;
                        $.each(r.data, function(i, v) {
                            if (room && room.room_id == v.id) {
                                var id = room.room_id;
                                getRoomHistory(id, true);
                            }

                            html += `
                                <li class="p-2 border-bottom btn-room-history chat-all ${v.unread_count == 0 ? 'chat-read' : 'chat-unread'} chat-${v.channel}" data-id="${v.id}">
                                    <a class="d-flex justify-content-between">
                                        <div class="d-flex flex-row">
                                            <img src="${v.avatar.url}"
                                                alt="avatar"
                                                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong mr-2"
                                                width="40">
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0 font-weight-bold">
                                                    ${v.name.substring(0, 35)}
                                                    ${v.unread_count != 0 ? `<span class="badge badge-pill badge-danger">${v.unread_count}</span>` : ''}
                                                </p>
                                                <p class="small text-muted">
                                                    ${v.last_message && v.last_message.text ? v.last_message.text.substring(0, 35) : ''}
                                                </p>
                                                <p class="small font-weight-bold">
                                                    ${channel[v.channel] ? channel[v.channel] : '<i class="far fa-comment fa-lg" style="color: #fb6340 ;"></i>'}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="pt-1">
                                            <p class="small text-muted mb-1">${inaDate(v.updated_at)}</p>
                                            ${v.resolved_at ? `<span class="badge float-end mt-5 text-success"style="border: green solid; border-width: thin;">Solved</span>` : `<span class="badge float-end mt-5 text-danger"style="border: red solid; border-width: thin;">Unsolved</span>`}
                                        </div>
                                    </a>
                                </li>
                            `;
                        });
                        $('#room').html(html);

                        if ($("#search-chat").val()) {
                            $("#search-chat").trigger('keyup');
                        } else if (curentChatFilter) {
                            $(`.chat-filter[data-filter='${curentChatFilter}']`).trigger('click');
                        }

                        if (r.data.length > 0 && first) {
                            getRoomHistory(r.data[0].id);
                            first = false;
                        }

                        syncData();
                    }

                    setTimeout(function() {
                        loadChat();
                    }, 3000)
                }
            });
        }

        function getRoomHistory(id, stay = false) {
            if (stay == false) {
                $('#isSolved').hide();
                $('#btnIsSolved').hide();
                $('#user-uid').text('');
                $('#btn-sent').prop('disabled', true);
                $('#eskalasi').prop('disabled', true);
                $('#eskalasi').val('');
            }
            $.ajax({
                type: "get",
                url: "{{ route('api.message.getRoomHistory') }}",
                data: {
                    room_id: id
                },
                dataType: "json",
                success: function(r) {
                    var html = ``;
                    if (r.status == 'success') {
                        if (r.data[0]) {
                            var data = r.data[0];
                            if (data.resolved_at) {
                                $('#isSolved').show();
                            } else {
                                $('#btnIsSolved').show();
                                $('#btn-sent').prop('disabled', false);
                                $('#eskalasi').prop('disabled', false);
                            }

                            $('#user-avatar').attr('src', data.avatar);
                            $('#user-name').text(data.name);
                            if (data.channel == 'wa' || data.channel == 'email' || data.channel == 'web_chat') {
                                $('#user-uid').text(data.account_uniq_id);
                            } else if (data.channel == 'ig' || data.channel == 'fb') {
                                $('#user-uid').text(data.channel_account);
                            }

                            // var found = false;
                            // var foundVal = null;

                            // $.each(data.agent_ids, function(i, v) {
                            //     if (found == false && eskalasi[v]) {
                            //         found = true;
                            //         $('#eskalasi').val(v);
                            //     }
                            // });

                            room = data;
                        }

                        var filteredRoom = allRoom.filter((v) => v.id == id);
                        // console.log(filteredRoom);
                        if (filteredRoom.length > 0) {
                            filteredRoom = filteredRoom[0];
                            // if (stay == false) {
                            //     $('#eskalasi').val(filteredRoom.agent_ids);
                            //     eskaSelect = false;
                            //     $('#eskalasi').trigger('change');
                            // }
                        }

                        // ${v.text.includes('qontak') ? '(Sistem) Percakapan diarsipkan...' : v.text}
                        $.each(r.data, function(i, v) {
                            html += `
                                <div class="d-flex ${v.participant_type == 'agent' || v.participant_type == 'bot' ? 'flex-row' : 'flex-row-reverse'} justify-content-end">
                                    <div>
                                        <p class="small p-2 me-3 mb-1 rounded-3 bg-primary" style="white-space: pre-line">${v.text}</p>
                                        <p class="small me-3 mb-3 rounded-3 text-muted">${inaDate(v.updated_at, true)}</p>
                                    </div>
                                    <img src="${v.participant_type == 'agent' || v.participant_type == 'bot' ? '/assets/img/user.png' : v.avatar}"
                                        alt="avatar 1" style="width: 45px; height: 100%;">
                                </div>
                            `;
                        });

                        $('#room-detail').html(html);

                        $.ajax({
                            type: "get",
                            url: "{{ route('tag.get-tag') }}",
                            data: {
                                id: room.room_id
                            },
                            dataType: "json",
                            success: function(r) {
                                if (r.sattus = 'success') {
                                    $('#tagging').val(r.data.tags);
                                    tagSelect = false;
                                    $('#tagging').trigger('change');

                                    $('#user-rating').val(r.data.rating ? r.data.rating : '');
                                    userRatingSelect = false;
                                    $('#user-rating').trigger('change');

                                    if (r.eks) {
                                        $('#eskalasi').val(r.eks);
                                        eskaSelect = false;
                                        $('#eskalasi').trigger('change');
                                    }
                                }
                            }
                        });
                    }
                }
            });

            if (is2kali) {
                is2kali = false;
                getRoomHistory(id);
            }
        }

        function sentMessage(room_id, channel, text, file) {
            $('#btn-sent').prop('disabled', true);
            $.ajax({
                type: "post",
                url: "{{ route('api.message.send') }}",
                data: {
                    room_id,
                    channel,
                    text
                },
                dataType: "json",
                success: function(r) {
                    getRoomHistory(room.room_id);
                    $('#input-message').val('');
                }
            });
        }

        function resolveRoom(id) {
            $.ajax({
                type: "post",
                url: "{{ route('api.message.markRoomAsResolved') }}",
                data: {
                    room_id: id,
                },
                dataType: "json",
                success: function(r) {
                    getRoomHistory(id);
                }
            });
        }

        async function ekalasiSelect() {
            // var html = `<option value="">-- Select --</option>`;
            $.ajax({
                type: "get",
                url: "{{ route('api.eskalasi') }}",
                dataType: "json",
                success: function(r) {
                    if (r.sattus = 'success') {
                        var eskalasi = r.data;
                        var html = ``;
                        $.each(eskalasi, function(i, v) {
                            html += `<option value="${i}">${v}</option>`;
                        });
                        $('#eskalasi').html(html);
                        $('#eskalasi').select2({
                            placeholder: "-- Divisi --",
                            allowClear: true
                        });
                    }
                }
            });
            $.ajax({
                type: "get",
                url: "{{ route('tag') }}",
                dataType: "json",
                success: function(r) {
                    if (r.sattus = 'success') {
                        var tag = r.data;
                        var html = ``;
                        $.each(tag, function(i, v) {
                            html += `<option value="${i}">${v}</option>`;
                        });
                        $('#tagging').html(html);
                        $('#tagging').select2({
                            placeholder: "-- Tag --",
                            allowClear: true
                        });
                    }
                }
            });
        }

        $('body').on('change', '#btn-sent', function() {
            let text = $('#input-message').val();
            console.log(text);
        });

        $('body').on('click', '.btn-room-history', function() {
            is2kali = true;
            var id = $(this).data('id');
            getRoomHistory(id);
        });

        $('body').on('click', '#btn-sent', function() {
            var id = room.room_id;
            var channel = channelSent[room.channel] ? channelSent[room.channel] : '';
            var text = $('#input-message').val();
            sentMessage(id, channel, text);
        });

        $('body').on('click', '#btnSolved', function() {
            var id = room.room_id;
            resolveRoom(id);
        });

        $('#eskalasi').change(function(e) {
            var val = $(this).val();
            if (val && eskaSelect) {
                $.ajax({
                    type: "post",
                    url: "{{ route('api.message.agent') }}",
                    data: {
                        room_id: room.room_id,
                        agent_id: val
                    },
                    dataType: "json",
                    success: function(r) {
                        getRoomHistory(room.room_id, true);
                    }
                });
            } else {
                eskaSelect = true;
            }
        });

        $('.chat-filter').click(function(e) {
            var f = $(this).data('filter');
            $('.chat-all').hide();
            $(f).show();
            curentChatFilter = f;
        });

        $('.chat-select').change(function(e) {
            var val = $(this).val();
            $(`.chat-filter-${val}`).trigger('click')
        });

        $("#search-chat").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".myChat li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('#tagging').change(function(e) {
            var val = $(this).val();
            if (tagSelect) {
                $.ajax({
                    type: "post",
                    url: "{{ route('tag.assign-tag') }}",
                    data: {
                        id: room.room_id,
                        tags: val
                    },
                    dataType: "json",
                    success: function(r) {
                        getRoomHistory(room.room_id, true);
                    }
                });
            } else {
                tagSelect = true;
            }
        });

        $('#user-rating').change(function(e) {
            var val = $(this).val();
            if (userRatingSelect) {
                $.ajax({
                    type: "post",
                    url: "{{ route('tag.assign-tag') }}",
                    data: {
                        id: room.room_id,
                        rating: val
                    },
                    dataType: "json",
                    success: function(r) {
                        getRoomHistory(room.room_id, true);
                    }
                });
            } else {
                userRatingSelect = true;
            }
        });

        ekalasiSelect();
        loadChat();

        function handleEnter(evt) {
            if (evt.keyCode == 13 && evt.shiftKey) {
                // console.log('shift + enter');
            } else if (evt.keyCode == 13) {
                // console.log('enter');
                evt.preventDefault();
                $('#btn-sent').trigger('click');
            }
        }

        $("#input-message").keydown(handleEnter);
    </script>
@endpush
