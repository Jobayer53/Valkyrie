@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            {{-- alert --}}
            @if (session('dlt_inventory'))
            <div class="alert alert-danger">{{ session('dlt_inventory') }}</div>
            @endif
         {{-- alert --}}
            <div class="card-header">
                <h3>Inventory List</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL          </th>
                        <th>Product Name   </th>
                        <th>Color  </th>
                        <th>Size  </th>
                        <th>Quantity</th>
                        <th>Action </th>
                    </tr>
                    @foreach ($inventories as $key=>$inventory )
                        
                   
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $inventory->rel_to_product->product_name }}</td>
                        <td>{{ $inventory->rel_to_color->color_name }}</td>
                        <td>{{ $inventory->rel_to_size->size_name }}</td>
                        <td>{{ $inventory->quantity }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                </button>
                                <div class="dropdown-menu">
                                    
                                    <a class="dropdown-item" href="{{ route('inventory.delete', $inventory->id) }}">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>   
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            {{-- alert --}}
                @if (session('success_inventory'))
                <div class="alert alert-success">{{ session('success_inventory') }}</div>
                @endif
            {{-- alert --}}
            <div class="card-header">
                <h3>Add Inventory</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('inventory.store') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <input type="text" class="form-control" readonly value="{{ $product_info->product_name }}" >
                        <input type="hidden" class="form-control" name="product_id" value="{{ $product_info->id }}" >
                    </div>
                    <div class="mb-4">
                        <select name="color_id" class="form-control">
                            <option value="">--Select Color--</option>
                            @foreach ($colors as $color )
                            <option value="{{ $color->id }}">{{$color->color_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="size_id" class="form-control">
                            <option value="">--Select Size--</option>
                            @foreach ($sizes as $size )
                            <option value="{{ $size->id }}">{{$size->size_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                       <input type="number" class="form-control" name="quantity" placeholder="Quantity">
                      </div>
                    <div class="mb-3">
                      <button class="btn btn-primary" >Add Inventory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
@endsection