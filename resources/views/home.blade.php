@extends('layouts.main')
@section('main-section')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-coins"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Income</span>
                            <span class="info-box-number">
                                10
                                <small>₹</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ route('courts') }}" style="color: #000 !important;">
                        <div class="info-box mb-3">

                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-building"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Courts</span>
                                <span class="info-box-number">{{ $courtCount }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </a>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <a href="{{ route('subcourts') }}" style="color: #000 !important;">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-building"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Sub Courts</span>
                                <span class="info-box-number">{{ $subCourtCount }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                </a>
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">

                <a href="{{ route('all.users') }}" style="color: #000 !important;">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Users</span>
                            <span class="info-box-number">{{ $usersCount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->



        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-8">
                <!-- USERS LIST -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Latest Members</h3>

                        <div class="card-tools">
                            {{-- <span class="badge badge-danger">8 New Members</span> --}}
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <ul class="users-list clearfix">
                            @foreach ($users as $user)
                                <li>
                                    <img src="{{ asset('storage/' . $user->profile) }}" alt="User Image" class="profile-image rounded-circle" style="height: 100px !important; width: 100px !important; object-fit: cover;">


                                    <a class="users-list-name" href="{{ route('profile', ['id' => $user->id]) }}">{{ $user->name }}</a>
                                    <span
                                        class="users-list-date">{{ \Carbon\Carbon::parse($user->created_at)->format('d-M-Y') }}
                                    </span>
                                </li>
                            @endforeach


                        </ul>
                        <!-- /.users-list -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="{{ route('all.users') }}">View All Users</a>
                    </div>
                    <!-- /.card-footer -->
                </div>


            </div>
            <!-- /.col -->

            <div class="col-md-4">
                <!-- Info Boxes Style 2 -->
                <a href="{{ route('pendinguser') }}" style="color: #000 !important;">
                    <div class="info-box mb-3 bg-warning">
                        <span class="info-box-icon"><i class="fas fa-user-clock "></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Inactive Users</span>
                            <span class="info-box-number">{{ $inactiveUsersCount }}</span>
                        </div>

                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
                <a href="{{ route('activeuser') }}" style="color: #000 !important;">
                    <div class="info-box mb-3 bg-success">
                        <span class="info-box-icon"><i class="fas fa-user-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Active Users</span>
                            <span class="info-box-number">{{ $activeUsersCount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
                <a href="{{ route('rejectuser') }}" style="color: #000 !important;">
                    <div class="info-box mb-3 bg-info">
                        <span class="info-box-icon"><i class="fas fa-user-ninja"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Reject Users</span>
                            <span class="info-box-number">{{ $rejectUsersCount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
                <a href="{{ route('blockeduser') }}" style="color: #000 !important;">
                    <div class="info-box mb-3 bg-danger">
                        <span class="info-box-icon"><i class="fas fa-user-slash"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Blocked User</span>
                            <span class="info-box-number">{{ $blockedUserCount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->



                <!-- PRODUCT LIST -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recently Added Courts</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach ($courts as $court)
                                <li class="item">
                                    <div class="product-img">
                                        <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">{{ $court->name }}
                                            <span class="badge badge-warning float-right">
                                                {{ \Carbon\Carbon::parse($court->created_at)->format('d-M-Y') }}</span></a>
                                    </div>
                                </li>
                            @endforeach


                        </ul>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <a href="{{ route('courts') }}" class="uppercase">View All Courts</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection()
