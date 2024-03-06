@extends('layouts.dashboard')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-5 m-auto">
            <div class="card">
                {{-- alert --}}
                @if (session('update'))
                <div class="alert alert-success"> {{session('update')}} </div>
                @endif
                {{-- alert --}}
                <div class="card-header">
                    <h2>Edit SubCategory</h2>
                </div>
                <div class="card-body">
                    <form Action="{{ route('subcategory.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <input type="hidden" name="id" value="{{ $subcategory_info->id }}">
                            <select name="category_id" class="form-control">
                                <option value="">-- Select --</option> 
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ ($category->id == $subcategory_info->category_id?'selected':'') }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="">SubCategory Name</label>
                            <input type="text" value="{{ $subcategory_info->subcategory_name }}" class="form form-control" name="subcategory_name">
                        </div>
                        <div class="mb-2">
                            <label for="">SubCategory Image</label>
                            <input onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" type="file" class="form form-control" name="subcategory_image">
                            <div class="mt-3">
                                <img width="100" src="{{ asset('uploads/subcategory/') }}/{{ $subcategory_info->subcategory_image }}"  id="blah">
                            </div>
                        </div>
                        <div class="pt-3">
                            <button type="submit" class="btn btn-primary">Update </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection