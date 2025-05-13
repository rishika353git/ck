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
                            @isset($SubDraft)
                                <input type="hidden" name="id" value="{{ $SubDraft->id }}">
                            @endisset
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="">Select Draft</label>
                                    <div class="form-group">
                                        <select class="form-control" name="draft_id">
                                            @foreach ($drafts as $draft)
                                                <option value="{{ $draft->id }}"
                                                    {{ isset($SubDraft) && $SubDraft->court_id == $draft->id ? 'selected' : '' }}>
                                                    {{ $draft->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('court_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Sub Draft Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Sub Draft Name"
                                        name="name" value="{{ isset($SubDraft) ? $SubDraft->name : old('name') }}">
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
