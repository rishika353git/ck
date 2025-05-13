@extends('layouts.main')
@section('main-section')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                {{-- <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg"
                                    alt="User profile picture"> --}}
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('storage/' . $data->profile) }}" alt="User profile picture" height="128px"
                                    width="200px">
                            </div>

                            <h3 class="profile-username text-center">{{ $data->name }}</h3>

                            <p class="text-muted text-center">{{ $data->profile_tagline }}</p>


                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Status</b> <a class="float-right">
                                        @if ($data->card_verified == 1)
                                            Active User
                                        @elseif($data->card_verified == 2)
                                            Reject User
                                        @elseif ($data->card_verified == 3)
                                            Blocked User
                                        @else
                                            Pending
                                        @endif


                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>Followers</b> <a class="float-right">{{ $data->total_followers }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Following</b> <a class="float-right">{{ $data->total_follow }}</a>
                                </li>

                            </ul>

                            <a href="{{ $data->linkedin_profile }}" class="btn btn-primary btn-block"><b>Linkedin</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <strong><i class="fas fa-calendar mr-1"></i> Year Of Enrollment</strong>
                            {{-- <i class="fa-solid fa-calendar-days"></i> --}}
                            <p class="text-muted">{{ $data->year_of_enrollment }}</p>

                            <hr>


                            <strong><i class="fas fa-book mr-1"></i> Education</strong>

                            <p class="text-muted">
                                {{ $data->law_school }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-calendar mr-1"></i> Batch</strong>
                            {{-- <i class="fa-solid fa-calendar-days"></i> --}}
                            <p class="text-muted">{{ $data->batch }}</p>

                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1 mb-2"></i> Skills</strong>
                            <p class="text-muted">
                                @php
                                    $skills = json_decode($data->top_5_skills);
                                @endphp

                                @if (is_array($skills))
                                    @foreach ($skills as $skill)
                                        {{-- <span class="tag"
                                            style="border: 2px solid;
                                            padding: 3px;
                                            margin: 3px;
                                            margin-top : 5px;
                                            border-radius: 9px;">{{ $skill }}</span> --}}
                                        <span class="tag">#{{ $skill }},</span>
                                    @endforeach
                                @endif
                            </p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Description</strong>

                            <p class="text-muted">{{ $data->description }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Counsel
                                        Card</a></li>
                                <li class="nav-item"><a class="nav-link" href="#home_court" data-toggle="tab">Home Court</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#previous_experiences"
                                        data-toggle="tab">Previous Experiences</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#area_of_practice" data-toggle="tab">Area Of
                                        Practice</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Additional
                                        Details</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#acounts" data-toggle="tab">Account Details
                                    </a>
                                </li>

                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <!-- Post -->
                                    <div class="post">
                                        <div class="user-block">
                                            <span>Counsel Card Image</span>

                                        </div>
                                        <!-- /.user-block -->
                                        <div class="row mb-3">
                                            <div class="col-sm-6">
                                                <img class="img-fluid"
                                                    src="{{ asset('storage/' . $data->card_front) }}"
                                                    alt="Photo">
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-sm-6">
                                                <img class="img-fluid"
                                                    src="{{ asset('storage/' . $data->card_back) }}" alt="Photo">
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->



                                    </div>
                                    <!-- /.post -->
                                </div>

                                <div class="tab-pane" id="previous_experiences">
                                    <!-- The timeline -->


                                    @php
                                        $experiences = json_decode($data->previous_experiences);
                                    @endphp

                                    @if (is_array($experiences))
                                        @foreach ($experiences as $experiencesdata)
                                            <div class="timeline timeline-inverse">
                                                <div>


                                                    <div class="timeline-item">
                                                        <h3 class="timeline-header border-0">{{ $experiencesdata }}
                                                        </h3>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    @endif


                                    <!-- timeline time label -->


                                </div>

                                <div class="tab-pane" id="settings">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Contact Number</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" id="inputName" value="{{ $data->mobile }}"
                                                    placeholder="Name" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputName2"
                                                    value="{{ $data->email }}" placeholder="Name" readonly>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <div class="tab-pane" id="home_court">
                                    <!-- The timeline -->


                                    @php
                                        $homecourt = json_decode($data->home_courts);
                                    @endphp

                                    @if (is_array($homecourt))
                                        @foreach ($homecourt as $homecourtdata)
                                            <div class="timeline timeline-inverse">
                                                <div>


                                                    <div class="timeline-item">
                                                        <h3 class="timeline-header border-0">{{ $homecourtdata }}
                                                        </h3>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    @endif


                                    <!-- timeline time label -->


                                </div>

                                <div class="tab-pane" id="area_of_practice">
                                    <!-- The timeline -->


                                    @php
                                        $area_of_practice = json_decode($data->area_of_practice);
                                    @endphp

                                    @if (is_array($area_of_practice))
                                        @foreach ($area_of_practice as $practicedata)
                                            <div class="timeline timeline-inverse">
                                                <div>


                                                    <div class="timeline-item">
                                                        <h3 class="timeline-header border-0">{{ $practicedata }}
                                                        </h3>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    @endif


                                    <!-- timeline time label -->


                                </div>

                                <div class="tab-pane" id="acounts">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="info-box bg-light">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center text-muted">Available Balance
                                                    </span>
                                                    <span class="info-box-number text-center text-muted mb-0">{{ $wallet->total_coins }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                        <div class="card-body">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Serial No</th>
                                                        <th>Status</th>
                                                        {{-- <th>Transaction Id</th> --}}
                                                        <th>Amount</th>
                                                        <th>Used For</th>
                                                        <th>Transaction Date</th>
                                                        <th>Transaction Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $serial = 1; // Initialize serial number counter
                                                    @endphp

                                                    @foreach ($transactions as $data)
                                                        <tr class="text-center">
                                                            <td>{{ $serial++ }}</td>
                                                            <!-- Increment the serial number for each row -->
                                                            <td>
                                                                @if ($data->type == 0)
                                                                <span class="badge bg-danger">Debit</span>
                                                                @else
                                                                    <span class="badge bg-success">Credit</span>
                                                                @endif
                                                            </td>
                                                            {{-- <td>{{ $data->transaction_id }}</td> --}}
                                                            <td>{{ $data->amount }}</td>
                                                            <td>{{ $data->used_for }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-M-Y') }}</td>

                                                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('H:i:s') }}</td>


                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection()
