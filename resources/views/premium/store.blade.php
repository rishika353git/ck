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
                            <!-- If $Court exists, include its ID -->
                            @isset($plans)
                                <input type="hidden" name="id" value="{{ $plans->id }}">
                            @endisset

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Plans Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Plans Name" name="name"
                                        value="{{ isset($plans) ? $plans->name : old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Monthly Amount</label>
                                            <input type="text" class="form-control" placeholder="Enter Monthly Amount"
                                                name="monthly_amount"
                                                value="{{ isset($plans) ? $plans->monthly_amount : old('name') }}">
                                            @error('monthly_amount')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Yearly Amount</label>
                                            <input type="text" class="form-control" placeholder="Enter Yearly Amount"
                                                name="yearly_amount"
                                                value="{{ isset($plans) ? $plans->yearly_amount : old('name') }}">
                                            @error('yearly_amount')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="post">Post</label>
                                            <input type="text" class="form-control" placeholder="Enter Post" name="post" value="{{ isset($plans) ? $plans->posts : old('post') }}">
                                            @error('post')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="blue_tick">Blue Tick</label>
                                            <select class="form-control" name="blue_tick">
                                                <option value="">Select Option</option>
                                                <option value="1" {{ isset($plans) && $plans->blue_tick == 1 ? 'selected' : '' }}>Yes</option>
                                                <option value="0" {{ isset($plans) && $plans->blue_tick == 0 ? 'selected' : '' }}>No</option>
                                            </select>
                                            @error('blue_tick')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
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
