@php

    $users = DB::table('users')
        ->where('id', Auth::user()->id)
        ->first();
    $orders = DB::table('orders')->where('status', 'pending')->orderBy('id', 'desc')->limit(5)->get();
@endphp

<nav class="navbar-custom">
    <ul class="list-inline float-right mb-0">
        <li class="list-inline-item notification-list dropdown d-none d-sm-inline-block">
            {{-- <form role="search" class="app-search">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" placeholder="Search..">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form> --}}
        </li>

        <li class="list-inline-item dropdown notification-list">
            {{-- <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
               aria-haspopup="false" aria-expanded="false">
                <i class="mdi mdi-bell-outline noti-icon"></i>
                <span class="badge badge-success badge-pill noti-icon-badge" id="notify_count">{{count($orders)}}</span>
            </a> --}}
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg">

                <!-- <div class="slimscroll" style="max-height: 230px;height:auto!important" id="notification_list">
                   <a>New Order</a>
                </div> -->

                <!-- All-->
                @foreach ($orders as $ord)
                    @php
                        $customer = DB::table('users')->where('id', $ord->customer_id)->first();

                        $ordered_time = now()->diffInMinutes($ord->created_at);

                    @endphp
                    <a href="{{ url('view_detail') . '/' . $ord->id }}">
                        <h6 class="text-sm font-weight-normal mb-1 ml-3">
                            <span class="font-weight-bold">New Order</span> from {{ $customer->name }}
                        </h6>
                        <p class="text-xs text-secondary mb-0 ml-3">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>

                            {{ now()->diffForHumans($ord->created_at) }}
                        </p>
                    </a>
                @endforeach

            </div>
        </li>

        <li class="list-inline-item dropdown notification-list">
            <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#"
                role="button" aria-haspopup="false" aria-expanded="false">
                @php
                    $photo = Auth::user()->photo;
                    $photo = str_replace(['http://127.0.0.1:8000/public/', 'http://127.0.0.1:8001/public/'], '', $photo);
                    if ($photo && !str_starts_with($photo, 'http')) {
                        $photo = asset($photo);
                    }
                @endphp
                <img src="{{ $photo ? $photo : asset('frontend/img/user.png') }}" alt="user" class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle m-r-5 text-muted"></i>
                    {{ Auth::user()->name }}</a>
                <a class="dropdown-item" href="{{ route('user.edit', Auth::user()->id) }}"><i
                        class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>

                <!--<a class="dropdown-item" href="#"><span class="badge badge-success mt-1 float-right">5</span><i class="mdi mdi-settings m-r-5 text-muted"></i> Settings</a>
                <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5 text-muted"></i> Lock screen</a>-->
                <a class="dropdown-item" href="{{ url('change_password') }}">
                    <i class="mdi mdi-logout m-r-5 text-muted"></i>
                    {{ __('Change Password') }}
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                    <i class="mdi mdi-logout m-r-5 text-muted"></i>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

    </ul>

    <ul class="list-inline menu-left mb-0">
        <li class="list-inline-item">
            <button type="button" class="button-menu-mobile open-left waves-effect">
                <i class="ion-navicon"></i>
            </button>
        </li>
    </ul>

    <div class="clearfix"></div>

</nav>
