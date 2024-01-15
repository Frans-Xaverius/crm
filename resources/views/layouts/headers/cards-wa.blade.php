<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <div class="d-flex justify-content-between">
                <b style="font-size: x-large;">WA Business</b>
                <input type="date" class="form-control" style="width: 300px;" id="date-filter"
                    value="<?= date('Y-m-d') ?>" />
            </div>
            <!-- Card stats -->
            <div class="row" style="margin-top: 20px;">
                @php
                    $data = [
                        (object) [
                            'id' => 'read',
                            'name' => 'Read Message',
                            'color' => 'success',
                            'icon' => 'far fa-comment',
                            'number' => 0,
                            'percent' => 0,
                            'percent_type' => 'up',
                            'type' => 'tab',
                        ],
                        (object) [
                            'id' => 'unread',
                            'name' => 'Unread Message',
                            'color' => 'danger',
                            'icon' => 'far fa-comment',
                            'number' => 0,
                            'percent' => 0,
                            'percent_type' => 'up',
                            'type' => 'tab',
                        ],
                        (object) [
                            'id' => 'solved',
                            'name' => 'Solved',
                            'color' => 'primary',
                            'icon' => 'far fa-comment',
                            'number' => 0,
                            'percent' => 0,
                            'percent_type' => 'up',
                            'type' => 'tab',
                        ],
                        (object) [
                            'id' => 'unsolved',
                            'name' => 'Unsolved',
                            'color' => 'primary',
                            'icon' => 'far fa-comment',
                            'number' => 0,
                            'percent' => 0,
                            'percent_type' => 'up',
                            'type' => 'tab',
                        ],
                    ];
                @endphp
                @foreach ($data as $v)
                    <div class="col-md-3 mb-sm-3 mb-md-0">
                        <div class="card shadow">
                            <a href="#" {!! !empty($v->type) && $v->type == 'modal' ? 'data-toggle="modal" data-target="#modalMessageDetail"' : '' !!}{!! !empty($v->type) && $v->type == 'tab' ? 'class="btn-table-tab" data-target="#' . $v->id . '-tab"' : '' !!}>
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
                                        <span class="text-nowrap">Since yesterday</span>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Divider -->
            <hr class="my-3">
        </div>
    </div>
</div>
