<div class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-brand">
        <a href="{{route('home')}}" class="d-inline-block">
            <img src="{{asset('master/global_assets/images/logo_light.png')}}" alt="">
        </a>
    </div>

    <div class="d-md1-none" id="mobile_sidebar_control">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav" style="margin-right:-68px;">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
        </ul>

        <span class="badge bg-success ml-md-3 mr-md-auto">Online</span>
        @php
            $role = Auth::user()->role->slug;
            $unreads = '';
            if($role == 'general_manager'){
                $unreads = \App\Models\Notification::where('gm_status', 0)->count();
            }
            if($role == 'office_manager'){
                $unreads = \App\Models\Notification::where('0m_status', 0)->count();
            }
        @endphp
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a href="animations_velocity_basic.html#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                    <i class="icon-bell3"></i>
                    <span class="d-md-none ml-2">Notifications</span>
                    <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{$unreads}}</span>
                </a>
                @php
                    $recent_messages = \App\Models\Notification::orderBy('created_at', 'desc')->limit(5)->get();
                @endphp
                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                    <div class="dropdown-content-header d-block text-center">
                        <span class="font-weight-semibold">Notifications</span>
                    </div>
                    <hr class="my-0">
                    <div class="dropdown-content-body dropdown-scrollable">
                        <ul class="media-list">
                            @foreach ($recent_messages as $item)
                                @php
                                    $posted_time = new DateTime($item->created_at);
                                    $now = new DateTime();
                                    $interval = $posted_time->diff($now);
                                    if($interval->d >= 1){
                                        $time = $interval->d. " Days";
                                    }else if($interval->h >= 1){
                                        $time = $interval->h. " Hours";
                                    }else if($interval->i >= 1){
                                        $time = $interval->i. " Mins";
                                    }else{
                                        $time = "Just Now";
                                    }                                    
                                @endphp 
                                <li class="media">
                                    <div class="mr-3 position-relative">                                        
                                            @switch($item->type)
                                                @case("new_reservation")
                                                    <a href="{{route('reservation.edit', $item->reservation->id).'?read='.$item->id}}" class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon">
                                                        <i class="icon-new"></i>
                                                    </a>
                                                    @break
                                                @case("om_accept")
                                                    <a href="{{route('reservation.edit', $item->reservation->id).'?read='.$item->id}}" class="btn bg-transparent border-info text-info rounded-round border-2 btn-icon">
                                                        <i class="icon-file-check"></i>
                                                    </a>
                                                    @break
                                                @case("gm_accept")
                                                    <a href="{{route('reservation.edit', $item->reservation->id).'?read='.$item->id}}" class="btn bg-transparent border-success text-success rounded-round border-2 btn-icon">
                                                        <i class="icon-file-check2"></i>
                                                    </a>
                                                    @break
                                                @default
                                                    <a href="{{route('reservation.edit', $item->reservation->id).'?read='.$item->id}}" class="btn bg-transparent border-warning text-warning rounded-round border-2 btn-icon">
                                                        <i class="icon-bubble-notification"></i>
                                                    </a>
                                            @endswitch
                                        
                                    </div>

                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="{{route('reservation.edit', $item->reservation->id).'?read='.$item->id}}">                                                
                                                    @switch($item->type)
                                                        @case("new_reservation")
                                                            <span class="font-weight-semibold text-primary">New Reservation</span>
                                                            @break
                                                        @case("om_accept")
                                                            <span class="font-weight-semibold text-info">Office Manager Accept</span>
                                                            @break
                                                        @case("gm_accept")
                                                            <span class="font-weight-semibold text-success">General Manager Accept</span>
                                                            @break
                                                        @default
                                                            <span class="font-weight-semibold text-warning">New Nofification</span>
                                                    @endswitch 
                                                
                                                <span class="text-muted float-right font-size-sm"> {{$time}} </span>
                                            </a>
                                        </div>
                                        <span class="text-muted">{{$item->content}}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="dropdown-content-footer justify-content-center p-0">
                        <a href="{{route('notification.index')}}" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Load more"><i class="icon-menu7 d-block top-0"></i></a>
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                    <img src="@if (isset(Auth::user()->picture)){{asset(Auth::user()->picture)}} @else {{asset('images/avatar128.png')}} @endif" class="rounded-circle mr-2" height="34" alt="">
                    <span>{{Auth::user()->name}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{route('profile')}}" class="dropdown-item"><i class="icon-user-plus"></i> My Profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" class="dropdown-item">
                    <i class="icon-switch2"></i> Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>