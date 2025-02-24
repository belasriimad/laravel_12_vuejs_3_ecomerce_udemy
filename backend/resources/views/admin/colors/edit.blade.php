@extends('admin.layouts.app')

@section('title')
    Edit color
@endsection

@section('content')
    <div class="row">
        @include('admin.layouts.sidebar')
        <div class="col-md-9">
            <div class="card-header bg-white">
                <h3 class="mt-2">
                    Edit color
                </h3>
            </div>
            <hr>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <form action="{{route('admin.colors.update',$color->id)}}" method="post">
                            @csrf
                            @method("PUT")
                            <div class="mb-3">
                                <label for="name" class="form-label">Name*</label>
                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name"
                                    id="name"
                                    value="{{old('name',$color->name)}}"
                                    aria-describedby="helpId"
                                    placeholder="Name*"
                                />
                                @error('name')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button
                                type="submit"
                                class="btn btn-sm btn-dark"
                            >
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
