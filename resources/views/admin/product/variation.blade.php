@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                 {{-- alert --}}
                 @if (session('dlt_color'))
                 <div class="alert alert-danger">{{ session('dlt_color') }}</div>
                 @endif
              {{-- alert --}}
                <div class="card-header">
                    <h3>Color List</h3>
                </div>
                <div class="card-body">
                    <table id="style" class="table">
                        <tr class="t_row">
                            <th>SL</th>
                            <th>COLOR NAME</th>
                            <th>COLOR</th>
                            <th>ACTION</th>
                        </tr >
                        @foreach ($colors as $key => $color )  
                        <tr class="t_row">
                            <td>{{ $key+1 }}</td>
                            <td>{{ $color->color_name }}</td>
                            <td><span class="badge badge-pill py-2" style="background-color: #{{ $color->color_code }}">Color</span></td>
                            <td>
                                <a href="{{ route('color.delete', $color->id) }}" class="btn btn-danger">Delete</a>
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
                 @if (session('success_color'))
                 <div class="alert alert-success">{{ session('success_color') }}</div>
                 @endif
              {{-- alert --}}
                 
                <div class="card-header">
                    <h3>Add Color</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('variation.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Color Name</label>
                            <input type="text" class="form-control" name="color_name" >
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Color Code</label>
                            <input type="text" class="form-control" name="color_code" >
                        </div>
                        <div class="mb-3">
                          <button class="btn btn-primary" name="btn" value="1">Add Color</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                {{-- alert --}}
                @if (session('dlt_size'))
                <div class="alert alert-danger">{{ session('dlt_size') }}</div>
                @endif
             {{-- alert --}}
                <div class="card-header">
                    <h3>Size List</h3>
                </div>
                <div class="card-body">
                    <table  class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Size</th>
                            <th>ACTION</th>
                        </tr >
                        @foreach ($sizes as $key => $size )  
                        <tr >
                            <td>{{ $key+1 }}</td>
                            <td>{{ $size->size_name }}</td>
                            <td>
                                <a href="{{ route('size.delete', $size->id) }}" class="btn btn-danger">Delete</a>
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
                @if (session('success_size'))
                <div class="alert alert-success">{{ session('success_size') }}</div>
                @endif
                 {{-- alert --}}
                <div class="card-header">
                    <h3>Add Size</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('variation.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Size Name</label>
                            <input type="text" class="form-control" name="size_name" >
                        </div>
                        <div class="mb-3">
                          <button class="btn btn-primary" name="btn2" value="2">Add Size</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection