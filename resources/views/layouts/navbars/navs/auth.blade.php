<?php
$currentURL = URL::current();
$breadcrumb = array();
$breadcrumb[0]['title'] = 'Dashboard';
$breadcrumb[0]['url'] = '/home';

if(str_contains($currentURL, 'facebook')){
    $breadcrumb[1]['title'] = 'Application / Facebook';
    $breadcrumb[1]['url'] = '/application/facebook';
}else if(str_contains($currentURL, 'instagram')){
    $breadcrumb[1]['title'] = 'Application / Instagram';
    $breadcrumb[1]['url'] = '/application/instagram';
}else if(str_contains($currentURL, 'whatsapp')){
    $breadcrumb[1]['title'] = 'Application / WhatsApp';
    $breadcrumb[1]['url'] = '/application/whatsapp';
}else if(str_contains($currentURL, 'call-center')){
    $breadcrumb[1]['title'] = 'Application / Call Center';
    $breadcrumb[1]['url'] = '/application/call-center';
}else if(str_contains($currentURL, 'webchat')){
    $breadcrumb[1]['title'] = 'Application / Web Chat';
    $breadcrumb[1]['url'] = '/application/webchat';
}else if(str_contains($currentURL, 'email')){
    $breadcrumb[1]['title'] = 'Application / Email';
    $breadcrumb[1]['url'] = '/application/email';
}else if(str_contains($currentURL, 'customer-monitoring')){
    $breadcrumb[1]['title'] = 'Customer Monitoring';
    $breadcrumb[1]['url'] = '/customer-monitoring';
}else if(str_contains($currentURL, 'report')){
    $breadcrumb[1]['title'] = 'Report';
    $breadcrumb[1]['url'] = '/report';
}else if(str_contains($currentURL, 'account-management')){
    $breadcrumb[1]['title'] = 'Setting / Account Management';
    $breadcrumb[1]['url'] = '/setting/account-management';
}else if(str_contains($currentURL, 'agent-management')){
    $breadcrumb[1]['title'] = 'Setting / Agent Management';
    $breadcrumb[1]['url'] = '/setting/agent-management';
}else if(str_contains($currentURL, 'help')){
    $breadcrumb[1]['title'] = 'Help';
    $breadcrumb[1]['url'] = '/help';
}else if(str_contains($currentURL, 'profile')){
    $breadcrumb[1]['title'] = 'Profile';
    $breadcrumb[1]['url'] = '/profile';
}

if(isset($page)){
    $breadcrumb[2]['title'] = ucfirst($page);
    $breadcrumb[2]['url'] = '/'.$page;
}
?>
<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md" id="navbar-main">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2 mt-3">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <?php foreach ($breadcrumb as $key => $value) {
              if($key === (count($breadcrumb)-1)){?>
                <li class="breadcrumb-item active"><?php echo $value['title'] ?></li>
              <?php }else{?>
                <li class="breadcrumb-item"><a href="<?php echo $value['url'] ?>"><?php echo $key == 0 ? '<i class="fas fa-home"></i>' : $value['title'] ?></a></li>
              <?php }
              } ?>
          </ol>
        </nav>
        <?php /*
        <!-- Form -->
        <form class="navbar-search form-inline mr-3 d-none d-md-flex ml-lg-auto">
            <div class="form-group mb-0">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input class="form-control" placeholder="Search" type="text">
                </div>
            </div>
        </form>*/?>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="ni ni-circle-08" style="font-size: 20px;"></span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
    <?php /*
    <section style="background-color: #eee;">
        <div class="container py-5">
      
          <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-6">
      
              <div class="card" id="chat2">
                <div class="card-header d-flex justify-content-between align-items-center p-3">
                  <h5 class="mb-0">Chat</h5>
                  <button type="button" class="btn btn-primary btn-sm" data-mdb-ripple-color="dark">Let's Chat
                    App</button>
                </div>
                <div class="card-body" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">
      
                  <div class="d-flex flex-row justify-content-start">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                      alt="avatar 1" style="width: 45px; height: 100%;">
                    <div>
                      <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Hi</p>
                      <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">How are you ...???
                      </p>
                      <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">What are you doing
                        tomorrow? Can we come up a bar?</p>
                      <p class="small ms-3 mb-3 rounded-3 text-muted">23:58</p>
                    </div>
                  </div>
      
                  <div class="divider d-flex align-items-center mb-4">
                    <p class="text-center mx-3 mb-0" style="color: #a2aab7;">Today</p>
                  </div>
      
                  <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                    <div>
                      <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Hiii, I'm good.</p>
                      <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">How are you doing?</p>
                      <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Long time no see! Tomorrow
                        office. will
                        be free on sunday.</p>
                      <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">00:06</p>
                    </div>
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava4-bg.webp"
                      alt="avatar 1" style="width: 45px; height: 100%;">
                  </div>
      
                  <div class="d-flex flex-row justify-content-start mb-4">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                      alt="avatar 1" style="width: 45px; height: 100%;">
                    <div>
                      <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Okay</p>
                      <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">We will go on
                        Sunday?</p>
                      <p class="small ms-3 mb-3 rounded-3 text-muted">00:07</p>
                    </div>
                  </div>
      
                  <div class="d-flex flex-row justify-content-end mb-4">
                    <div>
                      <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">That's awesome!</p>
                      <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">I will meet you Sandon Square
                        sharp at
                        10 AM</p>
                      <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Is that okay?</p>
                      <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">00:09</p>
                    </div>
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava4-bg.webp"
                      alt="avatar 1" style="width: 45px; height: 100%;">
                  </div>
      
                  <div class="d-flex flex-row justify-content-start mb-4">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                      alt="avatar 1" style="width: 45px; height: 100%;">
                    <div>
                      <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Okay i will meet
                        you on
                        Sandon Square</p>
                      <p class="small ms-3 mb-3 rounded-3 text-muted">00:11</p>
                    </div>
                  </div>
      
                  <div class="d-flex flex-row justify-content-end mb-4">
                    <div>
                      <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Do you have pictures of Matley
                        Marriage?</p>
                      <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">00:11</p>
                    </div>
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava4-bg.webp"
                      alt="avatar 1" style="width: 45px; height: 100%;">
                  </div>
      
                  <div class="d-flex flex-row justify-content-start mb-4">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                      alt="avatar 1" style="width: 45px; height: 100%;">
                    <div>
                      <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Sorry I don't
                        have. i
                        changed my phone.</p>
                      <p class="small ms-3 mb-3 rounded-3 text-muted">00:13</p>
                    </div>
                  </div>
      
                  <div class="d-flex flex-row justify-content-end">
                    <div>
                      <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Okay then see you on sunday!!
                      </p>
                      <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">00:15</p>
                    </div>
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava4-bg.webp"
                      alt="avatar 1" style="width: 45px; height: 100%;">
                  </div>
      
                </div>
                <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
                  <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                    alt="avatar 3" style="width: 40px; height: 100%;">
                  <input type="text" class="form-control form-control-lg" id="exampleFormControlInput1"
                    placeholder="Type message">
                  <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                  <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                  <a class="ms-3" href="#!"><i class="fas fa-paper-plane"></i></a>
                </div>
              </div>
      
            </div>
          </div>
      
        </div>
      </section>
      */ ?>
</nav>