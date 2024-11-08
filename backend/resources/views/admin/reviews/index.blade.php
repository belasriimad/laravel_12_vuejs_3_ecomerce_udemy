@extends('admin.layouts.app')

@section('title')
    Reviews
@endsection

@section('content')
    <div class="row">
        @include('admin.layouts.sidebar')
        <div class="col-md-9">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card-header bg-white">
                        <h3 class="mt-2">
                            Reviews ({{ $reviews->count() }})
                        </h3>
                    </div>
                    <hr>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Body</th>
                                    <th>Rating</th>
                                    <th>Approved</th>
                                    <th>By</th>
                                    <th>Product</th>
                                    <th>Review Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $key => $review)
                                    <tr>
                                        <td>{{ $key += 1 }}</td>
                                        <td>
                                            {{ $review->title }}
                                        </td>
                                        <td>
                                            {{ $review->body }}
                                        </td>
                                        <td>{{ $review->rating }}</td>
                                        <td>
                                            @if ($review->approved)
                                                <span class="badge bg-success">
                                                    Yes
                                                </span>
                                            @else
                                               <span class="badge bg-danger">
                                                    No
                                                </span> 
                                            @endif
                                        </td>
                                        <td>{{ $review->user->name }}</td>
                                        <td>
                                            <img src="{{asset($review->product->thumbnail)}}" 
                                                alt="{{ $review->product->name }}" 
                                                class="rounded"
                                                width="60"
                                                height="60"    
                                            >
                                        </td>
                                        <td>{{ $review->created_at }}</td>
                                        <td class="d-flex">
                                            @if ($review->approved)
                                                <a href="{{route('admin.reviews.update',['review' => $review->id,'status' => 0])}}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-eye-slash"></i>
                                                </a>
                                            @else
                                                <a href="{{route('admin.reviews.update',['review' => $review->id,'status' => 1])}}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check-double"></i>
                                                </a> 
                                            @endif
                                            <a href="#" onclick="deleteItem({{$review->id}})" class="btn btn-sm btn-danger mx-1">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <form id="{{$review->id}}" action="{{route('admin.reviews.delete',$review->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection