@extends('layouts.dashboard')

@section('content')
    <div class="card">
        {{-- alert --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        {{-- alert --}}
        <div class="card-header">
            <h2>Add Product</h2>
        </div>
        <div class="card-body ">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <select name="category_id" id="category_id" class=" form-control" >
                                <option value="">-- SELECT CATEGORY --</option>
                                @foreach ($categories as $category )
                                <option value="{{$category->id}}"> {{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- end here --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <select name="subcategory_id" id="subcategory_id"class=" form-control" >
                                <option value="">-- SELECT SUBCATEGORY --</option>
                            </select>
                        </div>
                    </div>
                    {{-- end here --}}
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="text" name="product_name" placeholder="Pruduct Name" class="form-control">
                        </div>
                    </div>
                    {{-- end here --}}
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="text" name="brand" placeholder="Pruduct Brand" class="form-control">
                        </div>
                    </div>
                    {{-- end here --}}
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="number" name="price" placeholder="Pruduct Price" class="form-control">
                        </div>
                    </div>
                    {{-- end here --}}
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input type="number" name="discount" placeholder="Discoutn-%" class="form-control">
                        </div>
                    </div>
                    {{-- end here --}}
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input type="text" name="short_desp" placeholder="Shor Description" class="form-control">
                        </div>
                    </div>
                    {{-- end here --}}
                    <div class="col-lg-12">
                        <div class="form-group">
                           <textarea  id="summernote" name="long_desp" class="form-control" ></textarea>
                        </div>
                    </div>
                    {{-- end here --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                           <label for=""> Product Preview</label>
                           <input type="file" name="product_preview" class="form-control">
                        </div>
                    </div>
                    {{-- end here --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                           <label for=""> Product Thumbnail</label>
                           <input type="file" name="product_thumbnail[]" multiple class="form-control">
                        </div>
                    </div>
                    {{-- end here --}}
                    <div class="col-lg-12">
                        <div class="form-group text-center mt-4">
                           <button type="submit" class="btn btn-primary" >Add Pruduct</button>
                        </div>
                    </div>
                    {{-- end here --}}


                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_script')
    <script>
        $('#category_id').change(function(){
            var category_id = $(this).val();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:'/getsubcategory',
                type:'POST',
                data:{'category_id': category_id},
                
                success:function(data){
                    $('#subcategory_id').html(data);                    
                }
            
            });
        
        });
    </script>
    <script>
          $('#summernote').summernote();
    </script>
@endsection