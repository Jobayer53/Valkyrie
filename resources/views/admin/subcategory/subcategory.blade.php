@extends('layouts.dashboard')
@section('content')
<div class="">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                {{-- alert --}}
                @if (session('dlt'))
                <div class="alert alert-danger"> {{session('dlt')}} </div>
                @endif
                {{-- alert --}}
                <div class="card-header">
                    <h2>SubCategory List</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Category</th>
                            <th> Subcategory</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($subcategories as $key=> $subcategory )
                            
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$subcategory->rel_to_category->category_name}}</td>
                            <td>{{$subcategory->subcategory_name}}</td>
                            <td><img width='50' src="{{asset('uploads/subcategory')}}/{{$subcategory->subcategory_image}}  " alt=""></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('subcategory.edit',$subcategory->id) }}">Edit</a>
                                        <a class="dropdown-item" href="{{ route('subcategory.delete',$subcategory->id) }}">Delete</a>
                                    </div>
                                </div>
                                {{-- <a href="{{ route('category.edit',$subcategory->id) }}" class="btn btn-primary">Edit </a>
                                <a href="{{ route('category.delete',$subcategory->id) }}" class="btn btn-danger">Delete </a> --}}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success"> {{session('success')}} </div>
                @endif
                <div class="card-header">
                    <h2>
                        Add SubCategory
                    </h2>
                </div>
                <div class="card-body">
                    <form Action="{{ route('subcategory.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <select name="category_id" class="form-control">
                                <option value="">-- Select --</option> 
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="">SubCategory Name</label>
                            <input type="text" class="form form-control" name="subcategory_name">
                        </div>
                            @error('subcategory_name')
                                <strong class="text text-danger"> {{ $message}} </strong>
                            @enderror
                        <div class="mb-2">
                            <label for="">SubCategory Image</label>
                            <input type="file" class="form form-control" name="subcategory_image">
                        </div>
                        @error('subcategory_image')
                        <strong class="text text-danger"> {{ $message}} </strong>
                        @enderror
                        <div class="pt-3">
                            <button type="submit" class="btn btn-primary">Add </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                @if (session('hard_dlt'))
                    <div class="alert alert-danger"> {{session('dlt')}} </div>
                @endif
                <div class="card-header">
                    <h2>Deleted Category List</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Category</th>
                            <th>Added By</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($trash_category as $key=> $category )
                            
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$category->category_name}}</td>
                            <td>
                                @if (App\Models\User::where('id', $category->added_by)->exists())
                                  {{$category->rel_to_user->name}}
                                @else
                                    Unknown
                                @endif
                            </td>
                            <td><img width='50' src="{{asset('uploads/category')}}/{{$category->category_image}}  " alt=""></td>
                            <td>{{$category->created_at->diffForHumans()}}</td>
                            <td>
                                <a href="{{ route('category.restore',$category->id) }}" class="btn btn-primary">Restore </a>
                                <a href="{{ route('category.hard.delete',$category->id) }}" class="btn btn-danger">Delete </a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection