@extends('layouts.main')
@section('main-section')
    <section class="content">
        <div class="container-fluid">
            <!-- Alert Messages -->
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
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $heading }}</h3>
                        </div>
                        <form action="{{ $actionurl }}" method="post">
                            @csrf
                            <!-- If SubCourt exists, include its ID -->
                            @isset($SubCourt)
                                <input type="hidden" name="id" value="{{ $SubCourt->id }}">
                            @endisset
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="">Select Court</label>
                                    <div class="form-group">
                                        <select class="form-control" name="court_id">
                                            <Option value="">Select Court</Option>
                                            @foreach ($courts as $court)
                                                <option value="{{ $court->id }}"
                                                    {{ isset($SubCourt) && $SubCourt->court_id == $court->id ? 'selected' : '' }}>
                                                    {{ $court->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('court_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Sub Court Name</label>
                                    <input type="text" class="form-control" placeholder="Enter sub Court Name"
                                        name="name" value="{{ isset($SubCourt) ? $SubCourt->name : old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ $btntext }}</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
