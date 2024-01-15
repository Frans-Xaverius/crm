@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards-wa')

    <div class="container-fluid mt--8">
        <div class="row">
            <div class="col-xl-12 mb-2 mb-xl-0">
                <div class="card bg-white shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="text-default mb-0"><?php echo ucfirst($page); ?></h2>
                            </div>
                            <?php /*<div class="col-md-4 text-right"> <button id="exporttable" class="btn btn-primary">Export</button> </div>*/?>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="htmltable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($x = 0; $x < 10; $x++){
                              $faker = \Faker\Factory::create();?>
                                <tr>
                                    <th scope="row"><?php echo $faker->name; ?></th>
                                    <td><?php echo $faker->email; ?></td>
                                    <td><?php echo $faker->numberBetween(100, 700); ?></td>
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
