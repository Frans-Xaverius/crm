<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <b class="h1 font-weight-bold">Report</b>
            {{-- nav --}}
            <div>
                <ul class="nav nav-tabs mt-3">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold btn-filter-tabsss" data-toggle="tab"
                            href="#tab_conversation">Conversation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold btn-filter-tabsss" data-toggle="tab"
                            href="#tab_call">Call</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold btn-filter-tabsss" data-toggle="tab"
                            href="#tab_user">Tagging</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold btn-filter-tabsss" data-toggle="tab"
                            href="#tab_rating">Rating</a>
                    </li>
                    <li class="nav-item ml-auto">
                        <a class="nav-link font-weight-bold">
                            <div class="row">
                                <div class="col filter-appsss">
                                    <div class="d-flex">
                                        <div class="mr-3">Application</div>
                                        <select class="mr-3 form-control form-control-sm pt-0" style="height: 25px;"
                                            id="filter-app">
                                            <option value="all">All Application</option>
                                            <option value="fb">Facebook</option>
                                            <option value="ig">Instagram</option>
                                            <option value="wa">WA Business</option>
                                            <option value="cc">Call Center</option>
                                            <option value="wc">Web Chat</option>
                                            <option value="e">Email</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col d-flex">
                                    <div class="mr-3">Date&nbsp;Filter</div>
                                    <input type='date' class="form-control orm-control-sm" style="height: 25px;"
                                        value="<?php echo date('Y-m-d'); ?>" id="date-filter" />
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content pt-3">
                <div id="tab_conversation" class="tab-pane fade in active show" style="margin-top: 20px;">
                    @php
                        $data = [
                            [
                                (object) [
                                    // 'id' => 'new-email',
                                    'name' => 'Read Message',
                                    'color' => 'success',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                ],
                                (object) [
                                    // 'id' => 'new-email',
                                    'name' => 'Unread Message',
                                    'color' => 'danger',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                ],
                                (object) [
                                    // 'id' => 'new-email',
                                    'name' => 'Solved',
                                    'color' => 'primary',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                ],
                                (object) [
                                    // 'id' => 'new-email',
                                    'name' => 'Unsolved',
                                    'color' => 'primary',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                ],
                            ],
                            [
                                (object) [
                                    // 'id' => 'new-email',
                                    'name' => 'Total Conversations',
                                    'color' => 'success',
                                    // 'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                ],
                                (object) [
                                    // 'id' => 'new-email',
                                    'name' => 'Total Sent Message',
                                    'color' => 'danger',
                                    // 'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                ],
                                (object) [
                                    // 'id' => 'new-email',
                                    'name' => 'Total Incoming Call',
                                    'color' => 'primary',
                                    // 'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                ],
                            ],
                            [
                                (object) [
                                    // 'id' => 'new-email',
                                    'name' => 'Solved Conversations',
                                    'color' => 'success',
                                    // 'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                ],
                                (object) [
                                    // 'id' => 'new-email',
                                    'name' => 'Unsolved Conversations',
                                    'color' => 'danger',
                                    // 'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                ],
                                (object) [
                                    // 'id' => 'new-email',
                                    'name' => 'Total User',
                                    'color' => 'primary',
                                    // 'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                ],
                            ],
                        ];
                    @endphp
                    @foreach ($data as $d)
                        <div class="row filter-card all-card">
                            @foreach ($d as $v)
                                <div class="col-md-3 mb-3">
                                    <div class="card shadow">
                                        <a href="#" {!! !empty($v->type) ? 'data-toggle="modal" data-target="#modalMessageDetail"' : '' !!}>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    @if (!empty($v->icon))
                                                        <div class="bg-light-{{ $v->color }} mr-1">
                                                            <i
                                                                class="{{ $v->icon }} px-1 text-{{ $v->color }}"></i>
                                                        </div>
                                                    @endif
                                                    <h5 class="card-title text-muted mb-0">
                                                        {{ $v->name }}
                                                    </h5>
                                                </div>
                                                <span class="h1 font-weight-bold mb-0"
                                                    id="{{ !empty($v->id) ? $v->id : str_replace(' ', '-', strtolower($v->name)) }}">{{ $v->number }}</span>
                                                <p class="mt-3 mb-0 text-muted text-sm">
                                                    @if (!empty($v->percent_type) && $v->percent_type == 'down')
                                                        <span class="text-danger mr-2 font-weight-bold">
                                                            <i class="fas fa-arrow-down"></i>
                                                            <span
                                                                id="{{ !empty($v->id) ? 'p' . $v->id : 'p' . str_replace(' ', '-', strtolower($v->name)) }}">{{ $v->percent }}%</span>
                                                        </span>
                                                    @else
                                                        <span class="text-success mr-2 font-weight-bold">
                                                            <i class="fas fa-arrow-up"></i>
                                                            <span
                                                                id="{{ !empty($v->id) ? 'p' . $v->id : 'p' . str_replace(' ', '-', strtolower($v->name)) }}">{{ $v->percent }}%</span>
                                                        </span>
                                                    @endif
                                                    <span class="text-nowrap">Since yerterday</span>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="filter-card all-card" style="margin-top: 20px">
                        <div class="card bg-white shadow">
                            <div class="card-header bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h2 class="text-default mb-0">List Conversation</h2>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <button id="exporttable2" class="btn btn-primary">Export</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="1%">No</th>
                                                <th>Name</th>
                                                <th>Channel</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cm-tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row filter-card app-card" style="display: none">
                        @php
                            $data = [
                                // fb
                                (object) [
                                    'id' => 'fbf',
                                    'name' => 'Followers',
                                    'color' => 'primary',
                                    'icon' => 'far fa-user',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'fb',
                                ],
                                (object) [
                                    'id' => 'fbl',
                                    'name' => 'Likes',
                                    'color' => 'danger',
                                    'icon' => 'far fa-heart',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'fb',
                                ],
                                (object) [
                                    'id' => 'fbc',
                                    'name' => 'Comments',
                                    'color' => 'warning',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'fb',
                                ],
                                (object) [
                                    'id' => 'fbm',
                                    'name' => 'Message',
                                    'color' => 'primary',
                                    'icon' => 'far fa-user',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'fb',
                                ],
                                // ig
                                (object) [
                                    'id' => 'igf',
                                    'name' => 'Followers',
                                    'color' => 'primary',
                                    'icon' => 'far fa-user',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'ig',
                                ],
                                (object) [
                                    'id' => 'igl',
                                    'name' => 'Likes',
                                    'color' => 'danger',
                                    'icon' => 'far fa-heart',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'ig',
                                ],
                                (object) [
                                    'id' => 'igc',
                                    'name' => 'Comments',
                                    'color' => 'warning',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'ig',
                                ],
                                (object) [
                                    'id' => 'igm',
                                    'name' => 'Message',
                                    'color' => 'primary',
                                    'icon' => 'far fa-user',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'ig',
                                ],
                                // wa
                                (object) [
                                    'id' => 'war',
                                    'name' => 'Read Message',
                                    'color' => 'success',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'wa',
                                ],
                                (object) [
                                    'id' => 'wau',
                                    'name' => 'Unread Message',
                                    'color' => 'danger',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'wa',
                                ],
                                (object) [
                                    'id' => 'was',
                                    'name' => 'Solved',
                                    'color' => 'primary',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'wa',
                                ],
                                (object) [
                                    'id' => 'waun',
                                    'name' => 'Unolved',
                                    'color' => 'primary',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'wa',
                                ],
                                // cc
                                (object) [
                                    'id' => 'cca',
                                    'name' => 'Answered',
                                    'color' => 'success',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'cc',
                                ],
                                (object) [
                                    'id' => 'ccu',
                                    'name' => 'Unanswered',
                                    'color' => 'danger',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'cc',
                                ],
                                (object) [
                                    'id' => 'ccs',
                                    'name' => 'Solved',
                                    'color' => 'primary',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'cc',
                                ],
                                // wc
                                (object) [
                                    'id' => 'wcr',
                                    'name' => 'Read Message',
                                    'color' => 'success',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'wc',
                                ],
                                (object) [
                                    'id' => 'wcu',
                                    'name' => 'Unread Message',
                                    'color' => 'danger',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'wc',
                                ],
                                (object) [
                                    'id' => 'wcs',
                                    'name' => 'Solved',
                                    'color' => 'primary',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'wc',
                                ],
                                (object) [
                                    'id' => 'wcun',
                                    'name' => 'Unolved',
                                    'color' => 'primary',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'wc',
                                ],
                                // email
                                (object) [
                                    'id' => 'es',
                                    'name' => 'Sent Email',
                                    'color' => 'success',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'e',
                                ],
                                (object) [
                                    'id' => 'ei',
                                    'name' => 'Inbox',
                                    'color' => 'primary',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'e',
                                ],
                                (object) [
                                    'id' => 'es',
                                    'name' => 'Spam',
                                    'color' => 'danger',
                                    'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                                    'group' => 'e',
                                ],
                            ];
                        @endphp
                        @foreach ($data as $v)
                            <div class="col-md-3 mb-3 filter-card {{ $v->group }}-card">
                                <div class="card shadow">
                                    <a href="#" {!! !empty($v->type) ? 'data-toggle="modal" data-target="#modalMessageDetail"' : '' !!}>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light-{{ $v->color }}">
                                                    <i class="{{ $v->icon }} px-1 text-{{ $v->color }}"></i>
                                                </div>
                                                <h5 class="card-title text-muted mb-0 ml-1">
                                                    {{ $v->name }}
                                                </h5>
                                            </div>
                                            <span class="h1 font-weight-bold mb-0"
                                                id="{{ !empty($v->id) ? $v->id : '' }}">{{ $v->number }}</span>
                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                @if (!empty($v->percent_type) && $v->percent_type == 'down')
                                                    <span class="text-danger mr-2 font-weight-bold">
                                                        <i class="fas fa-arrow-down"></i>
                                                        <span
                                                            id="{{ !empty($v->id) ? 'p' . $v->id : '' }}">{{ $v->percent }}%</span>
                                                    </span>
                                                @else
                                                    <span class="text-success mr-2 font-weight-bold">
                                                        <i class="fas fa-arrow-up"></i>
                                                        <span
                                                            id="{{ !empty($v->id) ? 'p' . $v->id : '' }}">{{ $v->percent }}%</span>
                                                    </span>
                                                @endif
                                                <span class="text-nowrap">Since yerterday</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div id="tab_call" class="tab-pane fade in" style="margin-top: 20px;">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                @php
                                    $data = [
                                        (object) [
                                            'id' => 'incoming',
                                            'name' => 'Incoming Call',
                                            'color' => 'primary',
                                            'icon' => 'far fa-user',
                                            'number' => 0,
                                            'percent' => 0,
                                            'percent_type' => 'up',
                                        ],
                                        (object) [
                                            'id' => 'missed',
                                            'name' => 'Missed Call',
                                            'color' => 'danger',
                                            'icon' => 'far fa-user',
                                            'number' => 0,
                                            'percent' => 0,
                                            'percent_type' => 'up',
                                        ],
                                        (object) [
                                            'id' => 'hold',
                                            'name' => 'Hold',
                                            'color' => 'warning',
                                            'icon' => 'far fa-user',
                                            'number' => 0,
                                            'percent' => 0,
                                            'percent_type' => 'up',
                                        ],
                                        // (object) [
                                        //     // 'id' => 'new-email',
                                        //     'name' => 'Solved',
                                        //     'color' => 'primary',
                                        //     'icon' => 'far fa-comment',
                                        //     'number' => 0,
                                        //     'percent' => 0,
                                        //     'percent_type' => 'up',
                                        // ],
                                        // (object) [
                                        //     // 'id' => 'new-email',
                                        //     'name' => 'Unsolved',
                                        //     'color' => 'primary',
                                        //     'icon' => 'far fa-comment',
                                        //     'number' => 0,
                                        //     'percent' => 0,
                                        //     'percent_type' => 'up',
                                        // ],
                                    ];
                                @endphp
                                @foreach ($data as $v)
                                    <div class="col-md-4 mb-3">
                                        <div class="card shadow">
                                            <a href="#" {!! !empty($v->type) ? 'data-toggle="modal" data-target="#modalMessageDetail"' : '' !!}>
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-light-{{ $v->color }}">
                                                            <i
                                                                class="{{ $v->icon }} px-1 text-{{ $v->color }}"></i>
                                                        </div>
                                                        <h5 class="card-title text-muted mb-0 ml-1">
                                                            {{ $v->name }}
                                                        </h5>
                                                    </div>
                                                    <span class="h1 font-weight-bold mb-0"
                                                        id="{{ !empty($v->id) ? $v->id : '' }}">{{ $v->number }}</span>
                                                    <p class="mt-3 mb-0 text-muted text-sm">
                                                        @if (!empty($v->percent_type) && $v->percent_type == 'down')
                                                            <span class="text-danger mr-2 font-weight-bold">
                                                                <i class="fas fa-arrow-down"></i>
                                                                <span
                                                                    id="{{ !empty($v->id) ? 'p' . $v->id : '' }}">{{ $v->percent }}%</span>
                                                            </span>
                                                        @else
                                                            <span class="text-success mr-2 font-weight-bold">
                                                                <i class="fas fa-arrow-up"></i>
                                                                <span
                                                                    id="{{ !empty($v->id) ? 'p' . $v->id : '' }}">{{ $v->percent }}%</span>
                                                            </span>
                                                        @endif
                                                        <span class="text-nowrap">Since yerterday</span>
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h4 class="text-center">Call Status</h4>
                                    <!-- Chart -->
                                    {{-- <div class="chart" style="height: 200px;">
                                        <canvas id="chart-orders" class="chart-canvas"></canvas>
                                    </div> --}}
                                    <div id="chartdiv-p">
                                        <div id="chartdiv" style="height: 200px; width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 20px">
                        <div class="card bg-white shadow">
                            <div class="card-header bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h2 class="text-default mb-0">History</h2>
                                    </div>
                                    <div class="col-md-4 text-right"> <button id="exporttable22"
                                            class="btn btn-primary">Export</button> </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="datatable datatable22 table table-striped" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Nomor</th>
                                                <th scope="col">Respon</th>
                                                <th scope="col">Durasi</th>
                                                <th scope="col">Hasil</th>
                                            </tr>
                                        </thead>
                                        <tbody id="history-tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="tab_user" class="tab-pane fade in" style="margin-top: 20px;">
                    <div class="row">
                        @php
                            $data = [
                                // (object) [
                                //     // 'id' => 'new-email',
                                //     'name' => 'Active User',
                                //     'color' => 'success',
                                //     'icon' => 'far fa-comment',
                                //     'number' => 0,
                                //     'percent' => 0,
                                //     'percent_type' => 'up',
                                // ],
                                // // (object) [
                                // //     // 'id' => 'new-email',
                                // //     'name' => 'Pasive User',
                                // //     'color' => 'danger',
                                // //     'icon' => 'far fa-comment',
                                // //     'number' => 0,
                                // //     'percent' => 0,
                                // //     'percent_type' => 'up',
                                // // ],
                                // (object) [
                                //     // 'id' => 'new-email',
                                //     'name' => 'Total User',
                                //     'color' => 'primary',
                                //     'icon' => 'far fa-comment',
                                //     'number' => 0,
                                //     'percent' => 0,
                                //     'percent_type' => 'up',
                                // ],
                            ];

                            foreach ($tag as $v) {
                                $data[] = (object) [
                                    'id' => 'tags'.$v->id,
                                    'name' => $v->name,
                                    'color' => 'success',
                                    // 'icon' => 'far fa-comment',
                                    'number' => 0,
                                    'percent' => 0,
                                    'percent_type' => 'up',
                            ];
                            }
                        @endphp
                        @foreach ($data as $v)
                            <div class="col-md-3 mb-3">
                                <div class="card shadow">
                                    <a href="#">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                {{-- <div class="bg-light-{{ $v->color }}">
                                                    <i class="{{ $v->icon }} px-1 text-{{ $v->color }}"></i>
                                                </div> --}}
                                                <h5 class="card-title text-muted mb-0">
                                                    {{ $v->name }}
                                                </h5>
                                            </div>
                                            <span class="h1 font-weight-bold mb-0"
                                                id="{{ !empty($v->id) ? $v->id : '' }}">{{ $v->number }}</span>
                                            <p class="mt-3 mb-0 text-muted text-sm">
                                                @if (!empty($v->percent_type) && $v->percent_type == 'down')
                                                    <span class="text-danger mr-2 font-weight-bold">
                                                        <i class="fas fa-arrow-down"></i>
                                                        <span id="{{ !empty($v->id) ? 'p'.$v->id : '' }}">{{ $v->percent }}%</span>
                                                    </span>
                                                @else
                                                    <span class="text-success mr-2 font-weight-bold">
                                                        <i class="fas fa-arrow-up"></i>
                                                        <span id="{{ !empty($v->id) ? 'p'.$v->id : '' }}">{{ $v->percent }}%</span>
                                                    </span>
                                                @endif
                                                <span class="text-nowrap">Since yerterday</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card bg-white shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="text-default mb-0">List Tag Data</h2>
                                </div>
                                {{-- <div class="col-md-4 text-right">
                                    <button id="exporttable2" class="btn btn-primary">Export</button>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="1%">No</th>
                                            <th>Name</th>
                                            <th>Tag</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tag-tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="tab_rating" class="tab-pane fade in" style="margin-top: 20px;">
                    <div class="card bg-white shadow">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="text-default mb-0">List Rating Data</h2>
                                </div>
                                {{-- <div class="col-md-4 text-right">
                                    <button id="exporttable2" class="btn btn-primary">Export</button>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="1%">No</th>
                                            <th>Name</th>
                                            <th>Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rating-tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    {{-- <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script> --}}
    <script>
        $('#filter-app').change(function(e) {
            var val = $(this).val();
            $('.filter-card').hide();
            if (val == 'all') {
                $('.all-card').show();
            } else {
                $('.app-card').show();
                $(`.${val}-card`).show();
            }
        });
    </script>
@endpush
