<!DOCTYPE html>
<html lang="en">
@include('layouts.header')

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->

            <ul class="ml-auto navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="far fa-bell"></i>
                        @if(session('notifications') && session('notifications')->count() > 0)
                        <span class="badge badge-warning navbar-badge">{{session('notifications')->count()}}</span>
                        @else

                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        @if(session('notifications') && session('notifications')->count() > 0)
                        <span class="dropdown-header">{{session('notifications')->count() > 0}} Notifications</span>
                        <div class="dropdown-divider"></div>
                        @foreach(session('notifications') as $notification)

                        <form method="POST" action="{{ route('notifications.read') }}">
                            @csrf



                            <x-responsive-nav-link :href="route('notifications.read')" 
                            onclick="event.preventDefault();
                            this.closest('form').submit();"
                                class="dropdown-item">
                                <div class="media">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            <b>{{ $notification->data['peminjaman_kode'] }}</b>
                                        </h3>
                                        {{-- <p class="text-sm">{{ $notification->data['message'] }}</p> --}}
                                        <p class="text-sm text-muted"><i
                                                class="mr-1 far fa-clock"></i>{{$notification->created_at->diffForHumans()}}
                                        </p>
                                    </div>
                                </div>
                            </x-responsive-nav-link>
                        </form>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                        @else
                        <span class="dropdown-header">0 Notifications</span>
                        <a href="#" class="dropdown-item">
                            <i class="mr-2 fas fa-envelope"></i> There are no new notifications
                            <span class="float-right text-sm text-muted"></span>
                        </a>
                        @endif
                    </div>
                </li>
                <li class="mt-1 nav-item">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); confirmLogOut(this);">
                            <i class="fas fa-sign-out-alt"></i>
                        </x-responsive-nav-link>
                    </form>

                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/" class="brand-link">
                <img src="{{ asset('adminlte/') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">BTM Wahana Mentari</span>
            </a>
            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <!-- Main content -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="mb-2 row">
                        <div class="col-sm-6">
                            <h1>Halaman @yield('title')</h1>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- /.container-fluid -->
            </section>
            @yield('content')
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('layouts.footer')
        <!-- ./footer -->
    </div>
    <!-- ./wrapper -->
    @include('layouts.scripts')
    <!-- ./scripts -->
</body>

</html>