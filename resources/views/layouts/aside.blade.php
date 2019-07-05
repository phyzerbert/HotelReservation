@php
    $page = config('site.page');
    $role = Auth::user()->role->slug;
@endphp
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
    <div class="sidebar-mobile-toggler text-center">
        <a href="form_checkboxes_radios.html#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="form_checkboxes_radios.html#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>

    <div class="sidebar-content">
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="#"><img src="@if (isset(Auth::user()->picture)){{asset(Auth::user()->picture)}} @else {{asset('images/avatar128.png')}} @endif" width="38" height="38" class="rounded-circle" alt=""></a>
                    </div>
                    <div class="media-body">
                        <div class="media-title font-weight-semibold">{{ Auth::user()->name }}</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-user font-size-sm"></i> &nbsp;{{ Auth::user()->role->name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item"><a href="{{route('home')}}" class="nav-link @if($page == 'home') active @endif"><i class="icon-home4"></i><span> Dashboard</span></a></li>
                <li class="nav-item"><a href="{{route('reservation.index')}}" class="nav-link @if($page == 'reservation') active @endif"><i class="icon-list2"></i><span> Reservation</span></a></li>
                @if ($role != 'data_editor')
                    <li class="nav-item"><a href="{{route('hotel.index')}}" class="nav-link @if($page == 'hotel') active @endif"><i class="icon-bed2"></i><span> Hotel</span></a></li>
                    <li class="nav-item"><a href="{{route('users.index')}}" class="nav-link @if($page == 'user') active @endif"><i class="icon-users2"></i><span> User</span></a></li>
                @endif
            </ul>
        </div>
    </div>    
</div>