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
                                    <h2 class="card-title">Drafts Categories</h2>
                                </div>
                                <div class="col-sm-6 section-2" style="float: left !important; text-align: right !important;">
                                    <button type="button" class="btn bg-primary"><a href="{{ route('drafts.create') }}">Add Drafts</a></button>
                                </div>
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
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $serial = 1; // Initialize serial number counter
                                    @endphp
                                    @foreach ($drafts as $draft)
                                    <tr class="text-center">
                                        <td>{{ $serial++ }}</td> <!-- Increment the serial number for each row -->
                                        <td>{{ $draft->name }}</td>
                                        @if ($draft->status == 0)
                                                <td><span class="badge bg-danger">Disable</span></td>
                                            @else
                                                <td><span class="badge bg-success">Enable</span></td>
                                            @endif()
                                        <td class="project-actions">
                                            <a class="btn btn-info btn-sm" href="{{ route('drafts.edit', ['id' => $draft->id]) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                                Edit
                                            </a>


                                            @if ($draft->status == 0)
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('drafts.enable', ['id' => $draft->id]) }}"
                                                onclick="Enableconfirmation(event)">
                                                <i class="fas fa-eye"></i>
                                                Enable
                                            </a>
                                        @else
                                        {{-- <i class="fa-solid fa-eye-slash"></i> --}}
                                            <a class="btn btn-danger btn-sm"
                                                href="{{ route('drafts.disable', ['id' => $draft->id]) }}"
                                                onclick="Disableconfirmation(event)">
                                                <i class="fas fa-eye-slash"></i>
                                                Disable
                                            </a>
                                        @endif()



                                            
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

