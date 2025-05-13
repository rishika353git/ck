@extends('layouts.main')
@section('main-section')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            @if (Session::has('success'))
                <script>
                    swal("success", "{{ Session::get('success') }}", "success", {
                        button: true,
                        button: "OK",
                        //timer: 3000,
                        dangerMode: true,
                    });
                </script>
            @elseif (Session::has('delete'))
                <script>
                    swal("success", "{{ Session::get('delete') }}", "success", {
                        button: true,
                        button: "OK",
                        //timer: 3000,
                        dangerMode: true,
                    });
                </script>
            @elseif(Session::has('error'))
                <script>
                    swal("error", "{{ Session::get('error') }}", "info", {
                        button: true,
                        button: "OK",
                        //timer: 3000,
                        dangerMode: true,
                    });
                </script>
            @endif


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-sm-6 section-1" style="float: left !important;">
                                        <h2 class="card-title">Widthrawal Request</h2>
                                    </div>
                                    {{-- <div class="col-sm-6 section-2"
                                        style="float: left !important; text-align: right !important;">
                                        <button type="button" class="btn bg-primary"><a
                                                href="{{ route('courts.create') }}">Add Courts</a></button>
                                    </div> --}}
                                </div>
                            </div>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>Serial No</th>
                                        <th>Name</th>
                                        <th>Widthrawal Amount</th>
                                        <th>Request Status</th>
                                        <th>Wallet Amount</th>
                                        <th>Wallet Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $serial = 1; // Initialize serial number counter
                                    @endphp
                                    @foreach ($requests as $data)
                                        <tr class="text-center">
                                            <td>{{ $serial++ }}</td> <!-- Increment the serial number for each row -->
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->coins }}</td>
                                            @if ($data->request_status == 0)
                                                <td><span class="badge bg-danger">Pending</span></td>
                                            @else
                                                <td><span class="badge bg-success">Success</span></td>
                                            @endif()
                                            <td>{{ $data->total_coins }}</td>
                                            @if ($data->status == 0)
                                                <td><span class="badge bg-danger">Deactive</span></td>
                                            @else
                                                <td><span class="badge bg-success">Active</span></td>
                                            @endif()

                                            <td class="project-actions">
                                                @if($data->request_status == 0)
                                                <form action="{{ route('withdrawal.approve') }}" method="POST">
                                                    @csrf
                                                        <input type="hidden" name='user_id' value="{{ $data->user_id }}"/>
                                                        <input type="hidden" name="wallet_id" value="{{ $data->wallet_id }}"/>
                                                        <input type="hidden" name="withdrawal_request_id" value="{{ $data->withdrawal_id }}"/>
                                                        <button type="submit" class="btn btn-info" >Approve</button>
                                                   </form>
                                                @else
                                                <a class="btn btn-danger btn-sm">
                                                        Approved
                                                    </a>
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection()
