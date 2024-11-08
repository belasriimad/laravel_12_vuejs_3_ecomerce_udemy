@extends('admin.layouts.app')

@section('title')
    Orders
@endsection

@section('content')
    <div class="row">
        @include('admin.layouts.sidebar')
        <div class="col-md-9">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card-header bg-white">
                        <h3 class="mt-2">
                            Orders ({{ $orders->count() }})
                        </h3>
                    </div>
                    <hr>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>By</th>
                                    <th>Coupon</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Order Date</th>
                                    <th>Delivered at</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>{{ $key += 1 }}</td>
                                        <td>
                                            <span class="d-flex flex-column">
                                                @foreach ($order->products as $product)
                                                    {{ $product->name }}
                                                @endforeach
                                            </span>
                                        </td>
                                        <td>
                                            <span class="d-flex flex-column">
                                                @foreach ($order->products as $product)
                                                    ${{ $product->price }}
                                                @endforeach
                                            </span>
                                        </td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>
                                            @if ($order->coupon()->exists())
                                                <span class="badge bg-success">
                                                    {{ $order->coupon->name }}
                                                </span>
                                            @else
                                               <span class="badge bg-danger">
                                                    N/A
                                                </span> 
                                            @endif
                                        </td>
                                        <td>{{ $order->qty }}</td>
                                        <td>${{ $order->total }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            @if ($order->delivered_at)
                                                <span class="badge bg-success">
                                                    {{ $order->delivered_at }}
                                                </span>
                                            @else 
                                                <a href="{{route('admin.orders.update',$order->id)}}">
                                                    <i class="fas fa-pencil"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" onclick="deleteItem({{$order->id}})" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <form id="{{$order->id}}" action="{{route('admin.orders.delete',$order->id)}}" method="post">
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