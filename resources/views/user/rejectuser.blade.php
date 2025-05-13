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
              <h3 class="card-title">Reject User</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr class="text-center">
                  <th>User Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Current Status</th>
                  <th>Reason</th>
                  <th>Change Status</th>
                  <td>Action</td>
                </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="text-center">
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email}}</td>
                        <td>{{ $user->mobile }}</td>
                        <td><span class="badge bg-danger">Reject</span></td>
                        <td>{{ $user->reason }}</td>
                        <td style="width: 12% !important;">
                            <form action="{{ route('PendingUserUpdate') }}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <div class="form-group">
                                    <select class="form-control statusSelect" name="status">
                                        <option value="0" {{ isset($user) && $user->council_verified == 0 ? 'selected' : '' }}>Pending</option>
                                        <option value="1" {{ isset($user) && $user->council_verified == 1 ? 'selected' : '' }}>Approve</option>
                                        <option value="2" {{ isset($user) && $user->council_verified == 2 ? 'selected' : '' }}>Reject</option>
                                        <option value="3" {{ isset($user) && $user->council_verified == 3 ? 'selected' : '' }}>Blocked</option>

                                    </select>
                                </div>
                                <div class="form-group status_result" style="display: none;">
                                    <input type="text" class="form-control reasonInput"
                                        name="reason" placeholder="Reason" required>
                                </div>
                        </td>
                        <td class="project-actions">
                            <a class="btn btn-primary btn-sm" href="{{ route('profile', ['id' => $user->id]) }}">
                                <i class="fas fa-folder"></i> View
                            </a>
                               {{-- <a class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-trash"></i> Delete
                                    </a> --}}
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-save"></i> Save
                            </button>
                            <a class="btn btn-danger btn-sm" href="{{ route('deleteuser', ['id' => $user->id]) }}">
                                <i class="fas fa-trash"></i> delete
                            </a>
                        </td>
                    </tr>
                    </form>
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
