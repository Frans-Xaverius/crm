<?php
function percentageValidation($param){
    $result = array();
    $result['icon'] = 'up';
    $result['color'] = 'success';
    if($param < 0){
        $result['icon'] = 'down';
        $result['color'] = 'danger';
    }
    return $result;
}

function cleanDate($param){
    return date('d-m-Y',strtotime(str_replace('-','/',$param)));
}
?>
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <b style="font-size: x-large;">Instagram</b>
            <input type='date' class="form-control" style="display: inline-flex!important; margin-left: 550px; width: 300px;" value="<?php echo isset($_GET['date']) ? $_GET['date'] : date("Y-m-d")?>" onChange="window.location.href = '?date='+this.value;" />
            <!-- Card stats -->
            <div class="row" style="margin-top: 20px;">
                <div class="col-xl-12">
                    <div class="card <?php echo (isset($page) && $page == 'followers') ? 'shadow card-active' : '';?>" style="width: 230px; display: inline-block; margin-right: 15px; margin-bottom: 20px;">
                        <a href="{{ route('application.instagram') }}/followers">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div style="background-color: lightblue; float: left; position: absolute; top: -5px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="12" fill="currentColor" class="bi bi-person-square text-blue" viewBox="0 0 16 16" style="margin-top: -3px;">
                                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z"/>
                                            </svg>
                                        </div>
                                        <h5 class="card-title text-muted mb-0 ml-4">
                                            Followers
                                        </h5>
                                        <span class="h1 font-weight-bold mb-0">1,97</span>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-success mr-2 font-weight-bold"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                    <span class="text-nowrap">Since yerterday</span>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="card <?php echo (isset($page) && $page == 'likes') ? 'shadow card-active' : '';?>" style="width: 230px; display: inline-block; margin-right: 15px;">
                        <a href="{{ route('application.instagram') }}/likes">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div style="background-color: pink; float: left; position: absolute; top: -5px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="12" fill="currentColor" class="bi bi-heart text-danger" viewBox="0 0 16 16" style="margin-top: -3px;">
                                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                            </svg>
                                        </div>
                                        <h5 class="card-title text-muted mb-0 ml-4">
                                            Likes
                                        </h5>
                                        <span class="h1 font-weight-bold mb-0">2,356</span>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-danger mr-2 font-weight-bold"><i class="fas fa-arrow-down"></i> 3.48%</span>
                                    <span class="text-nowrap">Since yerterday</span>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="card <?php echo (isset($page) && $page == 'comments') ? 'shadow card-active' : '';?>" style="width: 230px; display: inline-block; margin-right: 15px;">
                        <a href="{{ route('application.instagram') }}/comments">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div style="background-color: #FFCD9F; float: left; position: absolute; top: -5px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="12" fill="currentColor" class="bi bi-chat-left text-warning" viewBox="0 0 16 16" style="margin-top: -3px;">
                                                <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                            </svg>
                                        </div>
                                        <h5 class="card-title text-muted mb-0 ml-4">
                                            Comments
                                        </h5>
                                        <span class="h1 font-weight-bold mb-0">924</span>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2 font-weight-bold"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                    <span class="text-nowrap">Since yesterday</span>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="card" style="width: 230px; display: inline-block; margin-right: 15px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div style="background-color: lightblue; float: left; position: absolute; top: -5px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="12" fill="currentColor" class="bi bi-person-square text-blue" viewBox="0 0 16 16" style="margin-top: -3px;">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z"/>
                                        </svg>
                                    </div>
                                    <h5 class="card-title text-muted mb-0 ml-4">
                                        Read
                                    </h5>
                                    <span class="h1 font-weight-bold mb-0">49,65%</span>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2 font-weight-bold"><i class="fas fa-arrow-up"></i> 12%</span>
                                <span class="text-nowrap">Since yerterday</span>
                            </p>
                        </div>
                    </div>
                    <div class="card" style="width: 230px; display: inline-block; margin-right: 15px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div style="background-color: lightblue; float: left; position: absolute; top: -5px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="12" fill="currentColor" class="bi bi-person-square text-blue" viewBox="0 0 16 16" style="margin-top: -3px;">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z"/>
                                        </svg>
                                    </div>
                                    <h5 class="card-title text-muted mb-0 ml-4">
                                        Unread
                                    </h5>
                                    <span class="h1 font-weight-bold mb-0">49,65%</span>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2 font-weight-bold"><i class="fas fa-arrow-up"></i> 12%</span>
                                <span class="text-nowrap">Since yerterday</span>
                            </p>
                        </div>
                    </div>
                    <div class="card" style="width: 230px; display: inline-block; margin-right: 15px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div style="background-color: lightblue; float: left; position: absolute; top: -5px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="12" fill="currentColor" class="bi bi-person-square text-blue" viewBox="0 0 16 16" style="margin-top: -3px;">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z"/>
                                        </svg>
                                    </div>
                                    <h5 class="card-title text-muted mb-0 ml-4">
                                        Solved
                                    </h5>
                                    <span class="h1 font-weight-bold mb-0">49,65%</span>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2 font-weight-bold"><i class="fas fa-arrow-up"></i> 12%</span>
                                <span class="text-nowrap">Since yerterday</span>
                            </p>
                        </div>
                    </div>
                    <div class="card" style="width: 230px; display: inline-block; padding">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div style="background-color: lightblue; float: left; position: absolute; top: -5px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="12" fill="currentColor" class="bi bi-person-square text-blue" viewBox="0 0 16 16" style="margin-top: -3px;">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z"/>
                                        </svg>
                                    </div>
                                    <h5 class="card-title text-muted mb-0 ml-4">
                                        Unsolved
                                    </h5>
                                    <span class="h1 font-weight-bold mb-0">49,65%</span>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2 font-weight-bold"><i class="fas fa-arrow-up"></i> 12%</span>
                                <span class="text-nowrap">Since yerterday</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Divider -->
            <hr class="my-3">
        </div>
    </div>
</div>
