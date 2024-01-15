@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-fb')

    <div class="container-fluid mt--8">
        <div class="row">
            <div class="col-xl-12 mb-2 mb-xl-0">
                <div class="card bg-white shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="text-default mb-0"><?php echo isset($_GET['date']) ? ucfirst($page) . ' (' . cleanDate($_GET['date']) . ')' : ucfirst($page); ?></h2>
                            </div>
                            <div class="col-md-4 text-right"> <button id="exporttable" class="btn btn-primary">Export</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="htmltable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Date</th>
                                    <?php if($page == 'followers'){?>
                                    <th scope="col">Followers</th>
                                    <?php }else if($page == 'likes'){?>
                                    <th scope="col">Likes</th>
                                    <?php }else{?>
                                    <th scope="col">Comments</th>
                                    <?php }?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($db as $val){?>
                                <tr>
                                    <th scope="row"><?php echo $val->name; ?></th>
                                    <td><?php echo $val->email; ?></td>
                                    <td><?php echo $val->date; ?></td>
                                    <?php if($page == 'followers'){?>
                                    <td><?php echo number_format($val->followers); ?></td>
                                    <?php }else if($page == 'likes'){?>
                                    <td><?php echo number_format($val->likes); ?></td>
                                    <?php }else{?>
                                    <td><?php echo number_format($val->comments); ?></td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
