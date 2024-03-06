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
                    <h2>Edit Category</h2>
                </div>
                <div class="card-body">
                    <form Action="{{ route('category.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <label for="">Category Name</label>
                            <input type="hidden" class="form form-control" name="category_id" value=" {{ $category_info->id}} ">

                            <input type="text" class="form form-control" name="category_name" value=" {{ $category_info->category_name}} ">
                        </div>
                            @error('category_name')
                                <strong class="text text-danger"> {{ $message}} </strong>
                            @enderror
                        <div class="mb-2">
                            <label for="">Category Image</label>
                            <input type="file" class="form form-control" name="category_image"
                            onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">

                            <img id='blah' width='100'src=" {{asset('uploads/category')}}/{{$category_info->category_image}} " alt="">
                        </div>
                        @error('category_image')
                        <strong class="text text-danger"> {{ $message}} </strong>
                        @enderror
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